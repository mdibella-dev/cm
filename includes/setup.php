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



if( ! function_exists( 'cm_theme_setup' ) ) :

    /**
     * Performs basic settings for the theme.
     *
     * @since 1.0.0
     */

     function cm_theme_setup()
     {
        // Enables internationalization.
        load_theme_textdomain( 'cm', THEME_DIR . '/lang' );


        // Enables HTML5-compliant handling of various WordPress core elements.
        add_theme_support( 'html5', [
            'comment-list',
            'comment-form',
            'search-form',
            'gallery',
            'caption',
            'script',
            'style',
        ] );


        // Enables responsive embedding of media embeds.
        add_theme_support( 'responsive-embeds' );


        // Sets the block-editor palette.
        add_theme_support( 'editor-color-palette', [
            [
                'name'  => __( 'Weiß', 'cm' ),
                'slug'  => 'white',
                'color' => '#ffffff',
            ],
            [
                'name'  => __( 'Schwarz 5%', 'cm' ),
                'slug'  => 'black-05',
                'color' => '#fafafa',
            ],
            [
                'name'  => __( 'Schwarz 10%', 'cm' ),
                'slug'  => 'black-10',
                'color' => '#e5e5e5',
            ],
            [
                'name'  => __( 'Schwarz 20%', 'cm' ),
                'slug'  => 'black-20',
                'color' => '#cccccc',
            ],
            [
                'name'  => __( 'Schwarz 30%', 'cm' ),
                'slug'  => 'black-30',
                'color' => '#b2b2b2',
            ],
            [
                'name'  => __( 'Schwarz 40%', 'cm' ),
                'slug'  => 'black-40',
                'color' => '#999999',
            ],
            [
                'name'  => __( 'Schwarz 50%', 'cm' ),
                'slug'  => 'black-50',
                'color' => '#7f7f7f',
            ],
            [
                'name'  => __( 'Schwarz 60%', 'cm' ),
                'slug'  => 'black-60',
                'color' => '#666666',
            ],
            [
                'name'  => __( 'Schwarz 70%', 'cm' ),
                'slug'  => 'black-70',
                'color' => '#4c4c4c',
            ],
            [
                'name'  => __( 'Schwarz 80%', 'cm' ),
                'slug'  => 'black-80',
                'color' => '#333333',
            ],
            [
                'name'  => __( 'Schwarz 90%', 'cm' ),
                'slug'  => 'black-90',
                'color' => '#191919',
            ],
            [
                'name'  => __( 'Schwarz', 'cm' ),
                'slug'  => 'black',
                'color' => '#000000',
            ],
        ] );


        // Enables 'wide' support for the block editor (Gutenberg).
        add_theme_support( 'align-wide' );


        // Sets media sizes.
        add_theme_support( 'post-thumbnails' );
        set_post_thumbnail_size( 240, 240, false );

        if( ( 240 != get_option( 'thumbnail_size_w' ) ) ) :
            update_option( 'thumbnail_size_w', 240 );
            update_option( 'thumbnail_size_h', 240 );
        endif;

        if( ( 782 != get_option( 'medium_size_w' ) ) ) :
            update_option( 'medium_size_w', 782 );
            update_option( 'medium_size_h', 9999 );
        endif;

        if( ( 960 != get_option( 'large_size_w' ) ) ) :
            update_option( 'large_size_w', 960 );
            update_option( 'large_size_h', 9999 );
        endif;


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
    }

    add_action( 'after_setup_theme', 'cm_theme_setup' );

endif;



/**
 * Loads a set of necessary JS scripts and stylesheets.
 *
 * @since 1.0.0
 */

function cm_enqueue_scripts()
{
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
        array(),
        THEME_VERSION
    );
}

add_action( 'wp_enqueue_scripts', 'cm_enqueue_scripts', 9990 );
