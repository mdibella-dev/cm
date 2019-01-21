<?php
/**
 * Shortcodes für besondere redaktionelle Zwecke
 *
 * @author  Marco Di Bella <mdb@marcodibella.de>
 * @package mdb-congressomat
 */



function mdb_shortcode_speaker_table( $atts, $content = null )
{
    // Parameter auslesen
    extract( shortcode_atts( array( 'event' => '' ), $atts ) );

    // Ausgabe vorbereiten
    $output = '';
    $speakers_list = mdb_get_speakers( $event );



    $output .= '<div class="speaker-block-list">';

    foreach( $speakers_list as $speaker ) :
        $output .= '<article class="speaker-block">';
        $output .= '<div class="speaker-image squared">';
        $output .= sprintf( '<a href="%1$s" title="%2$s">%3$s</a>',
                            get_the_permalink( $post->ID ),
                            sprintf( __( 'Mehr über %1$s erfahren', TEXT_DOMAIN ), $speaker[ 'title_name' ] ),
                            get_the_post_thumbnail( $speaker[ 'id' ], 'full' ) );
        $output .= '</div>';
        $output .= sprintf( '<div class="speaker-caption">%1$s<br>%2$s</div>',
                            $speaker[ 'title_name' ],
                            $speaker[ 'position' ] );
        $output .= '</article>';
    endforeach;

    $output .= '</div>';



    // Ausgabe
    return $output;
}

add_shortcode( 'speaker-table', 'mdb_shortcode_speaker_table' );
