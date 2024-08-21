<?php
/**
 * This file can be overridden by copying it to yourtheme/elementor-custom/lists/view.php
 * 
 * @author  RadiusTheme
 * @since   1.0
 * @version 1.0
 */

namespace radiustheme\Cirkle_Core;

?>

<ul class="section-shape">
	<?php foreach ( $data['rt_news_shape'] as $index => $item ) { ?>
    <li><img src="<?php echo esc_url( $item['shape_image']['url'] ); ?>" alt="<?php esc_attr_e( 'shape', 'cirkle' ); ?>"></li>
    <?php } ?>
</ul>
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="newsletter-box">
            <h2 class="item-title"><?php echo esc_html( $data['title'] ); ?></h2>
            <p><?php echo esc_html( $data['desc'] ); ?></p>
            <?php echo do_shortcode( $data['shortcode'] ); ?>
        </div>
    </div>
</div>