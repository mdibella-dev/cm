<?php
/**
 * Zentrale Funktionen des Themes
 *
 * @author  Marco Di Bella <mdb@marcodibella.de>
 * @package mdb-congressomat
 **/



/**
 * Liefert ein Array mit Sessions
 *
 * @uses    mdb_get_active_events, mdb_sort_sessions_by_timestamp
 * @param   array   $args
 * @return  array
 * @since   1.0.0
 **/

function mdb_get_sessions( $args )
{
    // Übergebene Parameter auslesen
    extract( wp_parse_args( $args,
                            array(
                            'event'          => '',
                            'event_filter'   => 'ACTIVE',
                            'speaker'        => '',
                            'posts_per_page' => -1 ) ) );

    // Allgemeine Suchparameter setzen
    $query = array(
             'posts_per_page' => $posts_per_page,
             'post_status'    => 'publish',
             'post_type'      => 'session' );


    // Event setzen
    if( mdb_get_event( $event ) !== NULL ) :
        $query[ 'tax_query' ] = array( array(
                                       'taxonomy' => 'event',
                                       'field'    => 'term_id',
                                       'terms'    => $event ) );
    else :
        $event_list   = mdb_get_active_events();
        $event_filter = strtoupper( trim( $event_filter ) );

        switch( $event_filter ) :
            case 'INACTIVE' :
                $query[ 'tax_query' ] = array( array(
                                               'taxonomy' => 'event',
                                               'field'    => 'term_id',
                                               'terms'    => $event_list,
                                               'operator' => 'NOT IN' ) );
            break;

            case 'ACTIVE' :
            default:
                $query[ 'tax_query' ] = array( array(
                                               'taxonomy' => 'event',
                                               'field'    => 'term_id',
                                               'terms'    => $event_list,
                                               'operator' => 'IN' ) );
            break;
        endswitch;
    endif;

    // Speaker setzen
    if ( !empty( $speaker ) and is_numeric( $speaker ) ) :
        $query[ 'meta_query' ] = array( array(
                                        'key'     => 'programmpunkt-referenten',
                                        'value'   => $speaker,
                                        'compare' => 'LIKE',
                                     ) );
    endif;

    // Passende Sessions ermitteln
    $sessions = get_posts( $query );

    // Sortieren und zurückgeben
    return mdb_sort_sessions_by_timestamp( $sessions );
}



/**
 * Liefert die zu einem bestimmten Event gehörenden Sessions
 *
 * @uses    mdb_get_sessions
 * @param   int     $event
 * @return  array
 * @since   1.0.0
 **/

function mdb_get_sessions_by_event( $event )
{
    return mdb_get_sessions( array(
                             'event' => $event ) );
}



/**
 * Liefert die zu einem bestimmten Speaker gehörenden Sessions
 * Dabei kann nach aktiven, inaktiven oder allen Sessions gefiltert werden.
 *
 * @uses    mdb_get_sessions
 * @param   int     $speaker
 * @param   string  $event_filter  ACTIVE, INACTIVE, ALL
 * @return  array
 * @since   1.0.0
 **/

function mdb_get_sessions_by_speaker( $speaker, $event_filter = 'ALL' )
{
    return mdb_get_sessions( array(
                             'speaker'      => $speaker,
                             'event_filter' => $event_filter ) );
}



/**
 * Sortiert ein Array mit Sessions aufsteigend nach Zeitstempel
 *
 * @param   array   $sessions
 * @return  array
 * @see     mdb_get_sessions
 * @since   1.0.0
 **/

function mdb_sort_sessions_by_timestamp( $sessions )
{
    if( is_array( $sessions ) == TRUE ) :
        // Variablen setzen
        $unable_to_sort = FALSE;
        $sort           = array();

        // Zeitstempel und sortierfähiges Array bilden
        foreach( $sessions as $session ) :
            $timestamp = strtotime( get_field( 'programmpunkt-datum', $session->ID )
                                    . ''
                                    . get_field( 'programmpunkt-von', $session->ID ) );

            if( $timestamp === FALSE ) :
                $unable_to_sort = TRUE;
                break;
            endif;

            $sort[ $timestamp ] = $session;
        endforeach;

        // Sortieren wenn möglich
        if( $unable_to_sort == FALSE ) :
            ksort( $sort );
            $sessions = array_values( $sort );
        endif;
    endif;

    return $sessions;
}



/**
 * Ermittelt die derzeit aktiven Events
 *
 * @return array
 * @since  1.0.0
 **/

function mdb_get_active_events()
{
    // Suchparameter setzen
    $query = array(
             'taxonomy'   => 'event',
             'hide_empty' => 'false', // true?
             'meta_key'   => 'event-status',
    	     'meta_value' => '1' );

    // Passende Events ermitteln
    $terms = get_terms( $query );

    if( $terms === FALSE ) :
        return NULL;
    endif;

    // Rückgabedaten erstellen
    $events = array();

    foreach( $terms as $term ) :
        $events[] = $term->term_taxonomy_id;
    endforeach;

    return $events;
}



/**
 * Ermittelt die Speaker aus allen Sessions von einem oder mehreren Events
 * Bleibt $event_list_string leer, werden die aktiven Events zur Grundlage genommen
 *
 * @param  string  $event_list_string  eine kommaseparierte Liste mit Events (IDs)
 * @return array
 * @since  1.0.0
 **/

function mdb_get_speaker_datasets( $event_list_string = '' )
{
    // Suchparameter setzen
    $query = array(
             'posts_per_page' => -1,
             'post_status'    => 'publish',
             'post_type'      => 'session',
             'meta_query'     => array( array(
                                        'key'     => 'programmpunkt-referenten',
                                        'compare' => 'EXISTS' ) ),
             'tax_query'      => array( 'relation' => 'OR' ) );

    if( !empty( $event_list_string ) ) :
        $event_list = explode( ',', str_replace(" ", "", $event_list_string ) );
    else :
        $event_list = mdb_get_active_events();
    endif;

    foreach( $event_list as $event ) :
        $query[ 'tax_query' ][] = array(
                                  'taxonomy' => 'event',
                                  'field'    => 'term_id',
                                  'terms'    => $event );
    endforeach;


    // Passende Sessions ermitteln
    $sessions = get_posts( $query );

    if( $sessions ) :
        $finds_list   = array();
        $speaker_list = array();

        foreach( $sessions as $session ) :
            $speakers = get_field( 'programmpunkt-referenten', $session->ID );

            // Einen oder mehrere Speaker gefunden
            if( $speakers != NULL ) :
                foreach( $speakers as $speaker ) :

                    // Nur hinzufügen, wenn nicht bereits zuvor gefunden
                    if( in_array( $speaker, $finds_list ) == FALSE ) :
                        $finds_list[]   = $speaker;
                        $speaker_list[] = mdb_get_speaker_dataset( $speaker );

                    endif;
                endforeach;
            endif;
        endforeach;

        // Speaker nach Vor- und Nachnamen sortieren
        return mdb_sort_speaker_datasets( $speaker_list );
    endif;

    return NULL;
}



/**
 * Liefert den Datensatz eines bestimmten Speakers
 *
 * @param  int    $speaker
 * @return array
 * @since  1.0.0
 **/

function mdb_get_speaker_dataset( $speaker )
{
    $post = get_post( $speaker );

    $data[ 'id' ]          = $speaker;
    $data[ 'firstname' ]   = get_field( 'referent-vorname', $post );
    $data[ 'lastname' ]    = get_field( 'referent-nachname', $post );
    $data[ 'name' ]        = trim( sprintf( '%1$s %2$s', $data[ 'firstname' ], $data[ 'lastname' ] ) );
    $data[ 'title_name' ]  = trim( sprintf( '%1$s %2$s', get_field( 'referent-titel', $post ), $data[ 'name' ] ) );
    $data[ 'position' ]    = get_field( 'referent-position', $post );
    $data[ 'description' ] = get_field( 'referent-beschreibung', $post );
    $data[ 'permalink' ]   = get_post_permalink( $speaker );

    return $data;
}



/**
 * Sortiert eine Liste von Speaker-Datensätzen nach Vor- und Nachnamen
 *
 * @param  array  $speaker_list Die unsortierte Liste
 * @return array                Die sortierte List
 * @since  1.0.0
 */

function mdb_sort_speaker_datasets( $speaker_list )
{
    foreach( $speaker_list as $key => $row ) :
        $forename[$key] = $row[ 'forename' ];
        $lastname[$key] = $row[ 'lastname' ];
    endforeach;
    array_multisort( $lastname, SORT_ASC, SORT_STRING, $forename, SORT_ASC, SORT_STRING, $speaker_list );

    return $speaker_list;
}



/**
 * Ermittelt den Namen einer Location
 *
 * @param  int      $location
 * @return string
 * @since  1.0.0
 */

function mdb_get_location( $location )
{
    if( !empty( $location ) ) :
        $term = get_term_by( 'term_taxonomy_id', $location, 'location' );

        if( $term !== FALSE ) :
            return $term->name;
        endif;
    endif;

    return ''; // or NULL
}


/**
 * Ermittelt den Namen eines Events
 *
 * @param  int      $event
 * @return string
 * @since  1.0.0
 */

function mdb_get_event( $event )
{
    if( !empty( $event ) ) :
        $term = get_term_by( 'term_taxonomy_id', $event, 'event' );

        if( $term !== FALSE ) :
            return $term->name;
        endif;
    endif;

    return NULL;
}
