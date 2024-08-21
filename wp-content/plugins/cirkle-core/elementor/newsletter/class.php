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
use Elementor\Group_Control_Background;

if ( ! defined( 'ABSPATH' ) ) exit;

class Rt_Newsletter extends Custom_Widget_Base {

	public function __construct( $data = [], $args = null ){
		$this->rt_name = __( 'Newsletter', 'cirkle-core' );
		$this->rt_base = 'rt-newsletter';
		parent::__construct( $data, $args );
	}

	public function rt_fields(){
		$repeater = new \Elementor\Repeater();
		$repeater->add_control(
			'rt_news_shape', [
				'type'    => Controls_Manager::MEDIA,
				'label'   => esc_html__( 'Image', 'cirkle-core' ),
				'label_block' => true,
			]
		);
		$fields = array(
			array(
				'mode'    => 'section_start',
				'id'      => 'sec_locations',
				'label'   => esc_html__( 'Newsletter', 'cirkle-core' ),
			),
			array(
				'id'      => 'title',
				'type'    => Controls_Manager::TEXT,
				'label'   => __( 'Title', 'cirkle-core' ),
				'label_block' => true,
			),
			array(
				'id'      => 'desc',
				'type'    => Controls_Manager::TEXTAREA,
				'label'   => __( 'Description', 'cirkle-core' ),
				'label_block' => true,
			),
			array(
				'id'      => 'shortcode',
				'type'    => Controls_Manager::TEXT,
				'label'   => __( 'Shortcode', 'cirkle-core' ),
				'label_block' => true,
			),
			array(
				'type'    => Controls_Manager::REPEATER,
				'id'      => 'rt_news_shape',
				'label'   => esc_html__( 'Add many shape as you want', 'cirkle-core' ),
				// 'fields'  => array(
				// 	array(
				// 		'type'    => Controls_Manager::MEDIA,
				// 		'name'    => 'shape_image',
				// 		'label'   => esc_html__( 'Image', 'cirkle-core' ),
				// 		'label_block' => true,
				// 	),
				// ),
				'fields' => $repeater->get_controls(),
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