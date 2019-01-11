<?php
/**
 * Standard-Modul
 *
 * @author  Marco Di Bella <mdb@marcodibella.de>
 * @package mdb-theme
 */



// Variablen setzen
$class[]     = 'module';
$class[]     = get_row_layout();
$class[]     = get_sub_field( 'modul-zusatzklasse' );
$id          = get_sub_field( 'modul-id' );
$title       = get_sub_field( 'modul-titel' );
$subtitle    = get_sub_field( 'modul-untertitel' );
$content     = 'test'; //get_sub_field( 'module-content' );
$module_head = '';
$module_body = '';


if( $content != '' ) :
    // Titelbereich generieren
    if( $title != '' ) :
        $module_head = sprintf( '<div class="module-title">%1$s%2$s</div>',
                                sprintf( '<h2>%1$s</h2>', $title ),
                                ( $subtitle != '' )? sprintf( '<h3>%1$s</h3>', $subtitle ) : ''
                              );
    endif;

    // Inhaltsbereich generieren
    $module_body = sprintf( '<div class="module-content">%1$s</div>', $content );

    // Modul fertigstellen und ausgeben
    if( ( $module_head != '') and ( $module_body != '' ) ) :
        echo sprintf( '<section class="%1$s"%2$s><div class="module-wrapper">%3$s%4$s</div></section>',
                      implode( ' ', $class ),
                      ( $id != '' )? sprintf( ' id="%1$s"', $id ) : '',
                      $module_head,
                      $module_body
                    );
    endif;
endif;
