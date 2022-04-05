<?php
/**
 * Post Type Session (Programmpunkte)
 *
 * @author  Marco Di Bella <mdb@marcodibella.de>
 * @package cm
 */


defined( 'ABSPATH' ) or exit;



/**
 * Bestimmt die Spalten der Beitragsliste (Backend).
 *
 * @since  2.5.0
 * @param  array   $default    Die Standardvorgaben für Spalten.
 * @return $array              Ein assoziatives Array, in denen die zu verwendenden Spalten beschrieben werden.
 */

function cm_post_type_session__manage_posts_columns( $default )
{
    $columns['cb']                = $default['cb'];
    $columns['title']             = $default['title'];
    $columns['taxonomy-event']    = __( 'Veranstaltung', 'cm' );
    $columns['taxonomy-location'] = __( 'Örtlichkeit', 'cm' );
    $columns['event-date']        = __( 'Datum', 'cm' );
    $columns['event-time']        = __( 'Zeitraum', 'cm' );
    $columns['speaker']           = __( 'Referenten', 'cm' );

    return $columns;
}

add_filter( 'manage_session_posts_columns', 'cm_post_type_session__manage_posts_columns', 10 );



/**
 * Erzeugt die Ausgabe der Spalten.
 *
 * @since 2.5.0
 * @param string $column_name    Bezeichnung der auszugebenden Spalte.
 * @param int    $post_id        ID des Beitrags (aka Datensatzes) den auszugeben gilt.
 */

function cm_post_type_session__manage_posts_custom_column( $column_name, $post_id )
{
    switch( $column_name ) :

        case 'speaker':
            $speakers = get_field( 'programmpunkt-referenten', $post_id );

            if( null != $speakers ) :

                foreach( $speakers as $speaker ) :
                    $speaker_dataset = cm_get_speaker_dataset( $speaker );
                    echo sprintf(
                        '<a href="/wp-admin/post.php?post=%1$s&action=edit" title="%3$s">%2$s</a>',
                        $speaker_dataset[ 'id' ],
                        get_the_post_thumbnail( $speaker_dataset[ 'id' ], array( 100, 0 ) ),
                        sprintf(
                            __( 'Bearbeiten von %1$s', 'cm' ),
                            $speaker_dataset[ 'name' ],
                        ),
                    );
                endforeach;
            else :
                echo '-';
            endif;
        break;

        case 'event-date':
            echo get_field( 'programmpunkt-datum', $post_id );
        break;

        case 'event-time':
            $time = get_field( 'programmpunkt-alternative-zeitangabe', $post_id );

            if( empty( $time ) ) :
                $time = sprintf(
                    '%1$s bis %2$s Uhr',
                    get_field( 'programmpunkt-von', $post_id ),
                    get_field( 'programmpunkt-bis', $post_id )
                );
            endif;

            echo $time;
        break;

    endswitch;
}

add_action( 'manage_session_posts_custom_column', 'cm_post_type_session__manage_posts_custom_column', 9999, 2 );



/**
 * Registriert sortierfähige Spalten (durch Zuordnung entsprechender orderby-Parameter).
 *
 * @since  2.5.0
 * @param  array  $columns   Die Spalten.
 * @return $array            Ein assoziatives Array.
 */

function cm_post_type_session__manage_sortable_columns( $columns )
{
    $columns['title']             = 'title';
    $columns['taxonomy-event']    = 'taxonomy-event';
    $columns['taxonomy-location'] = 'taxonomy-location';
    $columns['event-date']        = 'event-date';
    return $columns;
}

add_filter( 'manage_edit-session_sortable_columns', 'cm_post_type_session__manage_sortable_columns' );



/**
 * Erzeugt eine sortierte Ausgabe.
 *
 * @since 2.5.0
 * @param WP_Query $query   Ein Datenobjekt der zuletzt gemachten Abfrage.
 */

function cm_post_type_session__pre_get_posts( $query )
{
    if( $query->is_main_query() and is_admin() ) :

        $orderby = $query->get( 'orderby' );

        switch( $orderby ) :

            case 'event-date':
                $query->set( 'orderby', 'meta_value' );
                $query->set( 'meta_key', 'programmpunkt-datum' );
            break;

        endswitch;
    endif;
}

add_action( 'pre_get_posts', 'cm_post_type_session__pre_get_posts', 1 );



/**
 * ....
 *
 * @since  2.5.0
 * @param  object $labels   Die aktuellen Beitragstitel.
 * @return object           Die modifizierten Beitragstitel.
 */

function cm_post_type_session__post_type_labels( $labels )
{
    $path  = $_SERVER['HTTP_REFERER'];
    $query = parse_url( $path, PHP_URL_QUERY );
    $parts = array();
    $extra = '';


    parse_str( $query, $parts );

    if( isset( $parts['event'] ) ) :
        $event = get_term_by( 'slug', $parts['event'], 'event' );
        $extra = $event->name;
    elseif( isset( $parts['location'] ) ) :
        $location = get_term_by( 'slug', $parts['location'], 'location' );
        $extra    = $location->name;
    endif;

    if( ! empty( $extra ) ) :
        $labels->name = sprintf (
            __( 'Programmpunkte (%1$s)', 'cm' ),
            $extra,
        );
    else:
        $labels->name = __( 'Programmpunkte', 'cm' );
    endif;


    ob_start();
    echo 'PARTS' . PHP_EOL;
    print_r( $parts );
    echo 'EVENT' . PHP_EOL;
    print_r( $event );
    echo 'LOCATION' . PHP_EOL;
    print_r( $location );
    echo 'SERVER' . PHP_EOL;
    print_r( $_SERVER);
    echo 'labels' . PHP_EOL;
    print_r( $labels );
    $output = ob_get_contents();
    ob_end_clean();

    $handle = fopen ( get_template_directory() . "/con.log", "w");
    fwrite ($handle, $output);
    fclose ($handle);
// https://wordpress.stackexchange.com/questions/27111/get-term-by-not-working-when-in-functions-php


    return $labels;
}

add_filter( 'post_type_labels_session', 'cm_post_type_session__post_type_labels', 10, 1 );
