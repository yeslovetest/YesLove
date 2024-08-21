<?php
/**
 * BuddyPress - Groups Admin - Manage Members
 *
 * @package BuddyPress
 * @subpackage bp-legacy
 * @version 3.0.0
 */
use radiustheme\cirkle\Helper;

?>

<h2 class="bp-screen-reader-text"><?php esc_html_e( 'Manage Members', 'cirkle' ); ?></h2>

<?php

/**
 * Fires before the group manage members admin display.
 *
 * @since 1.1.0
 */
do_action( 'bp_before_group_manage_members_admin' ); ?>

<div aria-live="polite" aria-relevant="all" aria-atomic="true">

	<div class="bp-widget group-members-list group-admins-list">
		<h3 class="section-header"><?php esc_html_e( 'Administrators', 'cirkle' ); ?></h3>

		<?php if ( bp_group_has_members( array( 'per_page' => 15, 'group_role' => array( 'admin' ), 'page_arg' => 'mlpage-admin' ) ) ) : ?>

			<?php if ( bp_group_member_needs_pagination() ) : ?>

				<div class="pagination no-ajax">

					<div id="member-count" class="pag-count">
						<?php bp_group_member_pagination_count(); ?>
					</div>

					<div id="member-admin-pagination" class="pagination-links">
						<?php bp_group_member_admin_pagination(); ?>
					</div>

				</div>

			<?php endif; ?>

			<ul id="admins-list" class="item-list">
				<?php while ( bp_group_members() ) : bp_group_the_member(); ?>
					<li class="user-list-view forum-member">
						<div class="widget-author block-box">
							<div class="author-heading">
								<?php 
									$dir = 'members';
									$user_id = bp_get_group_member_id();
									Helper::banner_img( $user_id, $dir ); 
								?>
		                        <div class="profile-img">
		                            <a href="<?php bp_group_member_domain(); ?>">
										<?php bp_group_member_avatar_thumb('type=full'); ?>
									</a>
		                        </div>
		                        <div class="profile-name">
		                            <h4 class="author-name">
		                            <?php bp_group_member_link(); ?>
							    	</h4>
		                            <div class="author-location">
		                            	<?php bp_group_member_joined_since(); ?>
		                            </div>
		                        </div>
		                    </div>
		                    <div class="action author-statistics">
								<?php if ( count( bp_group_admin_ids( false, 'array' ) ) > 1 ) : ?>
									<a class="button confirm admin-demote-to-member" href="<?php bp_group_member_demote_link(); ?>"><?php esc_html_e( 'Demote to Member', 'cirkle' ); ?></a>
								<?php endif; ?>

								<?php

								/**
								 * Fires inside the action section of a member admin item in group management area.
								 *
								 * @since 2.7.0
								 *
								 * @param $section Which list contains this item.
								 */
								do_action( 'bp_group_manage_members_admin_actions', 'admins-list' ); ?>
							</div>
						</div>
					</li>
				<?php endwhile; ?>
			</ul>

			<?php if ( bp_group_member_needs_pagination() ) : ?>

				<div class="pagination no-ajax">
					<div id="member-count" class="pag-count">
						<?php bp_group_member_pagination_count(); ?>
					</div>
					<div id="member-admin-pagination" class="pagination-links">
						<?php bp_group_member_admin_pagination(); ?>
					</div>
				</div>

			<?php endif; ?>

		<?php else: ?>

		<div id="message" class="info">
			<p><?php esc_html_e( 'No group administrators were found.', 'cirkle' ); ?></p>
		</div>

		<?php endif; ?>
	</div>

	<div class="bp-widget group-members-list group-mods-list">
		<h3 class="section-header"><?php esc_html_e( 'Moderators', 'cirkle' ); ?></h3>

		<?php if ( bp_group_has_members( array( 'per_page' => 15, 'group_role' => array( 'mod' ), 'page_arg' => 'mlpage-mod' ) ) ) : ?>

			<?php if ( bp_group_member_needs_pagination() ) : ?>

				<div class="pagination no-ajax">

					<div id="member-count" class="pag-count">
						<?php bp_group_member_pagination_count(); ?>
					</div>

					<div id="member-admin-pagination" class="pagination-links">
						<?php bp_group_member_admin_pagination(); ?>
					</div>

				</div>

			<?php endif; ?>

			<ul id="mods-list" class="item-list">

				<?php while ( bp_group_members() ) : bp_group_the_member(); ?>
					<li>
						<div class="item-avatar">
							<?php bp_group_member_avatar_thumb(); ?>
						</div>

						<div class="item">
							<div class="item-title">
								<?php bp_group_member_link(); ?>
							</div>
							<p class="joined item-meta">
								<?php bp_group_member_joined_since(); ?>
							</p>
							<?php

							/**
							 * Fires inside the item section of a member admin item in group management area.
							 *
							 * @since 1.1.0
							 * @since 2.7.0 Added $section parameter.
							 *
							 * @param $section Which list contains this item.
							 */
							do_action( 'bp_group_manage_members_admin_item', 'admins-list' ); ?>
						</div>

						<div class="action">
							<a href="<?php bp_group_member_promote_admin_link(); ?>" class="button confirm mod-promote-to-admin"><?php esc_html_e( 'Promote to Admin', 'cirkle' ); ?></a>
							<a class="button confirm mod-demote-to-member" href="<?php bp_group_member_demote_link(); ?>"><?php esc_html_e( 'Demote to Member', 'cirkle' ); ?></a>

							<?php

							/**
							 * Fires inside the action section of a member admin item in group management area.
							 *
							 * @since 2.7.0
							 *
							 * @param $section Which list contains this item.
							 */
							do_action( 'bp_group_manage_members_admin_actions', 'mods-list' ); ?>

						</div>
					</li>
				<?php endwhile; ?>

			</ul>

			<?php if ( bp_group_member_needs_pagination() ) : ?>

				<div class="pagination no-ajax">

					<div id="member-count" class="pag-count">
						<?php bp_group_member_pagination_count(); ?>
					</div>

					<div id="member-admin-pagination" class="pagination-links">
						<?php bp_group_member_admin_pagination(); ?>
					</div>

				</div>

			<?php endif; ?>

		<?php else: ?>

			<div id="message" class="info">
				<p><?php esc_html_e( 'No group moderators were found.', 'cirkle' ); ?></p>
			</div>

		<?php endif; ?>
	</div>

	<div class="bp-widget group-members-list">
		<h3 class="section-header"><?php esc_html_e( "Members", 'cirkle' ); ?></h3>

		<?php if ( bp_group_has_members( array( 'per_page' => 15, 'exclude_banned' => 0 ) ) ) : ?>

			<?php if ( bp_group_member_needs_pagination() ) : ?>

				<div class="pagination no-ajax">

					<div id="member-count" class="pag-count">
						<?php bp_group_member_pagination_count(); ?>
					</div>

					<div id="member-admin-pagination" class="pagination-links">
						<?php bp_group_member_admin_pagination(); ?>
					</div>

				</div>

			<?php endif; ?>

			<ul id="members-list" class="item-list" aria-live="assertive" aria-relevant="all">
				<?php while ( bp_group_members() ) : bp_group_the_member(); ?>
					<li class="<?php bp_group_member_css_class(); ?>">
						<div class="user-list-view forum-member">
							<div class="widget-author block-box">
			                    <div class="author-heading">
			                    	<?php 
				                		$user_id = bp_get_group_member_id();
				                		$bg_url = bp_attachments_get_attachment('url', array(
											'object_dir' => 'members',
											'item_id' => $user_id,
										));
										if (empty($bg_url)) {
									        $bg_url = CIRKLE_BANNER_DUMMY_IMG.'dummy-banner.jpg';
									    } else {
									        $bg_url = $bg_url;
									    }							  
									?>
			                        <div class="cover-img">
			                            <img src="<?php echo esc_url( $bg_url ); ?>" alt="<?php esc_attr_e( 'Cover Image', 'cirkle' ); ?>">
			                        </div>
			                        <div class="profile-img">
			                            <a href="<?php bp_group_member_domain(); ?>">
											<?php bp_group_member_avatar_thumb(); ?>
										</a>
			                        </div>
			                        <div class="profile-name">
			                            <h4 class="author-name">
			                            <?php bp_group_member_link(); ?>
								    	</h4>
			                            <div class="author-location">
			                            	<span class="activity" data-livestamp="<?php bp_core_iso8601_date( bp_get_group_member_joined_since( array( 'relative' => false ) ) ); ?>"><?php bp_group_member_joined_since(); ?></span>
			                            </div>
			                        </div>
			                    </div>
			                    <div class="action author-statistics">
									<?php if ( bp_get_group_member_is_banned() ) : ?>

										<a href="<?php bp_group_member_unban_link(); ?>" class="button confirm member-unban item-number"><?php esc_html_e( 'Remove Ban', 'cirkle' ); ?></a>

									<?php else : ?>

										<a href="<?php bp_group_member_ban_link(); ?>" class="button confirm member-ban item-number"><?php esc_html_e( 'Kick &amp; Ban', 'cirkle' ); ?></a>
										<a href="<?php bp_group_member_promote_mod_link(); ?>" class="button confirm member-promote-to-mod item-number"><?php esc_html_e( 'Promote to Mod', 'cirkle' ); ?></a>
										<a href="<?php bp_group_member_promote_admin_link(); ?>" class="button confirm member-promote-to-admin item-number"><?php esc_html_e( 'Promote to Admin', 'cirkle' ); ?></a>

									<?php endif; ?>

									<a href="<?php bp_group_member_remove_link(); ?>" class="button confirm item-number"><?php esc_html_e( 'Remove from group', 'cirkle' ); ?></a>

									<?php

									/**
									 * Fires inside the action section of a member admin item in group management area.
									 *
									 * @since 2.7.0
									 *
									 * @param $section Which list contains this item.
									 */
									do_action( 'bp_group_manage_members_admin_actions', 'members-list' ); ?>
								</div>
			                </div>
			            </div>
					</li>

				<?php endwhile; ?>
			</ul>

			<?php if ( bp_group_member_needs_pagination() ) : ?>

				<div class="pagination no-ajax">

					<div id="member-count" class="pag-count">
						<?php bp_group_member_pagination_count(); ?>
					</div>

					<div id="member-admin-pagination" class="pagination-links">
						<?php bp_group_member_admin_pagination(); ?>
					</div>

				</div>

			<?php endif; ?>

		<?php else: ?>

			<div id="message" class="info">
				<p><?php esc_html_e( 'No group members were found.', 'cirkle' ); ?></p>
			</div>

		<?php endif; ?>
	</div>

</div>

<?php

/**
 * Fires after the group manage members admin display.
 *
 * @since 1.1.0
 */
do_action( 'bp_after_group_manage_members_admin' );
