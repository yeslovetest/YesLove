<?php
/**
 * This file can be overridden by copying it to yourtheme/elementor-custom/chooseus/class.php
 * 
 * @author  RadiusTheme
 * @since   1.0
 * @version 1.0
 */

namespace radiustheme\Cirkle_Core;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Background;

if ( ! defined( 'ABSPATH' ) ) exit;

class Rt_Chooseus extends Custom_Widget_Base {

	public function __construct( $data = [], $args = null ){
		$this->rt_name = __( 'Why Choose Us', 'cirkle-core' );
		$this->rt_base = 'rt-chooseus';
		parent::__construct( $data, $args );
	}

	public function rt_fields(){
		$fields = array(
			array(
				'id'      => 'sec_chooseus',
				'mode'    => 'section_start',
				'label'   => __( 'Choose Us', 'cirkle-core' ),
			),

			// Title
			array(
				'id'      => 'title',
				'type'    => Controls_Manager::TEXT,
				'label'   => __( 'Title', 'cirkle-core' ),
				'default' => 'Section Title',
				'label_block' => true,
			),
			array(
				'id'      => 'heading_tag',
				'mode'    => 'responsive',
				'type'    => Controls_Manager::SELECT,
				'label'   => __( 'HTML Tag', 'cirkle-core' ),
				'options' => [
					'h1' => 'H1',
					'h2' => 'H2',
					'h3' => 'H3',
					'h4' => 'H4',
					'h5' => 'H5',
					'h6' => 'H6',
				],
				'default' => 'h2',
			),
			array(
				'id'      => 'align',
				'mode'    => 'responsive',
				'type'    => Controls_Manager::CHOOSE,
				'label'   => __( 'Title Alignment', 'cirkle-core' ),
				'options' => $this->rt_alignment_options(),
				'default' => 'center',
				'selectors' => [
					'{{WRAPPER}} ' => 'text-align: {{VALUE}};',
				],
			),
			// Description
			array(
				'id'      => 'desc',
				'type'    => Controls_Manager::WYSIWYG,
				'label'   => __( 'Description', 'cirkle-core' ),
				'label_block' => true,
			),
			array(
				'type'    => Controls_Manager::TEXT,
				'id'      => 'btntext',
				'label'   => __( 'Text', 'cirkle-core' ),
				'default' => 'Lorem Ipsum',
				'label_block' => true,
			),
			array(
				'id'    => 'btnurl',
				'type'  => Controls_Manager::URL,
				'label' => __( 'Link', 'cirkle-core' ),
				'placeholder' => 'https://your-link.com',
			),
			array(
				'id'    => 'side_image',
				'type'    => Controls_Manager::MEDIA,
				'label'   => esc_html__( 'Side image', 'cirkle-core' ),
				'label_block' => true,
			),
			array(
				'id'    => 'bg_image',
				'type'    => Controls_Manager::MEDIA,
				'label'   => esc_html__( 'Background image', 'cirkle-core' ),
				'label_block' => true,
			),

			array(
				'mode' => 'section_end',
			),
			// Style
			array(
				'id'      => 'sec_style',
				'mode'    => 'section_start',
				'tab'     => Controls_Manager::TAB_STYLE,
				'label'   => __( 'Style', 'cirkle-core' ),
			),
			// Title Style
			array(
				'id'      => 'title_heading',
				'type' => Controls_Manager::HEADING,
				'label'   => __( 'Title Style', 'cirkle-core' ),
				'separator' => 'before',
			),
			array(
				'id'      => 'title_color',
				'type'    => Controls_Manager::COLOR,
				'label'   => __( 'Color', 'cirkle-core' ),
				'selectors' => array( 
					'{{WRAPPER}} .content-box .item-title' => 'color: {{VALUE}}'
				),
			),
			array(
				'name'     => 'title_typo',
				'mode'     => 'group',
				'type'     => Group_Control_Typography::get_type(),
				'label'    => __( 'Typography', 'cirkle-core' ),
				'selector' => '{{WRAPPER}} .content-box .item-title',
			),
			// Description
			array(
				'id'      => 'desc_heading',
				'type' => Controls_Manager::HEADING,
				'label'   => __( 'Description Style', 'cirkle-core' ),
				'separator' => 'before',
			),
			array(
				'id'      => 'desc_color',
				'type'    => Controls_Manager::COLOR,
				'label'   => __( 'Color', 'cirkle-core' ),
				'selectors' => array( 
					'{{WRAPPER}} .content-box p' => 'color: {{VALUE}}'
				),
			),
			array(
				'name'     => 'desc_typo',
				'mode'     => 'group',
				'type'     => Group_Control_Typography::get_type(),
				'label'    => __( 'Typography', 'cirkle-core' ),
				'selector' => '{{WRAPPER}} .content-box p',
			),
			array(
				'mode' => 'section_end',
			),


			// Style
			array(
				'id'      => 'button_style',
				'mode'    => 'section_start',
				'tab'     => Controls_Manager::TAB_STYLE,
				'label'   => __( 'Button Style', 'cirkle-core' ),
			),
			array(
				'id'      => 'text_color',
				'type'    => Controls_Manager::COLOR,
				'label'   => __( 'Color', 'cirkle-core' ),
				'selectors' => array( 
					'{{WRAPPER}} a.button-slide' => 'color: {{VALUE}}',
				),
			),
			array(
				'name'     => 'button_typo',
				'mode'     => 'group',
				'type'     => Group_Control_Typography::get_type(),
				'label'    => __( 'Typography', 'cirkle-core' ),
				'selector' => '{{WRAPPER}} a.button-slide',
			),
			array(
				'name'      => 'text_bg_color',
				'mode'     => 'group',
				'type'     => Group_Control_Background::get_type(),
				'label'    => __( 'Background', 'cirkle-core' ),
				'selector' => '{{WRAPPER}} a.button-slide:after',
			),
			array(
				'name'     => 'btn_border',
				'mode'     => 'group',
				'type'     => Group_Control_Border::get_type(),
				'label'    => __( 'Border', 'cirkle-core' ),
				'selector' => '{{WRAPPER}} a.button-slide',
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