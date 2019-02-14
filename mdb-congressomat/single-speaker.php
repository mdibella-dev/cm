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
<?php get_template_part( 'inc/modules/module-breadcrumb' ); ?>
<?php
if ( have_posts() ) :
    // Ausgabe puffern
    ob_start();

    while( have_posts() ) :
        the_post();

        // Referentendaten holen
        $speaker = mdb_get_speaker_info( get_the_ID() );
?>
<article class="speaker-profile">
<div class="speaker-image"><?php echo get_the_post_thumbnail( $speaker[ 'id' ], 'full' ); ?></div>
<div>
<h2 class="speaker-title-name"><?php echo $speaker[ 'title_name' ]; ?></h2>
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
<div class="speaker-description"><?php echo $speaker[ 'description' ]; ?></div>
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

                echo sprintf( '<li><a href="%1$s" target="_blank" title="%2$s">%3$s</a></li>',
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
</article>
<?php
        // Ausgabenpuffer sichern; Pufferung beenden
        $buffer = ob_get_contents();
        ob_end_clean();

        // Modul generieren
        $args = array(
                'class' => 'module-standard',
                'title' => ''
                );
        echo mdb_get_module( $args, $buffer );
    endwhile;
endif;
?>
<?php
/**
 * Weitere Referenten anzeigen
 *
 * @since 1.0.0
 **/

// Ausgabe puffern
ob_start();

// Aktuell angezeigten Speaker ermitteln
// Shortcode generieren, der den aktuellen Speaker ausschließt und vier Speaker maximal anzeigt
$speaker = mdb_get_speaker_info( get_the_ID() );
echo do_shortcode( sprintf( '[speaker-grid exclude=%1$s show=4 shuffle=1]', $speaker[ 'id' ] ) );

// Ausgabenpuffer sichern; Pufferung beenden
$buffer  = ob_get_contents();
ob_end_clean();

// Modul generieren
$args    = array(
           'class'            => 'module-standard',
           'additional_class' => 'module-lightgray',
           'title'            => __( 'Weitere Referenten', TEXT_DOMAIN ),
           'alignment'        => 1
           );
echo mdb_get_module( $args, $buffer );
?>
</main>
<?php get_footer(); ?>
