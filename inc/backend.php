<?php
/**
 * Backend
 *
 * @author  Marco Di Bella <mdb@marcodibella.de>
 * @package mdb-congressomat
 **/



/**
 * Entfernt diverse Menüeinträge, um Usability zu erhöhen
 *
 * @since 	2.0.0
 **/

function mdb_ajust_admin_menu()
{
	$page = remove_submenu_page( 'edit.php?post_type=session', 'post-new.php?post_type=session' );
	$page = remove_submenu_page( 'edit.php?post_type=partner', 'post-new.php?post_type=partner' );
}



/**
 * Fügt ein JS-Script hinzu, um diverse Standard-Eingabefelder von WordPress in eine neue Maske (ACF) zu verschieben
 *
 * @source http://www.advancedcustomfields.com/resources/moving-wp-elements-content-editor-within-acf-fields/
 * @since 2.0
 */

function mdb_adjust_acf_dialog()
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
