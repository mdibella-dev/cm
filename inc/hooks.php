<?php
/**
 * Liste aller hookbasierten Funktionen und Aktionen
 *
 * @author  Marco Di Bella <mdb@marcodibella.de>
 * @package congressomat
 **/



// setup.php
add_action( 'after_setup_theme', 'congressomat_theme_setup' );
add_action( 'wp_enqueue_scripts', 'congressomat_enqueue_scripts', 9990 );


// performance.php
add_action( 'wp_enqueue_scripts', 'congressomat_remove_styles_scripts', 9985 );
add_filter( 'script_loader_src', 'congressomat_remove_script_version', 15, 1 );
add_filter( 'style_loader_src', 'congressomat_remove_script_version', 15, 1 );
add_filter( 'post_thumbnail_html', 'congressomat_remove_thumbnail_width_height', 10, 5 );
add_filter( 'post_class', 'congressomat_remove_post_classes', 10, 3 );


// block-editor.php
add_filter( 'gutenberg_can_edit_post_type', 'congressomat_disable_block_editor' );
add_filter( 'use_block_editor_for_post_type', 'congressomat_disable_block_editor', 10, 2);
add_action( 'enqueue_block_editor_assets', 'congressomat_add_block_editor_assets' );


// snippets.php
add_filter( 'excerpt_length', 'congressomat_excerpt_length', 999 );
add_filter( 'excerpt_more', 'congressomat_excerpt_more' );
add_filter( 'the_content' , 'congressomat_special_replacements' , 12);
add_filter( 'the_title', 'congressomat_special_replacements', 12 );
add_filter( 'the_title_rss', 'congressomat_special_replacements', 12 );
add_filter( 'the_content_feed', 'congressomat_special_replacements', 12 );


// backend.php
add_action( 'admin_menu', 'congressomat_ajust_admin_menu', 999 );
add_action( 'acf/input/admin_head', 'congressomat_adjust_acf_dialog' );
