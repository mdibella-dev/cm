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



/** Include files */

require_once( get_template_directory() . '/includes/setup.php' );
require_once( get_template_directory() . '/includes/performance.php' );
require_once( get_template_directory() . '/includes/shortcodes/index.php' );
