<?php
	/**
	* BuddyPress - Groups Loop
	*
	* Querystring is set via AJAX in _inc/ajax.php - bp_legacy_theme_object_filter().
	*
	* @package BuddyPress
	* @subpackage bp-legacy
	* @version 3.0.0
	*/
	use radiustheme\cirkle\RDTheme;
	use radiustheme\cirkle\Helper;
	$groups_per_page = RDTheme::$options['groups_per_page'];

	$group_count = groups_get_user_groups( bp_get_member_user_id() );
?>

<?php

/**
 * Fires before the display of groups from the groups loop.
 *
 * @since 1.2.0
 */
do_action( 'bp_before_groups_loop' ); ?>

<?php if ( bp_get_current_group_directory_type() ) : ?>
	<p class="current-group-type"><?php bp_current_group_directory_type_message() ?></p>
<?php endif; ?>

<?php if ( bp_has_groups( bp_ajax_querystring( 'groups' ).'&per_page='.$groups_per_page ) ) : ?>

	<?php

	/**
	 * Fires before the listing of the groups list.
	 *
	 * @since 1.1.0
	 */
	do_action( 'bp_before_directory_groups_list' ); ?>

	<div id="user-view" class="user-grid-view">
        <div class="row gutters-20">
			<?php while ( bp_groups() ) : bp_the_group(); ?>
				<div <?php bp_group_class( array('col-xl-3 col-lg-4 col-md-6') ); ?>>
                    <div class="widget-author user-group">
                        <div class="author-heading">
                        	<?php 
								$dir = 'groups';
								$user_id = bp_get_group_id();
								Helper::banner_img( $user_id, $dir ); 
							?>
                            <?php if ( ! bp_disable_group_avatar_uploads() ) : ?>
                            <div class="profile-img">
                                <a href="<?php bp_group_permalink(); ?>">
                                    <?php bp_group_avatar( 'type=full' ); ?>
                                </a>
                            </div>
                            <?php endif; ?>
                            <div class="profile-name">
                                <h4 class="author-name"><?php bp_group_link(); ?></h4>
                                <div class="author-location"><?php bp_group_type(); ?></div>
                            </div>
                        </div>
                       <?php if ( bp_group_has_members( 'group_id='.bp_get_group_id().'&per_page=4&exclude_admins_mods=false' ) ) : ?>
                        <ul class="member-thumb">
                        	<?php while ( bp_group_members() ) : bp_group_the_member(); ?>
                            <li><a href="<?php bp_member_permalink(); ?>"><?php bp_group_member_avatar_thumb('type=full'); ?></a></li>
                            <?php endwhile; ?>
                            <?php if ( bp_get_group_member_count() > 4 ) { ?>
                            <li><a href="<?php bp_group_permalink(); ?>"><i class="icofont-plus"></i></a></li>
                        	<?php } ?>
                        </ul>
                        <?php endif; ?>
                        <ul class="author-statistics">
                            <li>
                                <a href="<?php bp_group_permalink(); ?>"><span class="item-number"><?php echo Helper::cirkle_group_updates_count( bp_get_group_id() ); ?></span> <span class="item-text"><?php esc_html_e('Group Posts', 'cirkle'); ?></span></a>
                            </li>
                            <li>
                                <a href="<?php bp_group_permalink(); ?>">
                                    <?php
									/* translators: %s: group members count */
									printf( _nx( '<span class="item-number">%d</span> <span class="item-text">Member</span>', '<span class="item-number">%d</span> <span class="item-text">All Member</span>', bp_get_group_total_members( false ),'Group member count', 'cirkle' ), bp_get_group_total_members( false )  );
									?>
								</a>
                            </li>
                        </ul>
                    </div>
                </div>
			<?php endwhile; ?>
		</div>
	</div>

	<?php

	/**
	 * Fires after the listing of the groups list.
	 *
	 * @since 1.1.0
	 */
	do_action( 'bp_after_directory_groups_list' ); ?>
	<?php 
	if ( $group_count > 8 ) { ?>
		<div id="pag-bottom" class="pagination">
			<div class="pagination-links" id="group-dir-pag-bottom">
				<?php bp_groups_pagination_links(); ?>
			</div>
		</div>
	<?php } ?>
<?php else: ?>

	<div id="message" class="info">
		<p><?php esc_html_e( 'There were no groups found.', 'cirkle' ); ?></p>
	</div>

<?php endif; ?>

<?php

/**
 * Fires after the display of groups from the groups loop.
 *
 * @since 1.2.0
 */
do_action( 'bp_after_groups_loop' );
