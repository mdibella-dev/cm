<?php
/**
 * Liste aller hookbasierten Funktionen und Aktionen
 *
 * @author  Marco Di Bella <mdb@marcodibella.de>
 * @package mdb-congressomat
 * @since   0.0.1
 * @version 0.0.1
 */


// theme-setup.php
add_action( 'after_setup_theme', 'mdb_theme_setup' );
add_action( 'wp_enqueue_scripts', 'mdb_enqueue_scripts', 9999 );


// theme-performance.php
add_action( 'wp_enqueue_scripts', 'mdb_remove_styles_scripts', 9998 );
add_filter( 'script_loader_src', 'mdb_remove_script_version', 15, 1 );
add_filter( 'style_loader_src', 'mdb_remove_script_version', 15, 1 );
add_filter( 'post_thumbnail_html', 'mdb_remove_thumbnail_width_height', 10, 5 );
add_filter( 'post_class', 'mdb_remove_post_classes', 10, 3 );

/*
// post-type-vortrag.php
add_action( 'acf/input/admin_head', 'vortrag_admin_head' );
add_action( 'pre_get_posts', 'vortrag_pre_get_posts', 1 );
add_action( 'manage_vortrag_posts_custom_column', 'vortrag_manage_posts_custom_column', 10, 2 );
add_filter( 'manage_vortrag_posts_columns', 'vortrag_manage_posts_columns', 10 );
//add_filter( 'manage_vortrag_sortable_columns', 'vortrag_manage_sortable_columns' );
add_filter( 'manage_edit-vortrag_sortable_columns', 'vortrag_manage_sortable_columns' );
*/
