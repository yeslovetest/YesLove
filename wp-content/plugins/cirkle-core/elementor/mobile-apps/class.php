<?php
/**
 * This file can be overridden by copying it to yourtheme/elementor-custom/mobile-apps/class.php
 * 
 * @author  RadiusTheme
 * @since   1.0
 * @version 1.0
 */

namespace radiustheme\Cirkle_Core;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Background;

if ( ! defined( 'ABSPATH' ) ) exit;

class Rt_Mobile_Apps extends Custom_Widget_Base {

	public function __construct( $data = [], $args = null ){
		$this->rt_name = __( 'Mobile Apps', 'cirkle-core' );
		$this->rt_base = 'rt-mobile-apps';
		parent::__construct( $data, $args );
	}

	public function rt_fields(){
		$fields = array(
			array(
				'id'      => 'sec_mf',
				'mode'    => 'section_start',
				'label'   => __( 'Mobile Apps', 'cirkle-core' ),
			),

			// Title
			array(
				'id'      => 'apps_img',
				'type'    => Controls_Manager::MEDIA,
				'label'   => __( 'App Image', 'cirkle-core' ),
				'label_block' => true,
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