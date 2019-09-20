<?php
/**
 * Shortcode [faq]
 *
 * Erzeugt eine Liste mit den Kooperationspartnern
 *
 * Folgende Parameter können verwendet werden:
 * @param   faq
 *
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
        $output .= '<div class="faq-accordion">';
        $output .= '<ul>';

        while( have_rows( 'faq', $faq ) ) :
            the_row();

            $question = apply_filters( 'the_content', get_sub_field( 'question' ) );
            $answer   = apply_filters( 'the_content', get_sub_field( 'answer' ) );

            $output .= '<li class="faq-element">';
            $output .= sprintf( '<div class="faq-question"><span class="faq-arrow"><i class="fal fa-long-arrow-right"></i></span><span>%1$s</span></div>', wp_strip_all_tags( $question ) );
            $output .= sprintf( '<div class="faq-answer">%1$s</div>', $answer );
            $output .= '</li>';
        endwhile;
        $output .= '</ul>';
        $output .= '</div>';
    endif;

    // Ausgabe
    return $output;
}

add_shortcode( 'faq', 'mdb_shortcode_faq' );
