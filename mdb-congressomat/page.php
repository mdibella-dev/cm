<?php
/**
 * Seite mit einem modularen Layout
 *
 * @author  Marco Di Bella <mdb@marcodibella.de>
 * @package mdb-congressomat
 * @uses    Plugin ACF
 **/
?>
<?php get_header(); ?>
<main id="main">
<article class="article">
<?php
while( have_posts() ) :
    the_post();

    if( have_rows( 'module' ) ) :
        while( have_rows( 'module' ) ) :
            the_row();

            switch( get_row_layout() ) :
                case 'module-standard' :
                    get_template_part( 'inc/modules/module-standard' );
                break;
            endswitch;

            switch( get_row_layout() ) :
                case 'module-two-columns' :
                    get_template_part( 'inc/modules/module-two-columns' );
                break;
            endswitch;

        endwhile;
    endif;

endwhile;
?>
</article>
</main>
<?php get_footer(); ?>
