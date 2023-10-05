<?php
/**
 * The template to display the header section of a page/post.
 *
 * @author  Marco Di Bella
 * @package cm-theme
 */

namespace cm_theme;


/** Prevent direct access */

defined( 'ABSPATH' ) or exit;

?>
<!DOCTYPE html>

<html <?php language_attributes(); ?>>

<head>
    <title><?php wp_title( '', true ); ?></title>

    <meta charset="<?php bloginfo( 'charset' ); ?>"/>
    <meta name="author" content="G&amp;S Verlag GbR">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">

    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
    <header id="header">
    <?php
    if ( has_nav_menu( 'primary' ) ) {
        wp_nav_menu( [
            'theme_location' => 'primary',
            'container'      => false,
        ] );
    }
    ?>
    </header>
