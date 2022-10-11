<?php
/**
 * Shortcode [exhibition-list]
 *
 * @author  Marco Di Bella
 * @package cm
 */


/** Prevent direct access */

defined( 'ABSPATH' ) or exit;



/**
 * Shortcode zum Erzeugen einer (Aussteller-)Liste mit den Kooperationspartnern
 *
 * @since   2.3.0
 *
 * @param   array   $atts   die Attribute (Parameter) des Shorcodes
 *          - partnership   (optional) Die Kooperationsform(en) nach der gefiltert werden soll.
 *                          Die Kooperationsformen müssen in Form einer kommaseparierten Liste ihrer Identifikationsnummern vorliegen.
 * @return  string          die vom Shortcode erzeugte Ausgabe
 */

function cm_shortcode_exhibition_list( $atts, $content = null )
{
    // Übergebene Parameter ermitteln
    $default_atts = array(
        'partnership' => '',
    );
    extract( shortcode_atts( $default_atts, $atts ) );


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
<ul class="exhibition-list">
    <?php
    foreach( $partners as $partner ) :
        // Datensatz holen
        $data = cm_get_partner_dataset( $partner->ID );
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
                    /**
                     * Leere Eingaben herausfiltern
                     *
                     * @since 2.5.0
                     */
                    $spaces = array();

                    foreach( $data[ 'exhibition-spaces' ] as $space ) :
                        if( ! empty( $space[ 'location' ] ) and ! empty( $space[ 'signature' ] ) ) :
                            $spaces[] = $space;
                        endif;
                    endforeach;

                    if( ! empty( $spaces ) ) :
                    ?>
                        <div>
                            <div>
                                <div><?php echo __( 'Bereich', 'cm' ); ?></div>
                                <div><?php echo __( 'Stand', 'cm' ); ?></div>
                            </div>
                        <?php
                        foreach( $spaces as $space ) :
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
        // Ausgabenpufferung beenden und Puffer
        $output = ob_get_contents();
        ob_end_clean();
        return $output;
    endif;

    return null;
}

add_shortcode( 'exhibition-list', 'cm_shortcode_exhibition_list' );