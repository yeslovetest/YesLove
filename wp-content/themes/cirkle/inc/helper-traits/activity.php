<?php

namespace radiustheme\cirkle;


trait ActivityTrait {
	static function add_favorite_activity( $activityID, $userID ) {
		// true on success, false on error
		return bp_activity_add_user_favorite( $activityID, $userID );
	}

	static function remove_favorite_activity( $activityID, $userID ) {
		// true on success, false on error
		return bp_activity_remove_user_favorite( $activityID, $userID );
	}

	static function activity_create_meta_attachedmedia_id_task( $args ) {
		$task_execute = function ( $args ) {
			$meta_args = [
				'activity_id' => $args['activity_id'],
				'meta_key'    => 'attached_media_id',
				'meta_value'  => $args['id']
			];

			return Helper::update_activity_meta( $meta_args );
		};

		$task_rewind = function ( $args, $activity_id ) {

		};

		return new Cirkle_Task( $task_execute, $task_rewind, $args );
	}

	static function activity_create_meta_attachedmedia_type_task( $args ) {
		$task_execute = function ( $args ) {
			$meta_args = [
				'activity_id' => $args['activity_id'],
				'meta_key'    => 'attached_media_type',
				'meta_value'  => $args['type']
			];

			return Helper::update_activity_meta( $meta_args );
		};

		$task_rewind = function ( $args, $activity_id ) {

		};

		return new Cirkle_Task( $task_execute, $task_rewind, $args );
	}

	static function activity_create_meta_uploadedmedia_id_task( $activity_id ) {
		$task_execute = function ( $activity_id, $media_id ) {
			$meta_args = [
				'activity_id' => $activity_id,
				'meta_key'    => 'uploaded_media_id',
				'meta_value'  => $media_id
			];

			$result = self::add_activity_meta( $meta_args );

			if ( $result ) {
				return $media_id;
			}

			return false;
		};

		$task_rewind = function ( $activity_id, $meta_id ) {

		};

		return new Cirkle_Task( $task_execute, $task_rewind, $activity_id );
	}

	static function create_activity( $args ) {
		$result = bp_activity_add( $args );

		if ( $result ) {
			if ( $args['action'] === 'activity_comment' ) {
				do_action( 'bp_activity_comment_posted', $result, $args );
			} else {
				do_action( 'bp_activity_posted_update', $args['content'], $args['user_id'], $result );
			}

		}

		return $result;
	}

	static function activity_update( $args ) {
		$result = bp_activity_add( $args );

		$activity_id = (int) $args['id'];
		if ( is_numeric( $result ) && ( ( (int) $result ) === $activity_id ) ) {
			Helper::activity_last_edited_by_update( $activity_id, get_current_user_id() );
		}

		return $result;
	}

	static function activity_last_edited_by_update( $activity_id, $user_id ) {
		return bp_activity_update_meta( $activity_id, 'last_edited_by_user', $user_id );
	}

	static function delete_activity( $activity_id ) {
		return bp_activity_delete_by_activity_id( $activity_id );
	}

	static function activity_comment_delete( $activity_id, $comment_id ) {
		return bp_activity_delete_comment( $activity_id, $comment_id );
	}

	static function pin_activity( $activityID, $userID ) {
		return bp_update_user_meta( $userID, 'cirkle_pinned_activity', $activityID );
	}

	static function unpin_activity( $userID ) {
		return bp_update_user_meta( $userID, 'cirkle_pinned_activity', '' );
	}

	static function activity_create_meta_share_count_task( $args ) {
		$task_execute = function ( $args ) {
			$meta_args = [
				'activity_id' => $args['id'],
				'meta_key'    => 'share_count',
				'meta_value'  => $args['count']
			];

			$result = self::update_activity_meta( $meta_args );

			if ( $result ) {
				return $args['id'];
			}

			return false;
		};

		$task_rewind = function ( $args, $activity_id ) {

		};

		return new Cirkle_Task( $task_execute, $task_rewind, $args );
	}


	static function update_activity_meta( $args ) {
		// metadata ID on new meta created, true on meta update, false on error
		return bp_activity_update_meta( $args['activity_id'], $args['meta_key'], $args['meta_value'] );
	}

	static function add_activity_meta( $args ) {
		// metadata ID on new meta created, false on error
		return bp_activity_add_meta( $args['activity_id'], $args['meta_key'], $args['meta_value'] );
	}


	static function activity_action_filter( $action ) {
		$pattern = '/<\s*a[^>]*>[^<]*<\s*\/a\s*>\s*/';

		// remove first anchor
		return preg_replace( $pattern, '', $action, 1 );
	}

	/**
	 * Returns activity data
	 *
	 * @param array $args Filter activities using args data
	 *
	 * @return array
	 */
	public static function get_activities( $args = [] ) {
		$activities_args = [
			'display_comments' => 'threaded',
			'show_hidden'      => true
		];
		$pinned_activity = false;
		if ( array_key_exists( 'include_pinned_from', $args ) && $args['include_pinned_from'] ) {
			$user_id         = $args['include_pinned_from'];
			$pinned_activity = self::get_pinned_activity( $user_id );
			if ( ! empty( $pinned_activity ) && is_array( $pinned_activity ) ) {
				$pinned_activity['pinned']  = true;
				$activities_args['exclude'] = $pinned_activity['id'];
			}

			unset( $args['include_pinned_from'] );
		}
		$activities_args = array_replace_recursive( $activities_args, $args );

		$bp_activities = bp_activity_get( $activities_args );

		$activities = [
			'activities'     => $pinned_activity ? [ $pinned_activity ] : [],
			'has_more_items' => $bp_activities['has_more_items']
		];

		$logged_in_user_id        = bp_loggedin_user_id();
		$logged_in_user_favorites = bp_activity_get_user_favorites( $logged_in_user_id );

		foreach ( $bp_activities['activities'] as $bp_activity ) {
			$comments    = property_exists( $bp_activity, 'children' ) ? $bp_activity->children : false;
			$my_comments = [];

			if ( $comments ) {
				self::get_activity_comments_with_children_recursive( $comments, $my_comments );
			}

			$activity = [
				'id'                => $bp_activity->id,
				'item_id'           => $bp_activity->item_id,
				'secondary_item_id' => $bp_activity->secondary_item_id,
				'component'         => $bp_activity->component,
				'type'              => $bp_activity->type,
				'action'            => self::activity_action_filter( $bp_activity->action ),
				// 'action'            => apply_filters('bp_get_activity_action', $bp_activity->action, $bp_activity),
				'content'           => convert_smilies( stripslashes( $bp_activity->content ) ),
				'date'              => $bp_activity->date_recorded,
				'timestamp'         => sprintf(
					esc_html_x( '%s ago', 'Activity Comment Timestamp', 'cirkle' ),
					human_time_diff(
						mysql2date( 'U', get_date_from_gmt( $bp_activity->date_recorded ) ),
						current_time( 'timestamp' )
					)
				),
				'parent'            => $bp_activity->item_id === $bp_activity->secondary_item_id ? 0 : $bp_activity->secondary_item_id,
				'comments'          => $my_comments,
				'comment_count'     => bp_activity_recurse_comment_count( $bp_activity ),
				'meta'              => bp_activity_get_meta( $bp_activity->id ),
				'author'            => Helper::members_get_fallback( $bp_activity->user_id ),
				'favorite'          => $logged_in_user_favorites && in_array( $bp_activity->id, $logged_in_user_favorites ),
				'reactions'         => [],
				'permalink'         => bp_activity_get_permalink( $bp_activity->id ),
				'hide_sitewide'     => $bp_activity->hide_sitewide,
			];

			if ( Helper::plugin_is_active( 'rtreact' ) ) {
				$activity['reactions'] = Helper::reactions_insert_user_data( rtreact_bp_get_activity_reactions( $bp_activity->id ) );
			}

			// add group information
			if ( $bp_activity->component === 'groups' ) {
				$activity['group'] = Helper::groups_get( [ 'include' => [ $bp_activity->item_id ] ] )[0];
			}

			// add friend information
			if ( $bp_activity->type === 'friendship_created' ) {
				$activity['friend'] = Helper::members_get( [
					'include'    => [ $bp_activity->secondary_item_id ],
					'data_scope' => 'user-activity-friend'
				] )[0];
			}

			// add share information
			if ( $bp_activity->type === 'activity_share' ) {
				$activity['shared_item'] = self::get_activities( [
					'in'               => $bp_activity->secondary_item_id,
					'display_comments' => false
				] )['activities'][0];
			}

			// add share information
			if ( $bp_activity->type === 'post_share' ) {
				$activity['shared_item'] = Helper::get_posts( [ 'include' => [ $bp_activity->secondary_item_id ] ] )[0];
			}

			// add media information
			if ( Helper::plugin_is_active( 'mediapress' ) ) {
				$media_ids = mpp_activity_get_attached_media_ids( $bp_activity->id );
				$mpp_media = [];
				foreach ( $media_ids as $media_id ) {
					if ( $media = mpp_get_media( $media_id ) ) {
						$is_remote = (bool) get_post_meta( $media->id, '_mpp_is_remote', true );
						$is_oembed = (bool) get_post_meta( $media->id, '_mpp_is_oembed', true );
						$mediaData = [
							'id'         => $media->id,
							'type'       => $media->type,
							'user_id'    => $media->user_id,
							'gallery_id' => $media->gallery_id,
							'title'      => $media->title,
							'is_remote'  => $is_remote,
							'is_oembed'  => $is_oembed,
							'link'       => mpp_get_media_src( '', $media )
						];
						if ( $is_remote ) {
							$mediaData['source'] = get_post_meta( $media->id, '_mpp_source', true );
						}
						if ( $is_oembed ) {
							$mediaData['oembed'] = [
								'thumbnail' => get_post_meta( $media->id, '_mpp_oembed_content_thumbnail', true ),
								'content'   => get_post_meta( $media->id, '_mpp_oembed_content', true ),
							];
						}
						$mpp_media[] = $mediaData;
					}
				}
				$uploaded_media_count = count( $mpp_media );
				if ( count( $mpp_media ) > 0 ) {
					$display_max                = 5;
					$uploaded_media_fetch_count = min( $display_max, $uploaded_media_count );

					if ( $bp_activity->component === 'groups' ) {
						$media_group = self::groups_get( [ 'include' => [ $bp_activity->item_id ] ] )[0];
						$more_link   = trailingslashit( bp_get_groups_directory_permalink() . $media_group['slug'] . '/photos' );
					} else {
						$more_link = bp_core_get_user_domain( $bp_activity->user_id ) . 'photos';
					}

					$activity['uploaded_media'] = [
						'data'     => array_slice( $mpp_media, 0, $uploaded_media_fetch_count ),
						'metadata' => [
							'more'      => abs( $display_max - $uploaded_media_count ),
							'more_link' => $more_link
						]
					];
				}
			}


			$activities['activities'][] = $activity;
		}

		return $activities;
	}


	/**
	 * Get user pinned activity
	 *
	 * @param int $userID ID of the user
	 *
	 * @return bool|array
	 */
	public static function get_pinned_activity( $userID ) {
		// meta value if key exists, empty string if not
		$pinned_activity_id = (int) bp_get_user_meta( $userID, 'cirkle_pinned_activity', true );
		$pinned_activity    = false;
		if ( $pinned_activity_id ) {
			$pinned_activity_args = [
				'in'          => $pinned_activity_id,
				'show_hidden' => true
			];

			$pinned_activity = self::get_activities( $pinned_activity_args )['activities'];

			if ( count( $pinned_activity ) === 1 ) {
				$pinned_activity = $pinned_activity[0];
			}
		}

		return $pinned_activity;

	}

	/**
	 * Recursively re-format comment info
	 */
	public static function get_activity_comments_with_children_recursive( $comments, &$my_comments ) {
		foreach ( $comments as $comment ) {
			// only send required data
			$com = [
				'id'        => $comment->id,
				'parent'    => $comment->item_id === $comment->secondary_item_id ? 0 : $comment->secondary_item_id,
				'author'    => Helper::members_get( [ 'include' => [ $comment->user_id ] ] )[0],
				'date'      => $comment->date_recorded,
				'content'   => convert_smilies( stripslashes( $comment->content ) ),
				'timestamp' => sprintf(
					esc_html_x( '%s ago', 'Activity Comment Timestamp', 'cirkle' ),
					human_time_diff(
						mysql2date( 'U', get_date_from_gmt( $comment->date_recorded ) ),
						current_time( 'timestamp' )
					)
				),
				'reactions' => []
			];

			if ( Helper::plugin_is_active( 'rtreact' ) && Helper::plugin_is_active( 'buddypress' ) ) {
				$com['reactions'] = Helper::reactions_insert_user_data( rtreact_bp_get_activity_reactions( $comment->id ) );
			}

			if ( $comment->children ) {
				$com['children'] = [];
				self::get_activity_comments_with_children_recursive( $comment->children, $com['children'] );
			}

			$my_comments[] = $com;
		}
	}


	/**
	 * Get member activity post count
	 *
	 * @param int $member_id ID of the user to get the activity post count from
	 *
	 * @return int
	 */
	public static function activity_get_member_post_count( $member_id ) {
		$args = [
			'filter' => [
				'user_id' => $member_id,
				'object'  => [
					'activity',
					'groups'
				],
				'action'  => [
					'activity_update',
					'mpp_media_upload',
					'activity_share',
					'post_share'
				]
			]
		];

		return count( bp_activity_get( $args )['activities'] );
	}


	/**
	 * Get member activity comment count
	 *
	 * @param int $member_id ID of the user to get the activity comment count from
	 *
	 * @return int
	 */
	public static function activity_get_member_comment_count( $member_id ) {
		$args = [
			'display_comments' => 'stream',
			'filter'           => [
				'user_id' => $member_id,
				'object'  => [
					'activity',
					'groups'
				],
				'action'  => [
					'activity_comment'
				]
			]
		];

		return count( bp_activity_get( $args )['activities'] );
	}

}


