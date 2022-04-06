<?php
/**
 * Taxonomy Exhibition_Package (Ausstellungspaket)
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

function cm_set_exhibition_package_columns( $default )
{
    $columns = array(
        'cb'            => $default['cb'],
        'id'            => 'ID',
        'name'          => $default['name'],
        'description'   => $default['description'],
        'slug'          => $default['slug'],
        'posts'         => __( 'Anzahl', 'cm' ),
    );
    return $columns;
}
add_filter( 'manage_edit-exhibition_package_columns', 'cm_set_exhibition_package_columns' );



/**
 * Bestimmt den Inhalt der Spalten in der Taxonomy-Liste
 *
 * @since 2.5.0
 */

function cm_manage_exhibition_package_custom_column( $content, $column_name, $term_id )
{
    switch ($column_name) {
        case 'id':
            $content = $term_id;
        break;

        default:
        break;
    }
    return $content;
}
add_filter( 'manage_exhibition_package_custom_column', 'cm_manage_exhibition_package_custom_column', 10, 3 );
