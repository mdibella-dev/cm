<?php
/**
 * Snippets
 *
 * @since   1.0.0
 * @author  Marco Di Bella <mdb@marcodibella.de>
 * @package congressomat
 */



/**
 * Setzt die Länge des Excerpts
 *
 * @since 	1.0.0
 * @param	int		$length
 */

function congressomat_excerpt_length( $length )
{
	return 30;
}

add_filter( 'excerpt_length', 'congressomat_excerpt_length', 999 );
