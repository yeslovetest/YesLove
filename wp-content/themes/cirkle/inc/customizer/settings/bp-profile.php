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
class RDTheme_Bp_Profile_Settings extends RDTheme_Customizer {

	public function __construct() {
	    parent::instance();
        $this->populated_default_data();
        // Add Controls
        add_action( 'customize_register', array( $this, 'register_bpprofile_controls' ) );
	}

    public function register_bpprofile_controls( $wp_customize ) {
        /**
         * Heading
         */
        $wp_customize->add_setting('bp_proile_tab_settings', array(
            'default' => '',
            'sanitize_callback' => 'esc_html',
        ));
        $wp_customize->add_control(new Customizer_Heading_Control($wp_customize, 'bp_proile_tab_settings', array(
            'label' => esc_html__( 'Profile Tab Enable/Disable', 'cirkle' ),
            'section' => 'bp_profile_section',
        )));
        // Add our Checkbox switch setting and control for opening URLs in a new tab
        $wp_customize->add_setting( 'profile_about_tab',
            array(
                'default' => $this->defaults['profile_about_tab'],
                'transport' => 'refresh',
                'sanitize_callback' => 'rttheme_switch_sanitization',
            )
        );
        $wp_customize->add_control( new Customizer_Switch_Control( $wp_customize, 'profile_about_tab',
            array(
                'label' => esc_html__( 'About', 'cirkle' ),
                'section' => 'bp_profile_section',
            )
        ) );
        // Add our Checkbox switch setting and control for opening URLs in a new tab
        $wp_customize->add_setting( 'profile_friends_tab',
            array(
                'default' => $this->defaults['profile_friends_tab'],
                'transport' => 'refresh',
                'sanitize_callback' => 'rttheme_switch_sanitization',
            )
        );
        $wp_customize->add_control( new Customizer_Switch_Control( $wp_customize, 'profile_friends_tab',
            array(
                'label' => esc_html__( 'Friends', 'cirkle' ),
                'section' => 'bp_profile_section',
            )
        ) );
        // Add our Checkbox switch setting and control for opening URLs in a new tab
        $wp_customize->add_setting( 'profile_groups_tab',
            array(
                'default' => $this->defaults['profile_groups_tab'],
                'transport' => 'refresh',
                'sanitize_callback' => 'rttheme_switch_sanitization',
            )
        );
        $wp_customize->add_control( new Customizer_Switch_Control( $wp_customize, 'profile_groups_tab',
            array(
                'label' => esc_html__( 'Groups', 'cirkle' ),
                'section' => 'bp_profile_section',
            )
        ) );
        // Add our Checkbox switch setting and control for opening URLs in a new tab
        $wp_customize->add_setting( 'profile_message_tab',
            array(
                'default' => $this->defaults['profile_message_tab'],
                'transport' => 'refresh',
                'sanitize_callback' => 'rttheme_switch_sanitization',
            )
        );
        $wp_customize->add_control( new Customizer_Switch_Control( $wp_customize, 'profile_message_tab',
            array(
                'label' => esc_html__( 'Message', 'cirkle' ),
                'section' => 'bp_profile_section',
            )
        ) );
        // Add our Checkbox switch setting and control for opening URLs in a new tab
        $wp_customize->add_setting( 'profile_photos_tab',
            array(
                'default' => $this->defaults['profile_photos_tab'],
                'transport' => 'refresh',
                'sanitize_callback' => 'rttheme_switch_sanitization',
            )
        );
        $wp_customize->add_control( new Customizer_Switch_Control( $wp_customize, 'profile_photos_tab',
            array(
                'label' => esc_html__( 'Photos', 'cirkle' ),
                'section' => 'bp_profile_section',
            )
        ) );
        // Add our Checkbox switch setting and control for opening URLs in a new tab
        $wp_customize->add_setting( 'profile_videos_tab',
            array(
                'default' => $this->defaults['profile_videos_tab'],
                'transport' => 'refresh',
                'sanitize_callback' => 'rttheme_switch_sanitization',
            )
        );
        $wp_customize->add_control( new Customizer_Switch_Control( $wp_customize, 'profile_videos_tab',
            array(
                'label' => esc_html__( 'Videos', 'cirkle' ),
                'section' => 'bp_profile_section',
            )
        ) );
        // Add our Checkbox switch setting and control for opening URLs in a new tab
        $wp_customize->add_setting( 'profile_badges_tab',
            array(
                'default' => $this->defaults['profile_badges_tab'],
                'transport' => 'refresh',
                'sanitize_callback' => 'rttheme_switch_sanitization',
            )
        );
        $wp_customize->add_control( new Customizer_Switch_Control( $wp_customize, 'profile_badges_tab',
            array(
                'label' => esc_html__( 'Badges', 'cirkle' ),
                'section' => 'bp_profile_section',
            )
        ) );
        // Add our Checkbox switch setting and control for opening URLs in a new tab
        $wp_customize->add_setting( 'profile_forums_tab',
            array(
                'default' => $this->defaults['profile_forums_tab'],
                'transport' => 'refresh',
                'sanitize_callback' => 'rttheme_switch_sanitization',
            )
        );
        $wp_customize->add_control( new Customizer_Switch_Control( $wp_customize, 'profile_forums_tab',
            array(
                'label' => esc_html__( 'Forums', 'cirkle' ),
                'section' => 'bp_profile_section',
            )
        ) );
        // Add our Checkbox switch setting and control for opening URLs in a new tab
        $wp_customize->add_setting( 'profile_Settings_tab',
            array(
                'default' => $this->defaults['profile_Settings_tab'],
                'transport' => 'refresh',
                'sanitize_callback' => 'rttheme_switch_sanitization',
            )
        );
        $wp_customize->add_control( new Customizer_Switch_Control( $wp_customize, 'profile_Settings_tab',
            array(
                'label' => esc_html__( 'Settings', 'cirkle' ),
                'section' => 'bp_profile_section',
            )
        ) );

        /**
         * Heading tab text
         */
        $wp_customize->add_setting('bp_proile_tab_text', array(
            'default' => '',
            'sanitize_callback' => 'esc_html',
        ));
        $wp_customize->add_control(new Customizer_Heading_Control($wp_customize, 'bp_proile_tab_text', array(
            'label' => esc_html__( 'Profile Tab Enable/Disable', 'cirkle' ),
            'section' => 'bp_profile_section',
        )));
        // Timeline text
        $wp_customize->add_setting( 'bp_timeline_tab_text',
            array(
                'default' => $this->defaults['bp_timeline_tab_text'],
                'transport' => 'refresh',
                'sanitize_callback' => 'rttheme_text_sanitization',
            )
        );
        $wp_customize->add_control( 'bp_timeline_tab_text',
            array(
                'label' => esc_html__( 'Timeline', 'cirkle' ),
                'section' => 'bp_profile_section',
                'type' => 'text',
            )
        );
        // Timeline position
        $wp_customize->add_setting( 'bp_timeline_tab_p',
            array(
                'default' => $this->defaults['bp_timeline_tab_p'],
                'transport' => 'refresh',
                'sanitize_callback' => 'rttheme_sanitize_integer'
            )
        );
        $wp_customize->add_control( 'bp_timeline_tab_p',
            array(
                'label' => __( 'Position', 'cirkle' ),
                'section' => 'bp_profile_section',
                'type' => 'number'
            )
        );
        // About text
        $wp_customize->add_setting( 'bp_profile_tab_text',
            array(
                'default' => $this->defaults['bp_profile_tab_text'],
                'transport' => 'refresh',
                'sanitize_callback' => 'rttheme_text_sanitization',
            )
        );
        $wp_customize->add_control( 'bp_profile_tab_text',
            array(
                'label' => esc_html__( 'About', 'cirkle' ),
                'section' => 'bp_profile_section',
                'type' => 'text',
            )
        );
        // About position
        $wp_customize->add_setting( 'bp_profile_tab_p',
            array(
                'default' => $this->defaults['bp_profile_tab_p'],
                'transport' => 'refresh',
                'sanitize_callback' => 'rttheme_sanitize_integer'
            )
        );
        $wp_customize->add_control( 'bp_profile_tab_p',
            array(
                'label' => __( 'Position', 'cirkle' ),
                'section' => 'bp_profile_section',
                'type' => 'number'
            )
        );
        // Friends
        $wp_customize->add_setting( 'bp_friends_tab_text',
            array(
                'default' => $this->defaults['bp_friends_tab_text'],
                'transport' => 'refresh',
                'sanitize_callback' => 'rttheme_text_sanitization',
            )
        );
        $wp_customize->add_control( 'bp_friends_tab_text',
            array(
                'label' => esc_html__( 'Friends', 'cirkle' ),
                'section' => 'bp_profile_section',
                'type' => 'text',
            )
        );
        // Friends position
        $wp_customize->add_setting( 'bp_friends_tab_p',
            array(
                'default' => $this->defaults['bp_friends_tab_p'],
                'transport' => 'refresh',
                'sanitize_callback' => 'rttheme_sanitize_integer'
            )
        );
        $wp_customize->add_control( 'bp_friends_tab_p',
            array(
                'label' => __( 'Position', 'cirkle' ),
                'section' => 'bp_profile_section',
                'type' => 'number'
            )
        );
        // Groups
        $wp_customize->add_setting( 'bp_groups_tab_text',
            array(
                'default' => $this->defaults['bp_groups_tab_text'],
                'transport' => 'refresh',
                'sanitize_callback' => 'rttheme_text_sanitization',
            )
        );
        $wp_customize->add_control( 'bp_groups_tab_text',
            array(
                'label' => esc_html__( 'Groups', 'cirkle' ),
                'section' => 'bp_profile_section',
                'type' => 'text',
            )
        );
        // Groups position
        $wp_customize->add_setting( 'bp_groups_tab_p',
            array(
                'default' => $this->defaults['bp_groups_tab_p'],
                'transport' => 'refresh',
                'sanitize_callback' => 'rttheme_sanitize_integer'
            )
        );
        $wp_customize->add_control( 'bp_groups_tab_p',
            array(
                'label' => __( 'Position', 'cirkle' ),
                'section' => 'bp_profile_section',
                'type' => 'number'
            )
        );
        // Messages
        $wp_customize->add_setting( 'bp_messages_tab_text',
            array(
                'default' => $this->defaults['bp_messages_tab_text'],
                'transport' => 'refresh',
                'sanitize_callback' => 'rttheme_text_sanitization',
            )
        );
        $wp_customize->add_control( 'bp_messages_tab_text',
            array(
                'label' => esc_html__( 'Messages', 'cirkle' ),
                'section' => 'bp_profile_section',
                'type' => 'text',
            )
        );
        // Messages position
        $wp_customize->add_setting( 'bp_messages_tab_p',
            array(
                'default' => $this->defaults['bp_messages_tab_p'],
                'transport' => 'refresh',
                'sanitize_callback' => 'rttheme_sanitize_integer'
            )
        );
        $wp_customize->add_control( 'bp_messages_tab_p',
            array(
                'label' => __( 'Position', 'cirkle' ),
                'section' => 'bp_profile_section',
                'type' => 'number'
            )
        );
        // Photos
        $wp_customize->add_setting( 'bp_photos_tab_text',
            array(
                'default' => $this->defaults['bp_photos_tab_text'],
                'transport' => 'refresh',
                'sanitize_callback' => 'rttheme_text_sanitization',
            )
        );
        $wp_customize->add_control( 'bp_photos_tab_text',
            array(
                'label' => esc_html__( 'Photos', 'cirkle' ),
                'section' => 'bp_profile_section',
                'type' => 'text',
            )
        );
        // Photos position
        $wp_customize->add_setting( 'bp_photos_tab_p',
            array(
                'default' => $this->defaults['bp_photos_tab_p'],
                'transport' => 'refresh',
                'sanitize_callback' => 'rttheme_sanitize_integer'
            )
        );
        $wp_customize->add_control( 'bp_photos_tab_p',
            array(
                'label' => __( 'Position', 'cirkle' ),
                'section' => 'bp_profile_section',
                'type' => 'number'
            )
        );
        // Videos
        $wp_customize->add_setting( 'bp_videos_tab_text',
            array(
                'default' => $this->defaults['bp_videos_tab_text'],
                'transport' => 'refresh',
                'sanitize_callback' => 'rttheme_text_sanitization',
            )
        );
        $wp_customize->add_control( 'bp_videos_tab_text',
            array(
                'label' => esc_html__( 'Videos', 'cirkle' ),
                'section' => 'bp_profile_section',
                'type' => 'text',
            )
        );
        // Videos position
        $wp_customize->add_setting( 'bp_videos_tab_p',
            array(
                'default' => $this->defaults['bp_videos_tab_p'],
                'transport' => 'refresh',
                'sanitize_callback' => 'rttheme_sanitize_integer'
            )
        );
        $wp_customize->add_control( 'bp_videos_tab_p',
            array(
                'label' => __( 'Position', 'cirkle' ),
                'section' => 'bp_profile_section',
                'type' => 'number'
            )
        );
        // Badges
        $wp_customize->add_setting( 'bp_badges_tab_text',
            array(
                'default' => $this->defaults['bp_badges_tab_text'],
                'transport' => 'refresh',
                'sanitize_callback' => 'rttheme_text_sanitization',
            )
        );
        $wp_customize->add_control( 'bp_badges_tab_text',
            array(
                'label' => esc_html__( 'Badges', 'cirkle' ),
                'section' => 'bp_profile_section',
                'type' => 'text',
            )
        );
        // Badges position
        $wp_customize->add_setting( 'bp_badges_tab_p',
            array(
                'default' => $this->defaults['bp_badges_tab_p'],
                'transport' => 'refresh',
                'sanitize_callback' => 'rttheme_sanitize_integer'
            )
        );
        $wp_customize->add_control( 'bp_badges_tab_p',
            array(
                'label' => __( 'Position', 'cirkle' ),
                'section' => 'bp_profile_section',
                'type' => 'number'
            )
        );
        // Forums
        $wp_customize->add_setting( 'bp_forums_tab_text',
            array(
                'default' => $this->defaults['bp_forums_tab_text'],
                'transport' => 'refresh',
                'sanitize_callback' => 'rttheme_text_sanitization',
            )
        );
        $wp_customize->add_control( 'bp_forums_tab_text',
            array(
                'label' => esc_html__( 'Forums', 'cirkle' ),
                'section' => 'bp_profile_section',
                'type' => 'text',
            )
        );
        // Forums position
        $wp_customize->add_setting( 'bp_forums_tab_p',
            array(
                'default' => $this->defaults['bp_forums_tab_p'],
                'transport' => 'refresh',
                'sanitize_callback' => 'rttheme_sanitize_integer'
            )
        );
        $wp_customize->add_control( 'bp_forums_tab_p',
            array(
                'label' => __( 'Position', 'cirkle' ),
                'section' => 'bp_profile_section',
                'type' => 'number'
            )
        );
        // Settings
        $wp_customize->add_setting( 'bp_settings_tab_text',
            array(
                'default' => $this->defaults['bp_settings_tab_text'],
                'transport' => 'refresh',
                'sanitize_callback' => 'rttheme_text_sanitization',
            )
        );
        $wp_customize->add_control( 'bp_settings_tab_text',
            array(
                'label' => esc_html__( 'Settings', 'cirkle' ),
                'section' => 'bp_profile_section',
                'type' => 'text',
            )
        );
        // Settings position
        $wp_customize->add_setting( 'bp_settings_tab_p',
            array(
                'default' => $this->defaults['bp_settings_tab_p'],
                'transport' => 'refresh',
                'sanitize_callback' => 'rttheme_sanitize_integer'
            )
        );
        $wp_customize->add_control( 'bp_settings_tab_p',
            array(
                'label' => __( 'Position', 'cirkle' ),
                'section' => 'bp_profile_section',
                'type' => 'number'
            )
        );

    }

}

/**
 * Initialise our Customizer settings only when they're required  
 */
if ( class_exists( 'WP_Customize_Control' ) ) {
	new RDTheme_Bp_Profile_Settings();
}
