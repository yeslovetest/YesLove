<?php
/**
 * BuddyPress Activity templates
 *
 * @since 2.3.0
 *
 * @package BuddyPress
 * @subpackage bp-legacy
 * @version 3.0.0
 */

use radiustheme\cirkle\RDTheme;
use radiustheme\cirkle\Helper;

/**
 * Fires before the activity directory listing.
 *
 * @since 1.5.0
 */
do_action( 'bp_before_directory_activity' ); ?>

<div id="buddypress-news-feed" class="news-feed-page">
	<?php
		$page_title = RDTheme::$options['newsfeed_banner_title'];
		$page_desc = RDTheme::$options['newsfeed_banner_desc'];
		$size = 'full';
		$img_id = RDTheme::$options['cirkle_nb_img'];
		$page_img = Helper::cirkle_get_attach_img( $img_id, $size );

		$img_id2 = RDTheme::$options['cirkle_nb_shape_img'];
		$page_shape_img = Helper::cirkle_get_attach_img( $img_id2, $size );
	?>

	<!-- Banner Area Start -->
	<div class="newsfeed-banner">
	    <div class="media">
	        <div class="item-icon">
	            <i class="icofont-megaphone-alt"></i>
	        </div>
	        <div class="media-body">
	            <h3 class="item-title"><?php echo esc_html( $page_title ); ?></h3>
	            <p><?php echo esc_html( $page_desc ); ?></p>
	        </div>
	    </div>
	    <?php if (!empty( $page_shape_img || $page_img )) { ?>
	    <ul class="animation-img">
	        <li data-sal="slide-down" data-sal-duration="800" data-sal-delay="400"><?php echo wp_kses( $page_shape_img, 'alltext_allow' ); ?></li>
	        <li data-sal="slide-up" data-sal-duration="500"><?php echo wp_kses( $page_img, 'alltext_allow' ); ?></li>
	    </ul>
	    <?php } ?>
	</div>

	<div class="row">
		<div class="<?php Helper::the_layout_class(); ?>">
			
			<?php
			/**
			 * Fires before the activity directory display content.
			 *
			 * @since 1.2.0
			 */
			do_action( 'bp_before_directory_activity_content' ); ?>

			<?php if ( is_user_logged_in() ) : ?>
			<div class="cirkle-activity-form">
				<?php bp_get_template_part( 'common/post-form' );?>
			</div>	
			<?php endif; ?>

			<div id="template-notices" role="alert" aria-atomic="true">
				<?php
				/**
				 * Fires towards the top of template pages for notice display.
				 *
				 * @since 1.0.0
				 */
				do_action( 'template_notices' ); ?>
			</div>

			<?php
			/**
			 * Fires before the display of the activity list.
			 *
			 * @since 1.5.0
			 */
			do_action( 'bp_before_directory_activity_list' ); ?>

            <div id="activity-filterable-list" data-hideFilter></div>

			<?php
			/**
			 * Fires after the display of the activity list.
			 *
			 * @since 1.5.0
			 */
			do_action( 'bp_after_directory_activity_list' ); ?>

			<?php
			/**
			 * Fires inside and displays the activity directory display content.
			 */
			do_action( 'bp_directory_activity_content' ); ?>

			<?php
			/**
			 * Fires after the activity directory display content.
			 *
			 * @since 1.2.0
			 */
			do_action( 'bp_after_directory_activity_content' ); ?>
			<?php

			/**
			 * Fires after the activity directory listing.
			 *
			 * @since 1.5.0
			 */
			do_action( 'bp_after_directory_activity' ); ?>
		</div>
		<?php 
			if (!bp_is_groups_component()) {
				Helper::cirkle_sidebar(); 
			}
		?>
	</div>
</div>
