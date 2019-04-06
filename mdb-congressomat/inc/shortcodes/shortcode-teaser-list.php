<?php
/**
 * Shortcode [teaser-list]
 * Erzeugt eine Teaserliste mit den zuletzt veröffentlichten Artikeln.
 *
 * Folgende Parameter können verwendet werden:
 * - paged      (optional) Bestimmt, ob eine Teaserliste mit (1) oder ohne (0) Pagination angezeigt werden soll.
 *              Standardwert: 0 (non-paged)
 * - show       (optional) Bestimmt die Anzahl der Teaser, die entweder insgesamt (non-paged) oder pro Seite (paged) angezeigt werden sollen.
 *              Standardwerte:  non-paged:  4
 *                              paged:      die im Backend hinterlegte Angabe für Archivseiten
 * - exclude    (optional) Kommaseparierte Liste von Beiträgen (IDs), die nicht angezeigte werden sollen
 * - shuffle    (optional) Durchmischt die ausgegebenen Teaser (1, nur bei non-paged), statt sie chronologisch absteigend aufzulisten (0)
 *              Standardwert: 0
 *
 * @since 1.0.0
 * @author Marco Di Bella <mdb@marcodibella.de>
 * @package mdb-theme
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

    // Bestimmte Artikel ausschließen wenn gewünscht
    $exclude_ids = explode( ',', str_replace(" ", "", $exclude ) );


    /**
     * Schritt 1
     * In Abhängigkeit des Anzeige-Modus (paged/non-paged) die jeweils benötigten Werte ermitteln
     **/

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


    /**
     * Schritt 2
     * Daten abrufen
     **/

    $articles = get_posts( array(
                           'exclude'        => $exclude_ids,
                           'post_type'      => 'post',
                           'post_status'    => 'publish',
                           'order'          => 'DESC',
                           'orderby'        => $orderby,
                           'posts_per_page' => $show,
                           'offset'         => $offset ) );

    /**
     * Schritt 3
     * Ausgabe vorbereiten abrufen
     **/

    if( $articles ) :
        // Ausgabe puffern
        ob_start();

        if( $paged == 1 ) :
            mdb_get_teaser_pagination( $current_page, $max_page );
        endif;
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
<div class="teaser-more">
<a href="<?php the_permalink(); ?>" class="btn" title="<?php _e( 'Mehr erfahren', TEXT_DOMAIN ); ?>"><?php _e( 'Mehr erfahren', TEXT_DOMAIN ); ?></a>
</div>
</div>
</article>
<?php
        endforeach;
        wp_reset_postdata();
?>
</div>
<?php
        if( $paged == 1 ) :
            mdb_get_teaser_pagination( $current_page, $max_page );
        endif;

        // Ausgabenpuffer sichern; Pufferung beenden
        $buffer = ob_get_contents();
        ob_end_clean();
    endif;

    return $buffer;
}

add_shortcode( 'teaser-list', 'mdb_shortcode_teaser_list' );



/**
 * Erzeugt eine Pagination für die Teaserliste
 *
 * @since 1.0.0
 **/

function mdb_get_teaser_pagination( $current_page, $max_page )
{
    echo '<nav class="teaser-list-pagination">';

    echo sprintf( '<a href="%1$s" class="btn%3$s" title="%2$s" rel="prev"><i class="far fa-chevron-left"></i></a>',
                  add_query_arg( 'prt', $current_page - 1 ),
                  __( 'Vorhergehende Seite', TEXT_DOMAIN ),
                  ( $current_page != 1 )? '' : ' disabled' );

    echo sprintf( '<span class="pageinfo">%1$s</span>',
                  sprintf( __( 'Seite %1$s/%2$s', TEXT_DOMAIN ), $current_page, $max_page ) );

    echo sprintf( '<a href="%1$s" class="btn%3$s" title="%2$s" rel="next"><i class="far fa-chevron-right"></i></a>',
                  add_query_arg( 'prt', $current_page + 1 ),
                  __( 'Nächste Seite', TEXT_DOMAIN ),
                  ( $current_page != $max_page )? '' : ' disabled' );
    echo '</nav>';
}
