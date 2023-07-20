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

define( 'THEME_VERSION', '2.6.0' );

define( 'SOCIAL_MEDIA', [
    '1' => [
        'name' => 'Facebook',
        'icon' => 'fab fa-facebook-f',
    ],
    '2' => [
        'name' => 'Twitter',
        'icon' =>'fab fa-twitter',
    ],
    '3' => [
        'name' => 'Instagram',
        'icon' => 'fab fa-instagram',
    ],
    '4' => [
        'name' => 'YouTube',
        'icon' => 'fab fa-youtube',
    ],
    '5' => [
        'name' => 'XING',
        'icon' => 'fab fa-xing',
    ],
    '6' => [
        'name' => 'LinkedIn',
        'icon' => 'fab fa-linkedin-in',
    ],
] );



/** Include files */

require_once( get_template_directory() . '/includes/setup.php' );
require_once( get_template_directory() . '/includes/block-editor.php' );
require_once( get_template_directory() . '/includes/performance.php' );

require_once( get_template_directory() . '/includes/shortcodes/index.php' );
