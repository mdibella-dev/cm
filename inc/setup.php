<?php
/**
 * Hauptfunktion zum Einrichten der von diesem Thema unterstützten Optionen
 *
 * @author  Marco Di Bella <mdb@marcodibella.de>
 * @package congressomat
 **/




if ( ! function_exists( 'congressomat_theme_setup' ) ) :

    /**
     * Führt grundlegende Einstellungen für das Thema durch.
     *
     * @since   1.0.0
     **/

     function congressomat_theme_setup()
     {
        /**
         * Unterstützung für Übersetzungen
         **/

	    load_theme_textdomain( 'congressomat', get_template_directory() . '/lang' );


        /**
         * HTML5-Konformität für bestimmte WordPress-Core-Elementen
         **/

        add_theme_support( 'html5', array(
            'comment-list',
            'comment-form',
            'search-form',
            'gallery',
            'caption',
            'script',
            'style',
        ) );


        /**
         * Responsive Einbettung von Embeds ermöglichen
         **/

        add_theme_support( 'responsive-embeds' );


        /**
         * Thumbnails
         **/

        // Thumbnails auch für Posts
        add_theme_support( 'post-thumbnails' );

        // Thumbnailgröße
        set_post_thumbnail_size( 240, 240, false );

        if( ( get_option( 'thumbnail_size_w' ) != 240 ) ) :
            update_option( 'thumbnail_size_w', 240 );
            update_option( 'thumbnail_size_h', 240 );
        endif;


        /**
         * Blockeditor (Gutenberg)
         **/

        // Unterstützung für "align full"/"align wide"
         add_theme_support( 'align-wide' );

        // Farbpalette
        // Farben und Farbnamen entstammen https://coolors.co/
        $blockeditor_palette  = array();
        $congressomat_palette = array(
            'Weiß, white, #fff',
            'Schwarz 10%, black-10, #e5e5e5',
            'Schwarz 20%, black-20, #ccc',
            'Schwarz 30%, black-30, #b2b2b2',
            'Schwarz 40%, black-40, #999',
            'Schwarz 50%, black-50, #7f7f7f',
            'Schwarz 60%, black-60, #666',
            'Schwarz 70%, black-70, #4c4c4c',
            'Schwarz 80%, black-80, #333',
            'Schwarz 90%, black-90, #191919',
            'Schwarz, black, #000'
        );

        foreach( $congressomat_palette as $set ) :
            $part                  = explode( ',', $set );
            $blockeditor_palette[] = array(
                'name'  => __( trim( $part[0] ), 'congressomat' ),
                'slug'  => trim( $part[1] ),
                'color' => trim( $part[2] )
            );
        endforeach;
        add_theme_support( 'editor-color-palette', $blockeditor_palette );


        /**
         * Mediengrößen
         *
         * Größenangaben entsprechen den Gutenberg Media Queries
        **/

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


        /**
         * Navigation
         **/

        register_nav_menu( 'primary', __( 'Primäre Navigation', 'congressomat' ) );


        /**
         * Widgets
         **/

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

    add_action( 'after_setup_theme', 'congressomat_theme_setup' );

endif;



/**
 * (Ent-)Lädt eine Reihe von notwendigen JS-Scripts und Stylesheets.
 *
 * @since   1.0.0
 **/

function congressomat_enqueue_scripts()
{
    /**
     * Skripte registrieren und in den Footer laden
     **/

    // Verschieben der von WordPress gelieferten jQuery
    wp_deregister_script( 'jquery' );
    wp_register_script( 'jquery', '/wp-includes/js/jquery/jquery.js', false, false, true );
    wp_enqueue_script( 'jquery' );

    // Skript von Congressomat
    wp_register_script( 'congressomat', get_template_directory_uri() . '/assets/js/frontend.js', array( 'jquery' ), false, true );
    wp_enqueue_script( 'congressomat' );



    /**
     * Registrieren und Laden des Standard-Stylesheets von Congressomat
     *
     * style.css im Hauptverzeichnis dient nur zur Theme-Identifikation und -Versionierung
     * Die (komprimierten) Stilangaben befinden sich tatsächlich in frontend(.min).css
     **/

    wp_enqueue_style( 'congressomat', get_template_directory_uri() . '/assets/css/frontend.min.css' );
}

add_action( 'wp_enqueue_scripts', 'congressomat_enqueue_scripts', 9990 );
