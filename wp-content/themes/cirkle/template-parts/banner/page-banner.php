<?php

/**

 * Cirkle Template - BuddyPress Page Banner

 * 

 * @package Cirkle

 * @since 1.0.0

 * @author RadiusTheme (https://www.radiustheme.com/)

 * 

 */

use radiustheme\cirkle\Helper;

  // add BuddyPress member stats data if plugin is active

if (Helper::cirkle_plugin_is_active('buddypress')) {
    $page_img_url = $args['page_img_url'];
    $shape_img_url = $args['shape_img_url'];
	$page_title = $args['page_title']; // Original value from $args
    $page_desc = $args['page_desc'];
}
$page_title = 'Our Professionals'; // Overwriting the original value
?>

<!-- Banner Area Start -->

<div class="newsfeed-banner">

    <div class="media">

        <div class="item-icon">

            <i class="icofont-megaphone-alt"></i>

        </div>

        <div class="media-body">

            <h3 class="item-title"><?php echo esc_html( $page_title ); ?></h3>

            <p><?php echo esc_html( $page_desc ); ?></p>

        </div>

    </div>

    <?php if (!empty( $shape_img_url || $page_img_url )) { ?>

    <ul class="animation-img">

        <li data-sal="slide-down" data-sal-duration="800" data-sal-delay="400"><?php echo wp_kses( $shape_img_url, 'alltext_allow' ); ?></li>

        <li data-sal="slide-up" data-sal-duration="500"><?php echo wp_kses( $page_img_url, 'alltext_allow' ); ?></li>

    </ul>

    <?php } ?>

</div>