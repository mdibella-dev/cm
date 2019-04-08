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

function mdb_get_module( $args, $content )
{
    // Parameter auslesen
    extract( wp_parse_args( $args,
                            array(
                            'class'            => '',
							'additional_class' => '',
            ) ) );

    // Variablen setzen
    $output    = '';
    $classes[] = 'module';
    $classes[] = $class;
    $classes[] = $additional_class;

    // Bearbeitung erfolgt nur bei vorhandenem Inhalt
    if( !empty( $content) ) :
        // Inhaltsbereich generieren
        $module_body = sprintf( '<div class="module-content">%1$s</div>', $content );

        // Modul fertigstellen und ausgeben
        $output = sprintf( '<section class="%1$s"%2$s><div class="module-wrapper">%3$s</div></section>',
                           implode( ' ', $classes ),
                           ( !empty( $id ) )? sprintf( ' id="%1$s"', $id ) : '',
                           $module_body );
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
