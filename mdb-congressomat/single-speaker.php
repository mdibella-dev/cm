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
<section class="module">
<div class="module-wrapper">
<div class="module-content">
<?php
while( have_posts() ) :
    the_post();

    // Referentendaten holen
    $speaker = mdb_get_speaker_info( get_the_ID() );
?>
<article class="speaker-profile">
<div><?php echo get_the_post_thumbnail( $speaker[ 'id' ], 'full' ); ?></div>
<div>
<h2 class="speaker-title-name"><?php echo $speaker[ 'title_name' ]; ?></h2>
<?php
    // Position oder Berufstitel bekannt?
    if( !empty( $speaker[ 'position' ] ) ) :
?>
<p class="speaker-position"><?php echo $speaker[ 'position' ]; ?></p>
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
                        '1' => array( 'name' => 'Facebook' ),
                        '2' => array( 'name' => 'Twitter' ),
                        '3' => array( 'name' => 'Instagram' ),
                        '4' => array( 'name' => 'YouTube' ),
                        '5' => array( 'name' => 'XING' ),
                        '6' => array( 'name' => 'LinkedIn' ), );


            $service = get_sub_field( 'referent-web-service' );

            echo sprintf( '<li><a href="%1$s" target="_blank" title="%2$s">%3$s</a></li>',
                          get_sub_field( 'referent-web-service-url' ),
                          sprintf( __( 'Profil von %1$s auf %2$s', TEXT_DOMAIN ),
                                   $speaker[ 'name' ],
                                   $services[ $service ][ 'name' ] ),
                                   $services[ $service ][ 'name' ]
                      /* icon-button */ );
        endwhile;
?>
</ul>
</div>
<?php
    endif;

    // Ausführliche Beschreibung vorhanden?
    if( !empty( $speaker[ 'description' ] ) ) :
?>
<div class="speaker-description"><?php echo $speaker[ 'description' ]; ?></div>
<?php
    endif;
?>
</div>
</article>
<?php
endwhile;
?>
</div>
</div>
</section>
</main>
<?php get_footer(); ?>
