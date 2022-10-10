<?php
/**
 * Shortcode [icon-wall]
 *
 * @author  Marco Di Bella 
 * @package cm
 */


defined( 'ABSPATH' ) or exit;



/**
 * Shortcode zum Erzeugen einer "Mauer" mit den Logos der Kooperationspartner
 *
 * @since  2.3.0
 * @param  array   $atts    die Attribute (Parameter) des Shorcodes
 *         - partnership    (optional) Die Kooperationsform(en) nach der gefiltert werden soll.
 *                          Die Kooperationsformen müssen in Form einer kommaseparierten Liste ihrer Identifikationsnummern vorliegen
 *         - link           (optional) Legt fest, ob und wie das Logo verlinkt werden soll (none, internal, external)
 * @return string           die vom Shortcode erzeugte Ausgabe
 */

function cm_shortcode_icon_wall( $atts, $content = null )
{
    // Übergebene Parameter ermitteln
    $default_atts = array(
        'partnership' => '',
        'link'        => 'none',
    );
    extract( shortcode_atts( $default_atts, $atts ) );

    $link         = strtolower( trim( $link ) );
    $link_options = array(
        'none',
        'internal',
        'external',
    );

    if( !in_array( $link, $link_options ) ) :
        $link = 'none';
    endif;


    // Daten abrufen und aufbereiten
    // Optional kann hierbei nach Kooperationsform gefiltert werden
    $query = array(
        'post_type'      => 'partner',
        'post_status'    => 'publish',
        'posts_per_page' => '-1',
        'order'          => 'ASC',
        'orderby'        => 'title',
    );

    if( ! empty( $partnership ) ) :
        $query[ 'tax_query' ] = array( array(
            'taxonomy' => 'partnership',
            'field'    => 'term_id',
            'terms'    => explode(',', $partnership ),
        ) );
    endif;

    $partners = get_posts( $query );


    // Ausgabe
    if( $partners ) :
        ob_start();
?>

<ul class="icon-wall">
    <?php
    foreach( $partners as $partner ) :

        // Datensatz holen
        $data = cm_get_partner_dataset( $partner->ID );


        // Quadratische Logos?
        $li_class = '';
        $thumb    = wp_get_attachment_metadata( get_post_thumbnail_id( $data[ 'id' ] ) );

        if( $thumb[ 'width' ] == $thumb[ 'height' ] ) :
            $li_class = ' class="is-squared"';
        endif;
    ?>
    <li<?php echo $li_class; ?>>
        <?php
        switch( $link ) :
            case 'internal' :
                echo sprintf(
                    '<a href="%1$s" target="_self" title="%2$s">',
                    $data[ 'permalink' ],
                    __( 'Detailsseite aufrufen', 'cm' ),
                );
            break;

            case 'external' :
                if( ! empty( $data[ 'website' ] ) ) :
                    echo sprintf(
                        '<a href="%1$s" target="blank" title="%2$s">',
                        $data[ 'website' ],
                        __( 'Webseite aufrufen', 'cm' ),
                    );
                endif;
            break;

            case 'none' :
            break;
        endswitch;

        echo get_the_post_thumbnail( $data[ 'id' ], 'full' );

        switch( $link ) :
            case 'internal' :
                echo '</a>';
            break;

            case 'external' :
                if( ! empty( $data[ 'website' ] ) ) :
                    echo '</a>';
                endif;
            break;

            case 'none' :
            break;
        endswitch;
        ?>
    </li>
    <?php endforeach; ?>
</ul>

<?php
        // Ausgabenpufferung beenden und Puffer ausgeben
        $output = ob_get_contents();
        ob_end_clean();
        return $output;
    endif;

    return null;
}

add_shortcode( 'icon-wall', 'cm_shortcode_icon_wall' );
