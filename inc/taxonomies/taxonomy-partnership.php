<?php
/**
 * Taxonomy Partnership (Kooperationsformen)
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

function cm_set_partnership_columns( $default )
{
    print_r( $default);
    $columns = array(
        'cb'            => $default['cb'],
        'id'            => 'ID',
        'name'          => $default['name'],
        'description'   => $default['description'],
        'slug'          => $default['slug'],
        'posts'         => $default['posts'],
    );
    return $columns;
}
add_filter( 'manage_edit-partnership_columns', 'cm_set_partnership_columns' );



/**
 * Bestimmt den Inhalt der Spalten in der Taxonomy-Liste
 *
 * @since 2.5.0
 */

function cm_manage_partnership_custom_column( $content, $column_name, $term_id )
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
add_filter( 'manage_partnership_custom_column', 'cm_manage_partnership_custom_column', 10, 3 );
