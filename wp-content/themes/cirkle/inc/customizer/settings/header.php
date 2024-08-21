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
use radiustheme\cirkle\Customizer\Controls\Customizer_Heading_Control2;
use radiustheme\cirkle\Customizer\Controls\Customizer_Image_Radio_Control;
use WP_Customize_Media_Control;
use WP_Customize_Color_Control;

/**
 * Adds the individual sections, settings, and controls to the theme customizer
 */
class RDTheme_Header_Settings extends RDTheme_Customizer {

	public function __construct() {
	    parent::instance();
        $this->populated_default_data();
        // Add Controls
        add_action( 'customize_register', array( $this, 'register_header_controls' ) );
	}

    public function register_header_controls( $wp_customize ) {

        // Default Header Style
        $wp_customize->add_setting( 'header_style',
            array(
                'default' => $this->defaults['header_style'],
                'transport' => 'refresh',
                'sanitize_callback' => 'rttheme_radio_sanitization'
            )
        );

        $wp_customize->add_control( new Customizer_Image_Radio_Control( $wp_customize, 'header_style',
            array(
                'label' => esc_html__( 'Default Header Layout', 'cirkle' ),
                'description' => esc_html__( 'You can override this settings only Mobile', 'cirkle' ),
                'section' => 'header_section',
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


         // BuddyPress Header Style
        $wp_customize->add_setting( 'bp_header_style',
            array(
                'default' => $this->defaults['bp_header_style'],
                'transport' => 'refresh',
                'sanitize_callback' => 'rttheme_radio_sanitization'
            )
        );

        $wp_customize->add_control( new Customizer_Image_Radio_Control( $wp_customize, 'bp_header_style',
            array(
                'label' => esc_html__( 'BuddyPress Header Layout', 'cirkle' ),
                'description' => esc_html__( 'You can override this settings only Mobile', 'cirkle' ),
                'section' => 'header_section',
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


        /**
         * Heading
         */
        $wp_customize->add_setting('header_switching', array(
            'default' => '',
            'sanitize_callback' => 'esc_html',
        ));
        $wp_customize->add_control(new Customizer_Heading_Control2($wp_customize, 'header_switching', array(
            'label' => esc_html__( 'H1 Site Switch Control', 'cirkle' ),
            'section' => 'header_section',
        )));

        // Add our Checkbox switch setting and control for opening URLs in a new tab
        $wp_customize->add_setting( 'header_social',
            array(
                'default' => $this->defaults['header_social'],
                'transport' => 'refresh',
                'sanitize_callback' => 'rttheme_switch_sanitization',
            )
        );
        $wp_customize->add_control( new Customizer_Switch_Control( $wp_customize, 'header_social',
            array(
                'label' => esc_html__( 'Header Social', 'cirkle' ),
                'section' => 'header_section',
            )
        ) );

        // Add our Checkbox switch setting and control for opening URLs in a new tab
        $wp_customize->add_setting( 'header_search',
            array(
                'default' => $this->defaults['header_search'],
                'transport' => 'refresh',
                'sanitize_callback' => 'rttheme_switch_sanitization',
            )
        );
        $wp_customize->add_control( new Customizer_Switch_Control( $wp_customize, 'header_search',
            array(
                'label' => esc_html__( 'Search', 'cirkle' ),
                'section' => 'header_section',
            )
        ) );

        // Add our Checkbox switch setting and control for opening URLs in a new tab
        $wp_customize->add_setting( 'header_link',
            array(
                'default' => $this->defaults['header_link'],
                'transport' => 'refresh',
                'sanitize_callback' => 'rttheme_switch_sanitization',
            )
        );
        $wp_customize->add_control( new Customizer_Switch_Control( $wp_customize, 'header_link',
            array(
                'label' => esc_html__( 'Link Button', 'cirkle' ),
                'section' => 'header_section',
            )
        ) );
        // Link Button Text
        $wp_customize->add_setting( 'hlb_txt',
            array(
                'default' => $this->defaults['hlb_txt'],
                'transport' => 'refresh',
                'sanitize_callback' => 'rttheme_text_sanitization',
            )
        );
        $wp_customize->add_control( 'hlb_txt',
            array(
                'label' => esc_html__( 'Link Button Text', 'cirkle' ),
                'section' => 'header_section',
                'type' => 'text',
                'active_callback' => 'rttheme_header_link_btn_enabled',
            )
        );
        // Link Button Link
        $wp_customize->add_setting( 'hlb_link',
            array(
                'default' => $this->defaults['hlb_link'],
                'transport' => 'refresh',
                'sanitize_callback' => 'rttheme_text_sanitization',
            )
        );
        $wp_customize->add_control( 'hlb_link',
            array(
                'label' => esc_html__( 'Link Button Link', 'cirkle' ),
                'section' => 'header_section',
                'type' => 'text',
                'active_callback' => 'rttheme_header_link_btn_enabled',
            )
        );


        /**
         * H2 Heading
         */
        $wp_customize->add_setting('header2_switching', array(
            'default' => '',
            'sanitize_callback' => 'esc_html',
        ));
        $wp_customize->add_control(new Customizer_Heading_Control2($wp_customize, 'header2_switching', array(
            'label' => esc_html__( 'H2 Site Switch Control', 'cirkle' ),
            'section' => 'header_section',
        )));

        // Add our Checkbox switch setting and control for opening URLs in a new tab
        $wp_customize->add_setting( 'header_profile',
            array(
                'default' => $this->defaults['header_profile'],
                'transport' => 'refresh',
                'sanitize_callback' => 'rttheme_switch_sanitization',
            )
        );
        $wp_customize->add_control( new Customizer_Switch_Control( $wp_customize, 'header_profile',
            array(
                'label' => esc_html__( 'Header Profile', 'cirkle' ),
                'section' => 'header_section',
            )
        ) );

        // Add our Checkbox switch setting and control for opening URLs in a new tab
        $wp_customize->add_setting( 'header_notification',
            array(
                'default' => $this->defaults['header_notification'],
                'transport' => 'refresh',
                'sanitize_callback' => 'rttheme_switch_sanitization',
            )
        );
        $wp_customize->add_control( new Customizer_Switch_Control( $wp_customize, 'header_notification',
            array(
                'label' => esc_html__( 'Header Notification', 'cirkle' ),
                'section' => 'header_section',
            )
        ) );

        // Add our Checkbox switch setting and control for opening URLs in a new tab
        $wp_customize->add_setting( 'header_message',
            array(
                'default' => $this->defaults['header_message'],
                'transport' => 'refresh',
                'sanitize_callback' => 'rttheme_switch_sanitization',
            )
        );
        $wp_customize->add_control( new Customizer_Switch_Control( $wp_customize, 'header_message',
            array(
                'label' => esc_html__( 'Header Messaage', 'cirkle' ),
                'section' => 'header_section',
            )
        ) );

        // Add our Checkbox switch setting and control for opening URLs in a new tab
        $wp_customize->add_setting( 'header_friend',
            array(
                'default' => $this->defaults['header_friend'],
                'transport' => 'refresh',
                'sanitize_callback' => 'rttheme_switch_sanitization',
            )
        );
        $wp_customize->add_control( new Customizer_Switch_Control( $wp_customize, 'header_friend',
            array(
                'label' => esc_html__( 'Header Friend', 'cirkle' ),
                'section' => 'header_section',
            )
        ) );

        // Add our Checkbox switch setting and control for opening URLs in a new tab
        $wp_customize->add_setting( 'header_cart',
            array(
                'default' => $this->defaults['header_cart'],
                'transport' => 'refresh',
                'sanitize_callback' => 'rttheme_switch_sanitization',
            )
        );
        $wp_customize->add_control( new Customizer_Switch_Control( $wp_customize, 'header_cart',
            array(
                'label' => esc_html__( 'Woo Mini Cart', 'cirkle' ),
                'section' => 'header_section',
            )
        ) );


        // Add our Checkbox switch setting and control for opening URLs in a new tab 
        $wp_customize->add_setting( 'cirkle_has_banner',
            array(
                'default' => $this->defaults['cirkle_has_banner'],
                'transport' => 'refresh',
                'sanitize_callback' => 'rttheme_switch_sanitization',
            )
        );
        $wp_customize->add_control( new Customizer_Switch_Control( $wp_customize, 'cirkle_has_banner',
            array(
                'label' => esc_html__( 'Has Banner', 'cirkle' ),
                'section' => 'header_section',
            )
        ) );

        /**
         * Banner Background Settings
         */
        $wp_customize->add_setting('banner_bg_heading', array(
            'default' => '',
            'sanitize_callback' => 'esc_html',
        ));
        $wp_customize->add_control(new Customizer_Heading_Control($wp_customize, 'banner_bg_heading', array(
            'label' => esc_html__( 'Banner Settings', 'cirkle' ),
            'section' => 'header_section',
            'active_callback' => 'rttheme_is_header_banner_enabled',
        )));

        // Banner background image
        $wp_customize->add_setting( 'banner_bg_img',
            array(
                'default' => $this->defaults['banner_bg_img'],
                'transport' => 'refresh',
                'sanitize_callback' => 'absint',
            )
        );
        $wp_customize->add_control( new WP_Customize_Media_Control( $wp_customize, 'banner_bg_img',
            array(
                'label' => esc_html__( 'Banner Background Image', 'cirkle' ),
                'description' => esc_html__( 'This is the description for the Media Control', 'cirkle' ),
                'section' => 'header_section',
                'mime_type' => 'image',
                'button_labels' => array(
                    'select' => esc_html__( 'Select File', 'cirkle' ),
                    'change' => esc_html__( 'Change File', 'cirkle' ),
                    'default' => esc_html__( 'Default', 'cirkle' ),
                    'remove' => esc_html__( 'Remove', 'cirkle' ),
                    'placeholder' => esc_html__( 'No file selected', 'cirkle' ),
                    'frame_title' => esc_html__( 'Select File', 'cirkle' ),
                    'frame_button' => esc_html__( 'Choose File', 'cirkle' ),
                ),
                'active_callback' => 'rttheme_is_header_banner_enabled',
            )
        ) );
        // Banner image
        $wp_customize->add_setting( 'banner_img',
            array(
                'default' => $this->defaults['banner_img'],
                'transport' => 'refresh',
                'sanitize_callback' => 'absint',
            )
        );
        $wp_customize->add_control( new WP_Customize_Media_Control( $wp_customize, 'banner_img',
            array(
                'label' => esc_html__( 'Banner Image', 'cirkle' ),
                'description' => esc_html__( 'This is the description for the Media Control', 'cirkle' ),
                'section' => 'header_section',
                'mime_type' => 'image',
                'button_labels' => array(
                    'select' => esc_html__( 'Select File', 'cirkle' ),
                    'change' => esc_html__( 'Change File', 'cirkle' ),
                    'default' => esc_html__( 'Default', 'cirkle' ),
                    'remove' => esc_html__( 'Remove', 'cirkle' ),
                    'placeholder' => esc_html__( 'No file selected', 'cirkle' ),
                    'frame_title' => esc_html__( 'Select File', 'cirkle' ),
                    'frame_button' => esc_html__( 'Choose File', 'cirkle' ),
                ),
                'active_callback' => 'rttheme_is_header_banner_enabled',
            )
        ) );
        // Banner background color
        $wp_customize->add_setting('banner_bg_color', 
            array(
                'default' => '#2d5be3',
                'type' => 'theme_mod', 
                'capability' => 'edit_theme_options', 
                'transport' => 'refresh', 
                'sanitize_callback' => 'sanitize_hex_color',
            )
        );
        $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'banner_bg_color',
            array(
                'label' => esc_html__('Banner Background Color', 'cirkle'),
                'settings' => 'banner_bg_color', 
                'priority' => 10, 
                'section' => 'header_section', 
                'active_callback' => 'rttheme_is_header_banner_enabled',
            )
        ));
        // Banner background color opacity
        $wp_customize->add_setting( 'banner_bg_opacity',
            array(
                'default' => $this->defaults['banner_bg_opacity'],
                'transport' => 'refresh',
                'sanitize_callback' => 'rttheme_sanitize_integer',
            )
        );
        $wp_customize->add_control( 'banner_bg_opacity',
            array(
                'label' => esc_html__( 'Background Opacity', 'cirkle' ),
                'section' => 'header_section',
                'type' => 'number',
                'active_callback' => 'rttheme_is_header_banner_enabled',
            )
        );

        // Banner Padding Top
        $wp_customize->add_setting( 'banner_padding_top',
            array(
                'default' => $this->defaults['banner_padding_top'],
                'transport' => 'refresh',
                'sanitize_callback' => 'rttheme_sanitize_integer',
            )
        );
        $wp_customize->add_control( 'banner_padding_top',
            array(
                'label' => esc_html__( 'Banner Padding Top', 'cirkle' ),
                'section' => 'header_section',
                'type' => 'number',
                'active_callback' => 'rttheme_is_header_banner_enabled',
            )
        );
        // Banner Padding Bottom
        $wp_customize->add_setting( 'banner_padding_bottom',
            array(
                'default' => $this->defaults['banner_padding_bottom'],
                'transport' => 'refresh',
                'sanitize_callback' => 'rttheme_sanitize_integer',
            )
        );
        $wp_customize->add_control( 'banner_padding_bottom',
            array(
                'label' => esc_html__( 'Banner Padding Bottom', 'cirkle' ),
                'section' => 'header_section',
                'type' => 'number',
                'active_callback' => 'rttheme_is_header_banner_enabled',
            )
        );

    }

}

/**
 * Initialise our Customizer settings only when they're required
 */
if ( class_exists( 'WP_Customize_Control' ) ) {
	new RDTheme_Header_Settings();
}
