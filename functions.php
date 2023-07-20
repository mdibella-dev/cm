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



/** Variables and definitions **/

define( __NAMESPACE__ . "\THEME_VERSION", '2.6.0' );                          // The theme's version
define( __NAMESPACE__ . "\THEME_DIR", get_template_directory() . '/' );       // The theme's directory
define( __NAMESPACE__ . "\THEME_URI", get_template_directory_uri() .'/' );    // The theme's uri



/** Include files */

require_once( get_template_directory() . '/includes/setup.php' );
require_once( get_template_directory() . '/includes/performance.php' );
require_once( get_template_directory() . '/includes/shortcodes/index.php' );
