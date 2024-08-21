<?php
/**
 * @author  RadiusTheme
 * @since   1.2
 * @version 1.2
 */
/*------------------------------------------------------------------------------------------------------------------*/
/* Cirkle Demo Import
/*------------------------------------------------------------------------------------------------------------------*/

namespace radiustheme\Cirkle_Core;

use \RevSlider;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class RadiusThemeDemoimport {

	//Magic Mathod
	public function __construct(){
		// Action Hook
		add_action( 'pt-ocdi/after_import', array( $this, 'radiustheme_import_menu_setup' ) );
		add_action( 'pt-ocdi/after_import', array( $this, 'radiustheme_import_page_setup' ) );
		add_action( 'pt-ocdi/after_import', array( $this, 'radiustheme_import_page_setup' ) );
		add_action( 'pt-ocdi/after_import', array( $this, 'rev_slider_import_setup' ) );

		// Filter Hook
		add_filter( 'pt-ocdi/import_files', array( $this, 'radiustheme_import_files' ) );
		add_filter( 'pt-ocdi/plugin_page_setup', array( $this, 'radiustheme_oneclick_admin_page' ) );
		add_filter( 'pt-ocdi/plugin_intro_text', array( $this, 'radiustheme_ocdi_plugin_intro_text' ) );
		add_filter( 'pt-ocdi/disable_pt_branding', '__return_true' );
		add_filter( 'pt-ocdi/confirmation_dialog_options', array( $this, 'radiustheme_ocdi_confirmation_dialog_options' ), 10, 1 );
	}


	/**
	* Demo containes file loading methos
	*/
	public function radiustheme_import_files() {
		return array(
	        //Home 1 Setup
			array(
				'import_file_name'             => 'Home One',
				'categories'                   => array( 'Main Home' ),
				'local_import_file'            => trailingslashit( get_template_directory() ) . 'sample-data/contents.xml',
				'local_import_widget_file'     => trailingslashit( get_template_directory() ) . 'sample-data/widgets.wie',
				'local_import_customizer_file' => trailingslashit( get_template_directory() ) . 'sample-data/customizer.dat',
				'import_preview_image_url'     => plugins_url( 'screenshots/01.jpg', dirname(__FILE__) ),
				'preview_url'                  => 'https://radiustheme.com/demo/wordpress/themes/cirkle/',
				'import_notice'                => __( 'After you import this sample-data, you will have to re save permalik.', 'cirkle-core' ),
			),
			//Home 2 Setup
			array(
				'import_file_name'             => 'Home Two',
				'categories'                   => array( 'Home Two' ),
				'local_import_file'            => trailingslashit( get_template_directory() ) . 'sample-data/contents.xml',
				'local_import_widget_file'     => trailingslashit( get_template_directory() ) . 'sample-data/widgets.wie',
				'local_import_customizer_file' => trailingslashit( get_template_directory() ) . 'sample-data/customizer.dat',
				'import_preview_image_url'     => plugins_url( 'screenshots/02.jpg', dirname(__FILE__) ),
				'preview_url'                  => 'https://radiustheme.com/demo/wordpress/themes/cirkle/home/',
			),
		);
	}


	/**
	* Assign menus to their locations.
	*/
	public function radiustheme_import_menu_setup( $selected_import ) {
		$main_menu = get_term_by( 'name', 'Main Menu', 'nav_menu' );
		$side_menu = get_term_by( 'name', 'Side Menu', 'nav_menu' );
		set_theme_mod( 'nav_menu_locations', array(
				'primary' => $main_menu->term_id,
				'sidemenu' => $side_menu->term_id,
			)
		);
	}


	/**
	* Assign front page and posts page (blog page).
	*/
	public function radiustheme_import_page_setup( $selected_import ) {

	    // Assign front page and posts page (blog page).
		if ( 'Home One' === $selected_import['import_file_name'] ) {
			$front_page_id = get_page_by_title( 'Activity' );
		} elseif ( 'Home Two' === $selected_import['import_file_name'] ) {
			$front_page_id = get_page_by_title( 'Home' );
		} else {
			$front_page_id = get_page_by_title( 'Activity' );
		}

		update_option( 'show_on_front', 'page' );
		update_option( 'page_on_front', $front_page_id->ID ); 

		$blog_page_id  = get_page_by_title( 'Blog' );
		update_option( 'page_for_posts', $blog_page_id->ID );
	}

	/**
	* Install Demos Menu - Menu Edited
	*/
	public function radiustheme_oneclick_admin_page( $default_settings ) {
		$default_settings['parent_slug'] = 'themes.php';
		$default_settings['page_title']  = esc_html__( 'Install Demos', 'cirkle-core' );
		$default_settings['menu_title']  = esc_html__( 'Install Demos', 'cirkle-core' );
		$default_settings['capability']  = 'import';
		$default_settings['menu_slug']   = 'install_demos';
		return $default_settings;
	}


	// Model Popup - Width Increased
	public function radiustheme_ocdi_confirmation_dialog_options ( $options ) {
	  return array_merge( $options, array(
	    'width'       => 600,
	    'dialogClass' => 'wp-dialog',
	    'resizable'   => false,
	    'height'      => 'auto',
	    'modal'       => true,
	  ) );
	}

	public function radiustheme_ocdi_plugin_intro_text( $default_text ) {
		$auto_install = admin_url('themes.php?page=install_demos');
		$manual_install = admin_url('themes.php?page=install_demos&import-mode=manual');
		$default_text .= '<h1>Install Demos</h1>
		<div class="radiustheme-core_intro-text vtdemo-one-click">
		<div id="poststuff">

		<div class="postbox important-notes">
		<h3><span>Important notes:</span></h3>
		<div class="inside">
		<ol>
		<li>Please note, this import process will take time. So, please be patient.</li>
		<li>Please make sure you\'ve installed recommended plugins before you import this content.</li>
		<li>All images are demo purposes only. So, images may repeat in your site content.</li>
		</ol>
		</div>
		</div>

		<div class="postbox vt-support-box vt-error-box">
		<h3><span>Don\'t Edit Parent Theme Files:</span></h3>
		<div class="inside">
		<p>Don\'t edit any files from parent theme! Use only a <strong>Child Theme</strong> files for your customizations!</p>
		<p>If you get future updates from our theme, you\'ll lose edited customization from your parent theme.</p>
		</div>
		</div>

		<div class="postbox vt-support-box">
		<h3><span>Need Support?</span> <a href="https://themeforest.net/user/radiustheme" target="_blank" class="cs-section-video"><i class="fas fa-hand-point-right"></i> <span>How to?</span></a></h3>
		<div class="inside">
		<p>Have any doubts regarding this installation or any other issues? Please feel free to send us a mail to our support stuff mail support@radiustheme.com</p>
		<a href="https://www.radiustheme.com/demo/wordpress/themes/cirkle/docs/" class="button-primary" target="_blank">Docs</a>
		<a href="https://themeforest.net/user/radiustheme/" class="button-primary" target="_blank">Support</a>
		<a href="https://themeforest.net/item/radiustheme/123?ref=radiustheme" class="button-primary" target="_blank">Item Page</a>
		</div>
		</div>
		<div class="nav-tab-wrapper vt-nav-tab">
		<a href="'. $auto_install .'" class="nav-tab vt-mode-switch vt-auto-mode nav-tab-active">Auto Import</a>
		<a href="'. $manual_install .'" class="nav-tab vt-mode-switch vt-manual-mode">Manual Import</a>
		</div>

		</div>
		</div>';

		return $default_text;
	}

} //End Of Class

$radiustheme_init = new RadiusThemeDemoimport(); //Initialization of class
