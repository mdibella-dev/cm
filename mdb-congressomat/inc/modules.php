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
            $alignments  = array( 0 => 'module-title-left', 1 => 'module-title-center', 2 => 'module-title-right' );
            $module_head = sprintf( '<div class="module-title %1$s">%2$s%3$s</div>',
                                    $alignments[ $alignment ],
                                    sprintf( '<h2>%1$s</h2>', $title ),
                                    ( $subtitle != '' )? sprintf( '<h3>%1$s</h3>', $subtitle ) : '' );
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
