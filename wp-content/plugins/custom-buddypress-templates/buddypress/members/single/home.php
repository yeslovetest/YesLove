<?php
/**
 * BuddyPress - Members Home
 *
 * @package BuddyPress
 * @subpackage bp-legacy
 * @version 3.0.0
 */

use radiustheme\cirkle\Helper;

?>

<div id="buddypress-member-home">

	<?php
		$member_cover_image_url = bp_attachments_get_attachment('url', array(
			'object_dir' => 'members',
			'item_id' => bp_displayed_user_id(),
		));
		$user_id = bp_displayed_user_id();
	   	/**
	   	 * Section Banner
	   	 */
		echo get_template_part('template-parts/banner/profile', 'banner', [
			'section_bg_url'   => $member_cover_image_url,
			'user_id'          => $user_id,
		]); 
		Helper::cirkle_postviews( $user_id );
	?>

	<?php

	/**
	 * Fires before the display of member home content.
	 *
	 * @since 1.2.0
	 */
	do_action( 'bp_before_member_home_content' ); ?>

	<div id="profile-container-main">
	<div class="item-list-tabs" id="profile-sidebar">
	<?php do_action( 'bp_member_profile-sidebar' ); ?>
	</div>
	<div id="profile-mainbar">
	<div class="row">
	    
	    <div id="item-nav">
	
    		<div class="item-list-tabs no-ajax block-box user-top-header" id="object-nav" aria-label="<?php esc_attr_e( 'Member primary navigation', 'cirkle' ); ?>" role="navigation">
    			<ul class="menu-list">
    				<?php bp_get_displayed_user_nav(); ?>
    				<?php
    				/**
    				 * Fires after the display of member options navigation.
    				 *
    				 * @since 1.2.4
    				 */
    				do_action( 'bp_member_options_nav' ); ?>
    			</ul>
    		</div>
    	</div>
    	<!-- #item-nav -->
		
		<div class="<?php Helper::the_layout_class(); ?>">
			<?php if ( is_user_logged_in() && bp_is_my_profile() && ( !bp_current_action() || bp_is_current_action( 'just-me' ) ) ) { ?>
			<div class="cirkle-activity-form">
				<?php
					/**
					 * Fires before the display of the member activity post form.
					 *
					 * @since 1.2.0
					 */
					do_action( 'bp_before_member_activity_post_form' ); ?>

					<?php
					if ( is_user_logged_in() && bp_is_my_profile() && ( !bp_current_action() || bp_is_current_action( 'just-me' ) ) )
						bp_get_template_part( 'common/post-form' );
					/**
					 * Fires after the display of the member activity post form.
					 *
					 * @since 1.2.0
					 */
					do_action( 'bp_after_member_activity_post_form' );
				?>
			</div>	
			<?php } ?>

			<div id="item-body" class="profile-item-body">

				<?php

				/**
				 * Fires before the display of member body content.
				 *
				 * @since 1.2.0
				 */
				do_action( 'bp_before_member_body' );

				if ( bp_is_user_front() ) :
					bp_displayed_user_front_template_part();

				elseif ( bp_is_user_activity() ) :
					bp_get_template_part( 'members/single/activity' );

				elseif ( bp_is_user_blogs() ) :
					bp_get_template_part( 'members/single/blogs'    );

				elseif ( bp_is_user_friends() ) :
					bp_get_template_part( 'members/single/friends'  );

				elseif ( bp_is_user_groups() ) :
					bp_get_template_part( 'members/single/groups'   );

				elseif ( bp_is_user_messages() ) :
					bp_get_template_part( 'members/single/messages' );

				elseif ( bp_is_user_profile() ) :
					bp_get_template_part( 'members/single/profile'  );

				elseif ( bp_is_user_notifications() ) :
					bp_get_template_part( 'members/single/notifications' );

				elseif ( bp_is_user_settings() ) :
					bp_get_template_part( 'members/single/settings' );
					
				// If nothing sticks, load a generic template
				else :
					bp_get_template_part( 'members/single/plugins'  );

				endif;

				/**
				 * Fires after the display of member body content.
				 *
				 * @since 1.2.0
				 */
				do_action( 'bp_after_member_body' ); ?>

			</div><!-- #item-body -->

			<?php

			/**
			 * Fires after the display of member home content.
			 *
			 * @since 1.2.0
			 */
			do_action( 'bp_after_member_home_content' ); ?>
		</div>

		<?php 
			if ( !bp_is_groups_component() && !bp_is_current_component( 'photos' ) && !bp_is_current_component( 'videos' ) && !bp_is_current_component( 'badges' ) ) {
				Helper::cirkle_sidebar(); 
			}
		?>
	</div>
	</div>
	</div>
</div><!-- #buddypress-member-home -->
