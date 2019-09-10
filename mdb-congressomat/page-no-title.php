<?php
/**
 * Template Name: Seite ohne Titel
 *
 * @author  Marco Di Bella <mdb@marcodibella.de>
 * @package mdb-congressomat
 * @uses    Plugin ACF
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

        echo $buffer;
        // Modul generieren
        //echo mdb_do_module( array( 'classes' => array( 'module-standard' ) ), $buffer );
    endwhile;
endif;
?>
</main>
<?php get_footer(); ?>
