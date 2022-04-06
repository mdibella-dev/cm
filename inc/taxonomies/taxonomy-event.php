<?php
/**
 * Taxonomy Event (Veranstaltung)
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

function cm_set_event_columns( $default )
{
    print_r( $default);
    $columns = array(
        'cb'            => $default['cb'],
        'id'            => 'ID',
        'name'          => $default['name'],
        'description'   => $default['description'],
        'slug'          => $default['slug'],
        'status'        => __( 'Status', 'cm' ),
        'posts'         => __( 'Programmpunkte', 'cm' ),
    );
    return $columns;
}
add_filter( 'manage_edit-event_columns', 'cm_set_event_columns' );



/**
 * Bestimmt den Inhalt der Spalten in der Taxonomy-Liste
 *
 * @since 2.5.0
 */

function cm_manage_event_custom_column( $content, $column_name, $term_id )
{
    switch ($column_name) {
        case 'id':
            $content = $term_id;
        break;

        case 'status':
            $status = get_field( 'event-status', 'term_' . $term_id );

            $content  = sprintf(
                '<span class="status-icon %1$s" title="%2$s"></span>',
                (1 == $status)? 'status-icon-active' : 'status-icon-inactive',
                (1 == $status)? __( 'aktiv', 'cm') : __( 'nicht aktiv', 'cm'),
            );
        break;

        default:
        break;
    }
    return $content;
}
add_filter( 'manage_event_custom_column', 'cm_manage_event_custom_column', 10, 3 );
