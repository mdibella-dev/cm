<?php
/**
 * Snippets
 *
 * @author  Marco Di Bella <mdb@marcodibella.de>
 * @package congressomat
 **/



/**
 * Setzt die Länge des Excerpts
 *
 * @param	int		$length
 * @since 	1.0.0
 **/

function congressomat_excerpt_length( $length )
{
	return 30;
}

add_filter( 'excerpt_length', 'congressomat_excerpt_length', 999 );
