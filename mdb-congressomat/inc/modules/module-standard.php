<?php
/**
 * Standard-Modul
 *
 * @author  Marco Di Bella <mdb@marcodibella.de>
 * @package mdb-congressomat
 **/



// Variablen setzen
$args[ 'class' ]            = get_row_layout();
$args[ 'additional_class' ] = get_sub_field( 'module-additional-class' );
$args[ 'id' ]               = get_sub_field( 'module-id' );
$content                    = get_sub_field( 'module-content' );

echo mdb_get_module( $args, $content );
