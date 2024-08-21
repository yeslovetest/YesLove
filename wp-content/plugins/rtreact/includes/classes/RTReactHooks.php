<?php

class RTReactHooks
{
    public function __construct() {
        add_action('plugins_loaded', [&$this, 'load_translation']);
        register_activation_hook(RTREACT_PLUGIN_FILE, [RTReactInstall::class, 'activate']);
        register_deactivation_hook(RTREACT_PLUGIN_FILE, [RTReactInstall::class, 'deactivate']);
        register_uninstall_hook(RTREACT_PLUGIN_FILE, [RTReactInstall::class, 'uninstall']);

        add_action('deleted_user', [__CLASS__, 'delete_user_reactions']);

        add_action('wp_ajax_rtreact_get_reactions', [__CLASS__, 'get_reactions']);
        add_action('wp_ajax_nopriv_rtreact_get_reactions', [__CLASS__, 'get_reactions']);

        add_action('wp_ajax_rtreact_create_post_reaction', [__CLASS__, 'create_post_reaction']);
        add_action('wp_ajax_nopriv_rtreact_create_post_reaction', [__CLASS__, 'create_post_reaction']);
        add_action('wp_ajax_rtreact_delete_post_reaction', [__CLASS__, 'delete_post_reaction']);
        add_action('wp_ajax_nopriv_rtreact_delete_post_reaction', [__CLASS__, 'delete_post_reaction']);

        add_action('wp_ajax_rtreact_create_comment_reaction', [__CLASS__, 'create_comment_reaction']);
        add_action('wp_ajax_nopriv_rtreact_create_comment_reaction', [__CLASS__, 'create_comment_reaction']);
        add_action('wp_ajax_rtreact_delete_comment_reaction', [__CLASS__, 'delete_comment_reaction']);
        add_action('wp_ajax_nopriv_rtreact_delete_comment_reaction', [__CLASS__, 'delete_comment_reaction']);
        add_action('wp_head', [__CLASS__, 'add_react_list_js_params']);
        add_action('wp_footer', [__CLASS__, 'add_react_list_template']);
    }

    public static function add_react_list_js_params() {
        $reactions = rtreact_get_reactions(); ?>
        <script>
            var rtreact_list = <?php echo wp_json_encode($reactions); ?>
        </script>
        <?php
    }

    public static function add_react_list_template() {
        ?>
        <script type="text/html" id="tmpl-rtreact-list">
            <# if(data.reactions && data.reactions.length){ #>
            <ul class="react-list">
                <# data.reactions.map(function(reaction){ #>
                <li data-id="{{reaction.id}}"><a href="#"><img src="{{reaction.image_url}}" alt="{{reaction.name}}"></a>
                </li>
                <# }) #>
            </ul>
            <# } #>
        </script>
        <?php
    }

    public static function delete_user_reactions($user_id) {
        rtreact_delete_post_reactions($user_id);
        rtreact_delete_comment_reactions($user_id);
    }

    /**
     * Delete a user reaction for a post.
     */
    public static function delete_comment_reaction() {
        $args = !empty($_POST['args']) ? $_POST['args'] : [];
        $result = rtreact_delete_comment_reaction($args);

        if (!$result) {
            wp_send_json_error();
        }
        wp_send_json_success($result);
    }

    public static function create_comment_reaction() {
        $args = !empty($_POST['args']) ? $_POST['args'] : [];
        $result = rtreact_create_comment_reaction($args);
        if (!$result) {
            wp_send_json_error();
        }
        wp_send_json_success($result);
    }

    /**
     * Delete a user reaction for a post.
     */
    public static function delete_post_reaction() {
        $args = !empty($_POST['args']) ? $_POST['args'] : [];
        $result = rtreact_delete_post_reaction($args);

        if (!$result) {
            wp_send_json_error();
        }
        wp_send_json_success($result);
    }

    public static function create_post_reaction() {
        $post_id = !empty($_POST['post_id']) ? absint($_POST['post_id']) : 0;
        $reaction_id = !empty($_POST['reaction_id']) ? absint($_POST['reaction_id']) : 0;
        if (!$post_id || !$reaction_id) {
            wp_send_json_error([
                'message' => 'Post ID and react ID is required',
            ]);
        }
        $result = rtreact_create_post_reaction([
            'post_id'     => $post_id,
            'user_id'     => get_current_user_id(),
            'reaction_id' => $reaction_id,
        ]);
        if (!$result) {
            wp_send_json_error($result);
        }
        ob_start();
        rtreact_post_reactions_html($post_id);
        $html = ob_get_clean();
        wp_send_json_success(['reactions_html' => $html]);
    }

    public function load_translation() {
        load_plugin_textdomain('rtreact', false, basename(dirname(RTREACT_PLUGIN_FILE)) . '/languages');
    }

    public static function get_reactions() {
        $result = rtreact_get_reactions();
        wp_send_json($result);
    }
}

new RTReactHooks();
