<?php
/**
 * This file can be overridden by copying it to yourtheme/elementor-custom/video/class.php
 * 
 * @author  RadiusTheme
 * @since   1.0
 * @version 1.0
 */

namespace radiustheme\Cirkle_Core;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Background;

if ( ! defined( 'ABSPATH' ) ) exit;

class Rt_Video extends Custom_Widget_Base {

	public function __construct( $data = [], $args = null ){
		$this->rt_name = __( 'Video Button', 'cirkle-core' );
		$this->rt_base = 'rt-video-button';
		parent::__construct( $data, $args );
	}

	public function rt_fields(){
		$fields = array(
			array(
				'id'      => 'video_button',
				'mode'    => 'section_start',
				'label'   => __( 'Video Button', 'cirkle-core' ),
			),

			// Image 1
			array(
				'id'      => 'image1',
				'type'    => Controls_Manager::MEDIA,
				'label'   => esc_html__( 'Image 1', 'cirkle-core' ),
				'default' => [
                    'url' => $this->rt_placeholder_image(),
                ],
				'description' => esc_html__( 'Recommended full image', 'cirkle-core' ),
			),
			// Image 2
			array(
				'id'      => 'image2',
				'type'    => Controls_Manager::MEDIA,
				'label'   => esc_html__( 'Image 2', 'cirkle-core' ),
				'default' => [
                    'url' => $this->rt_placeholder_image(),
                ],
				'description' => esc_html__( 'Recommended full image', 'cirkle-core' ),
			),
			array(
				'id'      => 'video_link',
				'type'    => Controls_Manager::TEXT,
				'label'   => __( 'Video link', 'cirkle-core' ),
				'default' => 'https://www.youtube.com/watch?v=1iIZeIy7TqM',
			),
			array(
				'type'    => Controls_Manager::ICON,
				'id'      => 'video_icon',
				'label'   => esc_html__( 'Video play icon', 'cirkle-core' ),
				'default' => 'icofont-ui-play',
			),
			array(
				'id'      => 'align',
				'mode'    => 'responsive',
				'type'    => Controls_Manager::CHOOSE,
				'label'   => __( 'Title Alignment', 'cirkle-core' ),
				'options' => $this->rt_alignment_options(),
				'default' => 'center',
				'prefix_class' => 'video-btn%s-align-',
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .video-btn' => 'text-align: {{VALUE}};',
				],
			),
			array(
				'mode' => 'section_end',
			),
			array(
				'id'      => 'sec_style',
				'mode'    => 'section_start',
				'tab'     => Controls_Manager::TAB_STYLE,
				'label'   => __( 'Style', 'cirkle-core' ),
			),
			array(
				'id'      => 'btn_font_color',
				'type'    => Controls_Manager::COLOR,
				'label'   => __( 'Color', 'cirkle-core' ),
				'selectors' => array( 
					'{{WRAPPER}} .video-icon .play-btn i' => 'color: {{VALUE}}',
				),
			),
			array(
				'type'      => Controls_Manager::NUMBER,
				'id'        => 'icon_size',
				'label'     => esc_html__( 'Icon Size', 'clenix-core' ),
				'selectors' => array(
					'{{WRAPPER}} .video-icon .play-btn i' => 'font-size: {{VALUE}}px',
				),
				'description' => esc_html__( 'Icon size default: 22px', 'clenix-core' ),
			),
			array(
				'name'     => 'btn_bg',
				'mode'     => 'group',
				'type'     => Group_Control_Background::get_type(),
				'label'    => __( 'Background', 'cirkle-core' ),
				'selector' => '{{WRAPPER}} .video-icon .play-btn',
			),
			array(
				'name'     => 'btn_border',
				'mode'     => 'group',
				'type'     => Group_Control_Border::get_type(),
				'label'    => __( 'Border', 'cirkle-core' ),
				'selector' => '{{WRAPPER}} .video-icon .play-btn',
			),
			array(
				'id'      => 'hover_hover_heading',
				'type' => Controls_Manager::HEADING,
				'label'   => __( 'Hover Style', 'cirkle-core' ),
				'separator' => 'before',
			),
			array(
				'id'      => 'btn_hfont_color',
				'type'    => Controls_Manager::COLOR,
				'label'   => __( 'Color', 'cirkle-core' ),
				'selectors' => array( 
					'{{WRAPPER}} .video-icon .play-btn:hover i' => 'color: {{VALUE}}',
				),
			),
			array(
				'name'     => 'btn_hbg',
				'mode'     => 'group',
				'type'     => Group_Control_Background::get_type(),
				'label'    => __( 'Background', 'cirkle-core' ),
				'selector' => '{{WRAPPER}} .video-icon .play-btn:hover',
			),
			array(
				'id'      => 'btn_hb_color',
				'type'    => Controls_Manager::COLOR,
				'label'   => __( 'Border Color', 'cirkle-core' ),
				'selectors' => array( 
					'{{WRAPPER}} .video-icon .play-btn:hover' => 'border-color: {{VALUE}}',
				),
			),
			array(
				'mode' => 'section_end',
			),
		);
		return $fields;
	}

	protected function render() {
		$data = $this->get_settings();

		$template = 'view';

		return $this->rt_template( $template, $data );
	}
}