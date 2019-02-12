<?php
/**
 * Shortcodes für besondere redaktionelle Zwecke
 *
 * @author Marco Di Bella <mdb@marcodibella.de>
 * @package mdb-theme
 **/




/**
 * Shortcode [teaserpage]
 * Erzeugt eine modifizierte Teaserliste mit den zuletzt veröffentlichten Artikeln und einer Pagnination.
 *
 * @since 1.0.0
 **/

function mdb_shortcode_teaser_page( $atts, $content = null )
{
    // Variablen setzen
    global $post;
           $buffer = '';

    // Parameter auslesen
    extract( shortcode_atts( array(
                             'post_type'      => 'post',
                             'posts_per_page' => get_option( 'posts_per_page' ),
                             ), $atts ) );

    $get_prt  = isset( $_GET[ 'prt' ] )? $_GET[ 'prt' ] : 1;
    $max_page = round( sizeof( get_posts( array(
                                          'post_type'      => $post_type,
                                          'post_status'    => 'publish',
                                          'posts_per_page' => -1 ) ) ) / $posts_per_page ) ;

    // Aktuelle Seite ermitteln
    if( $get_prt <= 1 ) :
        $current_page = 1;
    elseif( $get_prt >= $max_page ) :
        $current_page = $max_page;
    else :
        $current_page = $get_prt;
    endif;

    // Artikel abrufen
    $articles = get_posts( array(
                           'post_type'      => $post_type,
                           'post_status'    => 'publish',
                           'order'          => 'DESC',
                           'orderby'        => 'date',
                           'posts_per_page' => $posts_per_page,
                           'offset'         => ($current_page - 1) * $posts_per_page ) );

    // Ausgabe
    if( $articles ) :
        // Ausgabe puffern
        ob_start();

        // Einführende Pagination
        mdb_get_teaser_pagination( $current_page, $max_page );
?>
<div class="teaser-list">
<?php
        foreach( $articles as $post ) :
            setup_postdata( $post );
?>
<article class="<?php echo implode( ' ', get_post_class( 'teaser', $post->ID ) ); ?>">
<div class="teaser-image">
<a href="<?php the_permalink(); ?>" title="<?php _e( 'Mehr erfahren', TEXT_DOMAIN ); ?>">
<?php the_post_thumbnail( $post->ID, 'full' ); ?>
</a>
</div>
<div class="teaser-content">
<h2><?php the_title(); ?></h2>
<?php the_excerpt(); ?>
<p class="teaser-more">
<a href="<?php the_permalink(); ?>" title="<?php _e( 'Mehr erfahren', TEXT_DOMAIN ); ?>"><?php _e( 'Mehr erfahren', TEXT_DOMAIN ); ?></a>
</p>
</div>
</article>
<?php
        endforeach;
        wp_reset_postdata();
?>
</div>
<?php
        // Abschließende Pagination
        mdb_get_teaser_pagination( $current_page, $max_page );

        // Ausgabenpuffer sichern; Pufferung beenden
        $buffer = ob_get_contents();
        ob_end_clean();
    endif;

    return $buffer;
}

add_shortcode( 'teaserpage', 'mdb_shortcode_teaser_page' );



/**
 * Erzeugt eine Pagination für die Teaserliste
 *
 * @since 1.0.0
 **/

function mdb_get_teaser_pagination( $current_page, $max_page )
{
    echo '<nav class="teaser-list-pagination">';

    echo sprintf( '<a href="%1$s" class="btn%3$s" title="%2$s"><i class="far fa-chevron-left"></i></a>',
                  add_query_arg( 'prt', $current_page - 1 ),
                  __( 'Vorhergehende Seite', TEXT_DOMAIN ),
                  ( $current_page != 1 )? '' : ' disabled' );

    echo sprintf( '<a href="%1$s" class="btn%3$s" title="%2$s"><i class="far fa-chevron-right"></i></a>',
                  add_query_arg( 'prt', $current_page + 1 ),
                  __( 'Nächste Seite', TEXT_DOMAIN ),
                  ( $current_page != $max_page )? '' : ' disabled' );
    echo '</nav>';
}
