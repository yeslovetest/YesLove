<?php
/**
 * BuddyPress - Members Loop
 *
 * @package Cirkle
 * @since 1.0.2
 * @author RadiusTheme (https://www.radiustheme.com/)
 *
 */

use radiustheme\cirkle\RDTheme;
use radiustheme\cirkle\Helper;

if (function_exists('bp_get_total_site_member_count')) {
	$member_count = bp_get_total_site_member_count();
} else {
	$member_count = 0;
}
$mpp = RDTheme::$options['member_per_page'];

do_action( 'bp_before_members_loop' ); ?>

<?php if ( bp_get_current_member_type() ) : ?>
	<p class="current-member-type"><?php bp_current_member_type_message() ?></p>
<?php endif; ?>

<?php if ( bp_has_members( bp_ajax_querystring( 'members' ).'&per_page='.$mpp ) ) : ?>

	<?php
	/**
	 * Fires before the display of the members list.
	 *
	 * @since 1.1.0
	 */
	do_action( 'bp_before_directory_members_list' ); ?>

	<ul id="cirkle-members-list" class="item-list" aria-live="assertive" aria-relevant="all">
		<?php
			$currentuser = bp_loggedin_user_id();
			while ( bp_members() ) : bp_the_member(); 
			$userid = bp_get_member_user_id();
		?>
		<li <?php bp_member_class(['user-list-view forum-member']); ?>>
			<div class="widget-author block-box">
                <div class="author-heading">
                	<?php 
						$dir = 'members';
						$user_id = bp_get_member_user_id();
						Helper::banner_img( $user_id, $dir ); 
					?>
                    <div class="profile-img">
                        <a href="<?php bp_member_permalink(); ?>">
                        	<?php bp_member_avatar('type=full'); ?>
                        </a>
                    </div>
                    <div class="profile-name">
                        <h5 class="author-name <?php echo Helper::cirkle_is_user_online(bp_get_member_user_id()); ?>"><a href="<?php bp_member_permalink(); ?>"><?php bp_member_name(); ?></a>
                            <?php echo Helper::cirkle_get_verified_badge( $user_id ) ?>
                        </h5>
                        <div class="author-location"><span class="activity" data-livestamp="<?php bp_core_iso8601_date( bp_get_member_last_active( array( 'relative' => false ) ) ); ?>"><?php bp_member_last_active(); ?></span></div>
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
                			if ( $key == 3 ) break;
                	?>
		            	<li>
		            	<?php 
		            		$badge_img_id = get_post_meta( $value, '_thumbnail_id', true );
		            		$img_src = wp_get_attachment_image_src( $badge_img_id, 'thumbnail' ); 
		            		if ( $img_src ) {
	            			?>
		            			<img src="<?php echo esc_url( $img_src[0] ); ?>" alt="<?php esc_attr_e( 'Member Image', 'cirkle' ) ?>">
		            			<?php
		            		}
			            ?>
		            	</li>
	            	<?php } 
	            	} 
	            	if ( count($earned_ids) > 3 ) {
	            	?>	
	            		<li class="more-badges"><a href="<?php echo bp_core_get_user_domain( $user_id ).'badges'; ?>"><i class="icofont-plus"></i></a></li>
	            	<?php } ?>
                </ul>
            	<?php } 
            	} ?>
                <ul class="author-statistics">
                    <?php if ( $currentuser !== $userid && is_user_logged_in() ) { ?>
                    <li class="action">
	                    <?php
						/**
						 * Fires inside the members action HTML markup to display actions.
						 *
						 * @since 1.1.0
						 */
						do_action( 'bp_directory_members_actions' ); ?>
					</li>
					<?php } ?>
                </ul>
     			<!-- action hook -->
            </div>
		</li>

		<?php endwhile; ?>

	</ul>

	<?php

	/**
	 * Fires after the display of the members list.
	 *
	 * @since 1.1.0
	 */
	do_action( 'bp_after_directory_members_list' ); ?>

	<?php bp_member_hidden_fields(); ?>
	<?php if ( $member_count > $mpp ) { ?>
	<div id="pag-bottom" class="pagination">
		<div class="pagination-links" id="member-dir-pag-bottom">
			<?php bp_members_pagination_links(); ?>
		</div>
	</div>
	<?php } ?>

<?php else: ?>

	<div id="message" class="info">
		<p><?php esc_html_e( "Sorry, no members were found.", 'cirkle' ); ?></p>
	</div>

<?php endif; ?>

<?php
/**
 * Fires after the display of the members loop.
 *
 * @since 1.2.0
 */
do_action( 'bp_after_members_loop' );
