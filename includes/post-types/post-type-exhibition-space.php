<?php
/**
 * Post Type Exhibition_Space (Ausstellungsfläche)
 *
 * @author  Marco Di Bella
 * @package cm
 */


/** Prevent direct access */

defined( 'ABSPATH' ) or exit;



/**
 * Bestimmt die Spalten der Beitragsliste (Backend).
 *
 * @since  2.5.0
 * @param  array   $default    Die Standardvorgaben für Spalten.
 * @return $array              Ein assoziatives Array, in denen die zu verwendenden Spalten beschrieben werden.
 */

function cm_post_type_exhibition_space__manage_posts_columns( $default )
{
    $columns['cb']                          = $default['cb'];
    $columns['title']                       = __( 'Ausstellungsfläche', 'cm' );
    $columns['taxonomy-location']           = __( 'Standort', 'cm' );
    $columns['taxonomy-exhibition_package'] = __( 'Ausstellungspaket', 'cm' );
    $columns['update']                      = __( 'Zuletzt aktualisiert', 'cm' );

    return $columns;
}

add_filter( 'manage_exhibition_space_posts_columns', 'cm_post_type_exhibition_space__manage_posts_columns', 10 );



/**
 * Erzeugt die Ausgabe der Spalten.
 *
 * @since 2.5.0
 * @param string $column_name    Bezeichnung der auszugebenden Spalte.
 * @param int    $post_id        ID des Beitrags (aka Datensatzes) den auszugeben gilt.
 */

function cm_post_type_exhibition_space__manage_posts_custom_column( $column_name, $post_id )
{
    switch( $column_name ) :

        case 'update':
            echo sprintf(
                '%1$s um %2$s Uhr',
                get_the_modified_date( 'd.m.Y', $post_id ),
                get_the_modified_date( 'H:i', $post_id ),
            );
        break;

    endswitch;
}

add_action( 'manage_exhibition_space_posts_custom_column', 'cm_post_type_exhibition_space__manage_posts_custom_column', 9999, 2 );



/**
 * Registriert sortierfähige Spalten (durch Zuordnung entsprechender orderby-Parameter).
 *
 * @since  2.5.0
 * @param  array  $columns   Die Spalten.
 * @return $array            Ein assoziatives Array.
 */

function cm_post_type_exhibition_space__manage_sortable_columns( $columns )
{
    $columns['title']                       = 'title';
    //$columns['taxonomy-exhibition_package'] = 'taxonomy-exhibition_package';
    $columns['taxonomy-location']           = 'taxonomy-location';
    $columns['update']                      = 'update';
    return $columns;
}

add_filter( 'manage_edit-exhibition_space_sortable_columns', 'cm_post_type_exhibition_space__manage_sortable_columns' );



/**
 * Erzeugt eine sortierte Ausgabe.
 *
 * @since 2.5.0
 * @param WP_Query $query   Ein Datenobjekt der zuletzt gemachten Abfrage.
 */

function cm_post_type_exhibition_space__pre_get_posts( $query )
{
    if( $query->is_main_query() and is_admin() ) :

        $orderby = $query->get( 'orderby' );

        switch( $orderby ) :

            case 'update':
                $query->set( 'orderby', 'modified' );
            break;

            default:
            case '':
                $query->set( 'orderby', 'title' );
                $query->set( 'order', 'asc' );
            break;

        endswitch;
    endif;
}

add_action( 'pre_get_posts', 'cm_post_type_exhibition_space__pre_get_posts', 1 );
