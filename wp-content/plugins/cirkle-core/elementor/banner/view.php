<?php
/**
 * This file can be overridden by copying it to yourtheme/elementor-custom/banner/view.php
 * 
 * @author  RadiusTheme
 * @since   1.0
 * @version 1.0
 */

namespace radiustheme\Cirkle_Core;
extract( $data );

$bgimg = $bg_image['url'];

?>
<section class="hero-banner" style="background-image: url(<?php echo esc_url( $bgimg ) ?>); ">
    <div class="container">
        <div class="hero-content" data-sal="zoom-out" data-sal-duration="1000">
            <?php if (!empty( $title )) { ?>
            <h1 class="item-title"><?php echo esc_html( $title ); ?></h1>
            <?php } if (!empty( $desc )) { ?>
            <p><?php echo esc_html( $desc ); ?></p>
            <?php } if (!empty( $number )) { ?>
            <div class="item-number"><?php echo esc_html( $number ); ?></div>
            <?php } if (!empty( $number_text )) { ?>
            <div class="conn-people"><?php echo esc_html( $number_text ); ?></div>
            <?php } if (!empty( $btn_link )) { ?>
            <a href="<?php echo esc_url( $btn_link ); ?>" class="button-slide">
                <span class="btn-text"><?php echo esc_html( $btn_txt ); ?></span>
                <span class="btn-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="21px" height="10px">
                        <path fill-rule="evenodd" fill="rgb(255, 255, 255)" d="M16.671,9.998 L12.997,9.998 L16.462,6.000 L5.000,6.000 L5.000,4.000 L16.462,4.000 L12.997,0.002 L16.671,0.002 L21.003,5.000 L16.671,9.998 ZM17.000,5.379 L17.328,5.000 L17.000,4.621 L17.000,5.379 ZM-0.000,4.000 L3.000,4.000 L3.000,6.000 L-0.000,6.000 L-0.000,4.000 Z" />
                    </svg>
                </span>
            </a>
            <?php } ?>
        </div>
    </div>

    <div class="leftside-image">
        <div class="cartoon-image" data-sal="slide-down" data-sal-duration="1000" data-sal-delay="100">
            <?php echo wp_get_attachment_image( $people_shape['id'], 'full' ); ?>
        </div>
        <div class="shape-image" data-sal="slide-down" data-sal-duration="500" data-sal-delay="700">
            <?php echo wp_get_attachment_image( $people_bgshape['id'], 'full' ); ?>
        </div>
    </div>
    <div class="map-line">
        <?php if ( $map_shape['url'] ) { ?>
        <?php echo wp_get_attachment_image( $map_shape['id'], 'full', "", array( "data-sal" => "slide-up", "data-sal-duration" => "500", "data-sal-delay" => "800" ) );  ?>
        <?php } ?>
        <ul class="map-marker">
            <?php if ($marker1['url']) { ?>
            <li data-sal="slide-up" data-sal-duration="700" data-sal-delay="1000"><?php echo wp_get_attachment_image( $marker1['id'], 'full' ); ?></li>
            <?php } if ($marker2['url']) { ?>
            <li data-sal="slide-up" data-sal-duration="800" data-sal-delay="1000"><?php echo wp_get_attachment_image( $marker2['id'], 'full' ); ?></li>
            <?php } if ($marker3['url']) { ?>
            <li data-sal="slide-up" data-sal-duration="900" data-sal-delay="1000"><?php echo wp_get_attachment_image( $marker3['id'], 'full' ); ?></li>
            <?php } if ($marker4['url']) { ?>
            <li data-sal="slide-up" data-sal-duration="1000" data-sal-delay="1000"><?php echo wp_get_attachment_image( $marker4['id'], 'full' ); ?></li>
            <?php } ?>
        </ul>
    </div>
</section>
