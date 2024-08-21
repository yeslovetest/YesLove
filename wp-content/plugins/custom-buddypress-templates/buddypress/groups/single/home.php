<?php
/**
 * BuddyPress - Groups Home
 *
 * @package Cirkle
 * @since 1.0.0
 * @author RadiusTheme (https://www.radiustheme.com/)
 *
 */
	
	use radiustheme\cirkle\Helper;
?>
<div id="buddypress-group-home">

	<?php if ( bp_has_groups() ) : while ( bp_groups() ) : bp_the_group(); ?>

	<?php

	/**
	 * Fires before the display of the group home content.
	 *
	 * @since 1.2.0
	 */
	do_action( 'bp_before_group_home_content' ); ?>

	<?php
		$bg_url = bp_attachments_get_attachment('url', array(
	        'object_dir' => 'groups',
	        'item_id' => bp_get_group_id(),
	    ));
	    if (empty($bg_url)) {
	        $bg_url = CIRKLE_BANNER_DUMMY_IMG.'dummy-banner.jpg';
	    } else {
	        $bg_url = $bg_url;
	    }
	    $group_id = bp_get_group_id();
	    $group_admins = groups_get_group_admins( $group_id );
	    $admin_id = $group_admins[0]->user_id;
	    
		/**
		 * Section Banner
		*/
		echo get_template_part('template-parts/banner/group', 'banner', [
		    'bg_url'  => $bg_url,
		    'admin_id' => $admin_id,
		]);
	?>

    <div class="row">
		<div class="<?php Helper::the_layout_class(); ?>">
			<div id="item-nav">
				<div class="item-list-tabs no-ajax" id="object-nav" aria-label="<?php esc_attr_e( 'Group primary navigation', 'cirkle' ); ?>" role="navigation">
					<ul>
						<?php bp_get_options_nav(); ?>
						<?php
						/**
						 * Fires after the display of group options navigation.
						 *
						 * @since 1.2.0
						 */
						do_action( 'bp_group_options_nav' ); ?>
					</ul>
					<div class="no-ajax" id="subnav" aria-label="<?php esc_attr_e( 'Group secondary navigation', 'cirkle' ); ?>" role="navigation">
						<ul>
							<?php

							/**
							 * Fires inside the syndication options list, after the RSS option.
							 *
							 * @since 1.2.0
							 */
							do_action( 'bp_group_activity_syndication_options' ); ?>

							<li id="activity-filter-select" class="last">
								<label for="activity-filter-by"><?php esc_html_e( 'Show:', 'cirkle' ); ?></label>
								<select id="activity-filter-by">
									<option value="-1"><?php esc_html_e( '&mdash; Everything &mdash;', 'cirkle' ); ?></option>

									<?php bp_activity_show_filters( 'group' ); ?>

									<?php

									/**
									 * Fires inside the select input for group activity filter options.
									 *
									 * @since 1.2.0
									 */
									do_action( 'bp_group_activity_filter_options' ); ?>
								</select>
							</li>
						</ul>
					</div><!-- .item-list-tabs -->
				</div>
			</div><!-- #item-nav -->

			<div id="item-body">

				<?php

				/**
				 * Fires before the display of the group home body.
				 *
				 * @since 1.2.0
				 */
				do_action( 'bp_before_group_body' );

				/**
				 * Does this next bit look familiar? If not, go check out WordPress's
				 * /wp-includes/template-loader.php file.
				 *
				 * @todo A real template hierarchy? Gasp!
				 */

					// Looking at home location
					if ( bp_is_group_home() ) :

						if ( bp_group_is_visible() ) {

							// Load appropriate front template
							bp_groups_front_template_part();

						} else {

							/**
							 * Fires before the display of the group status message.
							 *
							 * @since 1.1.0
							 */
							do_action( 'bp_before_group_status_message' ); ?>

							<div id="message" class="info">
								<p><?php bp_group_status_message(); ?></p>
							</div>

							<?php

							/**
							 * Fires after the display of the group status message.
							 *
							 * @since 1.1.0
							 */
							do_action( 'bp_after_group_status_message' );

						}

					// Not looking at home
					else :

						// Group Admin
						if     ( bp_is_group_admin_page() ) : bp_get_template_part( 'groups/single/admin'        );

						// Group Activity
						elseif ( bp_is_group_activity()   ) : bp_get_template_part( 'groups/single/activity'     );

						// Group Members
						elseif ( bp_is_group_members()    ) : bp_groups_members_template_part();

						// Group Invitations
						elseif ( bp_is_group_invites()    ) : bp_get_template_part( 'groups/single/send-invites' );

						// Membership request
						elseif ( bp_is_group_membership_request() ) : bp_get_template_part( 'groups/single/request-membership' );

						// Anything else (plugins mostly)
						else                                : bp_get_template_part( 'groups/single/plugins'      );

						endif;

					endif;

				/**
				 * Fires after the display of the group home body.
				 *
				 * @since 1.2.0
				 */
				do_action( 'bp_after_group_body' ); ?>
			</div><!-- #item-body -->
		</div>
		<?php 
			if (bp_is_group_single()) {
				Helper::cirkle_sidebar(); 
			}
		?>
	</div>

	<?php
	/**
	 * Fires after the display of the group home content.
	 *
	 * @since 1.2.0
	 */
	do_action( 'bp_after_group_home_content' ); ?>

	<?php endwhile; endif; ?>
</div><!-- #buddypress -->
