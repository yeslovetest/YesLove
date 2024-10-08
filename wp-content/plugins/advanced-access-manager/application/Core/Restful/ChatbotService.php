<?php

/**
 * ======================================================================
 * LICENSE: This file is subject to the terms and conditions defined in *
 * file 'license.txt', which is part of this source code package.       *
 * ======================================================================
 */

/**
 * RESTful API for the AAM Chatbot service
 *
 * @package AAM
 * @version 6.9.27
 */
class AAM_Core_Restful_ChatbotService
{

    use AAM_Core_Restful_ServiceTrait;

    /**
     * Constructor
     *
     * @return void
     *
     * @access protected
     * @version 6.9.27
     */
    protected function __construct()
    {
        // Register API endpoint
        add_action('rest_api_init', function() {
            // Create a redirect rule
            $this->_register_route('/chatbot', array(
                'methods'             => WP_REST_Server::CREATABLE,
                'callback'            => array($this, 'post_messages'),
                'permission_callback' => array($this, 'check_permissions'),
                'args'                => array(
                    'id' => array(
                        'description' => __('Conversation ID', AAM_KEY),
                        'type'        => 'string',
                        'pattern'     => '^[0-9a-f]{8}-[0-9a-f]{4}-4[0-9a-f]{3}-[89ab][0-9a-f]{3}-[0-9a-f]{12}$',
                        'required'    => true
                    ),
                    'message' => array(
                        'description' => __('Last message user submitted', AAM_KEY),
                        'type'        => 'string',
                        'required'    => true
                    )
                )
            ));
        });
    }

    /**
     * Either start new or continue existing conversation
     *
     * @param WP_REST_Request $request
     *
     * @return WP_REST_Response
     *
     * @access public
     * @version 6.9.27
     */
    public function post_messages(WP_REST_Request $request)
    {
        $id      = $request->get_param('id');
        $message = trim($request->get_param('message'));

        if (defined('AAM_COMPLETE_PACKAGE_LICENSE')) {
            $license = AAM_COMPLETE_PACKAGE_LICENSE;
        }

        // Prepare and execute the remote request
        $raw = wp_remote_post(
            AAM_Core_Server::getEndpoint() . '/conversation/' . $id,
            array(
                'body'    => json_encode(array( 'message' => $message)),
                'timeout' => 25,
                'headers' => array(
                    'Content-Type'      => 'application/json',
                    'Accept'            => 'application/json',
                    'x-aam-license-key' => $license
                )
            )
        );

        // Making sure that we are getting successful response
        if (is_wp_error($raw)) {
            $response = rest_ensure_response(array(
                'error' => $raw->get_error_message()
            ));

            $response->set_status(500);
        } elseif (intval(wp_remote_retrieve_response_code($raw)) === 200) {
            $response = rest_ensure_response(
                json_decode(wp_remote_retrieve_body($raw))
            );
        } else {
            $json     = json_decode(wp_remote_retrieve_body($raw));
            $response = rest_ensure_response(array(
                'error' => $json->message
            ));

            $response->set_status(400);
        }

        return $response;
    }

    /**
     * Check if current user has access to the service
     *
     * @return bool
     *
     * @access public
     * @version 6.9.27
     */
    public function check_permissions()
    {
        return current_user_can('aam_manager');
    }

}