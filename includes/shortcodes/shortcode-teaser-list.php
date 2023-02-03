<?php
/**
 * Shortcode [teaser-list].
 *
 * @author  Marco Di Bella
 * @package cm
 */


/** Prevent direct access */

defined( 'ABSPATH' ) or exit;



/**
 * Generates a teaser list with the most recently published articles.
 *
 * @since 1.0.0
 *
 * @param array $atts die Attribute (Parameter) des Shorcodes
 *                    - paged (optional)
 *                      Bestimmt, ob eine Teaserliste mit (1) oder ohne (0) Pagination angezeigt werden soll.
 *                    - show (optional)
 *                      Bestimmt die Anzahl der Teaser, die entweder insgesamt (non-paged) oder pro Seite (paged) angezeigt werden sollen.
 *                      Standardwerte sind 4 (non-paged) oder die im Backend hinterlegte Angabe für Archivseiten
 *                    - exclude (optional)
 *                      Kommaseparierte Liste von Beiträgen (IDs), die nicht angezeigte werden sollen
 *                    - shuffle (optional)
 *                      Durchmischt die ausgegebenen Teaser (1, nur bei non-paged), statt sie chronologisch absteigend aufzulisten (0)
 *
 * @return string die vom Shortcode erzeugte Ausgabe
 */

function cm_shortcode_teaser_list( $atts, $content = null )
{
    /** Determine passed parameters. */

    $default_atts = array(
        'show'      => '',
        'paged'     => '0',
        'exclude'   => '',
        'shuffle'   => '0',
        'category'  => '0',
    );
    extract( shortcode_atts( $default_atts, $atts ) );


    /** Retrieve and prepare data. */

    global $post;
           $exclude_ids = explode( ',', str_replace( " ", "", $exclude ) );
           $offset      = 0;
           $orderby     = 'date';


    // Determine the required values depending on the display mode (paged/non-paged)
    if( 1 == $paged ) :
        $show     = empty ( $show )? get_option( 'posts_per_page' ) : $show;
        $haystack = array(
            'exclude'        => $exclude_ids,
            'category'       => $category,
            'post_type'      => 'post',
            'post_status'    => 'publish',
            'posts_per_page' => -1,
        );
        $max_page = ceil( sizeof( get_posts( $haystack ) ) / $show ) ;
        $get_prt  = isset( $_GET['prt'] )? $_GET['prt'] : 1;

        if( $get_prt <= 1 ) :
            $current_page = 1;
        elseif( $get_prt >= $max_page ) :
            $current_page = $max_page;
        else :
            $current_page = $get_prt;
        endif;

        $offset = ($current_page - 1) * $show; // starting point
    else :
        $show = empty ( $show )? 4 : $show;

        if( 1 == $shuffle ) :
            $orderby = 'rand';
        endif;
    endif;

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


    /** Do the shortcode stuff and start the output. */

    if( $articles ) :
        ob_start();
?>
<div class="teaser-list<?php echo ( 1 == $paged )? ' teaser-list-has-pagination' : ''; ?>">

    <?php
    if( 1 == $paged ) :
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
                <a class="teaser-list-element" href="<?php the_permalink(); ?>" title="<?php echo __( 'Mehr erfahren', 'cm' ); ?>" rel="prev">
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
    if( 1 == $paged ) :
        cm_shortcode_teaser_list__echo_pagination( $current_page, $max_page );
    endif;
    ?>

</div>

<?php
        $output = ob_get_contents();
        ob_end_clean();
        return $output;
    endif;

    return null;
}

add_shortcode( 'teaser-list', 'cm_shortcode_teaser_list' );



/**
 * Helper function for the teaser list to output a pagination.
 *
 * @since 1.0.0
 */

function cm_shortcode_teaser_list__echo_pagination( $current_page, $max_page )
{
    ob_start();
?>
<nav>
    <div class="wp-block-button is-fa-button<?php echo ( 1 != $current_page )? '' : ' disabled'; ?>">
        <a href="<?php echo add_query_arg( 'prt', $current_page - 1 ); ?>" class="wp-block-button__link" title="<?php echo __( 'Vorhergehende Seite', 'cm' ); ?>" rel="prev"><i class="fas fa-chevron-left"></i></a>
    </div>
    <div class="pageinfo">
        <span><?php echo sprintf( __( 'Seite %1$s/%2$s', 'cm' ), $current_page, $max_page ); ?></span>
    </div>
    <div class="wp-block-button is-fa-button<?php echo ( $max_page != $current_page )? '' : ' disabled'; ?>">
        <a href="<?php echo add_query_arg( 'prt', $current_page + 1 ); ?>" class="wp-block-button__link" title="<?php echo __( 'Nächste Seite', 'cm' ); ?>" rel="next"><i class="fas fa-chevron-right"></i></a>
    </div>
</nav>
<?php
    $output = ob_get_contents();
    ob_end_clean();
    echo $output;
}
