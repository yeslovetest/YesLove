<?php
/**
 * Compatibility functions.
 *
 * @package ContentControl
 */

namespace ContentControl;

use function ContentControl\get_query;

defined( 'ABSPATH' ) || exit;

/**
 * Checks whether function is disabled.
 *
 * @param string $func Name of the function.
 *
 * @return bool Whether or not function is disabled.
 */
function is_func_disabled( $func ) {
	$disabled_functions = ini_get( 'disable_functions' );

	$disabled = $disabled_functions ? explode( ',', $disabled_functions ) : [];

	return in_array( $func, $disabled, true );
}

/**
 * Checks if the current request is a WP REST API request.
 *
 * Case #1: After WP_REST_Request initialisation
 * Case #2: Support "plain" permalink settings and check if `rest_route` starts with `/`
 * Case #3: It can happen that WP_Rewrite is not yet initialized,
 *          so do this (wp-settings.php)
 * Case #4: URL Path begins with wp-json/ (your REST prefix)
 *          Also supports WP installations in subfolders
 *
 * @returns boolean
 * @author matzeeable
 *
 * @return bool
 */
function is_rest() {
	// phpcs:disable WordPress.Security.NonceVerification.Recommended
	if ( defined( 'REST_REQUEST' ) && REST_REQUEST // (#1)
			|| isset( $_GET['rest_route'] ) // (#2)
					&& strpos( sanitize_text_field( wp_unslash( $_GET['rest_route'] ) ), '/', 0 ) === 0 ) {
			return true;
	}

	// (#4)
	$rest_url    = wp_parse_url( trailingslashit( rest_url() ) );
	$current_url = wp_parse_url( add_query_arg( [] ) );

	if ( ! $rest_url || ! $current_url ) {
		return false;
	}

	$current_path = isset( $current_url['path'] ) ? $current_url['path'] : false;
	$rest_path    = isset( $rest_url['path'] ) ? $rest_url['path'] : false;

	// If one of the URLs failed to parse, then the current request isn't a REST request.
	if ( ! $current_path || ! $rest_path ) {
		return false;
	}

	return strpos( $current_path, $rest_path, 0 ) === 0;
	// phpcs:enable WordPress.Security.NonceVerification.Recommended
}

/**
 * Check if this is a cron request.
 *
 * @return boolean
 */
function is_cron() {
	return defined( 'DOING_CRON' ) && DOING_CRON;
}

/**
 * Check if this is an AJAX request.
 *
 * @return boolean
 */
function is_ajax() {
	return defined( 'DOING_AJAX' ) && DOING_AJAX;
}

/**
 * Check if this is a frontend request.
 *
 * @return boolean
 */
function is_frontend() {
	global $wp_rewrite;

	$query = get_query();

	$request_uri = isset( $_SERVER['REQUEST_URI'] ) ? sanitize_text_field( wp_unslash( $_SERVER['REQUEST_URI'] ) ) : '';

	if (
		// Check if is CLI.
		( defined( 'WP_CLI' ) && WP_CLI ) ||
		// Check if is REST.
		is_admin() ||
		is_ajax() ||
		is_cron() ||
		( $query && $query->is_admin ) ||
		( $query && $query->is_favicon() ) ||
		( $query && $query->is_robots() ) ||
		strpos( $request_uri, 'favicon.ico' ) !== false ||
		strpos( $request_uri, 'robots.txt' ) !== false ||
		( $wp_rewrite && is_rest() )
	) {
		return false;
	}

	return true;
}

/**
 * Change camelCase to snake_case.
 *
 * @param string $str String to convert.
 *
 * @return string Converted string.
 */
function camel_case_to_snake_case( $str ) {
	return strtolower( preg_replace( '/(?<!^)[A-Z]/', '_$0', $str ) );
}


/**
 * Function that deeply cleans arrays for wp_maybe_serialize
 *
 * Gets rid of Closure and other invalid data types.
 *
 * @param array<mixed> $arr Array to clean.
 *
 * @return array<mixed> Cleaned array.
 */
function deep_clean_array( $arr ) {
	// Clean \Closure values deeply.
	array_walk_recursive(
		$arr,
		function ( &$value ) {
			if ( $value instanceof \Closure ) {
				$value = null;
			}
		}
	);

	return $arr;
}
