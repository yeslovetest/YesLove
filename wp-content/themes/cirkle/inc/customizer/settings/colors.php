<?php
/**
 * @author  RadiusTheme
 * @since   1.0
 * @version 1.0
 */
namespace radiustheme\cirkle\Customizer\Settings;

use radiustheme\cirkle\Customizer\RDTheme_Customizer;
use radiustheme\cirkle\Customizer\Controls\Customizer_Switch_Control;
use radiustheme\cirkle\Customizer\Controls\Customizer_Heading_Control2;
use radiustheme\cirkle\Customizer\Controls\Customizer_Separator_Control;
use WP_Customize_Media_Control;
use WP_Customize_Color_Control;

/**
 * Adds the individual sections, settings, and controls to the theme customizer
 */
class RDTheme_Colors_Settings extends RDTheme_Customizer {

	public function __construct() {
	    parent::instance();
        $this->populated_default_data();
        // Add Controls
        add_action( 'customize_register', array( $this, 'register_general_controls' ) );
	}

    public function register_general_controls( $wp_customize ) {
        /**
        * Base Color Controls
        ======================================================================*/
        $wp_customize->add_setting('base_color_heading', array(
            'default' => '',
            'sanitize_callback' => 'esc_html',
        ));
        $wp_customize->add_control(new Customizer_Heading_Control2($wp_customize, 'base_color_heading', array(
            'label' => esc_html__( 'Base Color', 'cirkle' ),
            'section' => 'site_color_section',
        )));
        // Primary Color
        $wp_customize->add_setting( 'primary_color',
            array(
                'default' => $this->defaults['primary_color'],
                'transport' => 'refresh',
                'sanitize_callback' => 'rttheme_text_sanitization',
            )
        );
        $wp_customize->add_control( 'primary_color',
            array(
                'label' => esc_html__( 'Primary Color', 'cirkle' ),
                'section' => 'site_color_section',
                'type' => 'color',
                'default' => '#2d5be3',
            )
        );
        // Secondary Color
        $wp_customize->add_setting( 'secondary_color',
            array(
                'default' => $this->defaults['secondary_color'],
                'transport' => 'refresh',
                'sanitize_callback' => 'rttheme_text_sanitization',
            )
        );
        $wp_customize->add_control( 'secondary_color',
            array(
                'label' => esc_html__( 'Secondary Color', 'cirkle' ),
                'section' => 'site_color_section',
                'type' => 'color',
                'default' => '#5edfff',
            )
        );
        /**
        * Menu Color Controls
        ======================================================================*/
        $wp_customize->add_setting('menu_color_heading', array(
            'default' => '',
            'sanitize_callback' => 'esc_html',
        ));
        $wp_customize->add_control(new Customizer_Heading_Control2($wp_customize, 'menu_color_heading', array(
            'label' => esc_html__( 'Menu Color Settings', 'cirkle' ),
            'section' => 'site_color_section',
        )));
        // Menu Text Color
        $wp_customize->add_setting( 'menu_text_color',
            array(
                'default' => $this->defaults['menu_text_color'],
                'transport' => 'refresh',
                'sanitize_callback' => 'rttheme_text_sanitization',
            )
        );
        $wp_customize->add_control( 'menu_text_color',
            array(
                'label' => esc_html__( 'Text Color', 'cirkle' ),
                'section' => 'site_color_section',
                'type' => 'color',
                'default' => '#cac8c8',
            )
        );
        // Menu Text Hover Color
        $wp_customize->add_setting( 'menu_text_hover_color',
            array(
                'default' => $this->defaults['menu_text_hover_color'],
                'transport' => 'refresh',
                'sanitize_callback' => 'rttheme_text_sanitization',
            )
        );
        $wp_customize->add_control( 'menu_text_hover_color',
            array(
                'label' => esc_html__( 'Hover Text Color', 'cirkle' ),
                'section' => 'site_color_section',
                'type' => 'color',
                'default' => '#fff',
            )
        );

        /**
        * Dropdown Menu Color Controls
        ======================================================================*/
        $wp_customize->add_setting('dropdown_menu_color_heading', array(
            'default' => '',
            'sanitize_callback' => 'esc_html',
        ));
        $wp_customize->add_control(new Customizer_Heading_Control2($wp_customize, 'dropdown_menu_color_heading', array(
            'label' => esc_html__( 'Sub Menu Color Settings', 'cirkle' ),
            'section' => 'site_color_section',
        )));

        // Submenu BG Color
        $wp_customize->add_setting( 'submenu_bg_color',
            array(
                'default' => $this->defaults['submenu_bg_color'],
                'transport' => 'refresh',
                'sanitize_callback' => 'rttheme_text_sanitization',
            )
        );
        $wp_customize->add_control( 'submenu_bg_color',
            array(
                'label' => esc_html__( 'Background Color', 'cirkle' ),
                'section' => 'site_color_section',
                'type' => 'color',
                'default' => '#000',
            )
        );

        // Submenu Text Color
        $wp_customize->add_setting( 'submenu_text_color',
            array(
                'default' => $this->defaults['submenu_text_color'],
                'transport' => 'refresh',
                'sanitize_callback' => 'rttheme_text_sanitization',
            )
        );
        $wp_customize->add_control( 'submenu_text_color',
            array(
                'label' => esc_html__( 'Text Color', 'cirkle' ),
                'section' => 'site_color_section',
                'type' => 'color',
                'default' => '#fff',
            )
        );

        // Submenu Hover Text Color
        $wp_customize->add_setting( 'submenu_htext_color',
            array(
                'default' => $this->defaults['submenu_htext_color'],
                'transport' => 'refresh',
                'sanitize_callback' => 'rttheme_text_sanitization',
            )
        );
        $wp_customize->add_control( 'submenu_htext_color',
            array(
                'label' => esc_html__( 'Hover Text Color', 'cirkle' ),
                'section' => 'site_color_section',
                'type' => 'color',
                'default' => '#000',
            )
        );


        /**
        * Newsfeed Banner BG Color Settings
        ======================================================================*/
        $wp_customize->add_setting('newsfeed_banner_color_heading', array(
            'default' => '',
            'sanitize_callback' => 'esc_html',
        ));
        $wp_customize->add_control(new Customizer_Heading_Control2($wp_customize, 'newsfeed_banner_color_heading', array(
            'label' => esc_html__( 'Banner Color Settings', 'cirkle' ),
            'section' => 'site_color_section',
            'description' => esc_html__( 'Newsfeed, Group, All Member, Forums banner color settings options', 'cirkle' ),
        )));

        // Newsfeed BG Color
        $wp_customize->add_setting( 'nf_bg_color1',
            array(
                'default' => $this->defaults['nf_bg_color1'],
                'transport' => 'refresh',
                'sanitize_callback' => 'rttheme_text_sanitization',
            )
        );
        $wp_customize->add_control( 'nf_bg_color1',
            array(
                'label' => esc_html__( 'Background Color 1', 'cirkle' ),
                'section' => 'site_color_section',
                'type' => 'color',
                'description' => esc_html__( 'Newsfeed, Group, All Member, Forums banner color settings options', 'cirkle' ),
            )
        );
        $wp_customize->add_setting( 'nf_bg_color2',
            array(
                'default' => $this->defaults['nf_bg_color2'],
                'transport' => 'refresh',
                'sanitize_callback' => 'rttheme_text_sanitization',
            )
        );
        $wp_customize->add_control( 'nf_bg_color2',
            array(
                'label' => esc_html__( 'Background Color 1', 'cirkle' ),
                'section' => 'site_color_section',
                'type' => 'color',
                'description' => esc_html__( 'Newsfeed, Group, All Member, Forums banner color settings options', 'cirkle' ),
            )
        );


        /**
         * Heading
         */
        $wp_customize->add_setting('color_header_switching', array(
            'default' => '',
            'sanitize_callback' => 'esc_html',
        ));
        $wp_customize->add_control(new Customizer_Heading_Control2($wp_customize, 'color_header_switching', array(
            'label' => esc_html__( 'Color Mode', 'cirkle' ),
            'section' => 'site_color_section',
        )));
        // Add our Checkbox switch setting and control for opening URLs in a new tab
        $wp_customize->add_setting( 'color_mode',
            array(
                'default' => $this->defaults['color_mode'],
                'transport' => 'refresh',
                'sanitize_callback' => 'rttheme_switch_sanitization',
            )
        );
        $wp_customize->add_control( new Customizer_Switch_Control( $wp_customize, 'color_mode',
            array(
                'label' => esc_html__( 'Color Mode Switch', 'cirkle' ),
                'section' => 'site_color_section',
            )
        ) );

        // Color type mode
        $wp_customize->add_setting( 'code_mode_type',
            array(
                'default' => $this->defaults['code_mode_type'],
                'transport' => 'refresh',
                'sanitize_callback' => 'rttheme_radio_sanitization'
            )
        );
        $wp_customize->add_control( 'code_mode_type',
            array(
                'label' => esc_html__( 'Choose Color Mode', 'cirkle' ),
                'section' => 'site_color_section',
                'description' => esc_html__( 'This is work if you disable "Color Mode Switch"', 'cirkle' ),
                'type' => 'radio',
                'choices' => array(
                    'light-mode' => esc_html__( 'Light Mode', 'cirkle' ),
                    'dark-mode' => esc_html__( 'Dark Mode', 'cirkle' ),
                ),
            )
        );

    }

}

/**
 * Initialise our Customizer settings only when they're required  
 */
if ( class_exists( 'WP_Customize_Control' ) ) {
	new RDTheme_Colors_Settings();
}
