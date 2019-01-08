<?php
/**
 * module-class-html
 *
 * @author  Marco Di Bella <mdb@marcodibella.de>
 * @package mdb-theme
 * @since   0.0.1
 * @version 0.0.1
 */



/**
 * Variablen setzen
 */

$content = '';
$args    = array(
           'class'            => get_row_layout(),
           'additional_class' => get_sub_field( 'module-additional-class' ),
           'id'               => get_sub_field( 'module-id' ),
           'title'            => get_sub_field( 'module-title' )
           );


/**
 * Moduloutput generieren
 */

$content .= get_sub_field( 'module-content' );



/**
 * Zentrale Ausgabe
 */

if( $content != '' ) :
    echo mdb_get_module( $args, $content );
endif;
