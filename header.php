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
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
	<header id="header">

		<div id="header-wrapper">

			<div id="header-branding">
				<a class="site-logo"
				   rel="start"
				   href="<?php bloginfo( 'url' );?>"
				   title="<?php echo __( 'Zur Startseite', 'congressomat' ); ?>" >
				</a >
			</div>

			<div id="header-spacer"></div>

			<div id="header-menu-toggle">
				<button class="site-menu-toggle" type="button"><span class="lines"></span></button>
			</div>

			<div id="header-menu">
				<nav class="site-menu">
					<?php
					if( has_nav_menu( 'primary' ) ) :
						wp_nav_menu( array(
							'menu'       	 => ' ',
                 			'menu_class'     => '',
        		 			'theme_location' => 'primary',
        		 			'container'  	 => false,
			 	 			'walker'         => new MegaMenu_Walker()
						) );
					endif;
					?>
				</nav>
			</div>

		</div>

	</header>
