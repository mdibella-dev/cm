<?php
/**
 * Shortcode [faq]
 * Erzeugt eine Liste mit den Kooperationspartnern
 *
 * Folgende Parameter können verwendet werden:
 * - partnership    (optional) Die Kooperationsform(en) nach der gefiltert werden soll.
 *                  Die Kooperationsformen müssen in Form einer kommaseparierten Liste ihrer Identifikationsnummern vorliegen.
 *
 * @since 1.0.0
 * @author  Marco Di Bella <mdb@marcodibella.de>
 * @package mdb-congressomat
 */

function mdb_shortcode_faq( $atts, $content = null )
{
    // Parameter auslesen
    extract( shortcode_atts( array(
                             'faq' => '',
                             ), $atts ) );

    // Ausgabe vorbereiten
    $output = '';

    if( have_rows( 'faq', $faq ) ) :
        $output .= '<ul class="faq-accordion">';

        while( have_rows( 'faq', $faq ) ) :
            the_row();

            $question = get_sub_field( 'question' );
            $answer   = get_sub_field( 'answer' );

            $output .= '<li>';
            $output .= sprintf( '<h3 class="faq-accordion-trigger">%1$s</h3>', $question );
            $output .= sprintf( '<div>%1$s</div>', $answer );
            $output .= '</li>';
        endwhile;
        $output .= '</ul>';
    endif;

    // Ausgabe
    return $output;
}

add_shortcode( 'faq', 'mdb_shortcode_faq' );
