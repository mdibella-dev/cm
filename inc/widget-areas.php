<?php
/**
 * Widget Areas
 *
 * @author  Marco Di Bella <mdb@marcodibella.de>
 * @package mdb-congressomat
 **/



register_sidebar( array(
	'name'			=> __( 'Footer #1', 'mdb-congressomat' ),
	'id'			=> 'footer-one',
	'description'	=> __( 'Die hier abgelegten Widgets erscheinen im Bereich 1 in der Fußzeile.', 'mdb-congressomat' ),
	'before_widget'	=> '<div class="widget %2$s clr">',
	'after_widget'	=> '</div>',
	'before_title'	=> '<h6 class="widget-title">',
	'after_title'	=> '</h6>',
) );

register_sidebar( array(
	'name'			=> __( 'Footer #2', 'mdb-congressomat' ),
	'id'			=> 'footer-two',
	'description'	=> __( 'Die hier abgelegten Widgets erscheinen im Bereich 2 in der Fußzeile.', 'mdb-congressomat' ),
	'before_widget'	=> '<div class="widget %2$s clr">',
	'after_widget'	=> '</div>',
	'before_title'	=> '<h6 class="widget-title">',
	'after_title'	=> '</h6>',
) );

register_sidebar( array(
	'name'			=> __( 'Footer #3', 'mdb-congressomat' ),
	'id'			=> 'footer-three',
	'description'	=> __( 'Die hier abgelegten Widgets erscheinen im Bereich 3 in der Fußzeile.', 'mdb-congressomat' ),
	'before_widget'	=> '<div class="widget %2$s clr">',
	'after_widget'	=> '</div>',
	'before_title'	=> '<h6 class="widget-title">',
	'after_title'	=> '</h6>',
) );
