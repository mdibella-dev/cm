<?php
/**
 * Seite
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
<article class="article">
<?php
        // Header
        echo '<header>';
        echo sprintf( '<h1>%1$s</h1>', get_the_title() );
        echo '</header>';

        // Inhalt
        the_content();
 ?>
</article>
<?php
        // Ausgabenpuffer sichern; Pufferung beenden
        $buffer = ob_get_contents();
        ob_end_clean();

        // Modul generieren
        echo mdb_do_module( array( 'classes' => array( 'module-standard' ) ), $buffer );
    endwhile;
endif;
?>
</main>
<?php get_footer(); ?>
