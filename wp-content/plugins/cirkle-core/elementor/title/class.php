<?php
/**
 * This file can be overridden by copying it to yourtheme/elementor-custom/title/class.php
 * 
 * @author  RadiusTheme
 * @since   1.0
 * @version 1.0
 */

namespace radiustheme\Cirkle_Core;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Background;

if ( ! defined( 'ABSPATH' ) ) exit;

class Rt_Title extends Custom_Widget_Base {

	public function __construct( $data = [], $args = null ){
		$this->rt_name = __( 'Section Title', 'cirkle-core' );
		$this->rt_base = 'rt-title';
		parent::__construct( $data, $args );
	}

	public function rt_fields(){
		$fields = array(
			array(
				'id'      => 'sec_general',
				'mode'    => 'section_start',
				'label'   => __( 'General', 'cirkle-core' ),
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
				'default' => 'left',
			),
			// Sub Title
			array(
				'id'      => 'subtitle',
				'type'    => Controls_Manager::TEXT,
				'label'   => __( 'Sub Title', 'cirkle-core' ),
				'default' => 'Section Sub Title',
				'label_block' => true,
			),
			// Description
			array(
				'id'      => 'desc',
				'type'    => Controls_Manager::WYSIWYG,
				'label'   => __( 'Description', 'cirkle-core' ),
				'label_block' => true,
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
					'{{WRAPPER}} .section-heading .item-title' => 'color: {{VALUE}}'
				),
			),
			array(
				'name'     => 'title_typo',
				'mode'     => 'group',
				'type'     => Group_Control_Typography::get_type(),
				'label'    => __( 'Typography', 'cirkle-core' ),
				'selector' => '{{WRAPPER}} .section-heading .item-title',
			),
			array(
			    'id'      => 'title_margin',
			    'mode' 	  => 'responsive',
			    'type'    => Controls_Manager::DIMENSIONS,
			    'size_units' => [ 'px', '%', 'em' ],
			    'label'   => esc_html__( 'Margin', 'bizcon-core' ),                 
			    'selectors' => array(
			        '{{WRAPPER}} .section-heading .item-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',                    
			    ),
			),
			// Sub Title
			array(
				'id'      => 'subtitle_heading',
				'type' => Controls_Manager::HEADING,
				'label'   => __( 'Sub Title Style', 'cirkle-core' ),
				'separator' => 'before',
			),
			array(
				'id'      => 'subtitle_color',
				'type'    => Controls_Manager::COLOR,
				'label'   => __( 'Color', 'cirkle-core' ),
				'selectors' => array( 
					'{{WRAPPER}} .section-heading .item-subtitle' => 'color: {{VALUE}}'
				),
			),
			array(
				'name'     => 'subtitle_typo',
				'mode'     => 'group',
				'type'     => Group_Control_Typography::get_type(),
				'label'    => __( 'Typography', 'cirkle-core' ),
				'selector' => '{{WRAPPER}} .section-heading .item-subtitle',
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
					'{{WRAPPER}} .section-heading p' => 'color: {{VALUE}}'
				),
			),
			array(
				'name'     => 'desc_typo',
				'mode'     => 'group',
				'type'     => Group_Control_Typography::get_type(),
				'label'    => __( 'Typography', 'cirkle-core' ),
				'selector' => '{{WRAPPER}} .section-heading p',
			),
			// Link Url
			array(
				'id'      => 'link_heading',
				'type' => Controls_Manager::HEADING,
				'label'   => __( 'Link Style', 'cirkle-core' ),
				'separator' => 'before',
				'condition'   => array( 'style' => array( 'style4' ) ),
			),
			array(
				'id'      => 'link_color',
				'type'    => Controls_Manager::COLOR,
				'label'   => __( 'Color', 'cirkle-core' ),
				'selectors' => array( 
					'{{WRAPPER}} .project-content .item-btn' => 'color: {{VALUE}}'
				),
				'condition'   => array( 'style' => array( 'style4' ) ),
			),
			array(
				'name'     => 'link_typo',
				'mode'     => 'group',
				'type'     => Group_Control_Typography::get_type(),
				'label'    => __( 'Typography', 'cirkle-core' ),
				'selector' => '{{WRAPPER}} .project-content .item-btn',
				'condition'   => array( 'style' => array( 'style4' ) ),
			),
			array(
				'id'      => 'link_h_color',
				'type'    => Controls_Manager::COLOR,
				'label'   => __( 'Hover Color', 'cirkle-core' ),
				'selectors' => array(
					'{{WRAPPER}} .project-content .item-btn:hover' => 'color: {{VALUE}}'
				),
				'condition'   => array( 'style' => array( 'style4' ) ),
			),
			array(
				'mode' => 'section_end',
			),
		);
		return $fields;
	}

	protected function render() {
		$data = $this->get_settings();

		$template = 'view-1';

		return $this->rt_template( $template, $data );
	}
}