<?php
/**
 * The generic template.
 *
 * @author  Marco Di Bella
 * @package cm-theme
 */


/** Prevent direct access */

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
