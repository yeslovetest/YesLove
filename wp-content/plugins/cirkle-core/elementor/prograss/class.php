<?php
/**
 * This file can be overridden by copying it to yourtheme/elementor-custom/prograssbar/class.php
 * 
 * @author  RadiusTheme
 * @since   1.0
 * @version 1.0
 */

namespace radiustheme\Cirkle_Core;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;

if ( ! defined( 'ABSPATH' ) ) exit;

class Rt_Prograss extends Custom_Widget_Base {

	public function __construct( $data = [], $args = null ){
		$this->rt_name = __( 'Prograss', 'cirkle-core' );
		$this->rt_base = 'rt-prograss';
		parent::__construct( $data, $args );
	}

	public function rt_fields(){

		$fields = array(
			array(
				'mode'    => 'section_start',
				'id'      => 'sec_general',
				'label'   => esc_html__( 'General', 'cirkle-core' ),
			),
			array(
				'id'      => 'icon',
				'type'    => Controls_Manager::ICON,
				'label'   => __( 'Icon', 'cirkle-core' ),
				'label_block' => true,
			),
			array(
				'id'      => 'title',
				'type'    => Controls_Manager::TEXT,
				'label'   => __( 'Title', 'cirkle-core' ),
				'label_block' => true,
			),
			array(
				'id'      => 'text',
				'type'    => Controls_Manager::TEXT,
				'label'   => __( 'Text', 'cirkle-core' ),
				'label_block' => true,
			),
			array(
				'mode' => 'section_end',
			),


			// Icon
			array(
				'id'      => 'icon_style',
				'mode'    => 'section_start',
				'label'   => esc_html__( 'Icon', 'clenix-core' ),
				'tab'     => Controls_Manager::TAB_STYLE,
			),
			array(
				'id'        => 'icon_heading',
				'type'      => Controls_Manager::HEADING,
				'label'     => __( 'Style', 'cirkle-core' ),
				'separator' => 'before',
			),
			array(
				'id'        => 'icon_color',
				'type'      => Controls_Manager::COLOR,
				'label'     => esc_html__( 'Icon Color', 'clenix-core' ),
				'selectors' => array(
					'{{WRAPPER}} .progress-box .media .item-icon' => 'color: {{VALUE}}',
				),
			),
			array(
				'type'      => Controls_Manager::NUMBER,
				'id'        => 'icon_size',
				'label'     => esc_html__( 'Icon Size', 'clenix-core' ),
				'selectors' => array(
					'{{WRAPPER}} .progress-box .media .item-icon' => 'font-size: {{VALUE}}px',
				),
				'description' => esc_html__( 'Icon size default: 36px', 'clenix-core' ),
			),
			array(
				'mode' => 'section_end',
			),

			// Title
			array(
				'id'      => 'title_style',
				'mode'    => 'section_start',
				'label'   => esc_html__( 'Title', 'clenix-core' ),
				'tab'     => Controls_Manager::TAB_STYLE,
			),
			array(
				'type'    => Controls_Manager::COLOR,
				'id'      => 'title_color',
				'label'   => esc_html__( 'Color', 'clenix-core' ),
				'default' => '',
				'selectors' => array(
					'{{WRAPPER}} .progress-box .media .item-title' => 'color: {{VALUE}}',
				),
			),
			array(
				'name'     => 'title_typo',
				'mode'     => 'group',
				'type'     => Group_Control_Typography::get_type(),
				'label'    => __( 'Typography', 'cirkle-core' ),
				'selector' => '{{WRAPPER}} .progress-box .media .item-title',
			),
			array(
				'mode' => 'section_end',
			),

			// Text
			array(
				'id'      => 'text_style',
				'mode'    => 'section_start',
				'label'   => esc_html__( 'Text', 'clenix-core' ),
				'tab'     => Controls_Manager::TAB_STYLE,
			),
			array(
				'type'    => Controls_Manager::COLOR,
				'id'      => 'text_color',
				'label'   => esc_html__( 'Color', 'clenix-core' ),
				'default' => '',
				'selectors' => array(
					'{{WRAPPER}} .progress-box .media .item-subtitle' => 'color: {{VALUE}}',
				),
			),
			array(
				'name'     => 'text_typo',
				'mode'     => 'group',
				'type'     => Group_Control_Typography::get_type(),
				'label'    => __( 'Typography', 'cirkle-core' ),
				'selector' => '{{WRAPPER}} .progress-box .media .item-subtitle',
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