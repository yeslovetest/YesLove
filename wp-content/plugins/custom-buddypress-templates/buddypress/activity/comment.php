<?php
/**
 * BuddyPress - Activity Stream Comment
 *
 * This template is used by bp_activity_comments() functions to show
 * each activity.
 *
 * @package BuddyPress
 * @subpackage bp-legacy
 * @version 3.0.0
 */

/**
 * Fires before the display of an activity comment.
 *
 * @since 1.5.0
 */
do_action( 'bp_before_activity_comment' ); ?>

<li id="acomment-<?php bp_activity_comment_id(); ?>">
	<div class="comment-header">
		<div class="acomment-avatar">
			<a href="<?php bp_activity_comment_user_link(); ?>">
				<?php bp_activity_avatar( 'type=thumb&user_id=' . bp_get_activity_comment_user_id() ); ?>
			</a>
		</div>

		<div class="acomment-meta">
			<?php
			/* translators: 1: user profile link, 2: user name, 3: activity permalink, 4: ISO8601 timestamp, 5: activity relative timestamp */
			printf( __( '<a href="%1$s">%2$s</a> <div class="mht">replied <a href="%3$s" class="activity-time-since"><span class="time-since" data-livestamp="%4$s">%5$s</span></a></div>', 'cirkle' ), bp_get_activity_comment_user_link(), bp_get_activity_comment_name(), bp_get_activity_comment_permalink(), bp_core_get_iso8601_date( bp_get_activity_comment_date_recorded() ), bp_get_activity_comment_date_recorded() );
			?>
		</div>
	</div>
	<div class="acomment-content"><?php bp_activity_comment_content(); ?></div>

	<div class="acomment-options">

		<?php if ( is_user_logged_in() && bp_activity_can_comment_reply( bp_activity_current_comment() ) ) : ?>

			<a href="#acomment-<?php bp_activity_comment_id(); ?>" class="acomment-reply bp-primary-action" id="acomment-reply-<?php bp_activity_id(); ?>-from-<?php bp_activity_comment_id(); ?>"><?php esc_html_e( 'Reply', 'cirkle' ); ?></a>

		<?php endif; ?>

		<?php if ( bp_activity_user_can_delete() ) : ?>

			<a href="<?php bp_activity_comment_delete_link(); ?>" class="delete acomment-delete confirm bp-secondary-action" rel="nofollow"><?php esc_html_e( 'Delete', 'cirkle' ); ?></a>

		<?php endif; ?>

		<?php

		/**
		 * Fires after the default comment action options display.
		 *
		 * @since 1.6.0
		 */
		do_action( 'bp_activity_comment_options' ); ?>

	</div>

	<?php bp_activity_recurse_comments( bp_activity_current_comment() ); ?>
</li>

<?php

/**
 * Fires after the display of an activity comment.
 *
 * @since 1.5.0
 */
do_action( 'bp_after_activity_comment' );
