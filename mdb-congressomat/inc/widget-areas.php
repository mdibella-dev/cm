<?php
/**
 * Widget Areas
 *
 * @author  Marco Di Bella <mdb@marcodibella.de>
 * @package mdb-theme
 **/



register_sidebar( array(
	'name'			=> __( 'Footer #1', TEXT_DOMAIN ),
	'id'			=> 'footer-one',
	'description'	=> __( 'Die hier abgelegten Widgets erscheinen im Bereich 1 in der Fußzeile.', TEXT_DOMAIN ),
	'before_widget'	=> '<div class="widget %2$s clr">',
	'after_widget'	=> '</div>',
	'before_title'	=> '<h6 class="widget-title">',
	'after_title'	=> '</h6>',
) );

register_sidebar( array(
	'name'			=> __( 'Footer #2', TEXT_DOMAIN ),
	'id'			=> 'footer-two',
	'description'	=> __( 'Die hier abgelegten Widgets erscheinen im Bereich 2 in der Fußzeile.', TEXT_DOMAIN ),
	'before_widget'	=> '<div class="widget %2$s clr">',
	'after_widget'	=> '</div>',
	'before_title'	=> '<h6 class="widget-title">',
	'after_title'	=> '</h6>',
) );

register_sidebar( array(
	'name'			=> __( 'Footer #3', TEXT_DOMAIN ),
	'id'			=> 'footer-three',
	'description'	=> __( 'Die hier abgelegten Widgets erscheinen im Bereich 3 in der Fußzeile.', TEXT_DOMAIN ),
	'before_widget'	=> '<div class="widget %2$s clr">',
	'after_widget'	=> '</div>',
	'before_title'	=> '<h6 class="widget-title">',
	'after_title'	=> '</h6>',
) );