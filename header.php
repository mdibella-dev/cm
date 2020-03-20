<?php
/**
 * Template für den Kopfbereich einer Seite
 *
 * @author  Marco Di Bella <mdb@marcodibella.de>
 * @package congressomat
 **/
?>

<!DOCTYPE html>

<html <?php language_attributes(); ?>>

<head>
	<title><?php wp_title( '', true ); ?></title>

	<meta charset="<?php bloginfo( 'charset' ); ?>"/>
	<meta name="author" content="G&amp;S Verlag GbR">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="geo.region" content="DE-NW" />
	<meta name="geo.placename" content="K&ouml;ln" />
	<meta name="geo.position" content="50.957827;7.017787"/>
	<meta name="ICBM" content="50.957827, 7.017787" />

	<?php
	/**
 	 * Integration von FontAwesome5 CDN
	 * Domäne muss zuvor im fontawesome-account registriert worden sein
	 *
	 * @used-by FontAwesome Plugin (https://wordpress.org/plugins/font-awesome/)
  	 **/
	?>
	<link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.12.1/css/all.css" integrity="sha384-TxKWSXbsweFt0o2WqfkfJRRNVaPdzXJ/YLqgStggBVRREXkwU7OKz+xXtqOU4u8+" crossorigin="anonymous">

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

	<header id="header">
	<?php
	if( has_nav_menu( 'primary' ) ) :
		wp_nav_menu( array(
		    'theme_location' => 'primary',
		    'container'  	 => false,
		) );
	endif;
	?>
	</header>
