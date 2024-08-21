<?php
/**
 * BuddyPress - Groups Members
 *
 * @package Cirkle
 * @since 1.0.0
 * @author RadiusTheme (https://www.radiustheme.com/)
 *
 */

use radiustheme\cirkle\RDTheme;
use radiustheme\cirkle\Helper;

?>

<?php if ( bp_group_has_members( bp_ajax_querystring( 'group_members' ) ) ) : ?>

	<?php
	/**
	 * Fires before the display of the group members content.
	 *
	 * @since 1.1.0
	 */
	do_action( 'bp_before_group_members_content' ); ?>

	<?php

	/**
	 * Fires before the display of the group members list.
	 *
	 * @since 1.1.0
	 */
	do_action( 'bp_before_group_members_list' ); ?>

	<ul id="member-list" class="item-list">
		<?php 
			$currentuser = bp_loggedin_user_id();
			while ( bp_group_members() ) : bp_group_the_member(); 
			$userid = bp_get_member_user_id();
		?>
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
                            	<span class="activity" data-livestamp="<?php bp_core_iso8601_date( bp_get_group_member_joined_since( array( 'relative' => false ) ) ); ?>"><?php bp_group_member_joined_since(); ?></span>
                            </div>
                        </div>
                    </div>
                    <?php
                    if (class_exists('GamiPress')) {
						$earned_ids = gamipress_get_user_earned_achievement_ids( $user_id, 'badge' );
						if ($earned_ids) {
	    			?>
	                <ul class="author-badge">
	                	<?php if ( $earned_ids ) {
	                		foreach ( $earned_ids as $key => $value ) { 
	                			if ( $key == 4 ) break;
	                	?>
			            	<li>
			            	<?php 
			            		$badge_img_id = get_post_meta( $value, '_thumbnail_id', true );
			            		$img_src = wp_get_attachment_image_src( $badge_img_id, 'thumbnail' ); 
			            		if ( $img_src ) {
		            			?>
			            			<img src="<?php echo esc_url( $img_src[0] ); ?>" alt="<?php esc_attr_e( 'Member Badge', 'cirkle' ) ?>">
			            			<?php
			            		}
				            ?>
			            	</li>
		            	<?php } } ?>
	                </ul>
	            	<?php }
	            	} ?>
                    <ul class="author-statistics">
	                    <?php if ( $currentuser !== $userid && is_user_logged_in() ) { ?>
	                    <li class="action">
	                    	<?php 
		                    /**
							 * Fires inside the listing of an individual group member listing item.
							 *
							 * @since 1.1.0
							 */
							do_action( 'bp_group_members_list_item' ); ?>
							<?php if ( bp_is_active( 'friends' ) ) : ?>
									<?php bp_add_friend_button( bp_get_group_member_id(), bp_get_group_member_is_friend() ); ?>
									<?php

									/**
									 * Fires inside the action section of an individual group member listing item.
									 *
									 * @since 1.1.0
									 */
									do_action( 'bp_group_members_list_item_action' ); ?>
							<?php endif; ?>
	                    </li>
	                	<?php } ?>
                    </ul>
                </div>
			</li>
		<?php endwhile; ?>
	</ul>

	<?php

	/**
	 * Fires after the display of the group members list.
	 *
	 * @since 1.1.0
	 */
	do_action( 'bp_after_group_members_list' ); ?>

	<div id="pag-bottom" class="pagination">
		<div class="pag-count" id="member-count-bottom">
			<?php bp_members_pagination_count(); ?>
		</div>
		<div class="pagination-links" id="member-pag-bottom">
			<?php bp_members_pagination_links(); ?>
		</div>
	</div>

	<?php

	/**
	 * Fires after the display of the group members content.
	 *
	 * @since 1.1.0
	 */
	do_action( 'bp_after_group_members_content' ); ?>

<?php else: ?>

	<div id="message" class="info">
		<p><?php esc_html_e( 'No members were found.', 'cirkle' ); ?></p>
	</div>

<?php endif;
