<?php
/**
 * Block Editor (aka Gutenberg)
 *
 * @author  Marco Di Bella <mdb@marcodibella.de>
 * @package congressomat
 **/



/**
 * Block Editor für diverse Post Types deaktivieren
 *
 * @param   bool    $current_status
 * @param   string  $post_type
 * @source  https://digwp.com/2018/04/how-to-disable-gutenberg/
 * @source  https://stackoverflow.com/questions/52199629/how-to-disable-gutenberg-editor-for-certain-post-types/52199630
 * @source  https://www.billerickson.net/disabling-gutenberg-certain-templates/
 * @since   1.0.0
 **/

function cm_disable_block_editor( $current_status, $post_type )
{
    if( ( $post_type === 'session' ) or
        ( $post_type === 'exhibitor' ) or
        ( $post_type === 'speaker' ) ) :
        return FALSE;
    endif;

    return $current_status;
}



/**
 * Script- und Stil-Modifikationen für den Block Editor
 *
 * @source  https://die-netzialisten.de/wordpress/gutenberg-breite-des-editors-anpassen/
 * @source  https://www.billerickson.net/block-styles-in-gutenberg/
 * @since   1.0.0
 **/

function cm_add_block_editor_assets()
{
    wp_enqueue_style( 'block-editor', get_template_directory_uri() . '/assets/css/block-editor.min.css', false, 0, 'all' );
	wp_enqueue_script( 'block-editor', get_template_directory_uri() . '/assets/js/block-editor.js',
		               array( 'wp-blocks', 'wp-dom' ),
		               0, //filemtime( get_template_directory() . '/assets/js/block-editor.js' ),
		               true	);
}
