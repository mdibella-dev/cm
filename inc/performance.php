<?php
/**
 * Funktionen zu Optimierung der Webseite
 *
 * @author  Marco Di Bella <mdb@marcodibella.de>
 * @package congressomat
 */


defined( 'ABSPATH' ) OR exit;



/**
 * Entfernt Höhen- und Breiten-Angaben bei Thumbnails
 *
 * @since   1.0.0
 */

function cm_remove_thumbnail_width_height( $html, $post_id, $post_thumbnail_id, $size, $attr )
{
    $html = preg_replace( '/(width|height)=\"\d*\"\s/', "", $html );
    return $html;
}

add_filter( 'post_thumbnail_html', 'cm_remove_thumbnail_width_height', 10, 5 );




/**
 * Entfernt diversen Ballast
 *
 * @since   1.0.0
 */

function cm_remove_styles_scripts()
{
	remove_action( 'wp_head', 'wlwmanifest_link' );
	remove_action( 'wp_head', 'rsd_link' );
    remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
    remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
    remove_action( 'wp_print_styles', 'print_emoji_styles' );
    remove_action( 'admin_print_styles', 'print_emoji_styles' );
}

add_action( 'wp_enqueue_scripts', 'cm_remove_styles_scripts', 9985 );




/**
 * Entfernt unnötige Beitrags-Klassen
 *
 * @since   1.0.0
 */

function cm_remove_post_classes( $classes, $class, $post_id )
{
    $checked_classes = array();

    if( !is_admin() ) :

        foreach( $classes as $check ) :

            if( ( false !== strpos( $check, 'has-post-thumbnail' ) ) or
                ( false !== strpos( $check, 'sticky' ) ) or
                ( false !== strpos( $check, 'status-' ) ) or
                ( false !== strpos( $check, 'category-' ) ) or
                ( false !== strpos( $check, 'tag-' ) ) or
                ( false !== strpos( $check, 'post_format-' ) ) or
                ( false !== strpos( $check, 'hentry' ) ) or
                ( false !== strpos( $check, 'type-' ) )
              ) :
                /* nicht übernehmen */
            else :
                /* ansonsten hinzufügen */
                $checked_classes[] = $check;
            endif;

        endforeach;

        $classes = $checked_classes;

    endif;

    return $classes;
}

add_filter( 'post_class', 'cm_remove_post_classes', 10, 3 );
