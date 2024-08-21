<?php

/**
 * @author  RadiusTheme
 * @since   1.0
 * @version 1.0
 */

namespace radiustheme\cirkle;
use radiustheme\cirkle\RDTheme;
?>
<!doctype html>
<html <?php language_attributes(); ?> >

<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
    <?php wp_body_open(); ?>
    <?php
        if (RDTheme::$options['preloader']) {
            do_action('site_prealoader');
        }
    ?>
    <!-- ============== Color Mode Swicth ================== -->
    <?php if ( RDTheme::$options['color_mode'] ) { ?>
    <div class="header__switch header__switch--wrapper">
        <span class="header__switch__settings"><i class="icofont-sun-alt"></i></span>
        <label class="header__switch__label" for="headerSwitchCheckbox">
            <input class="header__switch__input" type="checkbox" name="headerSwitchCheckbox" id="headerSwitchCheckbox">
            <span class="header__switch__main round"></span>
        </label>
        <span class="header__switch__dark"><i class="icofont-moon"></i></span>
    </div>
    <?php } ?>
    <div id="wrapper" class="wrapper">
        <div id="masthead" class="site-header">
            <?php
                get_template_part('template-parts/header/header', RDTheme::$options['shop_header_style']);
            ?>
        </div>

        <?php 
            if ( has_nav_menu( 'sidemenu' ) ) {
                // Sidebar Left
                get_template_part( 'template-parts/header/header', 'left' ); 
            }
        ?>

        <div class="page-content">
            <div class="container">
            <?php get_template_part( 'template-parts/content-banner', 'shop' ); ?>

