<?php
/**
 * The template for displaying a single partner.
 *
 * @author  Marco Di Bella
 * @package cm-theme
 */

namespace cm_theme;

use cm_theme_core\core__get_partner_dataset as get_dataset;


/** Prevent direct access */

defined( 'ABSPATH' ) or exit;



get_header();
?>

    <main id="main">
        <article>
            <?php
            if( have_posts() ) :
                while( have_posts() ) :
                    the_post();

                    // Get record
                    $data = get_dataset( get_the_ID() );
            ?>
            <div class="wp-block-group section-wrapper mb-0 mt-0 has-black-10-background-color has-background">
                <div class="wp-block-group__inner-container">
                    <h2 class="section-title has-text-align-center"><?php echo $data['title']; ?></h2>
                    <?php
                    if( ! empty( $data['description'] ) ) :
                        echo $data['description'];
                    else :
                    ?>
                    <p style="text-align: center;"><?php echo __( 'Keine Beschreibung verfügbar.', 'cm'); ?></p>
                    <?php
                    endif;
                    ?>
                </div>
            </div>

            <?php
            /**
             * Show contact details.
             *
             * @since   2.3.0
             */
            ?>
            <div class="wp-block-group section-wrapper mb-0 mt-0">
                <div class="wp-block-group__inner-container">
                    <h2 class="section-title has-text-align-center"><?php echo __( 'Kontaktinformationen', 'cm' ); ?></h2>
                    <div class="single-partner-details">
                        <div>
                            <figure>
                                <?php echo get_the_post_thumbnail(); ?>
                            </figure>
                        </div>
                        <div>
                            <p><?php echo $data['address'];?></p>
                        </div>
                        <div>
                            <ul>
                            <?php
                            if( $data['phone'] ) :
                                echo sprintf( '<li data-type="%1$s"><span>%2$s</span><span>%3$s</span></li>',
                                    'phone',
                                    __( 'Telefon', 'cm' ),
                                    $data['phone'],
                                    );
                            endif;

                            if( $data['fax'] ) :
                                echo sprintf( '<li data-type="%1$s"><span>%2$s</span><span>%3$s</span></li>',
                                    'fax',
                                    __( 'Telefax', 'cm' ),
                                    $data['fax'],
                                    );
                            endif;

                            if( $data['mail'] ) :
                                echo sprintf( '<li data-type="%1$s"><span>%2$s</span><span>%3$s</span></li>',
                                    'mail',
                                    __( 'E-Mail', 'cm' ),
                                    $data['mail'],
                                    );
                            endif;

                            if( $data['website'] ) :

                                $url = parse_url( $data['website'] );

                                echo sprintf( '<li data-type="%1$s"><span>%2$s</span><span><a href="%3$s" target="_blank" title="%5$s">%4$s</a></span></li>',
                                    'webseite',
                                    __( 'Web', 'congresscmomat' ),
                                    $data['website'],
                                    $url['host'],
                                    __( 'Webseite besuchen', 'cm' ),
                                    );
                            endif;
                            ?>
                            </ul>
                        </div>

                    </div>

            <?php
            /**
             * Show company address in Google Maps.
             *
             * @since   2.3.0
             */

            if( ! empty( $data['address'] ) ) :

                $google_maps_query =
                'https://www.google.com/maps/embed/v1/place?q='
                . urlencode( str_replace( '<br>', ', ', $data['address'] ) )
                . '&amp;maptype=roadmap&amp;zoom=16&amp;key=AIzaSyBABldTSNGLjLd8gLSgHaqxmuUqoi6HouI';
            ?>
                    <div class="wp-block-webfactory-map">
                        <div class="wp-block-webfactory-map">
                            <iframe width="100%" height="420px" src="<?php echo $google_maps_query; ?>" frameborder="0"></iframe>
                        </div>
                    </div>
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
