<?php

namespace radiustheme\cirkle;
trait CirkleFriendsTrait
{

    static function get_friends($args, $data_scope = 'user-status') {
        $friend_args = [
            'per_page' => 0,
            'page'     => 0,
            'filter'   => ''
        ];

        $friend_args = array_replace($friend_args, $args);

        $friends = friends_get_alphabetically($friend_args['user_id'], $friend_args['per_page'], $friend_args['page'], $friend_args['filter']);

        $f = [];

        foreach ($friends['users'] as $friend) {
            $user = Helper::members_get(['include' => [$friend->id], 'data_scope' => $data_scope])[0];
            $user['friendship_id'] = friends_get_friendship_id($friend_args['user_id'], $friend->id);
            $user['friendship_data'] = $friend;
            $f[] = $user;
        }

        return $f;
    }

    static function get_friend_requests_received($member_id) {
        global $wpdb;

        $prefix = $wpdb->base_prefix;
        $table_name = "bp_friends";
        $table = $prefix . $table_name;

        $sql = "SELECT id, initiator_user_id FROM $table
          WHERE friend_user_id=%d AND is_confirmed=0";

        $results = $wpdb->get_results($wpdb->prepare($sql, [$member_id]));

        $friend_requests_received = [];

        if (!is_null($results)) {
            foreach ($results as $result) {
                $friend_requests_received[] = [
                    'id'   => absint($result->id),
                    'user' => Helper::members_get(['include' => [absint($result->initiator_user_id)]])[0]
                ];
            }
        }

        return $friend_requests_received;
    }

    static function get_friend_requests_sent($member_id) {
        global $wpdb;

        $prefix = $wpdb->base_prefix;
        $table_name = "bp_friends";
        $table = $prefix . $table_name;

        $sql = "SELECT id, friend_user_id FROM $table
          WHERE initiator_user_id=%d AND is_confirmed=0";

        $results = $wpdb->get_results($wpdb->prepare($sql, [$member_id]));

        $friend_requests_sent = [];

        if (!is_null($results)) {
            foreach ($results as $result) {
                $friend_requests_sent[] = [
                    'id'   => absint($result->id),
                    'user' => Helper::members_get(['include' => [absint($result->friend_user_id)]])[0]
                ];
            }
        }

        return $friend_requests_sent;
    }

}