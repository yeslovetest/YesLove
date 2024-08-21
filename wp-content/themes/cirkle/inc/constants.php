<?php
/**
 * @author  RadiusTheme
 * @since   1.0
 * @version 1.0
 */

namespace radiustheme\cirkle;

$theme_data = wp_get_theme(get_template());
define('CIRKLE_THEME_VERSION', (WP_DEBUG) ? time() : $theme_data->get('Version'));
define('CIRKLE_THEME_AUTHOR_URI', $theme_data->get('AuthorURI'));
define('CIRKLE_THEME_PREFIX', 'cirkle');
define('CIRKLE_THEME_PREFIX_VAR', 'cirkle');
define('CIRKLE_WIDGET_PREFIX', 'cirkle');
define('CIRKLE_THEME_CPT_PREFIX', 'cirkle');

// DIR
define('CIRKLE_THEME_BASE_DIR', get_template_directory() . '/');
define('CIRKLE_THEME_BASE_URI', get_template_directory_uri() . '/');
define('CIRKLE_THEME_INC_DIR', CIRKLE_THEME_BASE_DIR . 'inc/');
define('CIRKLE_THEME_VIEW_DIR', CIRKLE_THEME_INC_DIR . 'views/');
define('CIRKLE_THEME_PLUGINS_DIR', CIRKLE_THEME_BASE_DIR . 'inc/plugin-bundle/');
define('CIRKLE_ASSETS_URI', CIRKLE_THEME_BASE_URI . 'assets/');
define('CIRKLE_BANNER_DUMMY_IMG', CIRKLE_ASSETS_URI . 'img/');

define('CIRKLE_UPLOADS_PATH', wp_get_upload_dir()['basedir'] . '/cirkle');
define('CIRKLE_UPLOADS_URL', wp_get_upload_dir()['baseurl'] . '/cirkle');