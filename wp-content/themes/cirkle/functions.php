<?php
/**
 * @author  RadiusTheme
 *
 * @since   1.0
 *
 * @version 1.0
 */
add_editor_style('style-editor.css');

if (!isset($content_width)) {
	$content_width = 1200;
}

class Cirkle_Main {
	public $theme   = 'cirkle';
	public $action  = 'cirkle_theme_init';

	public function __construct() {
		add_action('after_setup_theme', [$this, 'load_textdomain']);
		add_action('admin_notices', [$this, 'plugin_update_notices']);
		$this->includes();
	}

	public function load_textdomain() {
		load_theme_textdomain($this->theme, get_template_directory().'/languages');
	}

	public function includes() {
		do_action($this->action);
		require_once get_template_directory().'/inc/constants.php';
		require_once get_template_directory().'/inc/includes.php';
	}

	public function plugin_update_notices() {
		$plugins = [];

		if (defined('CIRKLE_CORE')) {
			if (version_compare(CIRKLE_CORE, '1.0.8', '<')) {
				$plugins[] = 'Cirkle Core';
			}
		}

		foreach ($plugins as $plugin) {
			$notice = '<div class="error"><p>'.sprintf(__("Please update plugin <b><i>%s</b></i> to the latest version otherwise some functionalities will not work properly. You can update it from <a href='%s'>here</a>", 'cirkle'), $plugin, menu_page_url('cirkle-install-plugins', false)).'</p></div>';
			echo wp_kses($notice, 'alltext_allow');
		}
	}
}
new Cirkle_Main();


add_filter('bp_core_fetch_avatar_no_grav', '__return_true', 999);
add_filter('bp_core_default_avatar_user', 'cirkle_set_bp_core_default_avatar_user', 999);

function cirkle_set_bp_core_default_avatar_user($avatar) {
	return CIRKLE_BANNER_DUMMY_IMG.'avatar/bp-avatar.png';
}

add_filter('bp_activity_type_requires_content', function ($current, $type){
	if($type === 'activity_update' && !empty($_POST['mpp-attached-media']) && empty($_POST['content'])){
		return false;
	}
	return $current;

}, 10 , 2);
