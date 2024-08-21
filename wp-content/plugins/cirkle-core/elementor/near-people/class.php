<?php
/**
 * This file can be overridden by copying it to yourtheme/elementor-custom/near-people/class.php
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
use \Cirkle_Usermeta;

if ( ! defined( 'ABSPATH' ) ) exit;

class Rt_Near_People extends Custom_Widget_Base {

	public function __construct( $data = [], $args = null ){
		$this->rt_name = __( 'Near People', 'cirkle-core' );
		$this->rt_base = 'rt-near-people';
		parent::__construct( $data, $args );
	}

	public function rt_fields(){

		$fields = array(
			array(
				'mode'    => 'section_start',
				'id'      => 'sec_general',
				'label'   => esc_html__( 'General', 'cirkle-core' ),
			),
			// Image
			array(
				'id'      => 'location_img',
				'type'    => Controls_Manager::MEDIA,
				'label'   => esc_html__( 'BG Image', 'cirkle-core' ),
				'default' => [
                    'url' => $this->rt_placeholder_image(),
                ],
				'description' => esc_html__( 'Recommended full image', 'cirkle-core' ),
			),
			array(
				'id'   => 'user_country',
				'label'   => esc_html__( 'Country', 'cirkle-core' ),
				'type'    => Controls_Manager::SELECT2,
				'options' => Cirkle_Usermeta::user_locations(),
				'label_block' => true,
			),
			array(
				'id'   => 'user_state',
				'label'   => esc_html__( 'State/Region', 'cirkle-core' ),
				'type'    => Controls_Manager::SELECT2,
				'options' => [],
				'label_block' => true,
			),
			array(
				'mode' => 'section_end',
			),
			
			// Style
			array(
				'id'      => 'npl_style',
				'mode'    => 'section_start',
				'tab'     => Controls_Manager::TAB_STYLE,
				'label'   => __( 'Style', 'cirkle-core' ),
			),
			// Title
			array(
				'id'      => 'title_heading',
				'type' => Controls_Manager::HEADING,
				'label'   => __( 'Title', 'cirkle-core' ),
				'separator' => 'before',
			),
			array(
				'id'      => 'title_color',
				'type'    => Controls_Manager::COLOR,
				'label'   => __( 'Color', 'cirkle-core' ),
				'selectors' => array( '{{WRAPPER}} .item-content .item-title a' => 'color: {{VALUE}}' ),
			),
			array(
				'name'     => 'title_typo',
				'mode'     => 'group',
				'type'     => Group_Control_Typography::get_type(),
				'label'    => __( 'Typography', 'cirkle-core' ),
				'selector' => '{{WRAPPER}} .item-content .item-title a',
			),
			array(
				'id'      => 'title_h_color',
				'type'    => Controls_Manager::COLOR,
				'label'   => __( 'Hover Color', 'cirkle-core' ),
				'selectors' => array(
					'{{WRAPPER}} .item-content .item-title a:hover' => 'color: {{VALUE}}', 
					'{{WRAPPER}} .location-box:hover .item-content .item-title:before' => 'background-color: {{VALUE}} !important'
				),
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

// Current file ajax settings
$current_url=esc_url("//".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);

if( strpos( $current_url, 'action=elementor') == true ){
    add_action( 'wp_footer', function() {
        if ( ! defined( 'ELEMENTOR_VERSION' ) ) {
            return;
        }
        wp_enqueue_script( 'cirkle-near-people', CIRKLE_CORE_BASE_URL . 'assets/js/cirkle-near-people.js' , array(), '', true );
        // make the ajaxurl var available to the above script
        wp_localize_script( 'cirkle-near-people', 'CirkleCoreObj', array(
            'ajaxurl' => admin_url( 'admin-ajax.php' ),
            ) 
        );
    } );
}