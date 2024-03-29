<?php
/**
 * Functions to optimize the structure of the site.
 *
 * @author  Marco Di Bella
 * @package cm-theme
 */

namespace cm_theme;


/** Prevent direct access */

defined( 'ABSPATH' ) or exit;



/**
 * Removes various ballast.
 *
 * @since 1.0.0
 */

function remove_styles_scripts() {
    remove_action( 'wp_head', 'wlwmanifest_link' );
    remove_action( 'wp_head', 'rsd_link' );
    remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
    remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
    remove_action( 'wp_print_styles', 'print_emoji_styles' );
    remove_action( 'admin_print_styles', 'print_emoji_styles' );
}

add_action( 'wp_enqueue_scripts', __NAMESPACE__ . '\remove_styles_scripts', 9985 );



/**
 * Removes unnecessary post classes like
 * - .has-post-thumbnail,
 * - .sticky,
 * - .category-,
 * - .tags-,
 * - .status
 *
 * @since 1.0.0
 *
 * @see https://developer.wordpress.org/reference/hooks/post_class/
 *
 * @param array $classes An array of CSS classes applied to post types.
 * @param array $class   An array of additional CSS classes.
 * @param int   $post_id The ID of the post.
 *
 * @return array Modified class array.
 */

function remove_post_classes( $classes, $class, $post_id ) {
    $checked_classes = [];

    if ( ! is_admin() ) {

        foreach( $classes as $check ) {
            if( ( false !== strpos( $check, 'has-post-thumbnail' ) )
                or ( false !== strpos( $check, 'sticky' ) )
                or ( false !== strpos( $check, 'status-' ) )
                or ( false !== strpos( $check, 'category-' ) )
                or ( false !== strpos( $check, 'tag-' ) )
                or ( false !== strpos( $check, 'post_format-' ) )
                or ( false !== strpos( $check, 'hentry' ) )
                or ( false !== strpos( $check, 'type-' ) )
            ) {
                // nicht übernehmen
            } else {
                // ansonsten hinzufügen
                $checked_classes[] = $check;
            }
        }

        $classes = $checked_classes;
    }

    return $classes;
}

add_filter( 'post_class', __NAMESPACE__ . '\remove_post_classes', 10, 3 );



/**
 * Set the excerpt's length.
 *
 * @since 1.0.0
 *
 * @param int $length The current length.
 *
 * @return int The modified number of characters.
 */

function set_excerpt_length( $length ) {
    return 30;
}

add_filter( 'excerpt_length', __NAMESPACE__ . '\set_excerpt_length', 999 );
