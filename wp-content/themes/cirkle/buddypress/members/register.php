<?php
/**
 * BuddyPress - Members Register
 *
 * @package BuddyPress
 * @subpackage bp-legacy
 * @version 3.0.0
 */
use radiustheme\cirkle\RDTheme;
use radiustheme\cirkle\BuddyPress_Setup;
?>

<div id="buddypress">

	<?php

	/**
	 * Fires at the top of the BuddyPress member registration page template.
	 *
	 * @since 1.1.0
	 */
	do_action( 'bp_before_register_page' ); ?>

	<div class="page" id="register-page">
		<div class="container">
			<div class="col-12">
				<?php 
                    $circleBuddy = new BuddyPress_Setup();
                    $error = $circleBuddy->cirkle_register_messages();
                    if (!empty( $error )) {
                        $active1 = '';
                        $show1 = '';
                        $active2 = 'active';
                        $show2 = 'show active';
                    } else {
                        $active1 = 'active';
                        $show1 = 'show active';
                        $active2 = '';
                        $show2 = '';
                    }
                ?>
				<div class="login-form-wrap">
			        <ul class="nav nav-tabs" role="tablist">
			            <li class="nav-item">
			                <a class="nav-link <?php echo $active1 ?>" data-toggle="tab" href="#login-tab" role="tab" aria-selected="true"><i class="icofont-users-alt-4"></i> <?php esc_html_e( 'Sign In', 'cirkle' ); ?> </a>
			            </li>
			            <?php if(empty($user_ID)) { ?>
			            <li class="nav-item">
			                <a class="nav-link <?php echo $active2 ?>" data-toggle="tab" href="#registration-tab" role="tab" aria-selected="false"><i class="icofont-download"></i> <?php esc_html_e( 'Registration', 'cirkle' ); ?></a>
			            </li>
			            <?php } ?>
			        </ul>
			        <div class="tab-content">
			            <div class="tab-pane login-tab fade <?php echo $show1 ?>" id="login-tab" role="tabpanel">
			                <?php if ( !empty( RDTheme::$options['form_title'] ) ) { ?>
			                <h3 class="item-title"><?php echo esc_html( RDTheme::$options['form_title'] ); ?></h3>
			                <?php } ?>
			                <?php 
			                    if(empty($user_ID)) { ?>
			                        <?php
			                            if (isset($_GET['reason'])) {
			                                echo '<p class="alert-danger">';
			                                switch ($_GET['reason']) {
			                                    case 'invalid_username':
			                                        $warning = esc_html__( 'Incorrect Username', 'cirkle' );
			                                        break;
			                                    case 'incorrect_password':
			                                        $warning = esc_html__( 'Incorrect Password', 'cirkle' );
			                                        break;
			                                    default:
			                                        $warning = esc_html__( 'Error username or password', 'cirkle' );
			                                        break;
			                                }
			                                echo esc_html($warning);
			                                echo '</p>';
			                            } 
			                        ?>         
			                        <h5><?php esc_html_e( 'You are now logged out.', 'cirkle' ); ?></h5>
			                        <!-- Modal Content -->
			                        <form class="modal-form" action="<?php echo site_url( '/wp-login.php' ); ?>" method="post">
			                            <?php $rememberme = ! empty( $_POST['rememberme'] ); ?>
			                            <div class="login-form-body">
			                                <div class="form-group">
			                                    <input class="form-control" type="text" name="log" placeholder="<?php esc_attr_e( 'Username', 'cirkle' ); ?>" required>
			                                </div>
			                                <div class="form-group">
			                                    <input class="form-control" type="password" name="pwd" id="user_pass" placeholder="<?php esc_attr_e( 'Password', 'cirkle' ); ?>" required>
			                                </div>
			                                <div class="form-group mb-4 checking-box">
			                                    <div class="remember-me form-check">
			                                        <input name="rememberme" type="checkbox" id="rememberme" value="forever" <?php checked( $rememberme ); ?> /> 
			                                        <label for="rememberme"><?php esc_html_e( 'Remember me', 'cirkle' ); ?></label>
			                                    </div>
			                                </div>
			                                <div class="form-group">
			                                    <button class="submit-btn btn" type="submit"><?php esc_html_e( 'Login', 'cirkle' ); ?></button>
			                                </div>
			                            </div>
			                            <?php 
			                                $shortcode = RDTheme::$options['social_login_shortcode'];
			                                if ( $shortcode ) {
			                                    echo sprintf( '<div class="social-login">%s</div>', do_shortcode( $shortcode ) );
			                                } 
			                            ?>
			                            <div class="form-footer">
			                                <span class="forget-psw"><a href="<?php echo wp_lostpassword_url(); ?>">
			                                    <?php esc_html_e( 'Lost Your password ?', 'cirkle' ); ?></a></span>
			                                <span class="back-to-site">
			                                    <a href="<?php echo esc_url( home_url('/') ); ?>"><i class="icofont-long-arrow-left"></i><?php esc_html_e( ' Back to Home', 'cirkle' ) . ' '. get_bloginfo( 'name' ); ?></a>
			                                </span>
			                            </div>
			                        </form>
			                    <?php } else { ?>
			                        <h6><?php esc_html_e( 'You Are Already Logged In', 'cirkle' ); ?></h6>
			                <?php } ?>
			            </div>
			            <div class="tab-pane registration-tab fade <?php echo $show2 ?>" id="registration-tab" role="tabpanel">
			                <h3 class="item-title"><?php esc_html_e( 'Sign Up Your Account', 'cirkle' ); ?></h3>
			                <form action="" name="signup_form" id="signup_form" class="standard-form" method="post" enctype="multipart/form-data">
								<?php if ( 'registration-disabled' == bp_get_current_signup_step() ) : ?>

									<div id="template-notices" role="alert" aria-atomic="true">
										<?php

										/** This action is documented in bp-templates/bp-legacy/buddypress/activity/index.php */
										do_action( 'template_notices' ); ?>
									</div>

									<?php

									/**
									 * Fires before the display of the registration disabled message.
									 *
									 * @since 1.5.0
									 */
									do_action( 'bp_before_registration_disabled' ); ?>

										<p><?php esc_html_e( 'User registration is currently not allowed.', 'cirkle' ); ?></p>

									<?php

									/**
									 * Fires after the display of the registration disabled message.
									 *
									 * @since 1.5.0
									 */
									do_action( 'bp_after_registration_disabled' ); ?>
								<?php endif; // registration-disabled signup step ?>

								<?php if ( 'request-details' == bp_get_current_signup_step() ) : ?>

									<div id="template-notices" role="alert" aria-atomic="true">
										<?php

										/** This action is documented in bp-templates/bp-legacy/buddypress/activity/index.php */
										do_action( 'template_notices' ); ?>

									</div>

									<p><?php _e( 'Registering for this site is easy. Just fill in the fields below, and we\'ll get a new account set up for you in no time.', 'cirkle' ); ?></p>

								<div class="account-profile">

									<?php

									/**
									 * Fires before the display of member registration account details fields.
									 *
									 * @since 1.1.0
									 */
									do_action( 'bp_before_account_details_fields' ); ?>

									<div class="register-section" id="basic-details-section">

										<?php /***** Basic Account Details ******/ ?>

										<h4><?php _e( 'Account Details', 'cirkle' ); ?></h4>

										<label for="signup_username"><?php _e( 'Username', 'cirkle' ); ?> <?php _e( '(required)', 'cirkle' ); ?></label>
										<?php

										/**
										 * Fires and displays any member registration username errors.
										 *
										 * @since 1.1.0
										 */
										do_action( 'bp_signup_username_errors' ); ?>
										<input type="text" name="signup_username" id="signup_username" value="<?php bp_signup_username_value(); ?>" <?php bp_form_field_attributes( 'username' ); ?>/>

										<label for="signup_email"><?php _e( 'Email Address', 'cirkle' ); ?> <?php _e( '(required)', 'cirkle' ); ?></label>
										<?php

										/**
										 * Fires and displays any member registration email errors.
										 *
										 * @since 1.1.0
										 */
										do_action( 'bp_signup_email_errors' ); ?>
										<input type="email" name="signup_email" id="signup_email" value="<?php bp_signup_email_value(); ?>" <?php bp_form_field_attributes( 'email' ); ?>/>

										<label for="signup_password"><?php _e( 'Choose a Password', 'cirkle' ); ?> <?php _e( '(required)', 'cirkle' ); ?></label>
										<?php

										/**
										 * Fires and displays any member registration password errors.
										 *
										 * @since 1.1.0
										 */
										do_action( 'bp_signup_password_errors' ); ?>
										<input type="password" name="signup_password" id="signup_password" value="" class="password-entry" <?php bp_form_field_attributes( 'password' ); ?>/>
										<div id="pass-strength-result"></div>

										<label for="signup_password_confirm"><?php _e( 'Confirm Password', 'cirkle' ); ?> <?php _e( '(required)', 'cirkle' ); ?></label>
										<?php

										/**
										 * Fires and displays any member registration password confirmation errors.
										 *
										 * @since 1.1.0
										 */
										do_action( 'bp_signup_password_confirm_errors' ); ?>
										<input type="password" name="signup_password_confirm" id="signup_password_confirm" value="" class="password-entry-confirm" <?php bp_form_field_attributes( 'password' ); ?>/>

										<?php

										/**
										 * Fires and displays any extra member registration details fields.
										 *
										 * @since 1.9.0
										 */
										do_action( 'bp_account_details_fields' ); ?>
									</div><!-- #basic-details-section -->

									<?php

									/**
									 * Fires after the display of member registration account details fields.
									 *
									 * @since 1.1.0
									 */
									do_action( 'bp_after_account_details_fields' ); ?>


									<?php /***** Extra Profile Details ******/ ?>



									<?php if ( bp_is_active( 'xprofile' ) ) : ?>

										<?php

										/**
										 * Fires before the display of member registration xprofile fields.
										 *
										 * @since 1.2.4
										 */
										do_action( 'bp_before_signup_profile_fields' ); ?>

										<div class="register-section" id="profile-details-section">

											<h4><?php _e( 'Profile Details', 'cirkle' ); ?></h4>

											<?php /* Use the profile field loop to render input fields for the 'base' profile field group */ ?>
											<?php if ( bp_is_active( 'xprofile' ) ) : if ( bp_has_profile( bp_xprofile_signup_args() ) ) : while ( bp_profile_groups() ) : bp_the_profile_group(); ?>

											<?php while ( bp_profile_fields() ) : bp_the_profile_field(); ?>

												<div<?php bp_field_css_class( 'editfield' ); ?>>
													<fieldset>

													<?php
													$field_type = bp_xprofile_create_field_type( bp_get_the_profile_field_type() );
													$field_type->edit_field_html();

													/**
													 * Fires before the display of the visibility options for xprofile fields.
													 *
													 * @since 1.7.0
													 */
													do_action( 'bp_custom_profile_edit_fields_pre_visibility' );

													if ( bp_current_user_can( 'bp_xprofile_change_field_visibility' ) ) : ?>
														<p class="field-visibility-settings-toggle" id="field-visibility-settings-toggle-<?php bp_the_profile_field_id() ?>"><span id="<?php bp_the_profile_field_input_name(); ?>-2">
															<?php
															printf(
																/* translators: %s: level of visibility */
																__( 'This field can be seen by: %s', 'cirkle' ),
																'<span class="current-visibility-level">' . bp_get_the_profile_field_visibility_level_label() . '</span>'
															);
															?>
															</span>
															<button type="button" class="visibility-toggle-link" aria-describedby="<?php bp_the_profile_field_input_name(); ?>-2" aria-expanded="false"><?php _ex( 'Change', 'Change profile field visibility level', 'cirkle' ); ?></button>
														</p>

														<div class="field-visibility-settings" id="field-visibility-settings-<?php bp_the_profile_field_id() ?>">
															<fieldset>
																<legend><?php _e( 'Who can see this field?', 'cirkle' ) ?></legend>

																<?php bp_profile_visibility_radio_buttons() ?>

															</fieldset>
															<button type="button" class="field-visibility-settings-close"><?php _e( 'Close', 'cirkle' ) ?></button>

														</div>
													<?php else : ?>
														<p class="field-visibility-settings-notoggle" id="field-visibility-settings-toggle-<?php bp_the_profile_field_id() ?>">
															<?php
															printf(
																__( 'This field can be seen by: %s', 'cirkle' ),
																'<span class="current-visibility-level">' . bp_get_the_profile_field_visibility_level_label() . '</span>'
															);
															?>
														</p>
													<?php endif ?>

													<?php

													/**
													 * Fires after the display of the visibility options for xprofile fields.
													 *
													 * @since 1.1.0
													 */
													do_action( 'bp_custom_profile_edit_fields' ); ?>

													</fieldset>
												</div>

											<?php endwhile; ?>

											<input type="hidden" name="signup_profile_field_ids" id="signup_profile_field_ids" value="<?php bp_the_profile_field_ids(); ?>" />

											<?php endwhile; endif; endif; ?>

											<?php

											/**
											 * Fires and displays any extra member registration xprofile fields.
											 *
											 * @since 1.9.0
											 */
											do_action( 'bp_signup_profile_fields' ); ?>

										</div><!-- #profile-details-section -->

										<?php

										/**
										 * Fires after the display of member registration xprofile fields.
										 *
										 * @since 1.1.0
										 */
										do_action( 'bp_after_signup_profile_fields' ); ?>

									<?php endif; ?>

									<?php if ( bp_get_blog_signup_allowed() ) : ?>

										<?php

										/**
										 * Fires before the display of member registration blog details fields.
										 *
										 * @since 1.1.0
										 */
										do_action( 'bp_before_blog_details_fields' ); ?>

										<?php /***** Blog Creation Details ******/ ?>

										<div class="register-section" id="blog-details-section">

											<h2><?php _e( 'Blog Details', 'cirkle' ); ?></h2>

											<p><label for="signup_with_blog"><input type="checkbox" name="signup_with_blog" id="signup_with_blog" value="1"<?php if ( (int) bp_get_signup_with_blog_value() ) : ?> checked="checked"<?php endif; ?> /> <?php _e( 'Yes, I\'d like to create a new site', 'cirkle' ); ?></label></p>

											<div id="blog-details"<?php if ( (int) bp_get_signup_with_blog_value() ) : ?>class="show"<?php endif; ?>>

												<label for="signup_blog_url"><?php _e( 'Blog URL', 'cirkle' ); ?> <?php _e( '(required)', 'cirkle' ); ?></label>
												<?php

												/**
												 * Fires and displays any member registration blog URL errors.
												 *
												 * @since 1.1.0
												 */
												do_action( 'bp_signup_blog_url_errors' ); ?>

												<?php if ( is_subdomain_install() ) : ?>
													http:// <input type="text" name="signup_blog_url" id="signup_blog_url" value="<?php bp_signup_blog_url_value(); ?>" /> .<?php bp_signup_subdomain_base(); ?>
												<?php else : ?>
													<?php echo home_url( '/' ); ?> <input type="text" name="signup_blog_url" id="signup_blog_url" value="<?php bp_signup_blog_url_value(); ?>" />
												<?php endif; ?>

												<label for="signup_blog_title"><?php _e( 'Site Title', 'cirkle' ); ?> <?php _e( '(required)', 'cirkle' ); ?></label>
												<?php

												/**
												 * Fires and displays any member registration blog title errors.
												 *
												 * @since 1.1.0
												 */
												do_action( 'bp_signup_blog_title_errors' ); ?>
												<input type="text" name="signup_blog_title" id="signup_blog_title" value="<?php bp_signup_blog_title_value(); ?>" />

												<fieldset class="register-site">
													<legend class="label"><?php _e( 'Privacy: I would like my site to appear in search engines, and in public listings around this network.', 'cirkle' ); ?></legend>
													<?php

													/**
													 * Fires and displays any member registration blog privacy errors.
													 *
													 * @since 1.1.0
													 */
													do_action( 'bp_signup_blog_privacy_errors' ); ?>

													<label for="signup_blog_privacy_public"><input type="radio" name="signup_blog_privacy" id="signup_blog_privacy_public" value="public"<?php if ( 'public' == bp_get_signup_blog_privacy_value() || !bp_get_signup_blog_privacy_value() ) : ?> checked="checked"<?php endif; ?> /> <?php _e( 'Yes', 'cirkle' ); ?></label>
													<label for="signup_blog_privacy_private"><input type="radio" name="signup_blog_privacy" id="signup_blog_privacy_private" value="private"<?php if ( 'private' == bp_get_signup_blog_privacy_value() ) : ?> checked="checked"<?php endif; ?> /> <?php _e( 'No', 'cirkle' ); ?></label>
												</fieldset>

												<?php

												/**
												 * Fires and displays any extra member registration blog details fields.
												 *
												 * @since 1.9.0
												 */
												do_action( 'bp_blog_details_fields' ); ?>

											</div>

										</div><!-- #blog-details-section -->

										<?php

										/**
										 * Fires after the display of member registration blog details fields.
										 *
										 * @since 1.1.0
										 */
										do_action( 'bp_after_blog_details_fields' ); ?>

									<?php endif; ?>

								</div>



									<?php 
						                $captcha_shortcode = RDTheme::$options['registration_captcha_shortcode'];
						                if ( $captcha_shortcode ) {
						                    echo sprintf( '<div class="cirkle-reCaptcha">%s</div>', do_shortcode( $captcha_shortcode ) );
						                } 
						            ?>

									<?php

									/**
									 * Fires before the display of the registration submit buttons.
									 *
									 * @since 1.1.0
									 */
									do_action( 'bp_before_registration_submit_buttons' );

									if ( bp_get_membership_requests_required() ) {
										$button_text = __( 'Submit Request', 'cirkle' );
									} else {
										$button_text = __( 'Complete Sign Up', 'cirkle' );
									}
									?>

									<div class="submit">
										<input type="submit" name="signup_submit" id="signup_submit" value="<?php echo esc_attr( $button_text ); ?>" />
									</div>

									<?php

									/**
									 * Fires after the display of the registration submit buttons.
									 *
									 * @since 1.1.0
									 */
									do_action( 'bp_after_registration_submit_buttons' ); ?>

									<?php wp_nonce_field( 'bp_new_signup' ); ?>

								<?php endif; // request-details signup step ?>

								<?php if ( 'completed-confirmation' == bp_get_current_signup_step() ) : ?>

									<div id="template-notices" role="alert" aria-atomic="true">
										<?php

										/** This action is documented in bp-templates/bp-legacy/buddypress/activity/index.php */
										do_action( 'template_notices' ); ?>

									</div>

									<?php

									/**
									 * Fires before the display of the registration confirmed messages.
									 *
									 * @since 1.5.0
									 */
									do_action( 'bp_before_registration_confirmed' ); ?>

									<div id="template-notices" role="alert" aria-atomic="true">
										<?php if ( bp_get_membership_requests_required() ) : ?>
											<p><?php _e( 'You have successfully submitted your membership request! Our site moderators will review your submission and send you an activation email if your request is approved.', 'cirkle' ); ?></p>
										<?php elseif ( bp_registration_needs_activation() ) : ?>
											<p><?php _e( 'You have successfully created your account! To begin using this site you will need to activate your account via the email we have just sent to your address.', 'cirkle' ); ?></p>
										<?php else : ?>
											<p><?php _e( 'You have successfully created your account! Please log in using the username and password you have just created.', 'cirkle' ); ?></p>
										<?php endif; ?>
									</div>

									<?php

									/**
									 * Fires after the display of the registration confirmed messages.
									 *
									 * @since 1.5.0
									 */
									do_action( 'bp_after_registration_confirmed' ); ?>

								<?php endif; // completed-confirmation signup step ?>

								<?php

								/**
								 * Fires and displays any custom signup steps.
								 *
								 * @since 1.1.0
								 */
								do_action( 'bp_custom_signup_steps' ); ?>
							</form>
			            </div>
			        </div>
			    </div>

			</div>
		</div>
	</div>

	<?php

	/**
	 * Fires at the bottom of the BuddyPress member registration page template.
	 *
	 * @since 1.1.0
	 */
	do_action( 'bp_after_register_page' ); ?>

</div><!-- #buddypress -->
