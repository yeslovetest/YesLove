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
 * BBPress Login Widget.
 *
 * @since 1.0.0
 */
class CBBP_Login_Widget extends WP_Widget {

	/**
	 * bbPress Login Widget
	 *
	 * Registers the login widget
	 *
	 * @since 2.0.0 bbPress (r2827)
	 */
	public function __construct() {
		$widget_ops = apply_filters( 'bbp_login_widget_options', array(
			'classname'                   => 'bbp_widget_login',
			'description'                 => esc_html__( 'A simple login form with optional links to sign-up and lost password pages.', 'cirkle-core' ),
			'customize_selective_refresh' => true
		) );

		parent::__construct( false, esc_html__( 'BBP Login Widget', 'cirkle-core' ), $widget_ops );
	}

	/**
	 * Register the widget
	 *
	 * @since 2.0.0 bbPress (r3389)
	 */
	public static function register_widget() {
		register_widget( 'CBBP_Login_Widget' );
	}

	/**
	 * Displays the output, the login form
	 *
	 * @since 2.0.0 bbPress (r2827)
	 *
	 * @param array $args Arguments
	 * @param array $instance Instance
	 */
	public function widget( $args = array(), $instance = array() ) {

		// Get widget settings
		$settings = $this->parse_settings( $instance );

		// Typical WordPress filter
		$settings['title'] = apply_filters( 'widget_title', $settings['title'], $instance, $this->id_base );

		// bbPress filters
		$settings['title']    = apply_filters( 'bbp_login_widget_title',    $settings['title'],    $instance, $this->id_base );
		$settings['register'] = apply_filters( 'bbp_login_widget_register', $settings['register'], $instance, $this->id_base );
		$settings['lostpass'] = apply_filters( 'bbp_login_widget_lostpass', $settings['lostpass'], $instance, $this->id_base );

		echo $args['before_widget'];

		if ( ! empty( $settings['title'] ) ) {
			echo $args['before_title'] . $settings['title'] . $args['after_title'];
		}

		if ( is_user_logged_in() ) { ?>
			<div class="bbp-logged-in">
				<a href="<?php bbp_user_profile_url( bbp_get_current_user_id() ); ?>" class="submit user-submit"><?php echo get_avatar( bbp_get_current_user_id(), '40' ); ?></a>
				<h4><?php bbp_user_profile_link( bbp_get_current_user_id() ); ?></h4>
				<?php bbp_logout_link(); ?>
			</div>
		<?php }

		echo $args['after_widget'];
	}

	/**
	 * Update the login widget options
	 *
	 * @since 2.0.0 bbPress (r2827)
	 *
	 * @param array $new_instance The new instance options
	 * @param array $old_instance The old instance options
	 */
	public function update( $new_instance, $old_instance ) {
		$instance             = $old_instance;
		$instance['title']    = strip_tags( $new_instance['title'] );
		$instance['register'] = esc_url_raw( $new_instance['register'] );
		$instance['lostpass'] = esc_url_raw( $new_instance['lostpass'] );

		return $instance;
	}

	/**
	 * Output the login widget options form
	 *
	 * @since 2.0.0 bbPress
	 *
	 * @param $instance Instance
	 */
	public function form( $instance = array() ) {

		// Get widget settings
		$settings = $this->parse_settings( $instance ); ?>

		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php esc_html_e( 'Title:', 'cirkle-core' ); ?>
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $settings['title'] ); ?>" /></label>
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
			'title'    => '',
			'register' => '',
			'lostpass' => ''
		), 'login_widget_settings' );
	}
}