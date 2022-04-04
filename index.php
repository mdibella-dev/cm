<?php
/**
 * Template für Seiten/Beträge aller Art (Fallback)
 *
 * @author  Marco Di Bella <mdb@marcodibella.de>
 * @package cm
 */


defined( 'ABSPATH' ) or exit;



get_header();
?>
    <main id="main">
        <article>
            <?php
            while( have_posts() ) :
                the_post();
                the_content();
            endwhile;
            ?>
        </article>
    </main>
<?php
get_footer();
