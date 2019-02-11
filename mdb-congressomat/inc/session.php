<?php
/**
 * ....
 *
 * @author  Marco Di Bella <mdb@marcodibella.de>
 * @package mdb-congressomat
 **/



/**
 * Sortiert ein Array mit Sessions austeigend nach Zeitstempel
 *
 * @param  array  $sessions  Ein durch ein get_posts()-Aufruf erzeugtes Array mit Objekten vom Post-Typ 'session'.
 * @return array  Das sortierte Array oder $sessions in den Fällen, in denen eine Sortierung nicht möglich ist.
 * @since  1.0.0
 * @uses   ACF
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
 * Liefert ein Array mit Sessions
 *
 * @param  array  $args  Array mit Argumenten zur Konfiguration der Suche
 * @return array  Die zum Event gehörenden Sessions
 * @since  1.0.0
 * @uses   ACF
 **/

function mdb_get_sessions( $args )
{
    // Übergebene Parameter auslesen
    extract( wp_parse_args( $args,
                            array(
                            'event_id'       => '0',
                            'speaker_id'     => '0',
                            'posts_per_page' => -1 ) ) );

    // Suchparameter setzen
    $query = array(
             'posts_per_page' => $posts_per_page,
             'post_status'    => 'publish',
             'post_type'      => 'session' );

    // Nach Event filtern?
    if( !empty( $event_id ) and is_numeric( $event_id ) ) :
        $query[ 'tax_query' ] = array( array(
                                       'taxonomy' => 'event',
                                       'field'    => 'term_id',
                                       'terms'    => $event_id ) );
    endif;

    // Nach Referent filtern?
    if( !empty( $speaker_id ) and is_numeric( $speaker_id ) ) :
        $query[ 'meta_query' ] = array( array(
                                        'key'     => 'programmpunkt-referenten',
                                        'value'   => serialize( (string) $speaker_id ),
                                        'compare' => 'LIKE' ) );
    endif;

    // Passende Sessions ermitteln
    $sessions = get_posts( $query );

    // Sortieren und zurückgeben
    return mdb_sort_sessions_by_timestamp( $sessions );
}



/**
 * Liefert ein Array mit den Sessions eines bestimmten Events
 *
 * Wrapper für mdb_get_sessions(). Optional kann nach einem bestimmten Referenten gefiltert werden
 *
 * @param  int    $event_id    Das zu filternde Event
 * @param  int    $speaker_id  Der zu filternde Referent (optional)
 * @return array  Die zum Event gehörenden Sessions
 * @since  1.0.0
 **/

function mdb_get_sessions_by_event( $event_id, $speaker_id = 0 )
{
    return mdb_get_sessions( array(
                             'event_id'   => $event_id,
                             'speaker_id' => $speaker_id ) );
}



/**
 * Liefert ein Array mit allen Daten eines bestimmten Referenten
 *
 * @param  int    $speaker_id  Der zu Referent
 * @return array  Die zum Referenten gehörenden Daten
 * @since  1.0.0
 **/

function mdb_get_speaker_info( $speaker_id )
{
    $post = get_post( $speaker_id );

    $data[ 'id' ]          = $speaker_id;
    $data[ 'firstname' ]   = get_field( 'referent-vorname', $post );
    $data[ 'lastname' ]    = get_field( 'referent-nachname', $post );
    $data[ 'name' ]        = trim( sprintf( '%1$s %2$s', $data[ 'firstname' ], $data[ 'lastname' ] ) );
    $data[ 'title_name' ]  = trim( sprintf( '%1$s %2$s', get_field( 'referent-titel', $post ), $data[ 'name' ] ) );
    $data[ 'position' ]    = get_field( 'referent-position', $post );
    $data[ 'description' ] = get_field( 'referent-beschreibung', $post );
    $data[ 'permalink' ]   = get_post_permalink( $speaker_id );

    return $data;
}



/**
 * Ermittelt alle Referenten aus allen Sessions von einem oder mehreren Events
 *
 * @param  string $events  Eine kommaseparierte Liste mit event_ids;
 *                         werden keine Werte übergeben, so werden die aktiven Events herausgesucht
 * @return array  Ein Array mit den Daten der Referenten
 * @since  1.0.0
 **/

function mdb_get_speakers( $events )
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

    // tax_query komplettieren
    if( !empty( $events ) ) :
        $event_ids = explode( ',', str_replace(" ", "", $events ) );
    else :
        $event_ids = mdb_get_active_events();
    endif;

    foreach( $event_ids as $event_id ) :
        $query[ 'tax_query' ][] = array(
                                  'taxonomy' => 'event',
                                  'field'    => 'term_id',
                                  'terms'    => $event_id );
    endforeach;

    // Passende Sessions ermitteln
    $sessions = get_posts( $query );

    if( $sessions ) :
        $found_ids    = array();
        $speaker_list = array();

        foreach( $sessions as $session ) :
            $speakers = get_field( 'programmpunkt-referenten', $session->ID );

            // Ein oder mehr Referent(en) gefunden
            if( $speakers != NULL ) :
                foreach( $speakers as $speaker_id ) :

                    // Nur hinzufügen, wenn nicht bereits zuvor gefunden
                    if( in_array( $speaker_id, $found_ids ) == FALSE ) :
                        $speaker_list[] = mdb_get_speaker_info( $speaker_id );
                        $found_ids[]    = $speaker_id;
                    endif;
                endforeach;
            endif;
        endforeach;

        // Referenten nach Vor- und Nachnamen sortieren
        return mdb_sort_speakerlist( $speaker_list );
    endif;

    return NULL;
}


function mdb_sort_speakerlist( $speaker_list )
{
    foreach( $speaker_list as $key => $row ) :
        $forename[$key] = $row[ 'forename' ];
        $lastname[$key] = $row[ 'lastname' ];
    endforeach;
    array_multisort( $lastname, SORT_ASC, SORT_STRING, $forename, SORT_ASC, SORT_STRING, $speaker_list );

    return $speaker_list;
}



function mdb_get_active_events()
{
    // Suchparameter setzen
    $query = array(
             'taxonomy'   => 'event',
             'hide_empty' => 'false',
             'meta_query' => array(
                             'key'   => 'event_status',
                             'value' => '1' ) );
        //     'meta_key'   => 'event_status',
    	//     'meta_value' => '1' );

    // Passende Events ermitteln
    $terms = get_terms( $query );

    if( $terms === FALSE ) :
        return NULL;
    endif;

    // Rückgabedaten erstellen
    $events = array();

    foreach( $terms as $term) :
        $events[] = $term->term_taxonomy_id;
    endforeach;

    return $events;
}







function mdb_get_location( $location_id )
{
    $term = get_term_by( 'term_taxonomy_id', $location_id, 'locations' );

    if( $term === FALSE ) :
        return '';
    endif;

    return $term->name;
}
