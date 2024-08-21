<?php
/**
 * BuddyPress - Users Groups
 *
 * @package BuddyPress
 * @subpackage bp-legacy
 * @version 3.0.0
 */

?>

<div class="item-list-tabs no-ajax block-box user-search-bar" id="subnav" aria-label="<?php esc_attr_e( 'Member secondary navigation', 'cirkle' ); ?>" role="navigation">
	<div class="box-item search-box">
	    <?php if ( has_filter( 'bp_directory_groups_search_form' ) ) : ?>
			<div id="group-dir-search" class="dir-search" role="search">
				<?php bp_directory_groups_search_form(); ?>
			</div><!-- #group-dir-search -->
		<?php else: ?>
			<?php bp_get_template_part( 'common/search/dir-search-form' ); ?>
		<?php endif; ?>
	</div>
	<div class="box-item search-filter">
		<ul>
			<?php if ( bp_is_my_profile() ) bp_get_options_nav(); ?>
			<?php if ( !bp_is_current_action( 'invites' ) ) : ?>
				<li id="groups-order-select" class="last filter">
					<label for="groups-order-by"><?php esc_html_e( 'Order By:', 'cirkle' ); ?></label>
					<select id="groups-order-by">
						<option value="active"><?php esc_html_e( 'Last Active', 'cirkle' ); ?></option>
						<option value="popular"><?php esc_html_e( 'Most Members', 'cirkle' ); ?></option>
						<option value="newest"><?php esc_html_e( 'Newly Created', 'cirkle' ); ?></option>
						<option value="alphabetical"><?php esc_html_e( 'Alphabetical', 'cirkle' ); ?></option>
						<?php
						/**
						 * Fires inside the members group order options select input.
						 *
						 * @since 1.2.0
						 */
						do_action( 'bp_member_group_order_options' ); ?>

					</select>
				</li>
			<?php endif; ?>
		</ul>
	</div>
	<div class="box-item search-switcher">
        <ul class="user-view-switcher">
            <li class="active">
                <a class="user-view-trigger" href="#" data-type="user-grid-view">
                    <i class="icofont-layout"></i>
                </a>
            </li>
            <li>
                <a class="user-view-trigger" href="#" data-type="user-list-view">
                    <i class="icofont-listine-dots"></i>
                </a>
            </li>
        </ul>
    </div>
</div><!-- .item-list-tabs -->

<?php

switch ( bp_current_action() ) :

	case 'my-groups' :

		/**
		 * Fires before the display of member groups content.
		 *
		 * @since 1.2.0
		 */
		do_action( 'bp_before_member_groups_content' ); ?>

		<?php if ( is_user_logged_in() ) : ?>
			<h2 class="bp-screen-reader-text"><?php
				/* translators: accessibility text */
				esc_html_e( 'My groups', 'cirkle' );
			?></h2>
		<?php else : ?>
			<h2 class="bp-screen-reader-text"><?php
				/* translators: accessibility text */
				esc_html_e( 'Member\'s groups', 'cirkle' );
			?></h2>
		<?php endif; ?>

		<div class="groups mygroups">
			<?php bp_get_template_part( 'groups/groups-loop' ); ?>
		</div>

		<?php
		/**
		 * Fires after the display of member groups content.
		 *
		 * @since 1.2.0
		 */
		do_action( 'bp_after_member_groups_content' );
		break;

	// Group Invitations
	case 'invites' :
		bp_get_template_part( 'members/single/groups/invites' );
		break;

	// Any other
	default :
		bp_get_template_part( 'members/single/plugins' );
		break;
endswitch;
