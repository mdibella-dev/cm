<?php
/**
 * Seite mit einem modularen Layout
 *
 * @author  Marco Di Bella <mdb@marcodibella.de>
 * @package mdb-congressomat
 * @since   0.0.1
 * @version 0.0.1
 * @uses    Plugin ACF
 */
?>
<?php get_header(); ?>
<main id="main">
<?php
while( have_posts() ) :
    the_post();

    if( have_rows( 'module' ) ) :
        while( have_rows( 'module' ) ) :
            the_row();

            switch( get_row_layout() ) :
                case 'modul-standard' :
                    get_template_part( 'inc/modules/module-standard' );
                break;
            endswitch;

        endwhile;
    endif;

endwhile;
?>
</main>
<?php get_footer(); ?>
