<?php
/**
 * Kern des Themas
 * Initialisiert das Thema und stellt eine Reihe von Zusatzfunktionen bereit
 *
 * @author  Marco Di Bella <mdb@marcodibella.de>
 * @package mdb-congressomat
 **/



// Notices ausschalten
error_reporting( E_ALL ^ E_NOTICE );


// Konstanten
define( 'PATH_THEME_URL',      get_template_directory_uri() );
define( 'PATH_THEME_TEMPLATE', get_template_directory() );


// Funktionsbibliothek einbinden
require_once( PATH_THEME_TEMPLATE . '/inc/theme-setup.php' );
require_once( PATH_THEME_TEMPLATE . '/inc/theme-performance.php' );
require_once( PATH_THEME_TEMPLATE . '/inc/theme-hooks.php' );
require_once( PATH_THEME_TEMPLATE . '/inc/session.php' );
