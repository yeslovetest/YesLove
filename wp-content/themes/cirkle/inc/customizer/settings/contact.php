<?php
/**
 * @author  RadiusTheme
 * @since   1.0
 * @version 1.0
 */
namespace radiustheme\cirkle\Customizer\Settings;

use radiustheme\cirkle\Customizer\RDTheme_Customizer;
use radiustheme\cirkle\Customizer\Controls\Customizer_Switch_Control;
use radiustheme\cirkle\Customizer\Controls\Customizer_Gallery_Control;
use radiustheme\cirkle\Customizer\Controls\Customizer_Heading_Control;
use radiustheme\cirkle\Customizer\Controls\Customizer_Separator_Control;
use WP_Customize_Media_Control;

/**
 * Adds the individual sections, settings, and controls to the theme customizer
 */
class RDTheme_Contact_Settings extends RDTheme_Customizer {

	public function __construct() {
	    parent::instance();
        $this->populated_default_data();
        // Add Controls
        add_action( 'customize_register', array( $this, 'register_general_controls' ) );
	}

    public function register_general_controls( $wp_customize ) {
        
        /**
         * Heading
         */
        $wp_customize->add_setting('contact_heading', array(
            'default' => '',
            'sanitize_callback' => 'esc_html',
        ));
        $wp_customize->add_control(new Customizer_Heading_Control($wp_customize, 'contact_heading', array(
            'label' => __( 'Socials', 'cirkle' ),
            'section' => 'contact_section',
        )));

        // Address
        $wp_customize->add_setting( 'social_facebook',
            array(
                'default' => $this->defaults['social_facebook'],
                'transport' => 'refresh',
                'sanitize_callback' => 'rttheme_text_sanitization',
            )
        );
        $wp_customize->add_control( 'social_facebook',
            array(
                'label' => esc_html__( 'Facebook', 'cirkle' ),
                'section' => 'contact_section',
                'type' => 'text',
            )
        );
        $wp_customize->add_setting( 'social_twitter',
            array(
                'default' => $this->defaults['social_twitter'],
                'transport' => 'refresh',
                'sanitize_callback' => 'rttheme_text_sanitization',
            )
        );
        $wp_customize->add_control( 'social_twitter',
            array(
                'label' => esc_html__( 'Twitter', 'cirkle' ),
                'section' => 'contact_section',
                'type' => 'text',
            )
        );
        // Phone
        $wp_customize->add_setting( 'social_linkedin',
            array(
                'default' => $this->defaults['social_linkedin'],
                'transport' => 'refresh',
                'sanitize_callback' => 'rttheme_text_sanitization',
            )
        );
        $wp_customize->add_control( 'social_linkedin',
            array(
                'label' => esc_html__( 'Linkdin', 'cirkle' ),
                'section' => 'contact_section',
                'type' => 'text',
            )
        );
        $wp_customize->add_setting( 'social_youtube',
            array(
                'default' => $this->defaults['social_youtube'],
                'transport' => 'refresh',
                'sanitize_callback' => 'rttheme_text_sanitization',
            )
        );
        $wp_customize->add_control( 'social_youtube',
            array(
                'label' => esc_html__( 'You Tube', 'cirkle' ),
                'section' => 'contact_section',
                'type' => 'text',
            )
        );
        $wp_customize->add_setting( 'social_pinterest',
            array(
                'default' => $this->defaults['social_pinterest'],
                'transport' => 'refresh',
                'sanitize_callback' => 'rttheme_text_sanitization',
            )
        );
        $wp_customize->add_control( 'social_pinterest',
            array(
                'label' => esc_html__( 'Pinterest', 'cirkle' ),
                'section' => 'contact_section',
                'type' => 'text',
            )
        );
        $wp_customize->add_setting( 'social_instagram',
            array(
                'default' => $this->defaults['social_instagram'],
                'transport' => 'refresh',
                'sanitize_callback' => 'rttheme_text_sanitization',
            )
        );
        $wp_customize->add_control( 'social_instagram',
            array(
                'label' => esc_html__( 'Instagram', 'cirkle' ),
                'section' => 'contact_section',
                'type' => 'text',
            )
        );

        /**
         * Heading
         */
        $wp_customize->add_setting('social_login_heading', array(
            'default' => '',
            'sanitize_callback' => 'esc_html',
        ));
        $wp_customize->add_control(new Customizer_Heading_Control($wp_customize, 'social_login_heading', array(
            'label' => __( 'Socials Login', 'cirkle' ),
            'section' => 'contact_section',
        )));
        $wp_customize->add_setting( 'social_login_shortcode',
            array(
                'default' => $this->defaults['social_login_shortcode'],
                'transport' => 'refresh',
                'sanitize_callback' => 'rttheme_text_sanitization',
            )
        );
        $wp_customize->add_control( 'social_login_shortcode',
            array(
                'label' => esc_html__( 'Social Login form shortcode', 'cirkle' ),
                'section' => 'contact_section',
                'type' => 'text',
            )
        );

    }

}

/**
 * Initialise our Customizer settings only when they're required  
 */
if ( class_exists( 'WP_Customize_Control' ) ) {
	new RDTheme_Contact_Settings();
}
