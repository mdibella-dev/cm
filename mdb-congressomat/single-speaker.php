<?php
/**
 * Einzelseite eines Referenten
 *
 * @author  Marco Di Bella <mdb@marcodibella.de>
 * @package mdb-congressomat
 **/
?>
<?php get_header(); ?>
<main id="main">
<article class="article adjust-workspace">
<?php
if ( have_posts() ) :
    // Ausgabe puffern
    ob_start();

    while( have_posts() ) :
        the_post();

        // Referentendaten holen
        $speaker = mdb_get_speaker_dataset( get_the_ID() );
?>
<div class="wp-block-coblocks-row alignfull mb-0 mt-0" data-columns="1" data-layout="100">
<div class="wp-block-coblocks-row__inner has-medium-gutter has-no-padding has-no-margin is-stacked-on-mobile">
<div class="wp-block-coblocks-column" style="width:100%">
<div class="wp-block-coblocks-column__inner has-padding has-large-padding has-no-margin">
<div class="speaker-profile">
<figure class="speaker-image"><?php echo get_the_post_thumbnail( $speaker[ 'id' ], 'full', array( 'alt' => $speaker[ 'title_name' ] ) ); ?></figure>
<div>
<h2 class="has-text-align-left thin"><?php echo $speaker[ 'title_name' ]; ?></h2>
<?php
        // Position oder Berufstitel bekannt?
        if( !empty( $speaker[ 'position' ] ) ) :
?>
<p class="speaker-position"><?php echo $speaker[ 'position' ]; ?></p>
<?php
        endif;

        // Ausführliche Beschreibung vorhanden?
        if( !empty( $speaker[ 'description' ] ) ) :
?>
<div class="speaker-description"><?php echo apply_filters( 'the_content', $speaker[ 'description' ] ); ?></div>
<?php
        endif;

        // Links zu Soziale Medien vorhanden?
        if( have_rows( 'referent-social-media' ) ) :
?>
<div class="speaker-social-media">
<ul>
<?php
            while( have_rows( 'referent-social-media' ) ) :
                the_row();

                $services = array(
                            '1' => array(
                                   'name' => 'Facebook',
                                   'icon' => 'fab fa-facebook-f' ),
                            '2' => array(
                                   'name' => 'Twitter',
                                   'icon' =>'fab fa-twitter' ),
                            '3' => array(
                                   'name' => 'Instagram',
                                   'icon' => 'fab fa-instagram' ),
                            '4' => array(
                                   'name' => 'YouTube',
                                   'icon' => 'fab fa-youtube' ),
                            '5' => array(
                                   'name' => 'XING',
                                   'icon' => 'fab fa-xing' ),
                            '6' => array(
                                   'name' => 'LinkedIn',
                                   'icon' => 'fab fa-linkedin-in' ), );

                $service = get_sub_field( 'referent-web-service' );

                echo sprintf( '<li><a href="%1$s" class="btn btn-flex" rel="external nofollow" target="_blank" title="%2$s">%3$s</a></li>',
                              get_sub_field( 'referent-web-service-url' ),
                              sprintf( __( 'Profil von %1$s auf %2$s', TEXT_DOMAIN ),
                                       $speaker[ 'name' ],
                                       $services[ $service ][ 'name' ] ),
                              sprintf( '<i class="%1$s"></i>',
                                       $services[ $service ][ 'icon' ] ) );
            endwhile;
?>
</ul>
</div>
<?php
        endif;
?>
</div>
</div>
</div>
</div>
</div>
</div>
<?php
/**
 * Veranstaltungen mit diesem Referenten
 * Hardcodierte CoBlock-Row
 *
 * @since 1.0.0
 **/
 ?>
<div class="wp-block-coblocks-row alignfull mb-0 mt-0 has-silvergray-background" data-columns="1" data-layout="100">
<div class="wp-block-coblocks-row__inner has-medium-gutter has-no-padding has-no-margin is-stacked-on-mobile">
<div class="wp-block-coblocks-column" style="width:100%">
<div class="wp-block-coblocks-column__inner has-padding has-large-padding has-no-margin">
<h2 class="has-text-align-center thin"><?php echo sprintf( __( 'Programmpunkte mit %1$s', TEXT_DOMAIN ), $speaker[ 'title_name' ] ); ?></h2>
<div style="height:40px" aria-hidden="true" class="wp-block-spacer"></div>
<?php
echo do_shortcode( sprintf( '[event-table set=1 speaker=%1$s]', $speaker[ 'id' ] ) );
?>
</div>
</div>
</div>
</div>
<?php
/**
 * Weitere Referenten anzeigen
 * Hardcodierte CoBlock-Row
 *
 * @since 1.0.0
 **/
 ?>
<div class="wp-block-coblocks-row alignfull mb-0 mt-0 has-lightgray-background" data-columns="1" data-layout="100">
<div class="wp-block-coblocks-row__inner has-medium-gutter has-no-padding has-no-margin is-stacked-on-mobile">
<div class="wp-block-coblocks-column" style="width:100%">
<div class="wp-block-coblocks-column__inner has-padding has-large-padding has-no-margin">
<h2 class="has-text-align-center thin"><?php echo __( 'Weitere Referenten', TEXT_DOMAIN ); ?></h2>
<?php
echo do_shortcode( sprintf( '[speaker-grid exclude=%1$s show=4 shuffle=1]', $speaker[ 'id' ] ) );
?>
</div>
</div>
</div>
</div>
<?php
    endwhile;

    // Ausgabenpuffer sichern; Pufferung beenden
    $buffer = ob_get_contents();
    ob_end_clean();

    // Ausgabe
    echo $buffer;
endif;
?>
</article>
</main>
<?php get_footer(); ?>
