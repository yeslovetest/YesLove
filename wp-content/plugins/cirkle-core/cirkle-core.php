<?php
/*
Plugin Name: Cirkle Core
Plugin URI: https://www.radiustheme.com
Description: Cirkle Core Plugin for Cirkle Theme
Version: 1.0.8
Author: RadiusTheme
Text Domain: cirkle-core
Domain Path: /languages
Author URI: https://www.radiustheme.com
*/

use radiustheme\cirkle\RDTheme;

if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! defined( 'CIRKLE_CORE' ) ) {
	$plugin_data = get_file_data( __FILE__, array( 'version' => 'Version' ) );
	define( 'CIRKLE_CORE',              $plugin_data['version'] );
	define( 'CIRKLE_CORE_SCRIPT_VER',   ( WP_DEBUG ) ? time() : CIRKLE_CORE );
	define( 'CIRKLE_CORE_THEME_PREFIX', 'cirkle' );
	define( 'CIRKLE_CORE_CPT', 		 'cirkle' );	
	define( 'CIRKLE_CORE_BASE_URL', 	 plugin_dir_url( __FILE__ ) );
	define( 'CIRKLE_CORE_BASE_DIR',     plugin_dir_path( __FILE__ ) );
}

class Cirkle_Core {

	public $plugin  = 'cirkle-core';
	public $action  = 'cirkle_theme_init';
	protected static $instance;

	public function __construct() {
		add_action( 'plugins_loaded',       array( $this, 'load_textdomain' ), 20 );
		add_action( 'plugins_loaded',       array( $this, 'demo_importer' ), 17 );
		add_action( $this->action,          array( $this, 'after_theme_loaded' ) );
		add_action( 'rdtheme_social_share', array( $this, 'social_share' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'cirkle_core_enqueue_scripts' ), 20 );
		add_action( 'wp_enqueue_scripts', array( $this, 'cirkle_core_enqueue_scripts' ), 20 );
	}

	public static function instance() {
		if ( null == self::$instance ) {
			self::$instance = new self;
		}
		return self::$instance;
	}

	public function cirkle_core_enqueue_scripts() {
		wp_enqueue_script( 'rttheme-select2-js', trailingslashit( get_template_directory_uri() ) . 'inc/customizer/typography/assets/select2.min.js', array( 'jquery' ), '4.0.6', true );
		wp_enqueue_style( 'rttheme-select2-css', trailingslashit( get_template_directory_uri() ) . 'inc/customizer/typography/assets//select2.min.css', array(), '4.0.6', 'all' );
		wp_enqueue_style( 'cirkle-core', CIRKLE_CORE_BASE_URL . 'assets/css/cirkle-core.css' );
		wp_enqueue_script('cirkle-core', CIRKLE_CORE_BASE_URL . 'assets/js/cirkle-core.js', array( 'jquery' ), '', true ); 
		
		wp_localize_script('cirkle-core', 'CirkleCoreObj', array(
			'ajaxurl' => esc_url( admin_url('admin-ajax.php') )
		));
	}
	
	public function after_theme_loaded() {
		if ( defined( 'RT_FRAMEWORK_VERSION' ) ) {
			require_once CIRKLE_CORE_BASE_DIR . 'widgets/init.php'; // Widgets
			require_once CIRKLE_CORE_BASE_DIR . 'inc/user-meta.php'; // User Meta Fields
		}
		if ( did_action( 'elementor/loaded' ) ) {
			require_once CIRKLE_CORE_BASE_DIR . 'elementor/init.php'; // Elementor
		}
	}

	public function social_share( $sharer ){
		include CIRKLE_CORE_BASE_DIR . 'inc/social-share.php';
	}

	public function load_textdomain() {
	    load_plugin_textdomain( $this->plugin, FALSE, basename( dirname( __FILE__ ) ) . '/languages' );
	}

	public function demo_importer() {
		require_once CIRKLE_CORE_BASE_DIR . 'inc/demo-importer.php';
	}

	private static $countryList = [];
	static function getCountryList( $country_id = '') {

		if ( ! self::$countryList ) { 
			self::$countryList = require CIRKLE_CORE_BASE_DIR . 'inc/geo/countries.php';
		}
        
		$countryList = self::$countryList;

        if ( $country_id ) {
        	return apply_filters('cirkle_country_list', $countryList[$country_id]);
        } else {
        	return apply_filters('cirkle_country_list', $countryList);
        }  
    }

    private static $stateList = [];
	static function getStateByCountry( $country_id ='' ) { 
        if ( ! self::$stateList ) { 
        	self::$stateList = require CIRKLE_CORE_BASE_DIR . 'inc/geo/states.php';
        }
              
        $stateList = self::$stateList;

        if ( $country_id ) {
        	return apply_filters('cirkle_state_list', $stateList[$country_id]);
        } else {
        	return apply_filters('cirkle_state_list', $stateList);
        } 
    }

}
Cirkle_Core::instance();
