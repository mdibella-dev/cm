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

    // Eigene Scripts laden
	//wp_enqueue_script( 'mdb-congressomat', PATH_THEME_URL . '/js/mdb-theme.js', 'jquery', FALSE, TRUE );

	// Eigenes Stylesheet in komprimierter Form laden
	wp_enqueue_style( 'mdb-congressomat', PATH_THEME_URL . '/assets/stylesheets/frontend.min.css' );
}



/**
 * Lädt die Datei backend.min.css mit diversen Style-Modifikationen für den Administrationsbereich
 *
 * @since 1.0.0
 **/

function mdb_admin_head()
{
    echo '<link rel="stylesheet" href="'. PATH_THEME_URL . '/assets/stylesheets/backend.min.css" type="text/css" media="all" />';
}
