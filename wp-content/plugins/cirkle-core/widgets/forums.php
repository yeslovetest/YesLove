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

/**
 * bbPress Forum Widget
 *
 * Adds a widget which displays the forum list
 *
 * @since 2.0.0 bbPress (r2653)
 */
class CBBP_Forums_Widget extends WP_Widget {

	/**
	 * bbPress Forum Widget
	 *
	 * Registers the forum widget
	 *
	 * @since 2.0.0 bbPress (r2653)
	 */
	public function __construct() {
		$widget_ops = apply_filters( 'cbbp_forums_widget_options', array(
			'classname'                   => 'widget_display_forums',
			'description'                 => esc_html__( 'A list of forums with an option to set the parent.', 'bbpress' ),
			'customize_selective_refresh' => true
		) );

		parent::__construct( false, esc_html__( '(A5) Forums List', 'bbpress' ), $widget_ops );
	}

	/**
	 * Register the widget
	 *
	 * @since 2.0.0 bbPress (r3389)
	 */
	public static function register_widget() {
		register_widget( 'BBP_Forums_Widget' );
	}

	/**
	 * Displays the output, the forum list
	 *
	 * @since 2.0.0 bbPress (r2653)
	 *
	 * @param array $args Arguments
	 * @param array $instance Instance
	 */
	public function widget( $args, $instance ) {

		// Get widget settings
		$settings = $this->parse_settings( $instance );

		// Typical WordPress filter
		$settings['title'] = apply_filters( 'widget_title',           $settings['title'], $instance, $this->id_base );

		// bbPress filter
		$settings['title'] = apply_filters( 'bbp_forum_widget_title', $settings['title'], $instance, $this->id_base );

		// Note: private and hidden forums will be excluded via the
		// bbp_pre_get_posts_normalize_forum_visibility action and function.
		$widget_query = new \WP_Query( array(

			// What and how
			'post_type'      => bbp_get_forum_post_type(),
			'post_status'    => bbp_get_public_status_id(),
			'post_parent'    => $settings['parent_forum'],
			'posts_per_page' => (int) get_option( '_bbp_forums_per_page', 50 ),

			// Order
			'orderby' => 'menu_order title',
			'order'   => 'ASC',

			// Performance
			'ignore_sticky_posts'    => true,
			'no_found_rows'          => true,
			'update_post_term_cache' => false,
			'update_post_meta_cache' => false
		) );

		// Bail if no posts
		if ( bbp_has_forums() ) :

		echo $args['before_widget'];
		if ( ! empty( $settings['title'] ) ) {
		?>
		<div class="widget-heading">
            <?php echo $args['before_title'] . $settings['title'] . $args['after_title']; ?>
        </div>
        <?php } ?>
        <div class="group-list">
        	<?php while ( bbp_forums() ) : bbp_the_forum(); ?>
            <div class="media">
            	<?php if (has_post_thumbnail()) { ?>
                <div class="item-img">
                    <a href="<?php bbp_forum_permalink( $widget_query->post->ID ); ?>">
                        <?php echo get_the_post_thumbnail(get_the_ID(), 'full'); ?>
                    </a>
                </div>
                <?php } ?>
                <div class="media-body">
                    <h4 class="item-title">
                    <a class="bbp-forum-title" href="<?php bbp_forum_permalink(); ?>"><?php bbp_forum_title(); ?></a>
                    </h4>
                    <div class="item-member"><?php bbp_forum_topic_count(); esc_html_e( ' Topics .', 'cirkle-core' ); ?> <?php bbp_show_lead_topic() ? bbp_forum_reply_count() : bbp_forum_post_count(); esc_html_e( ' Replies', 'cirkle-core' ); ?> </div>
                </div>
            </div>
            <?php endwhile; ?>
        </div>

		<?php echo $args['after_widget'];

		// Reset the $post global
		endif;
	}

	/**
	 * Update the forum widget options
	 *
	 * @since 2.0.0 bbPress (r2653)
	 *
	 * @param array $new_instance The new instance options
	 * @param array $old_instance The old instance options
	 */
	public function update( $new_instance, $old_instance ) {
		$instance                 = $old_instance;
		$instance['title']        = strip_tags( $new_instance['title'] );
		$instance['parent_forum'] = sanitize_text_field( $new_instance['parent_forum'] );

		// Force to any
		if ( ! empty( $instance['parent_forum'] ) && ! is_numeric( $instance['parent_forum'] ) ) {
			$instance['parent_forum'] = 'any';
		}

		return $instance;
	}

	/**
	 * Output the forum widget options form
	 *
	 * @since 2.0.0 bbPress (r2653)
	 *
	 * @param $instance Instance
	 */
	public function form( $instance ) {

		// Get widget settings
		$settings = $this->parse_settings( $instance ); ?>

		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php esc_html_e( 'Title:', 'bbpress' ); ?>
				<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $settings['title'] ); ?>" />
			</label>
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'parent_forum' ); ?>"><?php esc_html_e( 'Parent Forum ID:', 'bbpress' ); ?>
				<input class="widefat" id="<?php echo $this->get_field_id( 'parent_forum' ); ?>" name="<?php echo $this->get_field_name( 'parent_forum' ); ?>" type="text" value="<?php echo esc_attr( $settings['parent_forum'] ); ?>" />
			</label>

			<br />

			<small><?php esc_html_e( '"0" to show only root - "any" to show all', 'bbpress' ); ?></small>
		</p>

		<?php
	}

	/**
	 * Merge the widget settings into defaults array.
	 *
	 * @since 2.3.0 bbPress (r4802)
	 *
	 * @param $instance Instance
	 */
	public function parse_settings( $instance = array() ) {
		return bbp_parse_args( $instance, array(
			'title'        => esc_html__( 'Forums', 'bbpress' ),
			'parent_forum' => 0
		), 'forum_widget_settings' );
	}
}