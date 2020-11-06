<?php
/**
 * Hauptfunktion zum Einrichten der von diesem Thema unterstützten Optionen
 *
 * @since   1.0.0
 * @author  Marco Di Bella <mdb@marcodibella.de>
 * @package congressomat
 */


defined( 'ABSPATH' ) OR exit;



if ( ! function_exists( 'cm_theme_setup' ) ) :

    /**
     * Führt grundlegende Einstellungen für das Thema durch.
     *
     * @since   1.0.0
     */

     function cm_theme_setup()
     {
        /* Internationalisierung ermöglichen */

	    load_theme_textdomain( 'congressomat', get_template_directory() . '/lang' );


        /* HTML5-konformer Umgang von diversen WordPress-Core-Elementen ermöglichen */

        add_theme_support( 'html5', array(
            'comment-list',
            'comment-form',
            'search-form',
            'gallery',
            'caption',
            'script',
            'style',
        ) );


        /* Responsiven Einbettung von Embeds ermöglichen*/

        add_theme_support( 'responsive-embeds' );


        /*
         * Thumbnails
         * - Unterstützung von Thumbnails für jeden Beitragstyp
         * - Fetlegung der Thumbnailgröße auf 240x240px;
         */

        add_theme_support( 'post-thumbnails' );
        set_post_thumbnail_size( 240, 240, false );

        if( ( get_option( 'thumbnail_size_w' ) != 240 ) ) :
            update_option( 'thumbnail_size_w', 240 );
            update_option( 'thumbnail_size_h', 240 );
        endif;


        /*
         * Block-Editor (Gutenberg)
         * - Benutzerdefinierte Farbpalette einrichten
         * - "align full"/"align wide" ermöglichen
         */

        $palette = array(
            array(
                'name'  => __( 'Weiß', 'congressomat' ),
                'slug'  => 'white',
                'color' => '#ffffff',
            ),
            array(
                'name'  => __( 'Schwarz 5%', 'congressomat' ),
                'slug'  => 'black-05',
                'color' => '#fafafa',
            ),
            array(
                'name'  => __( 'Schwarz 10%', 'congressomat' ),
                'slug'  => 'black-10',
                'color' => '#e5e5e5',
            ),
            array(
                'name'  => __( 'Schwarz 20%', 'congressomat' ),
                'slug'  => 'black-20',
                'color' => '#cccccc',
            ),
            array(
                'name'  => __( 'Schwarz 30%', 'congressomat' ),
                'slug'  => 'black-30',
                'color' => '#b2b2b2',
            ),
            array(
                'name'  => __( 'Schwarz 40%', 'congressomat' ),
                'slug'  => 'black-40',
                'color' => '#999999',
            ),
            array(
                'name'  => __( 'Schwarz 50%', 'congressomat' ),
                'slug'  => 'black-50',
                'color' => '#7f7f7f',
            ),
            array(
                'name'  => __( 'Schwarz 60%', 'congressomat' ),
                'slug'  => 'black-60',
                'color' => '#666666',
            ),
            array(
                'name'  => __( 'Schwarz 70%', 'congressomat' ),
                'slug'  => 'black-70',
                'color' => '#4c4c4c',
            ),
            array(
                'name'  => __( 'Schwarz 80%', 'congressomat' ),
                'slug'  => 'black-80',
                'color' => '#333333',
            ),
            array(
                'name'  => __( 'Schwarz 90%', 'congressomat' ),
                'slug'  => 'black-90',
                'color' => '#191919',
            ),
            array(
                'name'  => __( 'Schwarz', 'congressomat' ),
                'slug'  => 'black',
                'color' => '#000000',
            ),
        );

        add_theme_support( 'editor-color-palette', $palette );
        add_theme_support( 'align-wide' );


        /*
         * Mediengrößen anpassen
         * Größenangaben entsprechen den Gutenberg Media Queries
         */

        if( ( get_option( 'medium_size_w' ) != 782 ) ) :
            update_option( 'medium_size_w', 782 );
            update_option( 'medium_size_h', 9999 );
        endif;

        if( ( get_option( 'large_size_w' ) != 960 ) ) :
            update_option( 'large_size_w', 960 );
            update_option( 'large_size_h', 9999 );
        endif;

        add_image_size ( 'mobile', 480, 9999 );
        add_image_size ( 'small', 600, 9999 );
        add_image_size ( 'wide', 1280, 9999 );
        add_image_size ( 'huge', 1440, 9999 );
        remove_image_size( 'medium_large' );


        /* Navigationsmenüs und Widget Areas registrieren */

        register_nav_menu( 'primary', __( 'Primäre Navigation', 'congressomat' ) );

        register_sidebar( array(
    	    'name'			=> __( 'Footer #1', 'congressomat' ),
    	    'id'			=> 'footer-one',
    	    'description'	=> __( 'Die hier abgelegten Widgets erscheinen im Bereich 1 in der Fußzeile.', 'congressomat' ),
    	    'before_widget'	=> '<div class="widget %2$s clr">',
    	    'after_widget'	=> '</div>',
    	    'before_title'	=> '<h6 class="widget-title">',
    	    'after_title'	=> '</h6>',
        ) );

        register_sidebar( array(
        	'name'			=> __( 'Footer #2', 'congressomat' ),
        	'id'			=> 'footer-two',
        	'description'	=> __( 'Die hier abgelegten Widgets erscheinen im Bereich 2 in der Fußzeile.', 'congressomat' ),
        	'before_widget'	=> '<div class="widget %2$s clr">',
        	'after_widget'	=> '</div>',
        	'before_title'	=> '<h6 class="widget-title">',
        	'after_title'	=> '</h6>',
        ) );

        register_sidebar( array(
        	'name'			=> __( 'Footer #3', 'congressomat' ),
        	'id'			=> 'footer-three',
        	'description'	=> __( 'Die hier abgelegten Widgets erscheinen im Bereich 3 in der Fußzeile.', 'congressomat' ),
        	'before_widget'	=> '<div class="widget %2$s clr">',
        	'after_widget'	=> '</div>',
        	'before_title'	=> '<h6 class="widget-title">',
        	'after_title'	=> '</h6>',
        ) );
    }

    add_action( 'after_setup_theme', 'cm_theme_setup' );

endif;



/**
 * (Ent-)Lädt eine Reihe von notwendigen JS-Scripts und Stylesheets.
 *
 * @since   1.0.0
 */

function cm_enqueue_scripts()
{
    wp_enqueue_script( 'congressomat-script', get_template_directory_uri() . '/assets/js/frontend.js', array( 'jquery' ), false, true );
    wp_enqueue_style( 'congressomat-style', get_template_directory_uri() . '/assets/css/frontend.min.css', array(), '2.4.0' );
}

add_action( 'wp_enqueue_scripts', 'cm_enqueue_scripts', 9990 );
