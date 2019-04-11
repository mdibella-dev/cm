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
<article class="article">
<?php
while( have_posts() ) :
    the_post();
    the_content();
endwhile;
?>
</article>
</main>
<?php get_footer(); ?>
