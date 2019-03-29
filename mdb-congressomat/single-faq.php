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
<?php get_template_part( 'inc/modules/module-breadcrumb' ); ?>
<?php
if ( have_posts() ) :
    // Ausgabe puffern
    ob_start();

    // Shortcode generieren mit den FAQs
    echo do_shortcode( sprintf( '[faq faq="%1$s"]', get_the_ID() ) );

    // Ausgabenpuffer sichern; Pufferung beenden
    $buffer  = ob_get_contents();
    ob_end_clean();

    // Modul generieren
    $args = array(
            'class'     => 'module-standard',
            'title'     => get_the_title(),
            'alignment' => 1
            );
    echo mdb_get_module( $args, $buffer );
endif;
?>
</main>
<?php get_footer(); ?>
