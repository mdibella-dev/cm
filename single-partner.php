<?php
/**
 * Einzelseite eines Kooperationspartners
 *
 * @author  Marco Di Bella <mdb@marcodibella.de>
 * @package congressomat
 **/

get_header();
?>

    <main id="main">
        <article>

            <?php
            if( have_posts() ) :
                while( have_posts() ) :
                    the_post();

                    /* Datensatz holen */

                    $data = congressomat_get_partner_dataset( get_the_ID() );
            ?>

            <div class="wp-block-group section-wrapper mb-0 mt-0 has-black-05-background-color has-background">
                <div class="wp-block-group__inner-container">

                    <?php
                    /**
                     * Kontaktdaten etc
                     *
                     * @since 1.1.0
                     **/
                    ?>

                    <div class="single-partner-profile">

                        <div class="single-partner-profile__column">



                        </div>

                        <div class="single-partner-profile__column">

                            <figure class="partner-image">
                                <?php echo get_the_post_thumbnail(); ?>
                            </figure>

                            <ul class="partner-contact">
                            <?php/*
                            if( $data[ 'phone' ] ) :
                                echo sprintf( '<li data-type="%1$s"><span>%2$s</span><span>%3$s</span></li>',
                                    'phone',
                                    __( 'Telefon', 'congressomat' ),
                                    $data[ 'phone' ],
                                    );
                            endif;

                            if( $data[ 'fax' ] ) :
                                echo sprintf( '<li data-type="%1$s"><span>%2$s</span><span>%3$s</span></li>',
                                    'fax',
                                    __( 'Telefax', 'congressomat' ),
                                    $data[ 'fax' ],
                                    );
                            endif;

                            if( $data[ 'mail' ] ) :
                                echo sprintf( '<li data-type="%1$s"><span>%2$s</span><span>%3$s</span></li>',
                                    'mail',
                                    __( 'E-Mail', 'congressomat' ),
                                    $data[ 'mail' ],
                                    );
                            endif;

                            if( $data[ 'website' ] ) :
                                echo sprintf( '<li data-type="%1$s"><span>%2$s</span><span>%3$s</span></li>',
                                    'webseite',
                                    __( 'Web', 'congressomat' ),
                                    $data[ 'website' ],
                                    );
                            endif;*/
                            ?>
                        </ul>

                        </div>
                    </div>
                </div>
            </div>

            <?php
            /**
             * Unternehmensadresse in Google Maps anzeigen
             *
             * @since 2.3.0
             **/

            if( !empty( $data[ 'address' ] ) ) :

                $google_maps_query =
                'https://www.google.com/maps/embed/v1/place?q='
                . urlencode( str_replace( '<br>', ', ', $data[ 'address' ] ) )
                . '&amp;maptype=roadmap&amp;zoom=16&amp;key=AIzaSyBABldTSNGLjLd8gLSgHaqxmuUqoi6HouI';

            ?>
            <div class="wp-block-webfactory-map">
                <div class="wp-block-webfactory-map">
                    <iframe width="100%" height="420px" src="<?php echo $google_maps_query; ?>" frameborder="0"></iframe>
                </div>
            </div>
            <?php
            endif;
            ?>

            <?php
            endwhile;

        endif;
        ?>

        </article>
    </main>

<?php
get_footer();
