<?php
/**
 * BuddyPress - Activity Stream (Single Item)
 *
 * This template is used by activity-loop.php and AJAX functions to show
 * each activity.
 *
 * @package Cirkle
 * @since   1.0.0
 * @author  RadiusTheme (https://www.radiustheme.com/)
 *
 */

use radiustheme\cirkle\Helper;

$displayed_user   = bp_get_displayed_user();
$member_id = !empty($displayed_user->id) ? $displayed_user->id : 0;

/**
 * Fires before the display of an activity entry.
 *
 * @since 1.2.0
 */
do_action('bp_before_activity_entry'); ?>

    <div id="activity-filterable-list"
    	data-groupid="<?php echo bp_get_group_id(); ?>"
        data-userid="<?php echo esc_attr($member_id); ?>"
        data-activityid="<?php echo esc_attr(bp_get_activity_id()); ?>"
        data-nofilter
    >
    </div>

<?php

/**
 * Fires after the display of an activity entry.
 *
 * @since 1.2.0
 */
do_action('bp_after_activity_entry');

