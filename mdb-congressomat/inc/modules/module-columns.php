<?php
/**
 * Modul 'Columns'
 *
 * @author  Marco Di Bella <mdb@marcodibella.de>
 * @package mdb-congressomat
 **/



// Content erstellen
if( have_rows( 'module-content' ) ):
    // Modulinhalt zusammenstellen
    $module_content = '<div class="module-column-wrapper">';
    $column_count   = 0;

    // Spalteninhalte zusammenstellen
    while ( have_rows( 'module-content' ) ) :
        the_row();

        $column_count   += 1;
        $column_id       = get_sub_field( 'module-column-id' );
        $column_classes  = array( 'module-column',
                                  get_sub_field( 'module-column-class' ),
                                  sprintf( 'module-column-%1$s', $column_count ) );
        $module_content .= sprintf( '<div class="%1$s"%2$s>%3$s</div>',
                                    implode( ' ', $column_classes ),
                                    ( !empty( $column_id ) )? sprintf( ' id="%1$s"', $column_id ) : '',
                                    get_sub_field( 'module-column-content' ) );
    endwhile;
    $module_content .= '</div>';
else :
    $module_content = '';
endif;


// Ausgabe
if( !empty( $module_content) ) :
    $module_column_class = array( 1 => 'module-one-column',
                                  2 => 'module-two-column',
                                  3 => 'module-three-column' );
    $args[ 'classes' ]   = array( get_row_layout(),
                                  get_sub_field( 'module-additional-class' ),
                                  $module_column_class[ $column_count ] );
    $args[ 'id' ]        = get_sub_field( 'module-id' );

    echo mdb_do_module( $args, $module_content );
endif;
