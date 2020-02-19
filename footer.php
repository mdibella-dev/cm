<?php
/**
 * Template für den Fußbereich einer Seite
 *
 * @author  Marco Di Bella <mdb@marcodibella.de>
 * @package congressomat
 **/
?>
        <footer id="footer">

            <section id="footer-widgets">

                <div class="footer-widgets__inner-container">

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
