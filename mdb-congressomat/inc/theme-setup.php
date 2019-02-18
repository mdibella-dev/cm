<?php
/**
 * Hauptfunktion zum Einrichten der von diesem Thema unterstützten Optionen
 *
 * @author  Marco Di Bella <mdb@marcodibella.de>
 * @package mdb-congressomat
 **/



/**
 * Führt grundlegende Einstellungen für das Thema durch.
 *
 * @since 1.0.0
 **/

 function mdb_theme_setup()
 {
    // Theme unterstützt: Lokalisation
	load_theme_textdomain( TEXT_DOMAIN, PATH_THEME_TEMPLATE . '/lang' );

    // Theme unterstützt: Betragsbilder
    add_theme_support( 'post-thumbnails' );

	// Menüs registrieren
	register_nav_menu( 'primary', __( 'Primäre Navigation', TEXT_DOMAIN ) );
}



/**
 * (Ent-)Lädt eine Reihe von notwendigen JS-Scripts und Stylesheets.
 *
 * @since 1.0.0
 **/

function mdb_enqueue_scripts()
{
	// jQuery in den Footer verlegen
    wp_deregister_script( 'jquery' );
    wp_register_script( 'jquery', '/wp-includes/js/jquery/jquery.js', FALSE, FALSE, TRUE );
    wp_enqueue_script( 'jquery' );

    // FontAwesome5 integrieren
	wp_enqueue_style( 'fontawesome', PATH_THEME_URL . '/assets/fa5/css/fontawesome-all.min.css' );

    // Eigene Scripts laden
    wp_register_script( 'mdb-congressomat', PATH_THEME_URL . '/assets/js/frontend.js', array( 'jquery' ), FALSE, TRUE );
	wp_enqueue_script( 'mdb-congressomat' );

	// Eigenes Stylesheet in komprimierter Form laden
	wp_enqueue_style( 'mdb-congressomat', PATH_THEME_URL . '/assets/css/frontend.min.css' );
}
