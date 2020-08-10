<?php
/**
 * Shortcode [event-table]
 *
 * Erzeugt eine Tabelle mit dem Zeitplan eines bestimmten Events
 *
 * Folgende Parameter können verwendet werden:
 * @param   set             Die gewählte Set-Vorlage
 * @param   event           Die Identifikationsnummer des Events
 * @param   speaker         Die Identfikationsnummer eines Referenten; dient zur Filterung der Beiträge dieses Referenten
 * @param   show_details    Anzeige der Details ermöglichen (true, false)
 *
 * @author  Marco Di Bella <mdb@marcodibella.de>
 * @package congressomat
 */

function congressomat_shortcode_event_table( $atts, $content = null )
{
    /* Übergebene Parameter ermitteln */

    $default_atts = array(
        'set'          => '1',
        'speaker'      => '',
        'event'        => '',
        'date'         => '',
        'show_details' => 'false',
    );

    extract( shortcode_atts( $default_atts, $atts ) );


    /* Bei valider Setlist fortfahren */

    if( ( 1 <= $set ) and ( $set <= sizeof( EVENT_TABLE_SETLIST ) ) ) :

        /*
         * Daten holen
         * Entweder nach (aktiven) Sessions des angegebenen Speakers suchen (Variante 1)
         * oder nach den Sessions des angegebenen Events suchen (Variante 2)
         */

        if( !empty( $speaker) ) :
            $sessions = congressomat_get_sessions_by_speaker( $speaker );
        elseif( !empty( $event ) ) :
            $sessions = congressomat_get_sessions_by_event( $event, $date );
        else :
            $sessions = null;
        endif;


        /* Jede Session entlang der Setlist abarbeiten */

        if( $sessions ) :
            $a_set = explode( ',', EVENT_TABLE_SETLIST[ $set ]['a'] );
            $b_set = explode( ',', EVENT_TABLE_SETLIST[ $set ]['b'] );


            /* Ausgabe vorbereiten */

            $output = sprintf( '<div class="event-table has-set-%1$s">', $set );

            foreach( $sessions as $session ) :
                $output .= '<div class="event-table__session">';


                /* Die durch a_set konfigurierten Elemente abarbeiten */

                $output .= '<div class="event-table__session-schedule">';

                foreach( $a_set as $data_key ) :

                    switch( $data_key ) :

                        case 'session-date' :
                            $output .= sprintf( '<div data-type="%1$s">%2$s</div>',
                                $data_key,
                                get_field( 'programmpunkt-datum', $session->ID )
                            );
                        break;

                        case 'session-time-begin' :
                            $output .= sprintf( '<div data-type="%1$s">%2$s</div>',
                                $data_key,
                                get_field( 'programmpunkt-von', $session->ID )
                            );
                        break;

                        case 'session-time-range' :
                            $data = get_field( 'programmpunkt-alternative-zeitangabe', $session->ID );

                            if( empty( $data ) ) :
                                $data = sprintf( '%1$s bis %2$s',
                                    get_field( 'programmpunkt-von', $session->ID ),
                                    get_field( 'programmpunkt-bis', $session->ID ) );
                            endif;

                            $output .= sprintf( '<div data-type="%1$s">%2$s</div>',
                                $data_key,
                                $data
                            );
                        break;

                        case 'session-location' :
                            $output .= sprintf( '<div data-type="%1$s">%2$s</div>',
                                $data_key,
                                congressomat_get_location( get_field( 'programmpunkt-location', $session->ID ) )
                            );
                        break;

                    endswitch;

                endforeach;

                $output .= '</div>';


                /* Die durch b_set konfigurierten Elemente abarbeiten */

                $output .= '<div class="event-table__session-overview">';

                foreach( $b_set as $data_key ) :

                    switch( $data_key ) :

                        case 'session-title' :
                            $output .= sprintf( '<div data-type="%1$s">%2$s</div>',
                                $data_key,
                                $session->post_title
                            );
                        break;

                        case 'session-subtitle' :
                            $output .= sprintf( '<div data-type="%1$s">%2$s</div>',
                                $data_key,
                                get_field( 'programmpunkt-untertitel', $session->ID )
                            );
                        break;

                        case 'session-speaker' :
                            $speakers = get_field( 'programmpunkt-referenten', $session->ID );

                            if( $speakers != null ) :
                                unset( $speakers_list );

                                foreach( $speakers as $speaker ) :
                                    $speaker_dataset = congressomat_get_speaker_dataset( $speaker );
                                    $speakers_list[] = sprintf(
                                        '<a href="%1$s" title="%2$s">%3$s</a>',
                                        $speaker_dataset[ 'permalink' ],
                                        sprintf( __( 'Mehr über %1$s erfahren', 'congressomat' ), $speaker_dataset[ 'title_name' ] ),
                                        get_the_post_thumbnail( $speaker_dataset[ 'id' ], 'full' ) );
                                endforeach;

                                $output .= sprintf( '<div data-type="%1$s">%2$s</div>',
                                    $data_key,
                                    implode( ' ', $speakers_list )
                                );
                            endif;

                        break;

                    endswitch;

                endforeach;

                $output .= '</div>';


                /* Anzeige der Detailinformationen (wenn vorhanden) ermöglichen */

                $details = apply_filters( 'the_content', get_field( 'programmpunkt-beschreibung', $session->ID ) );

                if( ( $show_details == true ) and !empty( $details ) ):
                    $output .= '<div class="event-table__session-toggle"><span><i class="far fa-angle-down"></i></span></div>';
                    $output .= sprintf ('<div class="event-table__session-details">%1$s</div>', $details );
                endif;

                $output .= '</div>';

            endforeach;

            $output .= '</div>';
        endif;
    endif;

    return $output;
}

add_shortcode( 'event-table', 'congressomat_shortcode_event_table' );
