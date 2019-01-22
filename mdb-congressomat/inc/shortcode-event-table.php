<?php
/**
 * Shortcodes für besondere redaktionelle Zwecke
 *
 * @author  Marco Di Bella <mdb@marcodibella.de>
 * @package mdb-congressomat
 */



/**
 * Shortcode [event-tabelle]
 * Erzeugt eine Tabelle mit dem Zeitplan eines bestimmten Events
 *
 * Folgende Parameter können verwendet werden:
 * - event       Die Identifikationsnummer des Events
 * - referent    Die Identfikationsnummer eines Referenten; dient zur Filterung der Beiträge dieses Referenten (optional)
 * - felder      Eine kommaseparierte Liste mit Feldschlüsseln, mit denen die Auswahl sowie die Sortierung der Tabellenzeilen vorgenommen wird.
 *               Folgende Werte sind derzeit möglich: VON, VONBIS, DATUM, TITEL, REFERENT, ORT
 *
 * @since 1.0.0
 */

function mdb_shortcode_event_table( $atts, $content = null )
{
    // Parameter auslesen
    extract( shortcode_atts( array(
                             'event'    => '',
                             'referent' => '',
							 'felder'   => 'VONBIS,TITEL,REFERENT,ORT'
                         ), $atts ) );

    // Ausgabe vorbereiten
    $output = '';

    // Daten holen
    $sessions = mdb_get_sessions_by_event( $event, $referent );

    if( $sessions ) :
        // Variablen setzen
        $rows       = array();
        $field_keys = explode( ',', strtoupper( str_replace(" ", "", $felder ) ) );


        /**
         * Schritt 1
         * Alle Programmpunkte durchlaufen und entsprechende Tabellenzeilen generieren
         **/

        foreach( $sessions as $session ) :
            // Tabellenzellen zurücksetzen
            unset( $cells );

            // Alle Feldschlüssel in der designierten Reihenfolge durchlaufen
            foreach( $field_keys as $field_key ) :
                switch( $field_key ) :
                    case 'DATUM':
                        $cells[] = get_field( 'programmpunkt-datum', $session->ID );
                    break;

                    case 'VON':
                        $cells[] = get_field( 'programmpunkt-von', $session->ID );
                    break;

                    case 'VONBIS':
                        $cells[] = sprintf( '%1$s-%2$s',
                                            get_field( 'programmpunkt-von', $session->ID ),
                                            get_field( 'programmpunkt-bis', $session->ID ) );
                    break;

                    case 'TITEL':
                        $title    = $session->post_title;
                        $subtitle = get_the_subtitle( $session->ID, '', '', FALSE );
                        $cells[]  = $title.'<br>'.$subtitle;
                    break;

                    case 'REFERENT':
                        $speakers = get_field( 'programmpunkt-referenten', $session->ID );

                        if( $speakers != NULL ) :
                            unset( $speakers_list );

                            foreach( $speakers as $speaker_id ) :
                                $speaker         = mdb_get_speaker_info( $speaker_id );
                                $speakers_list[] = sprintf( '<a href="%1$s" title="%2$s">%3$s</a>',
                                                            $speaker[ 'permalink' ],
                                                            sprintf( __( 'Mehr über %1$s erfahren', TEXT_DOMAIN ), $speaker[ 'title_name' ] ),
                                                            //get_the_post_thumbnail( $speaker[ 'id' ], 'full' )
                                                            $speaker[ 'title_name' ]
                                                        );
                            endforeach;

                            $cells[] = implode( ', ', $speakers_list );
                        else :
                            $cells[] = '';
                        endif;
                    break;

                    case 'ORT':
                        $cells[] = mdb_get_location( get_field( 'programmpunkt-location', $session->ID ) );
                    break;
                endswitch;
            endforeach;

            // Alle Tabellenzellen zu einer Tabellenreihe zusammenbauen
            $row_content = '';

            foreach( $cells as $cell) :
                $row_content .= sprintf( '<td>%1$s</td>', $cell );
            endforeach;

            $rows[] = sprintf( '<tr>%1$s</tr>', $row_content );
        endforeach;


        /**
         * Schritt 2
         * Kopfzeile generieren
         **/

        // Tabellenzellen zurücksetzen
        unset( $cells );

        // Alle Feldschlüssel in der designierten Reihenfolge durchlaufen
        foreach( $field_keys as $field_key ) :
            switch( $field_key ) :
                case 'DATUM':
                    $cells[] = __( 'Datum', TEXT_DOMAIN );
                break;

                case 'VON':
                    $cells[] = __( 'von', TEXT_DOMAIN );
                break;

                case 'VONBIS':
                    $cells[] = __( 'von/bis', TEXT_DOMAIN );
                break;

                case 'TITEL':
                    $cells[] = __( 'Titel', TEXT_DOMAIN );
                break;

                case 'REFERENT':
                    $cells[] = __( 'Referent(en)', TEXT_DOMAIN );
                break;

                case 'ORT':
                    $cells[] = __( 'Ort', TEXT_DOMAIN );
                break;
            endswitch;
        endforeach;

        // Alle Tabellenzellen zu einer Tabellenreihe zusammenbauen
        $row_content = '';

        foreach( $cells as $cell) :
            $row_content .= sprintf( '<td>%1$s</td>', $cell );
        endforeach;

        $row = sprintf( '<tr>%1$s</tr>', $row_content );


        /**
         * Schritt 3
         * Ausgabe vorbereiten
         **/

        $output .= '<table class="programm">';
        $output .= sprintf( '<thead>%1$s</thead>', $row );
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

add_shortcode( 'event-tabelle', 'mdb_shortcode_event_table' );
