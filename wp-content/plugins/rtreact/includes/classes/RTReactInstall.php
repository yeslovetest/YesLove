<?php
// Security check
defined('ABSPATH') || die();


class RTReactInstall
{
    public static function activate() {
        if (!is_blog_installed()) {
            return;
        }


        // Check if we are not already running this routine.
        if ('yes' === get_transient('rtreact_installing')) {
            return;
        }
        // If we made it till here nothing is running yet, lets set the transient now.
        set_transient('rtreact_installing', 'yes', MINUTE_IN_SECONDS * 10);

        self::create_tables();

        update_option('rtreact_version', RTREACT_VERSION);
        delete_transient('rtreact_installing');
        do_action('rtreact_installed');
    }

    public static function deactivate() {

    }

    public static function uninstall() {
        delete_option('rtreact_version');

        // drop tables
        $reaction = new RTReactReaction();
        $reaction_post = new RTReactPost();
        $reaction_comment = new RTReactComment();
        $reaction_bbpress = new RTReactActivityUserReaction();
        $reaction->dropTable();
        $reaction_post->dropTable();
        $reaction_comment->dropTable();
        $reaction_bbpress->dropTable();
    }

    private static function create_tables() {
        require_once ABSPATH . 'wp-admin/includes/upgrade.php';

        $reaction = new RTReactReaction();
        $reaction_post = new RTReactPost();
        $reaction_comment = new RTReactComment();
        $reaction_bbpress = new RTReactActivityUserReaction();
        $reaction->createTable();
        $reaction_post->createTable();
        $reaction_comment->createTable();
        $reaction_bbpress->createTable();
    }


}