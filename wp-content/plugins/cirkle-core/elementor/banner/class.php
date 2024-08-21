<?php
/**
 * This file can be overridden by copying it to yourtheme/elementor-custom/banner/class.php
 * 
 * @author  RadiusTheme
 * @since   1.0
 * @version 1.0
 */

namespace radiustheme\Cirkle_Core;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Background;

if ( ! defined( 'ABSPATH' ) ) exit;

class Rt_Banner extends Custom_Widget_Base {

	public function __construct( $data = [], $args = null ){
		$this->rt_name = __( 'Banner', 'cirkle-core' );
		$this->rt_base = 'rt-banner';
		parent::__construct( $data, $args );
	}

	public function rt_fields(){

		$fields = array(
			array(
				'mode'    => 'section_start',
				'id'      => 'banner_section',
				'label'   => esc_html__( 'Banner Section', 'cirkle-core' ),
			),
			// Image
			array(
				'id'      => 'bg_image',
				'type'    => Controls_Manager::MEDIA,
				'label'   => esc_html__( 'BG Image', 'cirkle-core' ),
				'default' => [
                    'url' => $this->rt_placeholder_image(),
                ],
				'description' => esc_html__( 'Recommended full image', 'cirkle-core' ),
			),
			// Title
			array(
				'id'      => 'title',
				'type'    => Controls_Manager::TEXT,
				'label'   => __( 'Title', 'cirkle-core' ),
				'label_block' => true,
			),
			// Description
			array(
				'id'      => 'desc',
				'type'    => Controls_Manager::TEXTAREA,
				'label'   => __( 'Description', 'cirkle-core' ),
				'label_block' => true,
			),
			// Number
			array(
				'id'      => 'number',
				'type'    => Controls_Manager::TEXT,
				'label'   => __( 'Number', 'cirkle-core' ),
				'label_block' => true,
			),
			// Number Title
			array(
				'id'      => 'number_text',
				'type'    => Controls_Manager::TEXT,
				'label'   => __( 'Number Text', 'cirkle-core' ),
				'label_block' => true,
			),
			// Button Text
			array(
				'id'      => 'btn_txt',
				'type'    => Controls_Manager::TEXT,
				'label'   => __( 'Button Text', 'cirkle-core' ),
				'label_block' => true,
			),
			// Button Title
			array(
				'id'      => 'btn_link',
				'type'    => Controls_Manager::TEXT,
				'label'   => __( 'Button Link', 'cirkle-core' ),
				'label_block' => true,
			),
			// Left Side Shape Image
			array(
				'id'      => 'people_shape',
				'type'    => Controls_Manager::MEDIA,
				'label'   => esc_html__( 'People Shape Image', 'cirkle-core' ),
				'default' => [
                    'url' => $this->rt_placeholder_image(),
                ],
				'description' => esc_html__( 'Recommended full image', 'cirkle-core' ),
			),
			// Left Side Shape Image
			array(
				'id'      => 'people_bgshape',
				'type'    => Controls_Manager::MEDIA,
				'label'   => esc_html__( 'People BG Shape Image', 'cirkle-core' ),
				'default' => [
                    'url' => $this->rt_placeholder_image(),
                ],
				'description' => esc_html__( 'Recommended full image', 'cirkle-core' ),
			),

			// Map Shape Image
			array(
				'id'      => 'map_shape',
				'type'    => Controls_Manager::MEDIA,
				'label'   => esc_html__( 'Map Shape Image', 'cirkle-core' ),
				'default' => [
                    'url' => $this->rt_placeholder_image(),
                ],
				'description' => esc_html__( 'Recommended full image', 'cirkle-core' ),
			),
			array(
				'id'      => 'marker1',
				'type'    => Controls_Manager::MEDIA,
				'label'   => esc_html__( 'Map Marker 1', 'cirkle-core' ),
				'default' => [
                    'url' => $this->rt_placeholder_image(),
                ],
				'description' => esc_html__( 'Recommended full image', 'cirkle-core' ),
			),
			array(
				'id'      => 'marker2',
				'type'    => Controls_Manager::MEDIA,
				'label'   => esc_html__( 'Map Marker 2', 'cirkle-core' ),
				'default' => [
                    'url' => $this->rt_placeholder_image(),
                ],
				'description' => esc_html__( 'Recommended full image', 'cirkle-core' ),
			),
			array(
				'id'      => 'marker3',
				'type'    => Controls_Manager::MEDIA,
				'label'   => esc_html__( 'Map Marker 3', 'cirkle-core' ),
				'default' => [
                    'url' => $this->rt_placeholder_image(),
                ],
				'description' => esc_html__( 'Recommended full image', 'cirkle-core' ),
			),
			array(
				'id'      => 'marker4',
				'type'    => Controls_Manager::MEDIA,
				'label'   => esc_html__( 'Map Marker 4', 'cirkle-core' ),
				'default' => [
                    'url' => $this->rt_placeholder_image(),
                ],
				'description' => esc_html__( 'Recommended full image', 'cirkle-core' ),
			),

			array(
				'mode' => 'section_end',
			),
			
			// Style 
			array(
				'id'      => 'banner_style',
				'mode'    => 'section_start',
				'tab'     => Controls_Manager::TAB_STYLE,
				'label'   => __( 'Style', 'cirkle-core' ),
			),

			// Item Padding
			array(
			    'id'      => 'item_padding',
			    'mode' 	  => 'responsive',
			    'type'    => Controls_Manager::DIMENSIONS,
			    'size_units' => [ 'px', '%', 'em' ],
			    'label'   => __( 'Padding', 'cirkle-core' ),                 
			    'selectors' => array(
			        '{{WRAPPER}} .hero-banner' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',                    
			    ),
			),

			// Title
			array(
				'id'      => 'title_heading',
				'type' => Controls_Manager::HEADING,
				'label'   => __( 'Title', 'cirkle-core' ),
				'separator' => 'before',
			),
			array(
				'id'      => 'title_color',
				'type'    => Controls_Manager::COLOR,
				'label'   => __( 'Color', 'cirkle-core' ),
				'default' => '',
				'selectors' => array( 
					'{{WRAPPER}} .hero-banner .item-title' => 'color: {{VALUE}}',
				),
			),
			array(
				'name'     => 'title_typo',
				'mode'     => 'group',
				'type'     => Group_Control_Typography::get_type(),
				'label'    => __( 'Typography', 'cirkle-core' ),
				'selector' => '{{WRAPPER}} .hero-banner .item-title',
			),

			// Description
			array(
				'id'      => 'desc_heading',
				'type' => Controls_Manager::HEADING,
				'label'   => __( 'Description', 'cirkle-core' ),
				'separator' => 'before',
			),
			array(
				'id'      => 'desc_color',
				'type'    => Controls_Manager::COLOR,
				'label'   => __( 'Color', 'cirkle-core' ),
				'default' => '',
				'selectors' => array( 
					'{{WRAPPER}} .hero-content p' => 'color: {{VALUE}}',
				),
			),
			array(
				'name'     => 'desc_typo',
				'mode'     => 'group',
				'type'     => Group_Control_Typography::get_type(),
				'label'    => __( 'Typography', 'cirkle-core' ),
				'selector' => '{{WRAPPER}} .hero-content p',
			),

			// Number
			array(
				'id'      => 'number_heading',
				'type' => Controls_Manager::HEADING,
				'label'   => __( 'Number', 'cirkle-core' ),
				'separator' => 'before',
			),
			array(
				'id'      => 'number_color',
				'type'    => Controls_Manager::COLOR,
				'label'   => __( 'Color', 'cirkle-core' ),
				'selectors' => array( 
					'{{WRAPPER}} .hero-banner .item-number' => 'color: {{VALUE}}',
				),
			),
			array(
				'name'     => 'number_typo',
				'mode'     => 'group',
				'type'     => Group_Control_Typography::get_type(),
				'label'    => __( 'Typography', 'cirkle-core' ),
				'selector' => '{{WRAPPER}} .hero-banner .item-number',
			),

			// Number Text
			array(
				'id'      => 'number_text_heading',
				'type' => Controls_Manager::HEADING,
				'label'   => __( 'Number', 'cirkle-core' ),
				'separator' => 'before',
			),
			array(
				'id'      => 'number_text_color',
				'type'    => Controls_Manager::COLOR,
				'label'   => __( 'Color', 'cirkle-core' ),
				'selectors' => array( 
					'{{WRAPPER}} .hero-banner .conn-people' => 'color: {{VALUE}}',
				),
			),
			array(
				'name'     => 'number_text_typo',
				'mode'     => 'group',
				'type'     => Group_Control_Typography::get_type(),
				'label'    => __( 'Typography', 'cirkle-core' ),
				'selector' => '{{WRAPPER}} .hero-banner .conn-people',
			),

			// Button
			array(
				'id'      => 'button_heading',
				'type' => Controls_Manager::HEADING,
				'label'   => __( 'Button', 'cirkle-core' ),
				'separator' => 'before',
			),
			array(
				'id'      => 'button_color',
				'type'    => Controls_Manager::COLOR,
				'label'   => __( 'Color', 'cirkle-core' ),
				'selectors' => array( 
					'{{WRAPPER}} .hero-banner .button-slide' => 'color: {{VALUE}}',
				),
			),
			array(
				'name'     => 'button_typo',
				'mode'     => 'group',
				'type'     => Group_Control_Typography::get_type(),
				'label'    => __( 'Typography', 'cirkle-core' ),
				'selector' => '{{WRAPPER}} .hero-banner .button-slide',
			),
			array(
				'name'     => 'button_bg_color',
				'mode'     => 'group',
				'type'     => Group_Control_Typography::get_type(),
				'label'    => __( 'Background Color', 'cirkle-core' ),
				'selector' => '{{WRAPPER}} .button-slide:after',
			),
			array(
				'id'      => 'button_border_heading',
				'type' => Controls_Manager::HEADING,
				'label'   => __( 'Button Border', 'cirkle-core' ),
				'separator' => 'before',
			),
			array(
				'name'     => 'btn_border',
				'mode'     => 'group',
				'type'     => Group_Control_Border::get_type(),
				'label'    => __( 'Border', 'cirkle-core' ),
				'selector' => '{{WRAPPER}} .hero-banner .button-slide',
			),
			array(
				'mode' => 'section_end',
			),
		);
		return $fields;
	}

	public function swiper(){
		wp_enqueue_style( 'swiper' );
		wp_enqueue_script( 'swiper' );
		wp_enqueue_script( 'swiper-func' );
	}

	protected function render() {
		$data = $this->get_settings();
		$this->swiper();	

		$template = 'view';

		return $this->rt_template( $template, $data );
	}
}