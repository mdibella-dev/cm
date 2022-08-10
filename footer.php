<?php
/**
 * Template für den Fußbereich einer Seite
 *
 * @author  Marco Di Bella 
 * @package cm
 */


 defined( 'ABSPATH' ) or exit;



?>
        <footer id="footer">

            <section class="footer-widgets-wrapper">

                <div class="footer-widgets-wrapper__inner-container">

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
