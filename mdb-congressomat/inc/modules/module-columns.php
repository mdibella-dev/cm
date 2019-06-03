<?php
/**
 * Modul 'Columns'
 *
 * @author  Marco Di Bella <mdb@marcodibella.de>
 * @package mdb-congressomat
 **/



// Variablen setzen
$module_id      = get_sub_field( 'module-id' );
$module_classes = array( 'module',
                         get_row_layout(),
                         get_sub_field( 'module-additional-class' ) );


// Content erstellen
if( have_rows( 'module-content' ) ):

    // Modulinhalt zusammenstellen
    $module_content = '<div class="module-content"><div class="module-column-wrapper">';
    $column_count   = 0;


    // Spalteninhalte zusammenstellen
    while ( have_rows( 'module-content' ) ) :
        the_row();

        $column_count   += 1;
        $column_classes  = array( 'module-column',
                                  get_sub_field( 'module-column-class' ),
                                  sprintf( 'module-column-%1$s', $column_count ) );
        $module_content .= sprintf( '<div class="%1$s">%2$s</div>',
                                    implode( ' ', $column_classes ),
                                    get_sub_field( 'module-column-content' ) );
    endwhile;
    $module_content .= '</div></div>';

    $module_classes[] = sprintf( 'module-columns-%1$s', $column_count );
else :
    $module_content = '';
endif;


// Ausgabe
if( !empty( $module_content) ) :
    echo sprintf( '<section class="%1$s"%2$s><div class="module-wrapper">%3$s</div></section>',
                  implode( ' ', $module_classes ),
                  ( !empty( $module_id ) )? sprintf( ' id="%1$s"', $module_id ) : '',
                  $module_content
                );
endif;
