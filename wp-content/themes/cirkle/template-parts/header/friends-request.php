<?php 
namespace radiustheme\cirkle;
use radiustheme\cirkle\Helper;
?>

<div class="dropdown dropdown-friend">
	<button class="dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false">
		<i class="icofont-users-alt-4"></i>
		<?php 
		if (function_exists('bp_friend_get_total_requests_count')) {
			if ( bp_friend_get_total_requests_count( bp_loggedin_user_id() ) > 0 ) { ?>
		<span class="notify-count"><?php echo bp_friend_get_total_requests_count( bp_loggedin_user_id() ); ?></span>
		<?php } } ?>
	</button>
	<div class="dropdown-menu dropdown-menu-right">
		<div class="item-heading">
			<h5 class="heading-title"><?php esc_html_e( 'Friend Requests', 'cirkle' ); ?></h5>
		</div>
		<?php 
			if (function_exists('bp_get_friendship_requests')) {
				if ( bp_has_members( 'type=alphabetical&include=' . bp_get_friendship_requests( bp_loggedin_user_id() ) ) ) { ?>
				<div class="item-body">
					<?php while ( bp_members() ) : bp_the_member(); ?>
					<div class="media">
						<div class="item-img">
							<a href="<?php bp_member_link(); ?>"><?php bp_member_avatar(); ?></a>
							<span class="chat-status <?php Helper::cirkle_is_user_online( bp_get_member_user_id() ); ?>"></span>
						</div>
						<div class="media-body">
							<h6 class="item-title"><a href="<?php bp_member_link(); ?>"><?php bp_member_name(); ?></a></h6>
							<p><?php bp_member_last_active(); ?></p>
							<div class="btn-area">
								<a class="button item-btn accept" href="<?php bp_friend_accept_request_link(); ?>"><i class="icofont-plus"></i></a>
								<a class="button item-btn reject" href="<?php bp_friend_reject_request_link(); ?>"><i class="icofont-minus"></i></a>
							</div>
						</div>
					</div>
					<?php endwhile; ?>
				</div>
				<div class="item-footer">
					<a href="<?php echo bp_loggedin_user_domain() .'friends/requests'; ?>" class="view-btn"><?php esc_html_e( 'View All Friend Request', 'cirkle' ); ?></a>
				</div>
				<?php } else {?>
				<div class="item-body">
					<p class="no-request"><?php _e( 'You have no pending friends requests.', 'cirkle' ); ?></p>
				</div>
		<?php } 
		} ?>
	</div>
</div> 