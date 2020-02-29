<?php
/**
 * Shortcode [faq]
 *
 * Erzeugt eine Liste mit den Kooperationspartnern
 *
 * Folgende Parameter können verwendet werden:
 * @param   faq
 *
 * @author  Marco Di Bella <mdb@marcodibella.de>
 * @package congressomat
 */

function congressomat_shortcode_faq( $atts, $content = null )
{
    /**
     * Parameter auslesen
     **/

    $default_atts = array(
        'faq' => '',
    );

    extract( shortcode_atts( $default_atts, $atts ) );


    /**
     * Daten abrufen und aufbereiten
     **/

    if( have_rows( 'faq', $faq ) ) :

        // Beginn der Ausgabenpufferung
        ob_start();
?>

<div class="faq-accordion">
    <ul>

        <?php
        while( have_rows( 'faq', $faq ) ) :
            the_row();
        ?>

        <li class="faq-element">
            <div class="faq-question">
                <span class="faq-arrow">
                    <i class="fal fa-long-arrow-right"></i>
                </span>

                <span>
                    <?php echo wp_strip_all_tags( apply_filters( 'the_content', get_sub_field( 'question' ) ) ); ?>
                </span>
            </div>

            <div class="faq-answer">
                <?php echo apply_filters( 'the_content', get_sub_field( 'answer' ) );?>
            </div>
        </li>

        <?php
        endwhile;
        ?>

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

add_shortcode( 'faq', 'congressomat_shortcode_faq' );
