<?php
/**
 * Standard-Modul
 *
 * @author  Marco Di Bella <mdb@marcodibella.de>
 * @package mdb-congressomat
 **/



// Variablen setzen
$args[ 'class' ]            = get_row_layout();
$args[ 'additional_class' ] = get_sub_field( 'modul-zusatzklasse' );
$args[ 'id ' ]              = get_sub_field( 'modul-id' );
$args[ 'title' ]            = get_sub_field( 'modul-titel' );
$args[ 'subtitle' ]         = get_sub_field( 'modul-untertitel' );
$args[ 'alignment' ]        = get_sub_field( 'modul-titel-ausrichtung' );
$content                    = get_sub_field( 'module-content' );

echo mdb_get_module( $args, $content );
