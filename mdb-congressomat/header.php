<?php
/**
 * Template für den Kopfbereich einer Seite
 *
 * @author  Marco Di Bella <mdb@marcodibella.de>
 * @package mdb-congressomat
 * @since   0.0.1
 * @version 0.0.1
 */
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
<body <?php body_class( 'dayshift' ); ?>>
<header id="header">
<?php

/**
 * Integration von QuadMenu MegaMenu
 *
 * @since 0.0.1
 */

quadmenu( array( 'theme_location' => 'primary') );
?>
</header>
