<?php

/**
 * Plugin Name: RadiusTheme Reactions
 * Plugin URI:
 * Description:
 * Version: 1.0.4
 * Author: RadiusTheme
 * Author URI:
 * License:
 * License URI:
 * Text Domain: rtreact
 * Domain Path: /languages
 */

defined('ABSPATH') or die('Keep Silent');

// Define RTCL_PLUGIN_FILE.
if (!defined('RTREACT_PLUGIN_FILE')) {
    define('RTREACT_PLUGIN_FILE', __FILE__);
}

if (!defined('RTREACT_VERSION')) {
    define('RTREACT_VERSION', '1.0.4');
}
/**
 * Plugin base path
 */
define('RTREACT_PLUGIN_PATH', plugin_dir_path(__FILE__));
define('RTREACT_PLUGIN_URL', plugin_dir_url(__FILE__));

require_once('includes/__init__.php');