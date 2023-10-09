<?php
/**
 * Main functions for setting up the theme.
 *
 * @author  Marco Di Bella
 * @package cm-theme
 */

namespace cm_theme;


/** Prevent direct access */

defined( 'ABSPATH' ) or exit;



/**
 * Performs basic settings for the theme.
 *
 * @since 1.0.0
 */

function theme_setup() {
    // Enables internationalization.
    load_theme_textdomain( 'cm', THEME_DIR . 'languages' );


    // Enables responsive embedding of media embeds.
    add_theme_support( 'responsive-embeds' );


    // Enables 'wide' support for the block editor (Gutenberg).
    add_theme_support( 'align-wide' );


    // Adds editor styles.
    add_theme_support( 'editor-styles' );
    add_editor_style( 'assets/build/css/frontend.min.css' );


    // Sets media sizes.
    add_theme_support( 'post-thumbnails' );
    set_post_thumbnail_size( 240, 240, false );

    if ( ( 240 != get_option( 'thumbnail_size_w' ) ) ) {
        update_option( 'thumbnail_size_w', 240 );
        update_option( 'thumbnail_size_h', 240 );
    }

    if ( ( 782 != get_option( 'medium_size_w' ) ) ) {
        update_option( 'medium_size_w', 782 );
        update_option( 'medium_size_h', 9999 );
    }

    if ( ( 960 != get_option( 'large_size_w' ) ) ) {
        update_option( 'large_size_w', 960 );
        update_option( 'large_size_h', 9999 );
    }


    // Registers the navigation menus.
    register_nav_menu( 'primary', __( 'Primäre Navigation', 'cm' ) );


    // Registers the widget areas.
    register_sidebar( [
        'name'          => __( 'Footer #1', 'cm' ),
        'id'            => 'footer-one',
        'description'   => __( 'Die hier abgelegten Widgets erscheinen im Bereich 1 in der Fußzeile.', 'cm' ),
        'before_widget' => '<div class="widget %2$s clr">',
        'after_widget'  => '</div>',
        'before_title'  => '<h6 class="widget-title">',
        'after_title'   => '</h6>',
    ] );

    register_sidebar( [
        'name'          => __( 'Footer #2', 'cm' ),
        'id'            => 'footer-two',
        'description'   => __( 'Die hier abgelegten Widgets erscheinen im Bereich 2 in der Fußzeile.', 'cm' ),
        'before_widget' => '<div class="widget %2$s clr">',
        'after_widget'  => '</div>',
        'before_title'  => '<h6 class="widget-title">',
        'after_title'   => '</h6>',
    ] );

    register_sidebar( [
        'name'          => __( 'Footer #3', 'cm' ),
        'id'            => 'footer-three',
        'description'   => __( 'Die hier abgelegten Widgets erscheinen im Bereich 3 in der Fußzeile.', 'cm' ),
        'before_widget' => '<div class="widget %2$s clr">',
        'after_widget'  => '</div>',
        'before_title'  => '<h6 class="widget-title">',
        'after_title'   => '</h6>',
    ] );

    register_sidebar( array(
        'name'          => __( 'Footer Social Media', 'cm' ),
        'id'            => 'footer-four',
        'description'   => __( 'Hier soll das Social-Media-Menü definiert werden.', 'cm' ),
        'before_widget' => '<div class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h6 class="widget-title">',
        'after_title'   => '</h6>',
    ) );
}

add_action( 'after_setup_theme', __NAMESPACE__ . '\theme_setup' );




/**
 * Loads a set of necessary JS scripts and stylesheets.
 *
 * @since 1.0.0
 */

function theme_scripts() {
    wp_enqueue_script(
        'cm-script',
        THEME_URI . '/assets/build/js/frontend.min.js',
        [
            'jquery'
        ],
        THEME_VERSION,
        true
    );

    wp_enqueue_style(
        'cm-style',
        THEME_URI . '/assets/build/css/frontend.min.css',
        [],
        THEME_VERSION
    );
}

add_action( 'wp_enqueue_scripts', __NAMESPACE__ . '\theme_scripts' );
