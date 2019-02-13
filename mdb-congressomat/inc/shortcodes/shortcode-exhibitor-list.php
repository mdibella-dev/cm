<?php
/**
 * Shortcodes für besondere redaktionelle Zwecke
 *
 * @author Marco Di Bella <mdb@marcodibella.de>
 * @package mdb-theme
 **/



/**
 * Shortcode [...]
 * Erzeugt eine Teaserliste mit den zuletzt veröffentlichten Artikeln.
 *
 * @since 1.0.0
 **/

function mdb_shortcode_exhibitor_list( $atts, $content = null )
{
    // Variablen setzen
    global $post;
           $buffer = '';

    // Parameter auslesen
    extract( shortcode_atts( array(
                             'partnership' => ''
                             ), $atts ) );

    // Aussteller holen
    $articles = get_posts( array(
                           'post_type'      => 'partner',
                           'post_status'    => 'publish',
                           'posts_per_page' => '-1',
                           'exclude'        => $exclude,
                           'order'          => 'ASC',
                           'orderby'        => 'title'
                           ) );

    // Ausgabe
    if( $articles ) :
        // Ausgabe puffern
        ob_start();
?>
<div class="partner-list">
<?php
        foreach( $articles as $post ) :
            setup_postdata( $post );
?>
<article class="<?php echo implode( ' ', get_post_class( 'partner', $post->ID ) ); ?>">
<div class="partner-image">
<?php the_post_thumbnail( $post->ID, 'full' ); ?>
</div>
<div class="partner-content">
<!--
<h2><?php the_title(); ?></h2>
<?php the_excerpt(); ?>

<p class="exhibitor-more">
<a href="<?php the_permalink(); ?>" title="<?php _e( 'Mehr erfahren', TEXT_DOMAIN ); ?>"><?php _e( 'Mehr erfahren', TEXT_DOMAIN ); ?></a>
</p>
-->
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

add_shortcode( 'exhibitor-list', 'mdb_shortcode_exhibitor_list' );
