<?php
/**
 * Template Name: Landingpage
 *
 * @author  Marco Di Bella <mdb@marcodibella.de>
 * @package congressomat
 **/

get_header();
?>

    <main id="main">
        <article>
        <?php
        if ( have_posts() ) :
            // Beginn der Ausgabenpufferung
            ob_start();

            while( have_posts() ) :
                the_post();
                the_content();
            endwhile;

            // Ende der Ausgabenpufferung
            $output_buffer = ob_get_contents();
            ob_end_clean();

            // Ausgabe
            echo $output_buffer;
        endif;
        ?>
        </article>
    </main>

<?php
get_footer();
