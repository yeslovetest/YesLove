<?php
/**
 * @author  RadiusTheme
 * @since   1.0
 * @version 1.0
 */
namespace radiustheme\cirkle\Customizer;
/**
 * Adds the individual sections, settings, and controls to the theme customizer
 */
class RDTheme_Customizer {
	// Get our default values
	protected $defaults;
    protected static $instance = null;

	public function __construct() {
		// Register Panels
		add_action( 'customize_register', array( $this, 'add_customizer_panels' ) );
		// Register sections
		add_action( 'customize_register', array( $this, 'add_customizer_sections' ) );
	}

    public static function instance() {
        if (null == self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function populated_default_data() {
        $this->defaults = rttheme_generate_defaults();
    }

	/**
	 * Customizer Panels
	 */
	public function add_customizer_panels( $wp_customize ) {

	    // Add Layput Panel
		$wp_customize->add_panel( 'rttheme_layouts_defaults',
		 	array(
				'title' => esc_html__( 'Layout Settings', 'cirkle' ),
				'description' => esc_html__( 'Adjust the overall layout for your site.', 'cirkle' ),
				'priority' => 6,
			)
		);

        // Add General Panel
        $wp_customize->add_panel( 'rttheme_blog_settings',
            array(
                'title' => esc_html__( 'Blog Settings', 'cirkle' ),
                'description' => esc_html__( 'Blog settings for your site.', 'cirkle' ),
                'priority' => 7,
            )
        );

        // Add General Panel
        $wp_customize->add_panel( 'rttheme_cpt_settings',
            array(
                'title' => esc_html__( 'Custom Posts', 'cirkle' ),
                'description' => esc_html__( 'All custom posts settings here.', 'cirkle' ),
                'priority' => 10,
            )
        );

        // Add General Panel
        $wp_customize->add_panel( 'rttheme_bp_settings',
            array(
                'title' => esc_html__( 'BuddyPress', 'cirkle' ),
                'description' => esc_html__( 'BuddyPress settings here.', 'cirkle' ),
                'priority' => 11,
            )
        );
		
	}

    /**
    * Customizer sections
    */
	public function add_customizer_sections( $wp_customize ) {

		// Rename the default Colors section
		$wp_customize->get_section( 'colors' )->title = 'Background';

		// Move the default Colors section to our new Colors Panel
		$wp_customize->get_section( 'colors' )->panel = 'colors_panel';

		// Change the Priority of the default Colors section so it's at the top of our Panel
		$wp_customize->get_section( 'colors' )->priority = 10;

		// Add General Section
		$wp_customize->add_section( 'general_section',
			array(
				'title' => esc_html__( 'General', 'cirkle' ),
				'priority' => 1,
			)
		);

        // Add Contact Section
        $wp_customize->add_section( 'contact_section',
            array(
                'title' => esc_html__( 'Socials', 'cirkle' ),
                'priority' => 2,
            )
        );

		// Add Header Main Section
		$wp_customize->add_section( 'header_section',
			array(
				'title' => esc_html__( 'Header', 'cirkle' ),
				'priority' => 3,
			)
		);

        // Add Footer Section
        $wp_customize->add_section( 'footer_section',
            array(
                'title' => esc_html__( 'Footer', 'cirkle' ),
                'priority' => 4,
            )
        );
        // Add Color Section
        $wp_customize->add_section( 'site_color_section',
            array(
                'title' => esc_html__( 'Color Scheme', 'cirkle' ),
                'priority' => 5,
            )
        );
        // Add Pages Layout Section
        $wp_customize->add_section( 'page_layout_section',
            array(
                'title' => esc_html__( 'Pages Layout', 'cirkle' ),
                'priority' => 6,
                'panel' => 'rttheme_layouts_defaults',
            )
        );
        // Add Single posts/Pages Layout Section
        $wp_customize->add_section( 'single_post_layout_section',
            array(
                'title' => esc_html__( 'Single Post Layout', 'cirkle' ),
                'priority' => 7,
                'panel' => 'rttheme_layouts_defaults',
            )
        );
        // Add Blog Settings Section
        $wp_customize->add_section( 'blog_post_settings_section',
            array(
                'title' => esc_html__( 'Blog Settings', 'cirkle' ),
                'priority' => 8,
                'panel' => 'rttheme_blog_settings',
            )
        );
        // Add Single Blog Settings Section
        $wp_customize->add_section( 'single_post_secttings_section',
            array(
                'title' => esc_html__( 'Single Post Settings', 'cirkle' ),
                'priority' => 9,
                'panel' => 'rttheme_blog_settings',
            )
        );

        // Add BP Profile Settings Section
        $wp_customize->add_section( 'bp_profile_section',
            array(
                'title' => esc_html__( 'Profile', 'cirkle' ),
                'priority' => 1,
                'panel' => 'rttheme_bp_settings',
            )
        );

        // Add BP Member Settings Section
        $wp_customize->add_section( 'bp_member_section',
            array(
                'title' => esc_html__( 'Member', 'cirkle' ),
                'priority' => 2,
                'panel' => 'rttheme_bp_settings',
            )
        );

        // Add BP Group Settings Section
        $wp_customize->add_section( 'bp_group_section',
            array(
                'title' => esc_html__( 'Groups', 'cirkle' ),
                'priority' => 3,
                'panel' => 'rttheme_bp_settings',
            )
        );

        // Add BP Newsfeed Settings Section
        $wp_customize->add_section( 'bp_newsfeed_section',
            array(
                'title' => esc_html__( 'Newsfeed', 'cirkle' ),
                'priority' => 4,
                'panel' => 'rttheme_bp_settings',
            )
        );

        // Add BP Forum Settings Section
        $wp_customize->add_section( 'bp_forum_section',
            array(
                'title' => esc_html__( 'Forum', 'cirkle' ),
                'priority' => 5,
                'panel' => 'rttheme_bp_settings',
            )
        );

        // Shop Products Settings
        $wp_customize->add_section( 'shop_common_section',
            array(
                'title' => esc_html__( 'Common Settings', 'cirkle' ),
                'priority' => 1,
                'panel' => 'woocommerce',
            )
        );
        $wp_customize->add_section( 'shop_products_section',
            array(
                'title' => esc_html__( 'Products', 'cirkle' ),
                'priority' => 2,
                'panel' => 'woocommerce',
            )
        );
        $wp_customize->add_section( 'product_details_section',
            array(
                'title' => esc_html__( 'Product Details', 'cirkle' ),
                'priority' => 3,
                'panel' => 'woocommerce',
            )
        );

        // Add Error Page Section
        $wp_customize->add_section( 'error_section',
            array(
                'title' => esc_html__( 'Error Page', 'cirkle' ),
                'priority' => 12,
            )
        );
        // Add Login Page Section
        $wp_customize->add_section( 'login_section',
            array(
                'title' => esc_html__( 'Login Page', 'cirkle' ),
                'priority' => 13,
            )
        );

	}

}
