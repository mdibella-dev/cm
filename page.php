<?php
/**
 * Seite
 *
 * @author  Marco Di Bella <mdb@marcodibella.de>
 * @package congressomat
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
        // Titel
        echo sprintf( '<h1>%1$s</h1>', get_the_title() );

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
