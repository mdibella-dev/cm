<?php
/**
 * Seite
 *
 * @author  Marco Di Bella <mdb@marcodibella.de>
 * @package congressomat
 **/

get_header();
?>

    <main id="main">
        <?php
        if ( have_posts() ) :
            // Beginn der Ausgabenpufferung
            ob_start();

            while( have_posts() ) :
                the_post();
        ?>

        <article>
            <div class="article-wrapper">
                <div class="article-wrapper__inner-container article">
                    <h1 class="page-title">
                        <?php echo get_the_title(); ?>
                    </h1>
                    <?php the_content(); ?>
                <div>
            </div>
        </article>

        <?php
            endwhile;

            // Ende der Ausgabenpufferung
            $output_buffer = ob_get_contents();
            ob_end_clean();

            // Ausgabe
            echo $output_buffer;
        endif;
        ?>
    </main>

<?php
get_footer();
