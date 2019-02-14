<?php
/**
 * Shortcode [partner-table]
 * Erzeugt eine Tabelle mit den Kooperationspartnern
 *
 * Folgende Parameter können verwendet werden:
 * - partnership    (optional) Die Kooperationsform nach der gefiltert werden soll.
 * - fieldset       Eine kommaseparierte Liste mit Feldschlüsseln, mit denen die Auswahl sowie die Sortierung der Tabellenzeilen vorgenommen wird.
 *                  Folgende Werte sind derzeit möglich:
 *                  LOGO, BESCHREIBUNG
 *
 * @since 1.0.0
 * @author  Marco Di Bella <mdb@marcodibella.de>
 * @package mdb-congressomat
 */


/**
 * Shortcode [...]
 * Erzeugt eine Teaserliste mit den zuletzt veröffentlichten Artikeln.
 *
 * @since 1.0.0
 **/

function mdb_shortcode_partner_table( $atts, $content = null )
{
    // Parameter auslesen
    extract( shortcode_atts( array(
                             'partnership' => '',
                             'fieldset'    => '',
                             ), $atts ) );

    // Daten holen
    // @todo: nach partnership filtern
    $partners = get_posts( array(
                           'post_type'      => 'partner',
                           'post_status'    => 'publish',
                           'posts_per_page' => '-1',
                           'order'          => 'ASC',
                           'orderby'        => 'title'
                           ) );


    // Ausgabe vorbereiten
    $output = '';

    if( $partners ) :
        // Variable setzen
        $rows       = array();
        $field_keys = explode( ',', strtoupper( str_replace(" ", "", $fieldset ) ) );

        /**
         * Schritt 1
         * Alle gefundenen Partner durchlaufen und entsprechende Tabellenzeilen generieren
         **/

        foreach( $partners as $partner ) :
            // Tabellenzellen zurücksetzen
            unset( $cells );

            // Alle Feldschlüssel in der designierten Reihenfolge durchlaufen
            foreach( $field_keys as $field_key ) :
                switch( $field_key ) :
                    case 'LOGO':
                        $cells[ 'partner-logo' ] = get_the_post_thumbnail( $partner->ID, 'full' );
                    break;

                    case 'BESCHREIBUNG':
                        $title       = get_the_title( $partner->ID);
                        $description = get_field( 'partner-beschreibung', $partner->ID );
                        $link        = get_field( 'partner-webseite', $partner->ID );

                        $cells[ 'partner-description' ] = '';

                        if( !empty( $title ) ) :
                            $cells[ 'partner-description' ] .= sprintf( '<span class="title">%1$s</span>',
                                                                        $title );
                        endif;

                        if( !empty( $description ) ) :
                            $cells[ 'partner-description' ] .= sprintf( '<span class="description">%1$s</span>',
                                                                        $description );
                        endif;

                        if( !empty( $link ) ) :
                            $url = parse_url( $link );

                            $cells[ 'partner-description' ] .= sprintf( '<span class="link">%1$s</span>',
                                                                        sprintf( '<a href="%1$s" target="_blank" title="%2$s">%1$s</a>',
                                                                                 $url[ 'host' ],
                                                                                 __( 'Externen Link aufrufen', TEXT_DOMAIN ) ) );
                        endif;
                    break;

                    case 'MESSESTAND':
                        $location = get_field( 'partner-messestand-ort', $partner->ID );
                        $number   = get_field( 'partner-messestand-nummer', $partner->ID );

                        if( 1==1 /*$location and $number*/ ) :
                            $cells[ 'partner-exhibition' ] = sprintf( '<span class="number">%1$s</span><span class="location">%2$s</span>',
                                                             $number,
                                                             $location );
                        else :
                            $cells[ 'partner-exhibition' ] = '';
                        endif;
                    break;

                    case 'WEBSEITE':
                        $link = get_field( 'partner-webseite', $partner->ID );

                        if( !empty( $link ) ) :
                            $cells[ 'partner-website' ] = sprintf( '<a href="%1$s" target="_blank" title="%2$s"><i class="fal fa-external-link-square"></i></a>',
                                                                   $link,
                                                                   __( 'Mehr erfahren', TEXT_DOMAIN ) );
                        else :
                            $cells[ 'partner-website' ] = '';
                        endif;
                    break;
                endswitch;
            endforeach;

            // Alle Tabellenzellen zu einer Tabellenreihe zusammenbauen
            $row_content = '';

            foreach( $cells as $class => $cell ) :
                $row_content .= sprintf( '<td class="%1$s">%2$s</td>', $class, $cell );
            endforeach;

            $rows[] = sprintf( '<tr>%1$s</tr>', $row_content );
        endforeach;


        /**
         * Schritt 2
         * Ausgabe vorbereiten
         **/

        $output .= '<table class="partner-table">';
        $output .= '<tbody>';

        foreach( $rows as $row ) :
            $output .= $row;
        endforeach;

        $output .= '</tbody>';
        $output .= '</table>';
    endif;

    // Ausgabe
    return $output;
}

add_shortcode( 'partner-table', 'mdb_shortcode_partner_table' );
