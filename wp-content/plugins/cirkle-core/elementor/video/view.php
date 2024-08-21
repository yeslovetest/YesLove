<?php
/**
 * This file can be overridden by copying it to yourtheme/elementor-custom/video/view.php
 * 
 * @author  RadiusTheme
 * @since   1.0
 * @version 1.0
 */

namespace radiustheme\Cirkle_Core;

extract( $data );

?>
<!--=====================================-->
<!--=            Video Section      	=-->
<!--=====================================-->
<div class="about-us-img">
    <div class="item-img" data-sal="slide-left" data-sal-duration="800">
        <?php echo wp_get_attachment_image( $image1['id'], 'full' ); ?>
    </div>
    <div class="item-video" data-sal="slide-up" data-sal-duration="800" data-sal-delay="200">
        <?php echo wp_get_attachment_image( $image2['id'], 'full' ); ?>
        <div class="video-icon">
            <a class="play-btn popup-youtube" href="<?php echo esc_url( $video_link ); ?>">
                <i class="icofont-ui-play"></i>
            </a>
        </div>
    </div>
</div>