<?php
/**
 * BuddyPress - Members Friends Requests
 *
 * @package BuddyPress
 * @subpackage bp-legacy
 * @version 3.0.0
 */

use radiustheme\cirkle\RDTheme;
use radiustheme\cirkle\Helper;

$mpp = RDTheme::$options['member_per_page'];

/**
 * Fires before the display of member friend requests content.
 *
 * @since 1.2.0
 */
do_action( 'bp_before_member_friend_requests_content' ); ?>

<?php if ( bp_has_members( 'type=alphabetical&include=' . bp_get_friendship_requests() ) ) : ?>

	<h2 class="bp-screen-reader-text"><?php
		/* translators: accessibility text */
		esc_html_e( 'Friendship requests', 'cirkle' );
	?></h2>

	<ul id="members-list" class="item-list">
		<?php while ( bp_members() ) : bp_the_member(); ?>

			<li id="friendship-<?php bp_friend_friendship_id(); ?>" <?php bp_member_class(['user-list-view forum-member']); ?>>
				<div class="widget-author block-box <?php Helper::cirkle_is_user_online( bp_get_member_user_id() ); ?>">
	                <div class="author-heading">
	                	<?php 
							$dir = 'members';
							$user_id = bp_get_member_user_id();
							Helper::banner_img( $user_id, $dir ); 
						?>
	                    <div class="profile-img">
	                        <a href="<?php bp_member_permalink(); ?>"><?php bp_member_avatar(); ?></a>
	                    </div>
	                    <div class="profile-name">
	                        <h5 class="author-name"><a href="<?php bp_member_permalink(); ?>"><?php bp_member_name(); ?></a></h5>
	                        <div class="author-location"><span class="activity" data-livestamp="<?php bp_core_iso8601_date( bp_get_member_last_active( array( 'relative' => false ) ) ); ?>"><?php bp_member_last_active(); ?></span></div>
	                    </div>
	                </div>
	                <ul class="author-statistics">
	                    <li>
	                        <a href="<?php bp_member_permalink(); ?>"><span class="item-number"><?php echo Helper::cirkle_user_post_count( $user_id ); ?></span> <span class="item-text"><?php esc_html_e( 'Posts', 'cirkle' ); ?></span></a>
	                    </li>
	                    <li>
	                        <a href="<?php bp_member_permalink(); ?>"><span class="item-number"><?php echo Helper::cirkle_count_user_comments($user_id); ?></span> <span class="item-text"><?php esc_html_e( 'Comments', 'cirkle' ); ?></span></a>
	                    </li>
	                </ul>
	                <div class="action">
	                	<a class="button accept" href="<?php bp_friend_accept_request_link(); ?>"><?php esc_html_e( 'Accept', 'cirkle' ); ?></a> &nbsp;
						<a class="button reject" href="<?php bp_friend_reject_request_link(); ?>"><?php esc_html_e( 'Reject', 'cirkle' ); ?></a>
						<?php
						/**
						 * Fires inside the member friend request actions markup.
						 *
						 * @since 1.1.0
						 */
						do_action( 'bp_friend_requests_item_action' ); ?>
					</div>
	            </div>
			</li>

		<?php endwhile; ?>
	</ul>

	<?php

	/**
	 * Fires and displays the member friend requests content.
	 *
	 * @since 1.1.0
	 */
	do_action( 'bp_friend_requests_content' ); ?>

	<div id="pag-bottom" class="pagination no-ajax">
		<div class="pag-count" id="member-dir-count-bottom">
			<?php bp_members_pagination_count(); ?>
		</div>

		<div class="pagination-links" id="member-dir-pag-bottom">
			<?php bp_members_pagination_links(); ?>
		</div>
	</div>

<?php else: ?>
	<div id="message" class="info">
		<p><?php esc_html_e( 'You have no pending friends requests.', 'cirkle' ); ?></p>
	</div>
<?php endif;?>

<?php
/**
 * Fires after the display of member friend requests content.
 *
 * @since 1.2.0
 */
do_action( 'bp_after_member_friend_requests_content' );
