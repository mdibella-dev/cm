<?php
/**
 * Shortcode [event-table]
 * Erzeugt eine Tabelle mit dem Zeitplan eines bestimmten Events
 *
 * Folgende Parameter können verwendet werden:
 * - event      Die Identifikationsnummer des Events
 * - speaker    (optional) Die Identfikationsnummer eines Referenten; dient zur Filterung der Beiträge dieses Referenten.
 * - fieldset   Eine kommaseparierte Liste mit Feldschlüsseln, mit denen die Auswahl sowie die Sortierung der Tabellenzeilen vorgenommen wird.
 *              Folgende Werte sind derzeit möglich:
 *              VON, VONBIS, DATUM, TITEL, REFERENT, ORT
 *
 * @since   1.0.0
 * @author  Marco Di Bella <mdb@marcodibella.de>
 * @package mdb-congressomat
 */

function mdb_shortcode_event_table( $atts, $content = null )
{
    // Parameter auslesen
    extract( shortcode_atts( array(
                             'event'    => '',
                             'speaker'  => '',
							 'fieldset' => 'VONBIS,TITEL,REFERENT,ORT'
                             ), $atts ) );

    // Daten holen
    $sessions = mdb_get_sessions_by_event( $event, $speaker );

    // Ausgabe vorbereiten
    $output = '';

    if( $sessions ) :
        // Variablen setzen
        $rows       = array();
        $field_keys = explode( ',', strtoupper( str_replace(" ", "", $fieldset ) ) );
        unset( $speaker );

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
                        $cells[ 'session-date' ] = get_field( 'programmpunkt-datum', $session->ID );
                    break;

                    case 'VON':
                        $cells[ 'session-begin' ] = get_field( 'programmpunkt-von', $session->ID );
                    break;

                    case 'VONBIS':
                        $cells[ 'session-time' ] = sprintf( '%1$s-%2$s',
                                                            get_field( 'programmpunkt-von', $session->ID ),
                                                            get_field( 'programmpunkt-bis', $session->ID ) );
                    break;

                    case 'TITEL':
                        // $title    = apply_filters( 'the_content', $session->post_title );
                        // $subtitle = apply_filters( 'the_content', get_the_subtitle( $session->ID, '', '', FALSE ) );

                        $title    = $session->post_title;
                        $subtitle = get_the_subtitle( $session->ID, '', '', FALSE );

                        if( !empty( $title ) ) :
                            $cells[ 'session-title' ] .= sprintf( '<span class="title">%1$s</span>', $title );

                            if( !empty( $subtitle ) ) :
                                $cells[ 'session-title' ] .= sprintf( '<span class="subtitle">%1$s</span>', $subtitle );
                            endif;
                        else :
                            $cells[ 'session-title' ] = '';
                        endif;
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
                                                            get_the_post_thumbnail( $speaker[ 'id' ], 'full' ) );
                            endforeach;

                            $cells[ 'session-speaker' ] = implode( ' ', $speakers_list );
                        else :
                            $cells[ 'session-speaker' ] = '';
                        endif;
                    break;

                    case 'ORT':
                        $cells[ 'session-location' ] = mdb_get_location( get_field( 'programmpunkt-location', $session->ID ) );
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
         * Kopfzeile generieren
         **/

        // Tabellenzellen zurücksetzen
        unset( $cells );

        // Alle Feldschlüssel in der designierten Reihenfolge durchlaufen
        foreach( $field_keys as $field_key ) :
            switch( $field_key ) :
                case 'DATUM':
                    $cells[ 'session-date' ] = __( 'Datum', TEXT_DOMAIN );
                break;

                case 'VON':
                    $cells[ 'session-begin' ] = __( 'von', TEXT_DOMAIN );
                break;

                case 'VONBIS':
                    $cells[ 'session-time' ] = __( 'von/bis', TEXT_DOMAIN );
                break;

                case 'TITEL':
                    $cells[ 'session-title' ] = __( 'Titel', TEXT_DOMAIN );
                break;

                case 'REFERENT':
                    $cells[ 'session-speaker' ] = __( 'Referent(en)', TEXT_DOMAIN );
                break;

                case 'ORT':
                    $cells[ 'session-location' ] = __( 'Ort', TEXT_DOMAIN );
                break;
            endswitch;
        endforeach;

        // Alle Tabellenzellen zu einer Tabellenreihe zusammenbauen
        $row_content = '';

        foreach( $cells as $class => $cell ) :
            $row_content .= sprintf( '<td class="%1$s">%2$s</td>', $class, $cell );
        endforeach;

        $row = sprintf( '<tr>%1$s</tr>', $row_content );


        /**
         * Schritt 3
         * Ausgabe vorbereiten
         **/

        $output .= '<table class="event-table">';
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

add_shortcode( 'event-table', 'mdb_shortcode_event_table' );
