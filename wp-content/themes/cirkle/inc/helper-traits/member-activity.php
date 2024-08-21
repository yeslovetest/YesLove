<?php

namespace radiustheme\cirkle;

use radiustheme\cirkle\RDTheme;

trait MemberActivityTrait
{

    /**
     * Returns default member avatar URL
     *
     * @return string
     */
    public static function get_default_member_avatar_url() {
        $members_default_avatar_id = get_theme_mod('cirkle_members_setting_default_avatar', false);

        if ($members_default_avatar_id) {
            $members_default_avatar_url = wp_get_attachment_image_src($members_default_avatar_id, 'full')[0];
        } else {
            $members_default_avatar_url = CIRKLE_ASSETS_URI . '/img/avatar/default-avatar.jpg';
        }

        return $members_default_avatar_url;
    }

    public static function cirkle_group_updates_count($group_id) {
        global $wpdb;
        $bp_prefix       = bp_core_get_table_prefix();
        $sql = "SELECT COUNT(*) FROM {$bp_prefix}bp_activity 
                          WHERE component = 'groups' 
                          AND   type = 'activity_update'
                          AND   item_id = %d";
        $total_updates = $wpdb->get_var($wpdb->prepare($sql, [$group_id]));
        return $total_updates;
    }

    public static function cirkle_show_verified_badge($user_id) {
        if (function_exists('bp_is_verified')) {
            if (bp_is_verified($user_id)) {
                $meta = get_user_meta($user_id, 'bp-verified', true);
                echo '<span class="ckl-verified-id" data-toggle="tooltip" data-placement="top" title="'.esc_attr_e( 'Verified', 'cirkle' ).'">' . bp_get_verified_image($meta['image']) . '</span>';
            }
        }
    }

    // User Verified
    public static function cirkle_verified($user_id) {
        $meta = get_user_meta($user_id, 'bp-verified', true);
        if (isset($meta['activity'])) {
            $verified = $meta['activity'];
        }
        return $verified;
    }

    public static function cirkle_verified_profile($user_id) {
        $meta = get_user_meta($user_id, 'bp-verified', true);
        if (isset($meta['profile'])) {
            $verified = $meta['profile'];
        }
        return $verified;
    }

    public static function cirkle_verified_member($user_id) {
        $meta = get_user_meta($user_id, 'bp-verified', true);
        if (isset($meta['members'])) {
            $verified = $meta['members'];
        }
        return $verified;
    }

}

