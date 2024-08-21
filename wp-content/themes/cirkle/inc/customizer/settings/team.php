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
class RDTheme_Team_Post_Settings extends RDTheme_Customizer {

	public function __construct() {
	    parent::instance();
        $this->populated_default_data();
        // Add Controls
        add_action( 'customize_register', array( $this, 'register_team_post_controls' ) );
	}

    /**
     * Gallery Post Controls
     */
    public function register_team_post_controls( $wp_customize ) {

        /**
        * Team Single Page
        ========================================================================================*/
        /**
         * Heading for team single
         */
        $wp_customize->add_setting('single_team_heading', array(
            'default' => '',
            'sanitize_callback' => 'esc_html',
        ));
        $wp_customize->add_control(new Customizer_Heading_Control($wp_customize, 'single_team_heading', array(
            'label' => esc_html__( 'Single Team', 'cirkle' ),
            'section' => 'team_section',
        )));

        // Team details page title
        $wp_customize->add_setting( 'team_details_page_title',
            array(
                'default' => $this->defaults['team_details_page_title'],
                'transport' => 'refresh',
                'sanitize_callback' => 'rttheme_text_sanitization'
            )
        );
        $wp_customize->add_control( 'team_details_page_title',
            array(
                'label' => esc_html__( 'Page Title', 'cirkle' ),
                'section' => 'team_section',
                'type' => 'text'
            )
        );

        // Team details page sub title
        $wp_customize->add_setting( 'team_details_page_subtitle',
            array(
                'default' => $this->defaults['team_details_page_subtitle'],
                'transport' => 'refresh',
                'sanitize_callback' => 'rttheme_text_sanitization'
            )
        );
        $wp_customize->add_control( 'team_details_page_subtitle',
            array(
                'label' => esc_html__( 'Page Sub Title', 'cirkle' ),
                'section' => 'team_section',
                'type' => 'textarea'
            )
        );

        $wp_customize->add_setting( 'team_details_banner_img',
            array(
                'default' => $this->defaults['team_details_banner_img'],
                'transport' => 'refresh',
                'sanitize_callback' => 'absint',
            )
        );
        $wp_customize->add_control( new WP_Customize_Media_Control( $wp_customize, 'team_details_banner_img',
            array(
                'label' => esc_html__( 'Page Banner Image', 'cirkle' ),
                'description' => esc_html__( 'This is the description for the Media Control', 'cirkle' ),
                'section' => 'team_section',
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

        // Single Team Slug
        $wp_customize->add_setting( 'single_team_slug',
            array(
                'default' => $this->defaults['single_team_slug'],
                'transport' => 'refresh',
                'sanitize_callback' => 'rttheme_text_sanitization'
            )
        );
        $wp_customize->add_control( 'single_team_slug',
            array(
                'label' => esc_html__( 'Team Slug', 'cirkle' ),
                'section' => 'team_section',
                'type' => 'text'
            )
        );

    }

}

/**
 * Initialise our Customizer settings only when they're required
 */
if ( class_exists( 'WP_Customize_Control' ) ) {
	new RDTheme_Team_Post_Settings();
}
