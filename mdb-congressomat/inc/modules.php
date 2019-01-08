<?php
/**
 * modules.php
 *
 * @author  Marco Di Bella <mdb@marcodibella.de>
 * @package mdb-congressomat
 * @since   0.0.1
 * @version 0.0.1
 */


/**
 * Erzeugt ein Modul
 *
 * @since 0.0.1
 */

function mdb_get_module( $args, $content )
{
    // Parameter auslesen
    extract( wp_parse_args( $args,
                            array(
                             'class'            => '',
							 'additional_class' => '',
                             'id'               => '',
                             'title'            => ''
                            ) ) );

    // Variablen setzen
    $output    = '';
    $classes[] = 'module';
    $classes[] = $class;
    $classes[] = $additional_class;

    // Modul zusammenbauen
    $output .= sprintf( '<section class="%1$s"%2$s>',
                        implode( ' ', $classes ),
                        ( $id != '' )? sprintf( ' id="%1$s"', $id ) : ''
                      );

    if( $title != '' ) :
        $output .= sprintf( '<div class="module-title"><h2>%1$s</h2></div>', $title );
     endif;

    $output .= '<div class="module-content">';
    $output .= $content;
    $output .= '</div>';
    $output .= '</section>';
    return $output;
}
