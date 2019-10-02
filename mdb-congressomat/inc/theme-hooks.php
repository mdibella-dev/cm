<?php
/**
 * Liste aller hookbasierten Funktionen und Aktionen
 *
 * @author  Marco Di Bella <mdb@marcodibella.de>
 * @package mdb-congressomat
 **/



// theme-setup.php
add_action( 'after_setup_theme', 'mdb_theme_setup' );
add_action( 'wp_enqueue_scripts', 'mdb_enqueue_scripts', 9990 );


// theme-performance.php
add_action( 'wp_enqueue_scripts', 'mdb_remove_styles_scripts', 9985 );
add_filter( 'script_loader_src', 'mdb_remove_script_version', 15, 1 );
add_filter( 'style_loader_src', 'mdb_remove_script_version', 15, 1 );
add_filter( 'post_thumbnail_html', 'mdb_remove_thumbnail_width_height', 10, 5 );
add_filter( 'post_class', 'mdb_remove_post_classes', 10, 3 );


// theme-gutenberg.php
add_filter( 'gutenberg_can_edit_post_type', 'mdb_disable_block_editor' );
add_filter( 'use_block_editor_for_post_type', 'mdb_disable_block_editor', 10, 2);
add_action( 'enqueue_block_editor_assets', 'mdb_add_block_editor_assets' );


// snippets.php
add_filter( 'excerpt_length', 'mdb_excerpt_length', 999 );
add_filter( 'excerpt_more', 'mdb_excerpt_more' );
add_filter( 'the_content' , 'mdb_special_replacements' , 12);
add_filter( 'the_title', 'mdb_special_replacements', 12 );
add_filter( 'the_title_rss', 'mdb_special_replacements', 12 );
add_filter( 'the_content_feed', 'mdb_special_replacements', 12 );
