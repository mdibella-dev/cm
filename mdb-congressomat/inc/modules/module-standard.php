<?php
/**
 * Standard-Modul
 *
 * @author  Marco Di Bella <mdb@marcodibella.de>
 * @package mdb-congressomat
 **/



// Variablen setzen
$args[ 'classes' ] = array( get_row_layout(),
                            get_sub_field( 'module-additional-class' ) );
$args[ 'id' ]      = get_sub_field( 'module-id' );
$module_content    = get_sub_field( 'module-content' );

echo mdb_do_module( $args, $module_content );
