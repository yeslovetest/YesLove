<?php
/**
 * @author  RadiusTheme
 * @since   1.0
 * @version 1.0
 */
namespace radiustheme\cirkle\Customizer\Settings;

use radiustheme\cirkle\Customizer\RDTheme_Customizer;
use radiustheme\cirkle\Customizer\Controls\Customizer_Switch_Control;
use radiustheme\cirkle\Customizer\Controls\Customizer_Image_Radio_Control;

/**
 * Adds the individual sections, settings, and controls to the theme customizer
 */
class RDTheme_Blog_Post_Settings extends RDTheme_Customizer {

	public function __construct() {
	    parent::instance();
        $this->populated_default_data();
        // Add Controls
        add_action( 'customize_register', array( $this, 'register_blog_post_controls' ) );
	}

    /**
     * Blog Post Controls
     */
    public function register_blog_post_controls( $wp_customize ) {

        // Blog Grid
        $wp_customize->add_setting( 'blog_grid',
            array(
                'default' => $this->defaults['blog_grid'],
                'transport' => 'refresh',
                'sanitize_callback' => 'rttheme_radio_sanitization'
            )
        );
        $wp_customize->add_control( 'blog_grid',
            array(
                'label' => esc_html__( 'Grid layput Columns', 'cirkle' ),
                'section' => 'blog_post_settings_section',
                'description' => esc_html__( 'This grid system work only for post layout 2', 'cirkle' ),
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

        $wp_customize->add_setting( 'blog_breadcrumb_title',
            array(
                'default' => $this->defaults['blog_breadcrumb_title'],
                'transport' => 'refresh',
                'sanitize_callback' => 'rttheme_text_sanitization',
            )
        );
        $wp_customize->add_control( 'blog_breadcrumb_title',
            array(
                'label' => esc_html__( 'Blog Breadcrumb Title', 'cirkle' ),
                'section' => 'blog_post_settings_section',
                'type' => 'text',
            )
        );

        // Post Categories
        $wp_customize->add_setting( 'meta_cats',
            array(
                'default' => $this->defaults['meta_cats'],
                'transport' => 'refresh',
                'sanitize_callback' => 'rttheme_switch_sanitization',
            )
        );
        $wp_customize->add_control( new Customizer_Switch_Control( $wp_customize, 'meta_cats',
            array(
                'label' => esc_html__( 'Meta Category', 'cirkle' ),
                'section' => 'blog_post_settings_section',
            )
        ) );

        // Post Admin
        $wp_customize->add_setting( 'meta_admin',
            array(
                'default' => $this->defaults['meta_admin'],
                'transport' => 'refresh',
                'sanitize_callback' => 'rttheme_switch_sanitization',
            )
        );
        $wp_customize->add_control( new Customizer_Switch_Control( $wp_customize, 'meta_admin',
            array(
                'label' => esc_html__( 'Meta Admin', 'cirkle' ),
                'section' => 'blog_post_settings_section',
            )
        ));

        // Post Date
        $wp_customize->add_setting( 'meta_date',
            array(
                'default' => $this->defaults['meta_date'],
                'transport' => 'refresh',
                'sanitize_callback' => 'rttheme_switch_sanitization',
            )
        );
        $wp_customize->add_control( new Customizer_Switch_Control( $wp_customize, 'meta_date',
            array(
                'label' => esc_html__( 'Meta Date', 'cirkle' ),
                'section' => 'blog_post_settings_section',
            )
        ));

        // Author React
        $wp_customize->add_setting( 'meta_react',
            array(
                'default' => $this->defaults['meta_react'],
                'transport' => 'refresh',
                'sanitize_callback' => 'rttheme_switch_sanitization',
            )
        );
        $wp_customize->add_control( new Customizer_Switch_Control( $wp_customize, 'meta_react',
            array(
                'label' => esc_html__( 'Meta React', 'cirkle' ),
                'section' => 'blog_post_settings_section',
            )
        ) );

        // Meta Comments
        $wp_customize->add_setting( 'meta_comnts',
            array(
                'default' => $this->defaults['meta_comnts'],
                'transport' => 'refresh',
                'sanitize_callback' => 'rttheme_switch_sanitization',
            )
        );
        $wp_customize->add_control( new Customizer_Switch_Control( $wp_customize, 'meta_comnts',
            array(
                'label' => esc_html__( 'Meta Comments', 'cirkle' ),
                'section' => 'blog_post_settings_section',
            )
        ) );

        // Excerpt Length
        $wp_customize->add_setting( 'excerpt_length',
            array(
                'default' => $this->defaults['excerpt_length'],
                'transport' => 'refresh',
                'sanitize_callback' => 'rttheme_sanitize_integer'
            )
        );
        $wp_customize->add_control( 'excerpt_length',
            array(
                'label' => esc_html__( 'Excerpt Length', 'cirkle' ),
                'section' => 'blog_post_settings_section',
                'type' => 'number'
            )
        );

    }

}

/**
 * Initialise our Customizer settings only when they're required
 */
if ( class_exists( 'WP_Customize_Control' ) ) {
	new RDTheme_Blog_Post_Settings();
}
