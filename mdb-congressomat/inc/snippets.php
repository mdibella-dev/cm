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



/**
 * Erzeugt eine korrekte deutsche Typografie
 *
 * @source https://reussmedia.de/wordpress-deutsche-anfuehrungszeichen/
 * @since  1.0.0
 **/

function mdb_special_replacements( $text )
{
    $text = str_replace( '&#8220;' , '&#8222;' , $text );
    $text = str_replace( '&#8221;' , '&#8220;' , $text );
    $text = str_replace( '&#8216;' , '&#8218;' , $text );
    $text = str_replace( '&#8217;' , '&#8216;' , $text );
	$text = str_replace( ' &#8208; ' , ' &ndash; ' , $text );
	$text = str_replace( ' &#45; ' , ' &ndash; ' , $text );

    return $text;
}
