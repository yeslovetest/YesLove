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
class RDTheme_Blog_Single_Post_Settings extends RDTheme_Customizer {

	public function __construct() {
	    parent::instance();
        $this->populated_default_data();
        // Add Controls
        add_action( 'customize_register', array( $this, 'register_blog_single_post_controls' ) );
	}

    /**
     * Blog Post Controls
     */
    public function register_blog_single_post_controls( $wp_customize ) {

        // Post Category
        $wp_customize->add_setting( 'post_cats',
            array(
                'default' => $this->defaults['post_cats'],
                'transport' => 'refresh',
                'sanitize_callback' => 'rttheme_switch_sanitization',
            )
        );
        $wp_customize->add_control( new Customizer_Switch_Control( $wp_customize, 'post_cats',
            array(
                'label' => esc_html__( 'Post Category', 'cirkle' ),
                'section' => 'single_post_secttings_section',
            )
        ) );

        // Post Admin
        $wp_customize->add_setting( 'post_admin',
            array(
                'default' => $this->defaults['post_admin'],
                'transport' => 'refresh',
                'sanitize_callback' => 'rttheme_switch_sanitization',
            )
        );
        $wp_customize->add_control( new Customizer_Switch_Control( $wp_customize, 'post_admin',
            array(
                'label' => esc_html__( 'Post Admin', 'cirkle' ),
                'section' => 'single_post_secttings_section',
            )
        ));

        // Post Date
        $wp_customize->add_setting( 'post_date',
            array(
                'default' => $this->defaults['post_date'],
                'transport' => 'refresh',
                'sanitize_callback' => 'rttheme_switch_sanitization',
            )
        );
        $wp_customize->add_control( new Customizer_Switch_Control( $wp_customize, 'post_date',
            array(
                'label' => esc_html__( 'Post Date', 'cirkle' ),
                'section' => 'single_post_secttings_section',
            )
        ));

        // Post Comments
        $wp_customize->add_setting( 'post_comnts',
            array(
                'default' => $this->defaults['post_comnts'],
                'transport' => 'refresh',
                'sanitize_callback' => 'rttheme_switch_sanitization',
            )
        );
        $wp_customize->add_control( new Customizer_Switch_Control( $wp_customize, 'post_comnts',
            array(
                'label' => esc_html__( 'Post Comments', 'cirkle' ),
                'section' => 'single_post_secttings_section',
            )
        ) );

        // Post Share
        $wp_customize->add_setting( 'post_share',
            array(
                'default' => $this->defaults['post_share'],
                'transport' => 'refresh',
                'sanitize_callback' => 'rttheme_switch_sanitization',
            )
        );
        $wp_customize->add_control( new Customizer_Switch_Control( $wp_customize, 'post_share',
            array(
                'label' => esc_html__( 'Display Post Share', 'cirkle' ),
                'section' => 'single_post_secttings_section',
            )
        ) );

        // Post Tags
        $wp_customize->add_setting( 'post_react',
            array(
                'default' => $this->defaults['post_react'],
                'transport' => 'refresh',
                'sanitize_callback' => 'rttheme_switch_sanitization',
            )
        );
        $wp_customize->add_control( new Customizer_Switch_Control( $wp_customize, 'post_react',
            array(
                'label' => esc_html__( 'Display Post React', 'cirkle' ),
                'section' => 'single_post_secttings_section',
            )
        ) );

        $wp_customize->add_setting( 'meta_react_text',
            array(
                'default' => $this->defaults['meta_react_text'],
                'transport' => 'refresh',
                'sanitize_callback' => 'rttheme_text_sanitization',
            )
        );
        $wp_customize->add_control( 'meta_react_text',
            array(
                'label' => esc_html__( 'Post Meta React Text', 'cirkle' ),
                'section' => 'single_post_secttings_section',
                'type' => 'text',
            )
        );

        // Post Share
        $wp_customize->add_setting( 'post_share',
            array(
                'default' => $this->defaults['post_share'],
                'transport' => 'refresh',
                'sanitize_callback' => 'rttheme_switch_sanitization',
            )
        );
        $wp_customize->add_control( new Customizer_Switch_Control( $wp_customize, 'post_share',
            array(
                'label' => esc_html__( 'Display Post Share', 'cirkle' ),
                'section' => 'single_post_secttings_section',
            )
        ) );

        // Related Post
        $wp_customize->add_setting( 'related_post',
            array(
                'default' => $this->defaults['related_post'],
                'transport' => 'refresh',
                'sanitize_callback' => 'rttheme_switch_sanitization',
            )
        );
        $wp_customize->add_control( new Customizer_Switch_Control( $wp_customize, 'related_post',
            array(
                'label' => esc_html__( 'Related Post', 'cirkle' ),
                'section' => 'single_post_secttings_section',
            )
        ) );
        // Related Post Title
        $wp_customize->add_setting( 'related_post_title',
            array(
                'default' => $this->defaults['related_post_title'],
                'transport' => 'refresh',
                'sanitize_callback' => 'rttheme_text_sanitization',
            )
        );
        $wp_customize->add_control( 'related_post_title',
            array(
                'label' => esc_html__( 'Related Post Title', 'cirkle' ),
                'section' => 'single_post_secttings_section',
                'type' => 'text',
                'active_callback' => 'rttheme_related_post_enabled',
            )
        );
        // Posts per page
        $wp_customize->add_setting( 'post_per_page',
            array(
                'default' => $this->defaults['post_per_page'],
                'transport' => 'refresh',
                'sanitize_callback' => 'rttheme_sanitize_integer'
            )
        );
        $wp_customize->add_control( 'post_per_page',
            array(
                'label' => esc_html__( 'Posts Per Page', 'cirkle' ),
                'section' => 'single_post_secttings_section',
                'type' => 'number',
                'active_callback' => 'rttheme_related_post_enabled',
            )
        );

    }

}

/**
 * Initialise our Customizer settings only when they're required
 */
if ( class_exists( 'WP_Customize_Control' ) ) {
	new RDTheme_Blog_Single_Post_Settings();
}
