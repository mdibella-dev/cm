<?php
/**
 * Shortcode [faq]
 *
 * Erzeugt eine Liste mit den Kooperationspartnern
 *
 * @param   faq

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

            $question = apply_filters( 'the_content', get_sub_field( 'question' ) );
            $answer   = apply_filters( 'the_content', get_sub_field( 'answer' ) );

            $output .= '<li>';
            $output .= sprintf( '<h3><span><i class="fal fa-long-arrow-right"></i></span><span>%1$s</span></h3>', wp_strip_all_tags( $question ) );
            $output .= sprintf( '<div>%1$s</div>', $answer );
            $output .= '</li>';
        endwhile;
        $output .= '</ul>';
    endif;

    // Ausgabe
    return $output;
}

add_shortcode( 'faq', 'mdb_shortcode_faq' );
