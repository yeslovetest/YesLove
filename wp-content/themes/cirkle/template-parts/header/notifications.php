<?php
namespace radiustheme\cirkle;

use radiustheme\cirkle\Helper;

?>
<div class="dropdown dropdown-notification">
    <button class="dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false">
        <i class="icofont-notification"></i>
		<?php if ( bp_notifications_get_unread_notification_count( bp_loggedin_user_id() ) > 0 ) { ?>
            <span class="notify-count"><?php echo bp_notifications_get_unread_notification_count( bp_loggedin_user_id() ); ?></span>
		<?php } ?>
    </button>
	<?php if ( is_user_logged_in() && bp_has_notifications( array(
			'user_id'      => bp_loggedin_user_id(),
			'per_page'     => 3,
			'search_terms' => false
		) ) ) { ?>
        <div class="dropdown-menu dropdown-menu-right">
            <div class="item-heading">
                <h5 class="heading-title"><?php esc_html_e( 'Notifications', 'cirkle' ); ?></h5>
            </div>
            <div class="item-body">
                <form method="post" id="notifications-bulk-management">
					<?php while ( bp_the_notifications() ) : bp_the_notification(); ?>
                        <div class="media">
                            <div class="item-img">
								<?php echo bp_core_fetch_avatar( array(
									'item_id' => bp_get_the_notification_secondary_item_id(),
									'type'    => 'full'
								) ); ?>
                            </div>
                            <div class="media-body">
                                <p><?php bp_the_notification_description(); ?></p>
                                <div class="media-body-footer">
                                    <div class="item-time"><?php bp_the_notification_time_since(); ?></div>
                                </div>
                            </div>
                        </div>
					<?php endwhile; ?>
                </form>
            </div>
            <div class="item-footer">
                <a href="<?php bp_notifications_permalink(); ?>"
                   class="view-btn"><?php esc_html_e( 'View All Notification', 'cirkle' ); ?></a>
            </div>
        </div>
	<?php } else { ?>
        <div class="dropdown-menu dropdown-menu-right">
            <div class="item-body">
                <p class="no-notification"><?php _e( 'Sorry, no notification were found.', 'cirkle' ); ?></p>
            </div>
        </div>
    <?php } ?>
</div>
