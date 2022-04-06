<?php
/**
 * Post Type Speaker (Referent)
 *
 * @author  Marco Di Bella <mdb@marcodibella.de>
 * @package cm
 */


defined( 'ABSPATH' ) or exit;



/**
 * Bestimmt die Spalten der Beitragsliste (Backend).
 *
 * @since  2.5.0
 * @param  array   $default    Die Standardvorgaben für Spalten.
 * @return $array              Ein assoziatives Array, in denen die zu verwendenden Spalten beschrieben werden.
 */

function cm_post_type_speaker__manage_posts_columns( $default )
{
    $columns['cb']               = $default['cb'];
    $columns['image']            = __( 'Bild', 'mdb' );
    $columns['title']            = __( 'Referent/in', 'mdb' );
    $columns['shortdescription'] = __( 'Kurzbeschreibung', 'mdb' );

    return $columns;
}

add_filter( 'manage_speaker_posts_columns', 'cm_post_type_speaker__manage_posts_columns', 10 );



/**
 * Erzeugt die Ausgabe der Spalten.
 *
 * @since 2.5.0
 * @param string $column_name    Bezeichnung der auszugebenden Spalte.
 * @param int    $post_id        ID des Beitrags (aka Datensatzes) den auszugeben gilt.
 */

function cm_post_type_speaker__manage_posts_custom_column( $column_name, $post_id )
{
    switch( $column_name ) :

        case 'image':
            if( true === has_post_thumbnail( $post_id ) ) :
                // alternativ: admin_url?
                echo sprintf(
                    '<a href="/wp-admin/post.php?post=%1$s&action=edit" title="%3$s">%2$s</a>',
                    $post_id,
                    get_the_post_thumbnail( $post_id, array( 100, 0 ) ),
                    __( 'Bearbeiten', 'cm' )
                );
            endif;
        break;

        case 'shortdescription':
            echo trim( implode( ' ', array(
                get_field( 'referent-titel', $post_id ),
                get_field( 'referent-vorname', $post_id ),
                get_field( 'referent-nachname', $post_id ),
            ) ) );

            $position = get_field( 'referent-position', $post_id );

            if( ! empty( $position ) ) :
                echo '<br>' . $position;
            endif;
        break;

    endswitch;
}

add_action( 'manage_speaker_posts_custom_column', 'cm_post_type_speaker__manage_posts_custom_column', 9999, 2 );
