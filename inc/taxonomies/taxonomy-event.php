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
        'status'        => 'Status',
        'posts'         => 'Programmpunkte',
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



/**
 * Registriert die Taxonomy-
 *
 * @since 2.5.0
 */

function cm_register_taxonomy_event()
{
	$labels = [
		"name" => __( "Veranstaltungen", "cm" ),
		"singular_name" => __( "Veranstaltung", "cm" ),
		"menu_name" => __( "Veranstaltungen", "cm" ),
		"all_items" => __( "Alle Veranstaltungen", "cm" ),
		"edit_item" => __( "Veranstaltung bearbeiten", "cm" ),
		"view_item" => __( "Veranstaltung anzeigen", "cm" ),
		"update_item" => __( "Veranstaltungstitel aktualisieren", "cm" ),
		"add_new_item" => __( "Neue Veranstaltung hinzufügen", "cm" ),
		"new_item_name" => __( "Neuer Veranstaltungstitel", "cm" ),
		"parent_item" => __( "Übergeordnet Veranstaltung", "cm" ),
		"parent_item_colon" => __( "Übergeordnet Veranstaltung:", "cm" ),
		"search_items" => __( "Veranstaltungen durchsuchen", "cm" ),
		"popular_items" => __( "Beliebte Veranstaltungen", "cm" ),
		"separate_items_with_commas" => __( "Veranstaltungen mit Kommas trennen", "cm" ),
		"add_or_remove_items" => __( "Veranstaltungen hinzufügen oder entfernen", "cm" ),
		"choose_from_most_used" => __( "Aus den am häufigsten verwendeten Veranstaltungen auswählen", "cm" ),
		"not_found" => __( "Keine Veranstaltungen gefunden", "cm" ),
		"no_terms" => __( "Keien Veranstaltungen", "cm" ),
		"items_list_navigation" => __( "Navigation Veranstaltungsliste", "cm" ),
		"items_list" => __( "Veranstaltungsliste", "cm" ),
		"back_to_items" => __( "Zurück zu den Veranstaltungen", "cm" ),
	];

	$args = [
		"label" => __( "Veranstaltungen", "cm" ),
		"labels" => $labels,
		"public" => true,
		"publicly_queryable" => true,
		"hierarchical" => false,
		"show_ui" => true,
		"show_in_menu" => true,
		"show_in_nav_menus" => false,
		"query_var" => true,
		"rewrite" => [ 'slug' => 'event', 'with_front' => true, ],
		"show_admin_column" => true,
		"show_in_rest" => true,
		"show_tagcloud" => false,
		"rest_base" => "event",
		"rest_controller_class" => "WP_REST_Terms_Controller",
		"show_in_quick_edit" => false,
		"sort" => false,
		"show_in_graphql" => false,
	];
	register_taxonomy( "event", [ "session" ], $args );
}

add_action( 'init', 'cm_register_taxonomy_event' );
