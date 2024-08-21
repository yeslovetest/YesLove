<?php
/**
 * This file can be overridden by copying it to yourtheme/elementor-custom/posts/class.php
 * 
 * @author  RadiusTheme
 * @since   1.0
 * @version 1.0
 */

namespace radiustheme\Cirkle_Core;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Background;

if ( ! defined( 'ABSPATH' ) ) exit;

class Rt_Post extends Custom_Widget_Base {

	public function __construct( $data = [], $args = null ){
		$this->rt_name = __( 'Posts', 'cirkle-core' );
		$this->rt_base = 'rt-post';
		parent::__construct( $data, $args );
	}

	public function rt_fields(){
		$fields = array(
			array(
				'id'      => 'sec_rt_post',
				'mode'    => 'section_start',
				'label'   => esc_html__( 'Posts', 'cirkle-core' ),
			),
			//Query Type
			array(
				'id'      => 'query_type',
				'type'    => Controls_Manager::SELECT2,
				'label'   => esc_html__( 'Get Posts by cats or title', 'evacon-core' ),
				'options' => array(
					'cats' => esc_html__( 'Posts by Categories', 'evacon-core' ),
					'titles' => esc_html__( 'Posts by Titles', 'evacon-core' ),
				),
				'label_block' => true,
			),
			array(
				'id'      => 'postbycats',
				'label'   => esc_html__( 'Posts By Title', 'evacon-core' ),
				'type'    => Controls_Manager::SELECT2,
				'options' => $this->rt_blog_categories(),
				'default' => '',
				'multiple' => true,
				'label_block' => true,
				'condition'   => array( 'query_type' => array( 'cats' ) ),
			),
			array(
				'id'      => 'postbytitle',
				'label'   => esc_html__( 'Posts By Title', 'evacon-core' ),
				'type'    => Controls_Manager::SELECT2,
				'options' => $this->rt_blog_posts_title(),
				'default' => '',
				'multiple' => true,
				'label_block' => true,
				'condition'   => array( 'query_type' => array( 'titles' ) ),
			),
			array(
				'id'      => 'orderby',
				'label'   => esc_html__( 'Order By', 'evacon-core' ),
				'type'    => Controls_Manager::SELECT,
				'options' => $this->rt_post_orderby(),
				'default' => 'date',
				'label_block' => true,
			),
			// Post per page
			array(
				'id'      => 'number',
				'label'   =>esc_html__( 'Total number of post Member', 'cirkle-core' ),
				'type'    => Controls_Manager::NUMBER,
				'default' => 3,
				'description' =>esc_html__( 'Write -1 to show all', 'cirkle-core' ),
				'label_block' => true,
			),
			array(
				'id'      => 'post_offset',
				'label'   =>esc_html__( 'Post Offset', 'cirkle-core' ),
				'type'    => Controls_Manager::NUMBER,
				'default' => 0,
				'description' =>esc_html__( 'offset means start showing post not from the first post', 'cirkle-core' ),
				'label_block' => true,
			),
			array(
				'id'      => 'excerpt',
				'label'   =>esc_html__( 'Content excerpt number', 'cirkle-core' ),
				'type'    => Controls_Manager::TEXT,
				'default' => '30',
				'label_block' => true,
				'condition'   => array( 'style' => array( 'style1' ) ),
			),
			array(
				'type'        => Controls_Manager::SWITCHER,
				'id'          => 'post_cat',
				'label'       => esc_html__( 'Category', 'cirkle-core' ),
				'label_on'    => esc_html__( 'On', 'cirkle-core' ),
				'label_off'   => esc_html__( 'Off', 'cirkle-core' ),
				'return_value' => 'on',
				'default' 	   => 'on',
				'description' => esc_html__( 'Enable or disable post category. Default: On', 'cirkle-core' ),
			),
			array(
				'type'        => Controls_Manager::SWITCHER,
				'id'          => 'post_date',
				'label'       => esc_html__( 'Date', 'cirkle-core' ),
				'label_on'    => esc_html__( 'On', 'cirkle-core' ),
				'label_off'   => esc_html__( 'Off', 'cirkle-core' ),
				'return_value' => 'on',
				'default' 	   => 'on',
				'description' => esc_html__( 'Enable or disable post date. Default: On', 'cirkle-core' ),
			),
			array(
				'type'        => Controls_Manager::SWITCHER,
				'id'          => 'post_admin',
				'label'       => esc_html__( 'Admin', 'cirkle-core' ),
				'label_on'    => esc_html__( 'On', 'cirkle-core' ),
				'label_off'   => esc_html__( 'Off', 'cirkle-core' ),
				'return_value' => 'on',
				'default' 	   => 'on',
				'description' => esc_html__( 'Enable or disable post admin. Default: On', 'cirkle-core' ),
				'condition'   => array( 'style' => array( 'style2' ) ),
			),
			array(
				'type'        => Controls_Manager::SWITCHER,
				'id'          => 'post_comments',
				'label'       => esc_html__( 'Comments', 'cirkle-core' ),
				'label_on'    => esc_html__( 'On', 'cirkle-core' ),
				'label_off'   => esc_html__( 'Off', 'cirkle-core' ),
				'return_value' => 'on',
				'default' 	   => 'on',
				'description' => esc_html__( 'Enable or disable post comments. Default: On', 'cirkle-core' ),
				'condition'   => array( 'style' => array( 'style1' ) ),
			),
			array(
				'id'      => 'cols',
				'label'   => esc_html__( 'Grid Columns', 'cirkle-core' ),
				'type'    => Controls_Manager::SELECT2,
				'options' => $this->rt_grid_options(),
				'default' => '4',
				'label_block' => true,
			),
			array(
				'type'    => Controls_Manager::SELECT2,
				'id'      => 'style',
				'label'   => esc_html__( 'Style', 'cirkle-core' ),
				'options' => array(
					'style1' => esc_html__( 'Layout 1', 'cirkle-core' ),
					'style2' => esc_html__( 'Layout 2', 'cirkle-core' ),
				),
				'default' => 'style1',
			),
			array(
				'mode' => 'section_end',
			),
			
			// Style
			array(
				'id'      => 'post_style',
				'mode'    => 'section_start',
				'tab'     => Controls_Manager::TAB_STYLE,
				'label'   => __( 'Style', 'cirkle-core' ),
			),
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
				'selectors' => array( '{{WRAPPER}} .blog-title a' => 'color: {{VALUE}} !important' ),
			),
			array(
				'name'     => 'title_typo',
				'mode'     => 'group',
				'type'     => Group_Control_Typography::get_type(),
				'label'    => __( 'Typography', 'cirkle-core' ),
				'selector' => '{{WRAPPER}} .blog-title a',
			),
			array(
				'id'      => 'title_h_heading',
				'type' => Controls_Manager::HEADING,
				'label'   => __( 'Title Hover', 'cirkle-core' ),
				'separator' => 'before',
			),
			array(
				'id'      => 'title_h_color',
				'type'    => Controls_Manager::COLOR,
				'label'   => __( 'Hover Color', 'cirkle-core' ),
				'selectors' => array( '{{WRAPPER}} .blog-title a:hover' => 'color: {{VALUE}} !important' ),
			),
			// Meta Date
			array(
				'id'      => 'meta_date_heading',
				'type' => Controls_Manager::HEADING,
				'label'   => __( 'Meta Date', 'cirkle-core' ),
				'separator' => 'before',
			),
			array(
				'id'      => 'meta_d_color',
				'type'    => Controls_Manager::COLOR,
				'label'   => __( 'Color', 'cirkle-core' ),
				'selectors' => array( 
					'{{WRAPPER}} .blog-box .blog-img .blog-date' => 'color: {{VALUE}} !important'
				),
			),
			array(
				'id'      => 'meta_dbg_color',
				'type'    => Controls_Manager::COLOR,
				'label'   => __( 'BG Color', 'cirkle-core' ),
				'selectors' => array( 
					'{{WRAPPER}} .blog-box .blog-img .blog-date' => 'background-color: {{VALUE}} !important'
				),
			),

			// Meta
			array(
				'id'      => 'meta_heading',
				'type' => Controls_Manager::HEADING,
				'label'   => __( 'Meta Style', 'cirkle-core' ),
				'separator' => 'before',
			),
			array(
				'id'      => 'meta_color',
				'type'    => Controls_Manager::COLOR,
				'label'   => __( 'Color', 'cirkle-core' ),
				'selectors' => array( 
					'{{WRAPPER}} .entry-meta li a' => 'color: {{VALUE}} !important'
				),
			),
			array(
				'name'     => 'meta_typo',
				'mode'     => 'group',
				'type'     => Group_Control_Typography::get_type(),
				'label'    => __( 'Typography', 'cirkle-core' ),
				'selector' => '{{WRAPPER}} .entry-meta li a',
			),
			array(
				'id'      => 'meta_h_heading',
				'type' => Controls_Manager::HEADING,
				'label'   => __( 'Meta Hover', 'cirkle-core' ),
				'separator' => 'before',
			),
			array(
				'id'      => 'meta_h_color',
				'type'    => Controls_Manager::COLOR,
				'label'   => __( 'Color', 'cirkle-core' ),
				'selectors' => array( '{{WRAPPER}} .entry-meta li a:hover' => 'color: {{VALUE}} !important' ),
			),
			
		);
		return $fields;
	}

	protected function render() {
		$data = $this->get_settings();

		switch ($data['style']) {
			case 'style2':
			$template = 'view-2';
			break;
			default:
			$template = 'view-1';
			break;
		}

		return $this->rt_template( $template, $data );
	}
}