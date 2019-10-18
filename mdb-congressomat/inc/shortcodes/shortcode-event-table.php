<?php
/**
 * Shortcode [event-table]
 *
 * Erzeugt eine Tabelle mit dem Zeitplan eines bestimmten Events
 *
 * Folgende Parameter können verwendet werden:
 * @param   event    Die Identifikationsnummer des Events
 * @param   speaker  Die Identfikationsnummer eines Referenten; dient zur Filterung der Beiträge dieses Referenten.
 * @param   set      Die gewählte Set-Vorlage
 *
 * @author  Marco Di Bella <mdb@marcodibella.de>
 * @package mdb-congressomat
 */

function mdb_shortcode_event_table( $atts, $content = null )
{
    // Parameter auslesen
    extract( shortcode_atts( array(
                             'event'    => '',
                             'speaker'  => '',
                             'set'      => '1',
                             ), $atts ) );


    $output  = '';
    $rowset  = array();
    $rowsets = array( '1' => 'session-date,session-time-range|session-title,session-subtitle|session-location',
                      '2' => 'session-time-begin|session-title,session-subtitle,session-location|session-speaker',
                      '3' => 'session-time-begin|session-title,session-subtitle|session-speaker' );


    if( ( 1 <= $set ) and ( $set <= sizeof( $rowsets) ) ) :

        /**
         * Schritt 1
         * Daten holen
         **/

        if( !empty( $speaker) ) :
            $sessions = mdb_get_sessions_by_speaker( $speaker, 'ACTIVE' );
        elseif( !empty( $event ) ) :
            $sessions = mdb_get_sessions_by_event( $event );
        else :
            $sessions = NULL;
        endif;

        /**
         * Schritt 2
         * Jede Session entlang des ermittelten Rowsets abarbeiten
         **/

        if( $sessions ) :

            /**
             * Schritt 1
             * Rowset vorbereiten
             **/

            $pass_1 = explode( '|', $rowsets[ $set ] );  // 1. Durchlauf

            foreach( $pass_1 as $pass_2 ) :
                $rowset[] = explode( ',', $pass_2 );     // 2. Durchlauf
            endforeach;
            $rows = '';

            foreach( $sessions as $session ) :
                $row = '';

                foreach( $rowset as $pass_1 ) :
                    $cell = '';

                    foreach( $pass_1 as $pass_2 ) :
                        $cell .= sprintf( '<div data-type="%1$s">%2$s</div>', $pass_2, mdb_get_session_data( $pass_2, $session ) );
                    endforeach;

                    $row .= sprintf( '<div class="cell">%1$s</div>', $cell );
                endforeach;

                $rows .= sprintf( '<div class="row">%1$s</div>', $row );
            endforeach;

            $output = sprintf( '<div class="event-table has-set-%1$s">%2$s</div>', $set, $rows );
        endif;
    endif;

    // Ausgabe
    return $output;
}

add_shortcode( 'event-table', 'mdb_shortcode_event_table' );



/**
 * Hilfsfunktion, um die zweistufige Datenabfrage zu ermöglichen
 */

function mdb_get_session_data( $data_key, $session )
{
    $value = '';

    switch( $data_key ) :
        case 'session-date' :
            $value = get_field( 'programmpunkt-datum', $session->ID );
        break;

        case 'session-time-begin' :
            $value = get_field( 'programmpunkt-von', $session->ID );
        break;

        case 'session-time-range' :
            $value = sprintf( '%1$s bis %2$s', get_field( 'programmpunkt-von', $session->ID ),
                                           get_field( 'programmpunkt-bis', $session->ID ) );
        break;

        case 'session-title' :
            // $value = $session->post_title;
            $value = apply_filters( 'the_content', $session->post_title );
        break;

        case 'session-subtitle' :
            //$value = get_field( 'programmpunkt-untertitel', $session->ID );
            $value = apply_filters( 'the_content', get_field( 'programmpunkt-untertitel', $session->ID ) );
        break;

        case 'session-location' :
            $value = mdb_get_location( get_field( 'programmpunkt-location', $session->ID ) );
        break;

        case 'session-speaker' :
            $speakers = get_field( 'programmpunkt-referenten', $session->ID );

            if( $speakers != NULL ) :
                unset( $speakers_list );

                foreach( $speakers as $speaker ) :
                    $speaker_dataset = mdb_get_speaker_dataset( $speaker );
                    $speakers_list[] = sprintf( '<a href="%1$s" title="%2$s">%3$s</a>',
                                                $speaker_dataset[ 'permalink' ],
                                                sprintf( __( 'Mehr über %1$s erfahren', 'mdb-congressomat' ), $speaker_dataset[ 'title_name' ] ),
                                                get_the_post_thumbnail( $speaker_dataset[ 'id' ], 'full' ) );
                endforeach;
                $value = implode( ' ', $speakers_list );
            endif;
        break;
    endswitch;

    return $value;
}
