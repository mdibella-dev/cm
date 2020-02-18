<?php
/**
 * Shortcode [partner-table]
 * Erzeugt eine Tabelle mit den Kooperationspartnern
 *
 * Folgende Parameter können verwendet werden:
 * @param   partnership (optional) Die Kooperationsform(en) nach der gefiltert werden soll.
 *                      Die Kooperationsformen müssen in Form einer kommaseparierten Liste ihrer Identifikationsnummern vorliegen.
 * @param   fieldset    Eine kommaseparierte Liste mit Feldschlüsseln, mit denen die Auswahl sowie die Sortierung der Tabellenzeilen vorgenommen wird.
 *                      Folgende Werte sind derzeit möglich:
 *                      LOGO, BESCHREIBUNG, MESSESTAND
 *
 * @author  Marco Di Bella <mdb@marcodibella.de>
 * @package congressomat
 */

function cm_shortcode_partner_table( $atts, $content = null )
{
    /**
     * Parameter auslesen
     **/

    $default_atts = array(
        'partnership' => '',
        'fieldset'    => '',
    );

    extract( shortcode_atts( $default_atts, $atts ) );


    // Abfrage zusammenstellen
    $query = array(
             'post_type'      => 'partner',
             'post_status'    => 'publish',
             'posts_per_page' => '-1',
             'order'          => 'ASC',
             'orderby'        => 'title' );

    // Nach Kooperationsform filtern
    if( !empty( $partnership ) ) :
        $query[ 'tax_query' ] = array( array(
                                       'taxonomy' => 'partnership',
                                       'field'    => 'term_id',
                                       'terms'    => explode(',', $partnership ) ) );
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
                                                                __( 'Externen Link aufrufen', 'congressomat' ),
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

                        // Ausgabe erstellen
                        if( !empty( $title ) ) :
                            $cells[ 'partner-description' ] .= sprintf( '<h2 class="title">%1$s</h2>', $title );
                        endif;

                        if( !empty( $description ) ) :
                            $cells[ 'partner-description' ] .= sprintf( '<span class="description">%1$s</span>', apply_filters( 'the_content', $description ) );
                        endif;

                        if( !empty( $link ) ) :
                            $url                             = parse_url( $link );
                            $cells[ 'partner-description' ] .= sprintf( '<span class="link">%1$s</span>',
                                                                        sprintf( '<a href="%1$s" target="_blank" title="%2$s" rel="external">%3$s</a>',
                                                                                 $link,
                                                                                 __( 'Externen Link aufrufen', 'congressomat' ),
                                                                                 $url[ 'host' ] ) );
                        endif;
                    break;

                    case 'MESSESTAND':
                        // Alle möglichen Inhalte holen
                        $exhibition = get_field( 'messestand', $partner->ID );
                        $location   = cm_get_location( $exhibition[ 'partner-messestand-ort' ] );
                        $number     = $exhibition[ 'partner-messestand-nummer' ];

                        // Ausgabe erstellen
                        if( !empty( $number ) or !empty( $location ) ) :
                            $strings = array();

                            if( !empty( $number ) ) :
                                $strings[] = sprintf( __( 'Stand %1$s', 'congressomat' ), $number );
                            endif;

                            if( !empty( $location ) ) :
                                $strings[] = $location;
                            endif;

                            $cells[ 'partner-exhibition' ] = sprintf( '<span class="exhibition">%1$s</span>', implode( ', ', $strings ) );
                        else :
                            $cells[ 'partner-exhibition' ] = '';
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

add_shortcode( 'partner-table', 'cm_shortcode_partner_table' );
