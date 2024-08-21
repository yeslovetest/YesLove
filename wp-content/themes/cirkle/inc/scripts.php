<?php
/**
 * @author  RadiusTheme
 * @since   1.0
 * @version 1.1
 */

namespace radiustheme\cirkle;

use radiustheme\cirkle\Helper;
use radiustheme\cirkle\RDTheme;
use \WP_Query;
use Elementor\Plugin;

class Scripts {
	public $cirkle = CIRKLE_THEME_PREFIX;
	public $version = CIRKLE_THEME_VERSION;

	public function __construct() {
		add_action( 'wp_enqueue_scripts', array( $this, 'register_scripts' ), 12 );
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ), 15 );
		add_action( 'admin_enqueue_scripts', array( $this, 'admin_conditional_scripts' ), 1 );
	}

	public function fonts_url() {
		$fonts_url = '';
		$subsets   = 'latin';
		$bodyFont  = 'Roboto';
		$bodyFW    = '400';
		$menuFont  = 'Nunito';
		$menuFontW = '500';
		$hFont     = 'Nunito';
		$hFontW    = '700';
		$h1Font    = '';
		$h2Font    = '';
		$h3Font    = '';
		$h4Font    = '';
		$h5Font    = '';
		$h6Font    = '';

		// Body Font
		$body_font = json_decode( RDTheme::$options['typo_body'], true );
		if ( $body_font['font'] == 'Inherit' ) {
			$bodyFont = 'Roboto';
		} else {
			$bodyFont = $body_font['font'];
		}
		$bodyFontW = $body_font['regularweight'];

		// Menu Font
		$menu_font = json_decode( RDTheme::$options['typo_menu'], true );
		if ( $menu_font['font'] == 'Inherit' ) {
			$menuFont = 'Nunito';
		} else {
			$menuFont = $menu_font['font'];
		}
		$menuFontW = $menu_font['regularweight'];

		// Heading Font Settings
		$h_font = json_decode( RDTheme::$options['typo_heading'], true );
		if ( $h_font['font'] == 'Inherit' ) {
			$hFont = 'Nunito-m';
		} else {
			$hFont = $h_font['font'];
		}
		$hFontW = $h_font['regularweight'];

		$h1_font = json_decode( RDTheme::$options['typo_h1'], true );
		$h2_font = json_decode( RDTheme::$options['typo_h2'], true );
		$h3_font = json_decode( RDTheme::$options['typo_h3'], true );
		$h4_font = json_decode( RDTheme::$options['typo_h4'], true );
		$h5_font = json_decode( RDTheme::$options['typo_h5'], true );
		$h6_font = json_decode( RDTheme::$options['typo_h6'], true );

		if ( 'off' !== _x( 'on', 'Google font: on or off', 'cirkle' ) ) {

			if ( ! empty( $h1_font['font'] ) ) {
				if ( $h1_font['font'] == 'Inherit' ) {
					$h1Font  = $hFont;
					$h1FontW = $hFontW;
				} else {
					$h1Font  = $h1_font['font'];
					$h1FontW = $h1_font['regularweight'];
				}
			}
			if ( ! empty( $h2_font['font'] ) ) {
				if ( $h2_font['font'] == 'Inherit' ) {
					$h2Font  = $hFont;
					$h2FontW = $hFontW;
				} else {
					$h2Font  = $h2_font['font'];
					$h2FontW = $h2_font['regularweight'];
				}
			}
			if ( ! empty( $h3_font['font'] ) ) {
				if ( $h3_font['font'] == 'Inherit' ) {
					$h3Font  = $hFont;
					$h3FontW = $hFontW;
				} else {
					$h3Font  = $h3_font['font'];
					$h3FontW = $h3_font['regularweight'];
				}
			}
			if ( ! empty( $h4_font['font'] ) ) {
				if ( $h4_font['font'] == 'Inherit' ) {
					$h4Font  = $hFont;
					$h4FontW = $hFontW;
				} else {
					$h4Font  = $h4_font['font'];
					$h4FontW = $h4_font['regularweight'];
				}
			}
			if ( ! empty( $h5_font['font'] ) ) {
				if ( $h5_font['font'] == 'Inherit' ) {
					$h5Font  = $hFont;
					$h5FontW = $hFontW;
				} else {
					$h5Font  = $h5_font['font'];
					$h5FontW = $h5_font['regularweight'];
				}
			}
			if ( ! empty( $h6_font['font'] ) ) {
				if ( $h6_font['font'] == 'Inherit' ) {
					$h6Font  = $hFont;
					$h6FontW = $hFontW;
				} else {
					$h6Font  = $h6_font['font'];
					$h6FontW = $h6_font['regularweight'];
				}
			}

			$check_families = array();
			$font_families  = array();

			// Body Font
			if ( 'off' !== $bodyFont ) {
				$font_families[] = $bodyFont . ':300,400,500,600,700,800,900,' . $bodyFW;
			}
			$check_families[] = $bodyFont;

			// Menu Font
			if ( 'off' !== $menuFont ) {
				if ( ! in_array( $menuFont, $check_families ) ) {
					$font_families[]  = $menuFont . ':300,400,500,600,700,800,900,' . $menuFontW;
					$check_families[] = $menuFont;
				}
			}

			// Heading Font
			if ( 'off' !== $hFont ) {
				if ( ! in_array( $hFont, $check_families ) ) {
					$font_families[]  = $hFont . ':300,400,500,600,700,800,900,' . $hFontW;
					$check_families[] = $hFont;
				}
			}
			// Heading 1 Font
			if ( ! empty( $h1_font['font'] ) ) {
				if ( 'off' !== $h1Font ) {
					if ( ! in_array( $h1Font, $check_families ) ) {
						$font_families[]  = $h1Font . ':' . $h1FontW;
						$check_families[] = $h1Font;
					}
				}
			}
			// Heading 2 Font
			if ( ! empty( $h2_font['font'] ) ) {
				if ( 'off' !== $h2Font ) {
					if ( ! in_array( $h2Font, $check_families ) ) {
						$font_families[]  = $h2Font . ':' . $h2FontW;
						$check_families[] = $h2Font;
					}
				}
			}
			// Heading 3 Font
			if ( ! empty( $h3_font['font'] ) ) {
				if ( 'off' !== $h3Font ) {
					if ( ! in_array( $h3Font, $check_families ) ) {
						$font_families[]  = $h3Font . ':' . $h3FontW;
						$check_families[] = $h3Font;
					}
				}
			}
			// Heading 4 Font
			if ( ! empty( $h4_font['font'] ) ) {
				if ( 'off' !== $h4Font ) {
					if ( ! in_array( $h4Font, $check_families ) ) {
						$font_families[]  = $h4Font . ':' . $h4FontW;
						$check_families[] = $h4Font;
					}
				}
			}

			// Heading 5 Font
			if ( ! empty( $h5_font['font'] ) ) {
				if ( 'off' !== $h5Font ) {
					if ( ! in_array( $h5Font, $check_families ) ) {
						$font_families[]  = $h5Font . ':' . $h5FontW;
						$check_families[] = $h5Font;
					}
				}
			}
			// Heading 6 Font
			if ( ! empty( $h6_font['font'] ) ) {
				if ( 'off' !== $h6Font ) {
					if ( ! in_array( $h6Font, $check_families ) ) {
						$font_families[]  = $h6Font . ':' . $h6FontW;
						$check_families[] = $h6Font;
					}
				}
			}
			$final_fonts = array_unique( $font_families );
			$query_args  = array(
				'family'  => urlencode( implode( '|', $final_fonts ) ),
				'display' => urlencode( 'fallback' ),
			);

			$fonts_url = add_query_arg( $query_args, "//fonts.googleapis.com/css" );
		}

		return esc_url_raw( $fonts_url );
	}

	public function register_scripts() {
		/* Deregister */
		wp_deregister_style( 'font-awesome' );

		/* = CSS
		======================================================================*/
		// Bootstrap css
		wp_register_style( 'bootstrap', Helper::get_css( 'bootstrap.min' ), array(), $this->version );
		// Icofont css
		wp_register_style( 'icofont', Helper::get_nomin_css( 'icofont.min' ), array(), $this->version );
		// Sal css
		wp_register_style( 'sal', Helper::get_css( 'sal' ), array(), $this->version );
		// Slick css
		wp_register_style( 'slick', Helper::get_nomin_css( 'slick' ), array(), $this->version );
		// Magnific
		wp_register_style( 'magnific-popup', Helper::get_css( 'magnific-popup' ), array(), $this->version );
		// Main Theme Style
		wp_register_style( 'cirkle-style', Helper::get_css( 'style' ), array(), $this->version );

		/* = JS
		======================================================================*/
		// Bootstrap Helper
		wp_register_script( 'popper', Helper::get_js( 'popper.min' ), array( 'jquery' ), $this->version, true );
		// Bootstrap
		wp_register_script( 'bootstrap', Helper::get_js( 'bootstrap.min' ), array( 'jquery' ), $this->version, true );
		// Sal
		wp_register_script( 'sal', Helper::get_js( 'sal' ), array( 'jquery' ), $this->version, true );
		// Slick Slider
		wp_register_script( 'slick', Helper::get_js( 'slick.min' ), array( 'jquery' ), $this->version, true );
		// Magnific Popup
		wp_register_script( 'jquery-magnific-popup', Helper::get_js( 'jquery.magnific-popup.min' ), array( 'jquery' ), $this->version, true );
		wp_register_script( 'color-mode', Helper::get_js( 'color-mode' ), array( 'jquery' ), $this->version, true );
		// Main js
		wp_register_script( 'cirkle-main', Helper::get_js( 'main' ), array( 'jquery' ), $this->version, true );
	}

	public function enqueue_scripts() {
		/*CSS*/
		wp_enqueue_style( 'cirkle-gfonts', $this->fonts_url(), array(), $this->version );
		wp_enqueue_style( 'bootstrap' );
		wp_enqueue_style( 'icofont' );
		wp_enqueue_style( 'sal' );
		wp_enqueue_style( 'slick' );
		$this->conditional_scripts();
		wp_enqueue_style( 'cirkle-style' );
		wp_enqueue_style( 'cirkle-extra-style', Helper::get_file( '/style.css' ), array(), $this->version );
		$this->dynamic_style();

		/*JS*/
		wp_enqueue_script( 'popper' );
		wp_enqueue_script( 'bootstrap' );
		wp_enqueue_script( 'masonry' );
		wp_enqueue_script( 'imagesloaded' );
		wp_enqueue_script( 'sal' );
		wp_enqueue_script( 'slick' );
		if ( Helper::cirkle_plugin_is_active( 'buddypress' ) ) {
			if ( bp_is_current_component( 'photos' ) || bp_is_current_component( 'activity' ) ) {
				if (class_exists('MediaPress')) {
					$lightbox = mpp_get_option( 'load_lightbox' );
					if ( $lightbox == 1 ) {
						wp_enqueue_style( 'magnific-popup' );
						wp_enqueue_script( 'jquery-magnific-popup' );
					}
				}
			}
		}

		if ( RDTheme::$options['color_mode'] ) {
			wp_enqueue_script( 'color-mode' );
		}

		wp_enqueue_script( 'cirkle-main' );
		// add main script
		wp_enqueue_script( 'cirkle-main' );
		$this->localized_scripts();

		wp_enqueue_script( 'cirkle-xmdropdown-scripts', Helper::get_js( 'vendor/xm_dropdown.min' ), [], '1.0.0', true );
		wp_enqueue_script( 'cirkle-xmpopup-scripts', Helper::get_js( 'vendor/xm_popup.min' ), [], '1.0.0', true );
		wp_enqueue_script( 'cirkle-xmtooltip-scripts', Helper::get_js( 'vendor/xm_tooltip.min' ), [], '1.0.0', true );

		// add main script
		wp_enqueue_script( 'cirkle-app', Helper::get_js( 'app.bundle' ), [
			'jquery'
		], time(), true );

		// pass php variables to javascript file
		$vars = [
			'cirkle_url'                => CIRKLE_THEME_BASE_URI,
			'search_url'                => esc_url( home_url( '/' ) ),
			'wp_rest_nonce'             => wp_create_nonce( 'wp_rest' ),
			'ajax_nonce'                => wp_create_nonce( 'cirkle_ajax' ),
			'rest_root'                 => esc_url_raw( rest_url() ),
			'bp_verified_member_badge'  => Helper::bpverifiedmember_badge_get(),
			'activity_show_more_height' => 1000,
			'plugin_active'             => Helper::plugin_get_required_plugins_activation_status(),
			'activity_edit_time_limit'  => 1000000,
			'current_user_is_admin'     => current_user_can( 'administrator' )
		];
		if ( Helper::plugin_is_active( 'bp-verified-member' ) ) {
			$vars['bp_verified_member_badge'] = Helper::bpverifiedmember_badge_get();

			$vars = array_merge( $vars, Helper::bpverifiedmember_settings_get() );
		}
		wp_localize_script( 'cirkle-app', 'cirkle_vars', $vars );

		// pass ajaxurl variable
		wp_localize_script( 'cirkle-app', 'cirkle_lng', cirkle_translation_get() );
	}

	private function conditional_scripts() {
		if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
			wp_enqueue_script( 'comment-reply' );
		}
	}

	public function admin_conditional_scripts() {
		wp_enqueue_style( 'icofont', Helper::get_nomin_css( 'icofont.min' ), array(), $this->version );
		wp_enqueue_style( 'cirkle-gfonts', $this->fonts_url(), array(), $this->version );
		wp_enqueue_script( 'jquery-ui-tabs' );
		wp_enqueue_style( 'wp-color-picker' );
	}

	private function localized_scripts() {
		// Localization
		if ( RDTheme::$header_style == 5 || RDTheme::$header_style == 6 ) {
			$rt_the_logo_light = Helper::rt_the_logo_dark();
		} else {
			$rt_the_logo_light = Helper::rt_the_logo_light();
		}

		if ( RDTheme::$header_style == 5 ) {
			$header_class = 'header-v5';
		} else {
			$header_class = '';
		}

		if ( ! empty( $rt_the_logo_light ) ) {
			$logo = '<a href="' . esc_url( home_url( '/' ) ) . '" alt="' . esc_attr( get_bloginfo( 'title' ) ) . '" class="img-logo"><img class="logo-small" src="' . esc_url( $rt_the_logo_light ) . '" /></a>';
		} else {
			$logo = '<a href="' . esc_url( home_url( '/' ) ) . '" alt="' . esc_attr( get_bloginfo( 'title' ) ) . '"  class="txt-logo">' . esc_html( get_bloginfo( 'title' ) ) . '</a>';
		}
		$adminajax     = esc_url( admin_url( 'admin-ajax.php' ) );
		$localize_data = array(
			'ajaxurl'         => $adminajax,
			'hasAdminBar'     => is_admin_bar_showing() ? 1 : 0,
			'headerStyle'     => RDTheme::$header_style,
			'siteLogo'        => '<div class="mobile-menu-nav-back ' . $header_class . '">' . $logo . '</div>',
			// Ajax
			'ajaxURL'         => admin_url( 'admin-ajax.php' ),
			// 'nonce'           => wp_create_nonce( 'cirkle-nonce' ),
			'wishlist_nonce'  => wp_create_nonce( 'add_to_wishlist' ),
			'cart_update_pbm' => esc_html__( 'Cart Update Problem.', 'cirkle' ),
			'buddypress'      => Helper::plugin_is_active( 'buddypress' )
		);
		wp_localize_script( 'cirkle-main', 'CirkleObj', $localize_data );
	}

	private function dynamic_style() {
		$dynamic_css = $this->template_style();
		ob_start();
		Helper::requires( 'dynamic-style.php' );
		$dynamic_css .= ob_get_clean();
		$dynamic_css = $this->minified_css( $dynamic_css );
		wp_register_style( $this->cirkle . '-dynamic', false );
		wp_enqueue_style( $this->cirkle . '-dynamic' );
		wp_add_inline_style( $this->cirkle . '-dynamic', $dynamic_css );
	}

	private function minified_css( $css ) {
		/* remove comments */
		$css = preg_replace( '!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $css );
		/* remove tabs, spaces, newlines, etc. */
		$css = str_replace( array( "\r\n", "\r", "\n", "\t", '  ', '    ', '    ' ), ' ', $css );

		return $css;
	}

	private function template_style() {
		$style = '';
		if ( is_single() ) {
			if ( ! empty( RDTheme::$bgimg ) ) {
				$opacity = RDTheme::$opacity / 100;
				$style   .= '.single .breadcrumbs-banner { background-image: url(' . RDTheme::$bgimg . ')}';
				$style   .= '.single .breadcrumbs-banner:before { background-color: ' . RDTheme::$bgcolor . '}';
				$style   .= '.single .breadcrumbs-banner:before { opacity: ' . $opacity . '}';
			} else {
				$opacity = RDTheme::$opacity / 100;
				$style   .= '.single .breadcrumbs-banner:before { background-color: ' . RDTheme::$bgcolor . '}';
				$style   .= '.breadcrumbs-banner:before { opacity: ' . $opacity . '}';
			}
		} else {
			if ( ! empty( RDTheme::$bgimg ) ) {
				$opacity = RDTheme::$opacity / 100;
				$style   .= '.breadcrumbs-banner { background-image: url(' . RDTheme::$bgimg . ')}';
				$style   .= '.breadcrumbs-banner:before { background-color: ' . RDTheme::$bgcolor . '}';
				$style   .= '.breadcrumbs-banner:before { opacity: ' . $opacity . '}';
			} else {
				$opacity = RDTheme::$opacity / 100;
				$style   .= '.breadcrumbs-banner:before { background-color: ' . RDTheme::$bgcolor . '}';
				$style   .= '.breadcrumbs-banner:before { opacity: ' . $opacity . '}';
			}
		}

		if ( RDTheme::$banner_pt ) {
			$style .= '.breadcrumbs-banner { padding-top:' . RDTheme::$banner_pt . 'px;}';
		}

		/* = Footer 1
		=======================================================*/
		if ( RDTheme::$options['footer1_bg_img'] ) {
			$f1_bg = wp_get_attachment_image_src( RDTheme::$options['footer1_bg_img'], 'full', true );
			$style .= '.footer-wrap.footer-1:before { background-image: url(' . $f1_bg[0] . ')}';
		}
		if ( RDTheme::$options['footer1_bg_color'] ) {
			$style .= '.footer-wrap.footer-1:before { background-color: ' . RDTheme::$options['footer1_bg_color'] . '}';
		}
		if ( RDTheme::$options['footer1_bg_opacity'] ) {
			$f1o   = RDTheme::$options['footer1_bg_opacity'] / 100;
			$style .= '.footer-wrap.footer-1:before { opacity: ' . $f1o . '}';
		}

		/* = Footer 2
		=======================================================*/
		if ( RDTheme::$options['footer2_bg_img'] ) {
			$f1_bg = wp_get_attachment_image_src( RDTheme::$options['footer2_bg_img'], 'full', true );
			$style .= '.footer-layout2 { background-image: url(' . $f1_bg[0] . ')}';
		}
		if ( RDTheme::$options['footer2_bg_color'] ) {
			$style .= '.footer-layout2 { background-color: ' . RDTheme::$options['footer2_bg_color'] . '}';
		}
		if ( RDTheme::$options['footer2_bg_opacity'] ) {
			$f1o   = RDTheme::$options['footer2_bg_opacity'] / 100;
			$style .= '.footer-layout2 { opacity: ' . $f1o . '}';
		}

		/* = Preloader
		=======================================================*/
		if ( RDTheme::$options['preloader_image'] ) {
			$error_bg = wp_get_attachment_image_src( RDTheme::$options['preloader_image'], 'full', true );
			$style    .= '#preloader { background-image: url(' . $error_bg[0] . ')}';
		}

		/* = Shop Banner
		=======================================================*/
		if ( RDTheme::$options['woo_banner_bgimg'] ) {
			$shop_banner = wp_get_attachment_image_src( RDTheme::$options['woo_banner_bgimg'], 'full', true );
			$style       .= '.product-breadcrumb { background-image: url(' . $shop_banner[0] . ')}';
		}

		/* = Login Background Image
		=======================================================*/
		if ( RDTheme::$options['loginbg'] ) {
			$loginbg = wp_get_attachment_image_src( RDTheme::$options['loginbg'], 'full', true );
			$style   .= '.login-page-wrap .content-wrap { background-image: url(' . $loginbg[0] . ')}';
		}

		return $style;
	}

}

new Scripts;