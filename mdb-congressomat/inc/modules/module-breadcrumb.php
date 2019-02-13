<?php
/**
 * Modul mit Brotkrümmelnavigation
 *
 * @author  Marco Di Bella <mdb@marcodibella.de>
 * @package mdb-congressomat
 **/



if( function_exists('yoast_breadcrumb') ) :
	// Ausgabe puffern
	ob_start();

	yoast_breadcrumb( '<nav class="breadcrumb">','</nav>' );

	// Ausgabenpuffer sichern; Pufferung beenden
	$buffer = ob_get_contents();
	ob_end_clean();

	// Modul generieren
	$args = array(
          	'class' => 'module-breadcrumb',
          	'id '   => 'breadcrumb' );

	echo mdb_get_module( $args, $buffer );
endif;
