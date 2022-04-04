<?php
/**
 * Template für Beiträge
 *
 * @author  Marco Di Bella <mdb@marcodibella.de>
 * @package cm
 */


defined( 'ABSPATH' ) or exit;



get_header();
?>

    <main id="main">
        <?php
        if( have_posts() ) :

            // Ausgabenpufferung beginnen
            ob_start();

            while( have_posts() ) :
                the_post();
        ?>
        <article>
            <div class="article-wrapper">
                <div class="article-wrapper__inner-container">
                    <h1 class="post-title">
                        <?php echo get_the_title(); ?>
                    </h1>
                    <?php the_content(); ?>
                <div>
            </div>
        </article>
        <?php
            endwhile;

            // Ausgabenpufferung beenden und Puffer ausgeben
            $output_buffer = ob_get_contents();
            ob_end_clean();
            echo $output_buffer;
        endif;
        ?>
    </main>

<?php
get_footer();
