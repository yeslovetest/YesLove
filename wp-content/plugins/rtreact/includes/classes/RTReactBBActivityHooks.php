<?php


class RTReactBBActivityHooks
{
    static function init() {
        add_action('wp_ajax_rtreact_bp_delete_activity_user_reaction_ajax', [__CLASS__, 'bp_delete_activity_user_reaction_ajax']);
        add_action('wp_ajax_nopriv_rtreact_bp_delete_activity_user_reaction_ajax', [__CLASS__, 'bp_delete_activity_user_reaction_ajax']);
        add_action('wp_ajax_rtreact_bp_create_activity_user_reaction_ajax', [__CLASS__, 'bp_create_activity_user_reaction_ajax']);
        add_action('wp_ajax_nopriv_rtreact_bp_create_activity_user_reaction_ajax', [__CLASS__, 'bp_create_activity_user_reaction_ajax']);
    }

    static function bp_create_activity_user_reaction_ajax() {
        $Activity_User_Reaction = new RTReactActivityUserReaction();

        $result = $Activity_User_Reaction->create($_POST['args']);
        wp_send_json($result);
    }

    /**
     * Delete a user reaction for an activity
     */
    static function bp_delete_activity_user_reaction_ajax() {
        $Activity_User_Reaction = new RTReactActivityUserReaction();
        $result = $Activity_User_Reaction->delete($_POST['args']);
        wp_send_json($result);
    }


}

RTReactBBActivityHooks::init();
