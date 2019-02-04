<?php
/**
 * Snippets
 *
 * @author  Marco Di Bella <mdb@marcodibella.de>
 * @package mdb-theme
 **/



/**
 * Setzt die Länge des Excerpts
 *
 * @since 1.0.0
 **/

function mdb_excerpt_length( $length )
{
	return 30;
}



/**
 * Entfernt das Hellip am Ende des Excerpts
 *
 * @since 1.0.0
 **/

function mdb_excerpt_more( $more )
{
	return '...';
}
