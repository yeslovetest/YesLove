<?php

namespace radiustheme\cirkle;

trait GamiPressTrait
{

    /**
     * Get current user rank information
     *
     * @param string $rank_type_slug Slug of the rank type to return data from
     * @param int    $user_id        ID of the user to return current rank from
     * @param string $data_scope     Scope of the rank data to return.
     *
     * @return array
     */
    public static function gamipress_get_user_rank_priority($rank_type_slug, $user_id, $data_scope = 'full') {
        $args = [
            'post_type' => $rank_type_slug
        ];

        $gp_ranks = gamipress_get_ranks($args);
        $total_gp_ranks = count($gp_ranks);

        $gp_user_rank = gamipress_get_user_rank($user_id, $rank_type_slug);
        $user_rank = '';
        if ($gp_user_rank) {
            if ($data_scope === 'full') {
                $user_rank = [
                    'id'          => $gp_user_rank->ID,
                    'name'        => $gp_user_rank->post_title,
                    'description' => wp_strip_all_tags($gp_user_rank->post_content),
                    'image_url'   => Helper::post_get_image($gp_user_rank->ID),
                    'current'     => gamipress_get_rank_priority($gp_user_rank->ID),
                    'total'       => $total_gp_ranks
                ];
            } else if ($data_scope === 'simple') {
                $user_rank = [
                    'id'      => $gp_user_rank->ID,
                    'name'    => $gp_user_rank->post_title,
                    'current' => gamipress_get_rank_priority($gp_user_rank->ID),
                    'total'   => $total_gp_ranks
                ];
            }
        }

        return $user_rank;
    }


    /**
     * Get user completed achievement data
     *
     * @param string $achievement_type_slug Slug of the achievement type to return data from
     * @param int    $user_id               ID of the user to return completed achievements from
     * @param string $data_scope            Scope of the achievement data to return.
     *
     * @return array
     */
    public static function gamipress_get_user_completed_achievements($achievement_type_slug, $user_id, $data_scope = 'full') {
        return self::gamipress_get_achievements($achievement_type_slug, $user_id, $data_scope, true);
    }


    /**
     * Get all achievements of an achievement type
     *
     * @param string  $achievement_type_slug Slug of the achievement type to return data from
     * @param int     $user_id               ID of the user to return completed achievement stats from
     * @param string  $data_scope            Scope of the achievement data to return.
     * @param boolean $completed             True to return only completed achievements, false to return uncompleted achievements
     *
     * @return array
     */
    public static function gamipress_get_achievements($achievement_type_slug, $user_id = false, $data_scope = 'full', $completed = null) {
        $args = [
            'post_type' => $achievement_type_slug,
            'order'     => 'ASC'
        ];

        $gp_achievements = gamipress_get_achievements($args);

        $achievements = [];

        if ($data_scope === 'full') {
            $point_types = self::gamipress_get_point_types();

            foreach ($gp_achievements as $gp_achievement) {
                $completed_achievement = false;
                $awarded_achievement = false;

                if ($user_id) {
                    $completed_achievement = self::gamipress_user_completed_achievement($gp_achievement->ID, $user_id);
                    $awarded_achievement = self::gamipress_achievement_was_awarded($gp_achievement->ID, $user_id);

                    // if completed arg supplied, use it to skip achievements accordingly
                    if (!is_null($completed) && ($completed !== $completed_achievement)) {
                        continue;
                    }
                }

                $points = absint(gamipress_get_post_meta($gp_achievement->ID, '_gamipress_points'));
                $point_type = gamipress_get_post_meta($gp_achievement->ID, '_gamipress_points_type');

                // if a point type is selected by the user for this achievement on the backend gamipress screen
                if (array_key_exists($point_type, $point_types)) {
                    $point_type = $point_types[$point_type];
                }

                $achievement = [
                    'id'                 => $gp_achievement->ID,
                    'name'               => $gp_achievement->post_title,
                    'description'        => wp_strip_all_tags($gp_achievement->post_content),
                    'slug'               => $gp_achievement->post_name,
                    'image_url'          => Helper::post_get_image($gp_achievement->ID),
                    'points'             => $points,
                    'points_type'        => $point_type,
                    'unlock_with_points' => self::gamipress_get_unlockable_with_points($gp_achievement->ID),
                    'steps'              => [],
                    'completed_users'    => self::gamipress_get_achievement_completed_users($gp_achievement->ID),
                    'completed'          => $completed_achievement,
                    'awarded'            => $awarded_achievement,
                    'achievement_type'   => $achievement_type_slug
                ];

                // get achievements steps
                $completed_all_steps = true;
                $steps = gamipress_get_achievement_steps($gp_achievement->ID);

                foreach ($steps as $step) {
                    $completed_step = false;

                    if ($user_id) {
                        $completed_step = self::gamipress_user_completed_step($step->ID, $user_id);
                    }

                    if (!$completed_step) {
                        $completed_all_steps = false;
                    }

                    $achievement['steps'][] = [
                        'id'          => $step->ID,
                        'description' => $step->post_title,
                        'completed'   => $completed_step
                    ];
                }

                $achievement['completed_all_steps'] = $completed_all_steps;
                // achievement was unlocked with points if it is completed without having all its steps completed and without beign awarded
                $achievement['unlocked_with_points'] = $achievement['completed'] && (!$completed_all_steps || count($steps) === 0) && !$achievement['awarded'];

                $achievements[] = $achievement;
            }
        } else if ($data_scope === 'simple') {
            foreach ($gp_achievements as $gp_achievement) {
                $completed_achievement = false;

                if ($user_id) {
                    $completed_achievement = self::gamipress_user_completed_achievement($gp_achievement->ID, $user_id);

                    // if completed arg supplied, use it to skip achievements accordingly
                    if (!is_null($completed) && ($completed !== $completed_achievement)) {
                        continue;
                    }
                }

                $achievement = [
                    'id'        => $gp_achievement->ID,
                    'name'      => $gp_achievement->post_title,
                    'image_url' => Helper::post_get_image($gp_achievement->ID)
                ];

                $achievements[] = $achievement;
            }
        }

        return $achievements;
    }


    /**
     * Check if user completed an achievement
     *
     * @param int $achievement_id ID of the achievement
     * @param int $user_id        ID of the user to check if the achivement is completed
     *
     * @return boolean
     */
    public static function gamipress_user_completed_achievement($achievement_id, $user_id) {
        $completed_achievements_users = gamipress_get_achievement_earners($achievement_id);

        foreach ($completed_achievements_users as $completed_achievements_user) {
            if ($completed_achievements_user->ID === $user_id) {
                return true;
            }
        }

        return false;
    }


    /**
     * Check if user completed a step
     *
     * @param int $step_id ID of the step
     * @param int $user_id ID of the user to check if the step is completed
     *
     * @return boolean
     */
    public static function gamipress_user_completed_step($step_id, $user_id) {
        $completed_steps_users = gamipress_get_achievement_earners($step_id);

        foreach ($completed_steps_users as $completed_steps_user) {
            if ($completed_steps_user->ID === $user_id) {
                return true;
            }
        }

        return false;
    }

    /**
     * Get users that completed an achievement
     *
     * @param int $achievement_id ID of the achievement to get users that completed it
     *
     * @return array
     */
    public static function gamipress_get_achievement_completed_users($achievement_id) {
        $users = [];

        $achievement_users = gamipress_get_achievement_earners($achievement_id);

        foreach ($achievement_users as $achievement_user) {
            $users[] = Helper::members_get(['include' => [$achievement_user->ID]])[0];
        }

        return $users;
    }


    /**
     * Get points an achievement or rank is unlockable with, or false if its not unlockable with points
     *
     * @param int $entity_id ID of the achievement or rank
     *
     * @return array|boolean
     */
    public static function gamipress_get_unlockable_with_points($entity_id) {
        $unlockable_with_points = (bool)gamipress_get_post_meta($entity_id, '_gamipress_unlock_with_points');

        if ($unlockable_with_points) {
            $points_to_unlock_type = gamipress_get_post_meta($entity_id, '_gamipress_points_type_to_unlock');
            $points_to_unlock = absint(gamipress_get_post_meta($entity_id, '_gamipress_points_to_unlock'));
            $point_types = self::gamipress_get_point_types();

            $unlockable_with_points = $point_types[$points_to_unlock_type];
            $unlockable_with_points['points'] = $points_to_unlock;
        }

        return $unlockable_with_points;
    }


    /**
     * Returns true if given achievement was awarded to the user (given to the user via the admin panel)
     *
     * @param int $achievement_id ID of the achievement
     * @param int $user_id        ID of the user to check if the achievement was awarded to
     *
     * @return boolean
     */
    public static function gamipress_achievement_was_awarded($achievement_id, $user_id) {
        global $wpdb;

        $gamipress_logs_table_name = 'gamipress_logs';
        $gamipress_logs_table = $wpdb->prefix . $gamipress_logs_table_name;

        $gamipress_logs_meta_table_name = 'gamipress_logs_meta';
        $gamipress_logs_meta_table = $wpdb->prefix . $gamipress_logs_meta_table_name;

        // get if achievement was awarded by using the logs
        $sql = "SELECT $gamipress_logs_table.user_id FROM $gamipress_logs_meta_table
          INNER JOIN $gamipress_logs_table ON $gamipress_logs_table.log_id=$gamipress_logs_meta_table.log_id
          WHERE meta_key='_gamipress_achievement_id' and meta_value=%d and user_id=%d and type='achievement_award'";

        $result = $wpdb->get_row($wpdb->prepare($sql, [$achievement_id, $user_id]));

        return !is_null($result);
    }


    /**
     * Get point types
     *
     * @return array
     */
    public static function gamipress_get_point_types() {
        $gm_point_types = gamipress_get_points_types();
        $point_types = [];

        foreach ($gm_point_types as $key => $value) {
            $point_types[$key] = [
                'id'            => $value['ID'],
                'singular_name' => $value['singular_name'],
                'plural_name'   => $value['plural_name'],
                'slug'          => $key,
                'image_url'     => Helper::post_get_image($value['ID'])
            ];
        }

        // order point types by id ASC
        uasort($point_types, function ($a, $b) {
            if ($a['id'] < $b['id']) {
                return -1;
            }

            if ($a['id'] > $b['id']) {
                return 1;
            }

            return 0;
        });

        return $point_types;
    }
}