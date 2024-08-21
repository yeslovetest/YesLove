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

<ul class="section-cloud">
	<?php foreach ( $data['rt_anim_shape'] as $index => $item ) { ?>
    <li><img src="<?php echo esc_url( $item['shape_image']['url'] ); ?>" alt="<?php esc_attr_e( 'Shape', 'cirkle' ); ?>"></li>
    <?php } ?>
</ul>