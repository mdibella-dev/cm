<?php
/**
 * The theme's core file.
 *
 * @author  Marco Di Bella
 * @package cm
 */


/** Prevent direct access */

defined( 'ABSPATH' ) or exit;



/** Turn off notices */

error_reporting( E_ALL ^ E_NOTICE );



/** Set global constants */

define( 'THEME_VERSION', '3.0.0' );

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


// Preconfigured sets for event tables;
// a = left column with place and time information;
// b = middle column with title etc.

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



/** Include files */

require_once( get_template_directory() . '/includes/setup.php' );
require_once( get_template_directory() . '/includes/block-editor.php' );
require_once( get_template_directory() . '/includes/backend.php' );
require_once( get_template_directory() . '/includes/performance.php' );
require_once( get_template_directory() . '/includes/core.php' );

require_once( get_template_directory() . '/includes/taxonomies/index.php' );
require_once( get_template_directory() . '/includes/post-types/index.php' );
require_once( get_template_directory() . '/includes/shortcodes/index.php' );
