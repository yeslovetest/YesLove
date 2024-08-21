<?php

namespace radiustheme\cirkle;

use radiustheme\cirkle\Helper;

?>

<div class="dropdown dropdown-message">
	<button class="dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false">
		<i class="icofont-speech-comments"></i>
		<?php if (bp_get_total_unread_messages_count(bp_loggedin_user_id()) > 0) { ?>
		<span class="notify-count"><?php echo bp_get_total_unread_messages_count(bp_loggedin_user_id()); ?></span>
		<?php } ?>
	</button>
	<div class="dropdown-menu dropdown-menu-right">
		<div class="item-heading">
			<h5 class="heading-title"><?php esc_html_e('Message', 'cirkle'); ?></h5>
		</div>
		<?php if (bp_has_message_threads(bp_ajax_querystring('messages').'user_id='.bp_loggedin_user_id().'&per_page=3')) : ?>
		<div class="item-body">
			<form action="<?php echo bp_displayed_user_domain() . bp_get_messages_slug() . '/' . bp_current_action() ?>/bulk-manage/" method="post" id="messages-bulk-management">
				<?php while (bp_message_threads()) : bp_message_thread(); ?>
				<div class="media">
                    <div class="item-img">
                        <?php bp_message_thread_avatar(array( 'width' => 40, 'height' => 40 )); ?>
                    </div>
                    <div class="media-body">
                    	<?php if ('sentbox' != bp_current_action()) : ?>
                        <h6 class="item-title"><?php bp_message_thread_from(); ?></h6>
                        <?php else: ?>
                        <h6 class="item-title"><span class="to"><?php _e('To:', 'cirkle'); ?></span> <?php bp_message_thread_to(); ?>
                        </h6>
                        <?php endif; ?>
                        <div class="item-time"><?php bp_message_thread_last_post_date(); ?></div>
                        <p><?php bp_message_thread_excerpt('3'); ?></p>
                    </div>
                </div>
                <?php endwhile; ?>
			</form>
		</div>
		<div class="item-footer">
			<a href="<?php echo bp_loggedin_user_domain().'messages/'; ?>" class="view-btn"><?php esc_html_e('View All Messages', 'cirkle'); ?></a>
		</div>
		<?php else: ?>
		<div class="item-body">
			<p class="no-message"><?php _e('Sorry, no messages were found.', 'cirkle'); ?></p>
		</div>
		<?php endif;?>
	</div>
</div>