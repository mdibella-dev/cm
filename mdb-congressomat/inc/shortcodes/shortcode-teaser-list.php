<?php
/**
 * Shortcode [teaser-list]
 *
 * Erzeugt eine Teaserliste mit den zuletzt veröffentlichten Artikeln.
 *
 * Folgende Parameter können verwendet werden:
 * @param   paged   (optional) Bestimmt, ob eine Teaserliste mit (1) oder ohne (0) Pagination angezeigt werden soll.
 * @param   show    (optional) Bestimmt die Anzahl der Teaser, die entweder insgesamt (non-paged) oder pro Seite (paged) angezeigt werden sollen.
 *                             Standardwerte sind 4 (non-paged) oder die im Backend hinterlegte Angabe für Archivseiten
 * @param   exclude (optional) Kommaseparierte Liste von Beiträgen (IDs), die nicht angezeigte werden sollen
 * @param   shuffle (optional) Durchmischt die ausgegebenen Teaser (1, nur bei non-paged), statt sie chronologisch absteigend aufzulisten (0)
 *
 * @author  Marco Di Bella <mdb@marcodibella.de>
 * @package mdb-congressomat
 **/

function mdb_shortcode_teaser_list( $atts, $content = null )
{
    // Variablen setzen
    global $post;
           $buffer = '';

    // Parameter auslesen
    extract( shortcode_atts( array(
                             'show'    => '',
                             'paged'   => '0',
                             'exclude' => '',
                             'shuffle' => '0',
                             ), $atts ) );

    /**
     * Schritt 1
     * Daten abrufen und aufbereiten
     **/

    // optional: bestimmte Artikel ausschließen
    $exclude_ids = explode( ',', str_replace(" ", "", $exclude ) );

    // In Abhängigkeit des Anzeige-Modus (paged/non-paged) die jeweils benötigten Werte ermitteln
    if( $paged == 1 ) :
        $show     = empty ( $show )? get_option( 'posts_per_page' ) : $show;
        $max_page = ceil( sizeof( get_posts( array(
                                              'exclude'        => $exclude_ids,
                                              'post_type'      => 'post',
                                              'post_status'    => 'publish',
                                              'posts_per_page' => -1 ) ) ) / $show ) ;

        // Aktuelle Seite ermitteln
        $get_prt = isset( $_GET[ 'prt' ] )? $_GET[ 'prt' ] : 1;

        if( $get_prt <= 1 ) :
            $current_page = 1;
        elseif( $get_prt >= $max_page ) :
            $current_page = $max_page;
        else :
            $current_page = $get_prt;
        endif;

        // Startpunkt ermitteln
        $offset  = ($current_page - 1) * $show;
        $orderby = 'date';
    else :
        $show   = empty ( $show )? 4 : $show;
        $offset = 0;

        if( $shuffle == 1 ) :
            $orderby = 'rand';
        else :
            $orderby = 'date';
        endif;
    endif;

    // anhand der zuvor ermittelten Daten die Artikel abrufen
    $articles = get_posts( array(
                           'exclude'        => $exclude_ids,
                           'post_type'      => 'post',
                           'post_status'    => 'publish',
                           'order'          => 'DESC',
                           'orderby'        => $orderby,
                           'posts_per_page' => $show,
                           'offset'         => $offset ) );

    /**
     * Schritt 2
     * Ausgabe vorbereiten
     **/

    if( $articles ) :
        // Ausgabe puffern
        ob_start();
?>
<div class="teaser-list<?php echo ( $paged == 1 )? ' teaser-list-has-pagination' : ''; ?>">
<?php
        if( $paged == 1 ) :
            mdb_shortcode_teaser_list__echo_pagination( $current_page, $max_page );
        endif;
?>
<ul>
<?php
        foreach( $articles as $post ) :
            setup_postdata( $post );
?>
<li>
<article class="<?php echo implode( ' ', get_post_class( 'teaser-list-element', $post->ID ) ); ?>">
<div class="teaser-image">
<a href="<?php the_permalink(); ?>" title="<?php _e( 'Mehr erfahren', TEXT_DOMAIN ); ?>" rel="prev">
<?php the_post_thumbnail( $post->ID, 'full' ); ?>
</a>
</div>
<div class="teaser-content">
<h2><?php the_title(); ?></h2>
<?php the_excerpt(); ?>
<p><a href="<?php the_permalink(); ?>" title="<?php _e( 'Mehr erfahren', TEXT_DOMAIN ); ?>" rel="next"><?php _e( 'Mehr erfahren', TEXT_DOMAIN ); ?></a></p>
</div>
</article>
</li>
<?php
        endforeach;
        wp_reset_postdata();
?>
</ul>
<?php
        if( $paged == 1 ) :
            mdb_shortcode_teaser_list__echo_pagination( $current_page, $max_page );
        endif;
?>
</div>
<?php
        // Ausgabenpuffer sichern; Pufferung beenden
        $buffer = ob_get_contents();
        ob_end_clean();
    endif;

    return $buffer;
}

add_shortcode( 'teaser-list', 'mdb_shortcode_teaser_list' );



/**
 * Hilfsfunktion für die Teaserliste zur Ausgabe einer Pagination
 *
 * @since 1.0.0
 **/

function mdb_shortcode_teaser_list__echo_pagination( $current_page, $max_page )
{
    echo '<nav>';

    echo sprintf( '<div class="wp-block-button is-fa-button%3$s"><a href="%1$s" class="wp-block-button__link" title="%2$s" rel="prev"><i class="far fa-chevron-left"></i></a></div>',
                  add_query_arg( 'prt', $current_page - 1 ),
                  __( 'Vorhergehende Seite', TEXT_DOMAIN ),
                  ( $current_page != 1 )? '' : ' disabled' );

    echo sprintf( '<div class="pageinfo"><span>%1$s</span></div>',
                  sprintf( __( 'Seite %1$s/%2$s', TEXT_DOMAIN ), $current_page, $max_page ) );

    echo sprintf( '<div class="wp-block-button is-fa-button%3$s"><a href="%1$s" class="wp-block-button__link" title="%2$s" rel="next"><i class="far fa-chevron-right"></i></a></div>',
                  add_query_arg( 'prt', $current_page + 1 ),
                  __( 'Nächste Seite', TEXT_DOMAIN ),
                  ( $current_page != $max_page )? '' : ' disabled' );
    echo '</nav>';
}
