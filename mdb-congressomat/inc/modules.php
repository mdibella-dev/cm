<?php
/**
 * Modulares Layout
 *
 * @author  Marco Di Bella <mdb@marcodibella.de>
 * @package mdb-theme
 **/



/**
 * Erzeugt ein Modul
 *
 * @since 1.0.0
 **/

function mdb_do_module( $args, $content )
{
    // Variablen setzen
    $args_default        = array( 'classes' => array(),
                                  'id'      => '' );
    $args                = array_merge( $args_default, $args );
    $args[ 'classes' ][] = 'module';
    $output              = '';


    // Bearbeitung erfolgt nur bei vorhandenem Inhalt
    if( !empty( $content) ) :
        $output = sprintf( '<section class="%1$s"%2$s><div class="module-wrapper">%3$s</div></section>',
                           implode( ' ', $args[ 'classes' ] ),
                           ( !empty( $args[ 'id' ] ) )? sprintf( ' id="%1$s"', $args[ 'id' ] ) : '',
                           sprintf( '<div class="module-content">%1$s</div>', $content ) );
    endif;

    return $output;
}



/**
 * Ergänzt im Backend die standardmäßige Angabe des Modultyps im Titel um einen individuellen Bezeichner mit mehr Aussagekraft
 *
 * @since 1.0.0
 **/

function mdb_set_module_title( $title, $field, $layout, $i )
{
	if( $field[ 'key' ] == 'field_5c35e946eacd2' ) :
        $text = get_sub_field( 'module-id' );

		if( !empty ($text ) ) :
			$title = sprintf( '%1$s (#%2$s)', $title, $text );
		endif;
	endif;

	// Rückgabe
	return $title;
}
