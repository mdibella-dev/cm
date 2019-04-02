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
define( 'TEXT_DOMAIN',         'mdb-congressomat' );


// Funktionsbibliothek einbinden
require_once( PATH_THEME_TEMPLATE . '/inc/theme-setup.php' );
require_once( PATH_THEME_TEMPLATE . '/inc/theme-hooks.php' );
require_once( PATH_THEME_TEMPLATE . '/inc/theme-backend.php' );
require_once( PATH_THEME_TEMPLATE . '/inc/theme-performance.php' );
require_once( PATH_THEME_TEMPLATE . '/inc/widget-areas.php' );
require_once( PATH_THEME_TEMPLATE . '/inc/snippets.php' );
require_once( PATH_THEME_TEMPLATE . '/inc/modules.php' );
require_once( PATH_THEME_TEMPLATE . '/inc/core.php' );
require_once( PATH_THEME_TEMPLATE . '/inc/classes/class-megamenu-walker.php' );
require_once( PATH_THEME_TEMPLATE . '/inc/shortcodes/shortcode-event-table.php' );
require_once( PATH_THEME_TEMPLATE . '/inc/shortcodes/shortcode-speaker-grid.php' );
require_once( PATH_THEME_TEMPLATE . '/inc/shortcodes/shortcode-teaser-list.php' );
require_once( PATH_THEME_TEMPLATE . '/inc/shortcodes/shortcode-partner-table.php' );
require_once( PATH_THEME_TEMPLATE . '/inc/shortcodes/shortcode-partner-list.php' );
require_once( PATH_THEME_TEMPLATE . '/inc/shortcodes/shortcode-faq.php' );
