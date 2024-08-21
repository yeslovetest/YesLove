<?php
/**
 * @author  RadiusTheme
 * @since   1.0
 * @version 1.0
 */
namespace radiustheme\cirkle\Customizer\Settings;

use radiustheme\cirkle\Customizer\RDTheme_Customizer;
use radiustheme\cirkle\Customizer\Controls\Customizer_Heading_Control;
use radiustheme\cirkle\Customizer\Controls\Customizer_Switch_Control;
use radiustheme\cirkle\Customizer\Controls\Customizer_Separator_Control;
use radiustheme\cirkle\Customizer\Controls\Customizer_Sortable_Repeater_Control;
use WP_Customize_Media_Control;
use WP_Customize_Color_Control;

/**
 * Adds the individual sections, settings, and controls to the theme customizer
 */
class RDTheme_General_Settings extends RDTheme_Customizer {

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
        $wp_customize->add_setting('site_logo', array(
            'default' => '',
            'sanitize_callback' => 'esc_html',
        ));
        $wp_customize->add_control(new Customizer_Heading_Control($wp_customize, 'site_logo', array(
            'label' => esc_html__( 'Site Logo', 'cirkle' ),
            'section' => 'general_section',
        )));

        $wp_customize->add_setting( 'logo',
            array(
                'default' => $this->defaults['logo'],
                'transport' => 'refresh',
                'sanitize_callback' => 'absint',
            )
        );
        $wp_customize->add_control( new WP_Customize_Media_Control( $wp_customize, 'logo',
            array(
                'label' => esc_html__( 'Main Logo', 'cirkle' ),
                'description' => esc_html__( 'This is the description for the Media Control', 'cirkle' ),
                'section' => 'general_section',
                'mime_type' => 'image',
                'button_labels' => array(
                    'select' => esc_html__( 'Select File', 'cirkle' ),
                    'change' => esc_html__( 'Change File', 'cirkle' ),
                    'default' => esc_html__( 'Default', 'cirkle' ),
                    'remove' => esc_html__( 'Remove', 'cirkle' ),
                    'placeholder' => esc_html__( 'No file selected', 'cirkle' ),
                    'frame_title' => esc_html__( 'Select File', 'cirkle' ),
                    'frame_button' => esc_html__( 'Choose File', 'cirkle' ),
                )
            )
        ) );

        $wp_customize->add_setting( 'logo_mobile',
            array(
                'default' => $this->defaults['logo_mobile'],
                'transport' => 'refresh',
                'sanitize_callback' => 'absint',
            )
        );
        $wp_customize->add_control( new WP_Customize_Media_Control( $wp_customize, 'logo_mobile',
            array(
                'label' => esc_html__( 'Logo Mobile', 'cirkle' ),
                'description' => esc_html__( 'This is the description for the Media Control', 'cirkle' ),
                'section' => 'general_section',
                'mime_type' => 'image',
                'button_labels' => array(
                    'select' => esc_html__( 'Select File', 'cirkle' ),
                    'change' => esc_html__( 'Change File', 'cirkle' ),
                    'default' => esc_html__( 'Default', 'cirkle' ),
                    'remove' => esc_html__( 'Remove', 'cirkle' ),
                    'placeholder' => esc_html__( 'No file selected', 'cirkle' ),
                    'frame_title' => esc_html__( 'Select File', 'cirkle' ),
                    'frame_button' => esc_html__( 'Choose File', 'cirkle' ),
                )
            )
        ) );

        // Logo Area Width
        $wp_customize->add_setting( 'logo_width',
            array(
                'default' => $this->defaults['logo_width'],
                'transport' => 'refresh',
                'sanitize_callback' => 'rttheme_radio_sanitization'
            )
        );
        $wp_customize->add_control( 'logo_width',
            array(
                'label' => esc_html__( 'Logo Area Width', 'cirkle' ),
                'section' => 'general_section',
                'description' => esc_html__( 'Width is defined by the number of bootstrap columns. Please note, navigation menu width will be decreased with the increase of logo width', 'cirkle' ),
                'type' => 'select',
                'choices' => array(
                    '1' => esc_html__( '1 Column', 'cirkle' ),
                    '2' => esc_html__( '2 Columns', 'cirkle' ),
                    '3' => esc_html__( '3 Columns', 'cirkle' ),
                    '4' => esc_html__( '4 Columns', 'cirkle' ),
                    '5' => esc_html__( '5 Columns', 'cirkle' ),
                    '6' => esc_html__( '6 Columns', 'cirkle' ),
                )
            )
        );

        /**
         * Heading
         */
        $wp_customize->add_setting('site_switching', array(
            'default' => '',
            'sanitize_callback' => 'esc_html',
        ));
        $wp_customize->add_control(new Customizer_Heading_Control($wp_customize, 'site_switching', array(
            'label' => esc_html__( 'Site Switch Control', 'cirkle' ),
            'section' => 'general_section',
        )));

        // Switch for back to top button
        $wp_customize->add_setting( 'page_scrolltop',
            array(
                'default' => $this->defaults['page_scrolltop'],
                'transport' => 'refresh',
                'sanitize_callback' => 'rttheme_switch_sanitization',
            )
        );
        $wp_customize->add_control( new Customizer_Switch_Control( $wp_customize, 'page_scrolltop',
            array(
                'label' => esc_html__( 'Back to Top', 'cirkle' ),
                'section' => 'general_section',
            )
        ) );

        // Switch for sticky
        $wp_customize->add_setting( 'sticky_header',
            array(
                'default' => $this->defaults['sticky_header'],
                'transport' => 'refresh',
                'sanitize_callback' => 'rttheme_switch_sanitization',
            )
        );
        $wp_customize->add_control( new Customizer_Switch_Control( $wp_customize, 'sticky_header',
            array(
                'label' => esc_html__( 'Sticky Header', 'cirkle' ),
                'section' => 'general_section',
            )
        ) );

        // Switch for fixed header
        $wp_customize->add_setting( 'fixed_header',
            array(
                'default' => $this->defaults['fixed_header'],
                'transport' => 'refresh',
                'sanitize_callback' => 'rttheme_switch_sanitization',
            )
        );
        $wp_customize->add_control( new Customizer_Switch_Control( $wp_customize, 'fixed_header',
            array(
                'label' => esc_html__( 'Fixed Header (Profile)', 'cirkle' ),
                'section' => 'general_section',
            )
        ) );

        $wp_customize->add_setting( 'preloader',
            array(
                'default' => $this->defaults['preloader'],
                'transport' => 'refresh',
                'sanitize_callback' => 'rttheme_switch_sanitization',
            )
        );
        $wp_customize->add_control( new Customizer_Switch_Control( $wp_customize, 'preloader',
            array(
                'label' => esc_html__( 'Preloader', 'cirkle' ),
                'section' => 'general_section',
            )
        ) );
        $wp_customize->add_setting( 'preloader_image',
            array(
                'default' => $this->defaults['preloader_image'],
                'transport' => 'refresh',
                'sanitize_callback' => 'absint',
            )
        );
        $wp_customize->add_control( new WP_Customize_Media_Control( $wp_customize, 'preloader_image',
            array(
                'label' => esc_html__( 'Preloader Image', 'cirkle' ),
                'description' => esc_html__( 'Preloader image should be animated/gif image', 'cirkle' ),
                'section' => 'general_section',
                'mime_type' => 'image',
                'button_labels' => array(
                    'select' => esc_html__( 'Select File', 'cirkle' ),
                    'change' => esc_html__( 'Change File', 'cirkle' ),
                    'default' => esc_html__( 'Default', 'cirkle' ),
                    'remove' => esc_html__( 'Remove', 'cirkle' ),
                    'placeholder' => esc_html__( 'No file selected', 'cirkle' ),
                    'frame_title' => esc_html__( 'Select File', 'cirkle' ),
                    'frame_button' => esc_html__( 'Choose File', 'cirkle' ),
                )
            )
        ) );

    }

}

/**
 * Initialise our Customizer settings only when they're required  
 */
if ( class_exists( 'WP_Customize_Control' ) ) {
	new RDTheme_General_Settings();
}
