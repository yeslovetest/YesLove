<?php

namespace radiustheme\cirkle;

use WP_REST_Request;

trait GroupTrait
{

    /**
     * Returns filtered groups
     *
     * @param array $args Filter for the groups query.
     *
     * @return array  $groups   Filtered groups.
     */
    public static function groups_get($args = []) {
        $request = new WP_REST_Request('GET', '/buddypress/v1/groups');

        $include_members = false;

        if (array_key_exists('include_members', $args)) {
            $include_members = $args['include_members'];
            unset($args['include_members']);
        }

        // set parameters
        foreach ($args as $key => $value) {
            $request->set_param($key, $value);
        }

        $bp_groups = rest_do_request($request);

        $groups = [];

        // if request was succesfull
        if ($bp_groups->status === 200) {
            foreach ($bp_groups->data as $bp_group) {
                $groups[] = self::group_get_data($bp_group, [], $include_members);
            }
        }

        return $groups;
    }


    /**
     * Get group data by ID
     *
     * @param       $bp_group
     * @param array $args
     * @param bool  $include_members
     *
     * @return array
     */
    public static function group_get_data($bp_group, $args = [], $include_members = false) {
        $members_args = [
            'group_id'       => $bp_group['id'],
            'exclude_admins' => false,
            'exclude_banned' => true
        ];

        $members_args = array_merge($members_args, $args);

        $group_meta_args = [
            'group_id' => $bp_group['id']
        ];
        $members = Helper::members_get(['include' => [$bp_group['creator_id']]]);
        $group = [
            'creator' => !empty($members[0]) ? $members[0] : null,
            'members' => self::groups_get_members($members_args),
            'banned'  => self::get_group_banned_members($bp_group['id']),
            'admins'  => self::get_group_admins($bp_group['id']),
            'mods'    => self::get_group_mods($bp_group['id']),
            'meta'    => self::group_get_meta($group_meta_args)
        ];

        $group['member_count'] = (int)$group['meta']['total_member_count'][0];

        $group = array_merge($group, $bp_group);

        // decode html entities
        $group['name'] = html_entity_decode($group['name']);

        $group['description'] = $bp_group['description']['raw'];

        if ($include_members) {
            $group['members'] = self::groups_get_members($members_args);
        }

        $group_extra_data = self::get_group_extra_data($group['id'], $group['slug']);

        $group = array_merge($group, $group_extra_data);

        return $group;
    }


    /**
     * Returns filtered group members.
     *
     * @param array $args Group filters.
     *
     * @return array  $group_members    Filtered group members.
     */
    public static function groups_get_members($args = []) {
        $request = new WP_REST_Request('GET', '/buddypress/v1/groups/' . $args['group_id'] . '/members');

        // set parameters
        foreach ($args as $key => $value) {
            $request->set_param($key, $value);
        }

        $bp_group_members = rest_do_request($request);

        $group_members = [];

        // if request was succesfull
        if ($bp_group_members->status === 200) {
            foreach ($bp_group_members->data as $bp_group_member) {
                $group_member_data = [
                    'is_admin'     => (boolean)$bp_group_member['is_admin'],
                    'is_mod'       => (boolean)$bp_group_member['is_mod'],
                    'is_banned'    => (boolean)$bp_group_member['is_banned'],
                    'is_confirmed' => (boolean)$bp_group_member['is_confirmed']
                ];

                $group_member_data = array_merge($group_member_data, Helper::member_get_data($bp_group_member, 'user-preview'));
                $group_members[] = $group_member_data;
            }
        }

        return $group_members;
    }


    /**
     * Get group banned members
     *
     * @param int $group_id ID of the group to return banned members from
     *
     * @return array
     */
    public static function get_group_banned_members($group_id) {
        $banned_members_args = [
            'group_id'       => $group_id,
            'exclude_admins' => false,
            'exclude_banned' => false
        ];

        $group_members = self::groups_get_members($banned_members_args);

        $banned_members = [];

        foreach ($group_members as $group_member) {
            if ($group_member['is_banned']) {
                $banned_members[] = $group_member;
            }
        }

        return $banned_members;
    }


    /**
     * Get group admins
     *
     * @param int $group_id ID of the group to return admins from
     *
     * @return array
     */
    public static function get_group_admins($group_id) {
        $bp_group_admins = groups_get_group_admins($group_id);

        $group_admins = [];

        foreach ($bp_group_admins as $bp_group_admin) {
            $group_admin = Helper::members_get(['include' => [$bp_group_admin->user_id]]);
            $group_admin = ! empty( $group_admin[0] ) ? $group_admin[0] : [];
            $group_admin = [0];
            $group_admin['date_modified'] = $bp_group_admin->date_modified;
            $group_admins[] = $group_admin;
        }

        return $group_admins;
    }

    /**
     * Get group mods
     *
     * @param int $group_id ID of the group to return mods from
     *
     * @return array
     */
    public static function get_group_mods($group_id) {
        $bp_group_mods = groups_get_group_mods($group_id);

        $group_mods = [];

        foreach ($bp_group_mods as $bp_group_mod) {
            $group_mod = self::members_get(['include' => [$bp_group_mod->user_id]])[0];
            $group_mod['date_modified'] = $bp_group_mod->date_modified;
            $group_mods[] = $group_mod;
        }

        return $group_mods;
    }


    /**
     * Get group metadata
     *
     * @param array $args
     * int     $args['group_id']         ID of the group to update metadata of
     * string  $args['meta_key']         Key of the metadata to update
     * boolean $args['single']           If true, return only the first value of the specified meta_key
     *
     * @return mixed
     */
    public static function group_get_meta($args) {
        $defaults = [
            'meta_key' => '',
            'single'   => true
        ];

        $args = array_merge($defaults, $args);

        return groups_get_groupmeta($args['group_id'], $args['meta_key'], $args['single']);
    }


    /**
     * Get group extra data
     *
     * @param int $groupID ID of the group to retrieve extra data from
     *
     * @return array
     */
    public static function get_group_extra_data($groupID, $groupSlug) {
        $fetch_avatar_args = [
            'item_id' => $groupID,
            'object'  => 'group',
            'type'    => 'full',
            'html'    => false
        ];

        $cover_image_url = bp_attachments_get_attachment('url', [
            'object_dir' => 'groups',
            'item_id'    => $groupID
        ]);

        $group_members_count_args = [
            'group_id'       => $groupID,
            'exclude_admins' => false
        ];

        // load default cover image url if user didn't upload any yet
        if (!$cover_image_url) {
            $cover_image_url = self::get_default_group_cover_url();
        }

        return [
            'post_count'      => self::get_groups_post_count($groupID),
            'link'            => trailingslashit(bp_get_groups_directory_permalink() . $groupSlug . '/'),
            'members_link'    => trailingslashit(bp_get_groups_directory_permalink() . $groupSlug . '/members'),
            'media_link'      => trailingslashit(bp_get_groups_directory_permalink() . $groupSlug . '/photos'),
            'avatar_url'      => bp_core_fetch_avatar($fetch_avatar_args),
            'cover_image_url' => $cover_image_url
        ];
    }


    /**
     * Get groups post count
     *
     * @param integer $groupID Group ID
     *
     * @return int
     */
    public static function get_groups_post_count($groupID) {
        $args = [
            'scope'  => 'groups',
            'filter' => [
                'object'     => 'groups',
                'action'     => [
                    'activity_update',
                    'activity_media_update',
                    'activity_media_upload',
                    'activity_share',
                    'post_share',
                    'created_group',
                    'joined_group'
                ],
                'primary_id' => $groupID
            ]
        ];

        return count(bp_activity_get($args)['activities']);
    }

    static function get_user_groups($userID, $filters = []) {
        $args = [
            'is_admin' => null,
            'is_mod'   => null
        ];

        $args = array_replace_recursive($args, $filters);

        $groups = bp_get_user_groups($userID, $args);

        $gps = [];

        foreach ($groups as $group) {
            $gp = self::groups_get(['include' => [$group->group_id]])[0];

            // check if member is admin, and add a property indicating this
            $gp['is_admin'] = false;

            foreach ($gp['admins'] as $admin) {
                // user is admin of this group
                if ( !empty($admin['id']) && $admin['id'] === $userID) {
                    $gp['is_admin'] = true;
                    break;
                }
            }

            // check if member is mod, and add a property indicating this
            $gp['is_mod'] = false;

            foreach ($gp['mods'] as $mod) {
                // user is mod of this group
                if ($mod['id'] === $userID) {
                    $gp['is_mod'] = true;
                    break;
                }
            }

            $gps[] = $gp;
        }

        return $gps;
    }

    static function group_get_invitations($args = []) {
        $request = new WP_REST_Request('GET', '/buddypress/v1/groups/invites');

        $defaults = [
            'per_page' => 100
        ];

        $args = array_merge($defaults, $args);

        // set parameters
        foreach ($args as $key => $value) {
            $request->set_param($key, $value);
        }

        $result = rest_do_request($request);

        // if request successfull
        if ($result->status === 200) {
            $invitations = [];

            foreach ($result->data as $bp_invitation) {
                $invitations[] = self::group_get_invitation_data($bp_invitation);
            }

            return $invitations;
        }

        return false;
    }

    static function group_get_invitation_data($bp_invitation) {
        $invitation = [
            'id'            => $bp_invitation['id'],
            'invite_sent'   => $bp_invitation['invite_sent'],
            'type'          => $bp_invitation['type'],
            'message'       => $bp_invitation['message'],
            'date_modified' => $bp_invitation['date_modified'],
            'group'         => self::groups_get(['include' => [$bp_invitation['group_id']]])[0],
            'user'          => Helper::members_get(['include' => [$bp_invitation['user_id']]])[0],
            'inviter'       => Helper::members_get(['include' => [$bp_invitation['inviter_id']]])[0]
        ];

        return $invitation;
    }

    static function get_default_group_avatar_url() {
        $groups_default_avatar_id = get_theme_mod('cirkle_groups_setting_default_avatar', false);

        if ($groups_default_avatar_id) {
            $groups_default_avatar_url = wp_get_attachment_image_src($groups_default_avatar_id, 'full')[0];
        } else {
            $groups_default_avatar_url = CIRKLE_ASSETS_URI . 'img/avatar/default-avatar.jpg';
        }

        return $groups_default_avatar_url;
    }

    /**
     * Returns default group cover URL
     *
     * @return string
     */
    public static function get_default_group_cover_url() {
        $groups_default_cover_id = get_theme_mod('cirkle_groups_setting_default_cover', false);

        if ($groups_default_cover_id) {
            $groups_default_cover_url = wp_get_attachment_image_src($groups_default_cover_id, 'full')[0];
        } else {
            $groups_default_cover_url = CIRKLE_ASSETS_URI . 'img/cover/default-cover.png';
        }

        return $groups_default_cover_url;
    }

}