<?php
/**
 * Template für Beiträge
 *
 * @author  Marco Di Bella <mdb@marcodibella.de>
 * @package mdb-congressomat
 **/
?>
<?php get_header(); ?>
<main id="main">
<?php get_template_part( 'inc/modules/module-breadcrumb' ); ?>
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
        $args    = array(
                   'class' => 'module-standard',
                   'title' => ''
                   );
        echo mdb_get_module( $args, $buffer );
    endwhile;
endif;
?>
</main>
<?php get_footer(); ?>
