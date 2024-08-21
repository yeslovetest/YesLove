<?php

/**
 * Topics Loop - Single
 *
 * @package bbPress
 * @subpackage Theme
 */

// Exit if accessed directly
defined( 'ABSPATH' ) || exit;

?>

<ul id="bbp-topic-<?php bbp_topic_id(); ?>" <?php bbp_topic_class(); ?>>
	<li class="bbp-topic-title">

		<?php if ( bbp_is_user_home() ) : ?>

			<?php if ( bbp_is_favorites() ) : ?>

				<span class="bbp-row-actions">

					<?php do_action( 'bbp_theme_before_topic_favorites_action' ); ?>

					<?php bbp_topic_favorite_link( array( 'before' => '', 'favorite' => '+', 'favorited' => '&times;' ) ); ?>

					<?php do_action( 'bbp_theme_after_topic_favorites_action' ); ?>

				</span>

			<?php elseif ( bbp_is_subscriptions() ) : ?>

				<span class="bbp-row-actions">

					<?php do_action( 'bbp_theme_before_topic_subscription_action' ); ?>

					<?php bbp_topic_subscription_link( array( 'before' => '', 'subscribe' => '+', 'unsubscribe' => '&times;' ) ); ?>

					<?php do_action( 'bbp_theme_after_topic_subscription_action' ); ?>

				</span>

			<?php endif; ?>

		<?php endif; ?>

		<?php do_action( 'bbp_theme_before_topic_meta' ); ?>

		<div class="bbp-topic-meta">

			<?php do_action( 'bbp_theme_before_topic_started_by' ); ?>

			<div class="topic-author-pic">
				<?php printf( bbp_get_topic_author_link( array( 'size' => '50', 'type' => 'avatar' ) ) ); ?>
			</div>
			<div class="topic-meta-content">
				<?php printf( bbp_get_topic_author_link( array( 'type' => 'name' ) ) ); ?>
				<?php do_action( 'bbp_theme_after_topic_started_by' ); ?>

				<?php do_action( 'bbp_theme_before_topic_title' ); ?>
				<a class="bbp-topic-permalink" href="<?php bbp_topic_permalink(); ?>"><?php bbp_topic_title(); ?></a>
				<?php do_action( 'bbp_theme_after_topic_title' ); ?>

				<?php if ( ! bbp_is_single_forum() || ( bbp_get_topic_forum_id() !== bbp_get_forum_id() ) ) : ?>

					<?php do_action( 'bbp_theme_before_topic_started_in' ); ?>

					<span class="bbp-topic-started-in"><?php printf( esc_html__( 'in: %1$s', 'cirkle' ), '<a href="' . bbp_get_forum_permalink( bbp_get_topic_forum_id() ) . '">' . bbp_get_forum_title( bbp_get_topic_forum_id() ) . '</a>' ); ?></span>
					<?php do_action( 'bbp_theme_after_topic_started_in' ); ?>

				<?php endif; ?>
			</div>
		</div>

		<?php do_action( 'bbp_theme_after_topic_meta' ); ?>

		<?php bbp_topic_pagination(); ?>

		<?php bbp_topic_row_actions(); ?>
	</li>

	<li class="bbp-topic-voice-count"><?php bbp_topic_voice_count(); ?></li>

	<li class="bbp-topic-reply-count"><?php bbp_show_lead_topic() ? bbp_topic_reply_count() : bbp_topic_post_count(); ?></li>
	<li class="bbp-forum-freshness">
		<div class="bbp-topic-meta-pic">
			<?php do_action( 'bbp_theme_before_topic_author' ); ?>
			<?php bbp_author_link( array( 'post_id' => bbp_get_topic_last_active_id(), 'size' => 45, 'type' => 'avatar' ) ); ?>
		</div>
		<div class="meta-info">
			<?php bbp_author_link( array( 'post_id' => bbp_get_topic_last_active_id(), 'type' => 'name' ) ); ?>
			<?php do_action( 'bbp_theme_before_topic_freshness_author' ); ?>
			<?php bbp_topic_freshness_link(); ?>
			<?php do_action( 'bbp_theme_after_topic_freshness_author' ); ?>
		</div>
	</li>
</ul><!-- #bbp-topic-<?php bbp_topic_id(); ?> -->
