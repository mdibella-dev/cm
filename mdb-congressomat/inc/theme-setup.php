<?php
/**
 * Hauptfunktion zum Einrichten der von diesem Thema unterstützten Optionen
 *
 * @author  Marco Di Bella <mdb@marcodibella.de>
 * @package mdb-congressomat
 * @since   0.0.1
 * @version 0.0.1
 */



/**
 * Führt grundlegende Einstellungen für das Thema durch.
 *
 * @since 0.0.1
 */

 function mdb_theme_setup()
 {
    // Theme unterstützt: Lokalisation
	load_theme_textdomain( 'mdb-congressomat', PATH_THEME_TEMPLATE . '/lang' );
/*
    // Theme unterstützt: Beitragsformate Bildgalerie und Video
	add_theme_support( 'post-formats', array( 'gallery', 'video' ) );

    // Theme unterstützt: Vorschaubilder für Beiträge
	add_theme_support( 'post-thumbnails' );
    set_post_thumbnail_size( 160, 90 );
*/
	// Navigationsmenüs registrieren
	register_nav_menu( 'primary', __( 'Primäre Navigation', 'mdb-congressomat' ) );
}



/**
 * (Ent-)Lädt eine Reihe von notwendigen JS-Scripts und Stylesheets.
 *
 * @since 0.0.1
 */

function mdb_enqueue_scripts()
{
	// jQuery in den Footer verlegen
    wp_deregister_script( 'jquery' );
    wp_register_script( 'jquery', '/wp-includes/js/jquery/jquery.js', false, false, true );
    wp_enqueue_script( 'jquery' );

    // Eigene Scripts laden
	//wp_enqueue_script( 'mdb-congressomat', PATH_THEME_URL . '/js/mdb-theme.js', 'jquery', false, true );

	// Eigenes Stylesheet in komprimierter Form laden
	wp_enqueue_style( 'mdb-congressomat', PATH_THEME_URL . '/assets/stylesheets/style.min.css' );
}
