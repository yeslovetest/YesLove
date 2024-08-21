<?php
/**
 * BuddyPress - Groups
 *
 * @package BuddyPress
 * @subpackage bp-legacy
 * @version 3.0.0
 */

use radiustheme\cirkle\RDTheme;
use radiustheme\cirkle\Helper;

/**
 * Fires at the top of the groups directory template file.
 *
 * @since 1.5.0
 */
do_action( 'bp_before_directory_groups_page' ); ?>

<div id="buddypress-cirkle" class="group-main-page">
	<?php
	/**
	 * Fires before the display of the groups.
	 *
	 * @since 1.1.0
	 */
	do_action( 'bp_before_directory_groups' ); ?>

	<?php
	/**
	 * Fires before the display of the groups content.
	 *
	 * @since 1.1.0
	 */
	do_action( 'bp_before_directory_groups_content' ); ?>

	<form method="post" id="groups-directory-form" class="dir-form">
		<?php 
			$page_title = RDTheme::$options['groups_banner_title'];
			$size = 'full';
			$img_id = RDTheme::$options['cirkle_gb_img'];
			$page_img = Helper::cirkle_get_attach_img( $img_id, $size );

			$img_id2 = RDTheme::$options['cirkle_gb_shape_img'];
			$page_shape_img = Helper::cirkle_get_attach_img( $img_id2, $size );
		?>

		<!-- Banner Area Start -->
		<div class="newsfeed-banner groups-page-banner">
		    <div class="media">
		        <div class="item-icon">
		            <i class="icofont-megaphone-alt"></i>
		        </div>
		        <div class="media-body">
		            <h3 class="item-title"><?php echo esc_html( $page_title ); ?></h3>
		            <div class="item-list-tabs" aria-label="<?php esc_attr_e( 'Groups directory main navigation', 'cirkle' ); ?>">
						<ul class="user-meta">
							<li class="selected" id="groups-all">
								<a href="<?php bp_groups_directory_permalink(); ?>">
									<?php
									/* translators: %s: all groups count */
									printf( __( 'All Groups %s', 'cirkle' ), '<span>' . bp_get_total_group_count() . '</span>' );
									?>
								</a>
							</li>

							<?php if ( is_user_logged_in() && bp_get_total_group_count_for_user( bp_loggedin_user_id() ) ) : ?>
								<li id="groups-personal">
									<a href="<?php echo bp_loggedin_user_domain() . bp_get_groups_slug() . '/my-groups/'; ?>">
										<?php
										/* translators: %s: current user groups count */
										printf( __( 'My Groups %s', 'cirkle' ), '<span>' . bp_get_total_group_count_for_user( bp_loggedin_user_id() ) . '</span>' );
										?>
									</a>
								</li>
							<?php endif; ?>

							<?php

							/**
							 * Fires inside the groups directory group filter input.
							 *
							 * @since 1.5.0
							 */
							do_action( 'bp_groups_directory_group_filter' ); ?>

						</ul>
					</div><!-- .item-list-tabs -->
		        </div>
		    </div>
		    <?php if (!empty( $page_shape_img || $page_img )) { ?>
		    <ul class="animation-img">
		        <li data-sal="slide-down" data-sal-duration="800" data-sal-delay="400"><?php echo wp_kses( $page_shape_img, 'alltext_allow' ); ?></li>
		        <li data-sal="slide-up" data-sal-duration="500"><?php echo wp_kses( $page_img, 'alltext_allow' ); ?></li>
		    </ul>
		    <?php } ?>
		</div>

		<div id="template-notices" role="alert" aria-atomic="true">
			<?php do_action( 'template_notices' ); ?>
		</div>

		<div class="item-list-tabs tabs-with-search" id="subnav" aria-label="<?php esc_attr_e( 'Groups directory secondary navigation', 'cirkle' ); ?>" role="navigation">

			<div class="dir-search">
				<div class="input-group">
					<label for="<?php bp_search_input_name(); ?>" class="bp-screen-reader-text"><?php bp_search_placeholder(); ?></label>
					<input type="text" name="<?php echo esc_attr( bp_core_get_component_search_query_arg() ); ?>" id="<?php bp_search_input_name(); ?>" class="form-control" placeholder="<?php bp_search_placeholder(); ?>" />

					<div class="input-group-append">
						<button type="submit" id="<?php echo esc_attr( bp_get_search_input_name() ); ?>_submit" class="bp-search-submit members-search-submit search-btn" name="<?php bp_search_input_name(); ?>_submit">
							<i class="icofont-search"></i>
							<span id="button-text" class="bp-screen-reader-text"><?php echo esc_html_x( 'Search', 'button', 'cirkle' ); ?></span>
						</button>
			        </div>
			    </div>
			</div>	

			<ul>
				<?php
				/**
				 * Fires inside the groups directory group types.
				 *
				 * @since 1.2.0
				 */
				do_action( 'bp_groups_directory_group_types' ); ?>

				<li id="groups-order-select" class="last filter">

					<label for="groups-order-by"><?php esc_html_e( 'Order By:', 'cirkle' ); ?></label>

					<select id="groups-order-by">
						<option value="active"><?php esc_html_e( 'Last Active', 'cirkle' ); ?></option>
						<option value="popular"><?php esc_html_e( 'Most Members', 'cirkle' ); ?></option>
						<option value="newest"><?php esc_html_e( 'Newly Created', 'cirkle' ); ?></option>
						<option value="alphabetical"><?php esc_html_e( 'Alphabetical', 'cirkle' ); ?></option>

						<?php

						/**
						 * Fires inside the groups directory group order options.
						 *
						 * @since 1.2.0
						 */
						do_action( 'bp_groups_directory_order_options' ); ?>
					</select>
				</li>
			</ul>
		</div>

		<h2 class="bp-screen-reader-text"><?php
			/* translators: accessibility text */
			esc_html_e( 'Groups directory', 'cirkle' );
		?></h2>

		<div id="groups-dir-list" class="groups dir-list">
			<?php bp_get_template_part( 'groups/groups-loop' ); ?>
		</div><!-- #groups-dir-list -->

		<?php

		/**
		 * Fires and displays the group content.
		 *
		 * @since 1.1.0
		 */
		do_action( 'bp_directory_groups_content' ); ?>

		<?php wp_nonce_field( 'directory_groups', '_wpnonce-groups-filter' ); ?>

		<?php

		/**
		 * Fires after the display of the groups content.
		 *
		 * @since 1.1.0
		 */
		do_action( 'bp_after_directory_groups_content' ); ?>

	</form><!-- #groups-directory-form -->

	<?php

	/**
	 * Fires after the display of the groups.
	 *
	 * @since 1.1.0
	 */
	do_action( 'bp_after_directory_groups' ); ?>

</div><!-- #buddypress-cirkle -->

<?php
/**
 * Fires at the bottom of the groups directory template file.
 *
 * @since 1.5.0
 */
do_action( 'bp_after_directory_groups_page' );
