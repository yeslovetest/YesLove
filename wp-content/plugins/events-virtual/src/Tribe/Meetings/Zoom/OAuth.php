<?php
/**
 * Handles OAuth-based authentication requests for the Zoom API.
 *
 * @since   1.0.0
 *
 * @package Tribe\Events\Virtual\Meetings\Zoom
 */

namespace Tribe\Events\Virtual\Meetings\Zoom;

/**
 * Class OAuth
 *
 * @since   1.0.0
 *
 * @package Tribe\Events\Virtual\Meetings\Zoom
 */
class OAuth {
	/**
	 * The name of the action used to generate the OAuth authentication URL.
	 *
	 * @since 1.0.0
	 *
	 * @var string
	 */
	public static $authorize_nonce_action = 'events-virtual-meetings-zoom-oauth-authorize';

	/**
	 * The name of the action used to generate the OAuth deauthorization URL.
	 *
	 * @since 1.0.0
	 *
	 * @var string
	 */
	public static $deauthorize_nonce_action = 'events-virtual-meetings-zoom-oauth-deauthorize';

	/**
	 * The name of the action used to autosave the client keys.
	 *
	 * @since 1.0.1
	 *
	 * @var string
	 */
	public static $client_keys_autosave_nonce_action = 'events-virtual-meetings-zoom-autosave-client-nonce';

	/**
	 * The base URL to request an access token to Zoom API.
	 *
	 * @since 1.0.0
	 * @since 1.4.0 - update to use new Zoom App endpoint.
	 *
	 * @var string
	 *
	 * @link  https://marketplace.zoom.us/docs/guides/auth/oauth
	 */
	public static $token_request_url = 'https://whodat.theeventscalendar.com/oauth/zoom/v2/token';

	/**
	 * The base URL to request an access token to Zoom API.
	 *
	 * @since 1.0.0
	 *
	 * @var string
	 *
	 * @link  https://marketplace.zoom.us/docs/guides/auth/oauth
	 */
	public static $legacy_token_request_url = 'https://zoom.us/oauth/token';

	/**
	 * an instance of the Zoom API handler.
	 *
	 * @var Api
	 */
	protected $api;

	/**
	 * OAuth constructor.
	 *
	 * @param Api $api An instance of the Zoom API handler.
	 */
	public function __construct( Api $api ) {
		$this->api = $api;
	}

	/**
	 * Handles an OAuth authorization return request.
	 *
	 * The method will `wp_die` if the nonce is not valid.
	 *
	 * @since 1.0.0
	 *
	 * @param string|null $nonce The nonce string to authorize the authorization request.
	 *
	 * @return bool|string Whether the authorization request is valid and was handled or not. Or an error message through wp_die().
	 */
	public function handle_auth_request( $nonce = null ) {
		if ( ! wp_verify_nonce( $nonce, self::$authorize_nonce_action ) ) {
			wp_die( _x(
					'You are not authorized to do this',
					'The message shown to a user providing a wrong Zoom API OAuth authorization nonce.',
					'events-virtual'
				)
			);
		}

		// This is the legacy response from Zoom directly.
		$legacy_code = tribe_get_request_var( 'code', false );
		// This is response from our OAuth proxy service.
		$service_response_body = tribe_get_request_var( 'response_body', false );
		// By default, mark the request as not handled.
		$handled = false;

		if ( $legacy_code ) {
			tribe_update_option( Settings::$option_prefix . 'auth_code', $legacy_code );

			// This will, implicitly, set the refresh token too.
			$this->fetch_access_token( $legacy_code );
			$handled = true;
		} elseif ( $service_response_body ) {
			$this->api->save_account( [ 'body' => base64_decode( $service_response_body ) ] );

			// Check if there were legacy settings, if so, clear the old config.
			$legacy_auth_code = tribe_get_option( Settings::$option_prefix . 'auth_code' );
			if ( $legacy_auth_code ) {
				$this->clear_legacy_config();
			}
			$handled = true;
		}

		wp_safe_redirect( Settings::admin_url() );

		return $handled;
	}

	/**
	 * Returns the full OAuth URL to authorize the application.
	 *
	 * @since 1.0.0
	 *
	 * @return string The full OAuth URL to authorize the application.
	 */
	public function authorize_url() {
		// Use the `state` query arg as described in Zoom API documentation.
		$authorize_url = add_query_arg(
			[
				'state' => wp_create_nonce( self::$authorize_nonce_action ),
			],
			admin_url()
		);

		return $authorize_url;
	}

	/**
	 * Handles the API disconnection (token de-authorization) request.
	 *
	 * @since 1.0.0
	 *
	 * @param null|string $nonce The nonce to validate the request.
	 *
	 * @return bool Whether the request was successfully handled or not.
	 */
	public function handle_deauth_request( $nonce = null ) {
		if ( ! wp_verify_nonce( $nonce, self::$deauthorize_nonce_action ) ) {
			return false;
		}

		$access_token = get_transient( Settings::$option_prefix . 'access_token' );

		$revoke_url = Url::$revoke_url;
		if ( defined( 'TEC_VIRTUAL_EVENTS_ZOOM_API_REVOKE_URL' ) ) {
			$revoke_url = TEC_VIRTUAL_EVENTS_ZOOM_API_REVOKE_URL;
		}

		// Check if this is a legacy authorization, if so, deauthorize to the legacy revoke URL.
		$legacy_auth_code = tribe_get_option( Settings::$option_prefix . 'auth_code' );
		if ( $legacy_auth_code ) {
			$revoke_url = Url::$legacy_revoke_url;
		}

		if ( $access_token ) {
			$this->api->post(
				$revoke_url,
				[
					'headers' => [
						'Authorization' => $this->api->authorization_header(),
					],
					'body'    => [
						'token' => $access_token,
					],
				],
				Api::OAUTH_POST_RESPONSE_CODE
			);
		}

		// Clear out all these legacy options.
		if ( $legacy_auth_code ) {
			$this->clear_legacy_config();
		}

		tribe_update_option( Settings::$option_prefix . 'refresh_token', '' );
		delete_transient( Settings::$option_prefix . 'access_token' );

		tribe_notice(
			'events-virtual-zoom-api-disconnected',
			'<p>' . __( 'Disconnected from Zoom API.', 'events-virtual' ) . '</p>',
			[ 'type' => 'success' ]
		);

		return true;
	}

	/**
	 * Clears out the legacy settings.
	 *
	 * The "legacy" settings are the ones where the OAuth flow would be handled by the plugin, not by our external
	 * service.
	 *
	 * @since 1.1.1
	 */
	public function clear_legacy_config() {
		tribe_update_option( Settings::$option_prefix . 'auth_code', '' );
		tribe_update_option( Settings::$option_prefix . 'client_id', '' );
		tribe_update_option( Settings::$option_prefix . 'client_secret', '' );
	}

	/**
	 * Handler for the ajax button-swap on the Events->Settings->Api tab.
	 *
	 * @since 1.0.1
	 * @deprecated
	 *
	 * @return boolean Whether the credentials were correctly saved or not.
	 */
	public static function ajax_credentials_save() {
		if ( ! check_ajax_referer( self::$client_keys_autosave_nonce_action, 'security', false ) ) {
			echo tribe( Settings::class )->get_disabled_button();

			wp_die();
			return false;
		}

		$client_id     = tribe_get_request_var( 'clientId' );
		$client_secret = tribe_get_request_var( 'clientSecret' );

		if ( empty( $client_id ) || empty( $client_secret ) ) {
			echo tribe( Settings::class )->get_disabled_button();

			wp_die();
			return false;
		}


		// Save the options!
		tribe_update_option( Settings::$option_prefix . 'client_id', $client_id );
		tribe_update_option( Settings::$option_prefix . 'client_secret', $client_secret );

		echo tribe( Settings::class )->get_connect_link();

		wp_die();
		return true;
	}

	/**
	 * Fetches the access token from Zoom API.
	 *
	 * This method should be used when first connecting to the Zoom API or when a refresh token is not available.
	 *
	 * @since 1.0.0
	 * @deprecated 1.5.0 - Replaced with Multiple Account Support, see Account_API class.
	 *
	 * @param string $code The token access code as returned from Zoom API callback.
	 */
	public function fetch_access_token( $code ) {
		_deprecated_function( __FUNCTION__, '1.5.0', '' );
		$this->api->post(
			static::$legacy_token_request_url,
			[
				'headers' => [
					'Authorization' => $this->api->authorization_header(),
				],
				'body'    => [
					'grant_type'   => 'authorization_code',
					'code'         => $code,
					'redirect_uri' => $this->authorize_url(),
				],
			],
			Api::OAUTH_POST_RESPONSE_CODE
		)->then( [ $this->api, 'save_access_token' ] );
	}
}
