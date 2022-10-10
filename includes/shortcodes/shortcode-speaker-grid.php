<?php
/**
 * Shortcode [speaker-grid]
 *
 * @author  Marco Di Bella
 * @package cm
 */


/** Prevent direct access */

defined( 'ABSPATH' ) or exit;



/**
 * Shortcode zum Erzeugen einer Grid-Ansicht mit den Bildern, Namen und Positionsbeschreibungen der Referenten eines oder mehrerer Events.
 * Wird keine Angaben zu den Events gemacht, so werden die im Backend als aktiv gekennzeichneten Events zur Grundlage gemacht.
 *
 * @since  1.0.0
 * @param  array   $atts    die Attribute (Parameter) des Shorcodes
 *         - event          (optional) Kommaseparierte Liste von Events, aus denen die Referenten bestimmt werden sollen.
 *         - exclude        (optional) Kommaseparierte Liste von Referenten, die nicht angezeigt werden sollen.
 *         - show           (optional) Die Anzahl der anzuzeigenden Referenten. Wenn nichts angegeben wird, werden alle gefundenen Referenten angezeigt.
 *         - shuffle        (optional, nur in Verbindung mir show) Randomisiert die Referentenauswahl vor der Auswahl durch show.
 * @return string           die vom Shortcode erzeugte Ausgabe
 */

function cm_shortcode_speaker_grid( $atts, $content = null )
{
    // Übergebene Parameter ermitteln
    $default_atts = array(
        'event'   => '-1', // nur aktive Events
        'exclude' => '',
        'show'    => 0,
        'shuffle' => 0,
    );
    extract( shortcode_atts( $default_atts, $atts ) );


    // Daten abrufen und aufbereiten
    $speakers = cm_get_speaker_datasets( ( $event == '-1' )? implode( ',', cm_get_active_events() ) : $event );

    if( $speakers ) :

        // Optional: Ausschluss bestimmtet Speaker
        $exclude_ids = explode( ',', str_replace(" ", "", $exclude ) );

        foreach( $speakers as $speaker ) :
            if( false == in_array( $speaker['id'], $exclude_ids ) ) :
                $speaker_list[] = $speaker;
            endif;
        endforeach;


        // Optional: Beschnitt der Ausgabe */
        if( ( true == is_numeric( $show ) ) and ( $show > 0 ) and ( $show < sizeof( $speaker_list ) ) ) :

            // Optional: Ausgabe durchmischen
            if( 1 == $shuffle ) :
                shuffle( $speaker_list );
                $speaker_list = array_slice( $speaker_list, 0, $show );
                $speaker_list = cm_sort_speaker_datasets( $speaker_list );
            else :
                $speaker_list = array_slice( $speaker_list, 0, $show );
            endif;

        endif;


        // Ausgabe
        ob_start();
?>
<div class="speaker-grid">
    <ul>
        <?php foreach( $speaker_list as $speaker ) : ?>
        <li>
            <a  class="speaker-grid-element"
                href="<?php echo $speaker['permalink']; ?>"
                title="<?php echo sprintf( __( 'Mehr über %1$s erfahren', 'cm' ), $speaker['title_name'] ); ?>">

                <figure>
                    <?php echo get_the_post_thumbnail( $speaker['id'], 'full', array( 'class' => 'speaker-image' ) ); ?>
                    <figcaption>
                        <div>
                            <p class="speaker-title-name"><?php echo $speaker['title_name']; ?></p>
                            <p class="speaker-position"><?php echo $speaker['position']; ?></p>
                        </div>
                    </figcaption>
                </figure>
            </a>
        </li>
        <?php endforeach; ?>
    </ul>
</div>

<?php
        // Ausgabenpufferung beenden und Puffer ausgeben
        $output = ob_get_contents();
        ob_end_clean();
        return $output;
    endif;

    return null;
}

add_shortcode( 'speaker-grid', 'cm_shortcode_speaker_grid' );
