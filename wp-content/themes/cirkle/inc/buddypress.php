<?php
/**
 * @author  RadiusTheme
 * @since   1.0
 * @version 1.0
 */

namespace radiustheme\cirkle;
use radiustheme\cirkle\RDTheme;
use radiustheme\cirkle\Helper;

class BuddyPress_Setup {

	public function __construct() {
		add_action( 'after_setup_theme', array( $this, 'cirkle_bp_setup' ) );
    	// BuddyPress
    	add_filter( 'bp_before_members_cover_image_settings_parse_args', array( &$this, 'cirkle_xprofile_cover_image' ), 10, 1 );
    	add_action( 'bp_init', array( &$this, 'cirkle_change_bp_nav_position' ), 999 );
    	add_action( 'bp_directory_members_search_form', array( &$this, 'cirkle_members_search_form' ) );
    	if ( class_exists( 'mediapress' )){
    		remove_action( 'bp_after_activity_post_form', 'mpp_activity_upload_buttons' );
			add_action('cirkle_media_uploading_btn', array( &$this,'mpp_activity_upload_buttons') );
			add_action('cirkle_media_uploading_field', array( &$this,'mpp_activity_dropzone') );
    		add_action('bp_setup_nav', array( &$this,'cirkle_profile_photos') );
    		remove_action( 'bp_activity_entry_content', 'mpp_activity_inject_attached_media_html' );
	    	add_action( 'bp_activity_entry_content', array( &$this, 'cirkle_mpp_activity_inject_attached_media_html' ) );
    	}
    	add_action( 'bp_setup_nav', array( &$this, 'cirkle_change_bp_nav_position' ), 100 );
	    add_action( 'wp_loaded',  array( &$this, 'cirkle_add_new_user' ) );
	    
	    add_filter('bbp_get_author_link', function($string) {
	    	return html_entity_decode( $string, ENT_HTML5 );
	    });

	    // Friends Action
		add_action("init",function(){
			remove_action( 'wp_ajax_addremove_friend', 'bp_legacy_theme_ajax_addremove_friend' );
			remove_action( 'wp_ajax_nopriv_addremove_friend', 'bp_legacy_theme_ajax_addremove_friend' );
		});

		add_action( 'wp_ajax_addremove_friend', [$this, 'bp_legacy_theme_ajax_addremove_friend'] );
		add_action( 'wp_ajax_nopriv_addremove_friend' , [$this, 'bp_legacy_theme_ajax_addremove_friend'] );

	    add_filter( 'bp_get_add_friend_button', function( $button ){
            $potential_friend_id = 0;
			if ( empty( $potential_friend_id ) ){
				$potential_friend_id = bp_get_potential_friend_id( $potential_friend_id );
			}
				
			$is_friend = bp_is_friend( $potential_friend_id );

			if ( empty( $is_friend ) ){
				return $button;
			}
				
	    	switch ( $is_friend ) {
				case 'pending':
					$button['link_text'] = sprintf(
						'<span class="item-number"><i class="icofont-minus"></i></span><span class="item-text">%s</span>', 
						esc_html__( 'Cancel Request', 'cirkle' )
					);
				break;
				case 'awaiting_response':
					$button['link_text'] = sprintf(
						'<span class="item-number"><i class="icofont-plus"></i></span><span class="item-text">%s</span>', 
						esc_html__( 'Accept Request', 'cirkle' )
					);
				break;
				case 'is_friend':
					$button['link_text'] = sprintf(
						'<span class="item-number"><i class="icofont-minus"></i></span><span class="item-text">%s</span>', 
						esc_html__( 'Unfriend', 'cirkle' )
					); 
				break;
				default:
				$button['link_text'] = sprintf(
					'<span class="item-number"><i class="icofont-plus"></i></span><span class="item-text">%s</span>',
					esc_html__( 'Add Friend', 'cirkle' )
				);
			}
			return $button;
		});

		add_action( 'init',  array( &$this, 'registration_condition' ) );
		add_filter('logout_redirect', [$this, 'cirkle_front_end_logout_url'], 10, 3);
		add_action( 'template_redirect', [$this, 'cirkle_bp_logged_out_page_template_redirect'] );

	}

	public function registration_condition(){
		$login_type = RDTheme::$options['cirkle_login_page_type'];
		if ( $login_type == 1 || $login_type == 2) {
			add_filter('login_redirect', [$this, 'cirkle_front_end_login_fail'], 10, 3);
		}
		if ( ! class_exists( 'woocommerce' ) ) {
		    add_action( 'login_form_lostpassword', array( $this, 'redirect_to_custom_lostpassword' ) );
		    add_shortcode( 'custom-password-lost-form', array( $this, 'render_password_lost_form' ) );
		    add_action( 'login_form_lostpassword', array( $this, 'do_password_lost' ) );
		}
	}

	public function redirect_to_custom_lostpassword() {
	    if ( 'GET' == $_SERVER['REQUEST_METHOD'] ) {
	        if ( is_user_logged_in() ) {
	            $this->redirect_logged_in_user();
	            exit;
	        }
	 
	        wp_redirect( get_template_part( 'templates/password_lost_form' ) );
	        exit;
	    }
	}

	public function render_password_lost_form( $attributes, $content = null ) {
	    // Parse shortcode attributes
	    $default_attributes = array( 'show_title' => false );
	    $attributes = shortcode_atts( $default_attributes, $attributes );
	 
	    if ( is_user_logged_in() ) {
	        return __( 'You are already signed in.', 'personalize-login' );
	    } else {
	        return $this->get_template_html( 'password_lost_form', $attributes );
	    }
	}

	public function do_password_lost() {
	    if ( 'POST' == $_SERVER['REQUEST_METHOD'] ) {
	        $errors = retrieve_password();
	        if ( is_wp_error( $errors ) ) {
	            // Errors found
	            $redirect_url = home_url( 'member-password-lost' );
	            $redirect_url = add_query_arg( 'errors', join( ',', $errors->get_error_codes() ), $redirect_url );
	        } else {
	            // Email sent
	            $redirect_url = home_url( 'member-login' );
	            $redirect_url = add_query_arg( 'checkemail', 'confirm', $redirect_url );
	        }
	 
	        wp_redirect( $redirect_url );
	        exit;
	    }
	}

	// Registration form fields
	public function cirkle_registration_fields() {
	    ob_start(); ?>
	        <h6 class="cirkle_header"><?php esc_html_e( 'Register New Account', 'cirkle' ); ?></h6>
	        <?php
	        // show any error messages after form submission
	        echo $this->cirkle_register_messages(); ?>

	        <form id="cirkle_registration_form" class="cirkle_form" action="" method="POST">
            	<div class="form-group">
                    <input name="user_fullname" id="user_fullname" type="text" class="form-control" placeholder="<?php esc_attr_e( 'Full Name', 'cirkle' ); ?>">
                </div>
                <div class="form-group">
                    <input name="cirkle_user_login" id="cirkle_user_login" class="form-control" type="text" placeholder="<?php esc_attr_e( 'Username', 'cirkle' ); ?>" required>
                </div>
                <div class="form-group">
                    <input name="cirkle_user_email" id="cirkle_user_email" class="form-control" type="email" placeholder="<?php esc_attr_e( 'Email', 'cirkle' ); ?>" required>
                </div>
                <div class="form-group">
                    <input name="cirkle_user_pass" id="password" class="form-control" type="password" placeholder="<?php esc_attr_e( 'Password', 'cirkle' ); ?>" required>
                </div>
                <div class="form-group">
                    <input name="cirkle_user_pass_confirm" id="password_again" class="form-control" type="password" placeholder="<?php esc_attr_e( 'Confirm Password', 'cirkle' ); ?>" required>
                </div>

                <div class="form-group submit-btn-wrap">
                    <input type="hidden" name="cirkle_csrf" value="<?php echo wp_create_nonce('cirkle-csrf'); ?>"/>
                    <input type="submit" class="submit-btn" value="<?php esc_html_e('Register Your Account', 'cirkle'); ?>"/>
                </div>
	        </form>
	    <?php
	    return ob_get_clean();
	}

	 // User registration login form
	public function cirkle_registration_form() {

	    // only show the registration form to non-logged-in members
	    if(!is_user_logged_in()) {

	        // check if registration is enabled
	        $registration_enabled = get_option('users_can_register');

	        // if enabled
	        if($registration_enabled) {
	            $output = $this->cirkle_registration_fields();
	        } else {
	            $output = esc_html__( 'User registration is not enabled', 'cirkle' );
	        }
	        return $output;
	    }
	}

	// Register a new user
	public function cirkle_add_new_user() {
	  	if (isset( $_POST["cirkle_user_login"] ) && wp_verify_nonce($_POST['cirkle_csrf'], 'cirkle-csrf')) {
			$user_fullname    = $_POST["user_fullname"];
			$user_login       = $_POST["cirkle_user_login"];
			$user_email       = $_POST["cirkle_user_email"];
			$user_pass        = $_POST["cirkle_user_pass"];
			$pass_confirm     = $_POST["cirkle_user_pass_confirm"];
			$country = $_POST["user_country"];
			$state = $_POST["user_state"];

	      	if(username_exists($user_login)) {
	          	// Username already registered
	          	$this->cirkle_errors()->add('username_unavailable', esc_html__( 'Username already taken', 'cirkle' ));
	      	}
	      	if(!validate_username($user_login)) {
	          	// invalid username
	          	$this->cirkle_errors()->add('username_invalid', esc_html__( 'Invalid username', 'cirkle' ));
	      	}
	      	if($user_login == '') {
	          	// empty username
	        	$this->cirkle_errors()->add('username_empty', esc_html__( 'Please enter a username', 'cirkle' ));
	      	}
	      	if(!is_email($user_email)) {
	          	//invalid email
	          	$this->cirkle_errors()->add('email_invalid', esc_html__( 'Invalid email', 'cirkle' ));
	      	}
			if(email_exists($user_email)) {
				//Email address already registered
				$this->cirkle_errors()->add('email_used', esc_html__( 'Email already registered', 'cirkle' ));
			}
			if($user_pass == '') {
				// passwords do not match
				$this->cirkle_errors()->add('password_empty', esc_html__( 'Please enter a password', 'cirkle' ));
			}
			if($user_pass != $pass_confirm) {
				// passwords do not match
				$this->cirkle_errors()->add('password_mismatch', esc_html__( 'Passwords do not match', 'cirkle' ));
			}

	      	$errors = $this->cirkle_errors()->get_error_messages();

	      	// if no errors then cretate user
	      	if(empty($errors)) {
	        	$new_user_id = wp_insert_user( array(
	                'user_fullname'   => $user_fullname,
	                'user_login'      => $user_login,
	                'user_pass'       => $user_pass,
	                'user_email'      => $user_email,
	                'user_registered' => date('Y-m-d H:i:s'),
	                'role'            => 'subscriber'
	            ));
	          	if($new_user_id) {
	          		add_user_meta($new_user_id, 'user_country', $country, true);
	          		add_user_meta($new_user_id, 'user_state', $state, true);
	             	// send an email to the admin
	             	wp_new_user_notification($new_user_id);

		            // Log the new user in
		            // Deprecated wp_setcookie($user_login, $user_pass, true);
	             	wp_clear_auth_cookie();
		            wp_set_auth_cookie( $new_user_id );

		            wp_set_current_user($new_user_id, $user_login);
		            do_action( 'wp_login', $user_login, wp_get_current_user() );
		            wp_safe_redirect(home_url('/'));
		            exit;
	          	} else {
	          		$this->cirkle_errors()->add('registration_error', esc_html__( 'Not Registered', 'cirkle' ));
	          	}
	      	}
	  	}
	}

	// Used for tracking error messages
	public function cirkle_errors(){
	    static $wp_error; // global variable handle
	    return isset($wp_error) ? $wp_error : ($wp_error = new \WP_Error(null, null, null));
	}

	public function cirkle_front_end_login_fail($redirect_to, $requested_redirect_to, $user) {
	    if (is_wp_error($user)) {
	    	if (isset($_SERVER['HTTP_REFERER'])) {
	    		$referrer = $_SERVER['HTTP_REFERER'];
	    		$referrer = remove_query_arg( ['login', 'reason'],  $referrer);
				//Login failed, find out why...
		        $error_types = array_keys($user->errors);
		        //Error type seems to be empty if none of the fields are filled out
		        $error_type = 'both_empty';
		        //Otherwise just get the first error (as far as I know there
		        //will only ever be one)
		        if (is_array($error_types) && !empty($error_types)) {
		            $error_type = $error_types[0];
		        }
		        if ( !empty($referrer) && !strstr($referrer,'wp-login') && !strstr($referrer,'wp-admin') ) {
		        	wp_redirect( $referrer . "?login=failed&reason=" . $error_type );
		        	exit;
		        }
	    	} else {
	    		if (RDTheme::$options['cirkle_login_page_type'] == 2) {
		    		wp_redirect(home_url( '/register/' ));
				} else {
					wp_redirect(get_template_part( 'login' ));
				}
	    	}
	    	exit;
	    } else {
	    	return $redirect_to;
	    }
	}

	//Hide for non-logged-in users (public visitors)
	public function cirkle_bp_logged_out_page_template_redirect() { 
		if (RDTheme::$options['logout_use_condition']) {
			if ( class_exists( 'BuddyPress' ) ) {
			   	if( (is_page( 'members' ) || is_page( 'activity' ) || bp_is_user()) && ! is_user_logged_in() ) { 
			   		if (RDTheme::$options['cirkle_login_page_type'] == 3) {
			   			wp_redirect(admin_url());
			   		} elseif (RDTheme::$options['cirkle_login_page_type'] == 2) {
			   			wp_redirect(home_url( '/register/' ));
					} else {
						wp_redirect(get_template_part( 'login' ));
					}
			    	exit(); 
			   	}
			}
		}
	}

	public function cirkle_front_end_logout_url( $redirect_to, $requested_redirect_to, $user) {
		$redirect_to = remove_query_arg(['login', 'login', 'reason'], $redirect_to);
		return $redirect_to;
	}

	// displays error messages from form submissions
	public function cirkle_register_messages() {
	    if($codes = $this->cirkle_errors()->get_error_codes()) {
	        $error_html = '<div class="cirkle_errors"><h4 style="color: red">Not Registered</h4>';
	            // Loop error codes and display errors
	            foreach($codes as $code){
	                $message = $this->cirkle_errors()->get_error_message($code);
	                $error_html .= '<span class="error"><strong>' . esc_html__( 'Error', 'cirkle' ) . '</strong>: ' . $message . '</span><br/>';
	            }
	        $error_html .= '</div>';

	        return $error_html;
	    }
	}

	public function bp_legacy_theme_ajax_addremove_friend() {
		if ( ! bp_is_post_request() ) {
			return;
		}

		// Cast fid as an integer.
		$friend_id = (int) $_POST['fid'];

		$user = get_user_by( 'id', $friend_id );
		if ( ! $user ) {
			die( esc_html__( 'No member found by that ID.', 'cirkle' ) );
		}

		// Trying to cancel friendship.
		if ( 'is_friend' == \BP_Friends_Friendship::check_is_friend( bp_loggedin_user_id(), $friend_id ) ) {
			check_ajax_referer( 'friends_remove_friend' );

			if ( ! friends_remove_friend( bp_loggedin_user_id(), $friend_id ) ) {
				echo esc_html__( 'Friend could not be canceled.', 'cirkle' );
			} else {
				echo '<a id="friend-' . esc_attr( $friend_id ) . '" class="friendship-button not_friends add" rel="add" href="' . wp_nonce_url( bp_loggedin_user_domain() . bp_get_friends_slug() . '/add-friend/' . $friend_id, 'friends_add_friend' ) . '"><span class="item-number"><i class="icofont-plus"></i></span><span class="item-text">' . esc_html__( 'Add Friend', 'cirkle' ) . '</span></a>';
			}

		// Trying to request friendship.
		} elseif ( 'not_friends' == \BP_Friends_Friendship::check_is_friend( bp_loggedin_user_id(), $friend_id ) ) {
			check_ajax_referer( 'friends_add_friend' );

			if ( ! friends_add_friend( bp_loggedin_user_id(), $friend_id ) ) {
				echo esc_html__(' Friend could not be requested.', 'cirkle' );
			} else {
				echo '<a id="friend-' . esc_attr( $friend_id ) . '" class="remove friendship-button pending_friend requested" rel="remove" href="' . wp_nonce_url( bp_loggedin_user_domain() . bp_get_friends_slug() . '/requests/cancel/' . $friend_id . '/', 'friends_withdraw_friendship' ) . '" class="requested"><span class="item-number"><i class="icofont-minus"></i></span><span class="item-text">' . esc_html__( 'Cancel Request', 'cirkle' ) . '</span></a>';
			}

		// Trying to cancel pending request.
		} elseif ( 'pending' == \BP_Friends_Friendship::check_is_friend( bp_loggedin_user_id(), $friend_id ) ) {
			check_ajax_referer( 'friends_withdraw_friendship' );

			if ( friends_withdraw_friendship( bp_loggedin_user_id(), $friend_id ) ) {
				echo '<a id="friend-' . esc_attr( $friend_id ) . '" class="friendship-button not_friends add" rel="add" href="' . wp_nonce_url( bp_loggedin_user_domain() . bp_get_friends_slug() . '/add-friend/' . $friend_id, 'friends_add_friend' ) . '"><span class="item-number"><i class="icofont-plus"></i></span><span class="item-text">' . esc_html__( 'Add Friend', 'cirkle' ) . '</span></a>';
			} else {
				echo esc_html__( "Friend request could not be cancelled.", 'cirkle' );
			}

		// Request already pending.
		} else {
			echo esc_html__( 'Request Pending', 'cirkle' );
		}

		exit;
	}

	public function cirkle_mpp_activity_inject_attached_media_html() {
		$media_ids = mpp_activity_get_attached_media_ids( bp_get_activity_id() );
		$lightbox = mpp_get_option( 'load_lightbox' );
		$lightbox_enabled = ! empty( $lightbox ) ? 1 : 0;
		$lightbox_class   = $lightbox_enabled ? 'zoom-gallery' : '';
		if ( empty( $media_ids ) ) {
			return;
		}
		$cols = '';
		$count = count( $media_ids );
		if ($count > 1 && $count < 3 ) {
			echo '<div class="cirkle-media-status circle-grid-template-2 '.$lightbox_class.'">';
		} elseif ($count > 2 && $count < 4 ) {
			echo '<div class="cirkle-media-status circle-grid-template-3 '.$lightbox_class.'">';
		} elseif ($count > 3 && $count < 5 ) {
			echo '<div class="cirkle-media-status circle-grid-template-2 '.$lightbox_class.'">';
		} else if ($count > 4 ) {
			echo '<div class="cirkle-media-status circle-grid-template-3 '.$lightbox_class.'">';
		} else {
			echo '<div class="cirkle-media-status circle-grid-template-0 '.$lightbox_class.'">';
		}
		$media_left = count( $media_ids ) - 6;

		foreach ($media_ids as $key => $media_id) {
			if ( $key > 5 ) break;

			$media = mpp_get_media( $media_id );
			if ( $media ) {
				$type = $media->type;
			?>
				<div class="grid-item">
					<?php if ( $key == 5 ) { ?>
						<div class="video-wrap last-item">
							<?php if ($type == 'video') { ?>
								<video src="<?php echo mpp_get_media_src( '', $media ); ?>" controls>
									<?php if ( $media_left > 0 ) { ?>
									<span>+<?php echo esc_html( $media_left ); ?></span>
									<?php } ?>
								</video>
							<?php } elseif ($type == 'photo') { ?>
								<a href="<?php mpp_media_src( 'full',  $media); ?>" class="popup-zoom">
									<img src="<?php echo mpp_get_media_src( 'mid', $media); ?>" alt="<?php esc_attr_e( 'Status Image ', 'cirkle' ) ?>">
									<?php if ( $media_left > 0 ) { ?>
									<span>+<?php echo esc_html( $media_left ); ?></span>
									<?php } ?>
								</a>
							<?php } else if ( $type == 'audio' ) { ?>
								<audio src="<?php echo mpp_get_media_src( '', $media ); ?>" controls>
									<?php if ( $media_left > 0 ) { ?>
									<span>+<?php echo esc_html( $media_left ); ?></span>
									<?php } ?>
								</audio>
							<?php } ?>
						</div>
					<?php } else { ?>
						<div class="video-wrap">
							<?php if ($type == 'video') { ?>
								<video src="<?php echo mpp_get_media_src( '', $media ); ?>" controls></video>
							<?php } elseif ($type == 'photo') { ?>
								<a href="<?php echo mpp_get_media_src( 'full', $media); ?>" class="popup-zoom">
									<img src="<?php echo mpp_get_media_src( 'mid', $media); ?>" alt="<?php esc_attr_e( 'Status Image', 'cirkle' ); ?>">
								</a>
							<?php } else if ( $type == 'audio' ) { ?>
								<audio src="<?php echo mpp_get_media_src( '', $media ); ?>" controls></audio>
							<?php } ?>
						</div>
					<?php } ?>
				</div>

			<?php }
		}

		echo '</div>';
	}

	public function cirkle_bp_setup() {
		add_theme_support( 'post-thumbnails', array( 'forum', 'topic' ) );
		add_post_type_support('forum', 'thumbnail');
		add_post_type_support('topic', 'thumbnail');
	}

	public function cirkle_xprofile_cover_image( $settings = array() ) {
	    $settings['width']  = 1170;
	    $settings['height'] = 250;
	    return $settings;
	}

	public static function userAddress($user_id){

		$country_id = get_user_meta( $user_id, 'user_country', true );
		$state_id = get_user_meta( $user_id, 'user_state', true );
		$address = [
			'country'=>'',
			'state'=>''
		];

		if(!$country_id || !$state_id ){
		    return $address;
		}
		$country = \Cirkle_Core::getCountryList($country_id);
		$state = '';
		if($country){
		    $states = \Cirkle_Core::getStateByCountry($country_id );
		    if (isset($states[$state_id])) {
		       $state = $states[$state_id];
		    }
		}
		return [
			'country'=>$country,
			'state'=>$state
		];
	}

	public function cirkle_change_bp_nav_position() {
		$timeline = RDTheme::$options['bp_timeline_tab_text'];
		$about    = RDTheme::$options['bp_profile_tab_text'];
		$friends  = RDTheme::$options['bp_friends_tab_text'];
		$groups  = RDTheme::$options['bp_groups_tab_text'];
		$messages  = RDTheme::$options['bp_messages_tab_text'];
		$photos  = RDTheme::$options['bp_photos_tab_text'];
		$videos  = RDTheme::$options['bp_videos_tab_text'];
		$badges  = RDTheme::$options['bp_badges_tab_text'];
		$forums  = RDTheme::$options['bp_forums_tab_text'];
		$settings  = RDTheme::$options['bp_settings_tab_text'];
		//Position
		$timeline_p = RDTheme::$options['bp_timeline_tab_p'];
		$about_p    = RDTheme::$options['bp_profile_tab_p'];
		$friends_p  = RDTheme::$options['bp_friends_tab_p'];
		$groups_p   = RDTheme::$options['bp_groups_tab_p'];
		$messages_p = RDTheme::$options['bp_messages_tab_p'];
		$photos_p   = RDTheme::$options['bp_photos_tab_p'];
		$videos_p   = RDTheme::$options['bp_videos_tab_p'];
		$badges_p   = RDTheme::$options['bp_badges_tab_p'];
		$forums_p   = RDTheme::$options['bp_forums_tab_p'];
		$settings_p = RDTheme::$options['bp_settings_tab_p'];

	    buddypress()->members->nav->edit_nav( array(
	    	'name' => $timeline,
	        'position' => $timeline_p,
	    ), 'activity' );
	    buddypress()->members->nav->edit_nav( array(
	    	'name' => $about,
	        'position' => $about_p,
	    ), 'profile' );
	    buddypress()->members->nav->edit_nav( array(
	    	'name' => $friends,
	        'position' => $friends_p,
	    ), 'friends' );
	    buddypress()->members->nav->edit_nav( array(
	    	'name' => $groups,
	        'position' => $groups_p,
	    ), 'groups' );
	    buddypress()->members->nav->edit_nav( array(
	    	'name' => $messages,
	        'position' => $messages_p,
	    ), 'messages' );
	    buddypress()->members->nav->edit_nav( array(
	    	'name' => $photos,
	        'position' => $photos_p,
	    ), 'photos' );
	    buddypress()->members->nav->edit_nav( array(
	    	'name' => $videos,
	        'position' => $videos_p,
	    ), 'videos' );
	    buddypress()->members->nav->edit_nav( array(
	    	'name' => $badges,
	        'position' => $badges_p,
	    ), 'badges' );
	    buddypress()->members->nav->edit_nav( array(
	    	'name' => $forums,
	        'position' => $forums_p,
	    ), 'forums' );
	    buddypress()->members->nav->edit_nav( array(
	    	'name' => $settings,
	        'position' => $settings_p,
	    ), 'settings' );
    	buddypress()->members->nav->edit_nav( array(
	        'name' => esc_html__( 'All Update', 'cirkle' ),
	    ), 'just-me', 'activity' );

	    if ( RDTheme::$options['profile_about_tab'] == 0 ) {
			bp_core_remove_nav_item( 'profile' );
		} if ( RDTheme::$options['profile_friends_tab'] == 0 ) {
			bp_core_remove_nav_item( 'friends' );
		} if ( RDTheme::$options['profile_groups_tab'] == 0 ) {
			bp_core_remove_nav_item( 'groups' );
		} if ( RDTheme::$options['profile_message_tab'] == 0 ) {
			bp_core_remove_nav_item( 'messages' );
		} if ( RDTheme::$options['profile_photos_tab'] == 0 ) {
			bp_core_remove_nav_item( 'photos' );
		} if ( RDTheme::$options['profile_videos_tab'] == 0 ) {
			bp_core_remove_nav_item( 'videos' );
		} if ( RDTheme::$options['profile_badges_tab'] == 0 ) {
			bp_core_remove_nav_item( 'badges' );
		} if ( RDTheme::$options['profile_forums_tab'] == 0 ) {
			bp_core_remove_nav_item( 'forums' );
		} if ( RDTheme::$options['profile_Settings_tab'] == 0 ) {
			bp_core_remove_nav_item( 'settings' );
		}
		bp_core_remove_nav_item( 'mediapress' );
	}

	public function cirkle_members_search_form() {
	  $search_form_html = '<div class="member-search-bar"><form action="" method="get" id="search-members-form"><div class="input-group">
	    <input type="text" class="form-control" name="s" id="members_search" placeholder="'. esc_attr( 'Member Search', 'cirkle' ) .'" />
	    <div class="input-group-append">
				<button type="submit" id="members_search_submit" class="bp-search-submit members-search-submit search-btn" name="members_search_submit">
					<i class="icofont-search"></i>
					<span id="button-text" class="bp-screen-reader-text">'. esc_html_x( 'Search', 'button', 'cirkle' ) .'</span>
				</button>
	        </div>
	  </div></form></div>';
	  return $search_form_html;
	}

	public function mpp_activity_upload_buttons() {

		$component    = mpp_get_current_component();
		$component_id = mpp_get_current_component_id();

		// If activity upload is disabled or the user is not allowed to upload to current component, don't show.
		if ( ! mpp_is_activity_upload_enabled( $component ) || ! mpp_user_can_upload( $component, $component_id ) ) {
			return;
		}

		// if we are here, the gallery activity stream upload is enabled,
		// let us see if we are on user profile and gallery is enabled.
		if ( ! mpp_is_enabled( $component, $component_id ) ) {
			return;
		}
		// if we are on group page and either the group component is not enabled or gallery is not enabled for current group, do not show the icons.
		if ( function_exists( 'bp_is_group' ) && bp_is_group() && ( ! mpp_is_active_component( 'groups' ) || ! ( function_exists( 'mpp_group_is_gallery_enabled' ) && mpp_group_is_gallery_enabled() ) ) ) {
			return;
		}
		// for now, avoid showing it on single gallery/media activity stream.
		if ( mpp_is_single_gallery() || mpp_is_single_media() ) {
			return;
		}
		
		?>
		<div id="mpp-activity-upload-buttons" class="mpp-upload-buttons">
			<?php do_action( 'mpp_before_activity_upload_buttons' ); // allow to add more type.  ?>
			<?php 
				$valid_types = mpp_get_active_types();
				// error_log( print_r($valid_types , true ) ); 
				if( ! empty( $valid_types ) ){
					foreach ($valid_types as $key => $value) { 
						?>
							<a href="#" id="mpp-<?php echo esc_attr( $key ); ?>-upload" data-media-type="<?php echo esc_attr( $key ); ?>" 
							title="<?php printf( esc_attr__( 'Upload %s', 'cirkle' ) , $value->singular_name ) ; ?>">
								<?php if( 'photo' === $key ) { ?>
									<i class="icofont-image"></i>
								<?php } ?>
								<?php if( 'video' === $key ) { ?>
									<i class="icofont-video-cam"></i>
								<?php } ?>
								<?php if( 'audio' === $key ) { ?>
									<i class="icofont-ui-volume"></i>
								<?php } ?>
								<?php if( 'doc' === $key ) { ?>
									<i class="icofont-law-document"></i>
								<?php } ?>
								
							</a>
						<?php
					}

				}

			?>
			

			<?php do_action( 'mpp_after_activity_upload_buttons' ); // allow to add more type.  ?>

		</div>
		<?php
	}

	public function mpp_activity_dropzone() {
		if( function_exists('mediapress')){
		?>
	    <div id="mpp-activity-media-upload-container" class="mpp-media-upload-container mpp-upload-container-inactive"><!-- mediapress upload container -->
	        <a href="#" class="mpp-upload-container-close" title="<?php esc_attr_e('Close', 'cirkle');?>"><span>x</span></a>
	        <!-- append uploaded media here -->
	        <div id="mpp-uploaded-media-list-activity" class="mpp-uploading-media-list">
	            <ul></ul>
	        </div>
			<?php do_action( 'mpp_after_activity_upload_medialist' ); ?>

			<?php if ( mpp_is_file_upload_enabled( 'activity' ) ): ?>
	            <!-- drop files here for uploading -->
				<?php mpp_upload_dropzone( 'activity' ); ?>
				<?php do_action( 'mpp_after_activity_upload_dropzone' ); ?>
	            <!-- show any feedback here -->
	            <div id="mpp-upload-feedback-activity" class="mpp-feedback">
	                <ul></ul>
	            </div>
			<?php endif; ?>
	        <input type='hidden' name='mpp-context' class='mpp-context' value="activity"/>
	        <?php do_action( 'mpp_after_activity_upload_feedback' ); ?>

		    <?php if ( mpp_is_remote_file_enabled() ) : ?>
	            <!-- remote media -->
	            <div class="mpp-remote-media-container">
	                <div class="mpp-feedback mpp-remote-media-upload-feedback">
	                    <ul></ul>
	                </div>
	                <div class="mpp-remote-add-media-row mpp-remote-add-media-row-activity">
	                    <input type="text" placeholder="<?php esc_attr_e( 'Enter a link', 'cirkle' );?>" value="" name="mpp-remote-media-url" id="mpp-remote-media-url" class="mpp-remote-media-url"/>
	                    <button id="mpp-add-remote-media" class="mpp-add-remote-media"><?php esc_attr_e( '+Add', 'cirkle' ); ?></button>
	                </div>
				    <?php wp_nonce_field( 'mpp_add_media', 'mpp-remote-media-nonce' ); ?>
	            </div>
	            <!-- end of remote media -->
		    <?php endif;?>

	    </div><!-- end of mediapress form container -->
		<?php }
	}

	public function cirkle_profile_photos() {
	    // global $bp;
	    bp_core_new_nav_item(
	        array(
	            'name'                => esc_html__( 'Photos', 'cirkle' ),
	            'slug'                => 'photos',
	            'position'            => 50,
	            'screen_function'     => [&$this, 'cirkle_photos_navigations'],
	            'default_subnav_slug' => 'photos',
	            'parent_url'          => buddypress()->loggedin_user->domain . buddypress()->slug . '/',
	            'parent_slug'         => buddypress()->slug
	        )
	    );
	    bp_core_new_nav_item(
	        array(
	            'name'                => esc_html__( 'Videos', 'cirkle' ),
	            'slug'                => 'videos',
	            'position'            => 60,
	            'screen_function'     => [&$this, 'cirkle_videos_navigations'],
	            'default_subnav_slug' => 'videos',
	            'parent_url'          => buddypress()->loggedin_user->domain . buddypress()->slug . '/',
	            'parent_slug'         => buddypress()->slug
	        )
	    );
	}

	// Photots
	public function cirkle_photos_navigations() {
	    add_action( 'bp_template_content', array( &$this, 'cirkle_photos_nav_content' ) );
	    bp_core_load_template( apply_filters( 'bp_core_template_plugin', 'members/single/plugins' ) );
	}

	public function cirkle_photos_nav_content() {

	    $defaults = array(
			// gallery type, all,audio,video,photo etc.
			'type'          => 'photo',
			'per_page'      => mpp_get_option( 'media_per_page' ),
			'offset'        => false,
			'paged'         => isset( $_REQUEST['mpage'] ) ? absint( $_REQUEST['mpage'] ) : '',
			'nopaging'      => false,
			'order'         => 'DESC',
			'orderby'       => 'date',
			'user_id'       => bp_displayed_user_id(),
			'user_name'     => '',
		);

		$query_args = $defaults;

	    $query = new \MPP_Media_Query( $query_args );

		mpp_widget_save_media_data( 'query', $query );

		$lightbox = mpp_get_option( 'load_lightbox' );

		$lightbox_enabled = ! empty( $lightbox ) ? 1 : 0;
		$lightbox_class   = $lightbox_enabled ? 'zoom-gallery' : '';

		$cols = mpp_get_option( 'media_columns' );
		if ($cols == 1) {
			$grid = 12;
		} elseif ($cols == 2) {
			$grid = 6;
		} elseif ($cols == 3) {
			$grid = 4;
		} elseif ($cols == 4) {
			$grid = 3;
		} else {
			$grid = 3;
		}

		/**
		 * Photo List
		 */
		$query = mpp_widget_get_media_data( 'query' );

		?>

		<?php if ( $query->have_media() ) : ?>

			<div class="mpp-container mpp-widget-container mpp-media-widget-container mpp-media-photo-widget-container">

				<div class='mpp-g mpp-item-list mpp-media-list mpp-photo-list <?php echo esc_attr( $lightbox_class ); ?> row rt-gutter-10'>

					<?php while ( $query->have_media() ) : $query->the_media(); ?>
						<?php $type = mpp_get_media_type(); ?>

						<div class="<?php mpp_media_class( 'mpp-widget-item mpp-widget-photo-item col-md-'.$grid ); ?> col-sm-6" data-mpp-type="<?php echo esc_attr( $type ); ?>">

							<?php do_action( 'mpp_before_media_widget_item' ); ?>

							<div class="mpp-item-meta mpp-media-meta mpp-media-widget-item-meta mpp-media-meta-top mpp-media-widget-item-meta-top">
								<?php do_action( 'mpp_media_widget_item_meta_top' ); ?>
							</div>
							<div class='mpp-item-entry mpp-media-entry mpp-photo-entry'>
								<a href="<?php mpp_media_src( 'full' ); ?>" <?php mpp_media_html_attributes( array(
									'class'            => 'mpp-item-thumbnail mpp-media-thumbnail mpp-photo-thumbnail popup-zoom',
									'data-mpp-context' => 'widget',
								) ); ?> data-mpp-type="<?php echo esc_attr( $type ); ?>">
									<img src="<?php mpp_media_src( 'cirkle-size-1' ); ?>" alt="<?php echo esc_attr( mpp_get_media_title() ); ?> "/>
								</a>
							</div>

							<div class="mpp-item-meta mpp-media-meta mpp-media-widget-item-meta mpp-media-meta-bottom mpp-media-widget-item-meta-bottom">
								<?php do_action( 'mpp_media_widget_item_meta' ); ?>
							</div>
							<?php do_action( 'mpp_after_media_widget_item' ); ?>
						</div>

					<?php endwhile; ?>
					<?php mpp_reset_media_data(); ?>
				</div>
				<div class="mpp-paginator cirkle-photos-pagination">
					<?php echo wp_kses_post( $query->paginate( false ) ); ?>
				</div>
			</div>
			<?php else: ?>
				<h6><?php esc_html_e( 'There have no media', 'cirkle' ); ?></h6>
			<?php endif;
			mpp_widget_reset_media_data( 'query' );
	    ?>

		<?php
	}

	// Videos
	public function cirkle_videos_navigations() {
	   add_action( 'bp_template_content', array( &$this, 'cirkle_videos_nav_content' ) );
	   bp_core_load_template( apply_filters( 'bp_core_template_plugin', 'members/single/plugins' ) );
	}

	public function cirkle_videos_nav_content() {

	    $defaults = array(
			'type'          => 'video',
			'per_page'      => false,
			'offset'        => false,
			'page'          => false,
			'nopaging'      => false,
			'order'         => 'DESC',
			'orderby'       => 'date',
			'user_id'       => bp_displayed_user_id(),
			'user_name'     => '',
		);

		$query_args = $defaults;

	    $query = new \MPP_Media_Query( $query_args );

		mpp_widget_save_media_data( 'query', $query );

		/**
		 * Shortcode Photo List
		 */
		$query = mpp_widget_get_media_data( 'query' ); ?>

		<?php if ( $query->have_media() ) : ?>

			<div class="mpp-container mpp-widget-container mpp-media-widget-container mpp-media-video-widget-container">
				<div class='mpp-g mpp-item-list mpp-media-list mpp-video-list row'>

					<?php while ( $query->have_media() ) : $query->the_media(); ?>
						<?php $type = mpp_get_media_type(); ?>

						<div class="<?php mpp_media_class( 'mpp-widget-item mpp-widget-video-item col-lg-4 col-sm-6' ); ?>" data-mpp-type="<?php echo esc_attr( $type ); ?>">
							<?php do_action( 'mpp_before_media_widget_item' ); ?>
							<div class="video-wrap user-video">
								<video src="<?php echo esc_url( mpp_get_media_src() ); ?>" controls></video>
							</div>
							<?php do_action( 'mpp_after_media_widget_item' ); ?>
						</div>

					<?php endwhile; ?>
					<?php mpp_reset_media_data(); ?>
				</div>
			</div>
			<?php else: ?>
				<h6><?php esc_html_e( 'There have no videos', 'cirkle' ); ?></h6>
			<?php endif;

			mpp_widget_reset_media_data( 'query' );
	    ?>

		<?php
	}

	//added version 1.1.4
	public static function bp_group_join_button( $group = false ) {
		echo bp_get_group_join_button( $group );
	}

}
new BuddyPress_Setup;
