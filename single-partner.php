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

                    $dataset = congressomat_get_partner_dataset( get_the_ID() );
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
                            <?php
                            if( $dataset[ 'phone' ] ) :
                                echo sprintf( '<li data-type="%1$s"><span>%2$s</span><span>%3$s</span></li>',
                                    'phone',
                                    __( 'Telefon', 'congressomat' ),
                                    $dataset[ 'phone' ],
                                    );
                            endif;

                            if( $dataset[ 'fax' ] ) :
                                echo sprintf( '<li data-type="%1$s"><span>%2$s</span><span>%3$s</span></li>',
                                    'fax',
                                    __( 'Telefax', 'congressomat' ),
                                    $dataset[ 'fax' ],
                                    );
                            endif;

                            if( $dataset[ 'mail' ] ) :
                                echo sprintf( '<li data-type="%1$s"><span>%2$s</span><span>%3$s</span></li>',
                                    'mail',
                                    __( 'E-Mail', 'congressomat' ),
                                    $dataset[ 'mail' ],
                                    );
                            endif;

                            if( $dataset[ 'website' ] ) :
                                echo sprintf( '<li data-type="%1$s"><span>%2$s</span><span>%3$s</span></li>',
                                    'webseite',
                                    __( 'Web', 'congressomat' ),
                                    $dataset[ 'website' ],
                                    );
                            endif;
                            ?>
                            </ul>

                        </div>
                    </div>
                </div>
            </div>

            <?php
            /**
             * Weitere Referenten anzeigen
             *
             * @since 1.0.0
             **/
            ?>
<!--            <div class="wp-block-group section-wrapper mb-0 mt-0 has-black-05-background-color has-background">
                <div class="wp-block-group__inner-container">
                    <h2 class="has-text-align-center section-title">
                        <?php echo __( 'Weitere Referenten', 'congressomat' ); ?>                    <div class="article">
                        <?php echo apply_filters( 'the_content', $speaker[ 'description' ] ); ?></div>
                    </h2>

                    <?php echo do_shortcode( sprintf( '[speaker-grid exclude=%1$s show=4 shuffle=1]', $speaker[ 'id' ] ) ); ?>
                </div>
            </div>-->

            <?php
            endwhile;

        endif;
        ?>

        </article>
    </main>

<?php
get_footer();
