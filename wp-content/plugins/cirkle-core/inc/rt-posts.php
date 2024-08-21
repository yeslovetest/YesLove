<?php
if ( ! defined( 'ABSPATH' ) ) exit;

if( !class_exists( 'RT_Posts' ) ){

	class RT_Posts {
		
		protected static $instance = null;
		private $post_types = array();
		private $taxonomies = array();

		private function __construct() {
			add_action( 'init', array( $this, 'initialize' ) );
		}

		public static function getInstance() {
			if ( null == self::$instance ) {
				self::$instance = new self;
			}
			return self::$instance;
		}

		public function initialize() {
			$this->register_taxonomies();
			$this->register_custom_post_types();
		}

		public function add_post_types( $post_types ) {

			foreach ( $post_types as $post_type => $args ) {

				$title = $args['title'];
				$plural_title = empty( $args['plural_title'] ) ? $title : $args['plural_title'];
				
				if ( ! empty( $args['rewrite'] ) ) {
					$args['rewrite'] = array( 'slug' => $args['rewrite'] );
				}

				$labels      = array(
					'name'                     => $plural_title,
					'singular_name'            => $title,
					'add_new'                  => esc_html__( 'Add New', 'cirkle-core' ),
					'add_new_item'             => sprintf( esc_html__( 'Add New %s', 'cirkle-core' ), $title ),
					'edit_item'                => sprintf( esc_html__( 'Edit %s', 'cirkle-core' ), $title ),
					'new_item'                 => sprintf( esc_html__( 'New %s', 'cirkle-core' ), $title ),
					'view_item'                => sprintf( esc_html__( 'View %s', 'cirkle-core' ), $title ),
					'view_items'               => sprintf( esc_html__( 'View %s', 'cirkle-core' ), $plural_title ),
					'search_items'             => sprintf( esc_html__( 'Search %s', 'cirkle-core' ), $plural_title ),
					'not_found'                => sprintf( esc_html__( '%s not found', 'cirkle-core' ), $plural_title ),
					'not_found_in_trash'       => sprintf( esc_html__( '%s found in Trash', 'cirkle-core' ), $plural_title ),
					'parent_item_colon'        => '',
					'all_items'                => sprintf( esc_html__( 'All %s', 'cirkle-core' ), $plural_title ),
					'archives'                 => sprintf( esc_html__( '%s Archives', 'cirkle-core' ), $title ),
					'attributes'               => sprintf( esc_html__( '%s Attributes', 'cirkle-core' ), $title ),
					'insert_into_item'         => sprintf( esc_html__( 'Insert into %s', 'cirkle-core' ), $title ),
					'uploaded_to_this_item'    => sprintf( esc_html__( 'Uploaded to this %s', 'cirkle-core' ), $title ),
					'filter_items_list'        => sprintf( esc_html__( 'Filter %s list', 'cirkle-core' ), $plural_title ),
					'items_list_navigation'    => sprintf( esc_html__( '%s list navigation', 'cirkle-core' ), $plural_title ),
					'items_list'               => sprintf( esc_html__( '%s list', 'cirkle-core' ), $plural_title ),
					'item_published'           => sprintf( esc_html__( '%s published.', 'cirkle-core' ), $title ),
					'item_published_privately' => sprintf( esc_html__( '%s published privately.', 'cirkle-core' ), $title ),
					'item_reverted_to_draft'   => sprintf( esc_html__( '%s reverted to draft.', 'cirkle-core' ), $title ),
					'item_scheduled'           => sprintf( esc_html__( '%s scheduled.', 'cirkle-core' ), $title ),
					'item_updated'             => sprintf( esc_html__( '%s  updated.', 'cirkle-core' ), $title ),
					'menu_name'                => $plural_title
				);

				if ( !empty( $args['labels_override'] ) ) {
					$labels = wp_parse_args( $args['labels_override'], $labels );
				}

				$defaults = array(
					'labels'             => $labels,
					'public'             => true,
					'publicly_queryable' => true,
					'show_ui'            => true,
					'show_in_menu'       => true,
					'show_in_nav_menus'  => true,
					'query_var'          => true,
					'has_archive'        => true,
					'hierarchical'       => false,
					'menu_position'      => null,
					'menu_icon'          => null,
					'supports'           => array( 'title', 'thumbnail', 'editor' )
				);

				$args = wp_parse_args( $args, $defaults );
				$this->post_types[ $post_type ] = $args;
			}
		}

		public function add_taxonomies( $taxonomies ) {

			foreach ($taxonomies as $taxonomy => $args ) {

				$title = $args['title'];
				$plural_title = empty( $args['plural_title'] ) ? $title : $args['plural_title'];

				$labels     = array(
					'name'                       => $title,
					'singular_name'              => $title,
					'search_items'               => sprintf( esc_html__( 'Search %s', 'cirkle-core' ), $plural_title ),
					'popular_items'              => sprintf( esc_html__( 'Popular %s', 'cirkle-core' ), $plural_title ),
					'all_items'                  => sprintf( esc_html__( 'All %s', 'cirkle-core' ), $plural_title ),
					'parent_item'                => sprintf( esc_html__( 'Parent %s', 'cirkle-core' ), $title ),
					'parent_item_colon'          => sprintf( esc_html__( 'Parent %s:', 'cirkle-core' ), $title ),
					'edit_item'                  => sprintf( esc_html__( 'Edit %s', 'cirkle-core' ), $title ),
					'view_item'                  => sprintf( esc_html__( 'View %s', 'cirkle-core' ), $title ),
					'update_item'                => sprintf( esc_html__( 'Update %s', 'cirkle-core' ), $title ),
					'add_new_item'               => sprintf( esc_html__( 'Add New %s', 'cirkle-core' ), $title ),
					'new_item_name'              => sprintf( esc_html__( 'New %s Name', 'cirkle-core' ), $title ),
					'separate_items_with_commas' => sprintf( esc_html__( 'Separate %s with commas', 'cirkle-core' ), $plural_title ),
					'add_or_remove_items'        => sprintf( esc_html__( 'Add or remove %s', 'cirkle-core' ), $plural_title ),
					'choose_from_most_used'      => sprintf( esc_html__( 'Choose from the most used %s', 'cirkle-core' ), $plural_title ),
					'not_found'                  => sprintf( esc_html__( 'No %s found.', 'cirkle-core' ), $plural_title ),
					'no_terms'                   => sprintf( esc_html__( 'No %s', 'cirkle-core' ), $plural_title ),
					'items_list_navigation'      => sprintf( esc_html__( '%s list navigation', 'cirkle-core' ), $plural_title ),
					'items_list'                 => sprintf( esc_html__( '%s list', 'cirkle-core' ), $plural_title ),
					'back_to_items'              => sprintf( esc_html__( '&larr; Back to %s', 'cirkle-core' ), $plural_title ),
					'menu_name'                  => $plural_title,
				);

				if ( !empty( $args['labels_override'] ) ) {
					$labels = wp_parse_args( $args['labels_override'], $labels );
				}

				$defaults = array(
					'hierarchical'      => true,
					'labels'            => $labels,
					'show_in_nav_menus' => true,
					'show_ui'           => null,
					'show_admin_column' => true,
					'query_var'         => true,
					'rewrite'           => array( 'slug' => $taxonomy )
				);

				$args = wp_parse_args( $args, $defaults );
				$this->taxonomies[ $taxonomy ] = $args;
			}
		}

		private function register_custom_post_types() {
			$post_types = apply_filters( 'rt_framework_post_types', $this->post_types );
			foreach ( $post_types as $post_type => $args ) {
				register_post_type( $post_type, $args );
			}
		}

		private function register_taxonomies() {
			$taxonomies = apply_filters( 'rt_framework_taxonomies', $this->taxonomies );
			foreach ( $taxonomies as $taxonomy => $args ) {
				register_taxonomy( $taxonomy, $args['post_types'], $args );
			}
		}
	}
}

RT_Posts::getInstance();