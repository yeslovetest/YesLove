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
 * BuddyPress Login Widget.
 *
 * @since 1.9.0
 */
class CBP_Login_Widget extends WP_Widget {

	/**
	 * Constructor method.
	 *
	 * @since 1.9.0
	 */
	public function __construct() {
		parent::__construct(
			false,
			_x( '(A1) Log In', 'Title of the login widget', 'cirkle-core' ),
			array(
				'description'                 => __( 'Show a Log In form to logged-out visitors, and a Log Out link to logged in visitors.', 'cirkle-core' ),
				'classname'                   => 'widget_bp_core_login_widget buddypress',
				'customize_selective_refresh' => true,
			)
		);
	}

	/**
	 * Display the login widget.
	 *
	 * @since 1.9.0
	 *
	 * @see WP_Widget::widget() for description of parameters.
	 *
	 * @param array $args     Widget arguments.
	 * @param array $instance Widget settings, as saved by the user.
	 */
	public function widget( $args, $instance ) {
		$title = isset( $instance['title'] ) ? $instance['title'] : '';

		/**
		 * Filters the title of the Login widget.
		 *
		 * @since 1.9.0
		 * @since 2.3.0 Added 'instance' and 'id_base' to arguments passed to filter.
		 *
		 * @param string $title    The widget title.
		 * @param array  $instance The settings for the particular instance of the widget.
		 * @param string $id_base  Root ID for all widgets of this type.
		 */
		$title = apply_filters( 'widget_title', $title, $instance, $this->id_base );

		echo $args['before_widget'];
		
		if (!empty($title)) {
			echo $args['before_title'] . esc_html( $title ) . $args['after_title']; 
		}

		?>

		<?php if ( is_user_logged_in() ) : ?>

			<?php
			/**
			 * Fires before the display of widget content if logged in.
			 *
			 * @since 1.9.0
			 */
			do_action( 'bp_before_login_widget_loggedin' ); ?>
			<?php 
				$cover_image_url = bp_attachments_get_attachment('url', array(
					'object_dir' => 'members',
					'item_id' => bp_loggedin_user_id(),
				));
				if (empty($cover_image_url)) {
			        $cover_image_url = CIRKLE_BANNER_DUMMY_IMG.'dummy-banner.jpg';
			    } else {
			        $cover_image_url = $cover_image_url;
			    } 
			?>
			<div class="widget-author <?php Helper::cirkle_is_user_online( bp_loggedin_user_id() ); ?>">
                <div class="author-heading">
                    <div class="cover-img">
                        <img src="<?php echo esc_url( $cover_image_url ); ?>" alt="cover">
                    </div>
                    <div class="profile-img">
                        <a href="<?php echo bp_loggedin_user_domain(); ?>">
                            <?php bp_loggedin_user_avatar( 'type=full' ); ?>
                        </a>
                        <?php 
                        if (function_exists('bp_is_verified')) {
                        	echo Helper::cirkle_show_verified_badge(bp_loggedin_user_id());
                        } ?>
                    </div>
                    <div class="profile-name">
                        <h4 class="author-name"><?php echo bp_core_get_userlink( bp_loggedin_user_id() ); ?></h4>
                        <div class="author-location"><?php echo xprofile_get_field_data( 'Shorttext', get_the_author_meta( 'ID' )) ?></div>
                    </div>
                </div>

                <?php
                if (class_exists('GamiPress')) {
					$earned_ids = gamipress_get_user_earned_achievement_ids( bp_loggedin_user_id(), 'badge' );
					if ($earned_ids) {
    			?>

                <ul class="author-badge">
                	<?php if ( $earned_ids ) {
                		$badge_left = count( $earned_ids ) - 3;
                		foreach ( $earned_ids as $key => $value ) { 
                			if ( $key == 3 ) break;
                	?>
		            	<li>
		            	<?php 
		            		$badge_img_id = get_post_meta( $value, '_thumbnail_id', true );
		            		$img_src = wp_get_attachment_image_src( $badge_img_id, 'thumbnail' ); 
		            		if ( $img_src ) {
	            			?>
		            			<img src="<?php echo esc_url( $img_src[0] ); ?>" alt="">
		            			<?php
		            		}
			            ?>
		            	</li>
		            	<?php } if ( $badge_left > 0 ) { ?>
	            		<li><a href="<?php echo bp_core_get_user_domain( bp_loggedin_user_id() ).'badges'; ?>" class="profile-circle">+<?php echo esc_html( $badge_left ); ?></a></li>
	            	<?php } } ?>
                </ul>
            	<?php } } ?>
                <ul class="author-statistics">
                    <li>
                    <a href="<?php echo bp_loggedin_user_domain(); ?>">
                    	<span class="item-number">
                    	<?php echo Helper::cirkle_user_post_count( bp_loggedin_user_id() ); ?>
                    	</span> 
                    	<span class="item-text">
                    		<?php esc_html_e( 'Posts', 'cirkle-core' ); ?>
                    	</span>
                    </a>
                    </li>
                    <li>
                    <a href="<?php echo bp_loggedin_user_domain(); ?>">
                    	<span class="item-number"><?php echo Helper::cirkle_count_user_comments( bp_loggedin_user_id() ); ?></span> 
                    	<span class="item-text">
                    		<?php esc_html_e( 'Comments', 'cirkle-core' ); ?>
                    	</span>
                    </a>
                    </li>
                    <li>
                    <a href="<?php echo bp_loggedin_user_domain(); ?>">
                    	<span class="item-number"><?php echo Helper::cirkle_get_postviews( bp_loggedin_user_id() ); ?></span> 
                    	<span class="item-text">
                    		<?php esc_html_e( 'Views', 'cirkle-core' ); ?>
                    	</span>
                    </a>
                    </li>
                </ul>
            </div>
			<?php

			/**
			 * Fires after the display of widget content if logged in.
			 *
			 * @since 1.9.0
			 */
			do_action( 'bp_after_login_widget_loggedin' ); ?>

		<?php else : ?>

			<?php

			/**
			 * Fires before the display of widget content if logged out.
			 *
			 * @since 1.9.0
			 */
			do_action( 'bp_before_login_widget_loggedout' ); ?>

			<form name="bp-login-form" id="bp-login-widget-form" class="standard-form cirkle-login-form" action="<?php echo esc_url( site_url( 'wp-login.php', 'login_post' ) ); ?>" method="post">
				<input type="text" name="log" id="bp-login-widget-user-login" class="input" value="" placeholder="<?php esc_attr_e( 'Username', 'cirkle-core' ); ?>" />
				<input type="password" name="pwd" id="bp-login-widget-user-pass" class="input" value="" placeholder="<?php esc_attr_e( 'Password', 'cirkle-core' ); ?>" <?php bp_form_field_attributes( 'password' ) ?>/>
				<div class="forgetmenot"><label for="bp-login-widget-rememberme"><input name="rememberme" type="checkbox" id="bp-login-widget-rememberme" value="forever" /> <?php _e( 'Remember Me', 'buddypress' ); ?></label></div>
				<input type="submit" name="wp-submit" id="bp-login-widget-submit" class="submit-btn" value="<?php esc_attr_e( 'Log In', 'buddypress' ); ?>" />
				<?php if ( bp_get_signup_allowed() ) : ?>
					<span class="bp-login-widget-register-link"><a href="<?php echo esc_url( bp_get_signup_page() ); ?>"><?php _e( 'Register', 'buddypress' ); ?></a></span>
				<?php endif; ?>

				<?php
				/**
				 * Fires inside the display of the login widget form.
				 *
				 * @since 2.4.0
				 */
				do_action( 'bp_login_widget_form' ); ?>

			</form>

			<?php

			/**
			 * Fires after the display of widget content if logged out.
			 *
			 * @since 1.9.0
			 */
			do_action( 'bp_after_login_widget_loggedout' ); ?>

		<?php endif;

		echo $args['after_widget'];
	}

	/**
	 * Update the login widget options.
	 *
	 * @since 1.9.0
	 *
	 * @param array $new_instance The new instance options.
	 * @param array $old_instance The old instance options.
	 * @return array $instance The parsed options to be saved.
	 */
	public function update( $new_instance, $old_instance ) {
		$instance             = $old_instance;
		$instance['title']    = isset( $new_instance['title'] ) ? strip_tags( $new_instance['title'] ) : '';

		return $instance;
	}

	/**
	 * Output the login widget options form.
	 *
	 * @since 1.9.0
	 *
	 * @param array $instance Settings for this widget.
	 * @return void
	 */
	public function form( $instance = array() ) {

		$settings = wp_parse_args( $instance, array(
			'title' => '',
		) ); ?>

		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:', 'buddypress' ); ?>
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $settings['title'] ); ?>" /></label>
		</p>

		<?php
	}
}