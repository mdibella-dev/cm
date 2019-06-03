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
                   );
        echo mdb_get_module( $args, $buffer );
        module-lightgray
    endwhile;
endif;
?>
<?php
/**
 * Weitere Artikel anzeigen
 *
 * @since 1.0.0
 **/

// Ausgabe puffern
ob_start();

echo mdb_do_header( __( 'Weitere Beiträge', TEXT_DOMAIN ), '', 'align-center' );
echo do_shortcode( sprintf( '[teaser-list exclude=%1$s show=2]', get_the_ID() ) );

// Ausgabenpuffer sichern; Pufferung beenden
$buffer  = ob_get_contents();
ob_end_clean();

// Modul generieren
echo mdb_do_module( array( 'classes' => array( 'module-standard', 'module-lightgray') ), $buffer );
?>
</main>
<?php get_footer(); ?>
