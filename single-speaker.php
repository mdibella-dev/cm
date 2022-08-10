<?php
/**
 * Einzelseite eines Referenten
 *
 * @author  Marco Di Bella 
 * @package cm
 */


defined( 'ABSPATH' ) or exit;



get_header();
?>

    <main id="main">
        <article>

            <?php
            if( have_posts() ) :

                while( have_posts() ) :
                    the_post();

                    // Datensatz holen
                    $data = cm_get_speaker_dataset( get_the_ID() );
            ?>
            <div class="wp-block-group section-wrapper mb-0 mt-0 has-black-10-background-color has-background">
                <div class="wp-block-group__inner-container">

                    <?php
                    /**
                     * Beschreibung des Referenten
                     *
                     * @since 1.1.0
                     */
                    ?>
                    <div class="single-speaker-profile">

                        <div class="single-speaker-profile__column">

                            <figure class="speaker-image">
                                <?php echo get_the_post_thumbnail( $data[ 'id' ], 'full', array( 'alt' => $data[ 'title_name' ] ) ); ?>
                            </figure>

                            <div class="speaker-social-media">
                                <ul>
                                    <?php
                                    while( have_rows( 'referent-social-media' ) ) :
                                        the_row();

                                        $service = get_sub_field( 'referent-web-service' );
                                    ?>
                                    <li>
                                        <div class="wp-block-button is-fa-button">
                                            <a  href="<?php echo get_sub_field( 'referent-web-service-url' ); ?>"
                                                class="wp-block-button__link"
                                                rel="external nofollow"
                                                target="_blank"
                                                title="<?php echo sprintf( __( 'Profil von %1$s auf %2$s', 'cm' ), $data[ 'name' ], SOCIAL_MEDIA[ $service ][ 'name' ] ); ?>">
                                                <i class="<?php echo SOCIAL_MEDIA[ $service ][ 'icon' ]; ?>"></i>
                                            </a>
                                        </div>
                                    </li>
                                    <?php
                                    endwhile;
                                    ?>
                                </ul>
                            </div>

                        </div>

                        <div class="single-speaker-profile__column">
                            <h2 class="speaker-title-name"><?php echo $data[ 'title_name' ]; ?></h2>
                            <?php
                            // Position oder Berufstitel bekannt?
                            if( !empty( $data[ 'position' ] ) ) :
                            ?>
                            <h3 class="speaker-position"><?php echo $data[ 'position' ]; ?></h3>
                            <?php
                            endif;
                            ?>
                            <div class="article"><?php echo apply_filters( 'the_content', $data[ 'description' ] ); ?></div>
                        </div>
                    </div>
                </div>
            </div>

            <?php
            /**
             * Veranstaltungen mit diesem Referenten
             *
             * @since 1.0.0
             */
            ?>
            <?php

            $sessions = do_shortcode( sprintf( '[event-table set=1 speaker=%1$s]', $data[ 'id' ] ) );

            if( ! empty( $sessions ) ) :
            ?>
            <div class="wp-block-group section-wrapper mb-0 mt-0">
                <div class="wp-block-group__inner-container">
                    <h2 class="has-text-align-center section-title"><?php echo sprintf( __( 'Programmpunkte mit %1$s', 'cm' ), $data[ 'title_name' ] ); ?></h2>
                    <div style="height:20px" aria-hidden="TRUE" class="wp-block-spacer"></div>
                    <?php echo $sessions; ?>
                </div>
            </div>
            <?php
            endif;


            /**
             * Weitere Referenten anzeigen
             *
             * @since 1.0.0
             */
            ?>
            <div class="wp-block-group section-wrapper mb-0 mt-0 has-black-10-background-color has-background">
                <div class="wp-block-group__inner-container">
                    <h2 class="has-text-align-center section-title"><?php echo __( 'Weitere Referenten', 'cm' ); ?></h2>
                    <?php echo do_shortcode( sprintf( '[speaker-grid exclude=%1$s show=4 shuffle=1]', $data[ 'id' ] ) ); ?>
                </div>
            </div>

            <?php
            endwhile;

        endif;
        ?>

        </article>
    </main>

<?php
get_footer();
