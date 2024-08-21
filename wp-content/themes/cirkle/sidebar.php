<?php
/**
 * @author  RadiusTheme
 * @since   1.0
 * @version 1.0
 */

namespace radiustheme\cirkle;
use radiustheme\cirkle\RDTheme;
use radiustheme\cirkle\Helper;

?>
<div class="<?php Helper::the_sidebar_class(); ?>">
	<aside class="sidebar-widget-area sidebar-widget <?php  echo esc_attr( RDTheme::$layout ) ?>">
		<?php
		if ( RDTheme::$sidebar ) {
			if ( is_active_sidebar( RDTheme::$sidebar ) ){
				dynamic_sidebar( RDTheme::$sidebar );
			}
		} elseif( Helper::cirkle_plugin_is_active( 'buddypress' )) {
			if ( bp_is_user() && is_active_sidebar( 'profile-widgets' )) {
				dynamic_sidebar( 'profile-widgets' );
			} elseif ( bp_is_activity_component() && is_active_sidebar( 'profile-widgets' ) ) {
				dynamic_sidebar( 'profile-widgets' );
			} elseif ( bp_is_group_single() && is_active_sidebar( 'group-widgets' ) ) {
				dynamic_sidebar( 'group-widgets' );
			} elseif ( is_bbpress() && is_active_sidebar( 'bbpress-widgets' ) ) {
				dynamic_sidebar( 'bbpress-widgets' );
			} elseif ( is_page( 'members' ) && is_active_sidebar('member-widgets') ) {
				dynamic_sidebar( 'member-widgets' );
			} elseif( class_exists( 'WooCommerce' ) ) {
				if ( is_shop() || is_product() && is_active_sidebar( 'woo-sidebar' ) ) {
					dynamic_sidebar( 'woo-sidebar' );
				} else {
					if ( is_active_sidebar( 'sidebar' ) ){
						dynamic_sidebar( 'sidebar' );
					}
				}
			} else {
				dynamic_sidebar( 'sidebar' );
			}
		} else {
			if ( is_active_sidebar( 'sidebar' ) ){
				dynamic_sidebar( 'sidebar' );
			}
		}
		?> 
	</aside>
</div>
