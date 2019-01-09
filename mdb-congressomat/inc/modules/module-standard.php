<?php
/**
 * module-standard
 *
 * @author  Marco Di Bella <mdb@marcodibella.de>
 * @package mdb-theme
 * @since   0.0.1
 * @version 0.0.1
 */



/**
 * Variablen setzen
 */

$klasse[]   = 'module';
$klasse[]   = get_row_layout();
$klasse[]   = get_sub_field( 'modul-zusatzklasse' );
$id         = get_sub_field( 'modul-id' );
$titel      = get_sub_field( 'modul-titel' );
$untertitel = get_sub_field( 'modul-untertitel' );
$content    = 'test'; //get_sub_field( 'module-content' );


/**
 * Zentrale Ausgabe
 */

if( $content != '' ) :
    $ausgabe = '';

    // Titelbereich
    if( $titel != '' ) :
        $ausgabe .= sprintf( '<div class="module-title">%1$s%2$s</div>',
                             sprintf( '<h2>%1$s</h2>', $titel ),
                             ( $untertitel != '' )? sprintf( '<h3>%1$s</h3>', $untertitel ) : ''
                           );
    endif;

    // Inhaltsbereich
    $ausgabe .= sprintf( '<div class="module-content">%1$s</div>', $content );


    // Modul zusammenbauen und ausgeben
    echo sprintf( '<section class="%1$s"%2$s><div class="module-wrapper">%3$s</div></section>',
                  implode( ' ', $klasse ),
                  ( $id != '' )? sprintf( ' id="%1$s"', $id ) : '',
                  $ausgabe
                );
endif;
