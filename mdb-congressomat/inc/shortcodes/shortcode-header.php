<?php
/**
 * Shortcode [header]
 * Erzeugt eine Kopfzeile
 *
 * Folgende Parameter können verwendet werden:
 * - heading    Die Überschrift
 * - subheading (optional) Die Unter-Überschrift.
 * - align      (optional) Die Ausrichtung der Kopfzeile (standardmäßig: center). Folgende Werte sind derzeit möglich:
 *              left, right, center
 *
 * @author  Marco Di Bella <mdb@marcodibella.de>
 * @package mdb-congressomat
 */

function mdb_shortcode_header( $atts, $content = null )
{
    // Parameter auslesen
    extract( shortcode_atts( array(
                             'align'      => 'center',
                             'subheading' => '',
							 'heading'    => '' ),
                             $atts ) );

    // Ausgabe vorbereiten
    $output = '';

    if( $heading ) :
        $align     = strtolower( trim( $align ) );
        $alignment = array( 'left'   => 'align-left',
                            'right'  => 'align-right',
                            'center' => 'align-center' );
        $output    = sprintf( '<header%1$s><h2>%2$s%3$s</h2></header>',
                              ( !empty( $alignment[ $align ] ) )? sprintf( ' class="%1$s"', $alignment[ $align ] ) : '',
                              $heading,
                              ( !empty( $subheading ) )? sprintf( '<p><span class="subheading">%1$s</span></p>', $subheading ) : '' );

    endif;

    // Ausgabe
    return $output;
}

add_shortcode( 'header', 'mdb_shortcode_header' );
