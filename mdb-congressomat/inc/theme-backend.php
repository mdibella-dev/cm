<?php
/**
 * Modifikationen für das Backend
 *
 * @author  Marco Di Bella <mdb@marcodibella.de>
 * @package mdb-theme
 **/



/**
 * Lädt die Datei backend.min.css mit diversen Style-Modifikationen für den Administrationsbereich
 *
 * @since 1.0.0
 **/

function mdb_admin_head()
{
    echo '<link rel="stylesheet" href="'. PATH_THEME_URL . '/assets/stylesheets/backend.min.css" type="text/css" media="all" />';
}



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
/*
    if( ( $post_type == 'vortrag' ) or
        ( $post_type == 'publikation' ) or
        ( $post_type == 'page' ) ) :
        return false;
    endif;
*/
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
    wp_enqueue_style( 'gutenberg-css', PATH_THEME_URL . '/assets/stylesheets/gutenberg.min.css' );
}
