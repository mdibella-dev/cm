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
    if( is_array( $sessions ) == true ) :
        // Variablen setzen
        $unable_to_sort = false;
        $sort           = array();

        // Zeitstempel und sortierfähiges Array bilden
        foreach( $sessions as $session ) :
            $timestamp = strtotime( get_field( 'programmpunkt-datum', $session->ID )
                                    . ''
                                    . get_field( 'programmpunkt-von', $session->ID ) );

            if( $timestamp === false ) :
                $unable_to_sort = true;
                break;
            endif;

            $sort [ $timestamp ] = $session;
        endforeach;

        // Sortieren wenn möglich
        if( $unable_to_sort == false ) :
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
                            'referent_id'    => '0',
                            'posts_per_page' => -1,
                            ) ) );


    // Suchparameter setzen
    $query[ 'posts_per_page' ] = $posts_per_page;
    $query[ 'post_status']     = 'publish';
    $query[ 'post_type' ]      = 'session';

    // Nach Event filtern?
    if( !empty( $event_id ) and is_numeric( $event_id ) ) :
        $query [ 'tax_query' ] = array( array(
                                       'taxonomy' => 'event',
                                       'field'    => 'term_id',
                                       'terms'    => $event_id
                                       ) );
    endif;

    // Nach Referent filtern?
    if( !empty( $referent_id ) and is_numeric( $referent_id ) ) :
        $query [ 'meta_query' ] = array( array(
                                        'key'     => 'programmpunkt-referenten',
                                        'value'   => serialize( (string) $referent_id ),
                                        'compare' => 'LIKE'
                                        ) );
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
 * @param  int    $event_id     Das zu filternde Event
 * @param  int    $referent_id  Der zu filternde Referent (optional)
 * @return array  Die zum Event gehörenden Sessions
 * @since  1.0.0
 **/

function mdb_get_sessions_by_event( $event_id, $referent_id = 0 )
{
    return mdb_get_sessions( array(
                             'event_id'    => $event_id,
                             'referent_id' => $referent_id
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



function mdb_get_referent( $referent_id )
{
    $post = get_post( $referent_id );

    $referent[ 'vorname' ]      = get_field( 'referent-vorname', $post );
    $referent[ 'nachname' ]     = get_field( 'referent-nachname', $post );
    $referent[ 'name' ]         = trim( sprintf( '%1$s %2$s', $referent[ 'vorname' ], $referent[ 'nachname' ] ) );
    $referent[ 'titel_name' ]   = trim( sprintf( '%1$s %2$s', get_field( 'referent-titel', $post ), $referent[ 'name' ] ) );
    $referent[ 'position' ]     = get_field( 'referent-posititon', $post );
    $referent[ 'beschreibung' ] = get_field( 'referent-beschreibung', $post );

    return $referent;
}
