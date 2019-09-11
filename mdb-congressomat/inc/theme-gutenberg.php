<?php
/**
 * Modifikationen für den Gutenberg Block Editor
 *
 * @author  Marco Di Bella <mdb@marcodibella.de>
 * @package mdb-congressomat
 **/



/**
 * Deaktiviert Gutenberg für diverse Post Types
 *
 * @since  1.0.0
 * @source https://digwp.com/2018/04/how-to-disable-gutenberg/
 * @source https://stackoverflow.com/questions/52199629/how-to-disable-gutenberg-editor-for-certain-post-types/52199630
 * @source https://www.billerickson.net/disabling-gutenberg-certain-templates/
 **/

function mdb_disable_gutenberg( $current_status, $post_type )
{
    if( /*( $post_type === 'page' ) or */
        ( $post_type === 'session' ) or
        ( $post_type === 'exhibitor' ) or
        ( $post_type === 'speaker' ) ) :
        return FALSE;
    endif;

    return $current_status;
}



/**
 * Fügt Stil-Modifikationen für Gutenberg hinzu
 *
 * @since  1.0.0
 * @source https://die-netzialisten.de/wordpress/gutenberg-breite-des-editors-anpassen/
 **/

function mdb_add_gutenberg_styles()
{
    wp_enqueue_style( 'gutenberg-css', PATH_THEME_URL . '/assets/css/gutenberg.min.css' );
}
