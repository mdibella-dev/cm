<?php
/**
 * Standard-Modul
 *
 * @author  Marco Di Bella <mdb@marcodibella.de>
 * @package mdb-congressomat
 **/



// Variablen setzen
$class[]     = 'module';
$class[]     = get_row_layout();
$class[]     = get_sub_field( 'modul-zusatzklasse' );
$id          = get_sub_field( 'modul-id' );
$title       = get_sub_field( 'modul-titel' );
$subtitle    = get_sub_field( 'modul-untertitel' );
$alignment   = get_sub_field( 'modul-titel-ausrichtung' );
$content     = get_sub_field( 'module-content' );

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
    echo sprintf( '<section class="%1$s"%2$s><div class="module-wrapper">%3$s%4$s</div></section>',
                  implode( ' ', $class ),
                  ( $id != '' )? sprintf( ' id="%1$s"', $id ) : '',
                  $module_head,
                  $module_body );
endif;
