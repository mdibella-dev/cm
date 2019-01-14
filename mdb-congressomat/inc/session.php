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
 * @param  array $sessions Ein durch ein get_posts()-Aufruf erzeugtes Array mit Objekten vom Post-Typ 'session'.
 * @return array Das sortierte Array oder $sessions in den Fällen, in denen eine Sortierung nicht möglich ist.
 *
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
 * Liefert ein Array mit allen zu einem Event gehörenden Sessions
 *
 * @param  int|string $event_id Ein durch ein get_posts()-Aufruf erzeugtes Array mit Objekten vom Post-Typ 'session'
 * @return array Die zum Event gehörenden Sessions
 * @since  1.0.0
 * @uses   ACF
 **/

function mdb_get_sessions_by_event( $event_id )
{
    // $event_id kann ein slug oder eine term_id sein
    if( is_numeric( $event_id ) ) :
        $event_id_type = 'term_id';
    else :
        $event_id_type = 'slug';
    endif;

    // Passende Sessions ermitteln
    $args = array(
	        'numberposts' => -1,
    	    'post_status' => 'publish',
            'post_type'   => 'session',
            'meta_query'  => array( array(
                                    'key'     => 'programmpunkt-referenten',
                                    'value'   => serialize( '25' ),
                                    'compare' => 'LIKE'
                              ) ),
            'tax_query'   => array( array(
                                    'taxonomy' => 'event',
                                    'field'    => $event_id_type,
                                    'terms'    => $event_id,
                             ) ),
            );

    $sessions = get_posts( $args );

/*
echo serialize( array( '25' ) ).' '.serialize( '25' ).'<br>';
foreach( $sessions as $session ) :
echo '<pre>';
print_r(get_post_custom($session->ID));
echo '</pre>';
endforeach;
*/
    // filtern ?

    // Sortieren und zurückgeben
    return mdb_sort_sessions_by_timestamp( $sessions );
}






function testio() {
    $event_id = '10';
    $sessions = mdb_get_sessions_by_event( $event_id );

    foreach( $sessions as $session ) :
        echo sprintf( 'Am %1$s von %2$s bis %3$s -> %4$s<br>',
                      get_field( 'programmpunkt-datum', $session->ID ),
                      get_field( 'programmpunkt-von', $session->ID ),
                      get_field( 'programmpunkt-bis', $session->ID ),
                      $session->post_title );

    endforeach;
}
