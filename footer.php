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

        </footer>

        <?php wp_footer(); ?>
    </body>
</html>
