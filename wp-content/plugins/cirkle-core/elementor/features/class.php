<?php
/**
 * This file can be overridden by copying it to yourtheme/elementor-custom/lists/class.php
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

class Rt_Features extends Custom_Widget_Base {

	public function __construct( $data = [], $args = null ){
		$this->rt_name = __( 'Features List', 'cirkle-core' );
		$this->rt_base = 'rt-features-list';
		parent::__construct( $data, $args );
	}

	public function rt_fields(){

		$repeater = new \Elementor\Repeater();
		$repeater->add_control(
			'list_icon', [
				'type'    => Controls_Manager::ICON,
				'label'   => esc_html__( 'Icon', 'cirkle-core' ),
				'default' => 'icofont-wechat',
				'label_block' => true,
			]
		);
		$repeater->add_control(
			'list_title', [
				'type'    => Controls_Manager::TEXT,
				'label'   => esc_html__( 'Title', 'cirkle-core' ),
				'label_block' => true,
			]
		);
		$repeater->add_control(
			'list_text', [
				'type'    => Controls_Manager::TEXTAREA,
				'label'   => esc_html__( 'List Text', 'cirkle-core' ),
				'label_block' => true,
			]
		);

		$fields = array(
			array(
				'mode'    => 'section_start',
				'id'      => 'sec_features',
				'label'   => esc_html__( 'Feature List', 'fototag-core' ),
			),
			array(
				'type'    => Controls_Manager::REPEATER,
				'id'      => 'rt_feature_list',
				'label'   => esc_html__( 'Add many list as you want', 'cirkle-core' ),
				'fields' => $repeater->get_controls(),
			),
			array(
				'mode' => 'section_end',
			),

			// Style
			array(
				'id'      => 'icon_style',
				'mode'    => 'section_start',
				'tab'     => Controls_Manager::TAB_STYLE,
				'label'   => __( 'Icon', 'fototag-core' ),
			),
			array(
				'id'      => 'icon_heading',
				'type' => Controls_Manager::HEADING,
				'label'   => __( 'Normal', 'fototag-core' ),
				'separator' => 'before',
			),
			array(
				'id'      => 'icon_color',
				'type'    => Controls_Manager::COLOR,
				'label'   => __( 'Color', 'fototag-core' ),
				'selectors' => array( 
					'{{WRAPPER}} .why-choose-box .features-list .item-icon' => 'color: {{VALUE}} !important'
				),
			),
			array(
				'name'     => 'icon_bgcolor',
				'mode'     => 'group',
				'type'     => Group_Control_Background::get_type(),
				'label'    => __( 'Background Color', 'cirkle-core' ),
				'selector' => '{{WRAPPER}} .why-choose-box .features-list .item-icon',
			),
			array(
				'id'      => 'icon_h_heading',
				'type' => Controls_Manager::HEADING,
				'label'   => __( 'Hover', 'cirkle-core' ),
				'separator' => 'before',
			),
			array(
				'id'      => 'icon_h_color',
				'type'    => Controls_Manager::COLOR,
				'label'   => __( 'Color', 'cirkle-core' ),
				'selectors' => array( 
					'{{WRAPPER}} .features-list .media:hover .item-icon' => 'color: {{VALUE}}'
				),
			),
			array(
				'name'     => 'icon_hbgcolor',
				'mode'     => 'group',
				'type'     => Group_Control_Background::get_type(),
				'label'    => __( 'Background Color', 'cirkle-core' ),
				'selector' => '{{WRAPPER}} .features-list .media:hover .item-icon',
			),
			array(
				'mode' => 'section_end',
			),

			// Title Style
			array(
				'id'      => 'title_style',
				'mode'    => 'section_start',
				'tab'     => Controls_Manager::TAB_STYLE,
				'label'   => __( 'Title', 'cirkle-core' ),
			),
			array(
				'id'      => 'title_color',
				'type'    => Controls_Manager::COLOR,
				'label'   => __( 'Color', 'cirkle-core' ),
				'selectors' => array( 
					'{{WRAPPER}} .why-choose-box .features-list .media-body .item-title' => 'color: {{VALUE}}'
				),
			),
			array(
				'name'     => 'title_typo',
				'mode'     => 'group',
				'type'     => Group_Control_Typography::get_type(),
				'label'    => __( 'Typography', 'cirkle-core' ),
				'selector' => '{{WRAPPER}} .why-choose-box .features-list .media-body .item-title',
			),
			array(
				'id'      => 'title_h_heading',
				'type' => Controls_Manager::HEADING,
				'label'   => __( 'Hover', 'cirkle-core' ),
				'separator' => 'before',
			),
			array(
				'id'      => 'title_h_color',
				'type'    => Controls_Manager::COLOR,
				'label'   => __( 'Color', 'cirkle-core' ),
				'selectors' => array( 
					'{{WRAPPER}} .why-choose-box .features-list .media-body:hover .item-title' => 'color: {{VALUE}}'
				),
			),
			array(
				'mode' => 'section_end',
			),

			// Text Style
			array(
				'id'      => 'text_style',
				'mode'    => 'section_start',
				'tab'     => Controls_Manager::TAB_STYLE,
				'label'   => __( 'Text', 'cirkle-core' ),
			),
			array(
				'id'      => 'text_heading',
				'type' => Controls_Manager::HEADING,
				'label'   => __( 'Text', 'fototag-core' ),
				'separator' => 'before',
			),
			array(
				'id'      => 'text_color',
				'type'    => Controls_Manager::COLOR,
				'label'   => __( 'Color', 'fototag-core' ),
				'selectors' => array( '{{WRAPPER}} .features-list .media-body p' => 'color: {{VALUE}}' ),
			),
			array(
				'name'     => 'text_typo',
				'mode'     => 'group',
				'type'     => Group_Control_Typography::get_type(),
				'label'    => __( 'Typography', 'fototag-core' ),
				'selector' => '{{WRAPPER}} .features-list .media-body p',
			),
			array(
				'mode' => 'section_end',
			),
		);
		return $fields;
	}

	public function slick(){
		wp_enqueue_script( 'slick' );
	}

	protected function render() {
		$data = $this->get_settings();
		$this->slick();
		
		$template = 'view';

		return $this->rt_template( $template, $data );
	}
}