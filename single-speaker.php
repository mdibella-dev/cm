<?php
/**
 * The template for displaying a single speaker.
 *
 * @author  Marco Di Bella
 * @package cm-theme
 */

namespace cm_theme;

use function \cm_theme_core\api\get_speaker_dataset as get_dataset;


/** Prevent direct access */

defined( 'ABSPATH' ) or exit;


define( 'SOCIAL_MEDIA', [
    '1' => [
        'name' => 'Facebook',
        'icon' => 'fab fa-facebook-f',
    ],
    '2' => [
        'name' => 'Twitter',
        'icon' =>'fab fa-twitter',
    ],
    '3' => [
        'name' => 'Instagram',
        'icon' => 'fab fa-instagram',
    ],
    '4' => [
        'name' => 'YouTube',
        'icon' => 'fab fa-youtube',
    ],
    '5' => [
        'name' => 'XING',
        'icon' => 'fab fa-xing',
    ],
    '6' => [
        'name' => 'LinkedIn',
        'icon' => 'fab fa-linkedin-in',
    ],
] );


get_header();
?>

    <main id="main">
        <article>

            <?php
            if ( have_posts() ) {

                while ( have_posts() ) {
                    the_post();

                    // Get record
                    $data = get_dataset( get_the_ID() );
            ?>
            <div class="wp-block-group section-wrapper mb-0 mt-0 has-black-10-background-color has-background">
                <div class="wp-block-group__inner-container">

                    <?php
                    /**
                     * Show description of the speaker.
                     *
                     * @since 1.1.0
                     */
                    ?>
                    <div class="single-speaker-profile">

                        <div class="single-speaker-profile__column">

                            <figure class="speaker-image">
                                <?php echo get_the_post_thumbnail( $data['id'], 'full', [ 'alt' => $data['title_name'] ] ); ?>
                            </figure>

                            <div class="speaker-social-media">
                                <ul>
                                    <?php
                                    while ( have_rows( 'referent-social-media' ) ) {
                                        the_row();

                                        $service = get_sub_field( 'referent-web-service' );
                                    ?>
                                    <li>
                                        <div class="wp-block-button is-fa-button">
                                            <a  href="<?php echo get_sub_field( 'referent-web-service-url' ); ?>"
                                                class="wp-block-button__link"
                                                rel="external nofollow"
                                                target="_blank"
                                                title="<?php echo sprintf( __( 'Profil von %1$s auf %2$s', 'cm' ), $data['name'], SOCIAL_MEDIA[ $service ]['name'] ); ?>">
                                                <i class="<?php echo SOCIAL_MEDIA[ $service ]['icon']; ?>"></i>
                                            </a>
                                        </div>
                                    </li>
                                    <?php
                                    }
                                    ?>
                                </ul>
                            </div>

                        </div>

                        <div class="single-speaker-profile__column">
                            <h2 class="speaker-title-name"><?php echo $data['title_name']; ?></h2>

                            <?php
                            // Position or job title known?
                            if ( ! empty( $data[ 'position' ] ) ) {
                            ?>
                            <h3 class="speaker-position"><?php echo $data['position']; ?></h3>
                            <?php
                            }
                            ?>

                            <div class="article"><?php echo apply_filters( 'the_content', $data['description'] ); ?></div>
                        </div>
                    </div>
                </div>
            </div>

            <?php
            /**
             * Events with this speaker.
             *
             * @since 1.0.0
             */
            ?>
            <?php

            $sessions = do_shortcode( sprintf( '[event-table set=1 speaker=%1$s]', $data['id'] ) );

            if ( ! empty( $sessions ) ) {
            ?>
            <div class="wp-block-group section-wrapper mb-0 mt-0">
                <div class="wp-block-group__inner-container">
                    <h2 class="has-text-align-center section-title"><?php echo sprintf( __( 'Programmpunkte mit %1$s', 'cm' ), $data['title_name'] ); ?></h2>
                    <div style="height:20px" aria-hidden="TRUE" class="wp-block-spacer"></div>
                    <?php echo $sessions; ?>
                </div>
            </div>
            <?php
            }


            /**
             * Show more speakers.
             *
             * @since 1.0.0
             */
            ?>
            <div class="wp-block-group section-wrapper mb-0 mt-0 has-black-10-background-color has-background">
                <div class="wp-block-group__inner-container">
                    <h2 class="has-text-align-center section-title"><?php echo __( 'Weitere Referenten', 'cm' ); ?></h2>
                    <?php echo do_shortcode( sprintf( '[speaker-grid exclude=%1$s show=4 shuffle=1]', $data['id'] ) ); ?>
                </div>
            </div>

            <?php
            }

        }
        ?>

        </article>
    </main>

<?php
get_footer();
