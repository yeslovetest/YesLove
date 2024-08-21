<?php
/**
 * @author  RadiusTheme
 * @since   1.0
 * @version 1.0
 */

namespace radiustheme\cirkle;

class TGM_Config {
	
	public $cirkle = CIRKLE_THEME_PREFIX;
	public $path   = CIRKLE_THEME_PLUGINS_DIR;
	public function __construct() {
		add_action( 'tgmpa_register', array( $this, 'register_required_plugins' ) );
	}
	public function register_required_plugins(){
		$plugins = array(
			// Bundled
			array(
				'name'         => esc_html__('Cirkle Core','cirkle'),
				'slug'         => 'cirkle-core',
				'source'       => 'cirkle-core.zip',
				'required'     =>  true,
				'version'      => '1.0.8'
			),
			array(
				'name'         => esc_html__('RT Framework','cirkle'),
				'slug'         => 'rt-framework',
				'source'       => 'rt-framework.zip',
				'required'     =>  true,
				'version'      => '2.8'
			),
			array(
				'name'         => esc_html__('RT React','cirkle'),
				'slug'         => 'rtreact',
				'source'       => 'rtreact-v1.0.4.zip',
				'required'     =>  true,
				'version'      => '1.0.4'
			),
			array(
				'name'         => esc_html__('RT Demo Importer','cirkle'),
				'slug'         => 'rt-demo-importer',
				'source'       => 'rt-demo-importer.zip',
				'required'     =>  false,
				'version'      => '5.0.0'
			),
			array(
				'name'         => esc_html__('Member Import/Export','cirkle'),
				'slug'         => 'buddypress-member-export-import',
				'source'       => 'buddypress-member-export-import.zip',
				'required'     =>  false,
			),
			// Repository
			array(
				'name'     => esc_html__('Elementor Page Builder','cirkle'),
				'slug'     => 'elementor',
				'required' => true,
			),
			array(
				'name'     => esc_html__( 'WooCommerce','cirkle' ),
				'slug'     => 'woocommerce',
				'required' => false,
			),
			array(
				'name'     => esc_html__( 'YITH WooCommerce Quick View','cirkle' ),
				'slug'     => 'yith-woocommerce-quick-view',
				'required' => false,
			),
			array(
				'name'     => esc_html__( 'YITH WooCommerce Wishlist','cirkle' ),
				'slug'     => 'yith-woocommerce-wishlist',
				'required' => false,
			),
			array(
				'name'     => esc_html__('Breadcrumb NavXT','cirkle'),
				'slug'     => 'breadcrumb-navxt',
				'required' => false,
			),
			array(
				'name'     => esc_html__('Fluent Forms','cirkle'),
				'slug'     => 'fluentform',
				'required' => true,
			),
			//Community Plugins
			array(
				'name'     => esc_html__('BuddyPress','cirkle'),
				'slug'     => 'buddypress',
				'required' => true,
			),
			array(
				'name'     => esc_html__('BbPress','cirkle'),
				'slug'     => 'bbpress',
				'required' => true,
			),
			array(
				'name'     => esc_html__('MediaPress','cirkle'),
				'slug'     => 'mediapress',
				'required' => true,
			),
			array(
				'name'     => esc_html__('GamiPress','cirkle'),
				'slug'     => 'gamipress',
				'required' => true,
			),
			array(
				'name'     => esc_html__('GamiPress BuddyPress Integration','cirkle'),
				'slug'     => 'gamipress-buddypress-integration',
				'required' => true,
			),
			array(
				'name'     => esc_html__('Verified Member for BuddyPress','cirkle'),
				'slug'     => 'bp-verified-member',
				'required' => true,
			),

			
		);
		$config = array( 
			'id'           => $this->cirkle,            // Unique ID for hashing notices for multiple instances of TGMPA.
			'default_path' => $this->path,              // Default absolute path to bundled plugins.
			'menu'         => $this->cirkle . '-install-plugins', // Menu slug.
			'has_notices'  => true,                    // Show admin notices or not.
			'dismissable'  => true,                    // If false, a user cannot dismiss the nag message.
			'dismiss_msg'  => '',                      // If 'dismissable' is false, this message will be output at top of nag.
			'is_automatic' => false,                    // Automatically activate plugins after installation or not.
			'message'      => '',                      // Message to output right before the plugins table.
		);

		tgmpa( $plugins, $config );
	}
}
new TGM_Config;