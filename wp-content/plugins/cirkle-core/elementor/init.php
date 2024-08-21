<?php
/**
 * @author  RadiusTheme
 * @since   1.0
 * @version 1.0
 */
namespace radiustheme\Cirkle_Core;

use radiustheme\cirkle\Helper;
use Elementor\Controls_Manager;
use Elementor\Plugin;
use Elementor\Core\Kits\Documents\Kit;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
require_once CIRKLE_CORE_BASE_DIR. '/elementor/controls/cirkle-icons.php';
require_once CIRKLE_CORE_BASE_DIR. '/elementor/controls/traits-icons.php';

class Custom_Widget_Init {

	public function __construct() {
		add_action( 'elementor/widgets/register', array( $this, 'init' ) );
		add_action( 'elementor/elements/categories_registered', array( $this, 'widget_categoty' ) );
		add_action( 'elementor/editor/after_enqueue_styles', array( $this, 'editor_style' ) );
		add_action( 'elementor/icons_manager/additional_tabs', array( $this, 'cirkle_flaticon_tab' ) );
		add_action( 'elementor/controls/controls_registered', array( $this, 'cirkle_icon_pack' ), 11 );
		add_action( 'after_switch_theme', [$this, 'cirkle_add_cpt_support'] );
	}


	function cirkle_add_cpt_support() {
	    //if exists, assign to $cpt_support var
		$cpt_support = get_option( 'elementor_cpt_support' );
		
		//check if option DOESN'T exist in db
		if( ! $cpt_support ) {
		    $cpt_support = [ 'page', 'post', 'cirkle_portfolio', 'cirkle_service' ]; //create array of our default supported post types
		    update_option( 'elementor_cpt_support', $cpt_support ); //write it to the database
		}
	}

	/**
     * Extend Icon pack core controls.
     *
     * @param  object $controls_manager Controls manager instance.
     * @return void
     */

   	public function cirkle_icon_pack( $controls_manager ) {
        $controls = array(
         	$controls_manager::ICON => \Cirkle_Icon_Controler::class,
        );
        foreach ( $controls as $control_id => $class_name ) {
         	$controls_manager->unregister( $control_id );
         	// $controls_manager->register_control( $control_id, new $class_name() );
         	// error_log( $class_name );
         	$controls_manager->register( new $class_name() );
        }
   	}

	/**
	 * Adding custom icon to icon control in Elementor
	 */
	public function cirkle_flaticon_tab( $tabs = array() ) {
		// Append new icons
		$flat_icons = ElementorIconTrait::flaticon_icons();
		
		$tabs['cirkle-flaticon-icons'] = array(
			'name'          => 'cirkle-flaticon-icons',
			'label'         => esc_html__( 'Flat Icons', 'cirkle-core' ),
			'labelIcon'     => 'flaticon-magnifying-glass',
			'prefix'        => '',
			'displayPrefix' => '',
			'url'           => Helper::get_css( 'flaticon' ),
			'icons'         => $flat_icons,
			'ver'           => '1.0',
		);
		return $tabs;
	}
	public function editor_style() {
		$img = plugins_url( 'icon.png', __FILE__ );
		wp_add_inline_style( 'elementor-editor', '.elementor-element .icon .rdtheme-el-custom {content: url( '.$img.');width: 28px;}' );
		wp_add_inline_style( 'elementor-editor', '.select2-container--default .select2-selection--single {min-width: 126px !important; min-height: 30px !important;}' );
		wp_enqueue_style( 'cirkle-icofonts-elementor', Helper::get_nomin_css( 'icofont.min' ));
	}

	public function init() {
		require_once __DIR__ . '/base.php';

		$widgets = array(
			'banner'      => 'Rt_Banner',
			'button'      => 'Rt_Button',
			'title'       => 'Rt_Title',
			'features'    => 'Rt_Features',
			'locations'   => 'Rt_Locations',
			'members'     => 'Rt_Member',
			'testimonial' => 'Rt_Testimonial',
			'chooseus'    => 'Rt_Chooseus',
			'near-people' => 'Rt_Near_People',
			'groups'  	  => 'Rt_Groups',
			'mobile-apps' => 'Rt_Mobile_Apps',
			'posts'       => 'Rt_Post',
			'newsletter'  => 'Rt_Newsletter',
			'anim-shape'  => 'Rt_Anim_Shape',
			'prograss'    => 'Rt_Prograss',
			'video'    	  => 'Rt_Video',
			'contact'     => 'Rt_Contact',
		);

		foreach ( $widgets as $dirname => $class ) {
			$template_name = '/elementor-custom/' . $dirname . '/class.php';
			if ( file_exists( STYLESHEETPATH . $template_name ) ) {
				$file = STYLESHEETPATH . $template_name;
			}
			elseif ( file_exists( TEMPLATEPATH . $template_name ) ) {
				$file = TEMPLATEPATH . $template_name;
			}
			else {
				$file = __DIR__ . '/' . $dirname . '/class.php';
			}

			require_once $file;
			
			$classname = __NAMESPACE__ . '\\' . $class;
			Plugin::instance()->widgets_manager->register( new $classname );
		}
	}

	public function widget_categoty( $class ) {
		$id         = CIRKLE_CORE_THEME_PREFIX . '-widgets'; // Category /@dev
		$properties = array(
			'title' => __( 'RadiusTheme Elements', 'cirkle-core' ),
		);
		Plugin::$instance->elements_manager->add_category( $id, $properties );
	}
}

new Custom_Widget_Init();