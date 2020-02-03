<?php
/**
 * Template für Seiten/Beträge aller Art (Fallback)
 *
 * @author  Marco Di Bella <mdb@marcodibella.de>
 * @package congressomat
 **/
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
