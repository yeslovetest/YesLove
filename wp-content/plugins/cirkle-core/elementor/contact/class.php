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

class Rt_Contact extends Custom_Widget_Base {

	public function __construct( $data = [], $args = null ){
		$this->rt_name = __( 'Contact', 'cirkle-core' );
		$this->rt_base = 'rt-contact';
		parent::__construct( $data, $args );
	}

	public function rt_fields(){

		$repeater = new \Elementor\Repeater();
		$repeater->add_control(
			'icon', [
				'label'       => __( 'Icon', 'cirkle-core' ),
				'type'        => Controls_Manager::ICON,
				'label_block' => true,
			]
		);
		$repeater->add_control(
			'text', [
				'type'        => Controls_Manager::TEXT,
				'label'       => __( 'List Title', 'cirkle-core' ),
				'label_block' => true,
			]						
		);

		$fields = array(
			array(
				'mode'    => 'section_start',
				'id'      => 'sec_contact',
				'label'   => esc_html__( 'Contact', 'cirkle-core' ),
			),
			array(
				'id'      => 'title',
				'type'    => Controls_Manager::TEXT,
				'label'   => __( 'Form Title', 'cirkle-core' ),
				'label_block' => true,
			),
			array(
				'id'      => 'shortcode',
				'type'    => Controls_Manager::TEXT,
				'label'   => __( 'Form Shortcode', 'cirkle-core' ),
				'label_block' => true,
			),
			array(
				'id'      => 'list_title',
				'type'    => Controls_Manager::TEXT,
				'label'   => __( 'List Title', 'cirkle-core' ),
				'label_block' => true,
			),
			array(
				'type'    => Controls_Manager::REPEATER,
				'id'      => 'rt_contact_list',
				'label'   => esc_html__( 'Add many shape as you want', 'cirkle-core' ),
				'fields' => $repeater->get_controls(),
				'title_field' => '{{{ text }}}',
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