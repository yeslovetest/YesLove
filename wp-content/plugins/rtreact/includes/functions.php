<?php

/**
 * Create a user reaction for a post comment
 *
 * @param array $args
 *                $comment_id   ID of the post comment
 *                $user_id          ID of the user
 *                $reaction_id      ID of the reaction
 *
 * @return int|boolean
 */
function rtreact_create_comment_reaction( $args ) {
	$ReactComment = new RTReactComment();

	return $ReactComment->create( $args );
}

/**
 * Delete a user reaction for a post comment
 *
 * @param array $args
 *                $comment_id    ID of the post comment
 *                $user_id           ID of the user
 *
 * @return int|boolean
 */
function rtreact_delete_comment_reaction( $args ) {
	$ReactComment = new RTReactComment();

	return $ReactComment->delete( $args );
}


/**
 * Delete all user post comment reactions
 *
 * @param int $user_id ID of the user.
 *
 * @return int/boolean
 */
function rtreact_delete_comment_reactions( $user_id ) {
	$ReactComment = new RTReactComment();

	return $ReactComment->deleteUserReactions( $user_id );
}

/**
 * Returns reactions associated to a post comment
 *
 * @param int $comment_id ID of the post comment to return reactions from
 *
 * @return array
 */
function rtreact_get_comment_reactions( $comment_id ) {
	$ReactComment = new RTReactComment();

	$reactions = $ReactComment->getReactions( $comment_id );

	if ( ! empty( $reactions ) ) {
		foreach ( $reactions as $reaction ) {
			$reaction->users = rtreact_get_users_by_comment_reaction( $comment_id, $reaction->id );
		}
	}

	return $reactions;
}

/**
 * Returns users associated to a post comment and reaction
 *
 * @param int $comment_id ID of the post comment to return users from
 * @param int $reaction_id ID of the reaction to return users from
 *
 * @return array
 */
function rtreact_get_users_by_comment_reaction( $comment_id, $reaction_id ) {
	$ReactComment = new RTReactComment();

	$users_data = $ReactComment->getUsersByPostCommentReaction( $comment_id, $reaction_id );

	$users = [];
	if ( ! empty( $users_data ) ) {
		foreach ( $users_data as $user_data ) {
			$users[] = absint( $user_data->user_id );
		}
	}

	return $users;
}

/**
 * Create a user reaction for a post
 *
 * @param array $args
 *                $post_id          ID of the post
 *                $user_id          ID of the user
 *                $reaction_id      ID of the reaction
 *
 * @return int | boolean
 */
function rtreact_create_post_reaction( $args ) {
	$ReactPost = new RTReactPost();

	return $ReactPost->create( $args );
}


/**
 * Delete a user reaction for a post
 *
 * @param array $args
 *                $post_id          ID of the post
 *                $user_id          ID of the user
 *
 * @return int|boolean
 */
function rtreact_delete_post_reaction( $args ) {
	$ReactPost = new RTReactPost();

	return $ReactPost->delete( $args );
}


/**
 * Delete all user post reactions
 *
 * @param int $user_id ID of the user.
 *
 * @return int|boolean
 */
function rtreact_delete_post_reactions( $user_id ) {
	$ReactPost = new RTReactPost();

	return $ReactPost->deleteUserReactions( $user_id );
}


/**
 * Returns reactions associated to a post
 *
 * @param int $post_id ID of the post to return reactions from
 *
 * @return array
 */
function rtreact_get_post_reactions( $post_id ) {
	$ReactPost = new RTReactPost();

	$reactions = $ReactPost->getReactions( $post_id );

	if ( ! empty( $reactions ) ) {
		foreach ( $reactions as $reaction ) {
			$reaction->users = rtreact_get_users_by_post_reaction( $post_id, $reaction->id );
		}
	}

	return $reactions;
}

/**
 * Returns users associated to a post and reaction
 *
 * @param int $post_id ID of the post to return users from
 * @param int $reaction_id ID of the reaction to return users from
 *
 * @return array
 */
function rtreact_get_users_by_post_reaction( $post_id, $reaction_id ) {
	$ReactPost = new RTReactPost();

	$users_data = $ReactPost->getUsersByPostReaction( $post_id, $reaction_id );

	$users = [];
	if ( ! empty( $users_data ) ) {
		foreach ( $users_data as $user_data ) {
			$users[] = absint( $user_data->user_id );
		}
	}

	return $users;
}

/**
 * @return array
 */
function rtreact_get_reactions() {
	$Reaction = new RTReactReaction();

	// array with matching elements, empty array if no matching rows or database error
	$results = $Reaction->getAll();

	$reactions = [];

	foreach ( $results as $reaction_item ) {
		$reaction       = $reaction_item;
		$reaction->name = rtreact_get_reaction_local_name( $reaction->name );
		$reactions[]    = $reaction;
	}

	return $reactions;
}

if ( ! function_exists( 'rtreact_post_reactions_html' ) ) {
	/**
	 * Returns reactions associated to a post
	 *
	 * @param int $post_id ID of the post to return reactions from
	 *
	 * @return void
	 */
	function rtreact_post_reactions_html( $post_id = 0 ) {
		$post_id = ! $post_id ? get_the_ID() : $post_id;
		if ( ! $post_id ) {
			return;
		}

		$total_reactions = 0;
		$reactions       = rtreact_get_post_reactions( $post_id );
		if ( ! empty( $reactions ) ) {
		?>
        <div class="reaction-icon">
			<?php
				$has_current_user = false;
				foreach ( $reactions as $reaction ) {
					$total_reactions  += $reaction->reaction_count;
					$has_current_user = ! $has_current_user && in_array( get_current_user_id(), $reaction->users );
					echo sprintf( '<img src="%1$s" alt="%2$s" data-id="%3$s" data-count="%4$d" data-current="%5$b" />',
						$reaction->image_url,
						$reaction->name,
						$reaction->id,
						$reaction->reaction_count,
						$has_current_user
					);
				} 
			?>
        </div>
        <?php } if ( $total_reactions > 0 ) { ?>
        	<div class="meta-text reaction-count"><?php echo $total_reactions; ?></div>
		<?php } else { ?> 
			<div class="meta-text reaction-count"><?php esc_html_e( 'No React!', 'cirkle' ); ?></div>
		<?php }
	}
}

/**
 * @param string $reaction_type
 *
 * @return null|string
 */
function rtreact_get_reaction_local_name( $reaction_type ) {
	$reactions = [
		'like'    => esc_html__( 'like', 'rtreact' ),
		'love'    => esc_html__( 'love', 'rtreact' ),
		'dislike' => esc_html__( 'dislike', 'rtreact' ),
		'happy'   => esc_html__( 'happy', 'rtreact' ),
		'funny'   => esc_html__( 'funny', 'rtreact' ),
		'wow'     => esc_html__( 'wow', 'rtreact' ),
		'angry'   => esc_html__( 'angry', 'rtreact' ),
		'sad'     => esc_html__( 'sad', 'rtreact' )
	];
	return ! empty( $reactions[ $reaction_type ] ) ? $reactions[ $reaction_type ] : '';
}
