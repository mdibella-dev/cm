<?php
/**
 * Shortcode [partner-table]
 * Erzeugt eine Tabelle mit den Kooperationspartnern
 *
 * Folgende Parameter können verwendet werden:
 * - partnership    (optional) Die Kooperationsform nach der gefiltert werden soll.
 *                  Die Kooperationsform muss in Form ihrer Identifikationsnummer eingetragen werden.
 * - fieldset       Eine kommaseparierte Liste mit Feldschlüsseln, mit denen die Auswahl sowie die Sortierung der Tabellenzeilen vorgenommen wird.
 *                  Folgende Werte sind derzeit möglich:
 *                  LOGO, BESCHREIBUNG
 *
 * @since 1.0.0
 * @author  Marco Di Bella <mdb@marcodibella.de>
 * @package mdb-congressomat
 */

function mdb_shortcode_partner_table( $atts, $content = null )
{
    // Parameter auslesen
    extract( shortcode_atts( array(
                             'partnership' => '',
                             'fieldset'    => '',
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
                        $link  = get_field( 'partner-webseite', $partner->ID );
                        $image = get_the_post_thumbnail( $partner->ID, 'full' );

                        if( !empty( $link ) ) :
                            $cells[ 'partner-logo' ] = sprintf( '<a href="%1$s" target="_blank" title="%2$s" rel="external">%3$s</a>',
                                                                $link,
                                                                __( 'Externen Link aufrufen', TEXT_DOMAIN ),
                                                                $image );
                        else :
                            $cells[ 'partner-logo' ] = $image;
                        endif;
                    break;

                    case 'BESCHREIBUNG':
                        // Alle möglichen Inhalte holen
                        $title       = get_the_title( $partner->ID);
                        $description = get_field( 'partner-beschreibung', $partner->ID );
                        $link        = get_field( 'partner-webseite', $partner->ID );
                        $exhibition  = get_field( 'messestand', $partner->ID );
                        $location    = mdb_get_location( $exhibition[ 'partner-messestand-ort' ] );
                        $number      = $exhibition[ 'partner-messestand-nummer' ];

                        // Ausgabe erstellen
                        $cells[ 'partner-description' ] = '';
                        $link_string                    = '';
                        $exhib_string                   = '';

                        if( !empty( $title ) ) :
                            $cells[ 'partner-description' ] .= sprintf( '<span class="title">%1$s</span>', $title );
                        endif;

                        if( !empty( $description ) ) :
                            $cells[ 'partner-description' ] .= sprintf( '<span class="description">%1$s</span>', $description );
                        endif;

                        if( !empty( $link ) ) :
                            $url         = parse_url( $link );
                            $link_string = sprintf( '<span class="link">%1$s</span>',
                                                    sprintf( '<a href="%1$s" target="_blank" title="%2$s" rel="external">%3$s</a>',
                                                             $link,
                                                             __( 'Externen Link aufrufen', TEXT_DOMAIN ),
                                                             $url[ 'host' ] ) );
                        endif;

                        if( !empty( $location ) ) :
                            $exhib_string = sprintf( '<span class="exhibition">%1$s, %2$s</span>',
                                                     sprintf( __( 'Stand %1$s', TEXT_DOMAIN ), $number ),
                                                     $location );
                        endif;

                        if( !empty( $exhib_string ) and !empty( $link_string ) ) :
                            $cells[ 'partner-description' ] .= sprintf( '<span class="additional">%1$s%2$s</span>', $exhib_string, $link_string );
                        elseif( !empty( $link_string ) and empty( $exhib_string ) ) :
                            $cells[ 'partner-description' ] .= sprintf( '<span class="additional">%1$s</span>', $link_string );
                        elseif( !empty( $exhib_string ) and empty( $link_string ) ) :
                            $cells[ 'partner-description' ] .= sprintf( '<span class="additional">%1$s</span>', $exhib_string );
                        endif;

                    break;

                    case 'MESSESTAND':
                        $exhibition = get_field( 'messestand', $partner->ID );
                        $location   = mdb_get_location( $exhibition[ 'partner-messestand-ort' ] );
                        $number     = $exhibition[ 'partner-messestand-nummer' ];

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
