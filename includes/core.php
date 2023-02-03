<?php
/**
 * CM core API.
 *
 * @author  Marco Di Bella
 * @package cm
 */


/** Prevent direct access */

defined( 'ABSPATH' ) or exit;



/**
 * Returns an array with sessions
 *
 * @since 1.0.0
 *
 * @param array $args
 *
 * @return array
 */

function cm_get_sessions( $args )
{
    // Determination of the passed parameters
    $default_args = array(
        'event'          => '',
        'event_filter'   => 'ACTIVE',
        'speaker'        => '',
        'posts_per_page' => -1,
        'date'           => '',
    );
    extract( wp_parse_args( $args, $default_args ) );


    // Data query construction
    $query = array(
        'posts_per_page' => $posts_per_page,
        'post_status'    => 'publish',
        'post_type'      => 'session',
    );


    // Handling event/event_filter
    // Adds either the search for the sessions of a specific event (variant 1)
    // or filtering by active or inactive sessions (variant 2).
    if( null !== cm_get_event( $event ) ) :

        $query[ 'tax_query' ] = array( array(
            'taxonomy' => 'event',
            'field'    => 'term_id',
            'terms'    => $event,
        ) );
    else :
        $event_list   = cm_get_active_events();
        $event_filter = strtoupper( trim( $event_filter ) );

        if( 'INACTIVE' === $event_filter ) :

            $query['tax_query'] = array( array(
                'taxonomy' => 'event',
                'field'    => 'term_id',
                'terms'    => $event_list,
                'operator' => 'NOT IN',
            ) );
        elseif( 'ACTIVE' === $event_filter ) :

            $query['tax_query'] = array( array(
                'taxonomy' => 'event',
                'field'    => 'term_id',
                'terms'    => $event_list,
                'operator' => 'IN',
            ) );
        endif;

    endif;


    // Handling of speaker/date
    // Adds the search for the sessions of a specific speaker and/or the search for the session taking place on a specific date.
    if( ! empty( $speaker ) or ! empty( $date ) ) :
        $query['meta_query'] = array();

        if( ! empty( $speaker ) and is_numeric( $speaker ) ) :

            $query['meta_query'][] = array(
                'key'     => 'programmpunkt-referenten',
                'value'   => $speaker,
                'compare' => 'LIKE',
            );

        endif;

        if( ! empty( $date ) ) :

            // @see: https://www.php.net/manual/de/function.strtotime.php#122937/
            $date = str_replace( '.', '-', $date );

            if( false !== ( $timestamp = strtotime( $date) ) ) :
                $query['meta_query'][] = array(
                    'key'   => 'programmpunkt-datum',
                    'value' => date( 'Ymd', $timestamp ),
                );
            endif;

        endif;

    endif;


    // Execution of the data query and return of the sorted result
    $sessions = get_posts( $query );
    return cm_sort_sessions_by_timestamp( $sessions );
}



/**
 * Returns the sessions belonging to a specific event.
 *
 * @since  1.0.0
 * @param  int    $event
 * @return array
 */

function cm_get_sessions_by_event( $event, $date = '' )
{
    return cm_get_sessions( array(
        'event' => $event,
        'date'  => $date,
    ) );
}



/**
 * Delivers the sessions belonging to a specific speaker.
 * It can be filtered by active, inactive or all sessions.
 *
 * @since  1.0.0
 * @param  int    $speaker
 * @param  string $event_filter
 * @return array
 */

function cm_get_sessions_by_speaker( $speaker, $event_filter = 'ACTIVE' )
{
    return cm_get_sessions( array(
        'speaker'      => $speaker,
        'event_filter' => $event_filter,
    ) );
}



/**
 * Sorts an array of sessions in ascending order by timestamp.
 *
 * @since  1.0.0
 * @param  array $sessions
 * @return array
 */

function cm_sort_sessions_by_timestamp( $sessions )
{
    if( true == is_array( $sessions ) ) :
        $unable_to_sort = false;
        $sort           = array();

        // Creation of a sortable array
        foreach( $sessions as $session ) :

            // Generation of the necessary time stamps ('from', to')
            $timestamp_from = strtotime(
                get_field( 'programmpunkt-datum', $session->ID )
                . ' ' .
                get_field( 'programmpunkt-von', $session->ID )
            );

            $timestamp_to = strtotime(
                get_field( 'programmpunkt-datum', $session->ID )
                . ' ' .
                get_field( 'programmpunkt-bis', $session->ID )
            );


            // Add the session to the sort array if 'from' timestamps (1st priority) or 'to' timestamps (2nd priority) are present.
            // Otherwise abort, because sorting is not possible.
            if( false !== $timestamp_from ) :
                $sort[ $timestamp_from ] = $session;
            elseif ( false !== $timestamp_to ) :
                $sort[ $timestamp_to ] = $session;
            else :
                $unable_to_sort = true;
                break;
            endif;

        endforeach;


        // Implementation of the sorting (if possible)
        if( false === $unable_to_sort ) :
            ksort( $sort );
            $sessions = array_values( $sort );
        endif;

    endif;

    return $sessions;
}



/**
 * Determines the currently active events.
 *
 * @since  1.0.0
 * @return array
 */

function cm_get_active_events()
{
    $events = array();
    $terms  = get_terms( array(
        'taxonomy'   => 'event',
        'hide_empty' => 'false',
        'meta_key'   => 'event-status',
        'meta_value' => '1',
    ) );

    if( false === $terms ) :
        return null;
    endif;

    foreach( $terms as $term ) :
        $events[] = $term->term_taxonomy_id;
    endforeach;

    return $events;
}



/**
 * Determines the speakers from all sessions from one or more events.
 * @since  1.0.0
 * @param  string $event_list_string    A comma-separated list of events (IDs)
 * @return array
 */

function cm_get_speaker_datasets( $event_list_string = '' )
{
    // Construction and implementation of the data query.
    // If no events have been specified (i.e. $event_list_string is empty), the active events will be used as a basis.
    $query = array(
        'posts_per_page' => -1,
        'post_status'    => 'publish',
        'post_type'      => 'session',
        'meta_query'     => array( array(
            'key'     => 'programmpunkt-referenten',
            'compare' => 'EXISTS',
        ) ),
        'tax_query'      => array( 'relation' => 'OR' )
    );

    if( ! empty( $event_list_string ) ) :
        $event_list = explode( ',', str_replace(" ", "", $event_list_string ) );
    else :
        $event_list = cm_get_active_events();
    endif;

    foreach( $event_list as $event ) :
        $query[ 'tax_query' ][] = array(
            'taxonomy' => 'event',
            'field'    => 'term_id',
            'terms'    => $event,
        );
    endforeach;

    $sessions = get_posts( $query );


    // Identification of the affected speakers.
    if( $sessions ) :
        $finds_list   = array();
        $speaker_list = array();

        foreach( $sessions as $session ) :
            $speakers = get_field( 'programmpunkt-referenten', $session->ID );

            if( null != $speakers ) :
                foreach( $speakers as $speaker ) :
                    // Do not add if already in the list.
                    if( false == in_array( $speaker, $finds_list ) ) :
                        $finds_list[]   = $speaker;
                        $speaker_list[] = cm_get_speaker_dataset( $speaker );
                    endif;
                endforeach;
            endif;
        endforeach;


        // Sorting the found speakers by first and last name.
        return cm_sort_speaker_datasets( $speaker_list );
    endif;

    return null;
}



/**
 * Returns the dataset of a specific speaker.
 *
 * @since  1.0.0
 *
 * @param  int   $speaker
 * @return array
 */

function cm_get_speaker_dataset( $speaker )
{
    $speaker_post = get_post( $speaker );

    $data['id']          = $speaker;
    $data['firstname']   = get_field( 'referent-vorname', $speaker_post );
    $data['lastname']    = get_field( 'referent-nachname', $speaker_post );
    $data['name']        = trim( sprintf( '%1$s %2$s', $data[ 'firstname' ], $data[ 'lastname' ] ) );
    $data['title_name']  = trim( sprintf( '%1$s %2$s', get_field( 'referent-titel', $speaker_post ), $data[ 'name' ] ) );
    $data['position']    = get_field( 'referent-position', $speaker_post );
    $data['description'] = get_field( 'referent-beschreibung', $speaker_post );
    $data['permalink']   = get_post_permalink( $speaker_post );

    return $data;
}



/**
 * Sorts a list of speaker datasets by first and last name.
 *
 * @since  1.0.0
 *
 * @param  array  $speaker_list    Die unsortierte Liste
 * @return array                   Die sortierte List
 */

function cm_sort_speaker_datasets( $speaker_list )
{
    foreach( $speaker_list as $key => $row ) :
        $forename[ $key ] = $row['forename'];
        $lastname[ $key ] = $row['lastname'];
    endforeach;

    array_multisort( $lastname, SORT_ASC, SORT_STRING, $forename, SORT_ASC, SORT_STRING, $speaker_list );

    return $speaker_list;
}



/**
 * Determines the name of a location.
 *
 * @since  1.0.0
 *
 * @param  int    $location
 * @return string
 */

function cm_get_location( $location )
{
    if( ! empty( $location ) ) :
        $term = get_term_by( 'term_taxonomy_id', $location, 'location' );

        if( false != $term ) :
            return $term->name;
        endif;

    endif;

    return null;
}



/**
 * Determines the name of an event.
 *
 * @since  1.0.0
 *
 * @param  int      $event
 * @return string
 */

function cm_get_event( $event )
{
    if( ! empty( $event ) ) :
        $term = get_term_by( 'term_taxonomy_id', $event, 'event' );

        if( false != $term ) :
            return $term->name;
        endif;
    endif;

    return null;
}



/**
 * Returns the record of a specific partner.
 *
 * @since  2.3.0
 *
 * @param  int    $partner_id
 * @return array
 */

function cm_get_partner_dataset( $partner )
{
    $partner_post = get_post( $partner );

    $data['id']                = $partner;
    $data['permalink']         = get_post_permalink( $partner_post );
    $data['title']             = get_the_title( $partner_post );
    $data['address']           = get_field( 'partner-anschrift', $partner_post );
    $data['phone']             = get_field( 'partner-telefon', $partner_post );
    $data['fax']               = get_field( 'partner-telefax', $partner_post );
    $data['mail']              = get_field( 'partner-mail', $partner_post );
    $data['website']           = get_field( 'partner-webseite', $partner_post );
    $data['description']       = get_field( 'partner-beschreibung', $partner_post );
    $data['exhibition-spaces'] = array();

    while( have_rows( 'partner-exhibition-spaces', $partner_post ) ) :
        the_row();

        $space          = get_sub_field( 'partner-exhibition-space', $partner_post );
        $space_post     = get_post( $space );
        $space_location = get_term( get_field( 'exhibition-space-location', $space_post ),'location' );
        $space_package  = get_term( get_field( 'exhibition-space-package', $space_post ), 'exhibition_package' );

        $data['exhibition-spaces'][] = array(
            'signature' => get_the_title( $space_post ),
            'location'  => $space_location->name,
            'package'   => $space_package->name,
            'id'        => $space_post->ID,
        );
    endwhile;

    return $data;
}
