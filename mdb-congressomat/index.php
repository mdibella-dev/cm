<?php
/**
 * Template für Seiten/Beträge aller Art (Fallback)
 *
 * @author  Marco Di Bella <mdb@marcodibella.de>
 * @package mdb-congressomat
 * @since   0.0.1
 * @version 0.0.1
 */
?>
<?php get_header(); ?>
<main id="main">
<?php
while( have_posts() ) :
    the_post();
    the_content();
endwhile;
?>
</main>
<?php get_footer(); ?>
