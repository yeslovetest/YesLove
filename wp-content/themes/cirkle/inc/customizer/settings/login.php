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
use WP_Customize_Media_Control;
/**
 * Adds the individual sections, settings, and controls to the theme customizer
 */
class RDTheme_Login_Settings extends RDTheme_Customizer {

	public function __construct() {
	    parent::instance();
        $this->populated_default_data();
        // Add Controls
        add_action( 'customize_register', array( $this, 'register_login_controls' ) );
	}

    public function register_login_controls( $wp_customize ) {
        // Login/Registration
        $wp_customize->add_setting( 'cirkle_login_page_type',
            array(
                'default' => $this->defaults['cirkle_login_page_type'],
                'transport' => 'refresh',
                'sanitize_callback' => 'rttheme_radio_sanitization'
            )
        );
        $wp_customize->add_control( 'cirkle_login_page_type',
            array(
                'label' => esc_html__( 'Login/Registration page type', 'cirkle' ),
                'section' => 'login_section',
                'description' => esc_html__( 'Select Site Login or Registration form type', 'cirkle' ),
                'type' => 'select',
                'choices' => array(
                    '1' => esc_html__( 'Cirkle Custom Form', 'cirkle' ),
                    '2' => esc_html__( 'BuddyPress Form', 'cirkle' ),
                    '3' => esc_html__( 'WordPress Default Form', 'cirkle' ),
                )
            )
        );


        // Login Page Header
        $wp_customize->add_setting( 'login_page_header',
            array(
                'default' => $this->defaults['login_page_header'],
                'transport' => 'refresh',
                'sanitize_callback' => 'rttheme_switch_sanitization',
            )
        );
        $wp_customize->add_control( new Customizer_Switch_Control( $wp_customize, 'login_page_header',
            array(
                'label' => esc_html__( 'Login Page Header Enable', 'cirkle' ),
                'section' => 'login_section',
            )
        ) );

        // Login Page Footer
        $wp_customize->add_setting( 'login_page_footer',
            array(
                'default' => $this->defaults['login_page_footer'],
                'transport' => 'refresh',
                'sanitize_callback' => 'rttheme_switch_sanitization',
            )
        );
        $wp_customize->add_control( new Customizer_Switch_Control( $wp_customize, 'login_page_footer',
            array(
                'label' => esc_html__( 'Login Page Footer Enable', 'cirkle' ),
                'section' => 'login_section',
            )
        ) );

        /**
         * Login Page Background Image 
         */
        $wp_customize->add_setting('login_page_bgimg', array(
            'default' => '',
            'sanitize_callback' => 'esc_html',
        ));
        $wp_customize->add_control(new Customizer_Heading_Control($wp_customize, 'login_page_bgimg', array(
            'label' => esc_html__( 'Background Image', 'cirkle' ),
            'section' => 'login_section',
        )));

        $wp_customize->add_setting( 'loginbg',
            array(
                'default' => $this->defaults['loginbg'],
                'transport' => 'refresh',
                'sanitize_callback' => 'absint',
            )
        );
        $wp_customize->add_control( new WP_Customize_Media_Control( $wp_customize, 'loginbg',
            array(
                'label' => esc_html__( 'Login Page Background Image', 'cirkle' ),
                'description' => esc_html__( 'This is the description for the Media Control', 'cirkle' ),
                'section' => 'login_section',
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

        // Title
        $wp_customize->add_setting( 'form_title',
            array(
                'default' => $this->defaults['form_title'],
                'transport' => 'refresh',
                'sanitize_callback' => 'rttheme_text_sanitization'
            )
        );
        $wp_customize->add_control( 'form_title',
            array(
                'label' => esc_html__( 'Form Title', 'cirkle' ),
                'section' => 'login_section',
                'type' => 'text',
            )
        );


        /**
         * Login page map image
         */
        $wp_customize->add_setting('login_page_mapimg', array(
            'default' => '',
            'sanitize_callback' => 'esc_html',
        ));
        $wp_customize->add_control(new Customizer_Heading_Control($wp_customize, 'login_page_mapimg', array(
            'label' => esc_html__( 'Map image', 'cirkle' ),
            'section' => 'login_section',
        )));

        $wp_customize->add_setting( 'mapbg',
            array(
                'default' => $this->defaults['mapbg'],
                'transport' => 'refresh',
                'sanitize_callback' => 'absint',
            )
        );
        $wp_customize->add_control( new WP_Customize_Media_Control( $wp_customize, 'mapbg',
            array(
                'label' => esc_html__( 'Map Background Image', 'cirkle' ),
                'description' => esc_html__( 'This is the description for the Media Control', 'cirkle' ),
                'section' => 'login_section',
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

        /**
         * Login Page location image
         */
        $wp_customize->add_setting('login_location_heading', array(
            'default' => '',
            'sanitize_callback' => 'esc_html',
        ));
        $wp_customize->add_control(new Customizer_Heading_Control($wp_customize, 'login_location_heading', array(
            'label' => esc_html__( 'Map location images', 'cirkle' ),
            'section' => 'login_section',
        )));

        $wp_customize->add_setting( 'location_icon1',
            array(
                'default' => $this->defaults['location_icon1'],
                'transport' => 'refresh',
                'sanitize_callback' => 'absint',
            )
        );
        $wp_customize->add_control( new WP_Customize_Media_Control( $wp_customize, 'location_icon1',
            array(
                'label' => esc_html__( 'Location Icon 1', 'cirkle' ),
                'description' => esc_html__( 'This is the description for the Media Control', 'cirkle' ),
                'section' => 'login_section',
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

        $wp_customize->add_setting( 'location_icon2',
            array(
                'default' => $this->defaults['location_icon2'],
                'transport' => 'refresh',
                'sanitize_callback' => 'absint',
            )
        );
        $wp_customize->add_control( new WP_Customize_Media_Control( $wp_customize, 'location_icon2',
            array(
                'label' => esc_html__( 'Location Icon 2', 'cirkle' ),
                'description' => esc_html__( 'This is the description for the Media Control', 'cirkle' ),
                'section' => 'login_section',
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

        $wp_customize->add_setting( 'location_icon3',
            array(
                'default' => $this->defaults['location_icon3'],
                'transport' => 'refresh',
                'sanitize_callback' => 'absint',
            )
        );
        $wp_customize->add_control( new WP_Customize_Media_Control( $wp_customize, 'location_icon3',
            array(
                'label' => esc_html__( 'Location Icon 3', 'cirkle' ),
                'description' => esc_html__( 'This is the description for the Media Control', 'cirkle' ),
                'section' => 'login_section',
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

        $wp_customize->add_setting( 'location_icon4',
            array(
                'default' => $this->defaults['location_icon4'],
                'transport' => 'refresh',
                'sanitize_callback' => 'absint',
            )
        );
        $wp_customize->add_control( new WP_Customize_Media_Control( $wp_customize, 'location_icon4',
            array(
                'label' => esc_html__( 'Location Icon 4', 'cirkle' ),
                'description' => esc_html__( 'This is the description for the Media Control', 'cirkle' ),
                'section' => 'login_section',
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

        /**
         * Heading
         */
        $wp_customize->add_setting('cirkle_recaptcha', array(
            'default' => '',
            'sanitize_callback' => 'esc_html',
        ));
        $wp_customize->add_control(new Customizer_Heading_Control($wp_customize, 'cirkle_recapcha', array(
            'label' => __( 'Registration Form reCaptcha Shortcode', 'cirkle' ),
            'section' => 'login_section',
        )));
        $wp_customize->add_setting( 'registration_captcha_shortcode',
            array(
                'default' => $this->defaults['registration_captcha_shortcode'],
                'transport' => 'refresh',
                'sanitize_callback' => 'rttheme_text_sanitization',
            )
        );
        $wp_customize->add_control( 'registration_captcha_shortcode',
            array(
                'label' => esc_html__( 'reCaptcha shortcode', 'cirkle' ),
                'section' => 'login_section',
                'type' => 'text',
            )
        );


    }

}

/**
 * Initialise our Customizer settings only when they're required
 */
if ( class_exists( 'WP_Customize_Control' ) ) {
	new RDTheme_Login_Settings();
}
