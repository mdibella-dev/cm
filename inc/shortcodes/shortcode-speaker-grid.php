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

function congressomat_shortcode_speaker_grid( $atts, $content = null )
{
    // Variablen setzen
    $buffer = '';

    // Parameter auslesen
    extract( shortcode_atts( array(
                             'event'   => '',
                             'exclude' => '',
                             'show'    => 0,
                             'shuffle' => 0
                            ), $atts ) );

    /**
     * Schritt 1
     * Daten abrufen und aufbereiten
     **/

    // optional: nur die Speaker von derzeit aktiven Events
    if( $event == '-1' ) :
        $event = congressomat_get_active_events();
    endif;

    $speakers = congressomat_get_speaker_datasets( $event );

    if( $speakers ) :
        // optional: bestimmte Speaker ausschließen
        $exclude_ids = explode( ',', str_replace(" ", "", $exclude ) );

        foreach( $speakers as $speaker ) :
            if( in_array( $speaker[ 'id' ], $exclude_ids ) == FALSE ) :
                $speaker_list[] = $speaker;
            endif;
        endforeach;

        // optional: Ausgabe beschneiden
        if( ( is_numeric( $show ) == TRUE )
            and ( $show > 0 )
            and ( $show < sizeof( $speaker_list ) ) ) :

            // optional: Ausgabe durchmischen
            if( $shuffle == 1 ) :
                shuffle( $speaker_list );
            endif;

            $speaker_list = array_slice( $speaker_list, 0, $show );

            // falls vorher durchmischt: Ergebnis wieder sortieren
            if( $shuffle == 1 ) :
                $speaker_list = congressomat_sort_speaker_datasets( $speaker_list );
            endif;
        endif;


        /**
         * Schritt 2
         * Ausgabe vorbereiten
         **/

        ob_start();
?>
<div class='speaker-grid'>
<ul>
<?php
    foreach( $speaker_list as $speaker ) :
?>
<li>
<figure class="squared">
<a href="<?php echo $speaker[ 'permalink' ]; ?>"
   title="<?php echo sprintf( __( 'Mehr über %1$s erfahren', 'congressomat' ), $speaker[ 'title_name' ] ); ?>">
<?php echo get_the_post_thumbnail( $speaker[ 'id' ], 'full' ); ?></a>
<figcaption class="speaker-caption">
<p class="speaker-title-name">
<a href="<?php echo $speaker[ 'permalink' ]; ?>"
   title="<?php echo sprintf( __( 'Mehr über %1$s erfahren', 'congressomat' ), $speaker[ 'title_name' ] ); ?>">
<?php echo $speaker[ 'title_name' ]; ?></a></p>
<p class="speaker-position"><?php echo $speaker[ 'position' ]; ?></p>
</figcaption>
</figure>
</li>
<?php
    endforeach;
?>
</ul>
</div>
<?php
        // Ausgabenpuffer sichern; Pufferung beenden
        $buffer = ob_get_contents();
        ob_end_clean();
    endif;

    return $buffer;
}

add_shortcode( 'speaker-grid', 'congressomat_shortcode_speaker_grid' );
