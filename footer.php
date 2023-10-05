<?php
/**
 * The template to display the footer section of a page/post.
 *
 * @author  Marco Di Bella
 * @package cm-theme
 */

namespace cm_theme;


/** Prevent direct access */

defined( 'ABSPATH' ) or exit;



?>
        <footer id="footer">

            <?php if ( is_active_sidebar( 'footer-four' ) ) { ?>
            <section id="footer-social" class="footer-wrapper">

                <div class="footer-wrapper__inner-container">

                    <div class="widget-area">
                        <?php dynamic_sidebar( 'footer-four' ); ?>
                    </div>

                </div>

            </section>
            <?php } ?>

            <?php if ( is_active_sidebar( 'footer-one' ) and is_active_sidebar( 'footer-two' ) and is_active_sidebar( 'footer-three' ) ) { ?>
            <section id="footer-widgets" class="footer-wrapper">

                <div class="footer-wrapper__inner-container">

                    <div class="widget-area">
                        <?php dynamic_sidebar( 'footer-one' ); ?>
                    </div>

                    <div class="widget-area">
                        <?php dynamic_sidebar( 'footer-two' ); ?>
                    </div>

                    <div class="widget-area">
                        <?php dynamic_sidebar( 'footer-three' ); ?>
                    </div>

                </div>

            </section>
            <?php } ?>

        </footer>

        <?php wp_footer(); ?>
    </body>
</html>
