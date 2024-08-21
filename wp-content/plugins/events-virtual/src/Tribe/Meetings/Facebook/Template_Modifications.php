<?php
/**
 * Handles the templates modifications required by the Facebook Live API integration.
 *
 * @since 1.7.0
 *
 * @package Tribe\Events\Virtual\Meetings\Facebook
 */

namespace Tribe\Events\Virtual\Meetings\Facebook;

use Tribe\Events\Virtual\Template;
use Tribe\Events\Virtual\Admin_Template;
use Tribe\Events\Virtual\Template_Modifications as Base_Modifications;

/**
 * Class Template_Modifications
 *
 * @since 1.7.0
 *
 * @package Tribe\Events\Virtual\Meetings\Facebook
 */
class Template_Modifications {

	/**
	 * An instance of the front-end template handler.
	 *
	 * @since 1.7.0
	 *
	 * @var Template
	 */
	protected $template;

	/**
	 * An instance of the admin template handler.
	 *
	 * @since 1.7.0
	 *
	 * @var Template
	 */
	protected $admin_template;

	/**
	 * Template_Modifications constructor.
	 *
	 * @since 1.7.0
	 *
	 * @param Template           $template           An instance of the front-end template handler.
	 * @param Admin_Template     $admin_template     An instance of the backend template handler.
	 * @param Settings           $settings           An instance of the Settings handler.
	 * @param Page_API           $api                An instance of the Page_API handler.
	 * @param URL                $url                An instance of the URL handler.
	 * @param Base_Modifications $base_modifications An instance of base Virtual Event template modifications instance.
	 */
	public function __construct(
		Template $template,
		Admin_Template $admin_template,
		Settings $settings,
		Page_API $api,
		Url $url,
		Base_Modifications $base_modifications
	) {
		$this->template           = $template;
		$this->admin_template     = $admin_template;
		$this->settings           = $settings;
		$this->api                = $api;
		$this->url                = $url;
		$this->base_modifications = $base_modifications;
	}

	/**
	 * Get intro text for Facebook API UI
	 *
	 * @since 1.7.0
	 *
	 * @return string HTML for the intro text.
	 */
	public function get_intro_text() {
		$message = get_transient( $this->settings->get_prefix( 'account_message' ) );
		if ( $message ) {
			delete_transient( $this->settings->get_prefix( 'account_message' ) );
		}

		return $this->admin_template->template( 'facebook/intro-text', [ 'message' => $message, ], false );
	}

	/**
	 * Get information message to help get the Facebook app id and secret.
	 *
	 * @since 1.7.0
	 *
	 * @return string HTML for the find Facebook app id and secret text.
	 */
	public function get_find_app_id() {
		return $this->admin_template->template( 'facebook/find-app-id', [], false );
	}

	/**
	 * Adds button to save the Facebook app id and secret.
	 *
	 * @since 1.7.0
	 *
	 * @return string HTML button to save the Facebook app id and secret.
	 */
	public function get_save_button() {
		return $this->admin_template->template( 'facebook/save', [ 'url' => $this->url ], false );
	}

	/**
	 * Adds Facebook Live Page authorize fields.
	 *
	 * @since 1.7.0
	 *
	 * @return string HTML for the authorize fields.
	 */
	public function get_page_authorize_fields() {
		return $this->admin_template->template( 'facebook/authorize-fields', [ 'api' => $this->api, 'url' => $this->url ], false );
	}

	/**
	 * Get the Facebook Page's admin fields.
	 *
	 * @since 1.7.0
	 *
	 * @param int                 $local_id The unique id used to save the page data.
	 * @param array<string|mixed> $page     The page data.
	 *
	 * @return string The Facebook Page's admin fields html.
	 */
	public function get_page_fields( $local_id, $page ) {
		return $this->admin_template->template( 'facebook/page/fields', [
			'local_id' => $local_id,
			'page'     => $page,
			'url'      => $this->url
		] );
	}

	/**
	 * The message template to display on setting changes.
	 *
	 * @since 1.7.0
	 *
	 * @param string $message The message to display.
	 * @param string $type    The type of message, either updated or error.
	 *
	 * @return string The message with html to display.
	 */
	public function get_settings_message_template( $message, $type = 'updated' ) {
		return $this->admin_template->template( 'components/message', [
			'message' => $message,
			'type'    => $type,
		] );
	}

	/**
	 * Adds Facebook video embed to a single event.
	 *
	 * @since 1.7.0
	 *
	 * @return string The embed html or empty string when it should not display.
	 */
	public function add_facebook_video_embed() {
		// Don't show on password protected posts.
		if ( post_password_required() ) {
			return;
		}

		$event = tribe_get_event( get_the_ID() );
		if ( ! $event instanceof \WP_Post ) {
			return;
		}

		// Only embed when the source is video.
		if (
			! isset( $event->virtual_video_source ) ||
			'facebook' !== $event->virtual_video_source
		) {
			return;
		}

		// Hide on a past event.
		if ( tribe_is_past_event( $event ) ) {
			return;
		}

		// Don't show if requires log in and user isn't logged in.
		if ( ! $this->base_modifications->should_show_virtual_content( $event ) ) {
			return;
		}

		if (
			! $event->virtual_embed_video ||
			! $event->virtual_should_show_embed
		) {
			return;
		}

		if ( ! $event->virtual_meeting_is_live ) {
			$context = [
				'event'         => $event,
				'offline'           => esc_html_x(
					'The Live Stream is Offline.',
					'Facebook offline message',
					'events-virtual'
				),
			];
			$this->template->template( 'facebook/single/facebook-embed-offline', $context );

			return;
		}

		if ( ! $event->virtual_meeting_embed ) {
			return;
		}

		$context = [
			'event'         => $event,
			'embed_classes' => [],
			'embed'         => $event->virtual_meeting_embed,
		];

		$this->template->template( 'facebook/single/facebook-embed', $context );
	}
}
