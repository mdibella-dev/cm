<?php
/**
 * Shortcode [exhibition-list]
 * Erzeugt eine (Aussteller-)Liste mit den Kooperationspartnern
 *
 * Folgende Parameter können verwendet werden:
 * @param   partnership (optional) Die Kooperationsform(en) nach der gefiltert werden soll.
 *                      Die Kooperationsformen müssen in Form einer kommaseparierten Liste ihrer Identifikationsnummern vorliegen.
 *
 * @author  Marco Di Bella <mdb@marcodibella.de>
 * @package congressomat
 */

function congressomat_shortcode_exhibition_list( $atts, $content = null )
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

<ul class="exhibition-list">

    <?php
    foreach( $partners as $partner ) :

        /* Datensatz holen */

        $data = congressomat_get_partner_dataset( $partner->ID );
    ?>

    <li class="exhibition-list-element">

        <a href="<?php echo $data[ 'permalink' ]; ?>">

            <figure>
                <?php echo get_the_post_thumbnail( $partner->ID, 'full' ); ?>
            </figure>

            <div>

                <h3><?php echo $data[ 'title' ]; ?></h3>

                <div class="exhibition-list-layout">
                    <div><?php echo $data[ 'address' ];?></div>

                    <div>
                    <?php
                    if( !empty( $data[ 'exhibition-spaces' ] ) ) :
                    ?>
                        <div>
                            <div>
                                <div><?php echo __( 'Bereich', 'congressomat' ); ?></div>
                                <div><?php echo __( 'Stand', 'congressomat' ); ?></div>
                            </div>
                        <?php
                        foreach( $data[ 'exhibition-spaces' ] as $space ) :
                        ?>
                            <div>
                                <div><?php echo $space[ 'location' ];?></div>
                                <div><?php echo $space[ 'signature' ];?></div>
                            </div>
                        <?php
                        endforeach;
                        ?>
                        </div>
                    <?php
                    endif;
                    ?>
                    </div>

                    <div>
                        <div class="wp-block-button is-fa-button">
                            <span class="wp-block-button__link">
                                <i class="fas fa-chevron-double-right"></i>
                            </span>
                        </div>
                    </div>
                </div>

            </div>

        </a>

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

add_shortcode( 'exhibition-list', 'congressomat_shortcode_exhibition_list' );