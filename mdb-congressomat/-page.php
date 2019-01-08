<?php
/**
 * Template für (modulare) Seiten
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

    if( have_rows( 'modules' ) ) :
        while( have_rows( 'modules' ) ) :
            the_row();

            switch( get_row_layout() ) :
                case 'module-standard' :
                    get_template_part( 'inc/modules/module-standard' );
                break;
/*
                case 'module-vortrag' :
                    get_template_part( 'inc/modules/module-vortrag' );
                break;

                case 'module-publikation' :
                    get_template_part( 'inc/modules/module-publikation' );
                break;
*/
            endswitch;

        endwhile;
    endif;

endwhile;
?>
</main>
<?php get_footer(); ?>
