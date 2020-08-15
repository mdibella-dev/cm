<?php
/**
 * Shortcode [icon-wall]
 * Erzeugt eine "Mauer" mit den Logos der Kooperationspartner
 *
 * Folgende Parameter können verwendet werden:
 * @param   partnership (optional)
 *                      Die Kooperationsform(en) nach der gefiltert werden soll.
 *                      Die Kooperationsformen müssen in Form einer kommaseparierten Liste ihrer Identifikationsnummern vorliegen
 * @param   link        (optional)
 *                      Legt fest, ob und wie das Logo verlinkt werden soll (none, internal, external)
 *
 * @author  Marco Di Bella <mdb@marcodibella.de>
 * @package congressomat
 */

function congressomat_shortcode_icon_wall( $atts, $content = null )
{
    /* Übergebene Parameter ermitteln */

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

<ul class="icon-wall">
    <?php
    foreach( $partners as $partner ) :

        /* Datensatz holen */

        $data = congressomat_get_partner_dataset( $partner->ID );
    ?>
    <li>
        <?php
        switch( $link ) :

            case 'internal' :
                echo sprintf( '<a href="%1$s" target="_self" title="%2$s">',
                    $data[ 'permalink' ],
                    __( 'Detailsseite aufrufen'),
                );
            break;

            case 'external' :
                if( !empty( $data[ 'website' ] ) ) :
                    echo sprintf( '<a href="%1$s" target="blank" title="%2$s">',
                        $data[ 'website' ],
                        __( 'Webseite aufrufen'),
                    );
                endif;
            break;

            case 'none' :
            break;

        endswitch;

        echo get_the_post_thumbnail( $partner->ID, 'full' );

        switch( $link ) :

            case 'internal' :
                echo '</a>';
            break;

            case 'external' :
                if( !empty( $data[ 'website' ] ) ) :
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
        /* Ausgabenpufferung beenden und Puffer ausgeben */

        $output_buffer = ob_get_contents();
        ob_end_clean();
        return $output_buffer;
    endif;

    return NULL;
}

add_shortcode( 'icon-wall', 'congressomat_shortcode_icon_wall' );
