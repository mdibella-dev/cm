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
 * @package congressomat
 */

function congressomat_shortcode_event_table( $atts, $content = null )
{
    /**
     * Parameter auslesen
     **/

    $default_atts = array(
        'event'   => '',
        'speaker' => '',
        'set'     => '1',
    );

    extract( shortcode_atts( $default_atts, $atts ) );


    /**
     * Variablen setzen
     **/

    $output  = '';
    $rowset  = array();


    if( ( 1 <= $set ) and ( $set <= sizeof( EVENT_TABLE_ROWSET) ) ) :

        /**
         * Schritt 1
         * Daten holen
         **/

        if( !empty( $speaker) ) :
            $sessions = congressomat_get_sessions_by_speaker( $speaker, 'ACTIVE' );
        elseif( !empty( $event ) ) :
            $sessions = congressomat_get_sessions_by_event( $event );
        else :
            $sessions = null;
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

            // 1. Durchlauf
            $pass_1 = explode( '|', EVENT_TABLE_ROWSET[ $set ] );

            // 2. Durchlauf
            foreach( $pass_1 as $pass_2 ) :
                $rowset[] = explode( ',', $pass_2 );
            endforeach;
            $rows = '';

            foreach( $sessions as $session ) :
                $row = '';

                foreach( $rowset as $pass_3 ) :
                    $cell = '';
                    foreach( $pass_3 as $data_key ) :
                        print_r( $data_key);
                        $cell .= sprintf( '<div data-type="%1$s">%2$s</div>', $data_key, congressomat_get_session_data( $data_key, $session ) );
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

//add_shortcode( 'event-table', 'congressomat_shortcode_event_table_2' );



function congressomat_shortcode_event_table_2( $atts, $content = null )
{
    /**
     * Parameter auslesen
     **/

    $default_atts = array(
        'event'   => '',
        'speaker' => '',
        'set'     => '1',
    );

    extract( shortcode_atts( $default_atts, $atts ) );



    if( ( 1 <= $set ) and ( $set <= sizeof( EVENT_TABLE_SETLIST ) ) ) :

        /**
         * Schritt 1
         * Daten holen
         **/

        if( !empty( $speaker) ) :
            $sessions = congressomat_get_sessions_by_speaker( $speaker, 'ACTIVE' );
        elseif( !empty( $event ) ) :
            $sessions = congressomat_get_sessions_by_event( $event );
        else :
            $sessions = null;
        endif;


        /**
         * Schritt 2
         * Jede Session entlang der Setlist abarbeiten
         **/

        if( $sessions ) :

            // 1. Durchlauf
            $pass_1 = explode( '|', EVENT_TABLE_SETLIST[ $set ] );

            // 2. Durchlauf
            $setlist = array();
            foreach( $pass_1 as $pass_2 ) :
                $setlist[] = explode( ',', $pass_2 );
            endforeach;

            // Ausgabe vorbereiten
            $output = sprintf( '<div class="event-table has-set-%1$s">', $set );

            foreach( $sessions as $session ) :
                $output .= '<div class="row">';

                foreach( $setlist as $pass_3 ) :

                    $output .= '<div class="cell">';

                    foreach( $pass_3 as $data_key ) :
                        $output .= sprintf( '<div data-type="%1$s">%2$s</div>', $data_key, congressomat_get_session_data( $data_key, $session ) );
                    endforeach;

                    $output .= '</div>';
                endforeach;

                $output .= '</div>';
            endforeach;

            $output .= '</div>';
        endif;
    endif;

    // Ausgabe
    return $output;
}

add_shortcode( 'event-table', 'congressomat_shortcode_event_table_2' );


/**
 * Hilfsfunktion, um die zweistufige Datenabfrage zu ermöglichen
 */

function congressomat_get_session_data( $data_key, $session )
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
            $value = get_field( 'programmpunkt-alternative-zeitangabe', $session->ID );

            if( empty( $value ) ) :
                $value = sprintf( '%1$s bis %2$s',
                    get_field( 'programmpunkt-von', $session->ID ),
                    get_field( 'programmpunkt-bis', $session->ID ) );
            endif;
        break;

        case 'session-title' :
            $value = apply_filters( 'the_content', $session->post_title );
        break;

        case 'session-subtitle' :
            $value = apply_filters( 'the_content', get_field( 'programmpunkt-untertitel', $session->ID ) );
        break;

        case 'session-location' :
            $value = congressomat_get_location( get_field( 'programmpunkt-location', $session->ID ) );
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
                $value = implode( ' ', $speakers_list );
            endif;
        break;
    endswitch;

    return $value;
}
