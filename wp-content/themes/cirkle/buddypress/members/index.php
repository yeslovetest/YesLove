<?php
/**
 * BuddyPress - Members
 *
 * @package BuddyPress
 * @subpackage bp-legacy
 * @version 3.0.0
 */

use radiustheme\cirkle\RDTheme;
use radiustheme\cirkle\Helper;

/**
 * Fires at the top of the members directory template file.
 *
 * @since 1.5.0
 */
do_action( 'bp_before_directory_members_page' ); 

if ( is_active_sidebar('member-widgets')) {
	$mw = 'member-widgets-active';
} else {
	$mw = 'sidebar-none';
}

?>

<div id="cirkle-buddypress" class="<?php echo esc_attr( $mw ); ?>">

	<?php
		$page_title = RDTheme::$options['member_banner_title'];
		$page_desc  = RDTheme::$options['member_banner_desc'];

		$img_id = RDTheme::$options['cirkle_mb_img'];
		$size = 'full';
		$page_img = Helper::cirkle_get_attach_img( $img_id, $size );

		$img_id2 = RDTheme::$options['cirkle_mb_shape_img'];
		$page_shape_img = Helper::cirkle_get_attach_img( $img_id2, $size );

		/**
		 * Section Banner
		*/
		echo get_template_part('template-parts/banner/page', 'banner', [
		    'page_img_url'  => $page_img,
		    'shape_img_url' => $page_shape_img,
		    'page_title'    => $page_title,
		    'page_desc'     => $page_desc,
		]);

	?>
	<div class="row">
        <div class="<?php Helper::the_layout_class(); ?>">
			<?php
				/**
				 * Fires before the display of the members.
				 *
				 * @since 1.1.0
				 */
				do_action( 'bp_before_directory_members' ); 
			?>

			<?php
				/**
				 * Fires before the display of the members content.
				 *
				 * @since 1.1.0
				 */
				do_action( 'bp_before_directory_members_content' );
			?>
			<div class="block-box user-search-bar">
				<?php bp_get_template_part( 'members/directory/search' ); ?>

				<div class="item-list-tabs" id="subnav" aria-label="<?php esc_attr_e( 'Members directory secondary navigation', 'cirkle' ); ?>" role="navigation">
					<ul>
						<?php
						/**
						 * Fires inside the members directory member sub-types.
						 *
						 * @since 1.5.0
						 */
						do_action( 'bp_members_directory_member_sub_types' ); ?>

						<li id="members-order-select" class="last filter">
							<label for="members-order-by"><?php esc_html_e( 'Order By:', 'cirkle' ); ?></label>
							<select id="members-order-by">
								<option value="active"><?php esc_html_e( 'Last Active', 'cirkle' ); ?></option>
								<option value="newest"><?php esc_html_e( 'Newest Member', 'cirkle' ); ?></option>
								<?php if ( bp_is_active( 'xprofile' ) ) : ?>
									<option value="alphabetical"><?php esc_html_e( 'Alphabetical', 'cirkle' ); ?></option>
								<?php endif; ?>
								<?php
								/**
								 * @since 1.2.0
								 */
								do_action( 'bp_members_directory_order_options' ); ?>
							</select>
						</li>
					</ul>
				</div>
			</div>
			<?php
			/**
			 * Fires before the display of the members list tabs.
			 *
			 * @since 1.8.0
			 */
			do_action( 'bp_before_directory_members_tabs' ); ?>

			<form method="post" id="members-directory-form" class="dir-form">
				<div class="item-list-tabs" aria-label="<?php esc_attr_e( 'Members directory main navigation', 'cirkle' ); ?>" role="navigation">
					<ul>
						<li class="selected" id="members-all"><a href="<?php echo trailingslashit( bp_get_root_domain() . '/' . bp_get_members_root_slug() ); ?>"><?php printf( __( 'All Members <span>%s</span>', 'cirkle' ), bp_get_total_site_member_count() ); ?></a></li>

						<?php if ( is_user_logged_in() && bp_is_active( 'friends' ) && bp_get_total_friend_count( bp_loggedin_user_id() ) ) : ?>

							<li id="members-personal"><a href="<?php echo bp_loggedin_user_domain() . bp_get_friends_slug() . '/my-friends/' ?>"><?php printf( __( 'My Friends <span>%s</span>', 'cirkle' ), bp_get_total_friend_count( bp_loggedin_user_id() ) ); ?></a></li>

						<?php endif; ?>

						<?php do_action( 'bp_members_directory_member_types' ); ?>

					</ul>
				</div><!-- .item-list-tabs -->
				<h2 class="bp-screen-reader-text"><?php
					/* translators: accessibility text */
					esc_html_e( 'Members directory', 'cirkle' );
				?></h2>

				<div id="members-dir-list" class="members dir-list">
					<?php bp_get_template_part( 'members/members-loop' ); ?>
				</div><!-- #members-dir-list -->

				<?php
				/**
				 * Fires and displays the members content.
				 *
				 * @since 1.1.0
				 */
				do_action( 'bp_directory_members_content' ); ?>

				<?php wp_nonce_field( 'directory_members', '_wpnonce-member-filter' ); ?>

				<?php
				/**
				 * Fires after the display of the members content.
				 *
				 * @since 1.1.0
				 */
				do_action( 'bp_after_directory_members_content' ); ?>

			</form><!-- #members-directory-form -->

			<?php
			/**
			 * Fires after the display of the members.
			 *
			 * @since 1.1.0
			 */
			do_action( 'bp_after_directory_members' ); ?>
		</div>	
    	<?php Helper::cirkle_sidebar(); ?>
    </div>
</div><!-- #buddypress -->

<?php

/**
 * Fires at the bottom of the members directory template file.
 *
 * @since 1.5.0
 */
do_action( 'bp_after_directory_members_page' );
