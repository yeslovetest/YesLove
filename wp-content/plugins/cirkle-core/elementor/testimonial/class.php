<?php
/**
 * This file can be overridden by copying it to yourtheme/elementor-custom/testimonial/class.php
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

class Rt_Testimonial extends Custom_Widget_Base {

	public function __construct( $data = [], $args = null ){
		$this->rt_name = __( 'Testimonial', 'cirkle-core' );
		$this->rt_base = 'rt-testimonial';
		parent::__construct( $data, $args );
	}

	public function rt_fields(){

		$repeater = new \Elementor\Repeater();
		$repeater->add_control(
			'picture', [
				'type'    => \Elementor\Controls_Manager::MEDIA,
				'label'   => esc_html__( 'Picture', 'cirkle-core' ),
				'default' => [
	                'url' => $this->rt_placeholder_image(),
	            ],
				'description' => esc_html__( 'Image size should be 105px', 'cirkle-core' ),
				'show_label' => false,
			]
		);
		$repeater->add_control(
			'testi_name', [
				'label' => __( 'Name', 'cirkle-core' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => __( 'Testimonial Name' , 'cirkle-core' ),
				'label_block' => true,
			]
		);
		$repeater->add_control(
			'testi_desig', [
				'label' => __( 'Designation', 'cirkle-core' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => 'Testimonial Designation',
				'label_block' => true,
			]
		);
		$repeater->add_control(
			'content', [
				'label' => __( 'Testimonial Text', 'cirkle-core' ),
				'type' => \Elementor\Controls_Manager::TEXTAREA,
				'default' => '“ Tesorem ipsum dolor sit amet consectetur adipiscing elit consectetur adipiscing elit. ” ',
				'label_block' => true,
			]
		);

		$fields1 = array(
			array(
				'mode'    => 'section_start',
				'id'      => 'sec_general',
				'label'   => esc_html__( 'Testimonial Items', 'cirkle-core' ),
			),
			array(
				'id'      => 'cols',
				'label'   => esc_html__( 'Grid Columns', 'cirkle-core' ),
				'type'    => Controls_Manager::SELECT2,
				'options' => $this->rt_grid_options(),
				'default' => '6',
				'label_block' => true,
				'condition'   => array( 'layout' => array( 'grid' ) ),
			),
			array(
				'type'    => Controls_Manager::REPEATER,
				'id'      => 'testimonials',
				'label'   => esc_html__( 'Add as many slides as you want', 'cirkle-core' ),
				'fields' => $repeater->get_controls(),
				'default' => array(
					array( 'testi_name' => 'Vintage Alaski', 'testi_desig' => 'Architect', 'content' => 'There are many variations of passages of Lorem that available but the majority have suffered alteration in the words which slightly believable.' ),
					array( 'testi_name' => 'Victoria Vargas', 'testi_desig' => 'Architect', 'content' => 'There are many variations of passages of Lorem that available but the majority have suffered alteration in the words which slightly believable.' ),
				),
				'title_field' => '{{{ testi_name }}}',
			),

			array(
				'mode' => 'section_end',
			),
		);

		$repeater2 = new \Elementor\Repeater();
		$repeater2->add_control(
			'shape', [
				'type'    => \Elementor\Controls_Manager::MEDIA,
				'label'   => esc_html__( 'Picture', 'cirkle-core' ),
				'default' => [
	                'url' => $this->rt_placeholder_image(),
	            ],
				'description' => esc_html__( 'Image size should be 105px', 'cirkle-core' ),
				'show_label' => false,
			]
		);

		$fields2 = array(
			array(
				'mode'    => 'section_start',
				'id'      => 'sec_shape',
				'label'   => esc_html__( 'Animation Shape', 'cirkle-core' ),
			),
			
			array(
				'type'    => Controls_Manager::REPEATER,
				'id'      => 'shape_list',
				'label'   => esc_html__( 'Add as many slides as you want', 'cirkle-core' ),
				'fields' => $repeater2->get_controls(),
			),

			array(
				'mode' => 'section_end',
			),
		);


		$fields3 = array(
			array(
				'mode'        => 'section_start',
				'id'          => 'sec_slider',
				'label'       => esc_html__( 'Slider Options', 'cirkle-core' ),
			),
			array(
				'type'        => Controls_Manager::SWITCHER,
				'id'          => 'slider_fade',
				'label'       => esc_html__( 'Fade', 'cirkle-core' ),
				'label_on'    => esc_html__( 'On', 'cirkle-core' ),
				'label_off'   => esc_html__( 'Off', 'cirkle-core' ),
				'description' => esc_html__( 'Enable or disable fade. Default: Off', 'cirkle-core' ),
			),
			array(
				'type'        => Controls_Manager::SWITCHER,
				'id'          => 'slider_autoplay',
				'label'       => esc_html__( 'Autoplay', 'cirkle-core' ),
				'label_on'    => esc_html__( 'On', 'cirkle-core' ),
				'label_off'   => esc_html__( 'Off', 'cirkle-core' ),
				'description' => esc_html__( 'Enable or disable autoplay. Default: On', 'cirkle-core' ),
			),
			array(
				'type'    => Controls_Manager::SELECT2,
				'id'      => 'slider_autoplay_speed',
				'label'   => esc_html__( 'Autoplay Speed', 'cirkle-core' ),
				'options' => $this->rt_autoplay_speed(),
				'default' => '2000',
				'description' => esc_html__( 'Select any value for autopaly speed. Default: 2000', 'cirkle-core' ),
			),
			array(
				'type'        => Controls_Manager::SWITCHER,
				'id'          => 'slider_dots',
				'label'       => esc_html__( 'Dots', 'cirkle-core' ),
				'label_on'    => esc_html__( 'On', 'cirkle-core' ),
				'label_off'   => esc_html__( 'Off', 'cirkle-core' ),
				'description' => esc_html__( 'Enable or disable nav dots. Default: off', 'cirkle-core' ),
			),
			array(
				'type'        => Controls_Manager::SWITCHER,
				'id'          => 'slider_arrow',
				'label'       => esc_html__( 'Arrow', 'cirkle-core' ),
				'label_on'    => esc_html__( 'On', 'cirkle-core' ),
				'label_off'   => esc_html__( 'Off', 'cirkle-core' ),
				'description' => esc_html__( 'Enable or disable nav dots. Default: off', 'cirkle-core' ),
			),
			array(
				'type'    => Controls_Manager::SELECT2,
				'id'      => 'slide_to_show',
				'label'   => esc_html__( 'Slide To Show', 'cirkle-core' ),
				'options' => $this->rt_number_options(),
				'default' => '3',
				'description' => esc_html__( 'Select any value for desktop device show. Default: 3', 'cirkle-core' ),
			),
			array(
				'type'    => Controls_Manager::SELECT2,
				'id'      => 'slide_to_show_tab',
				'label'   => esc_html__( 'Tab View', 'cirkle-core' ),
				'options' => $this->rt_number_options(),
				'default' => '2',
				'description' => esc_html__( 'Select any value for tab device show. Default: 2', 'cirkle-core' ),
			),
			array(
				'type'    => Controls_Manager::SELECT2,
				'id'      => 'slide_to_show_mobile',
				'label'   => esc_html__( 'Mobile View', 'cirkle-core' ),
				'options' => $this->rt_number_options(),
				'default' => '1',
				'description' => esc_html__( 'Select any value for mobile device show. Default: 1', 'cirkle-core' ),
			),
			array(
				'type'    => Controls_Manager::SELECT2,
				'id'      => 'slide_to_show_small_mobile',
				'label'   => esc_html__( 'Mobile Small View', 'cirkle-core' ),
				'options' => $this->rt_number_options(),
				'default' => '1',
				'description' => esc_html__( 'Select any value for small mobile device show. Default: 1', 'cirkle-core' ),
			),
			array(
				'mode' => 'section_end',
			),

			// Style
			array(
				'id'      => 'testimonial_style',
				'mode'    => 'section_start',
				'tab'     => Controls_Manager::TAB_STYLE,
				'label'   => __( 'Style', 'cirkle-core' ),
			),
			// Name
			array(
				'id'      => 'name_heading',
				'type' => Controls_Manager::HEADING,
				'label'   => __( 'Name', 'cirkle-core' ),
				'separator' => 'before',
			),
			array(
				'id'      => 'name_color',
				'type'    => Controls_Manager::COLOR,
				'label'   => __( 'Color', 'cirkle-core' ),
				'selectors' => array( '{{WRAPPER}} .item-title' => 'color: {{VALUE}}' ),
			),
			array(
				'name'     => 'name_typo',
				'mode'     => 'group',
				'type'     => Group_Control_Typography::get_type(),
				'label'    => __( 'Typography', 'cirkle-core' ),
				'selector' => '{{WRAPPER}} .item-title',
			),
			// Designation
			array(
				'id'      => 'designation_heading',
				'type' => Controls_Manager::HEADING,
				'label'   => __( 'Designation', 'cirkle-core' ),
				'separator' => 'before',
			),
			array(
				'id'      => 'designation_color',
				'type'    => Controls_Manager::COLOR,
				'label'   => __( 'Color', 'cirkle-core' ),
				'selectors' => array( '{{WRAPPER}} .testimonial-content .item-subtitle' => 'color: {{VALUE}}' ),
			),
			array(
				'name'     => 'designation_typo',
				'mode'     => 'group',
				'type'     => Group_Control_Typography::get_type(),
				'label'    => __( 'Typography', 'cirkle-core' ),
				'selector' => '{{WRAPPER}} .testimonial-content .item-subtitle',
			),
			// Description
			array(
				'id'      => 'text_heading',
				'type' => Controls_Manager::HEADING,
				'label'   => __( 'Text', 'cirkle-core' ),
				'separator' => 'before',
			),
			array(
				'id'      => 'text_color',
				'type'    => Controls_Manager::COLOR,
				'label'   => __( 'Color', 'cirkle-core' ),
				'selectors' => array( '{{WRAPPER}} .testimonial-content p' => 'color: {{VALUE}}' ),
			),
			array(
				'name'     => 'text_typo',
				'mode'     => 'group',
				'type'     => Group_Control_Typography::get_type(),
				'label'    => __( 'Typography', 'cirkle-core' ),
				'selector' => '{{WRAPPER}} .item-paragraph',
			),
			array(
				'mode' => 'section_end',
			),
		);

		$fields = array_merge( $fields1, $fields2, $fields3 );

		return $fields;
	}

	protected function render() {
		$data = $this->get_settings();
		
		$template = 'view';


		return $this->rt_template( $template, $data );
	}
}