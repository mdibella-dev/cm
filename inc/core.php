<?php
/**
 * Zentrale Funktionen des Themes
 *
 * @since   1.0.0
 * @author  Marco Di Bella <mdb@marcodibella.de>
 * @package congressomat
 */


defined( 'ABSPATH' ) OR exit;



/**
 * Liefert ein Array mit Sessions
 *
 * @since   1.0.0
 *
 * @param   array   $args
 * @return  array
 **/

function cm_get_sessions( $args )
{
    /* Ermittelung der übergebenen Parameter */

    $default_args = array(
        'event'          => '',
        'event_filter'   => 'ACTIVE',
        'speaker'        => '',
        'posts_per_page' => -1,
        'date'           => '',
    );

    extract( wp_parse_args( $args, $default_args ) );


    /* Konstruktion der Datenabfrage */

    $query = array(
        'posts_per_page' => $posts_per_page,
        'post_status'    => 'publish',
        'post_type'      => 'session',
    );


    /*
     * Behandlung von event/event_filter
     *
     * Fügt entweder die Suche nach den Sessions eines bestimmenten Events hinzu (Variante 1)
     * bzw. eine Filterung nach aktiven oder inaktiven Sessions (Variante 2) hinzu.
     */

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

            $query[ 'tax_query' ] = array( array(
                'taxonomy' => 'event',
                'field'    => 'term_id',
                'terms'    => $event_list,
                'operator' => 'NOT IN',
            ) );

        elseif( 'ACTIVE' === $event_filter ) :

            $query[ 'tax_query' ] = array( array(
                'taxonomy' => 'event',
                'field'    => 'term_id',
                'terms'    => $event_list,
                'operator' => 'IN',
            ) );

        endif;

    endif;


    /*
     * Behandlung von speaker/date
     *
     * Fügt die Suche nach den Sessions eines bestimmten Speakers
     * und/oder die Suche nach den Session, die an einem bestimmten Datum stattfinden, hinzu.
     */

    if( !empty( $speaker ) or !empty( $date ) ) :
        $query[ 'meta_query' ] = array();

        if( !empty( $speaker ) and is_numeric( $speaker ) ) :

            $query[ 'meta_query' ][] = array(
                'key'     => 'programmpunkt-referenten',
                'value'   => $speaker,
                'compare' => 'LIKE',
            );

        endif;

        if( !empty( $date ) ) :

            /** @see: https://www.php.net/manual/de/function.strtotime.php#122937 **/
            $date = str_replace( '.', '-', $date );

            if( ( $timestamp = strtotime( $date) ) !== false ) :
                $query[ 'meta_query' ][] = array(
                    'key'   => 'programmpunkt-datum',
                    'value' => date( 'Ymd', $timestamp ),
                );
            endif;

        endif;

    endif;


    /* Durchführung der Datenabfrage und Rückgabe des sortierten Ergebnisses */

    $sessions = get_posts( $query );
    return cm_sort_sessions_by_timestamp( $sessions );
}



/**
 * Liefert die zu einem bestimmten Event gehörenden Sessions
 *
 * @since   1.0.0
 *
 * @param   int     $event
 * @return  array
 **/

function cm_get_sessions_by_event( $event, $date = '' )
{
    return cm_get_sessions( array(
        'event' => $event,
        'date'  => $date,
    ) );
}



/**
 * Liefert die zu einem bestimmten Speaker gehörenden Sessions
 * Dabei kann nach aktiven, inaktiven oder allen Sessions gefiltert werden
 *
 * @since   1.0.0
 *
 * @param   int     $speaker
 * @param   string  $event_filter
 * @return  array
 **/

function cm_get_sessions_by_speaker( $speaker, $event_filter = 'ACTIVE' )
{
    return cm_get_sessions( array(
        'speaker'      => $speaker,
        'event_filter' => $event_filter,
    ) );
}



/**
 * Sortiert ein Array mit Sessions aufsteigend nach Zeitstempel
 *
 * @since   1.0.0
 *
 * @param   array   $sessions
 * @return  array
 */

function cm_sort_sessions_by_timestamp( $sessions )
{
    if( is_array( $sessions ) == true ) :
        $unable_to_sort = false;
        $sort           = array();

        /* Bildung eines sortierfähigen Arrays */

        foreach( $sessions as $session ) :

            /* Erzeugung der notwendigen Zeitstempel ('von', bis') */

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


            /*
             * Hinzufügung der Session zum Sortier-Array sofern 'von'-Zeitstempel (1. Priorität)
             * oder 'bis'-Zeitstempel (2. Priorität) vorhanden sind.
             * Andernfalls Abbruch, da eine Sortierung nicht möglich ist.
             */

            if( false !== $timestamp_from ) :
                $sort[ $timestamp_from ] = $session;
            elseif ( false !== $timestamp_to ) :
                $sort[ $timestamp_to ] = $session;
            else :
                $unable_to_sort = true;
                break;
            endif;

        endforeach;


        /* Durchführung der Sortierung (wenn möglich) */

        if( false === $unable_to_sort ) :
            ksort( $sort );
            $sessions = array_values( $sort );
        endif;

    endif;

    return $sessions;
}



/**
 * Ermittelt die derzeit aktiven Events
 *
 * @since  1.0.0
 *
 * @return array
 */

function cm_get_active_events()
{
    $events = array();
    $terms  = get_terms( array(
        'taxonomy'   => 'event',
        'hide_empty' => 'false', // true?
        'meta_key'   => 'event-status',
    	'meta_value' => '1',
    ) );

    if( $terms === false ) :
        return null;
    endif;

    foreach( $terms as $term ) :
        $events[] = $term->term_taxonomy_id;
    endforeach;

    return $events;
}



/**
 * Ermittelt die Speaker aus allen Sessions von einem oder mehreren Events
 *
 * @since  1.0.0
 *
 * @param  string  $event_list_string  eine kommaseparierte Liste mit Events (IDs)
 * @return array
 */

function cm_get_speaker_datasets( $event_list_string = '' )
{
    /*
     * Konstruktion und Durchführung der Datenabfrage
     *
     * Sollten keine Events angegeben worden sein (d.h. $event_list_string ist leer),
     * werden die aktiven Events zur Grundlage genommen
     */

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

    if( !empty( $event_list_string ) ) :
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


    /* Ermittelung der betroffenen Speaker */

    if( $sessions ) :
        $finds_list   = array();
        $speaker_list = array();

        foreach( $sessions as $session ) :
            $speakers = get_field( 'programmpunkt-referenten', $session->ID );

            if( $speakers != NULL ) :

                foreach( $speakers as $speaker ) :

                    /* Nicht hinzufügen, wenn bereits in der Liste */

                    if( false == in_array( $speaker, $finds_list ) ) :
                        $finds_list[]   = $speaker;
                        $speaker_list[] = cm_get_speaker_dataset( $speaker );
                    endif;

                endforeach;

            endif;

        endforeach;


        /* Sortierung der gefundenen Speaker nach Vor- und Nachnamen */

        return cm_sort_speaker_datasets( $speaker_list );
    endif;

    return NULL;
}



/**
 * Liefert den Datensatz eines bestimmten Speakers
 *
 * @since  1.0.0
 *
 * @param  int    $speaker
 * @return array
 */

function cm_get_speaker_dataset( $speaker )
{
    $speaker_post = get_post( $speaker );

    $data[ 'id' ]          = $speaker;
    $data[ 'firstname' ]   = get_field( 'referent-vorname', $speaker_post );
    $data[ 'lastname' ]    = get_field( 'referent-nachname', $speaker_post );
    $data[ 'name' ]        = trim( sprintf( '%1$s %2$s', $data[ 'firstname' ], $data[ 'lastname' ] ) );
    $data[ 'title_name' ]  = trim( sprintf( '%1$s %2$s', get_field( 'referent-titel', $speaker_post ), $data[ 'name' ] ) );
    $data[ 'position' ]    = get_field( 'referent-position', $speaker_post );
    $data[ 'description' ] = get_field( 'referent-beschreibung', $speaker_post );
    $data[ 'permalink' ]   = get_post_permalink( $speaker_post );

    return $data;
}



/**
 * Sortiert eine Liste von Speaker-Datensätzen nach Vor- und Nachnamen
 *
 * @since  1.0.0
 *
 * @param  array  $speaker_list Die unsortierte Liste
 * @return array                Die sortierte List
 */

function cm_sort_speaker_datasets( $speaker_list )
{
    foreach( $speaker_list as $key => $row ) :
        $forename[ $key ] = $row[ 'forename' ];
        $lastname[ $key ] = $row[ 'lastname' ];
    endforeach;

    array_multisort( $lastname, SORT_ASC, SORT_STRING, $forename, SORT_ASC, SORT_STRING, $speaker_list );

    return $speaker_list;
}



/**
 * Ermittelt den Namen einer Location
 *
 * @since  1.0.0
 *
 * @param  int      $location
 * @return string
 */

function cm_get_location( $location )
{
    if( !empty( $location ) ) :
        $term = get_term_by( 'term_taxonomy_id', $location, 'location' );

        if( $term !== false ) :
            return $term->name;
        endif;

    endif;

    return NULL;
}



/**
 * Ermittelt den Namen eines Events
 *
 * @since  1.0.0
 *
 * @param  int      $event
 * @return string
 */

function cm_get_event( $event )
{
    if( !empty( $event ) ) :
        $term = get_term_by( 'term_taxonomy_id', $event, 'event' );

        if( $term !== false ) :
            return $term->name;
        endif;
    endif;

    return NULL;
}



/**
 * Liefert den Datensatz eines bestimmten Partners
 *
 * @since  2.3.0
 *
 * @param  int    $partner_id
 * @return array
 */

function cm_get_partner_dataset( $partner )
{
    $partner_post = get_post( $partner );

    $data[ 'id' ]               = $partner;
    $data[ 'permalink' ]        = get_post_permalink( $partner_post );
    $data[ 'title' ]            = get_the_title( $partner_post );
    $data[ 'address' ]          = get_field( 'partner-anschrift', $partner_post );
    $data[ 'phone' ]            = get_field( 'partner-telefon', $partner_post );
    $data[ 'fax' ]              = get_field( 'partner-telefax', $partner_post );
    $data[ 'mail' ]             = get_field( 'partner-mail', $partner_post );
    $data[ 'website' ]          = get_field( 'partner-webseite', $partner_post );
    $data[ 'description' ]      = get_field( 'partner-beschreibung', $partner_post );
    $data[ 'exhibition-spaces'] = array();

    while( have_rows( 'partner-exhibition-spaces', $partner_post ) ) :
        the_row();

        $space          = get_sub_field( 'partner-exhibition-space', $partner_post );
        $space_post     = get_post( $space );
        $space_location = get_term( get_field( 'exhibition-space-location', $space_post ),'location' );
        $space_package  = get_term( get_field( 'exhibition-space-package', $space_post ), 'exhibition_package' );

        $data[ 'exhibition-spaces'][] = array(
            'signature' => get_the_title( $space_post ),
            'location'  => $space_location->name,
            'package'   => $space_package->name,
        );
    endwhile;

    return $data;
}
