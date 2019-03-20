<?php
/**
 * Shortcode [partner-list]
 * Erzeugt eine Liste mit den Kooperationspartnern
 *
 * Folgende Parameter können verwendet werden:
 * - partnership    (optional) Die Kooperationsform nach der gefiltert werden soll.
 *                  Die Kooperationsform muss in Form ihrer Identifikationsnummer eingetragen werden.
 *
 * @since 1.0.0
 * @author  Marco Di Bella <mdb@marcodibella.de>
 * @package mdb-congressomat
 */

function mdb_shortcode_partner_list( $atts, $content = null )
{
    // Parameter auslesen
    extract( shortcode_atts( array(
                             'partnership' => '',
                             ), $atts ) );

    // Abfrage zusammenstellen
    $query = array(
             'post_type'      => 'partner',
             'post_status'    => 'publish',
             'posts_per_page' => '-1',
             'order'          => 'ASC',
             'orderby'        => 'title' );

    // Nach Kooperationsform filtern
    if( !empty( $partnership ) and is_numeric( $partnership ) ) :
        $query[ 'tax_query' ] = array( array(
                                       'taxonomy' => 'partnership',
                                       'field'    => 'term_id',
                                       'terms'    => $partnership ) );
    endif;

    // Daten holen
    $partners = get_posts( $query );

    // Ausgabe vorbereiten
    $output = '';

    if( $partners ) :
        $output .= '<ul class="partner-list">';

        foreach( $partners as $partner ) :
            $output .= sprintf( '<li>%1$s</li>', get_the_post_thumbnail( $partner->ID, 'full' ) );
        endforeach;

        $output .= '</ul>';
    endif;

    // Ausgabe
    return $output;
}

add_shortcode( 'partner-list', 'mdb_shortcode_partner_list' );