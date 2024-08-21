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
class RDTheme_Bp_Newsfeed_Settings extends RDTheme_Customizer {

	public function __construct() {
	    parent::instance();
        $this->populated_default_data();
        // Add Controls
        add_action( 'customize_register', array( $this, 'register_bpmember_controls' ) );
	}

    public function register_bpmember_controls( $wp_customize ) {
        /**
         * Heading
         */
        $wp_customize->add_setting('bp_newsfeed_banner_img', array(
            'default' => '',
            'sanitize_callback' => 'esc_html',
        ));
        $wp_customize->add_control(new Customizer_Heading_Control($wp_customize, 'bp_newsfeed_banner_img', array(
            'label' => esc_html__( 'Banner Images', 'cirkle' ),
            'section' => 'bp_newsfeed_section',
        )));

        $wp_customize->add_setting( 'cirkle_nb_img',
            array(
                'default' => $this->defaults['cirkle_nb_img'],
                'transport' => 'refresh',
                'sanitize_callback' => 'absint',
            )
        );
        $wp_customize->add_control( new WP_Customize_Media_Control( $wp_customize, 'cirkle_nb_img',
            array(
                'label' => esc_html__( 'Banner Image', 'cirkle' ),
                'description' => esc_html__( 'This is the member banner image', 'cirkle' ),
                'section' => 'bp_newsfeed_section',
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

        $wp_customize->add_setting( 'cirkle_nb_shape_img',
            array(
                'default' => $this->defaults['cirkle_nb_shape_img'],
                'transport' => 'refresh',
                'sanitize_callback' => 'absint',
            )
        );
        $wp_customize->add_control( new WP_Customize_Media_Control( $wp_customize, 'cirkle_nb_shape_img',
            array(
                'label' => esc_html__( 'Banner Shape Image', 'cirkle' ),
                'description' => esc_html__( 'This is the member banner bg shape image', 'cirkle' ),
                'section' => 'bp_newsfeed_section',
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
        // News Banner Title
        $wp_customize->add_setting( 'newsfeed_banner_title',
            array(
                'default' => $this->defaults['newsfeed_banner_title'],
                'transport' => 'refresh',
                'sanitize_callback' => 'rttheme_text_sanitization'
            )
        );
        $wp_customize->add_control( 'newsfeed_banner_title',
            array(
                'label' => esc_html__( 'Banner Title', 'cirkle' ),
                'section' => 'bp_newsfeed_section',
                'type' => 'text',
            )
        );
        // Banner Description
        $wp_customize->add_setting( 'newsfeed_banner_desc',
            array(
                'default' => $this->defaults['newsfeed_banner_desc'],
                'transport' => 'refresh',
                'sanitize_callback' => 'rttheme_text_sanitization'
            )
        );
        $wp_customize->add_control( 'newsfeed_banner_desc',
            array(
                'label' => esc_html__( 'Banner Description', 'cirkle' ),
                'section' => 'bp_newsfeed_section',
                'type' => 'text',
            )
        );
    }

}

/**
 * Initialise our Customizer settings only when they're required  
 */
if ( class_exists( 'WP_Customize_Control' ) ) {
	new RDTheme_Bp_Newsfeed_Settings();
}
