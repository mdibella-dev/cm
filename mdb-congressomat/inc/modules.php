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
                            'id'               => '',
                            'title'            => '',
                            'subtitle'         => '',
                            'alignment'        => 0
            ) ) );

    // Variablen setzen
    $output    = '';
    $classes[] = 'module';
    $classes[] = $class;
    $classes[] = $additional_class;

    // Bearbeitung erfolgt nur bei vorhandenem Inhalt
    if( !empty( $content) ) :
        $module_head = '';
        $module_body = '';

        // Titelbereich generieren
        if( !empty( $title ) ) :
            $alignments  = array( 0 => 'module-title-alignment-left',
                                  1 => 'module-title-alignment-center',
                                  2 => 'module-title-alignment-right' );
            $module_head = sprintf( '<div class="module-title %1$s">%2$s%3$s</div>',
                                    $alignments[ $alignment ],
                                    sprintf( '<h2>%1$s</h2>', $title ),
                                    ( $subtitle != '' )? sprintf( '<span class="subheading">%1$s</span>', $subtitle ) : '' );
        endif;

        // Inhaltsbereich generieren
        $module_body = sprintf( '<div class="module-content">%1$s</div>', $content );

        // Modul fertigstellen und ausgeben
        $output = sprintf( '<section class="%1$s"%2$s><div class="module-wrapper">%3$s%4$s</div></section>',
                           implode( ' ', $classes ),
                           ( $id != '' )? sprintf( ' id="%1$s"', $id ) : '',
                           $module_head,
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
        $text = get_sub_field( 'module-description' );

		if( !empty ($text ) ) :
			$title = sprintf( '%1$s (%2$s)', $text, $title );
		endif;
	endif;

	// Rückgabe
	return $title;
}
