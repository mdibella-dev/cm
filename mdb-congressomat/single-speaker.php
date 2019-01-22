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
<?php
while( have_posts() ) :
    the_post();
    //the_content();
    $speaker = mdb_get_speaker_info( get_the_ID() );

    echo get_the_post_thumbnail( $speaker[ 'id' ], 'full' );
    echo $speaker[ 'title_name' ];
    echo '<br>';
    echo $speaker[ 'position' ];

    if( have_rows( 'referent-social-media' ) ) :
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

            echo sprintf( '<a href="%1$s" target="_blank" title="%2$s">%3$s</a>',
                          get_sub_field( 'referent-web-service-url' ),
                          sprintf( __( 'Profil von %1$s auf %2$s', TEXT_DOMAIN ),
                                   $speaker[ 'name' ],
                                   $services[ $service ][ 'name' ] ),
                                   $services[ $service ][ 'name' ]
                      /* icon-button */ );
        endwhile;
    endif;
    echo $speaker[ 'description' ];
endwhile;
?>
</main>
<?php get_footer(); ?>
