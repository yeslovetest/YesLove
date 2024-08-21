<?php 
namespace radiustheme\cirkle;
use radiustheme\cirkle\Helper;
use radiustheme\cirkle\RDTheme;

$cart = RDTheme::$options['header_cart'] && class_exists( 'WooCommerce' ) ? true : false;
if ( $cart == true ) {
	echo '<div class="dropdown dropdown-cart">';
		CKLWC_Functions::CirkleWooMiniCart();
	echo '</div>';
}
?>