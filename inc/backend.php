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
		'data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0idXRmLTgiIHN0YW5kYWxvbmU9InllcyI/PjwhLS0gR2VuZXJhdG9yOiBBZG9iZSBJbGx1c3RyYXRvciAyNC4yLjMsIFNWRyBFeHBvcnQgUGx1Zy1JbiAuIFNWRyBWZXJzaW9uOiA2LjAwIEJ1aWxkIDApICAtLT48c3ZnIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyIgeG1sbnM6eGxpbms9Imh0dHA6Ly93d3cudzMub3JnLzE5OTkveGxpbmsiIHN0eWxlPSJ6b29tOiAxOyIgdmlld0JveD0iMCAwIDE1LjYgMTguOSI+PHBvbHlnb24gcG9pbnRzPSIxLjgyNDUsMS43IDEzLjYyNDUwMSwxLjcgMTMuNjI0NTAxLDMuMSAxLjgyNDUsMy4xICI+PC9wb2x5Z29uPjxwYXRoIGZpbGw9Im5vbmUiIHN0cm9rZT0iIzAwMDAwMCIgc3Ryb2tlLXdpZHRoPSIwLjUiIHN0cm9rZS1taXRlcmxpbWl0PSIxMCIgZD0iTTYuOCwxMS44SDYuMmMtMC4yLTAuMy0wLjUtMC41LTAuOC0wLjUgYy0wLjMsMC0wLjcsMC4yLTAuOCwwLjVIMy45Yy0wLjMsMC0wLjUsMC4yLTAuNSwwLjVzMC4yLDAuNSwwLjUsMC41bDAsMGgwLjZjMC4yLDAuMywwLjUsMC41LDAuOCwwLjVjMC4zLDAsMC43LTAuMiwwLjgtMC41aDAuNiBjMC4zLDAsMC41LTAuMiwwLjUtMC41UzcsMTEuOCw2LjgsMTEuOHoiPjwvcGF0aD48cGF0aCBkPSJNMi4yLDMuM3YxMy4yaDExLjJWMy4zSDIuMnogTTksNWgyLjd2NC41SDlWNXogTTQsNWgyLjd2NC41SDRWNXogTTUuMywxMy43Yy0wLjgsMC0xLjQtMC42LTEuNC0xLjRzMC42LTEuNCwxLjQtMS40IHMxLjQsMC42LDEuNCwxLjRTNi4xLDEzLjcsNS4zLDEzLjd6IE0xMC4zLDEzLjdjLTAuOCwwLTEuNC0wLjYtMS40LTEuNHMwLjYtMS40LDEuNC0xLjRzMS40LDAuNiwxLjQsMS40UzExLjEsMTMuNywxMC4zLDEzLjd6Ij48L3BhdGg+PHBhdGggZmlsbD0ibm9uZSIgc3Ryb2tlPSIjMDAwMDAwIiBzdHJva2Utd2lkdGg9IjAuNSIgc3Ryb2tlLW1pdGVybGltaXQ9IjEwIiBkPSJNMTEuNSwxMS4zbC0wLjUsMC4yYy0wLjQtMC4zLTEuMS0wLjMtMS40LDAuMiBjLTAuMSwwLjEtMC4yLDAuMy0wLjIsMC40bC0wLjUsMC4yYy0wLjIsMC4xLTAuNCwwLjQtMC4zLDAuNmMwLDAsMCwwLDAsMGMwLjEsMC4zLDAuNCwwLjQsMC42LDAuM0w5LjcsMTNjMC4zLDAuMiwwLjcsMC4zLDEsMC4yIGMwLjMtMC4xLDAuNi0wLjQsMC42LTAuOGwwLjUtMC4yYzAuMy0wLjEsMC40LTAuNCwwLjMtMC42UzExLjgsMTEuMiwxMS41LDExLjNMMTEuNSwxMS4zeiI+PC9wYXRoPjwvc3ZnPg==',
		20,
	);

	add_submenu_page(
		$admin_menu_slug,
		__( 'Veranstaltungen', 'congressomat' ),
		__( 'Veranstaltungen', 'congressomat' ),
		'manage_options',
		'edit-tags.php?taxonomy=event&post_type=session',
		'',
		'',
	);

	add_submenu_page(
		$admin_menu_slug,
		__( 'Örtlichkeiten', 'congressomat' ),
		__( 'Örtlichkeiten', 'congressomat' ),
		'manage_options',
		'edit-tags.php?taxonomy=location&post_type=session',
		'',
		'',
	);

	add_submenu_page(
		$admin_menu_slug,
		__( 'Kooperationsformen', 'congressomat' ),
		__( 'Kooperationsformen', 'congressomat' ),
		'manage_options',
		'edit-tags.php?taxonomy=partnership&post_type=session',
		'',
		'',
	);

	add_submenu_page(
		$admin_menu_slug,
		__( 'Ausstellungspakete', 'congressomat' ),
		__( 'Ausstellungspakete', 'congressomat' ),
		'manage_options',
		'edit-tags.php?taxonomy=exhibition_package&post_type=session',
		'',
		'',
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

	/** @todo: Internationalisierung **/

	$sort_order = array(
		'Programmpunkte',
		'Veranstaltungen',
		'Örtlichkeiten',
		'Referenten',
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
