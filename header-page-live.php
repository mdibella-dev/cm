<?php
/**
 * The template to display the header section of the live page.
 *
 * @author  Marco Di Bella
 * @package cm
 */


/** Prevent direct access */

defined( 'ABSPATH' ) or exit;



?>
<!DOCTYPE html>

<html <?php language_attributes(); ?>>

<head>
    <title><?php wp_title( '', true ); ?></title>

    <meta charset="<?php bloginfo( 'charset' ); ?>"/>
    <meta name="author" content="G&amp;S Verlag GbR">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate">
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="Expires" content="0">


    <?php
    /**
     * FontAwesome5 CDN integration.
     * Domain must have been previously registered in fontawesome-account.
     *
     * @used-by FontAwesome Plugin (https://wordpress.org/plugins/font-awesome/)
     */
    ?>
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.12.1/css/all.css" integrity="sha384-TxKWSXbsweFt0o2WqfkfJRRNVaPdzXJ/YLqgStggBVRREXkwU7OKz+xXtqOU4u8+" crossorigin="anonymous">

    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
    <header id="header">
    <?php
    if( has_nav_menu( 'primary' ) ) :
        wp_nav_menu( [
            'theme_location' => 'primary',
            'container'      => false,
        ] );
    endif;
    ?>
    </header>
