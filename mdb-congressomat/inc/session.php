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
                            'posts_per_page' => -1,
                            ) ) );


    // Suchparameter setzen
    $query[ 'posts_per_page' ] = $posts_per_page;
    $query[ 'post_status']     = 'publish';
    $query[ 'post_type' ]      = 'session';

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
 * Liefert ein Array mit Sessions eines bestimmten Events
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
                             'speaker_id' => $speaker_id
                             ) );
}





function mdb_get_location( $location_id )
{
    $term = get_term_by( 'term_taxonomy_id', $location_id, 'locations' );

    if( $term === false ) :
        return '';
    endif;

    return $term->name;
}




function mdb_get_speaker_info( $speaker_id )
{
    $post = get_post( $speaker_id );

    $speaker_info[ 'id' ]          = $speaker_id;
    $speaker_info[ 'firstname' ]   = get_field( 'referent-vorname', $post );
    $speaker_info[ 'lastname' ]    = get_field( 'referent-nachname', $post );
    $speaker_info[ 'name' ]        = trim( sprintf( '%1$s %2$s', $speaker_info[ 'firstname' ], $speaker_info[ 'lastname' ] ) );
    $speaker_info[ 'title_name' ]  = trim( sprintf( '%1$s %2$s', get_field( 'referent-titel', $post ),$speaker_info[ 'name' ] ) );
    $speaker_info[ 'position' ]    = get_field( 'referent-position', $post );
    $speaker_info[ 'description' ] = get_field( 'referent-beschreibung', $post );

    return $speaker_info;
}



/**
 * Ermittelt alle Referenten aus allen Sessions von einem oder mehreren Events
 *
 * @param  string $events  Eine kommaseparierte Liste mit event_ids
 * @return array  Ein Array mit den Daten der Referenten
 * @since  1.0.0
 **/

function mdb_get_speakers( $events )
{
    // Suchparameter setzen
    $query[ 'posts_per_page' ] = -1;
    $query[ 'post_status']     = 'publish';
    $query[ 'post_type' ]      = 'session';
    $query[ 'meta_query' ]     = array( array(
                                        'key'     => 'programmpunkt-referenten',
                                        'compare' => 'EXISTS' ) );
    $query[ 'tax_query' ]      = array( 'relation' => 'OR' );

    // tax_query komplettieren
    $event_ids = explode( ',', str_replace(" ", "", $events ) );

    foreach( $event_ids as $event_id ) :
        $query[ 'tax_query' ][] = array(
                                  'taxonomy' => 'event',
                                  'field'    => 'term_id',
                                  'terms'    => $event_id );
    endforeach;

    // Passende Sessions ermitteln
    $sessions = get_posts( $query );

    if( $sessions ) :
        $found_ids     = array();
        $speakers_list = array();

        foreach( $sessions as $session ) :
            $speakers = get_field( 'programmpunkt-referenten', $session->ID );

            // Ein oder mehr Referent(en) gefunden
            if( $speakers != NULL ) :
                foreach( $speakers as $speaker_id ) :

                    // Nur hinzufügen, wenn nicht bereits zuvor gefunden
                    if( in_array( $speaker_id, $found_ids ) == FALSE ) :
                        $speakers_list[] = mdb_get_speaker_info( $speaker_id );
                        $found_ids[]     = $speaker_id;
                    endif;
                endforeach;
            endif;
        endforeach;

        // Referenten nach Vor- und Nachnamen sortieren
        foreach( $speakers_list as $key => $row ) :
            $forename[$key] = $row['forename'];
            $lastname[$key] = $row['lastname'];
        endforeach;
        array_multisort( $lastname, SORT_ASC, SORT_STRING, $forename, SORT_ASC, SORT_STRING, $speakers_list );

        return $speakers_list;
    endif;

    return NULL;
}
