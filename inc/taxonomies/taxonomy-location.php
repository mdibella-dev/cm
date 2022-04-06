<?php
/**
 * Taxonomy Location (Örtlichkeiten)
 *
 * @author  Marco Di Bella <mdb@marcodibella.de>
 * @package cm
 */


defined( 'ABSPATH' ) or exit;



/**
 * Bestimmt die Spalten in der Taxonomy-Liste
 *
 * @since 2.5.0
 */

function cm_set_location_columns( $default )
{
    $columns = array(
        'cb'            => $default['cb'],
        'id'            => 'ID',
        'image'         => __( 'Bild', 'cm' ),
        'name'          => $default['name'],
        'description'   => $default['description'],
        'slug'          => $default['slug'],
        'posts'         => __( 'Anzahl', 'cm' ),
    );
    return $columns;
}
add_filter( 'manage_edit-location_columns', 'cm_set_location_columns' );



/**
 * Bestimmt den Inhalt der Spalten in der Taxonomy-Liste
 *
 * @since 2.5.0
 */

function cm_manage_location_custom_column( $content, $column_name, $term_id )
{
    switch ($column_name) {
        case 'id':
            $content = $term_id;
        break;

        case 'image':
            $image_id = get_field( 'location-image', 'location_' . $term_id );
            $image    = wp_get_attachment_image( $image_id, array( '150', '9999' ) );

            if( ! empty( $image ) ) :
                echo $image;
            else :
                echo '&mdash;';
            endif;
        break;

        default:
        break;
    }
    return $content;
}
add_filter( 'manage_location_custom_column', 'cm_manage_location_custom_column', 10, 3 );
