<?php
/**
 * @author  RadiusTheme
 * @since   1.0
 * @version 1.0
 */

namespace radiustheme\Cirkle_Core;

use radiustheme\cirkle\inc\RDTheme;
use radiustheme\cirkle\Helper;

if ( ! defined( 'ABSPATH' ) ) exit;

if ( !class_exists( 'RT_Postmeta' ) ) {
	return;
}

$Postmeta = \RT_Postmeta::getInstance();

$prefix = CIRKLE_CORE_THEME_PREFIX;

$ctp_socials = array(
	'facebook' => array(
		'label' => __( 'Facebook', 'cirkle-core' ),
		'type'  => 'text',
		'icon'  => 'fa-facebook',
		'color' => '#3b5998',
	),
	'twitter' => array(
		'label' => __( 'Twitter', 'cirkle-core' ),
		'type'  => 'text',
		'icon'  => 'fa-twitter',
		'color' => '#1da1f2',
	),
	'instagram' => array(
		'label' => __( 'Instagram', 'cirkle-core' ),
		'type'  => 'text',
		'icon'  => 'fa-instagram',
		'color' => '#AA3DB2',
	),
	'pinterest' => array(
		'label' => __( 'Pinterest', 'cirkle-core' ),
		'type'  => 'text',
		'icon'  => 'fab fa-pinterest-p',
		'color' => '#e60023',
	),
);
$cirkle_ctp_socials = apply_filters( 'ctp_socials', $ctp_socials );

/*---------------------------------------------------------------------
#. = Layout Settings
-----------------------------------------------------------------------*/
$nav_menus = wp_get_nav_menus( array( 'fields' => 'id=>name' ) );
$nav_menus = array( 'default' => __( 'Default', 'cirkle-core' ) ) + $nav_menus;
$Postmeta->add_meta_box( 'cirkle_page_settings', esc_html__( 'Layout Settings', 'cirkle-core' ), array( 'page', 'post' ), '', '', 'high', array(
	'fields' => array(
		"{$prefix}_layout" => array(
			'label'   => esc_html__( 'Layout', 'cirkle-core' ),
			'type'    => 'select',
			'options' => array(
				'default'       => esc_html__( 'Default', 'cirkle-core' ),
				'full-width'    => esc_html__( 'Full Width', 'cirkle-core' ),
				'left-sidebar'  => esc_html__( 'Left Sidebar', 'cirkle-core' ),
				'right-sidebar' => esc_html__( 'Right Sidebar', 'cirkle-core' ),
				),
			'default'  			=> 'default',
		),	
		"{$prefix}_header" => array(
			'label'   => esc_html__( 'Header Layout', 'cirkle-core' ),
			'type'    => 'select',
			'options' => array(
				'default' => esc_html__( 'Default', 'cirkle-core' ),
				'1'       => esc_html__( 'Layout 1', 'cirkle-core' ),
				'2'       => esc_html__( 'Layout 2', 'cirkle-core' ),
			),
			'default'  => 'default',
		),
		"{$prefix}_footer" => array(
			'label'   => esc_html__( 'Footer Layout', 'cirkle-core' ),
			'type'    => 'select',
			'options' => array(
				'default' => esc_html__( 'Default', 'cirkle-core' ),
				'1'       => esc_html__( 'Layout 1', 'cirkle-core' ),
				'2'       => esc_html__( 'Layout 2', 'cirkle-core' ),
			),
			'default'  => 'default',
		),
		"{$prefix}_has_banner" => array(
			'label'   => esc_html__( 'Banner', 'fototag-core' ),
			'type'    => 'select',
			'options' => array(
				'default' => esc_html__( 'Default', 'fototag-core' ),
				'on'      => esc_html__( 'Enable', 'fototag-core' ),
				'off'     => esc_html__( 'Disable', 'fototag-core' ),
				),
			'default'  => 'default',
		),
		"{$prefix}_breadcrumb" => array(
			'label'   => esc_html__( 'Breadcrumb', 'cirkle-core' ),
			'type'    => 'select',
			'options' => array(
				'default' => esc_html__( 'Default', 'cirkle-core' ),
				'on'      => esc_html__( 'Enable', 'cirkle-core' ),
				'off'     => esc_html__( 'Disable', 'cirkle-core' ),
				),
			'default'  => 'default',
		),
		"{$prefix}_menu_transparent" => array(
			'label'   => esc_html__( 'Menu Transparent', 'cirkle-core' ),
			'type'    => 'select',
			'options' => array(
				'default' => esc_html__( 'Default', 'cirkle-core' ),
				'on'      => esc_html__( 'Enable', 'cirkle-core' ),
				'off'     => esc_html__( 'Disable', 'cirkle-core' ),
				),
			'default'  => 'default',
		),

		"{$prefix}_menu_bg_color" => array(
			'label' => esc_html__( 'Banner Background Color', 'cirkle-core' ),
			'type'  => 'color_picker',
			'desc'  => esc_html__( 'If not selected, default will be used', 'cirkle-core' ),
		),
		"{$prefix}_menu_bg_opacity" => array(
			'label' => esc_html__( 'Background Opacity', 'cirkle-core' ),
			'type'  => 'number',
			'default'  => '',
			'desc'  => esc_html__( 'Max input number will be 100', 'cirkle-core' ),
		),	
		"{$prefix}_menu_bg_height" => array(
			'label' => esc_html__( 'Menu background height', 'cirkle-core' ),
			'type'  => 'text',
			'default'  => '',
			'desc'  => esc_html__( 'default menu background height will be used 200 "px"', 'cirkle-core' ),
		),		
	),
	) 
);

/*---------------------------------------------------------------------
#. = Portfolio
-----------------------------------------------------------------------*/
$Postmeta->add_meta_box( $prefix.'_portfolio_info', __( 'Portfolio Information', 'cirkle-core' ), array( $prefix.'_portfolio' ), '', '', 'high', array(
	'fields' => array(
		"{$prefix}_portfolio_subtitle" => array(
			'label' => esc_html__( 'Portfolio Sub Title', 'cirkle-core' ),
			'type'  => 'text',
		),
		"{$prefix}_portfolio_location" => array(
			'label' => esc_html__( 'Portfolio Location', 'cirkle-core' ),
			'type'  => 'text',
		),
		"{$prefix}_portfolio_info" => array(
			'type'  => 'repeater',
			'label' => esc_html__( 'Portfolio Information', 'cirkle-core' ),
			'button' => __( 'Add New Info', 'cirkle-core' ),
			'value'  => array(
				'info_title' => array(
					'label' => __( 'Info Title', 'cirkle-core' ),
					'type'  => 'text',
					'desc'  => __( 'This is team member profile info title', 'cirkle-core' ),
				),
				'info_text' => array(
					'label' => __( 'Info Text', 'cirkle-core' ),
					'type'  => 'text',
					'desc'  => __( 'This is team member profile info text', 'cirkle-core' ),
				),
			)
		),
	)
) );


$Postmeta->add_meta_box( $prefix.'_portfolio_mi', __( 'Mesonry Image', 'cirkle-core' ), array( $prefix.'_portfolio' ), '', 'side', 'high', array(
	'fields' => array(
		"portfolio_mesonry_img" => array(
			'label' => esc_html__( 'Mesonry Image', 'cirkle-core' ),
			'type'  => 'image',
			'desc'  => __( 'This is portfolio mesonry image filed. This image work only mesonry layout.', 'cirkle-core' ),
		),
	)
) );





/*---------------------------------------------------------------------
#. = Team
-----------------------------------------------------------------------*/
$Postmeta->add_meta_box( $prefix.'_team_info', __( 'Team Information', 'cirkle-core' ), array( $prefix.'_team' ), '', '', 'high', array(
	'fields' => array(
		"{$prefix}_team_desigantion" => array(
			'label' => esc_html__( 'Team Designation', 'cirkle-core' ),
			'type'  => 'text',
		),
		"{$prefix}_team_info" => array(
			'type'  => 'repeater',
			'label' => esc_html__( 'Team Information', 'cirkle-core' ),
			'button' => __( 'Add New Info', 'cirkle-core' ),
			'value'  => array(
				'info_title' => array(
					'label' => __( 'Info Title', 'cirkle-core' ),
					'type'  => 'text',
					'desc'  => __( 'This is team member profile info title', 'cirkle-core' ),
				),
				'info_text' => array(
					'label' => __( 'Info Text', 'cirkle-core' ),
					'type'  => 'text',
					'desc'  => __( 'This is team member profile info text', 'cirkle-core' ),
				),
			)
		),
		"{$prefix}_team_socials" => array(
			'type'  => 'group',
			'label' => esc_html__( 'Team Socials', 'cirkle-core' ),
			'value'  => $cirkle_ctp_socials
		),
	)
) );
$Postmeta->add_meta_box( $prefix.'_team_bio', __( 'Team Biography', 'cirkle-core' ), array( $prefix.'_team' ), '', '', 'high', array(
	'fields' => array(
		"{$prefix}_team_bio_title" => array(
			'label' => esc_html__( 'Team Bio Title', 'cirkle-core' ),
			'type'  => 'text',
		),
		"{$prefix}_team_bio_text" => array(
			'label' => esc_html__( 'Team Bio Text', 'cirkle-core' ),
			'type'  => 'textarea_html',
		),

	)
) );

$Postmeta->add_meta_box( $prefix.'_team_skill', __( 'Team Skills', 'cirkle-core' ), array( $prefix.'_team' ), '', '', 'high', array(
	'fields' => array(
		"{$prefix}_team_skill_title" => array(
			'label' => esc_html__( 'Skill Title', 'cirkle-core' ),
			'type'  => 'text',
		),
		"{$prefix}_team_skills" => array(
			'type'  => 'repeater',
			'label' => esc_html__( 'Team Skills List', 'cirkle-core' ),
			'button' => __( 'Add New Skill', 'cirkle-core' ),
			'value'  => array(
				'info_title' => array(
					'label' => __( 'Skill Name', 'cirkle-core' ),
					'type'  => 'text',
					'desc'  => __( 'This is team member skill name', 'cirkle-core' ),
				),
				'info_text' => array(
					'label' => __( 'Skill Persantage', 'cirkle-core' ),
					'type'  => 'text',
					'desc'  => __( 'This is team member skill persantage, Please put persantage with %, like as (90%)', 'cirkle-core' ),
				),
			)
		),
	)
) );

$Postmeta->add_meta_box( $prefix.'_team_diversity', __( 'Team Diversity', 'cirkle-core' ), array( $prefix.'_team' ), '', '', 'high', array(
	'fields' => array(
		"{$prefix}_team_diversity_title" => array(
			'label' => esc_html__( 'Team Bio Title', 'cirkle-core' ),
			'type'  => 'text',
		),
		"{$prefix}_team_diversity_text" => array(
			'label' => esc_html__( 'Team Bio Text', 'cirkle-core' ),
			'type'  => 'textarea_html',
		),

	)
) );

$Postmeta->add_meta_box( $prefix.'_team_contact', __( 'Team Contact', 'cirkle-core' ), array( $prefix.'_team' ), '', '', 'high', array(
	'fields' => array(
		"{$prefix}_team_contact_title" => array(
			'label' => esc_html__( 'Contact Title', 'cirkle-core' ),
			'type'  => 'text',
		),
		"{$prefix}_team_contact_shortcode" => array(
			'label' => esc_html__( 'Contact Form Shortcode', 'cirkle-core' ),
			'type'  => 'textarea_html',
		),

	)
) );