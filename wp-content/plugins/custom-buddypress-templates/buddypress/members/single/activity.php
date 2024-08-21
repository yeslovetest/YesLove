<?php
/**
 * BuddyPress - Users Activity
 *
 * @package BuddyPress
 * @subpackage bp-legacy
 * @version 3.0.0
 */

$user_id = bp_displayed_user_id();

?>
<div id="activity-filterable-list" data-userid="<?php echo esc_attr($user_id); ?>"><div class="cirkle-loader"></div></div>
<?php

/**
 * Fires before the display of the member activities list.
 *
 * @since 1.2.0
 */
do_action( 'bp_before_member_activity_content' );
?>

<?php

/**
 * Fires after the display of the member activities list.
 *
 * @since 1.2.0
*/
do_action( 'bp_after_member_activity_content' );
