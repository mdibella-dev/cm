<?php
/**
 * Backend
 *
 * @author  Marco Di Bella <mdb@marcodibella.de>
 * @package congressomat
 **/




/**
 * Erstellt das Congressomat-Menü
 * Hinweis: Menüpunkte für Posttypes werden bei deren Registrierung erzeugt
 *
 * @since 	2.3.0
 **/

function congressomat_admin_menu()
{
	$admin_menu_slug = 'edit.php?post_type=session';

	add_menu_page(
		__( 'Congressomat', 'congressomat' ),
		__( 'Congressomat', 'congressomat' ),
		'manage_options',
		$admin_menu_slug,
		'',
		'dashicons-universal-access',
		20,
	);

	add_submenu_page(
		$admin_menu_slug,
		__( 'Veranstaltungen', 'congressomat' ),
		__( 'Veranstaltungen', 'congressomat' ),
		'manage_options',
		'edit-tags.php?taxonomy=event&post_type=session',
		'',
		0,
	);

	add_submenu_page(
		$admin_menu_slug,
		__( 'Örtlichkeiten', 'congressomat' ),
		__( 'Örtlichkeiten', 'congressomat' ),
		'manage_options',
		'edit-tags.php?taxonomy=location&post_type=session',
		'',
		0,
	);

	add_submenu_page(
		$admin_menu_slug,
		__( 'Kooperationsformen', 'congressomat' ),
		__( 'Kooperationsformen', 'congressomat' ),
		'manage_options',
		'edit-tags.php?taxonomy=partnership&post_type=session',
		'',
		0,
	);

	add_submenu_page(
		$admin_menu_slug,
		__( 'Ausstellungspakete', 'congressomat' ),
		__( 'Ausstellungspakete', 'congressomat' ),
		'manage_options',
		'edit-tags.php?taxonomy=exhibition_package&post_type=session',
		'',
		0,
	);
}

add_action( 'admin_menu', 'congressomat_admin_menu', 999 );



/**
 * Sortiert das Congressomat-Menü
 *
 * @since 	2.3.0
 **/

function congressomat_admin_menu_order( $menu_order )
{
	global $submenu;
		   $admin_menu_slug = 'edit.php?post_type=session';
		   $sorted    		= array();


	foreach( $submenu[ $admin_menu_slug ] as $submenu_item ) :
		$sorted[ $submenu_item[0] ] = $submenu_item;
	endforeach;

	ksort( $sorted );

	$submenu[ $admin_menu_slug ] = $sorted;

	return $menu_order;
}

add_filter( 'custom_menu_order', '__return_true' );
add_filter( 'menu_order', 'congressomat_admin_menu_order' );




/**
 * Fügt ein JS-Script hinzu, um diverse Standard-Eingabefelder von WordPress in eine neue Maske (ACF) zu verschieben
 *
 * @since 2.0.0
 * @source http://www.advancedcustomfields.com/resources/moving-wp-elements-content-editor-within-acf-fields/
 */

function congressomat_adjust_acf_dialog()
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

add_action( 'acf/input/admin_head', 'congressomat_adjust_acf_dialog' );
