<?php
/**
 * The template for displaying a single post.
 *
 * @author  Marco Di Bella
 * @package cm-theme
 */

namespace cm_theme;


/** Prevent direct access */

defined( 'ABSPATH' ) or exit;



get_header();
?>

    <main id="main">
        <?php
        if ( have_posts() ) {

            ob_start();

            while ( have_posts() ) {
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
            }

            $output = ob_get_contents();
            ob_end_clean();
            echo $output;
        }
        ?>
    </main>

<?php
get_footer();
