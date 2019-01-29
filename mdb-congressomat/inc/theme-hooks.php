<?php
/**
 * Liste aller hookbasierten Funktionen und Aktionen
 *
 * @author  Marco Di Bella <mdb@marcodibella.de>
 * @package mdb-congressomat
 **/



// theme-setup.php
add_action( 'after_setup_theme', 'mdb_theme_setup' );
add_action( 'wp_enqueue_scripts', 'mdb_enqueue_scripts', 9999 );


// theme-performance.php
add_action( 'wp_enqueue_scripts', 'mdb_remove_styles_scripts', 9998 );
add_filter( 'script_loader_src', 'mdb_remove_script_version', 15, 1 );
add_filter( 'style_loader_src', 'mdb_remove_script_version', 15, 1 );
add_filter( 'post_thumbnail_html', 'mdb_remove_thumbnail_width_height', 10, 5 );
add_filter( 'post_class', 'mdb_remove_post_classes', 10, 3 );


// theme-backend.php
add_action( 'admin_head', 'mdb_admin_head' );
add_filter( 'gutenberg_can_edit_post_type', 'mdb_disable_gutenberg' );
add_action( 'enqueue_block_editor_assets', 'mdb_add_gutenberg_styles' );
