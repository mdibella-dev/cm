<?php
/**
 * Modul 'Two Columns'
 *
 * @author  Marco Di Bella <mdb@marcodibella.de>
 * @package mdb-congressomat
 **/



// Variablen setzen
$args[ 'class' ]            = get_row_layout();
$args[ 'additional_class' ] = get_sub_field( 'module-additional-class' );
$args[ 'id' ]               = get_sub_field( 'module-id' );

if( have_rows( 'module-content' ) ):

    $content = '<div class="module-column-wrapper">';

    while ( have_rows( 'module-content' ) ) :
        the_row();

        unset( $classes );
        $classes[] = 'module-column';
        $classes[] = get_sub_field( 'module-column-class' );
        $content  .= sprintf( '<div class="%1$s">%2$s</div>',
                              implode( ' ', $classes ),
                              get_sub_field( 'module-column-content' ) );
    endwhile;

    $content .= '</div>';
else :
    $column = '';
endif;


echo mdb_get_module( $args, $content );
