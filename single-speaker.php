<?php
/**
 * Einzelseite eines Referenten
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
                // Beginn der Ausgabenpufferung
                ob_start();

                while( have_posts() ) :
                    the_post();

                    // Referentendaten holen
                    $speaker = congressomat_get_speaker_dataset( get_the_ID() );
            ?>

            <div class="wp-block-group section-wrapper mb-0 mt-0 has-black-10-background-color has-background">
                <div class="wp-block-group__inner-container">

                    <?php
                    /**
                     * Beschreibung des Referenten
                     *
                     * @since 1.1.0
                     **/
                    ?>

                    <div class="wp-block-columns single-speaker-profile">

                        <div class="wp-block-column" style="flex-basis: 25%;">

                            <figure class="speaker-image">
                                <?php echo get_the_post_thumbnail( $speaker[ 'id' ], 'full', array( 'alt' => $speaker[ 'title_name' ] ) ); ?>
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
                                                title="<?php echo sprintf( __( 'Profil von %1$s auf %2$s', 'congressomat' ), $speaker[ 'name' ], SOCIAL_MEDIA[ $service ][ 'name' ] ); ?>">
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

                        <div class="wp-block-column">

                            <h2 class="speaker-title-name"><?php echo $speaker[ 'title_name' ]; ?></h2>

                            <?php
                            // Position oder Berufstitel bekannt?
                            if( !empty( $speaker[ 'position' ] ) ) :
                            ?>
                            <h3 class="speaker-position"><?php echo $speaker[ 'position' ]; ?></h3>
                            <?php
                            endif;
                            ?>

                            <div class="article"><?php echo apply_filters( 'the_content', $speaker[ 'description' ] ); ?></div>

                        </div>
                    </div>
                </div>
            </div>

            <?php
            /**
             * Veranstaltungen mit diesem Referenten
             *
             * @since 1.0.0
             **/
            ?>
            <div class="wp-block-group section-wrapper mb-0 mt-0">
                <div class="wp-block-group__inner-container">
                    <div style="height:20px" aria-hidden="true" class="wp-block-spacer"></div>

                    <h2 class="has-text-align-center section-title">
                        <?php echo sprintf( __( 'Programmpunkte mit %1$s', 'congressomat' ), $speaker[ 'title_name' ] ); ?>
                    </h2>

                    <div style="height:20px" aria-hidden="true" class="wp-block-spacer"></div>

                    <?php echo do_shortcode( sprintf( '[event-table set=4 speaker=%1$s]', $speaker[ 'id' ] ) ); ?>
                </div>
            </div>


            <?php
            /**
             * Weitere Referenten anzeigen
             *
             * @since 1.0.0
             **/
            ?>
            <div class="wp-block-group section-wrapper mb-0 mt-0 has-black-10-background-color has-background">
                <div class="wp-block-group__inner-container">
                    <h2 class="has-text-align-center section-title">
                        <?php echo __( 'Weitere Referenten', 'congressomat' ); ?>
                    </h2>

                    <?php echo do_shortcode( sprintf( '[speaker-grid exclude=%1$s show=4 shuffle=1]', $speaker[ 'id' ] ) ); ?>
                </div>
            </div>

            <?php
            endwhile;

            // Ausgabenpuffer sichern; Pufferung beenden
            $output_buffer = ob_get_contents();
            ob_end_clean();

            // Ausgabe
            echo $output_buffer;
        endif;
        ?>

        </article>
    </main>

<?php
get_footer();
