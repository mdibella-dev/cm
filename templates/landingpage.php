<?php
/**
 * Template Name: Landingpage
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

            ob_start(); // notwendig?

            while( have_posts() ) :
                the_post();
                the_content();
            endwhile;

            $output = ob_get_contents();
            ob_end_clean();
            echo $output;

        endif;
        ?>
        </article>
    </main>

<?php
get_footer();
