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
    extract( shortcode_atts( array(
                             'event'   => '',
                             'exclude' => '',
                             'show'    => 0,
                             'shuffle' => 0
                            ), $atts ) );

    // Bestimmte Speaker ausschließen wenn gewünscht
    $speakers    = mdb_get_speakers( $event );
    $exclude_ids = explode( ',', str_replace(" ", "", $exclude ) );

    foreach( $speakers as $speaker ) :
        if( in_array( $speaker[ 'id' ], $exclude_ids ) == FALSE ) :
            $speaker_list[] = $speaker;
        endif;
    endforeach;

    // Beschneidet die Ausgabe falls gewünscht
    if( ( is_numeric( $show ) == TRUE )
        and ( $show > 0 )
        and ( $show < sizeof( $speaker_list ) ) ) :

        // Mischen falls gewünscht
        if( $shuffle == 1 ) :
            shuffle( $speaker_list );
        endif;

        // Liste beschneiden
        $speaker_list = array_slice( $speaker_list, 0, $show );

        // Ergebnis wieder sortieren falls vorher durchmischt
        if( $shuffle == 1 ) :
            $speaker_list = mdb_sort_speakerlist( $speaker_list );
        endif;
    endif;

    // Ausgabe vorbereiten
    $output  = '';
    $output .= '<div class="speaker-block-list">';

    foreach( $speaker_list as $speaker ) :
        $output .= '<article class="speaker-block">';
        $output .= '<div class="speaker-image squared">';
        $output .= sprintf( '<a href="%1$s" title="%2$s">%3$s</a>',
                            $speaker[ 'permalink' ],
                            sprintf( __( 'Mehr über %1$s erfahren', TEXT_DOMAIN ), $speaker[ 'title_name' ] ),
                            get_the_post_thumbnail( $speaker[ 'id' ], 'full' ) );
        $output .= '</div>';
        $output .= '<div class="speaker-caption">';
        $output .= sprintf( '<a class="speaker-title-name" href="%1$s" title="%2$s">%3$s</a>',
                            $speaker[ 'permalink' ],
                            sprintf( __( 'Mehr über %1$s erfahren', TEXT_DOMAIN ), $speaker[ 'title_name' ] ),
                            $speaker[ 'title_name' ] );
        $output .= sprintf( '<p class="speaker-position">%1$s</p>', $speaker[ 'position' ] );
        $output .= '</div>';
        $output .= '</article>';
    endforeach;

    $output .= '</div>';

    // Ausgabe
    return $output;
}

add_shortcode( 'speaker-table', 'mdb_shortcode_speaker_table' );
