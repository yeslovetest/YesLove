<?php
/**
 * @author  RadiusTheme
 * @since   1.0
 * @version 1.0
 */

namespace radiustheme\Cirkle_Core;

use \WP_Widget;
use \RT_Widget_Fields;
use radiustheme\Cirkle\Helper;

class Post_Widget extends WP_Widget {
	public function __construct() {
		$id = CIRKLE_CORE_THEME_PREFIX . '_post';
		parent::__construct(
            $id, // Base ID
            esc_html__( 'A3: Posts', 'cirkle-core' ), // Name
            array( 'description' => esc_html__( 'Cirkle: Posts Widget', 'cirkle-core' )
        ) );
	}

	public function widget( $args, $instance ){
		echo wp_kses_post( $args['before_widget'] );

		if (!empty($instance['title'])) {
        	$title = $instance['title'];
      	} else {
        	$title = '';
      	} 
      	if (!empty($instance['layout'])) {
        	$layout = $instance['layout'];
      	} else {
        	$layout = '';
      	} 
		$q_args = array(
			'cat'                 => (int) $instance['cat'],
			'orderby'             => $instance['orderby'],
			'posts_per_page'      => $instance['number'],
			'ignore_sticky_posts' => true,
		);

		switch ( $instance['orderby'] ){
			case 'title':
			case 'menu_order':
			$q_args['order'] = 'ASC';
			break;
		}

		$query = new \WP_Query( $q_args );
		?>
		<?php if ( $query->have_posts() ) :?>
            <div class="widget-recent">
            	<?php if (!empty($title)) { ?>
	            <div class="widget-section-heading heading-dark">
					<h3 class="widget-title"><?php echo esc_html( $title ); ?></h3>
				</div>
	            <?php } ?>
	            <ul class="list-item">
	            	<?php while ( $query->have_posts() ) : $query->the_post(); ?>
		            	<li class="media">
			            	<?php if ( $layout == 2 && has_post_thumbnail() ) { ?>
			            		<div class="left-box">
		                            <a href="<?php the_permalink(); ?>" class="item-figure">
		                                <?php the_post_thumbnail( 'thumbnail' ); ?>
		                            </a>
		                        </div>
		                    <?php } ?>
			            	<div class="media-body">
				                <h3 class="entry-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
				                <ul class="entry-meta">
									<li class="entry-date"><a href="<?php the_permalink(); ?>"><i class="far fa-calendar-alt"></i><?php the_time( get_option( 'date_format' ) ); ?></a></li>
								</ul>
			                </div>
			            </li>
	            	<?php endwhile;?>
	            </ul>
	        </div>
		<?php else: ?>
			<div><?php esc_html_e( 'Currently there are no posts to display', 'cirkle-core' ); ?></div>
		<?php endif;?>
		<?php wp_reset_postdata();?>
		<?php
		echo wp_kses_post( $args['after_widget'] );
	}

	public function update( $new_instance, $old_instance ){
		$instance             = array();
		$instance['title']    = ( ! empty( $new_instance['title'] ) ) ? sanitize_text_field( $new_instance['title'] ) : '';
		$instance['cat']      = ( ! empty( $new_instance['cat'] ) ) ? sanitize_text_field( $new_instance['cat'] ) : '';
		$instance['orderby']  = ( ! empty( $new_instance['orderby'] ) ) ? sanitize_text_field( $new_instance['orderby'] ) : '';
		$instance['number']   = ( ! empty( $new_instance['number'] ) ) ? sanitize_text_field( $new_instance['number'] ) : '';
		$instance['layout']   = ( ! empty( $new_instance['layout'] ) ) ? sanitize_text_field( $new_instance['layout'] ) : '';
		return $instance;
	}

	public function form( $instance ){
		$defaults = array(
			'title'   => '',
			'cat'     => '0',
			'orderby' => '',
			'number'  => '4',
			'layout'  => '1',
		);
		$instance = wp_parse_args( (array) $instance, $defaults );

		$categories = get_categories();
		$category_dropdown = array( '0' => __( 'All Categories', 'cirkle-core' ) );

		foreach ( $categories as $category ) {
			$category_dropdown[$category->term_id] = $category->name;
		}

		$orderby = array(
			'date'        => __( 'Date (Recents comes first)', 'cirkle-core' ),
			'title'       => __( 'Title', 'cirkle-core' ),
			'menu_order'  => __( 'Custom Order (Available via Order field inside Page Attributes box)', 'cirkle-core' ),
		);

		$fields = array(
			'title'       => array(
				'label'   => esc_html__( 'Title', 'cirkle-core' ),
				'type'    => 'text',
			),
			'cat'        => array(
				'label'   => esc_html__( 'Category', 'cirkle-core' ),
				'type'    => 'select',
				'options' => $category_dropdown,
			),
			'orderby' => array(
				'label'   => esc_html__( 'Order by', 'cirkle-core' ),
				'type'    => 'select',
				'options' => $orderby,
			),
			'number' => array(
				'label'   => esc_html__( 'Number of Post', 'cirkle-core' ),
				'type'    => 'number',
			),
			'layout'      => array(
				'label'   => esc_html__( 'Thumbnail Image', 'cirkle-core' ),
				'type'    => 'select',
				'options' => array(
					'1' => esc_html__( 'Without Thumbnail', 'cirkle-core' ),
					'2' => esc_html__( 'With Thumbnail', 'cirkle-core' ),
				),
			),
		);
		RT_Widget_Fields::display( $fields, $instance, $this );
	}
}