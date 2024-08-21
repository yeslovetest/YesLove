<?php
/**
 * @author  RadiusTheme
 * @since   1.0
 * @version 1.0
 */
namespace radiustheme\cirkle\Customizer\Settings;

use radiustheme\cirkle\Customizer\RDTheme_Customizer;
use radiustheme\cirkle\Customizer\Controls\Customizer_Switch_Control;
use radiustheme\cirkle\Customizer\Controls\Customizer_Heading_Control;
use radiustheme\cirkle\Customizer\Controls\Customizer_Separator_Control;
use radiustheme\cirkle\Customizer\Controls\Customizer_Image_Radio_Control;
use WP_Customize_Media_Control;
use WP_Customize_Color_Control;
/**
 * Adds the individual sections, settings, and controls to the theme customizer
 */
class RDTheme_Products_Settings extends RDTheme_Customizer {

	public function __construct() {
        parent::instance();
        $this->populated_default_data();
        // Register Page Controls
        add_action( 'customize_register', array( $this, 'register_woo_products_controls' ) );
	}

    public function register_woo_products_controls( $wp_customize ) {

        /**
         * Cirkle Woo Common Feature Setting
        ===================================================================*/
        $wp_customize->add_setting('woo_common_heading', array(
            'default' => '',
            'sanitize_callback' => 'esc_html',
        ));
        $wp_customize->add_control(new Customizer_Heading_Control($wp_customize, 'woo_common_heading', array(
            'label' => __( 'WooCommerce', 'cirkle' ),
            'section' => 'shop_common_section',
        )));


        // Default Header Style
        $wp_customize->add_setting( 'shop_header_style',
            array(
                'default' => $this->defaults['shop_header_style'],
                'transport' => 'refresh',
                'sanitize_callback' => 'rttheme_radio_sanitization'
            )
        );

        $wp_customize->add_control( new Customizer_Image_Radio_Control( $wp_customize, 'shop_header_style',
            array(
                'label' => esc_html__( 'Default Header Layout', 'cirkle' ),
                'description' => esc_html__( 'You can override this settings only Mobile', 'cirkle' ),
                'section' => 'shop_common_section',
                'choices' => array(
                    '1' => array(
                        'image' => trailingslashit( get_template_directory_uri() ) . 'assets/img/header-1.png',
                        'name' => esc_html__( 'Layout 1', 'cirkle' )
                    ),                  
                    '2' => array(
                        'image' => trailingslashit( get_template_directory_uri() ) . 'assets/img/header-2.png',
                        'name' => esc_html__( 'Layout 2', 'cirkle' )
                    ),
                )
            )
        ) );


        $wp_customize->add_setting( 'shop_footer_style',
            array(
                'default' => $this->defaults['shop_footer_style'],
                'transport' => 'refresh',
                'sanitize_callback' => 'rttheme_radio_sanitization'
            )
        );

        $wp_customize->add_control( new Customizer_Image_Radio_Control( $wp_customize, 'shop_footer_style',
            array(
                'label' => esc_html__( 'Footer Layout', 'cirkle' ),
                'description' => esc_html__( 'You can set default footer form here.', 'cirkle' ),
                'section' => 'shop_common_section',
                'choices' => array(
                    '1' => array(
                        'image' => trailingslashit( get_template_directory_uri() ) . 'assets/img/footer-1.png',
                        'name' => esc_html__( 'Layout 1', 'cirkle' )
                    ),                  
                    '2' => array(
                        'image' => trailingslashit( get_template_directory_uri() ) . 'assets/img/footer-2.png',
                        'name' => esc_html__( 'Layout 2', 'cirkle' )
                    ),
                )
            )
        ) );

        // Banner BG Type 
        $wp_customize->add_setting( 'woo_banner_bgimg',
            array(
                'default' => $this->defaults['woo_banner_bgimg'],
                'transport' => 'refresh',
                'sanitize_callback' => 'absint',
            )
        );
        $wp_customize->add_control( new WP_Customize_Media_Control( $wp_customize, 'woo_banner_bgimg',
            array(
                'label' => __( 'Banner Background Image', 'cirkle' ),
                'description' => esc_html__( 'This is the description for the Media Control', 'cirkle' ),
                'section' => 'shop_common_section',
                'mime_type' => 'image',
                'button_labels' => array(
                    'select' => __( 'Select File', 'cirkle' ),
                    'change' => __( 'Change File', 'cirkle' ),
                    'default' => __( 'Default', 'cirkle' ),
                    'remove' => __( 'Remove', 'cirkle' ),
                    'placeholder' => __( 'No file selected', 'cirkle' ),
                    'frame_title' => __( 'Select File', 'cirkle' ),
                    'frame_button' => __( 'Choose File', 'cirkle' ),
                ),
            )
        ) );

        // Banner background image overlay
        $wp_customize->add_setting('woo_banner_bgimage_overlay', 
            array(
                'default' => 'rgba(0, 0, 0, 0.5)', 
                'type' => 'theme_mod', 
                'capability' => 'edit_theme_options', 
                'transport' => 'refresh', 
                'sanitize_callback' => 'sanitize_hex_color',
            )
        );
        $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'woo_banner_bgimage_overlay',
            array(
                'label' => esc_html__('Banner Background Overlay Color', 'cirkle'),
                'settings' => 'woo_banner_bgimage_overlay', 
                'priority' => 10, 
                'section' => 'shop_common_section',
            )
        ));

        /**
         * Separator
         */
        $wp_customize->add_setting('separator_page', array(
            'default' => '',
            'sanitize_callback' => 'esc_html',
        ));
        
        $wp_customize->add_control(new Customizer_Separator_Control($wp_customize, 'separator_page', array(
            'settings' => 'separator_page',
            'section' => 'shop_products_section',
        )));


        /**
         * Shop/Archive Page Layout
        =====================================================================*/
        $wp_customize->add_setting('woo_shop_heading', array(
            'default' => '',
            'sanitize_callback' => 'esc_html',
        ));
        $wp_customize->add_control(new Customizer_Heading_Control($wp_customize, 'woo_shop_heading', array(
            'label' => __( 'Shop Page Layout', 'cirkle' ),
            'section' => 'shop_products_section',
        )));

        $wp_customize->add_setting( 'woo_page_layout',
            array(
                'default' => $this->defaults['woo_page_layout'],
                'transport' => 'refresh',
                'sanitize_callback' => 'rttheme_radio_sanitization'
            )
        );
        $wp_customize->add_control( new Customizer_Image_Radio_Control( $wp_customize, 'woo_page_layout',
            array(
                'label' => __( 'Layout', 'cirkle' ),
                'description' => esc_html__( 'Select the default template layout for Pages', 'cirkle' ),
                'section' => 'shop_products_section',
                'choices' => array(
                    'left-sidebar' => array(
                        'image' => trailingslashit( get_template_directory_uri() ) . 'assets/img/sidebar-left.png',
                        'name' => __( 'Left Sidebar', 'cirkle' )
                    ),
                    'full-width' => array(
                        'image' => trailingslashit( get_template_directory_uri() ) . 'assets/img/sidebar-full.png',
                        'name' => __( 'Full Width', 'cirkle' )
                    ),
                    'right-sidebar' => array(
                        'image' => trailingslashit( get_template_directory_uri() ) . 'assets/img/sidebar-right.png',
                        'name' => __( 'Right Sidebar', 'cirkle' )
                    )
                )
            )
        ) );

        // Posts per page
        $wp_customize->add_setting( 'products_per_page',
            array(
                'default' => $this->defaults['products_per_page'],
                'transport' => 'refresh',
                'sanitize_callback' => 'rttheme_sanitize_integer'
            )
        );
        $wp_customize->add_control( 'products_per_page',
            array(
                'label' => __( 'Products Per Page', 'cirkle' ),
                'section' => 'shop_products_section',
                'type' => 'number'
            )
        );

        /**
         * Products Columns Separator 
         */
        $wp_customize->add_setting('separator_pc', array(
            'default' => '',
            'sanitize_callback' => 'esc_html',
        ));
        $wp_customize->add_control(new Customizer_Separator_Control($wp_customize, 'separator_pc', array(
            'settings' => 'separator_pc',
            'section' => 'shop_products_section',
        )));
        $wp_customize->add_setting( 'products_cols_width',
            array(
                'default' => $this->defaults['products_cols_width'],
                'transport' => 'refresh',
                'sanitize_callback' => 'rttheme_radio_sanitization'
            )
        );
        $wp_customize->add_control( 'products_cols_width',
            array(
                'label' => __( 'Products Columns', 'cirkle' ),
                'section' => 'shop_products_section',
                'description' => esc_html__( 'Width is defined by the number of woocommerce defaul columns.', 'cirkle' ),
                'type' => 'select',
                'choices' => array(
                    '1' => esc_html__( '1 Columns', 'cirkle' ),
                    '6' => esc_html__( '2 Columns', 'cirkle' ),
                    '4' => esc_html__( '3 Columns', 'cirkle' ),
                    '3' => esc_html__( '4 Columns', 'cirkle' ),
                    '2' => esc_html__( '6 Columns', 'cirkle' ),
                )
            )
        );


        /**
         * Product Details
        ==========================================================================================*/
        $wp_customize->add_setting('woo_product_heading', array(
            'default' => '',
            'sanitize_callback' => 'esc_html',
        ));
        $wp_customize->add_control(new Customizer_Heading_Control($wp_customize, 'woo_product_heading', array(
            'label' => __( 'Product Details', 'cirkle' ),
            'section' => 'product_details_section',
        )));

        $wp_customize->add_setting( 'woo_product_details_layout',
            array(
                'default' => $this->defaults['woo_product_details_layout'],
                'transport' => 'refresh',
                'sanitize_callback' => 'rttheme_radio_sanitization'
            )
        );
        $wp_customize->add_control( new Customizer_Image_Radio_Control( $wp_customize, 'woo_product_details_layout',
            array(
                'label' => __( 'Layout', 'cirkle' ),
                'description' => esc_html__( 'Select the default template layout for Pages', 'cirkle' ),
                'section' => 'product_details_section',
                'choices' => array(
                    'left-sidebar' => array(
                        'image' => trailingslashit( get_template_directory_uri() ) . 'assets/img/sidebar-left.png',
                        'name' => __( 'Left Sidebar', 'cirkle' )
                    ),
                    'full-width' => array(
                        'image' => trailingslashit( get_template_directory_uri() ) . 'assets/img/sidebar-full.png',
                        'name' => __( 'Full Width', 'cirkle' )
                    ),
                    'right-sidebar' => array(
                        'image' => trailingslashit( get_template_directory_uri() ) . 'assets/img/sidebar-right.png',
                        'name' => __( 'Right Sidebar', 'cirkle' )
                    )
                )
            )
        ) );

        //  Wishlist Icon Shop
        $wp_customize->add_setting( 'cklwc_related_product',
            array(
                'default' => $this->defaults['cklwc_related_product'],
                'transport' => 'refresh',
                'sanitize_callback' => 'rttheme_switch_sanitization',
            )
        );
        $wp_customize->add_control( new Customizer_Switch_Control( $wp_customize, 'cklwc_related_product',
            array(
                'label' => __( 'Display related products', 'cirkle' ),
                'section' => 'product_details_section',
            )
        ) );

        // Posts per page
        $wp_customize->add_setting( 'related_products_per_page',
            array(
                'default' => $this->defaults['related_products_per_page'],
                'transport' => 'refresh',
                'sanitize_callback' => 'rttheme_sanitize_integer'
            )
        );
        $wp_customize->add_control( 'related_products_per_page',
            array(
                'label' => __( 'Related Products Per Page', 'cirkle' ),
                'section' => 'product_details_section',
                'type' => 'number'
            )
        );

        /**
         * Related Products Columns Separator 
         */
        $wp_customize->add_setting('separator_rpc', array(
            'default' => '',
            'sanitize_callback' => 'esc_html',
        ));
        $wp_customize->add_control(new Customizer_Separator_Control($wp_customize, 'separator_rpc', array(
            'settings' => 'separator_rpc',
            'section' => 'product_details_section',
        )));
        $wp_customize->add_setting( 'related_products_cols',
            array(
                'default' => $this->defaults['related_products_cols'],
                'transport' => 'refresh',
                'sanitize_callback' => 'rttheme_radio_sanitization'
            )
        );
        $wp_customize->add_control( 'related_products_cols',
            array(
                'label' => __( 'Related Products Columns', 'cirkle' ),
                'section' => 'product_details_section',
                'description' => esc_html__( 'Width is defined by the number of woocommerce defaul columns.', 'cirkle' ),
                'type' => 'select',
                'choices' => array(
                    '1' => esc_html__( '1 Columns', 'cirkle' ),
                    '2' => esc_html__( '2 Columns', 'cirkle' ),
                    '3' => esc_html__( '3 Columns', 'cirkle' ),
                    '4' => esc_html__( '4 Columns', 'cirkle' ),
                    '5' => esc_html__( '5 Columns', 'cirkle' ),
                    '6' => esc_html__( '6 Columns', 'cirkle' ),
                )
            )
        );

    }

}

/**
 * Initialise our Customizer settings only when they're required 
 */
if ( class_exists( 'WP_Customize_Control' ) ) {
	new RDTheme_Products_Settings();
}
