<?php
/**
 * BuddyPress - Groups Create
 *
 * @package BuddyPress
 * @subpackage bp-legacy
 * @version 3.0.0
 */

use radiustheme\cirkle\RDTheme;
use radiustheme\cirkle\Helper;

/**
 * Fires at the top of the groups creation template file.
 *
 * @since 1.7.0
 */
do_action( 'bp_before_create_group_page' ); ?>

<div id="buddypress-cirkle">

	<?php
		$page_title = RDTheme::$options['groups_banner_title'];
		$size = 'full';
		$img_id = RDTheme::$options['cirkle_gb_img'];
		$page_img = Helper::cirkle_get_attach_img( $img_id, $size );

		$img_id2 = RDTheme::$options['cirkle_gb_shape_img'];
		$page_shape_img = Helper::cirkle_get_attach_img( $img_id2, $size );
	?>

	<!-- Banner Area Start -->
	<div class="newsfeed-banner groups-page-banner">
	    <div class="media">
	        <div class="item-icon">
	            <i class="icofont-megaphone-alt"></i>
	        </div>
	        <div class="media-body">
	            <h3 class="item-title"><?php echo esc_html( $page_title ); ?></h3>
	            <div class="item-list-tabs" aria-label="<?php esc_attr_e( 'Groups directory main navigation', 'cirkle' ); ?>">
					<ul class="user-meta">
						<li class="selected" id="groups-all">
							<a href="<?php bp_groups_directory_permalink(); ?>">
								<?php
								/* translators: %s: all groups count */
								printf( __( 'All Groups %s', 'cirkle' ), '<span>' . bp_get_total_group_count() . '</span>' );
								?>
							</a>
						</li>

						<?php if ( is_user_logged_in() && bp_get_total_group_count_for_user( bp_loggedin_user_id() ) ) : ?>
							<li id="groups-personal">
								<a href="<?php echo bp_loggedin_user_domain() . bp_get_groups_slug() . '/my-groups/'; ?>">
									<?php
									/* translators: %s: current user groups count */
									printf( __( 'My Groups %s', 'cirkle' ), '<span>' . bp_get_total_group_count_for_user( bp_loggedin_user_id() ) . '</span>' );
									?>
								</a>
							</li>
						<?php endif; ?>

						<?php

						/**
						 * Fires inside the groups directory group filter input.
						 *
						 * @since 1.5.0
						 */
						do_action( 'bp_groups_directory_group_filter' ); ?>

					</ul>
				</div><!-- .item-list-tabs -->
	        </div>
	    </div>
	    <?php if (!empty( $page_shape_img || $page_img )) { ?>
	    <ul class="animation-img">
	        <li data-sal="slide-down" data-sal-duration="800" data-sal-delay="400"><?php echo wp_kses( $page_shape_img, 'alltext_allow' ); ?></li>
	        <li data-sal="slide-up" data-sal-duration="500"><?php echo wp_kses( $page_img, 'alltext_allow' ); ?></li>
	    </ul>
	    <?php } ?>
	</div>

	<?php

	/**
	 * Fires before the display of group creation content.
	 *
	 * @since 1.6.0
	 */
	do_action( 'bp_before_create_group_content_template' ); ?>

	<form action="<?php bp_group_creation_form_action(); ?>" method="post" id="create-group-form" class="standard-form cirkle-create-form-group" enctype="multipart/form-data">

		<?php
		/**
		 * Fires before the display of group creation.
		 *
		 * @since 1.2.0
		 */
		do_action( 'bp_before_create_group' ); ?>

		<div class="item-list-tabs no-ajax" id="group-create-tabs">
			<ul>
				<?php bp_group_creation_tabs(); ?>
			</ul>
		</div>

		<div id="template-notices" role="alert" aria-atomic="true">
			<?php
			/** This action is documented in bp-templates/bp-legacy/buddypress/activity/index.php */
			do_action( 'template_notices' ); ?>
		</div>

		<div class="item-body create-form-body" id="group-create-body">

			<?php /* Group creation step 1: Basic group details */ ?>
			<?php if ( bp_is_group_creation_step( 'group-details' ) ) : ?>

				<h2 class="bp-screen-reader-text"><?php
					/* translators: accessibility text */
					esc_html_e( 'Group Details', 'cirkle' );
				?></h2>

				<?php
				/**
				 * Fires before the display of the group details creation step.
				 *
				 * @since 1.1.0
				 */
				do_action( 'bp_before_group_details_creation_step' ); ?>

				<div>
					<label for="group-name"><?php esc_html_e( 'Group Name (required)', 'cirkle' ); ?></label>
					<input type="text" name="group-name" id="group-name" aria-required="true" value="<?php echo esc_attr( bp_get_new_group_name() ); ?>" />
				</div>
				<div>
					<label for="group-desc"><?php esc_html_e( 'Group Description (required)', 'cirkle' ); ?></label>
					<textarea name="group-desc" id="group-desc" aria-required="true"><?php bp_new_group_description(); ?></textarea>
				</div>

				<?php
				/**
				 * Fires after the display of the group details creation step.
				 *
				 * @since 1.1.0
				 */
				do_action( 'bp_after_group_details_creation_step' );
				do_action( 'groups_custom_group_fields_editable' ); // @Deprecated
				wp_nonce_field( 'groups_create_save_group-details' ); ?>

			<?php endif; ?>

			<?php /* Group creation step 2: Group settings */ ?>
			<?php if ( bp_is_group_creation_step( 'group-settings' ) ) : ?>

				<h2 class="bp-screen-reader-text"><?php
					/* translators: accessibility text */
					esc_html_e( 'Group Settings', 'cirkle' );
				?></h2>

				<?php

				/**
				 * Fires before the display of the group settings creation step.
				 *
				 * @since 1.1.0
				 */
				do_action( 'bp_before_group_settings_creation_step' ); ?>

				<fieldset class="group-create-privacy">
					<legend><?php esc_html_e( 'Privacy Options', 'cirkle' ); ?></legend>
					<div class="radio">
						<label for="group-status-public"><input type="radio" name="group-status" id="group-status-public" value="public"<?php if ( 'public' == bp_get_new_group_status() || !bp_get_new_group_status() ) { ?> checked="checked"<?php } ?> aria-describedby="public-group-description" /> <?php esc_html_e( 'This is a public group', 'cirkle' ); ?></label>

						<ul id="public-group-description">
							<li><?php esc_html_e( 'Any site member can join this group.', 'cirkle' ); ?></li>
							<li><?php esc_html_e( 'This group will be listed in the groups directory and in search results.', 'cirkle' ); ?></li>
							<li><?php esc_html_e( 'Group content and activity will be visible to any site member.', 'cirkle' ); ?></li>
						</ul>

						<label for="group-status-private"><input type="radio" name="group-status" id="group-status-private" value="private"<?php if ( 'private' == bp_get_new_group_status() ) { ?> checked="checked"<?php } ?> aria-describedby="private-group-description" /> <?php esc_html_e( 'This is a private group', 'cirkle' ); ?></label>

						<ul id="private-group-description">
							<li><?php esc_html_e( 'Only users who request membership and are accepted can join the group.', 'cirkle' ); ?></li>
							<li><?php esc_html_e( 'This group will be listed in the groups directory and in search results.', 'cirkle' ); ?></li>
							<li><?php esc_html_e( 'Group content and activity will only be visible to members of the group.', 'cirkle' ); ?></li>
						</ul>

						<label for="group-status-hidden"><input type="radio" name="group-status" id="group-status-hidden" value="hidden"<?php if ( 'hidden' == bp_get_new_group_status() ) { ?> checked="checked"<?php } ?> aria-describedby="hidden-group-description" /> <?php esc_html_e('This is a hidden group', 'cirkle' ); ?></label>

						<ul id="hidden-group-description">
							<li><?php esc_html_e( 'Only users who are invited can join the group.', 'cirkle' ); ?></li>
							<li><?php esc_html_e( 'This group will not be listed in the groups directory or search results.', 'cirkle' ); ?></li>
							<li><?php esc_html_e( 'Group content and activity will only be visible to members of the group.', 'cirkle' ); ?></li>
						</ul>
					</div>

				</fieldset>

				<?php // Group type selection ?>
				<?php if ( $group_types = bp_groups_get_group_types( array( 'show_in_create_screen' => true ), 'objects' ) ): ?>

					<fieldset class="group-create-types">
						<legend><?php esc_html_e( 'Group Types', 'cirkle' ); ?></legend>

						<p><?php esc_html_e( 'Select the types this group should be a part of.', 'cirkle' ); ?></p>

						<?php foreach ( $group_types as $type ) : ?>
							<div class="checkbox">
								<label for="<?php printf( 'group-type-%s', $type->name ); ?>"><input type="checkbox" name="group-types[]" id="<?php printf( 'group-type-%s', $type->name ); ?>" value="<?php echo esc_attr( $type->name ); ?>" <?php checked( true, ! empty( $type->create_screen_checked ) ); ?> /> <?php echo esc_html( $type->labels['name'] ); ?>
									<?php
										if ( ! empty( $type->description ) ) {
											/* translators: Group type description shown when creating a group. */
											printf( __( '&ndash; %s', 'cirkle' ), '<span class="bp-group-type-desc">' . esc_html( $type->description ) . '</span>' );
										}
									?>
								</label>
							</div>
						<?php endforeach; ?>
					</fieldset>

				<?php endif; ?>

				<fieldset class="group-create-invitations">
					<legend><?php esc_html_e( 'Group Invitations', 'cirkle' ); ?></legend>
					<p><?php esc_html_e( 'Which members of this group are allowed to invite others?', 'cirkle' ); ?></p>
					<div class="radio">
						<label for="group-invite-status-members"><input type="radio" name="group-invite-status" id="group-invite-status-members" value="members"<?php bp_group_show_invite_status_setting( 'members' ); ?> /> <?php esc_html_e( 'All group members', 'cirkle' ); ?></label>
						<label for="group-invite-status-mods"><input type="radio" name="group-invite-status" id="group-invite-status-mods" value="mods"<?php bp_group_show_invite_status_setting( 'mods' ); ?> /> <?php esc_html_e( 'Group admins and mods only', 'cirkle' ); ?></label>
						<label for="group-invite-status-admins"><input type="radio" name="group-invite-status" id="group-invite-status-admins" value="admins"<?php bp_group_show_invite_status_setting( 'admins' ); ?> /> <?php esc_html_e( 'Group admins only', 'cirkle' ); ?></label>
					</div>
				</fieldset>

				<?php
				/**
				 * Fires after the display of the group settings creation step.
				 *
				 * @since 1.1.0
				 */
				do_action( 'bp_after_group_settings_creation_step' ); ?>

				<?php wp_nonce_field( 'groups_create_save_group-settings' ); ?>

			<?php endif; ?>

			<?php /* Group creation step 3: Avatar Uploads */ ?>
			<?php if ( bp_is_group_creation_step( 'group-avatar' ) ) : ?>

				<h2 class="bp-screen-reader-text"><?php
					/* translators: accessibility text */
					esc_html_e( 'Group Avatar', 'cirkle' );
				?></h2>

				<?php

				/**
				 * Fires before the display of the group avatar creation step.
				 *
				 * @since 1.1.0
				 */
				do_action( 'bp_before_group_avatar_creation_step' ); ?>

				<?php if ( 'upload-image' == bp_get_avatar_admin_step() ) : ?>

					<div class="left-menu">
						<?php bp_new_group_avatar(); ?>
					</div><!-- .left-menu -->

					<div class="main-column">
						<p><?php esc_html_e( "Upload an image to use as a profile photo for this group. The image will be shown on the main group page, and in search results.", 'cirkle' ); ?></p>

						<p>
							<label for="file" class="bp-screen-reader-text"><?php
								/* translators: accessibility text */
								esc_html_e( 'Select an image', 'cirkle' );
							?></label>
							<input type="file" name="file" id="file" />
							<input type="submit" name="upload" id="upload" value="<?php esc_attr_e( 'Upload Image', 'cirkle' ); ?>" />
							<input type="hidden" name="action" id="action" value="bp_avatar_upload" />
						</p>

						<p><?php esc_html_e( 'To skip the group profile photo upload process, hit the "Next Step" button.', 'cirkle' ); ?></p>
					</div><!-- .main-column -->

					<?php
					/**
					 * Load the Avatar UI templates
					 *
					 * @since 2.3.0
					 */
					bp_avatar_get_templates(); ?>

				<?php endif; ?>

				<?php if ( 'crop-image' == bp_get_avatar_admin_step() ) : ?>

					<h4><?php esc_html_e( 'Crop Group Profile Photo', 'cirkle' ); ?></h4>

					<img src="<?php bp_avatar_to_crop(); ?>" id="avatar-to-crop" class="avatar" alt="<?php esc_attr_e( 'Profile photo to crop', 'cirkle' ); ?>" />

					<div id="avatar-crop-pane">
						<img src="<?php bp_avatar_to_crop(); ?>" id="avatar-crop-preview" class="avatar" alt="<?php esc_attr_e( 'Profile photo preview', 'cirkle' ); ?>" />
					</div>

					<input type="submit" name="avatar-crop-submit" id="avatar-crop-submit" value="<?php esc_attr_e( 'Crop Image', 'cirkle' ); ?>" />

					<input type="hidden" name="image_src" id="image_src" value="<?php bp_avatar_to_crop_src(); ?>" />
					<input type="hidden" name="upload" id="upload" />
					<input type="hidden" id="x" name="x" />
					<input type="hidden" id="y" name="y" />
					<input type="hidden" id="w" name="w" />
					<input type="hidden" id="h" name="h" />

				<?php endif; ?>

				<?php

				/**
				 * Fires after the display of the group avatar creation step.
				 *
				 * @since 1.1.0
				 */
				do_action( 'bp_after_group_avatar_creation_step' ); ?>

				<?php wp_nonce_field( 'groups_create_save_group-avatar' ); ?>

			<?php endif; ?>

			<?php /* Group creation step 4: Cover image */ ?>
			<?php if ( bp_is_group_creation_step( 'group-cover-image' ) ) : ?>

				<h2 class="bp-screen-reader-text"><?php
					/* translators: accessibility text */
					esc_html_e( 'Cover Image', 'cirkle' );
				?></h2>

				<?php

				/**
				 * Fires before the display of the group cover image creation step.
				 *
				 * @since 2.4.0
				 */
				do_action( 'bp_before_group_cover_image_creation_step' ); ?>

				<div id="header-cover-image"></div>

				<p><?php esc_html_e( 'The Cover Image will be used to customize the header of your group.', 'cirkle' ); ?></p>

				<?php bp_attachments_get_template_part( 'cover-images/index' ); ?>

				<?php

				/**
				 * Fires after the display of the group cover image creation step.
				 *
				 * @since 2.4.0
				 */
				do_action( 'bp_after_group_cover_image_creation_step' ); ?>

				<?php wp_nonce_field( 'groups_create_save_group-cover-image' ); ?>

			<?php endif; ?>

			<?php /* Group creation step 5: Invite friends to group */ ?>
			<?php if ( bp_is_group_creation_step( 'group-invites' ) ) : ?>

				<h2 class="bp-screen-reader-text"><?php
					/* translators: accessibility text */
					esc_html_e( 'Group Invites', 'cirkle' );
				?></h2>

				<?php

				/**
				 * Fires before the display of the group invites creation step.
				 *
				 * @since 1.1.0
				 */
				do_action( 'bp_before_group_invites_creation_step' ); ?>

				<?php if ( bp_is_active( 'friends' ) && bp_get_total_friend_count( bp_loggedin_user_id() ) ) : ?>

					<div class="left-menu">
						<div id="invite-list">
							<ul>
								<?php bp_new_group_invite_friend_list(); ?>
							</ul>
							<?php wp_nonce_field( 'groups_invite_uninvite_user', '_wpnonce_invite_uninvite_user' ); ?>
						</div>
					</div><!-- .left-menu -->

					<div class="main-column">
						<div id="message" class="info">
							<p><?php esc_html_e('Select people to invite from your friends list.', 'cirkle' ); ?></p>
						</div>
						<?php /* The ID 'friend-list' is important for AJAX support. */ ?>
						<ul id="friend-list" class="item-list">

						<?php if ( bp_group_has_invites() ) : ?>

							<?php while ( bp_group_invites() ) : bp_group_the_invite(); ?>

								<li id="<?php bp_group_invite_item_id(); ?>">

									<?php bp_group_invite_user_avatar(); ?>

									<h4><?php bp_group_invite_user_link(); ?></h4>
									<span class="activity"><?php bp_group_invite_user_last_active(); ?></span>

									<div class="action">
										<a class="remove" href="<?php bp_group_invite_user_remove_invite_url(); ?>" id="<?php bp_group_invite_item_id(); ?>"><?php esc_html_e( 'Remove Invite', 'cirkle' ); ?></a>
									</div>
								</li>

							<?php endwhile; ?>

							<?php wp_nonce_field( 'groups_send_invites', '_wpnonce_send_invites' ); ?>

						<?php endif; ?>

						</ul>

					</div><!-- .main-column -->

				<?php else : ?>

					<div id="message" class="info">
						<p><?php esc_html_e( 'Once you have built up friend connections you will be able to invite others to your group.', 'cirkle' ); ?></p>
					</div>

				<?php endif; ?>

				<?php wp_nonce_field( 'groups_create_save_group-invites' ); ?>

				<?php

				/**
				 * Fires after the display of the group invites creation step.
				 *
				 * @since 1.1.0
				 */
				do_action( 'bp_after_group_invites_creation_step' ); ?>

			<?php endif; ?>

			<?php

			/**
			 * Fires inside the group admin template.
			 *
			 * Allows plugins to add custom group creation steps.
			 *
			 * @since 1.1.0
			 */
			do_action( 'groups_custom_create_steps' ); ?>

			<?php

			/**
			 * Fires before the display of the group creation step buttons.
			 *
			 * @since 1.1.0
			 */
			do_action( 'bp_before_group_creation_step_buttons' ); ?>

			<?php if ( 'crop-image' != bp_get_avatar_admin_step() ) : ?>

				<div class="submit" id="previous-next">

					<?php /* Previous Button */ ?>
					<?php if ( !bp_is_first_group_creation_step() ) : ?>

						<input type="button" value="<?php esc_attr_e( 'Back to Previous Step', 'cirkle' ); ?>" id="group-creation-previous" name="previous" onclick="location.href='<?php bp_group_creation_previous_link(); ?>'" />

					<?php endif; ?>

					<?php /* Next Button */ ?>
					<?php if ( !bp_is_last_group_creation_step() && !bp_is_first_group_creation_step() ) : ?>

						<input type="submit" value="<?php esc_attr_e( 'Next Step', 'cirkle' ); ?>" id="group-creation-next" name="save" />

					<?php endif;?>

					<?php /* Create Button */ ?>
					<?php if ( bp_is_first_group_creation_step() ) : ?>

						<input type="submit" value="<?php esc_attr_e( 'Create Group and Continue', 'cirkle' ); ?>" id="group-creation-create" name="save" />

					<?php endif; ?>

					<?php /* Finish Button */ ?>
					<?php if ( bp_is_last_group_creation_step() ) : ?>

						<input type="submit" value="<?php esc_attr_e( 'Finish', 'cirkle' ); ?>" id="group-creation-finish" name="save" />

					<?php endif; ?>
				</div>

			<?php endif;?>

			<?php

			/**
			 * Fires after the display of the group creation step buttons.
			 *
			 * @since 1.1.0
			 */
			do_action( 'bp_after_group_creation_step_buttons' ); ?>

			<?php /* Don't leave out this hidden field */ ?>
			<input type="hidden" name="group_id" id="group_id" value="<?php bp_new_group_id(); ?>" />
			<?php

			/**
			 * Fires and displays the groups directory content.
			 *
			 * @since 1.1.0
			 */
			do_action( 'bp_directory_groups_content' ); ?>

		</div><!-- .item-body -->

		<?php

		/**
		 * Fires after the display of group creation.
		 *
		 * @since 1.2.0
		 */
		do_action( 'bp_after_create_group' ); ?>

	</form>

	<?php

	/**
	 * Fires after the display of group creation content.
	 *
	 * @since 1.6.0
	 */
	do_action( 'bp_after_create_group_content_template' ); ?>

</div>

<?php

/**
 * Fires at the bottom of the groups creation template file.
 *
 * @since 1.7.0
 */
do_action( 'bp_after_create_group_page' );
