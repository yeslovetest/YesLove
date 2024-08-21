<?php
/**
 * @author  RadiusTheme
 * @since   1.0
 * @version 1.0
 */
namespace radiustheme\cirkle\Customizer\Settings;

use radiustheme\cirkle\Customizer\RDTheme_Customizer;
use WP_Customize_Media_Control;
/**
 * Adds the individual sections, settings, and controls to the theme customizer
 */
class RDTheme_Error_Settings extends RDTheme_Customizer {

	public function __construct() {
	    parent::instance();
        $this->populated_default_data();
        // Add Controls
        add_action( 'customize_register', array( $this, 'register_error_controls' ) );
	}

    public function register_error_controls( $wp_customize ) {

        // Title
        $wp_customize->add_setting( 'error_page_banner',
            array(
                'default' => $this->defaults['error_page_banner'],
                'transport' => 'refresh',
                'sanitize_callback' => 'rttheme_text_sanitization'
            )
        );
        $wp_customize->add_control( 'error_page_banner',
            array(
                'label' => esc_html__( '404 Error Page', 'cirkle' ),
                'section' => 'error_section',
                'type' => 'text',
            )
        );
        // Title
        $wp_customize->add_setting( 'error_page_title',
            array(
                'default' => $this->defaults['error_page_title'],
                'transport' => 'refresh',
                'sanitize_callback' => 'rttheme_text_sanitization'
            )
        );
        $wp_customize->add_control( 'error_page_title',
            array(
                'label' => esc_html__( '404 Title', 'cirkle' ),
                'section' => 'error_section',
                'type' => 'text',
            )
        );
        // Sub Title
        $wp_customize->add_setting( 'error_page_subtitle',
            array(
                'default' => $this->defaults['error_page_subtitle'],
                'transport' => 'refresh',
                'sanitize_callback' => 'rttheme_text_sanitization'
            )
        );
        $wp_customize->add_control( 'error_page_subtitle',
            array(
                'label' => esc_html__( '404 Sub Title', 'cirkle' ),
                'section' => 'error_section',
                'type' => 'text',
            )
        );
        // Description Text
        $wp_customize->add_setting( 'error_desc_text',
            array(
                'default' => $this->defaults['error_desc_text'],
                'transport' => 'refresh',
                'sanitize_callback' => 'rttheme_text_sanitization'
            )
        );
        $wp_customize->add_control( 'error_desc_text',
            array(
                'label' => esc_html__( 'Description Text', 'cirkle' ),
                'section' => 'error_section',
                'type' => 'textarea',
            )
        );
        // Button Text
        $wp_customize->add_setting( 'error_buttontext',
            array(
                'default' => $this->defaults['error_buttontext'],
                'transport' => 'refresh',
                'sanitize_callback' => 'rttheme_text_sanitization'
            )
        );
        $wp_customize->add_control( 'error_buttontext',
            array(
                'label' => esc_html__( 'Button Text', 'cirkle' ),
                'section' => 'error_section',
                'type' => 'text',
            )
        );
    }

}

/**
 * Initialise our Customizer settings only when they're required
 */
if ( class_exists( 'WP_Customize_Control' ) ) {
	new RDTheme_Error_Settings();
}
