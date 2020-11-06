<?php
/**
 * Initialisiert das Thema und stellt eine Reihe von Zusatzfunktionen bereit
 *
 * @since   1.0.0
 * @author  Marco Di Bella <mdb@marcodibella.de>
 * @package congressomat
 */


defined( 'ABSPATH' ) OR exit;


/* Notices ausschalten */

error_reporting( E_ALL ^ E_NOTICE );


/* Konstanten */

/*
 * Soziale Netze
 */

define( 'SOCIAL_MEDIA', array(
    '1' => array(
        'name' => 'Facebook',
        'icon' => 'fab fa-facebook-f',
    ),
    '2' => array(
        'name' => 'Twitter',
        'icon' =>'fab fa-twitter',
    ),
    '3' => array(
        'name' => 'Instagram',
        'icon' => 'fab fa-instagram',
    ),
    '4' => array(
        'name' => 'YouTube',
        'icon' => 'fab fa-youtube',
    ),
    '5' => array(
        'name' => 'XING',
        'icon' => 'fab fa-xing',
    ),
    '6' => array(
        'name' => 'LinkedIn',
        'icon' => 'fab fa-linkedin-in',
    ),
) );


/*
 * Vorkonfigurierte Sets für Eventtabellen;
 * a = linke Spalte mit Orts- und Zeitangaben;
 * b = mittlere Spalte mit Titel etc.
 */

define( 'EVENT_TABLE_SETLIST', array(
    '1' => array(
        'a' => 'session-date,session-time-range,session-location',
        'b' => 'session-title,session-subtitle',
    ),
    '2' => array(
        'a' => 'session-time-begin,session-location',
        'b' => 'session-title,session-subtitle,session-speaker',
    ),
    '3' => array(
        'a' => 'session-time-range',
        'b' => 'session-title,session-subtitle,session-speaker',
    ),
    '4' => array(
        'a' => 'session-date,session-time-range',
        'b' => 'session-title,session-subtitle',
    ),
) );



/* Funktionsbibliothek einbinden */

require_once( get_template_directory() . '/inc/setup.php' );
require_once( get_template_directory() . '/inc/block-editor.php' );
require_once( get_template_directory() . '/inc/backend.php' );
require_once( get_template_directory() . '/inc/performance.php' );
require_once( get_template_directory() . '/inc/snippets.php' );
require_once( get_template_directory() . '/inc/core.php' );
require_once( get_template_directory() . '/inc/shortcodes/shortcode-event-table.php' );
require_once( get_template_directory() . '/inc/shortcodes/shortcode-speaker-grid.php' );
require_once( get_template_directory() . '/inc/shortcodes/shortcode-teaser-list.php' );
require_once( get_template_directory() . '/inc/shortcodes/shortcode-partner-table.php' );
require_once( get_template_directory() . '/inc/shortcodes/shortcode-icon-wall.php' );
require_once( get_template_directory() . '/inc/shortcodes/shortcode-exhibition-list.php' );
require_once( get_template_directory() . '/inc/shortcodes/shortcode-faq.php' );
