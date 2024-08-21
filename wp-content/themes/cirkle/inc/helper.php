<?php
/**
 * @author  RadiusTheme
 *
 * @since   1.0
 *
 * @version 1.1
 */

namespace radiustheme\cirkle;

class Helper
{
	use IconTrait;
	use CustomQueryTrait;
	use ResourceLoadTrait;
	use DataTrait;
	use LayoutTrait;
	use SocialShares;
	use MemberTrait;
	use MemberActivityTrait;
	use ActivityTrait;
	use GamiPressTrait;
	use GroupTrait;
	use CirkleFriendsTrait;

	/**
	 * Get post image url.
	 *
	 * @param int $post_id ID of the post to get the image from
	 *
	 * @return string
	 */
	public static function post_get_image($post_id)
	{
		$thumbnail_id = get_post_thumbnail_id($post_id);

		$thumbnail_post = get_post($thumbnail_id);

		return $thumbnail_post->guid;
	}

	/**
	 * Returns filtered posts.
	 *
	 * @param array $args Filter arguments for post query
	 *
	 * @return array
	 */
	public static function get_posts($args)
	{
		// get posts
		$wp_posts = get_posts($args);

		$posts = [];

		foreach ($wp_posts as $wp_post) {
			$post = [
				'id'                => $wp_post->ID,
				'type'              => 'post',
				'format'            => get_post_format($wp_post->ID),
				'timestamp'         => get_the_date('', $wp_post->ID),
				'excerpt'           => get_the_excerpt($wp_post->ID),
				'permalink'         => get_permalink($wp_post->ID),
				'title'             => $wp_post->post_title,
				'cover_url'         => false,
				'cover_url_thumb'   => false,
				'postv1_cover_url'  => false,
				'postv2_cover_url'  => false,
				'share_count'       => self::post_get_share_count($wp_post->ID),
				'comment_count'     => (int) $wp_post->comment_count,
				'reactions'         => [],
				'categories'        => [],
				'tags'              => [],
				'comment_status'    => $wp_post->comment_status,
				'ping_status'       => $wp_post->ping_status,
				'post_password'     => $wp_post->post_password,
				'password_required' => post_password_required($wp_post->ID),
			];

			// add BuddyPress member data if plugin is active
			if (self::plugin_is_active('buddypress')) {
				$post['author'] = self::members_get(['include' => [$wp_post->post_author]])[0];
			} else {
				$post['author'] = self::user_get_data($wp_post->post_author);
			}

			// if no author data available, show as deleted
			if (count($post['author']) === 0) {
				$post['author'] = [
					'id'           => $wp_post->post_author,
					'name'         => '[deleted]',
					'mention_name' => '[deleted]',
					'link'         => '',
					'media_link'   => '',
					'badges_link'  => '',
					'avatar_url'   => self::get_default_member_avatar_url(),
					'rank'         => [
						'current' => 0,
						'total'   => 0,
					],
				];
			}

			// add vkreact reactions data if plugin is active
			if (self::plugin_is_active('rtreact')) {
				$post['reactions'] = rtreat_reactions_insert_user_data(vkreact_get_post_reactions($wp_post->ID));
			}

			// add post format information
			if ($post['format'] === 'video') {
				$videoURL          = get_post_meta($wp_post->ID, 'cirkle_video_url', true);
				$post['video_url'] = $videoURL;
			} elseif ($post['format'] === 'audio') {
				$audioURL = get_post_meta($wp_post->ID, 'cirkle_audio_url', true);

				$post['audio_url'] = $audioURL;
			} elseif ($post['format'] === 'gallery') {
				$attachment_ids = get_post_meta($wp_post->ID, 'cirkle_gallery_ids', true);

				if ($attachment_ids[0] !== '') {
					$attachment_ids = explode(',', $attachment_ids);

					$post['gallery'] = [];

					foreach ($attachment_ids as $attachment_id) {
						$attachment        = [];
						$attachment['id']  = $attachment_id;
						$attachment['url'] = wp_get_attachment_url($attachment_id);
						$post['gallery'][] = $attachment;
					}
				} else {
					$post['gallery'] = false;
				}
			}

			// if user uploaded a custom cover
			if (has_post_thumbnail($wp_post->ID)) {
				// get user custom cover url
				$post['cover_url']        = get_the_post_thumbnail_url($wp_post->ID);
				$post['cover_url_thumb']  = get_the_post_thumbnail_url($wp_post->ID, 'cirkle-postlist-thumb');
				$post['postv1_cover_url'] = get_the_post_thumbnail_url($wp_post->ID, 'cirkle-postv1-fullscreen');
				$post['postv2_cover_url'] = get_the_post_thumbnail_url($wp_post->ID, 'cirkle-postv2-fullscreen');
			}

			// get post categories
			$categories = get_the_category($wp_post->ID);

			foreach ($categories as $category) {
				$post_cat = get_category($category);

				$cat         = [];
				$cat['id']   = $post_cat->cat_ID;
				$cat['name'] = $post_cat->name;
				$cat['link'] = get_category_link($post_cat->cat_ID);

				$post['categories'][] = $cat;
			}

			// get post tags
			$tags = get_the_tags($wp_post->ID);

			if ($tags) {
				foreach ($tags as $tag) {
					$t         = [];
					$t['id']   = $tag->term_id;
					$t['name'] = $tag->name;
					$t['link'] = get_tag_link($tag->term_id);

					$post['tags'][] = $t;
				}
			}

			$posts[] = $post;
		}

		return $posts;
	}

	/**
	 * Returns user data.
	 *
	 * @param int $user_id User id.
	 *
	 * @return array  $user         User data.
	 */
	public static function user_get_data($user_id)
	{
		$user_data = get_userdata($user_id);

		$user = [];

		if ($user_data) {
			$user = [
				'id'           => $user_data->ID,
				'name'         => $user_data->display_name,
				'mention_name' => $user_data->user_login,
				'link'         => '',
				'media_link'   => '',
				'badges_link'  => '',
				'avatar_url'   => get_avatar_url($user_data->ID),
				'cover_url'    => self::get_default_member_cover_url(),
				'badges'       => [],
				'rank'         => [
					'current' => 0,
					'total'   => 0,
				],
			];

			// add GamiPress rank data if plugin is active
			if (self::plugin_is_active('gamipress')) {
				$user['rank']   = self::gamipress_get_user_rank_priority('rank', $user_data->ID, 'simple');
				$user['badges'] = self::gamipress_get_user_completed_achievements('badge', $user_data->ID, 'simple');
			}
		}

		return $user;
	}

	/**
	 * Gets post share count.
	 *
	 * @param int $post_id ID of the post to get share count of.
	 *
	 * @return int  $share_count      Share count of the post.
	 */
	public static function post_get_share_count($post_id)
	{
		$share_count = get_post_meta($post_id, 'share_count', true);

		return ! empty($share_count) ? $share_count : 0;
	}

	/**
	 * Check if a plugin is active.
	 *
	 * @param string $plugin PLugin name.
	 *
	 * @return bool   $is_active      True if plugin is active, false otherwise.
	 */
	public static function plugin_is_active($plugin)
	{
		switch ($plugin) {
			case 'buddypress':
				$is_active = function_exists('buddypress');
				break;
			case 'gamipress':
				$is_active = function_exists('GamiPress');
				break;
			case 'gamipress-buddypress-integration':
				$is_active = class_exists('GamiPress_BuddyPress');
				break;
			case 'elementor':
				$is_active = class_exists('Elementor\Plugin');
				break;
			case 'bp-verified-member':
				$is_active = class_exists('BP_Verified_Member');
				break;
			case 'bbpress':
				$is_active = class_exists('bbPress');
				break;
			case 'rtreact':
				$is_active = defined('RTREACT_VERSION');
				break;
			case 'mediapress':
				$is_active = function_exists('mediapress');
				break;
			default:
				$is_active = false;
		}

		return $is_active;
	}

	public static function rt_the_logo_light()
	{
		if (has_custom_logo()) {
			$custom_logo_id = get_theme_mod('custom_logo');
			$logo_light     = wp_get_attachment_image($custom_logo_id, 'full');
		} else {
			if (! empty(RDTheme::$options['logo'])) {
				$logo_light = wp_get_attachment_image(RDTheme::$options['logo'], 'full');
			} else {
				$logo_light = '';
			}
		}

		return $logo_light;
	}

	public static function rt_the_logo_mobile()
	{
		if (! empty(RDTheme::$options['logo_mobile'])) {
			$logo_mobile = wp_get_attachment_image(RDTheme::$options['logo_mobile'], 'full');
		} else {
			$logo_mobile = '';
		}

		return $logo_mobile;
	}

	public static function cirkle_excerpt($limit)
	{
		$excerpt = explode(' ', get_the_excerpt(), $limit);
		if (count($excerpt) >= $limit) {
			array_pop($excerpt);
			$excerpt = implode(' ', $excerpt) . '';
		} else {
			$excerpt = implode(' ', $excerpt);
		}
		$excerpt = preg_replace('`[[^]]*]`', '', $excerpt);

		return $excerpt;
	}

	public static function generate_elementor_anchor($anchor, $anchor_text = 'Read More', $classes = '')
	{
		if (! empty($anchor['url'])) {
			$class_attribute = '';
			if ($classes) {
				$class_attribute = "class='{$classes}'";
			}

			$target_attribute = '';
			if ($anchor['is_external']) {
				$target_attribute = 'target="_blank"';
			}

			$rel_attribute = '';
			if ($anchor['nofollow']) {
				$rel_attribute = 'rel="nofollow"';
			}
			$anchor_url      = $anchor['url'];
			$href_attributes = "href='{$anchor_url}'";

			$all_attributes = "$class_attribute $target_attribute $rel_attribute $href_attributes";

			$a = sprintf('<%1$s %2$s>%3$s</%1$s>', 'a', $all_attributes, $anchor_text);

			return $a;
		}

		return null;
	}

	public static function custom_sidebar_fields()
	{
		$cirkle         = CIRKLE_THEME_PREFIX_VAR;
		$sidebar_fields = [];

		$sidebar_fields['sidebar']         = esc_html__('Sidebar', 'cirkle');
		$sidebar_fields['sidebar-project'] = esc_html__('Project Sidebar ', 'cirkle');

		$sidebars = get_option("{$cirkle}_custom_sidebars", []);
		if ($sidebars) {
			foreach ($sidebars as $sidebar) {
				$sidebar_fields[$sidebar['id']] = $sidebar['name'];
			}
		}

		return $sidebar_fields;
	}

	public static function cirkle_get_primary_category()
	{
		if (get_post_type() != 'post') {
			return;
		}
		// Get the first assigned category ----------
		$get_the_category = get_the_category();
		$primary_category = [$get_the_category[0]];

		if (! empty($primary_category[0])) {
			return $primary_category;
		}
	}

	public static function filter_content($content)
	{
		// wp filters
		$content = wptexturize($content);
		$content = convert_smilies($content);
		$content = convert_chars($content);
		$content = wpautop($content);
		$content = shortcode_unautop($content);

		// remove shortcodes
		$pattern = '/\[(.+?)\]/';
		$content = preg_replace($pattern, '', $content);

		// remove tags
		$content = strip_tags($content);

		return $content;
	}

	public static function pagination($max_num_pages = false)
	{
		global $wp_query;
		$max = $max_num_pages ? $max_num_pages : $wp_query->max_num_pages;
		$max = intval($max);

		/** Stop execution if there's only 1 page */
		if ($max <= 1) {
			return;
		}

		$paged = get_query_var('paged') ? absint(get_query_var('paged')) : 1;

		/**    Add current page to the array */
		if ($paged >= 1) {
			$links[] = $paged;
		}

		/**    Add the pages around the current page to the array */
		if ($paged >= 3) {
			$links[] = $paged - 1;
			$links[] = $paged - 2;
		}

		if (($paged + 2) <= $max) {
			$links[] = $paged + 2;
			$links[] = $paged + 1;
		}
		include CIRKLE_THEME_VIEW_DIR . 'pagination.php';
	}

	public static function comments_callback($comment, $args, $depth)
	{
		include CIRKLE_THEME_VIEW_DIR . 'comments-callback.php';
	}

	public static function nav_menu_args()
	{
		$cirkle        = CIRKLE_THEME_PREFIX_VAR;
		$nav_menu_args = [
			'theme_location' => 'primary',
			'container'      => 'ul',
			'echo'           => true,
			'menu_id'     	 => 'menu-main-menu',
			'menu_class'     => 'cirkle-main-menu',
		];

		return $nav_menu_args;
	}

	public static function sidebar_menu_args()
	{
		$nav_menu_args = [
			'theme_location' => 'sidemenu',
			'container'      => 'ul',
			'menu_class'     => 'side-menu',
		];

		return $nav_menu_args;
	}

    public static function sidebar_icon_menu()
    {
        $menu_name       = 'sidemenu';
        $short_menu_list = '';
    
        if (($locations = get_nav_menu_locations()) && isset($locations[$menu_name])) {
            $menu = wp_get_nav_menu_object($locations[$menu_name]);
    
            if ($menu && !is_wp_error($menu)) {
                $menu_items = wp_get_nav_menu_items($menu->term_id);
                $short_menu_list = '<ul id="short-menu-' . $menu_name . '" class="side-menu">';
    
                foreach ((array) $menu_items as $key => $menu_item) {
                    if (isset($menu_item->title, $menu_item->url, $menu_item->db_id)) {
                        $title      = $menu_item->title;
                        $url        = $menu_item->url;
                        $icon_class = get_post_meta($menu_item->db_id, '_cirkle_menu_icon', true);
    
                        if ($icon_class) {
                            $short_menu_list .= '<li><a href="' . esc_url($url) . '" class="menu-link" data-toggle="tooltip" data-placement="right" title="' . esc_attr($title) . '"><i class="' . esc_attr($icon_class) . '"></i></a></li>';
                        }
                    }
                }
    
                $short_menu_list .= '</ul>';
            }
        }
    
        echo wp_kses_stripslashes($short_menu_list);
    }


    public static function sidebar_icon_text_menu()
    {
        $menu_name = 'sidemenu';
        $menu_list = '';
    
        if (($locations = get_nav_menu_locations()) && isset($locations[$menu_name])) {
            $menu = wp_get_nav_menu_object($locations[$menu_name]);
    
            if ($menu && !is_wp_error($menu)) {
                $menu_items = wp_get_nav_menu_items($menu->term_id);
                $menu_list  = '<ul id="long-menu-' . $menu_name . '" class="side-menu">';
    
                foreach ((array) $menu_items as $key => $menu_item) {
                    if (isset($menu_item->title, $menu_item->url, $menu_item->db_id)) {
                        $title      = $menu_item->title;
                        $url        = $menu_item->url;
                        $icon_class = get_post_meta($menu_item->db_id, '_cirkle_menu_icon', true);
    
                        if ($icon_class) {
                            $menu_list .= '<li><a href="' . esc_url($url) . '" class="menu-link"><i class="' . esc_attr($icon_class) . '"></i><span class="menu-title">' . esc_attr($title) . '</span></a></li>';
                        } else {
                            $menu_list .= '<li><a href="' . esc_url($url) . '" class="menu-link"><span class="menu-title">' . esc_attr($title) . '</span></a></li>';
                        }
                    }
                }
    
                $menu_list .= '</ul>';
            }
        }
    
        echo wp_kses_stripslashes($menu_list);
    }

	public static function requires($filename, $dir = false)
	{
		if ($dir) {
			$child_file = get_stylesheet_directory() . '/' . $dir . '/' . $filename;
			if (file_exists($child_file)) {
				$file = $child_file;
			} else {
				$file = get_template_directory() . '/' . $dir . '/' . $filename;
			}
		} else {
			$child_file = get_stylesheet_directory() . '/inc/' . $filename;
			if (file_exists($child_file)) {
				$file = $child_file;
			} else {
				$file = CIRKLE_THEME_INC_DIR . $filename;
			}
		}

		require_once $file;
	}

	/* = BuddyPress Code
	============================================================================ */
	public static function cirkle_plugin_is_active($plugin)
	{
		switch ($plugin) {
			case 'buddypress':
				$is_active = function_exists('buddypress');
				break;
			case 'bbpress':
				$is_active = function_exists('bbpress');
				break;
			default:
				$is_active = false;
		}

		return $is_active;
	}

	public static function get_logged_user_data()
	{
		$user = false;

		if (is_user_logged_in()) {
			$user_id = get_current_user_id();
			$user    = self::user_get_data($user_id);
		}

		return $user;
	}

	public static function update_post_meta($args)
	{
		// metadata ID on new meta created, true on meta update, false on error
		return update_post_meta($args['post_id'], $args['meta_key'], $args['meta_value']);
	}

	public static function post_create_meta_share_count_task($args)
	{
		$task_execute = function ($args) {
			$meta_args = [
				'post_id'    => $args['id'],
				'meta_key'   => 'share_count',
				'meta_value' => $args['count'],
			];

			$result = self::update_post_meta($meta_args);

			if ($result) {
				return $args['id'];
			}

			return false;
		};

		$task_rewind = function ($args, $post_id) {
		};

		return new Cirkle_Task($task_execute, $task_rewind, $args);
	}

	public static function plugin_get_required_plugins_activation_status()
	{
		$required_plugins_status = [
			'buddypress'                       => self::plugin_is_active('buddypress'),
			'gamipress'                        => self::plugin_is_active('gamipress'),
			'bbpress'                          => self::plugin_is_active('bbpress'),
			'gamipress-buddypress-integration' => self::plugin_is_active('gamipress-buddypress-integration'),
			'elementor'                        => self::plugin_is_active('elementor'),
			'rtreact'                          => self::plugin_is_active('rtreact'),
			'mediapress'                       => self::plugin_is_active('mediapress'),
			'bp-verified-member'               => self::plugin_is_active('bp-verified-member'),
		];

		// add buddypress component related activation status
		if (self::plugin_is_active('buddypress')) {
			$required_plugins_status['buddypress_groups']   = bp_is_active('groups');
			$required_plugins_status['buddypress_friends']  = bp_is_active('friends');
			$required_plugins_status['buddypress_messages'] = bp_is_active('messages');
		}

		return $required_plugins_status;
	}

	public static function customizer_theme_colors_get_array()
	{
		return []; //$user_custom_colors;
	}

	/**
	 * Inserts user data into reactions.
	 *
	 * @param array $reactions_data Reactions data, each with an array of user ids
	 *
	 * @return array  $reactions_data_with_users  Reactions data with user data inserted
	 */
	public static function reactions_insert_user_data($reactions_data)
	{
		$reactions_data_with_users = [];

		foreach ($reactions_data as $reaction_data) {
			$reaction_data_cp          = (array) $reaction_data;
			$reaction_data_cp['users'] = [];

			foreach ($reaction_data->users as $user_id) {
				// add BuddyPress member data if plugin is active
				if (self::plugin_is_active('buddypress')) {
					$members                     = self::members_get(['include' => [$user_id]]);
					$reaction_data_cp['users'][] = ! empty($members[0]) ? $members[0] : [];
				} else {
					$reaction_data_cp['users'][] = self::user_get_data($user_id);
				}
			}

			$reactions_data_with_users[] = $reaction_data_cp;
		}

		return $reactions_data_with_users;
	}

	public static function bpverifiedmember_badge_get()
	{
		$badge = '';
		if ( class_exists( 'BuddyPress' ) ) {
			// only get settings if the plugin is active
			if (self::plugin_is_active('bp-verified-member')) {
				global $bp_verified_member;

				$badge = $bp_verified_member->get_verified_badge();
			}
		}

		return $badge;
	}

	public static function bpverifiedmember_user_is_verified($user_id)
	{
		global $bp_verified_member;

		return $bp_verified_member->is_user_verified($user_id);
	}

	public static function bpverifiedmember_settings_get($scope = 'all')
	{
		$settings = [];

		// only get settings if the plugin is active
		if (self::plugin_is_active('bp-verified-member')) {
			$settings = [
				'bp_verified_member_display_badge_in_profile_username' => get_option('bp_verified_member_display_badge_in_profile_username', 1) == 1,
				'bp_verified_member_display_badge_in_profile_fullname' => get_option('bp_verified_member_display_badge_in_profile_fullname', 0) == 1,
			];

			if ($scope === 'all' || $scope === 'activity') {
				$settings['bp_verified_member_display_badge_in_activity_stream'] = get_option('bp_verified_member_display_badge_in_activity_stream', 1) == 1;
			}

			if ($scope === 'all' || $scope === 'members') {
				$settings['bp_verified_member_display_badge_in_members_lists'] = get_option('bp_verified_member_display_badge_in_members_lists', 1) == 1;
			}

			if ($scope === 'all' || $scope === 'topics') {
				$settings['bp_verified_member_display_badge_in_bbp_topics'] = get_option('bp_verified_member_display_badge_in_bbp_topics', 1) == 1;
			}

			if ($scope === 'all' || $scope === 'replies') {
				$settings['bp_verified_member_display_badge_in_bbp_replies'] = get_option('bp_verified_member_display_badge_in_bbp_replies', 1) == 1;
			}

			if ($scope === 'all' || $scope === 'comments') {
				$settings['bp_verified_member_display_badge_in_wp_comments'] = get_option('bp_verified_member_display_badge_in_wp_comments', 1) == 1;
			}

			if ($scope === 'all' || $scope === 'posts') {
				$settings['bp_verified_member_display_badge_in_wp_posts'] = get_option('bp_verified_member_display_badge_in_wp_posts', 1) == 1;
			}
		}

		return $settings;
	}
}
