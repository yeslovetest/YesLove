<?php

namespace radiustheme\cirkle\ajax;

use radiustheme\cirkle\Helper;

class CirkleAjaxMember
{
    static public function init() {
        add_action('wp_ajax_cirkle_get_logged_user_member_data_ajax', [__CLASS__, 'get_logged_user_member_data']);
        add_action('wp_ajax_nopriv_cirkle_get_logged_user_member_data_ajax', [__CLASS__, 'get_logged_user_member_data']);
    }

    public static function get_logged_user_member_data() {
        // nonce check, dies early if the nonce cannot be verified
        check_ajax_referer('cirkle_ajax');

        $data_scope = isset($_POST['data_scope']) ? $_POST['data_scope'] : 'user-status';

        if (Helper::cirkle_plugin_is_active('buddypress')) {
            $user = Helper::get_logged_user_member_data($data_scope);
        } else {
            $user = Helper::get_logged_user_data();
        }

        wp_send_json($user);
    }
}

CirkleAjaxMember::init();