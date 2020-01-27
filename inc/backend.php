<?php
/**
 * Backend
 *
 * @author  Marco Di Bella <mdb@marcodibella.de>
 * @package mdb-congressomat
 **/



/**
 * Setzt die Länge des Excerpts
 *
 * @since 	2.0.0
 **/

function mdb_ajust_admin_menu()
{
	$page = remove_submenu_page( 'edit.php?post_type=session', 'post-new.php?post_type=session' );
	$page = remove_submenu_page( 'edit.php?post_type=partner', 'post-new.php?post_type=partner' );
}
