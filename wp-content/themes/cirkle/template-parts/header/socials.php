<?php
/**
 * @author  RadiusTheme
 * @since   1.0
 * @version 1.0
 */
use radiustheme\cirkle\RDTheme;
use radiustheme\cirkle\Helper;
$socials = Helper::socials();

if (!empty( $socials )) {
	foreach( $socials as $social ){
?>
<a href="<?php echo esc_url( $social['url'] );?>"><i class="<?php echo esc_attr( $social['icon'] );?>"></i></a>

<?php } 
} ?>
