<?php
/**
 * This file can be overridden by copying it to yourtheme/elementor-custom/members/class.php
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

class Rt_Member extends Custom_Widget_Base {

	public function __construct( $data = [], $args = null ){
		$this->rt_name = __( 'Member', 'cirkle-core' );
		$this->rt_base = 'rt-member';
		parent::__construct( $data, $args );
	}

	public function rt_fields(){

		$repeater = new \Elementor\Repeater();
		$repeater->add_control(
			'shape_image', [
				'type'    => \Elementor\Controls_Manager::MEDIA,
				'label'   => esc_html__( 'Image', 'cirkle-core' ),
				'show_label' => false,
			]
		);

		$fields = array(
			array(
				'id'      => 'sec_general',
				'mode'    => 'section_start',
				'label'   => __( 'Member', 'cirkle-core' ),
			),
			// Member Per Page
			array(
				'id'      => 'posts_per_page',
				'type'    => Controls_Manager::TEXT,
				'label'   => __( 'Member display here', 'cirkle-core' ),
				'default' => '6',
				'label_block' => true,
			),
			array(
				'type'    => Controls_Manager::REPEATER,
				'id'      => 'rt_anim_shape',
				'label'   => esc_html__( 'Add animation shape image as you want', 'cirkle-core' ),
				'fields' => $repeater->get_controls(),
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