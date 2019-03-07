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
$args[ 'id ' ]              = get_sub_field( 'module-id' );
$args[ 'title' ]            = get_sub_field( 'module-title' );
$args[ 'subtitle' ]         = get_sub_field( 'module-subtitle' );
$args[ 'alignment' ]        = get_sub_field( 'module-title-alignment' );


$content = 'TEST';

echo mdb_get_module( $args, $content );
