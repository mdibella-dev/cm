<?php
/**
 * Backend
 *
 * @author  Marco Di Bella <mdb@marcodibella.de>
 * @package cm
 */


defined( 'ABSPATH' ) or exit;



/**
 * Erstellt das CM-Menü
 * Hinweis: Menüpunkte für Posttypes werden bei deren Registrierung erzeugt
 *
 * @since 2.3.0
 */

function cm_admin_menu()
{
    $admin_menu_slug = 'edit.php?post_type=session';

    add_menu_page(
        __( 'Congress-Management', 'cm' ),
        __( 'Congress-Management', 'cm' ),
        'manage_options',
        $admin_menu_slug,
        '',
        'dashicons-groups',
        20,
    );

    add_submenu_page(
        $admin_menu_slug,
        __( 'Veranstaltungen', 'cm' ),
        __( 'Veranstaltungen', 'cm' ),
        'manage_options',
        'edit-tags.php?taxonomy=event&post_type=session',
        '',
        0,
    );

    add_submenu_page(
        $admin_menu_slug,
        __( 'Örtlichkeiten', 'cm' ),
        __( 'Örtlichkeiten', 'cm' ),
        'manage_options',
        'edit-tags.php?taxonomy=location&post_type=session',
        '',
        0,
    );

    add_submenu_page(
        $admin_menu_slug,
        __( 'Kooperationsformen', 'cm' ),
        __( 'Kooperationsformen', 'cm' ),
        'manage_options',
        'edit-tags.php?taxonomy=partnership&post_type=session',
        '',
        0,
    );

    add_submenu_page(
        $admin_menu_slug,
        __( 'Ausstellungspakete', 'cm' ),
        __( 'Ausstellungspakete', 'cm' ),
        'manage_options',
        'edit-tags.php?taxonomy=exhibition_package&post_type=session',
        '',
        0,
    );
}

add_action( 'admin_menu', 'cm_admin_menu', 999 );



/**
 * Sortiert das Congressomat-Menü
 *
 * @since 2.3.0
 */

function cm_admin_menu_order( $menu_order )
{
    global $submenu;
           $admin_menu_slug = 'edit.php?post_type=session';
           $sorted          = array();

    $sort_order = array(
        'Veranstaltungen',
        'Örtlichkeiten',
        'Referenten',
        'Programmpunkte',
        'Kooperationspartner',
        'Kooperationsformen',
        'Ausstellungsflächen',
        'Ausstellungspakete',
    );

    for( $i = 0; $i != sizeof( $sort_order ); $i++ ) :
        foreach( $submenu[ $admin_menu_slug ] as $submenu_item ) :
            if( $submenu_item[0] == $sort_order[ $i ]) :
                $sorted[] = $submenu_item;
                break;
            endif;
        endforeach;
    endfor;

    $submenu[ $admin_menu_slug ] = $sorted;

    return $menu_order;
}

add_filter( 'custom_menu_order', '__return_true' );
add_filter( 'menu_order', 'cm_admin_menu_order' );




/**
 * Fügt ein JS-Script hinzu, um diverse Standard-Eingabefelder von WordPress in eine neue Maske (ACF) zu verschieben
 *
 * @since 2.0.0
 * @see   http://www.advancedcustomfields.com/resources/moving-wp-elements-content-editor-within-acf-fields/
 */

function cm_adjust_acf_dialog()
{
?>
<script type="text/javascript">
    (function($) {
        $(document).ready(function(){
<?php /* -- CPT Session -- */ ?>
            $('.acf-field-5d81eec13261d .acf-input').append( $('#title') );
            $( '#title-prompt-text' ).remove();
        });
    })(jQuery);
</script>
<?php
}

add_action( 'acf/input/admin_head', 'cm_adjust_acf_dialog' );
