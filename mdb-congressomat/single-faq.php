<?php
/**
 * Einzelseite einer FAQ
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

    // Shortcode generieren mit den FAQs
    echo mdb_do_header( get_the_title(), '', 'align-center' );
    echo do_shortcode( sprintf( '[faq faq="%1$s"]', get_the_ID() ) );

    // Ausgabenpuffer sichern; Pufferung beenden
    $buffer  = ob_get_contents();
    ob_end_clean();

    // Modul generieren
    $args = array(
            'class'     => 'module-standard',
            );
    echo mdb_get_module( $args, $buffer );
endif;
?>
</main>
<?php get_footer(); ?>
