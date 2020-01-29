<?php
/**
 * Initialisiert das Thema und stellt eine Reihe von Zusatzfunktionen bereit
 *
 * @author  Marco Di Bella <mdb@marcodibella.de>
 * @package mdb-congressomat
 **/



// Notices ausschalten
error_reporting( E_ALL ^ E_NOTICE );



// Funktionsbibliothek einbinden
require_once( get_template_directory() . '/inc/setup.php' );
require_once( get_template_directory() . '/inc/hooks.php' );
require_once( get_template_directory() . '/inc/gutenberg.php' );
require_once( get_template_directory() . '/inc/performance.php' );
require_once( get_template_directory() . '/inc/widget-areas.php' );
require_once( get_template_directory() . '/inc/snippets.php' );
require_once( get_template_directory() . '/inc/backend.php' );
require_once( get_template_directory() . '/inc/core.php' );
require_once( get_template_directory() . '/inc/classes/class-megamenu-walker.php' );
require_once( get_template_directory() . '/inc/shortcodes/shortcode-event-table.php' );
require_once( get_template_directory() . '/inc/shortcodes/shortcode-speaker-grid.php' );
require_once( get_template_directory() . '/inc/shortcodes/shortcode-teaser-list.php' );
require_once( get_template_directory() . '/inc/shortcodes/shortcode-partner-table.php' );
require_once( get_template_directory() . '/inc/shortcodes/shortcode-partner-list.php' );
require_once( get_template_directory() . '/inc/shortcodes/shortcode-faq.php' );
