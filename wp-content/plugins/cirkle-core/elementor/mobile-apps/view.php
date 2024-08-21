<?php
/**
 * This file can be overridden by copying it to yourtheme/elementor-custom/mobile-apps/view-1.php
 * 
 * @author  RadiusTheme
 * @since   1.0
 * @version 1.0
 */

namespace radiustheme\Cirkle_Core;
use radiustheme\cirkle\Helper;
extract( $data );

if (!empty($apps_img['url'])) { ?>
<div class="banner-apps">
	<div class="banner-img">
	    <div class="apps-view">
	        <?php echo wp_get_attachment_image( $apps_img['id'], 'full' ); ?>
	    </div>
	</div>
</div>
<?php } ?>

