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
use radiustheme\cirkle\Customizer\Controls\Customizer_Image_Radio_Control;
use WP_Customize_Media_Control;
use WP_Customize_Color_Control;

/**
 * Adds the individual sections, settings, and controls to the theme customizer
 */
class RDTheme_Footer_Settings extends RDTheme_Customizer {

	public function __construct() {
	    parent::instance();
        $this->populated_default_data();
        // Add Controls
        add_action( 'customize_register', array( $this, 'register_footer_controls' ) );
	}

    public function register_footer_controls( $wp_customize ) {
        /**
        * Copyright Text
        ========================================================================================*/
        $wp_customize->add_setting( 'copyright_text',
            array(
                'default' => $this->defaults['copyright_text'],
                'transport' => 'refresh',
                'sanitize_callback' => 'sanitize_textarea_field'
            )
        );
        $wp_customize->add_control( 'copyright_text',
            array(
                'label' => esc_html__( 'Copyright Text', 'cirkle' ),
                'section' => 'footer_section',
                'type' => 'textarea',
            )
        );

        /**
        * Footer Style
        ========================================================================================*/
        $wp_customize->add_setting( 'footer_style',
            array(
                'default' => $this->defaults['footer_style'],
                'transport' => 'refresh',
                'sanitize_callback' => 'rttheme_radio_sanitization'
            )
        );

        $wp_customize->add_control( new Customizer_Image_Radio_Control( $wp_customize, 'footer_style',
            array(
                'label' => esc_html__( 'Footer Layout', 'cirkle' ),
                'description' => esc_html__( 'You can set default footer form here.', 'cirkle' ),
                'section' => 'footer_section',
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


        /**
        * Footer 1 Background
        ========================================================================================*/
        $wp_customize->add_setting('footer1_heading', array(
            'default' => '',
            'sanitize_callback' => 'esc_html',
        ));
        $wp_customize->add_control(new Customizer_Heading_Control($wp_customize, 'footer1_heading', array(
            'label' => esc_html__( 'Footer 1 Background', 'cirkle' ),
            'section' => 'footer_section',
        )));

        // Banner background image
        $wp_customize->add_setting( 'footer1_bg_img',
            array(
                'default' => $this->defaults['footer1_bg_img'],
                'transport' => 'refresh',
                'sanitize_callback' => 'absint',
            )
        );
        $wp_customize->add_control( new WP_Customize_Media_Control( $wp_customize, 'footer1_bg_img',
            array(
                'label' => esc_html__( 'Footer Background Image', 'cirkle' ),
                'description' => esc_html__( 'This is the description for the Media Control', 'cirkle' ),
                'section' => 'footer_section',
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
            )
        ) );
        // Banner background color
        $wp_customize->add_setting('footer1_bg_color', 
            array(
                'default' => '#000000',
                'type' => 'theme_mod', 
                'capability' => 'edit_theme_options', 
                'transport' => 'refresh', 
                'sanitize_callback' => 'sanitize_hex_color',
            )
        );
        $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'footer1_bg_color',
            array(
                'label' => esc_html__('Banner Background Color', 'cirkle'),
                'settings' => 'footer1_bg_color', 
                'priority' => 10, 
                'section' => 'footer_section', 
            )
        ));
        // Banner background color opacity
        $wp_customize->add_setting( 'footer1_bg_opacity',
            array(
                'default' => $this->defaults['footer1_bg_opacity'],
                'transport' => 'refresh',
                'sanitize_callback' => 'rttheme_sanitize_integer',
            )
        );
        $wp_customize->add_control( 'footer1_bg_opacity',
            array(
                'label' => esc_html__( 'Background Opacity', 'cirkle' ),
                'section' => 'footer_section',
                'type' => 'number',
            )
        );

        /**
         * Footer Shape round image list
         */
        $wp_customize->add_setting('f_img_heading', array(
            'default' => '',
            'sanitize_callback' => 'esc_html',
        ));
        $wp_customize->add_control(new Customizer_Heading_Control($wp_customize, 'f_img_heading', array(
            'label' => esc_html__( 'Footer Top Image List', 'cirkle' ),
            'section' => 'footer_section',
        )));

        //  Gallery
        $wp_customize->add_setting( 'f1_top_img',
            array(
                'default' => $this->defaults['f1_top_img'],
                'transport' => 'refresh',
                'sanitize_callback' => '',
            )
        );
        $wp_customize->add_control( new Customizer_Gallery_Control( $wp_customize, 'f1_top_img',
            array(
                'label' => esc_html__( 'Footer Top Images', 'cirkle' ),
                'description' => esc_html__( 'This is for brand logo images', 'cirkle' ),
                'section' => 'footer_section',
                'button_labels' => array(
                    'add' => esc_html__( 'Add Image', 'cirkle' ),
                ),
            )
        ) );


        /**
        * Footer 2 Background
        ========================================================================================*/
        $wp_customize->add_setting('footer2_heading', array(
            'default' => '',
            'sanitize_callback' => 'esc_html',
        ));
        $wp_customize->add_control(new Customizer_Heading_Control($wp_customize, 'footer2_heading', array(
            'label' => esc_html__( 'Footer 2 Background', 'cirkle' ),
            'section' => 'footer_section',
        )));

        // Banner background image
        $wp_customize->add_setting( 'footer2_bg_img',
            array(
                'default' => $this->defaults['footer2_bg_img'],
                'transport' => 'refresh',
                'sanitize_callback' => 'absint',
            )
        );
        $wp_customize->add_control( new WP_Customize_Media_Control( $wp_customize, 'footer2_bg_img',
            array(
                'label' => esc_html__( 'Footer Background Image', 'cirkle' ),
                'description' => esc_html__( 'This is the description for the Media Control', 'cirkle' ),
                'section' => 'footer_section',
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
            )
        ) );
        // Banner background color
        $wp_customize->add_setting('footer2_bg_color', 
            array(
                'default' => '#000000',
                'type' => 'theme_mod', 
                'capability' => 'edit_theme_options', 
                'transport' => 'refresh', 
                'sanitize_callback' => 'sanitize_hex_color',
            )
        );
        $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'footer2_bg_color',
            array(
                'label' => esc_html__('Banner Background Color', 'cirkle'),
                'settings' => 'footer2_bg_color', 
                'priority' => 10, 
                'section' => 'footer_section',
            )
        ));
        // Banner background color opacity
        $wp_customize->add_setting( 'footer2_bg_opacity',
            array(
                'default' => $this->defaults['footer2_bg_opacity'],
                'transport' => 'refresh',
                'sanitize_callback' => 'rttheme_sanitize_integer',
            )
        );
        $wp_customize->add_control( 'footer2_bg_opacity',
            array(
                'label' => esc_html__( 'Background Opacity', 'cirkle' ),
                'section' => 'footer_section',
                'type' => 'number',
            )
        );


        /**
        * Footer Columns
        ========================================================================================*/
        $wp_customize->add_setting('footer_columns_heading', array(
            'default' => '',
            'sanitize_callback' => 'esc_html',
        ));
        $wp_customize->add_control(new Customizer_Heading_Control($wp_customize, 'footer_columns_heading', array(
            'label' => esc_html__( 'Footer Columns', 'cirkle' ),
            'section' => 'footer_section',
        )));

        $wp_customize->add_setting( 'footer_widgets_column',
            array(
                'default' => $this->defaults['footer_widgets_column'],
                'transport' => 'refresh',
                'sanitize_callback' => 'rttheme_radio_sanitization',
            )
        );
        $wp_customize->add_control( 'footer_widgets_column',
            array(
                'label' => esc_html__( 'Footer Columns', 'cirkle' ),
                'section' => 'footer_section',
                'type' => 'select',
                'choices' => array(
                    '12' => esc_html__( '1 Column', 'cirkle' ),
                    '6' => esc_html__( '2 Columns', 'cirkle' ),
                    '4' => esc_html__( '3 Columns', 'cirkle' ),
                    '3' => esc_html__( '4 Columns', 'cirkle' ),
                    '2' => esc_html__( '6 Columns', 'cirkle' ),
                ),
            )
        );

    }

}

/**
 * Initialise our Customizer settings only when they're required
 */
if ( class_exists( 'WP_Customize_Control' ) ) {
	new RDTheme_Footer_Settings();
}
