<?php

namespace radiustheme\cirkle;

use radiustheme\cirkle\RDTheme;
use WP_REST_Request;

trait MemberTrait
{


    /**
     * Returns filtered members
     *
     * @param array $args Filter for the members query.
     *
     * @return array  $members    Filtered members.
     */
    public static function members_get($args = []) {
        $request = new WP_REST_Request('GET', '/buddypress/v1/members');

        $data_scope = 'user-status';

        if (array_key_exists('data_scope', $args)) {
            $data_scope = $args['data_scope'];
            unset($args['data_scope']);
        }

        $defaults = [
            'type' => 'alphabetical'
        ];

        $args = array_merge($defaults, $args);

        // set parameters
        foreach ($args as $key => $value) {
            $request->set_param($key, $value);
        }

        $bp_members = rest_do_request($request);

        $members = [];

        // if request was succesfull
        if ($bp_members->status === 200) {
            foreach ($bp_members->data as $bp_member) {
                $members[] = self::member_get_data($bp_member, $data_scope);
            }
        }

        return $members;
    }


    /**
     * Returns member data
     *
     * @type boolean $xprofile True to include xprofile data, false otherwise. Default false.
     *
     * @param string $data_scope
     *
     * @return array
     */
    public static function member_get_data($bp_member, $data_scope = 'user-status') {
        if ($data_scope === 'user-status') {
            return self::member_get_user_status_data($bp_member);
        }

        if ($data_scope === 'user-preview') {
            return self::member_get_user_preview_data($bp_member);
        }

        if ($data_scope === 'user-sidebar') {
            return self::member_get_user_sidebar_data($bp_member);
        }

        if ($data_scope === 'user-friends') {
            return self::member_get_user_friends_data($bp_member);
        }

        if ($data_scope === 'user-groups') {
            return self::member_get_user_groups_data($bp_member);
        }

        if ($data_scope === 'user-activity') {
            return self::member_get_user_activity_data($bp_member);
        }

        if ($data_scope === 'user-activity-friend') {
            return self::member_get_user_activity_friend_data($bp_member);
        }

        if ($data_scope === 'user-settings') {
            return self::member_get_user_settings_data($bp_member);
        }

        if ($data_scope === 'user-settings-profile') {
            return self::member_get_user_settings_profile_data($bp_member);
        }

        if ($data_scope === 'user-settings-password') {
            return self::member_get_user_settings_password_data($bp_member);
        }

        return [];
    }

    public static function members_get_fallback($member_id, $data_scope = 'user-status') {
        $member = self::members_get(['include' => $member_id, 'data_scope' => $data_scope]);
        if (count($member)) {
            $member_data = $member[0];
        } else {
            $member_data = [
                'id'           => $member_id,
                'name'         => esc_html__('[deleted]', 'cirkle'),
                'mention_name' => esc_html__('[deleted]', 'cirkle'),
                'link'         => '',
                'media_link'   => '',
                'badges_link'  => '',
                'avatar_url'   => Helper::get_default_member_avatar_url(),
                'verified'     => false
            ];
        }

        return $member_data;
    }


    /**
     * Returns user-status scope member data
     *
     * @param array $bp_member BP member data.
     *
     * @return array  $user_status_data     user-status scope member data.
     */
    public static function member_get_user_status_data($bp_member) {
        $user_status_data = [
            'id'                              => $bp_member['id'],
            'name'                            => $bp_member['name'],
            'link'                            => $bp_member['link'],
            'badges_link'                     => $bp_member['link'] . 'badges',
            'media_link'                      => $bp_member['link'] . 'photos',
            'stream_link'                     => $bp_member['link'] . 'settings/stream',
            'friend_requests_link'            => $bp_member['link'] . 'settings/friend-requests',
            'messages_link'                   => $bp_member['link'] . 'settings/messages',
            'notifications_link'              => $bp_member['link'] . 'settings/notifications',
            'manage_groups_link'              => $bp_member['link'] . 'settings/manage-groups',
            'received_group_invitations_link' => $bp_member['link'] . 'settings/received-group-invitations',
            'membership_requests_link'        => $bp_member['link'] . 'settings/membership-requests',
            'avatar_url'                      => $bp_member['avatar_urls']['full'],
            'verified'                        => false,
            'membership'                      => false
        ];

        if (bp_is_active('activity')) {
            $user_status_data['mention_name'] = $bp_member['mention_name'];
        } else {
            $user = get_userdata($bp_member['id']);
            $user_status_data['mention_name'] = $user->user_nicename;
        }
        // add GamiPress rank data if plugin is active
        if (Helper::plugin_is_active('gamipress')) {
            $user_status_data['rank'] = self::gamipress_get_user_rank_priority('rank', $bp_member['id'], 'simple');
        }

        // add Verified Member for BuddyPress data if plugin is active
        if (Helper::plugin_is_active('bp-verified-member')) {
            $user_status_data['verified'] = Helper::bpverifiedmember_user_is_verified($user_status_data['id']);
        }

        return $user_status_data;
    }


    public static function member_get_user_preview_data($bp_member) {
        $user_preview_data = [
            'id'           => $bp_member['id'],
            'name'         => $bp_member['name'],
            'mention_name' => $bp_member['mention_name'],
            'link'         => $bp_member['link'],
            'badges_link'  => $bp_member['link'] . 'badges',
            'avatar_url'   => $bp_member['avatar_urls']['full'],
            'cover_url'    => self::member_get_cover_url($bp_member['id']),
            'stats'        => [
                'post_count'    => Helper::activity_get_member_post_count($bp_member['id']),
                'friend_count'  => bp_is_active('friends') ? absint(bp_get_total_friend_count($bp_member['id'])) : 0,
                'comment_count' => Helper::activity_get_member_comment_count($bp_member['id'])
            ],
            'badges'       => [],
            'rank'         => [
                'current' => 0,
                'total'   => 0
            ],
            'profile_data' => self::member_get_xprofile_data($bp_member['id']),
        ];

        // add GamiPress rank data if plugin is active
        if (Helper::plugin_is_active('gamipress')) {
            $user_preview_data['badges'] = Helper::gamipress_get_user_completed_achievements('badge', $bp_member['id'], 'simple');
            $user_preview_data['rank'] = Helper::gamipress_get_user_rank_priority('rank', $bp_member['id'], 'simple');
        }

        return $user_preview_data;
    }


    /**
     * Returns user-sidebar scope member data
     *
     * @param array $bp_member BP member data.
     *
     * @return array  $user_status_data     user-sidebar scope member data.
     */
    public static function member_get_user_sidebar_data($bp_member) {
        $user_sidebar_data = [
            'id'           => $bp_member['id'],
            'name'         => $bp_member['name'],
            'mention_name' => $bp_member['mention_name'],
            'link'         => $bp_member['link'],
            'badges_link'  => $bp_member['link'] . 'badges',
            'avatar_url'   => $bp_member['avatar_urls']['full'],
            'cover_url'    => self::member_get_cover_url($bp_member['id']),
            'stats'        => [
                'post_count'    => Helper::activity_get_member_post_count($bp_member['id']),
                'friend_count'  => bp_is_active('friends') ? absint(bp_get_total_friend_count($bp_member['id'])) : 0,
                'comment_count' => Helper::activity_get_member_comment_count($bp_member['id'])
            ],
            'badges'       => [],
            'rank'         => [
                'current' => 0,
                'total'   => 0
            ]
        ];

        // add GamiPress rank data if plugin is active
        if (Helper::plugin_is_active('gamipress')) {
            $user_sidebar_data['badges'] = Helper::gamipress_get_user_completed_achievements('badge', $bp_member['id'], 'simple');
            $user_sidebar_data['rank'] = Helper::gamipress_get_user_rank_priority('rank', $bp_member['id'], 'simple');
        }

        return $user_sidebar_data;
    }

    static function member_get_user_friends_data($bp_member) {
        $user_friends_data = [
            'id'                       => $bp_member['id'],
            'name'                     => $bp_member['name'],
            'mention_name'             => $bp_member['mention_name'],
            'link'                     => $bp_member['link'],
            'avatar_url'               => $bp_member['avatar_urls']['thumb'],
            'rank'                     => [
                'current' => 0,
                'total'   => 0
            ],
            'friends'                  => [],
            'friend_requests_received' => [],
            'friend_requests_sent'     => [],
            'friend_requests_link'     => $bp_member['link'] . 'settings/friend-requests',
            'messages_link'            => $bp_member['link'] . 'settings/messages',
            'notifications_link'       => $bp_member['link'] . 'settings/notifications'
        ];

        // add GamiPress rank data if plugin is active
        if (Helper::plugin_is_active('gamipress')) {
            $user_friends_data['rank'] = Helper::gamipress_get_user_rank_priority('rank', $bp_member['id'], 'simple');
        }

        // add BuddyPress friend data if BuddyPress and the friends component are active
        if (Helper::plugin_is_active('buddypress') && bp_is_active('friends')) {
            $user_friends_data['friends'] = Helper::get_friends(['user_id' => $bp_member['id']]);
            $user_friends_data['friend_requests_received'] = Helper::get_friend_requests_received($bp_member['id']);
            $user_friends_data['friend_requests_sent'] = Helper::get_friend_requests_sent($bp_member['id']);
        }

        return $user_friends_data;
    }

    /**
     * Returns user-groups scope member data
     *
     * @param array $bp_member BP member data.
     *
     * @return array  $user_groups_data     user-groups scope member data.
     */
    static function member_get_user_groups_data($bp_member) {
        $user_groups_data = [
            'id'                            => $bp_member['id'],
            'name'                          => $bp_member['name'],
            'mention_name'                  => $bp_member['mention_name'],
            'link'                          => $bp_member['link'],
            'avatar_url'                    => $bp_member['avatar_urls']['thumb'],
            'rank'                          => [
                'current' => 0,
                'total'   => 0
            ],
            'groups'                        => [],
            'group_invitations_received'    => [],
            'group_invitations_sent'        => [],
            'manage_groups_link'            => $bp_member['link'] . 'settings/manage-groups',
            'default_group_avatar_url'      => Helper::get_default_group_avatar_url(),
            'default_group_cover_image_url' => Helper::get_default_group_cover_url()
        ];

        // add GamiPress rank data if plugin is active
        if (Helper::plugin_is_active('gamipress')) {
            $user_groups_data['rank'] = Helper::gamipress_get_user_rank_priority('rank', $bp_member['id'], 'simple');
        }

        // add BuddyPress group data if BuddyPress and the groups component are active
        if (Helper::plugin_is_active('buddypress') && bp_is_active('groups')) {
            $user_groups_data['groups'] = Helper::get_user_groups($bp_member['id']);

            $group_invitations_received_args = [
                'user_id' => $bp_member['id']
            ];

            $group_invitations_sent_args = [
                'inviter_id' => $bp_member['id']
            ];

            $user_groups_data['group_invitations_received'] = Helper::group_get_invitations($group_invitations_received_args);
            $user_groups_data['group_invitations_sent'] = Helper::group_get_invitations($group_invitations_sent_args);
        }

        return $user_groups_data;
    }

    public static function member_get_user_activity_data($bp_member) {
        $user_activity_data = [
            'id'                         => $bp_member['id'],
            'name'                       => $bp_member['name'],
            'mention_name'               => $bp_member['mention_name'],
            'link'                       => $bp_member['link'],
            'avatar_url'                 => $bp_member['avatar_urls']['thumb'],
            'rank'                       => [
                'current' => 0,
                'total'   => 0
            ],
            'friends'                    => [],
            'friend_requests_received'   => [],
            'friend_requests_sent'       => [],
            'groups'                     => [],
            'group_invitations_received' => [],
            'group_invitations_sent'     => [],
            'messages_link'              => $bp_member['link'] . 'settings/messages'
        ];

        // add GamiPress rank data if plugin is active
        if (Helper::plugin_is_active('gamipress')) {
            $user_activity_data['rank'] = Helper::gamipress_get_user_rank_priority('rank', $bp_member['id'], 'simple');
        }

        // add BuddyPress friend data if BuddyPress and the friends component are active
        if (Helper::plugin_is_active('buddypress') && bp_is_active('friends')) {
            $user_activity_data['friends'] = Helper::get_friends(['user_id' => $bp_member['id']]);
            $user_activity_data['friend_requests_received'] = Helper::get_friend_requests_received($bp_member['id']);
            $user_activity_data['friend_requests_sent'] = Helper::get_friend_requests_sent($bp_member['id']);
        }

        // add BuddyPress group data if BuddyPress and the groups component are active
        if (Helper::plugin_is_active('buddypress') && bp_is_active('groups')) {
            
            $user_activity_data['groups'] = Helper::get_user_groups($bp_member['id']);

            $group_invitations_received_args = [
                'user_id' => $bp_member['id']
            ];

            $group_invitations_sent_args = [
                'inviter_id' => $bp_member['id']
            ];

            $user_activity_data['group_invitations_received'] = Helper::group_get_invitations($group_invitations_received_args);
            $user_activity_data['group_invitations_sent'] = Helper::group_get_invitations($group_invitations_sent_args);
        }

        return $user_activity_data;
    }

    static function member_get_user_activity_friend_data($bp_member) {
        $user_activity_friend_data = [
            'id'            => $bp_member['id'],
            'name'          => $bp_member['name'],
            'mention_name'  => $bp_member['mention_name'],
            'link'          => $bp_member['link'],
            'messages_link' => $bp_member['link'] . 'messages',
            'avatar_url'    => $bp_member['avatar_urls']['full'],
            'cover_url'     => self::member_get_cover_url($bp_member['id']),
            'rank'          => [
                'current' => 0,
                'total'   => 0
            ]
        ];

        // add GamiPress rank data if plugin is active
        if (Helper::plugin_is_active('gamipress')) {
            $user_activity_friend_data['rank'] = Helper::gamipress_get_user_rank_priority('rank', $bp_member['id'], 'simple');
        }

        return $user_activity_friend_data;
    }

    /**
     * Returns user-settings scope member data
     *
     * @param array $bp_member BP member data.
     *
     * @return array  $user_settings_data   user-settings scope member data.
     */
    static function member_get_user_settings_data($bp_member) {
        return [
            'id'           => $bp_member['id'],
            'name'         => $bp_member['name'],
            'mention_name' => $bp_member['mention_name'],
            'link'         => $bp_member['link'],
            'avatar_url'   => $bp_member['avatar_urls']['full'],
            'rank'         => [
                'current' => 0,
                'total'   => 0
            ],
            'profile_data' => self::member_get_xprofile_data($bp_member['id']),
        ];
    }

    /**
     * Returns user-settings-profile scope member data
     *
     * @param array $bp_member BP member data.
     *
     * @return array  $user_settings_profile_data   user-settings-profile scope member data.
     */
    static function member_get_user_settings_profile_data($bp_member) {
        $user_settings_profile_data = [
            'id'           => $bp_member['id'],
            'name'         => $bp_member['name'],
            'mention_name' => $bp_member['mention_name'],
            'link'         => $bp_member['link'],
            'avatar_url'   => $bp_member['avatar_urls']['full'],
            'cover_url'    => self::member_get_cover_url($bp_member['id']),
            'rank'         => [
                'current' => 0,
                'total'   => 0
            ],
            'profile_data' => self::member_get_xprofile_data($bp_member['id']),
        ];

        // add GamiPress rank data if plugin is active
        if (Helper::plugin_is_active('gamipress')) {
            $user_settings_profile_data['rank'] = Helper::gamipress_get_user_rank_priority('rank', $bp_member['id'], 'simple');
        }

        return $user_settings_profile_data;
    }


    /**
     * Returns user-settings-password scope member data
     *
     * @param array $bp_member BP member data.
     *
     * @return array  $user_settings_password_data  user-settings-password scope member data.
     */
    static function member_get_user_settings_password_data($bp_member) {
        $user = get_userdata($bp_member['id']);

        return [
            'id'           => $bp_member['id'],
            'name'         => $bp_member['name'],
            'mention_name' => $bp_member['mention_name'],
            'password'     => $user->user_pass,
            'link'         => $bp_member['link'],
            'avatar_url'   => $bp_member['avatar_urls']['full'],
            'rank'         => [
                'current' => 0,
                'total'   => 0
            ]
        ];
    }


    /**
     * Returns member xprofile data
     *
     * @param int $member_id Member id.
     *
     * @return array  $member_xprofile_data   Structured member xprofile data.
     */
    public static function member_get_xprofile_data($member_id) {
        $request = new WP_REST_Request('GET', '/buddypress/v1/xprofile/groups');

        // set parameters
        $request->set_param('user_id', $member_id);
        $request->set_param('fetch_fields', true);
        $request->set_param('fetch_field_data', true);

        $bp_xprofile_groups = rest_do_request($request);

        $member_xprofile_data = [
            'group' => [],
            'field' => []
        ];

        // if request was succesfull
        if ($bp_xprofile_groups->status === 200) {
            foreach ($bp_xprofile_groups->data as $bp_xprofile_group) {
                $member_xprofile_data['group'][$bp_xprofile_group['name']] = [];

                foreach ($bp_xprofile_group['fields'] as $field) {
                    $member_xprofile_field_data = [
                        'group_id'     => $bp_xprofile_group['id'],
                        'id'           => $field['id'],
                        'name'         => $field['name'],
                        'type'         => $field['type'],
                        'value'        => stripslashes($field['data']['value']['raw']),
                        'field_order'  => $field['field_order'],
                        'option_order' => $field['option_order'],
                        'options'      => $field['options'],
                        'is_required'  => $field['is_required'],
                        'meta'         => bp_xprofile_get_meta($field['id'], 'field'),
                        'values'       => $field['data']
                    ];

                    // pass checkbox unserialized value as a comma separated string
                    if ($field['type'] === 'checkbox') {
                        $member_xprofile_field_data['value'] = implode(', ', $field['data']['value']['unserialized']);
                    }

                    $default_value_option_field_types = ['selectbox', 'radio'];

                    // field type with defaultable option values
                    // set default option as value if value is not yet set by user
                    if ($field['data']['value']['raw'] === '') {
                        if (in_array($field['type'], $default_value_option_field_types)) {
                            foreach ($field['options'] as $option) {
                                if ($option['is_default_option']) {
                                    $member_xprofile_field_data['value'] = $option['name'];
                                    break;
                                }
                            }
                        }

                        if ($field['type'] === 'checkbox') {
                            $values = [];

                            foreach ($field['options'] as $option) {
                                if ($option['is_default_option']) {
                                    $values[] = $option['name'];
                                }
                            }

                            $member_xprofile_field_data['value'] = implode(', ', $values);
                        }
                    }

                    $member_xprofile_data['group'][$bp_xprofile_group['name']][] = $member_xprofile_field_data;
                    $member_xprofile_data['field'][$bp_xprofile_group['name'] . '_' . $field['name']] = $member_xprofile_field_data;
                }
            }
        }

        return $member_xprofile_data;
    }


    /**
     * Returns member cover url
     *
     * @param int $member_id Member id.
     *
     * @return string $cover_url      Member cover url.
     */
    public static function member_get_cover_url($member_id) {
        $cover_url = bp_attachments_get_attachment('url', [
            'object_dir' => 'members',
            'item_id'    => $member_id
        ]);

        // get default cover url if user hasn't uploaded one yet
        if (!$cover_url) {
            $cover_url = self::get_default_member_cover_url();
        }

        return $cover_url;
    }


    public static function banner_img($user_id, $dir) {
        $bg_url = bp_attachments_get_attachment('url', array(
            'object_dir' => $dir,
            'item_id'    => $user_id,
        ));
        if (empty($bg_url)) {
            $bg_url = CIRKLE_BANNER_DUMMY_IMG . 'dummy-banner.jpg';
        } else {
            $bg_url = $bg_url;
        }
        ?>
        <div class="cover-img">
            <img src="<?php echo esc_url($bg_url); ?>" alt="<?php esc_attr_e( 'Cover Image', 'cirkle' ) ?>">
        </div>
    <?php }


    /**
     * Returns default member cover URL
     *
     * @return string
     */
    public static function get_default_member_cover_url() {
        $members_default_cover_id = get_theme_mod('cirkle_members_setting_default_cover', false);

        if ($members_default_cover_id) {
            $members_default_cover_url = wp_get_attachment_image_src($members_default_cover_id, 'full')[0];
        } else {
            $members_default_cover_url = CIRKLE_BANNER_DUMMY_IMG . '/cover/default-cover.png';
        }

        return $members_default_cover_url;
    }

    // User Post

    /**
     * @param $user_id
     *
     * @return string
     */
    public static function cirkle_user_post_count($user_id) {
        return count_user_posts($user_id);
    }

    //User Social
    public static function cirkle_member_social_socials_info($user_id) {
        $facebook_info = xprofile_get_field_data('Facebook', $user_id);
        $twitter_info = xprofile_get_field_data('Twitter', $user_id);
        $dribbble_info = xprofile_get_field_data('Dribbble', $user_id);
        $behance_info = xprofile_get_field_data('Behance', $user_id);
        $youtube_info = xprofile_get_field_data('YouTube', $user_id);

        ?>
        <ul class="item-social">
            <?php if ($facebook_info) { ?>
                <li><a href="<?php echo esc_url( $facebook_info ); ?>" class="bg-fb" target="_blank"><i class="icofont-facebook"></i></a></li>
            <?php }
            if ($twitter_info) { ?>
                <li><a href="<?php echo esc_url( $twitter_info ); ?>" class="bg-twitter" target="_blank"><i class="icofont-twitter"></i></a></li>
            <?php }
            if ($dribbble_info) { ?>
                <li><a href="<?php echo esc_url( $dribbble_info ); ?>" class="bg-dribble" target="_blank"><i class="icofont-dribbble"></i></a></li>
            <?php }
            if ($behance_info) { ?>
                <li><a href="<?php echo esc_url( $behance_info ); ?>" class="bg-behance" target="_blank"><i class="icofont-behance"></i></a></li>
            <?php }
            if ($youtube_info) { ?>
                <li><a href="<?php echo esc_url( $youtube_info ); ?>" class="bg-youtube" target="_blank"><i class="icofont-brand-youtube"></i></a></li>
            <?php } ?>
        </ul>
    <?php }

    //User Online Status
    public static function cirkle_is_user_online($use_id) {
        $last_activity = bp_get_user_last_activity($use_id);
        $curr_time = time();
        $diff = $curr_time - strtotime($last_activity);
        $time = 5 * 60; // must be in seconds
        if ($diff < $time)
            echo 'online';
        else
            echo 'offline';
    }

    // User Comments
    public static function cirkle_count_user_comments($member_id) {
        $args = [
            'display_comments' => 'stream',
            'filter'           => [
                'user_id' => $member_id,
                'object'  => [
                    'activity',
                    'groups'
                ],
                'action'  => [
                    'activity_comment'
                ]
            ]
        ];
        return count(bp_activity_get($args)['activities']);
    }

    //Uer Profile Views
    public static function cirkle_postviews($user_id) {

        //Set the name of the Posts Custom Field.
        $count_key = 'post_views_count';

        //Returns values of the custom field with the specified key from the specified post.
        $count = get_post_meta($user_id, $count_key, true);

        //If the the Post Custom Field value is empty.
        if ($count == '') {
            $count = 0; // set the counter to zero.

            //Delete all custom fields with the specified key from the specified post.
            delete_post_meta($user_id, $count_key);

            //Add a custom (meta) field (Name/value)to the specified post.
            add_post_meta($user_id, $count_key, '0');
            return $count;

            //If the the Post Custom Field value is NOT empty.
        } else {
            $count++; //increment the counter by 1.
            //Update the value of an existing meta key (custom field) for the specified post.
            update_post_meta($user_id, $count_key, $count);

            //If statement, is just to have the singular form 'View' for the value '1'
            if ($count == '1') {
                return $count;
            } //In all other cases return (count) Views
            else {
                return $count;
            }
        }
    }

    public static function cirkle_get_postviews($user_id) {
        $count_key = 'post_views_count';
        //Returns values of the custom field with the specified key from the specified post.
        $count = get_post_meta($user_id, $count_key, true);

        return $count;
    }

    /**
     * Add verified class for each verified member in the directory.
     *
     * @param array $classes Classes that will be output in the member container.
     *
     * @return array Modified classes array.
     */
    public function member_directory_add_verified_class($classes) {
        global $bp_verified_member_admin, $members_template;

        if (empty($bp_verified_member_admin->settings->get_option('display_badge_in_members_lists'))) {
            return $classes;
        }

        $user_id = $members_template->member->id;

        if (empty(get_user_meta($user_id, $bp_verified_member_admin->meta_box->meta_keys['verified'], true))) {
            return $classes;
        }

        $classes[] = 'bp-verified-member';

        return $classes;
    }

    /**
     * Get the verified badge HTML.
     *
     * @return string The badge HTML.
     */
    public static function cirkle_get_verified_badge($user_id) {
        $verified = get_user_meta($user_id, 'bp_verified_member', true);
        if ($verified == 1) {
            return apply_filters('bp_verified_member_verified_badge', '<span class="bp-verified-badge"></span>');
        }
    }


    static function get_logged_user_member_data($data_scope = 'user-status') {
        $user = false;

        if (is_user_logged_in()) {
            $user_id = get_current_user_id();
            $user = self::members_get(['include' => [$user_id], 'data_scope' => $data_scope])[0];
        }

        return $user;
    }


}