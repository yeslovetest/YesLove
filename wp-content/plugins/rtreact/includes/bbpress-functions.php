<?php

/**
 * Returns users associated to an activity and reaction
 *
 * @param int $activity_id ID of the activity to return users from
 * @param int $reaction_id ID of the reaction to return users from
 *
 * @return array
 */
function rtreact_bp_get_users_by_activity_reaction( $activity_id, $reaction_id ) {
	$Activity_User_Reaction = new RTReactActivityUserReaction();

	$users_data = $Activity_User_Reaction->getUsersByActivityReaction( $activity_id, $reaction_id );

	$users = [];

	foreach ( $users_data as $user_data ) {
		$users[] = absint( $user_data->user_id );
	}

	return $users;
}

/**
 * Returns reactions associated to an activity.
 *
 * @param int $activity_id ID of the activity to return reactions from
 *
 * @return array
 */
function rtreact_bp_get_activity_reactions( $activity_id ) {
	$Activity_User_Reaction = new RTReactActivityUserReaction();

	$reactions = $Activity_User_Reaction->getReactions( $activity_id );
	foreach ( $reactions as $reaction ) {
		$reaction->name  = rtreact_get_reaction_local_name( $reaction->name );
		$reaction->users = rtreact_bp_get_users_by_activity_reaction( $activity_id, $reaction->id );
	}
	return $reactions;
}
