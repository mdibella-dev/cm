<?php
/**
 * Shortcode [speaker-grid]
 *
 * Erzeugt eine Grid-Ansicht mit den Bildern, Namen und Positionsbeschreibungen der Referenten eines oder mehrerer Events.
 * Wird keine Angaben zu den Events gemacht, so werden die im Backend als aktiv gekennzeichneten Events zur Grundlage gemacht.
 *
 * Folgende Parameter können verwendet werden:
 * @param   event   (optional) Kommaseparierte Liste von Events, aus denen die Referenten bestimmt werden sollen.
 * @param   exclude (optional) Kommaseparierte Liste von Referenten, die nicht angezeigt werden sollen.
 * @param   show    (optional) Die Anzahl der anzuzeigenden Referenten. Wenn nichts angegeben wird, werden alle gefundenen Referenten angezeigt.
 * @param   shuffle (optional, nur in Verbindung mir show) Randomisiert die Referentenauswahl vor der Auswahl durch show.
 *
 * @author  Marco Di Bella <mdb@marcodibella.de>
 * @package congressomat
 */

function cm_shortcode_speaker_grid( $atts, $content = null )
{
    /**
     * Parameter auslesen
     **/

    $default_atts = array(
        'event'   => '-1', // nur aktive Events
        'exclude' => '',
        'show'    => 0,
        'shuffle' => 0,
    );

    extract( shortcode_atts( $default_atts, $atts ) );


    /**
     * Daten abrufen und aufbereiten
     **/

    $speakers = cm_get_speaker_datasets( ( $event == '-1' )? cm_get_active_events() : $event );

    if( $speakers ) :

        // Optional: Ausschluss bestimmtet Speaker
        $exclude_ids = explode( ',', str_replace(" ", "", $exclude ) );

        foreach( $speakers as $speaker ) :
            if( in_array( $speaker[ 'id' ], $exclude_ids ) == false ) :
                $speaker_list[] = $speaker;
            endif;
        endforeach;


        // Optional: Beschnitt der Ausgabe
        if( ( is_numeric( $show ) == true )
            and ( $show > 0 )
            and ( $show < sizeof( $speaker_list ) ) ) :

            // Optional: Ausgabe durchmischen
            if( $shuffle == 1 ) :
                shuffle( $speaker_list );
                $speaker_list = array_slice( $speaker_list, 0, $show );
                $speaker_list = cm_sort_speaker_datasets( $speaker_list );
            else :
                $speaker_list = array_slice( $speaker_list, 0, $show );
            endif;
        endif;


        /**
         * Ausgabe
         **/

        // Beginn der Ausgabenpufferung
        ob_start();

?>
<div class='speaker-grid'>

    <ul>

        <?php foreach( $speaker_list as $speaker ) : ?>

        <li>
            <figure class="squared">

                <a href="<?php echo $speaker[ 'permalink' ]; ?>"
                   title="<?php echo sprintf( __( 'Mehr über %1$s erfahren', 'congressomat' ), $speaker[ 'title_name' ] ); ?>">
                   <?php echo get_the_post_thumbnail( $speaker[ 'id' ], 'full' ); ?>
                </a>

                <figcaption class="speaker-caption">

                    <p class="speaker-title-name">
                        <a href="<?php echo $speaker[ 'permalink' ]; ?>"
                           title="<?php echo sprintf( __( 'Mehr über %1$s erfahren', 'congressomat' ), $speaker[ 'title_name' ] ); ?>">
                           <?php echo $speaker[ 'title_name' ]; ?>
                        </a>
                    </p>

                    <p class="speaker-position">
                        <?php echo $speaker[ 'position' ]; ?>
                    </p>

                </figcaption>

            </figure>

        </li>

        <?php endforeach; ?>

    </ul>

</div>

<?php
        // Ende der Ausgabenpufferung
        $output_buffer = ob_get_contents();
        ob_end_clean();

        // Ausgabe
        return $output_buffer;
    endif;

    return null;
}

add_shortcode( 'speaker-grid', 'cm_shortcode_speaker_grid' );
