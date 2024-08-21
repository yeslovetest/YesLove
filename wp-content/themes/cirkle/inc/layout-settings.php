<?php
/**
 * @author  RadiusTheme
 * @since   1.0
 * @version 1.0
 */

namespace radiustheme\cirkle;
use radiustheme\cirkle\RDTheme;
use radiustheme\cirkle\Helper;
class Layouts {
	public $cirkle = CIRKLE_THEME_PREFIX;
	public $cpt   = CIRKLE_THEME_CPT_PREFIX;

	public function __construct() {
		add_action( 'template_redirect', array( $this, 'layout_settings' ) );
	}
	public function layout_settings() {

		// Single Pages
		if( is_single() || is_page() ) {
			$post_type = get_post_type();
			$post_id   = get_the_ID();
			switch( $post_type ) {
				case 'page':
				$cirkle = 'page';
				break;
				case 'post':
				$cirkle = 'single_post';
				break;
				default:
				$cirkle = 'single_post';
				break;
			}

			// Layout and Header, Footer
			$layout         	  = get_post_meta( $post_id, "{$this->cpt}_layout", true );
			$header_style   	  = get_post_meta( $post_id, "{$this->cpt}_header", true );
			$footer_style   	  = get_post_meta( $post_id, "{$this->cpt}_footer", true );
			// If Above Layout and Header, Footer code missd then under code will work by default
			RDTheme::$layout = ( empty( $layout ) || $layout == 'default' ) ? RDTheme::$options[$cirkle . '_layout'] : $layout;
			RDTheme::$header_style = ( empty( $header_style ) || $header_style == 'default' ) ? RDTheme::$options['header_style'] : $header_style;
			RDTheme::$footer_style = ( empty( $footer_style ) || $footer_style == 'default' ) ? RDTheme::$options['footer_style'] : $footer_style;

			// Others
			$has_breadcrumb   = get_post_meta( $post_id, "{$this->cirkle}_breadcrumb", true );
			$has_banner 	  = get_post_meta( $post_id, "{$this->cirkle}_has_banner", true );
			$trans_menu 	  = get_post_meta( $post_id, "{$this->cirkle}_menu_transparent", true );
			$bgcolor          = get_post_meta( $post_id, "{$this->cpt}_menu_bg_color", true );
			$bgimg            = get_post_meta( $post_id, "{$this->cpt}_menu_bg_img", true );	
			$opacity 	      = get_post_meta( $post_id, "{$this->cirkle}_banner_bg_opacity", true );
			$banner_pt   = get_post_meta( $post_id, "{$this->cirkle}_banner_padding_top", true );
			// If Above Others code missed then under code will work by default
			RDTheme::$has_breadcrumb = ( empty( $has_breadcrumb ) || $has_breadcrumb == 'default' ) ? RDTheme::$options['cirkle_breadcrumb'] : $has_breadcrumb;
			RDTheme::$has_banner = ( empty( $has_banner ) || $has_banner == 'default' ) ? RDTheme::$options['cirkle_has_banner'] : $has_banner;
			RDTheme::$trans_menu = ( empty( $trans_menu ) || $trans_menu == 'default' ) ? 'off' : $trans_menu;
			RDTheme::$bgcolor = empty( $bgcolor ) ? RDTheme::$options['banner_bg_color'] : $bgcolor;
			RDTheme::$opacity = empty( $opacity ) ? RDTheme::$options['banner_bg_opacity'] : $opacity;
			RDTheme::$banner_pt = empty( $banner_pt ) ? RDTheme::$options['banner_padding_top'] : $banner_pt;

			// Menu Background Image Settings
			if (is_singular( 'cirkle_gallery' )) { 
				$attch_url      = wp_get_attachment_image_src( RDTheme::$options['single_gallery_banner_bgimg'], 'full', true );
				RDTheme::$bgimg = $attch_url[0];
			} elseif( !empty( $bgimg ) ) {
				$attch_url      = wp_get_attachment_image_src( $bgimg, 'full', true );
				RDTheme::$bgimg = $attch_url[0];
			}
			elseif ( has_header_image() ) {
				RDTheme::$bgimg = get_header_image();
			}
			elseif( !empty( RDTheme::$options['banner_bg_img']) ) {
				$attch_url      = wp_get_attachment_image_src( RDTheme::$options['banner_bg_img'], 'full', true );
				RDTheme::$bgimg = $attch_url[0];
			}
			else {
				RDTheme::$bgimg = '';
			}
			
			if ( function_exists( 'is_buddypress' ) ) {
				if ( is_page( 'members' ) && is_active_sidebar('member-widgets') ) {
					RDTheme::$layout = 'right-sidebar';
				} elseif ( bp_is_user() && is_active_sidebar('profile-widgets')) {
					RDTheme::$layout = 'right-sidebar';
				} elseif ( bp_is_activity_component() && is_active_sidebar('profile-widgets')) {
					RDTheme::$layout = 'right-sidebar';
				} elseif ( bp_is_group_single() && is_active_sidebar('group-widgets')  ) {
					RDTheme::$layout = 'right-sidebar';
				} else {
					RDTheme::$layout = RDTheme::$layout;
				}
			}

			if ( function_exists( 'is_bbpress' ) && is_active_sidebar('bbpress-widgets') ) {
				if ( is_bbpress() && is_active_sidebar('bbpress-widgets')  ) {
					RDTheme::$layout = 'right-sidebar';
				} else if ( !is_active_sidebar( 'sidebar' ) ){
					RDTheme::$layout = RDTheme::$layout;
				}
			}

			if ( class_exists( 'WooCommerce' ) ) {
				if ( is_product() ) {
					RDTheme::$layout = RDTheme::$options['woo_product_details_layout'];
				} else {
					RDTheme::$layout = RDTheme::$layout;
				}
			}

		}

		// Blog and Archive work by default code
		elseif( is_home() || is_archive() || is_search() || is_404() ) {

			$cirkle = 'page';
			// Layout and Header, Footer
			RDTheme::$layout         = RDTheme::$options[$cirkle . '_layout'];	
			RDTheme::$header_style   = RDTheme::$options['header_style'];
			RDTheme::$footer_style   = RDTheme::$options['footer_style'];
			// Others
			RDTheme::$has_breadcrumb = RDTheme::$options['cirkle_breadcrumb'];
			RDTheme::$has_banner     = RDTheme::$options['cirkle_has_banner'];
			RDTheme::$bgcolor        = RDTheme::$options['banner_bg_color'];
			RDTheme::$opacity        = RDTheme::$options['banner_bg_opacity'];
			RDTheme::$banner_pt      = RDTheme::$options['banner_padding_top'];
			RDTheme::$banner_pb      = RDTheme::$options['banner_padding_bottom'];
			RDTheme::$trans_menu     = 'off';

			if (is_singular( 'cirkle_gallery' )) { 
				$attch_url      = wp_get_attachment_image_src( RDTheme::$options['single_gallery_banner_bgimg'], 'full', true );
				RDTheme::$bgimg = $attch_url[0];
			} elseif ( has_header_image() ) {
				RDTheme::$bgimg = get_header_image();
			} elseif( !empty( RDTheme::$options['banner_bg_img']) ) {
				$attch_url      = wp_get_attachment_image_src( RDTheme::$options['banner_bg_img'], 'full', true );
				RDTheme::$bgimg = $attch_url[0];
			} else {
				RDTheme::$bgimg = '';
			}

			if ( function_exists( 'is_bbpress' ) ) {
				if ( is_bbpress() && is_active_sidebar('bbpress-widgets')  ) {
					RDTheme::$layout = 'right-sidebar';
				} else if ( !is_active_sidebar( 'sidebar' ) ){
					RDTheme::$layout = 'full-width';
				}
			}
			if ( class_exists( 'WooCommerce' ) ) {
				if ( is_shop() ) {
					RDTheme::$layout = RDTheme::$options['woo_page_layout'];
				} else {
					RDTheme::$layout = RDTheme::$layout;
				}
			}

		}
	}
}
new Layouts;
