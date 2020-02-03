<?php
/**
 * Hauptfunktion zum Einrichten der von diesem Thema unterstützten Optionen
 *
 * @author  Marco Di Bella <mdb@marcodibella.de>
 * @package congressomat
 **/



/**
 * Führt grundlegende Einstellungen für das Thema durch.
 *
 * @since   1.0.0
 **/

 function congressomat_theme_setup()
 {
    // Laden der Lokalisation
	load_theme_textdomain( 'congressomat', get_template_directory() . '/lang' );


    // Theme-Support für diverse Features
    add_theme_support( 'responsive-embeds' );
    add_theme_support( 'align-wide' );
    add_theme_support( 'html5', array( 'comment-list', 'comment-form', 'search-form', 'gallery', 'caption' ) );


    // Thumbnails für Posts
    add_theme_support( 'post-thumbnails' );
    set_post_thumbnail_size( 240, 240, false );

    if( ( get_option( 'thumbnail_size_w' ) != 240 ) ) :
        update_option( 'thumbnail_size_w', 240 );
        update_option( 'thumbnail_size_h', 240 );
    endif;


    // Farbpalette für Blockeditor
    // Farben und Farbnamen entstammen https://coolors.co/
    $gutenberg_palette = array();
    $palette = array(
        'Weiß, white, #fff',
        'Schwarz 5%, black-05, #f0f0f0',
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

    foreach( $palette as $color_set ) :
        $parts               = explode( ',',  $color_set );
        $gutenberg_palette[] = array(
            'name'  => __( trim( $parts[0] ), 'congressomat' ),
            'slug'  => trim( $parts[1] ),
            'color' => trim( $parts[2] )
        );
    endforeach;
    add_theme_support( 'editor-color-palette', $gutenberg_palette );


    // Registrierung/Neudefinierung der Bildgrößen
    // Angaben entsprechen den Gutenberg Media Queries
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


    // Registrierung der Hauptnavigation
    register_nav_menu( 'primary', __( 'Primäre Navigation', 'congressomat' ) );


    // Registrierung der Widget-Areas im Bereich der Fußzeile
    $areas = array (
        1 => 'footer-one',
        2 => 'footer-two',
        3 => 'footer-three'
    );

    foreach( $areas as $area_nr => $area_id ) :
        register_sidebar( array(
    	    'name'			=> sprintf( __( 'Footer #$1$s', 'congressomat' ), $area_nr ),
    	    'id'			=> $area_id,
    	    'description'	=> sprintf( __( 'Die hier abgelegten Widgets erscheinen im Bereich $1$s in der Fußzeile.', 'congressomat' ), $area_nr ),
    	    'before_widget'	=> '<div class="widget %2$s clr">',
    	    'after_widget'	=> '</div>',
    	    'before_title'	=> '<h6 class="widget-title">',
    	    'after_title'	=> '</h6>',
        ) );
    endforeach;
}



/**
 * (Ent-)Lädt eine Reihe von notwendigen JS-Scripts und Stylesheets.
 *
 * @since   1.0.0
 **/

function congressomat_enqueue_scripts()
{
    // Verschieben der von WordPress gelieferten jQuery in den Footer
    wp_deregister_script( 'jquery' );
    wp_register_script( 'jquery', '/wp-includes/js/jquery/jquery.js', FALSE, FALSE, TRUE );
    wp_enqueue_script( 'jquery' );


    // Integration von FontAwesome5
	wp_enqueue_style( 'fontawesome', get_template_directory_uri() . '/assets/fa5/css/fontawesome-all.min.css' );


    // Registrieren und Laden eigener Skripte
    wp_register_script( 'congressomat', get_template_directory_uri() . '/assets/js/frontend.min.js', array( 'jquery' ), FALSE, TRUE );
	wp_enqueue_script( 'congressomat' );


	// Laden des eigenen Stylesheets
	wp_enqueue_style( 'congressomat', get_template_directory_uri() . '/assets/css/frontend.min.css' );
}
