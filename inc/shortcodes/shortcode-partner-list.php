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

function congressomat_shortcode_partner_list( $atts, $content = null )
{
    /* Übergebene Parameter ermitteln */

    $default_atts = array(
        'partnership' => '',
    );

    extract( shortcode_atts( $default_atts, $atts ) );


    /*
     * Daten abrufen und aufbereiten
     * Optional kann hierbei nach Kooperationsform gefiltert werden
     */

    $query = array(
        'post_type'      => 'partner',
        'post_status'    => 'publish',
        'posts_per_page' => '-1',
        'order'          => 'ASC',
        'orderby'        => 'title',
    );

    if( !empty( $partnership ) ) :
        $query[ 'tax_query' ] = array( array(
            'taxonomy' => 'partnership',
            'field'    => 'term_id',
            'terms'    => explode(',', $partnership ),
        ) );
    endif;

    $partners = get_posts( $query );


    /* Ausgabe */

    if( $partners ) :
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
        /* Ausgabenpufferung beenden und Puffer ausgeben */
        
        $output_buffer = ob_get_contents();
        ob_end_clean();
        return $output_buffer;
    endif;

    return NULL;
}

add_shortcode( 'partner-list', 'congressomat_shortcode_partner_list' );
