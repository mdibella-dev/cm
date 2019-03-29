<?php
/**
 * Template für Seiten/Beträge aller Art (Fallback)
 *
 * @author  Marco Di Bella <mdb@marcodibella.de>
 * @package mdb-congressomat
 **/
?>
<?php get_header(); ?>
<main id="main">
<div id="dimmer"></div>
<?php
while( have_posts() ) :
    the_post();
    the_content();
endwhile;
?>
</main>
<?php get_footer(); ?>
