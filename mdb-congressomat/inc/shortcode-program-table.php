<?php
/**
 * Shortcodes für besondere redaktionelle Zwecke
 *
 * @author  Marco Di Bella <mdb@marcodibella.de>
 * @package mdb-congressomat
 */



/**
 * Shortcode [program-table]
 * Erzeugt eine Tabelle mit dem Programm eines bestimmten Events
 *
 * Folgende Parameter können verwendet werden
 * - event_id       Die Identifikationsnummer des Events
 * - referent_id    Die Identfikationsnummer eines Referenten; dient zur Filterung der Beiträge dieses Referenten (optional)
 * - fields         Eine kommaseparierte Liste mit Feldschlüsseln, mit denen die Auswahl sowie die Sortierung der Tabellenzeilen vorgenommen wird.
 *                  Folgende Werte sind möglich: VON, VONBIS, DATUM, TITEL, REFERENT, ORT
 *
 * @since 1.0.0
 */

function mdb_shortcode_program_table( $atts, $content = null )
{
    // Parameter auslesen
    extract( shortcode_atts( array(
                             'event_id'    => '',
                             'referent_id' => '',
							 'fields'      => 'VONBIS,TITEL,REFERENT,ORT'
                         ), $atts ) );

    // Ausgabe vorbereiten
    $output   = '';

    // Daten holen
    $sessions = mdb_get_sessions_by_event( $event_id, $referent_id );

    if( $sessions ) : // !empty( $event_id ) and is_numeric( $event_id ) ) :
        // Variablen setzen
        $rows       = array();
        $field_keys = explode( ',', strtoupper( $fields ) );


        foreach( $sessions as $session ) :
            // Tabellenzellen zurücksetzen
            unset( $cells );

            // Alle Feldschlüssel in der designierten Reihenfolge durchlaufen und Tabellenzellen erstellen
            foreach( $field_keys as $field_key ) :
                switch( $field_key ):
                    case 'DATUM':
                         $cells[] = get_field( 'programmpunkt-datum', $session->ID );
                    break;

                    case 'VON':
                        $cells[] = get_field( 'programmpunkt-von', $session->ID );
                    break;

                    case 'VONBIS':
                        $von = get_field( 'programmpunkt-von', $session->ID );
                        $bis = get_field( 'programmpunkt-bis', $session->ID );
                        $cells[] = sprintf( '%1$s-%2$s', $von, $bis );
                    break;

                    case 'TITEL':
                        $titel      = $session->post_title;
                        $untertitel = get_the_subtitle( $session->ID, '', '', FALSE );
                        $cells[]    = $titel.'<br>'.$untertitel;
                    break;

                    case 'REFERENT':
                        $referenten = get_field( 'programmpunkt-referenten', $session->ID );

                        if( $referenten != NULL ) :
                            unset( $referenten_liste );

                            foreach( $referenten as $referent_ID ) :
                                $referent           = mdb_get_referent( $referent_ID );
                                $referenten_liste[] = $referent[ 'titel_name' ];
                            endforeach;

                            $cells[] = implode( ', ', $referenten_liste );
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
            // Todo: Tabellenkopfzeile!
            $row_content = '';

            foreach( $cells as $cell) :
                $row_content .= sprintf( '<td>%1$s</td>', $cell );
            endforeach;

            $rows[] = $row_content;
        endforeach;

        // Ausgabe vorbereiten
        $output .= '<table class="programm">';

        // echo '<thead>';
        // + th
        // echo '</thead>';

        $output .= '<tbody>';

        foreach( $rows as $row ) :
            $output .= '<tr>' . $row . '</tr>';
        endforeach;

        $output .= '</tbody>';
        $output .= '</table>';
    endif;

    // Ausgabe
    return $output;
}

add_shortcode( 'program-table', 'mdb_shortcode_program_table' );
