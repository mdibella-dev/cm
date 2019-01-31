<?php
/**
 * Shortcodes für besondere redaktionelle Zwecke
 *
 * @author Marco Di Bella <mdb@marcodibella.de>
 * @package mdb-theme
 **/



/**
 * Shortcode [teaserlist]
 * Erzeugt einee Teaserliste mit den zuletzt veröffentlichten Artikeln.
 *
 * @since 1.0.0
 **/

function mdb_shortcode_teaserlist( $atts, $content = null )
{
    // Variablen setzen
    global $post;
           $buffer = '';

    // Parameter auslesen
    extract( shortcode_atts( array(
                             'post_type'      => 'post',
                             'posts_per_page' => 4,
                             'exclude'        => '',
                             'orderby'        => 'date',
                             ), $atts ) );

    // Publikationen holen
    $articles = get_posts( array(
                           'post_type'      => $post_type,
                           'post_status'    => 'publish',
                           'posts_per_page' => $posts_per_page,
                           'exclude'        => $exclude,
                           'order'          => 'DESC',
                           'orderby'        => $orderby
                           ) );

    // Ausgabe
    if( $articles ) :
        // Ausgabe puffern
        ob_start();
?>
<div class="teaser-block">
<?php
        foreach( $articles as $post ) :
            setup_postdata( $post );
?>
<article class="<?php echo implode( ' ', get_post_class( 'teaser', $post->ID ) ); ?>">
<div class="teaser-image">
<a href="<?php the_permalink(); ?>" title="<?php _e( 'Mehr', TEXT_DOMAIN ); ?>">
<?php the_post_thumbnail( $post->ID, 'full' ); ?>
</a>
</div>
<div class="teaser-caption">
<h2><?php the_title(); ?></h2>
</div>
</article>
<?php
        endforeach;
        wp_reset_postdata();
?>
</div>
<?php
        // Ausgabenpuffer sichern; Pufferung beenden
        $buffer = ob_get_contents();
        ob_end_clean();
    endif;

    return $buffer;
}

add_shortcode( 'teaserlist', 'mdb_shortcode_teaserlist' );
