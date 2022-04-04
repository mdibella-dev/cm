<?php
/**
 * Snippets
 *
 * @author  Marco Di Bella <mdb@marcodibella.de>
 * @package congressomat
 */


defined( 'ABSPATH' ) or exit;



/**
 * Setzt die Länge des Excerpts
 *
 * @since 	1.0.0
 * @param	int		$length
 */

function cm_excerpt_length( $length )
{
	return 30;
}

add_filter( 'excerpt_length', 'cm_excerpt_length', 999 );
