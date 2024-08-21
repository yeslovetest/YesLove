<?php
/**
 * This file can be overridden by copying it to yourtheme/elementor-custom/locations/view.php
 * 
 * @author  RadiusTheme
 * @since   1.0
 * @version 1.0
 */

namespace radiustheme\Cirkle_Core;

?>
<div class="community-network">
    <ul class="map-marker">
        <?php 
        	foreach ( $data['rt_locations_list'] as $index => $item ) {
        	extract( $item ); 
        ?>
        <li>
            <?php echo wp_get_attachment_image( $location_image['id'], 'full' ); ?>
        </li>
        <?php } ?>
    </ul>
</div>