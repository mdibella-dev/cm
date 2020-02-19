<?php
/**
 * Shortcode [partner-list]
 * Erzeugt eine Liste mit den Kooperationspartnern
 *
 * Folgende Parameter können verwendet werden:
 * @param   partnership (optional) Die Kooperationsform(en) nach der gefiltert werden soll.
 *                      Die Kooperationsformen müssen in Form einer kommaseparierten Liste ihrer Identifikationsnummern vorliegen.
 *
 * @author  Marco Di Bella <mdb@marcodibella.de>
 * @package congressomat
 */

function cm_shortcode_partner_list( $atts, $content = null )
{
    /**
     * Parameter auslesen
     **/

    $default_atts = array(
        'partnership' => '',
    );

    extract( shortcode_atts( $default_atts, $atts ) );


    /**
     * Daten abrufen und aufbereiten
     **/

    // Grundlegende Datenabfrage
    $query = array(
        'post_type'      => 'partner',
        'post_status'    => 'publish',
        'posts_per_page' => '-1',
        'order'          => 'ASC',
        'orderby'        => 'title',
    );

    // Optional: Nach Kooperationsform filtern
    if( !empty( $partnership ) ) :
        $query[ 'tax_query' ] = array( array(
            'taxonomy' => 'partnership',
            'field'    => 'term_id',
            'terms'    => explode(',', $partnership ),
        ) );
    endif;

    // Daten holen
    $partners = get_posts( $query );


    /**
     * Ausgabe
     **/

    if( $partners ) :

        // Beginn der Ausgabenpufferung
        ob_start();
?>

<ul class="partner-list">
    <?php foreach( $partners as $partner ) : ?>
    <li>
        <?php echo get_the_post_thumbnail( $partner->ID, 'full' ); ?>
    </li>
    <?php endforeach; ?>
</ul>

<?php
        // Ende der Ausgabenpufferung
        $output_buffer = ob_get_contents();
        ob_end_clean();

        // Ausgabe
        return $output_buffer;
    endif;

    return null;
}

add_shortcode( 'partner-list', 'cm_shortcode_partner_list' );
