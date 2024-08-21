<?php
/**
 * This file can be overridden by copying it to yourtheme/elementor-custom/locations/class.php
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

class Rt_Locations extends Custom_Widget_Base {

	public function __construct( $data = [], $args = null ){
		$this->rt_name = __( 'Locations', 'cirkle-core' );
		$this->rt_base = 'rt-locations-list';
		parent::__construct( $data, $args );
	}

	public function rt_fields(){

		$repeater = new \Elementor\Repeater();
		$repeater->add_control(
			'location_image', [
				'type'    => \Elementor\Controls_Manager::MEDIA,
				'label'   => esc_html__( 'Image', 'cirkle-core' ),
				'show_label' => false,
			]
		);

		$fields = array(
			array(
				'mode'    => 'section_start',
				'id'      => 'sec_locations',
				'label'   => esc_html__( 'Locations', 'cirkle-core' ),
			),
			array(
				'type'    => Controls_Manager::REPEATER,
				'id'      => 'rt_locations_list',
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
				'label'   => __( 'Background Color', 'fototag-core' ),
			),
			array(
				'name'     => 'icon_bgcolor',
				'mode'     => 'group',
				'type'     => Group_Control_Background::get_type(),
				'label'    => __( 'Background Color', 'cirkle-core' ),
				'selector' => '{{WRAPPER}} .community-network .map-marker li:after',
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