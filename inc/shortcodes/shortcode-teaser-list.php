<?php
/**
 * Shortcode [teaser-list]
 *
 * @author  Marco Di Bella <mdb@marcodibella.de>
 * @package congressomat
 */


defined( 'ABSPATH' ) OR exit;



/**
 * Erzeugt eine Teaserliste mit den zuletzt veröffentlichten Artikeln.
 *
 * @since   1.0.0
 *
 * @param   array   $atts   die Attribute (Parameter) des Shorcodes
 *          - paged         (optional) Bestimmt, ob eine Teaserliste mit (1) oder ohne (0) Pagination angezeigt werden soll.
 *          - show          (optional) Bestimmt die Anzahl der Teaser, die entweder insgesamt (non-paged) oder pro Seite (paged) angezeigt werden sollen.
 *                          Standardwerte sind 4 (non-paged) oder die im Backend hinterlegte Angabe für Archivseiten
 *          - exclude       (optional) Kommaseparierte Liste von Beiträgen (IDs), die nicht angezeigte werden sollen
 *          - shuffle       (optional) Durchmischt die ausgegebenen Teaser (1, nur bei non-paged), statt sie chronologisch absteigend aufzulisten (0)
 * @return  string          die vom Shortcode erzeugte Ausgabe
 */

function cm_shortcode_teaser_list( $atts, $content = null )
{
    /* Übergebene Parameter ermitteln */

    $default_atts = array(
        'show'      => '',
        'paged'     => '0',
        'exclude'   => '',
        'shuffle'   => '0',
        'category'  => '0',
    );

    extract( shortcode_atts( $default_atts, $atts ) );


    /* Variablen setzen */

    global $post;
           $exclude_ids = explode( ',', str_replace( " ", "", $exclude ) );
           $offset      = 0;
           $orderby     = 'date';


    /* In Abhängigkeit des Anzeige-Modus (paged/non-paged) die jeweils benötigten Werte ermitteln */

    if( $paged == 1 ) :
        $show     = empty ( $show )? get_option( 'posts_per_page' ) : $show;
        $haystack = array(
            'exclude'        => $exclude_ids,
            'category'       => $category,
            'post_type'      => 'post',
            'post_status'    => 'publish',
            'posts_per_page' => -1
        );
        $max_page = ceil( sizeof( get_posts( $haystack ) ) / $show ) ;
        $get_prt  = isset( $_GET[ 'prt' ] )? $_GET[ 'prt' ] : 1;

        if( $get_prt <= 1 ) :
            $current_page = 1;
        elseif( $get_prt >= $max_page ) :
            $current_page = $max_page;
        else :
            $current_page = $get_prt;
        endif;

        $offset = ($current_page - 1) * $show; /* Startpunkt */
    else :
        $show = empty ( $show )? 4 : $show;

        if( $shuffle == 1 ) :
            $orderby = 'rand';
        endif;
    endif;


    /* Daten abrufen und aufbereiten */

    $query = array(
        'exclude'        => $exclude_ids,
        'post_type'      => 'post',
        'post_status'    => 'publish',
        'order'          => 'DESC',
        'category'       => $category,
        'orderby'        => $orderby,
        'posts_per_page' => $show,
        'offset'         => $offset,
    );
    $articles = get_posts( $query );


    /* Ausgabe vorbereiten */

    if( $articles ) :

        ob_start();
?>

<div class="teaser-list<?php echo ( $paged == 1 )? ' teaser-list-has-pagination' : ''; ?>">

    <?php
    if( $paged == 1 ) :
        cm_shortcode_teaser_list__echo_pagination( $current_page, $max_page );
    endif;
    ?>

    <ul>
        <?php
        foreach( $articles as $post ) :
            setup_postdata( $post );
        ?>

        <li>
            <article class="<?php echo implode( ' ', get_post_class( $post->ID ) ); ?>">
                <a class="teaser-list-element" href="<?php the_permalink(); ?>" title="<?php _e( 'Mehr erfahren', 'congressomat' ); ?>" rel="prev">
                    <div class="teaser-image">
                        <?php the_post_thumbnail( $post->ID, 'full' ); ?>
                    </div>
                    <div class="teaser-content">
                        <h2><?php the_title(); ?></h2>
                        <?php the_excerpt(); ?>
                    </div>
                </a>
            </article>
        </li>

        <?php
        endforeach;
        wp_reset_postdata();
        ?>

    </ul>

    <?php
    if( $paged == 1 ) :
        cm_shortcode_teaser_list__echo_pagination( $current_page, $max_page );
    endif;
    ?>

</div>

<?php
        /* Ausgabenpufferung beenden und Puffer ausgeben */

        $output_buffer = ob_get_contents();
        ob_end_clean();
        return $output_buffer;
    endif;

    return NULL;
}

add_shortcode( 'teaser-list', 'cm_shortcode_teaser_list' );



/**
 * Hilfsfunktion für die Teaserliste zur Ausgabe einer Pagination
 *
 * @since 1.0.0
 **/

function cm_shortcode_teaser_list__echo_pagination( $current_page, $max_page )
{
    echo '<nav>';

    echo sprintf( '<div class="wp-block-button is-fa-button%3$s"><a href="%1$s" class="wp-block-button__link" title="%2$s" rel="prev"><i class="fas fa-chevron-left"></i></a></div>',
                  add_query_arg( 'prt', $current_page - 1 ),
                  __( 'Vorhergehende Seite', 'congressomat' ),
                  ( $current_page != 1 )? '' : ' disabled' );

    echo sprintf( '<div class="pageinfo"><span>%1$s</span></div>',
                  sprintf( __( 'Seite %1$s/%2$s', 'congressomat' ), $current_page, $max_page ) );

    echo sprintf( '<div class="wp-block-button is-fa-button%3$s"><a href="%1$s" class="wp-block-button__link" title="%2$s" rel="next"><i class="fas fa-chevron-right"></i></a></div>',
                  add_query_arg( 'prt', $current_page + 1 ),
                  __( 'Nächste Seite', 'congressomat' ),
                  ( $current_page != $max_page )? '' : ' disabled' );
    echo '</nav>';
}
