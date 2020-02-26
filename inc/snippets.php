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



/**
 * Entfernt das Hellip am Ende des Excerpts
 *
 * @since 	1.0.0
 **/

function congressomat_excerpt_more( $more )
{
	return '...';
}

add_filter( 'excerpt_more', 'congressomat_excerpt_more' );



/**
 * Erzeugt eine korrekte deutsche Typografie
 *
 * @param	string	$text
 * @source 	https://reussmedia.de/wordpress-deutsche-anfuehrungszeichen/
 * @since  	1.0.0
 **/

function congressomat_special_replacements( $text )
{
	// Anführungsstriche
    $text = str_replace( '&#8220;' , '&#8222;' , $text );
    $text = str_replace( '&#8221;' , '&#8220;' , $text );
    $text = str_replace( '&#8216;' , '&#8218;' , $text );
    $text = str_replace( '&#8217;' , '&#8216;' , $text );

	// Gedankenstriche
	$text = str_replace( ' &#8208; ' , ' &ndash; ' , $text );
	$text = str_replace( ' &#45; ' , ' &ndash; ' , $text );

    return $text;
}

add_filter( 'the_title', 'congressomat_special_replacements', 12 );
add_filter( 'the_content' , 'congressomat_special_replacements' , 12);
add_filter( 'the_title_rss', 'congressomat_special_replacements', 12 );
add_filter( 'the_content_feed', 'congressomat_special_replacements', 12 );
