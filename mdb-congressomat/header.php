<?php
/**
 * Template für den Kopfbereich einer Seite
 *
 * @author  Marco Di Bella <mdb@marcodibella.de>
 * @package mdb-congressomat
 **/
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<title><?php wp_title( '', true ); ?></title>
<meta charset="<?php bloginfo( 'charset' ); ?>"/>
<meta name="author" content="<?php echo get_the_author_meta( 'display_name', $post->post_author ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="geo.region" content="DE-NW" />
<meta name="geo.placename" content="K&ouml;ln" />
<meta name="geo.position" content="50.957827;7.017787"/>
<meta name="ICBM" content="50.957827, 7.017787" />
<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<header id="header">
<div id="header-wrapper">
<div>
<button id="logo" type="button"><!-- add your logo as svg here --></button>
</div>
<div>
<button id="toggle" type="button">MENUE</button>
</div>
<div>
<nav id="primary" class="megamenu">
<?php
// Hauptmenü
if( has_nav_menu( 'primary' ) ) :
	wp_nav_menu( array(
				 'menu'       	  => ' ',
                 'menu_class'     => '',
        		 'theme_location' => 'primary',
        		 'container'  	  => FALSE,
			 	 'walker'         => new MegaMenu_Walker() ) );
endif;
?>
</nav>
</div>
</div>
</header>
