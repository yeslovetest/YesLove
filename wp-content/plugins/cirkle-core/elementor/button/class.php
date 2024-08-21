<?php
/**
 *
 * This file can be overridden by copying it to yourtheme/elementor-custom/button/class.php
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

class Rt_Button extends Custom_Widget_Base {

	public function __construct( $data = [], $args = null ){
		$this->rt_name = esc_html__( 'Button', 'cirkle-core' );
		$this->rt_base = 'rt-button';
		parent::__construct( $data, $args );
	}

	public function rt_fields(){
		$fields = array(
			array(
				'mode'    => 'section_start',
				'id'      => 'sec_general',
				'label'   => __( 'General', 'cirkle-core' ),
			),
			array(
				'type'    => Controls_Manager::TEXT,
				'id'      => 'btntext',
				'label'   => __( 'Text', 'cirkle-core' ),
				'default' => 'Lorem Ipsum',
				'label_block' => true,
			),
			array(
				'type'  => Controls_Manager::URL,
				'id'    => 'url',
				'label' => __( 'Link', 'cirkle-core' ),
				'placeholder' => 'https://your-link.com',
			),
			array(
				'type'    => Controls_Manager::CHOOSE,
				'mode'    => 'responsive',
				'id'      => 'align',
				'label'   => __( 'Alignment', 'cirkle-core' ),
				'options' => $this->rt_alignment_options(),
				'prefix_class' => 'elementor-align-',
				'selectors' => [
					'{{WRAPPER}} .cirkle-btn' => 'text-align: {{VALUE}};',
				],
			),
			array(
				'mode' => 'section_end',
			),

			// Style
			array(
				'id'      => 'button_style',
				'mode'    => 'section_start',
				'tab'     => Controls_Manager::TAB_STYLE,
				'label'   => __( 'Style', 'cirkle-core' ),
			),
			array(
				'id'      => 'normal_heading',
				'type' => Controls_Manager::HEADING,
				'label'   => __( 'Button', 'cirkle-core' ),
				'separator' => 'before',
			),
			array(
				'id'      => 'text_color',
				'type'    => Controls_Manager::COLOR,
				'label'   => __( 'Color', 'cirkle-core' ),
				'selectors' => array( 
					'{{WRAPPER}} .cirkle-btn a' => 'color: {{VALUE}}',
				),
			),
			array(
				'name'     => 'button_typo',
				'mode'     => 'group',
				'type'     => Group_Control_Typography::get_type(),
				'label'    => __( 'Typography', 'cirkle-core' ),
				'selector' => '{{WRAPPER}} .cirkle-btn a',
			),
			array(
				'name'      => 'btn_bg_color',
				'mode'     => 'group',
				'type'     => Group_Control_Background::get_type(),
				'label'    => __( 'Background', 'cirkle-core' ),
				'selector' => '{{WRAPPER}} .button-slide',
			),
			array(
				'name'     => 'btn_border',
				'mode'     => 'group',
				'type'     => Group_Control_Border::get_type(),
				'label'    => __( 'Border', 'cirkle-core' ),
				'selector' => '{{WRAPPER}} .cirkle-btn a',
			),
			array(
				'id'      => 'icon_heading',
				'type' => Controls_Manager::HEADING,
				'label'   => __( 'Icon', 'cirkle-core' ),
				'separator' => 'before',
			),
			array(
				'name'      => 'icon_bg_color',
				'mode'     => 'group',
				'type'     => Group_Control_Background::get_type(),
				'label'    => __( 'Background', 'cirkle-core' ),
				'selector' => '{{WRAPPER}} .button-slide:after',
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