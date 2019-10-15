<?php
/**
 * Template Name: Landingpage mit Abstand (unten)
 *
 * @author  Marco Di Bella <mdb@marcodibella.de>
 * @package mdb-congressomat
 **/
?>
<?php get_header(); ?>
<main id="main">
<?php
if ( have_posts() ) :
    // Ausgabe puffern
    ob_start();

    while( have_posts() ) :
        the_post();
?>
<article class="article adjust-workspace">
<?php
        // Inhalt
        the_content();
 ?>
</article>
<?php
        // Ausgabenpuffer sichern; Pufferung beenden
        $buffer = ob_get_contents();
        ob_end_clean();

        // Ausgabe
        echo $buffer;
    endwhile;
endif;
?>
</main>
<?php get_footer(); ?>
