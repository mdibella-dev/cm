<?php
/**
 * Backend
 *
 * @author  Marco Di Bella
 * @package cm
 */


/** Prevent direct access */

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



/**
 * Versteckt standardmäßig diverse Spalten in der Adminübersicht
 *
 * @since 2.5.0
 */

function cm_default_hidden_columns( $hidden, $screen )
{
    if( isset( $screen->id ) ) :
        switch( $screen->id ) :

            case 'edit-event' :
                $hidden[] = 'slug' ;
            break;

            case 'edit-location' :
            case 'edit-partnership' :
            case 'edit-exhibition_package' :
                $hidden[] = 'description';
                $hidden[] = 'slug';
            break;

        endswitch;
    endif;

    return $hidden;
}

add_filter( 'default_hidden_columns', 'cm_default_hidden_columns', 10, 2 );



/**
 * Erzeugt angepasste Seitentitel in der Adminübersicht.
 *
 * @since 2.5.0
 * @see   https://stackoverflow.com/questions/22261284/add-button-link-immediately-after-title-to-custom-post-type-edit-screen
 */

function mdb_rewrite_header()
{
    $screen    = get_current_screen();
    $do_modify = false;
    $term      = false;

    if( isset( $_GET['post_type'] ) and isset( $screen->id ) ) :
        switch( $screen->id ) :
            case 'edit-session':  // event // location
                if( isset( $_GET['location'] ) ) :
                    $term = get_term_by( 'slug', $_GET['location'], 'location' );
                elseif( isset( $_GET['event'] ) ) :
                    $term = get_term_by( 'slug', $_GET['event'], 'event' );
                endif;

                if( false !== $term ) :
                    $do_modify = true;
                    $title     = __( 'Programmpunkte', 'cm' );
                    $subtitle  = $term->name;
                endif;
            break;

            case 'edit-partner':
                if( isset( $_GET['partnership'] ) ) :
                    $term = get_term_by( 'slug', $_GET['partnership'], 'partnership' );
                endif;

                if( false !== $term ) :
                    $do_modify = true;
                    $title     = __( 'Kooperationspartner', 'cm' );
                    $subtitle  = $term->name;
                endif;
            break;

            case 'edit-exhibition_space':
                if( isset( $_GET['location'] ) ) :
                    $term = get_term_by( 'slug', $_GET['location'], 'location' );
                elseif( isset( $_GET['exhibition_package'] ) ) :
                    $term = get_term_by( 'slug', $_GET['exhibition_package'], 'exhibition_package' );
                endif;

                if( false !== $term ) :
                    $do_modify = true;
                    $title     = __( 'Ausstellungsflächen', 'cm' );
                    $subtitle  = $term->name;
                endif;
            break;

        endswitch;
    endif;

    if( $do_modify ) :
     ?>
<div class="wrap">
    <h1 class="wp-heading-inline show" style="display:inline-block;"><?php echo $title . ' (' . $subtitle . ')';?></h1>
     <a href="<?php echo admin_url( 'post-new.php?post_type=' . $_GET['post_type'] ); ?>" class="page-title-action show"><?php echo __( 'Erstellen', 'cm' );?></a>
</div>
<style id="modify">
    .wp-heading-inline:not(.show), .page-title-action:not(.show) { display:none !important;}
</style>
<?php
    endif;
 }

 add_action( 'admin_notices', 'mdb_rewrite_header' );
