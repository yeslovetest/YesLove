<?php

namespace radiustheme\cirkle\ajax;

use radiustheme\cirkle\Cirkle_Scheduler;
use radiustheme\cirkle\Helper;

class CirkleAjaxActivity {

	static public function init() {
		add_action( 'wp_ajax_cirkle_get_activities_ajax', [ __CLASS__, 'get_activities' ] );
		add_action( 'wp_ajax_nopriv_cirkle_get_activities_ajax', [ __CLASS__, 'get_activities' ] );

		add_action( 'wp_ajax_cirkle_delete_activity_ajax', [ __CLASS__, 'delete_activity_ajax' ] );
		add_action( 'wp_ajax_nopriv_cirkle_delete_activity_ajax', [ __CLASS__, 'delete_activity_ajax' ] );


		add_action( 'wp_ajax_cirkle_get_pinned_activity_ajax', [ __CLASS__, 'pinned_activity_ajax' ] );
		add_action( 'wp_ajax_nopriv_cirkle_get_pinned_activity_ajax', [ __CLASS__, 'pinned_activity_ajax' ] );

		add_action( 'wp_ajax_cirkle_get_unpin_activity_ajax', [ __CLASS__, 'get_unpin_activity_ajax' ] );
		add_action( 'wp_ajax_nopriv_cirkle_get_unpin_activity_ajax', [ __CLASS__, 'get_unpin_activity_ajax' ] );


		add_action( 'wp_ajax_cirkle_pin_activity_ajax', [ __CLASS__, 'pin_activity_ajax' ] );
		add_action( 'wp_ajax_nopriv_cirkle_pin_activity_ajax', [ __CLASS__, 'pin_activity_ajax' ] );


		add_action( 'wp_ajax_cirkle_unpin_activity_ajax', [ __CLASS__, 'unpin_activity_ajax' ] );
		add_action( 'wp_ajax_nopriv_cirkle_unpin_activity_ajax', [ __CLASS__, 'unpin_activity_ajax' ] );

		add_action( 'wp_ajax_cirkle_create_activity_comment', [ __CLASS__, 'create_activity_comment' ] );
		add_action( 'wp_ajax_nopriv_cirkle_create_activity_comment', [ __CLASS__, 'create_activity_comment' ] );

		add_action( 'wp_ajax_cirkle_activity_comment_delete', [ __CLASS__, 'delete_activity_comment' ] );
		add_action( 'wp_ajax_cirkle_activity_update', [ __CLASS__, 'activity_update' ] );

		add_action( 'wp_ajax_cirkle_add_favorite_activity_ajax', [ __CLASS__, 'add_favorite_activity_ajax' ] );
		add_action( 'wp_ajax_nopriv_cirkle_add_favorite_activity_ajax', [ __CLASS__, 'add_favorite_activity_ajax' ] );
		add_action( 'wp_ajax_cirkle_remove_favorite_activity_ajax', [ __CLASS__, 'remove_favorite_activity_ajax' ] );
		add_action( 'wp_ajax_nopriv_cirkle_remove_favorite_activity_ajax', [
			__CLASS__,
			'remove_favorite_activity_ajax'
		] );
	}

	/**
	 * Add favorite activity
	 */
	static function remove_favorite_activity_ajax() {
		// nonce check, dies early if the nonce cannot be verified
		check_ajax_referer( 'cirkle_ajax' );

		$result = Helper::remove_favorite_activity( $_POST['activityID'], $_POST['userID'] );
		wp_send_json( $result );
	}

	/**
	 * Add favorite activity
	 */
	static function add_favorite_activity_ajax() {
		// nonce check, dies early if the nonce cannot be verified
		check_ajax_referer( 'cirkle_ajax' );

		$result = Helper::add_favorite_activity( $_POST['activityID'], $_POST['userID'] );
		wp_send_json( $result );
	}

	static function create_activity_comment() {
		// nonce check, dies early if the nonce cannot be verified
		check_ajax_referer( 'cirkle_ajax' );

		$args = isset( $_POST['args'] ) ? $_POST['args'] : [];

		$result = bp_activity_new_comment( $args );
		wp_send_json( $result );
	}

	static function delete_activity_comment() {
		check_ajax_referer( 'cirkle_ajax' );
		$args = isset( $_POST['args'] ) ? $_POST['args'] : false;

		if ( ! $args ) {
			wp_die();
		}

		$activity_id = isset( $args['activity_id'] ) ? (int) $args['activity_id'] : false;
		$comment_id  = isset( $args['comment_id'] ) ? (int) $args['comment_id'] : false;

		if ( ! $activity_id || ! $comment_id ) {
			wp_die( 'Missing parameters' );
		}

		$logged_user_is_site_admin = current_user_can( 'administrator' );

		// get logged user id
		$logged_user_id = get_current_user_id();

		$bp_comment_args = [
			'in'               => [ $comment_id ],
			'display_comments' => 'stream',
			'show_hidden'      => true
		];

		$bp_comment = bp_activity_get( $bp_comment_args );

		$bp_activity_args = [
			'in'          => [ $activity_id ],
			'show_hidden' => true
		];

		$bp_activity = bp_activity_get( $bp_activity_args );

		if ( ( count( $bp_comment['activities'] ) === 0 ) || ( count( $bp_activity['activities'] ) === 0 ) ) {
			wp_die( 'Activity or comment not found' );
		}

		$comment  = $bp_comment['activities'][0];
		$activity = $bp_activity['activities'][0];

		// get comment author id
		$comment_author_id = $comment->user_id;

		$logged_user_is_comment_author = $logged_user_id === $comment_author_id;

		// get comment component
		$comment_belongs_to_group = $activity->component === 'groups';
		$comment_group_id         = $comment_belongs_to_group ? $activity->item_id : 0;

		// // logged user is activity group admin or mod
		$logged_user_is_activity_group_admin = $comment_belongs_to_group ? groups_is_user_admin( $logged_user_id, $comment_group_id ) : false;
		$logged_user_is_activity_group_mod   = $comment_belongs_to_group ? groups_is_user_mod( $logged_user_id, $comment_group_id ) : false;

		// user can delete another user activity if he is a site admin
		if ( ! $logged_user_is_comment_author && ! $logged_user_is_site_admin ) {
			// user can delete another user activity if the activity belongs to a group and he is a mod or admin of that group
			if ( $comment_belongs_to_group ) {
				if ( ! $logged_user_is_activity_group_admin && ! $logged_user_is_activity_group_mod ) {
					wp_die( 'Unauthorized' );
				}
			} else {
				wp_die( 'Unauthorized' );
			}
		}

		$result = Helper::activity_comment_delete( $activity_id, $comment_id );
		wp_send_json( $result );
	}

	static function activity_update(){
		check_ajax_referer( 'cirkle_ajax' );

		$args = isset($_POST['args']) ? $_POST['args'] : false;

		if (!$args) {
			wp_die('Missing Parameters');
		}

		$activity_id = isset($args['id']) ? (int) $args['id'] : false;

		if (!$activity_id) {
			wp_die('Missing Parameters');
		}

		$logged_user_is_site_admin = current_user_can('administrator');

		// get logged user id
		$logged_user_id = get_current_user_id();

		$bp_activity_args = [
			'in'                => [ $activity_id ],
			'display_comments'  => 'stream',
			'show_hidden'       => true
		];

		$bp_activity = bp_activity_get($bp_activity_args);

		if (count($bp_activity['activities']) === 0) {
			wp_die('Activity not found');
		}

		$activity = $bp_activity['activities'][0];

		// get activity author id
		$activity_author_id = $activity->user_id;

		$logged_user_is_activity_author = $logged_user_id === $activity_author_id;

		// if this activity is a comment, get the parent activity
		// which will indicate if the comment belongs to a group
		if ($activity->type === 'activity_comment') {
			$bp_activity_args = [
				'in'                => [ $activity->item_id ],
				'display_comments'  => 'stream',
				'show_hidden'       => true
			];

			$bp_activity = bp_activity_get($bp_activity_args);

			if (count($bp_activity['activities']) === 0) {
				wp_die('Activity not found');
			}

			$activity = $bp_activity['activities'][0];
		}

		// get activity component
		$activity_belongs_to_group = $activity->component === 'groups';
		$activity_group_id = $activity_belongs_to_group ? $activity->item_id : 0;

		// // logged user is activity group admin or mod
		$logged_user_is_activity_group_admin = $activity_belongs_to_group ? groups_is_user_admin($logged_user_id, $activity_group_id) : false;
		$logged_user_is_activity_group_mod = $activity_belongs_to_group ? groups_is_user_mod($logged_user_id, $activity_group_id) : false;

		// user can delete another user activity if he is a site admin
		if (!$logged_user_is_activity_author && !$logged_user_is_site_admin) {
			// user can delete another user activity if the activity belongs to a group and he is a mod or admin of that group
			if ($activity_belongs_to_group) {
				if (!$logged_user_is_activity_group_admin && !$logged_user_is_activity_group_mod) {
					wp_die('Unauthorized');
				}
			} else {
				wp_die('Unauthorized');
			}
		}

		$result = Helper::activity_update($args);
		wp_send_json( $result );
	}

	static function pin_activity_ajax() {
		// nonce check, dies early if the nonce cannot be verified
		check_ajax_referer( 'cirkle_ajax' );

		$result = Helper::pin_activity( $_POST['activityID'], $_POST['userID'] );

		wp_send_json( $result );
	}

	static function unpin_activity_ajax() {
		// nonce check, dies early if the nonce cannot be verified
		check_ajax_referer( 'cirkle_ajax' );

		$result = Helper::unpin_activity( $_POST['userID'] );
		wp_send_json( $result );
	}

	/**
	 * Create activity
	 */
	static function create_activity_ajax() {
		// nonce check, dies early if the nonce cannot be verified
		check_ajax_referer( 'cirkle_ajax' );

		// assemble ajax args
		$args = [
			'creation_config' => $_POST['creation_config'],
			'attached_media'  => isset( $_POST['attached_media'] ) ? $_POST['attached_media'] : false,
			'share_config'    => isset( $_POST['share_config'] ) ? $_POST['share_config'] : false
		];

		// convert hide_sitewide to boolean
		if ( array_key_exists( 'hide_sitewide', $args['creation_config'] ) ) {
			$args['creation_config']['hide_sitewide'] = $args['creation_config']['hide_sitewide'] === 'true';
		}

		// create activity, $activity_id is activity id on success, or false on error
		$activity_id = Helper::create_activity( $args['creation_config'] );

		// if activity created succesfully
		if ( $activity_id ) {
			// create task scheduler
			$create_activity_scheduler = new Cirkle_Scheduler();

			// activity is a share
			if ( $args['share_config'] ) {
				// sharing an activity
				if ( $args['share_config']['type'] === 'activity' ) {
					// create activity share count meta task
					$create_activity_share_count_meta_task = Helper::activity_create_meta_share_count_task( $args['share_config'] );
					// add task to scheduler
					$create_activity_scheduler->addTask( $create_activity_share_count_meta_task );
					// sharing a post
				} else if ( $args['share_config']['type'] === 'post' ) {
					// create post share count meta task
					$create_post_share_count_meta_task = Helper::post_create_meta_share_count_task( $args['share_config'] );
					// add task to scheduler
					$create_activity_scheduler->addTask( $create_post_share_count_meta_task );
				}
			}

			// run scheduler
			$result = $create_activity_scheduler->run();

			// if a task failed, remove created activity
			if ( ! $result ) {
				Helper::delete_activity( $activity_id );
				$activity_id = $result;
			}
		}

		wp_send_json( $activity_id );
	}

	static function delete_activity_ajax() {
		// nonce check, dies early if the nonce cannot be verified
		check_ajax_referer( 'cirkle_ajax' );

		$result = Helper::delete_activity( $_POST['activity_id'] );
		wp_send_json( $result );
	}

	static function pinned_activity_ajax() {
		// nonce check, dies early if the nonce cannot be verified
		check_ajax_referer( 'cirkle_ajax' );

		$result = Helper::get_pinned_activity( $_POST['userID'] );
		wp_send_json( $result );
	}

	static function get_unpin_activity_ajax() {
		// nonce check, dies early if the nonce cannot be verified
		check_ajax_referer( 'cirkle_ajax' );

		$result = Helper::unpin_activity( $_POST['userID'] );

		wp_send_json( $result );
	}

	public static function get_activities() {
		// nonce check, dies early if the nonce cannot be verified
		check_ajax_referer( 'cirkle_ajax' );

		$filters = isset( $_POST['filters'] ) ? $_POST['filters'] : [];

		if ( array_key_exists( 'show_hidden', $filters ) ) {
			$filters['show_hidden'] = $filters['show_hidden'] === 'true';
		}
		$activities = Helper::get_activities( $filters );
		wp_send_json( $activities );
	}
}

CirkleAjaxActivity::init();