<?php
/**
 * Cirkle Template - BuddyPress Profile Banner
 * 
 * @package Cirkle
 * @since 1.0.0
 * @author RadiusTheme (https://www.radiustheme.com/)
 * 
 */
use radiustheme\cirkle\BuddyPress_Setup;
use radiustheme\cirkle\RDTheme;
use radiustheme\cirkle\Helper;

// add BuddyPress member stats data if plugin is active
if (Helper::cirkle_plugin_is_active('buddypress')) {
    $user_id = $args['user_id'];
    $bg_url = $args['section_bg_url'];
}
if (empty($bg_url)) {
    $bg_url = CIRKLE_BANNER_DUMMY_IMG.'dummy-banner.jpg';
} else {
    $bg_url = $bg_url;
}

$separator = $country = $state = '';
$address = BuddyPress_Setup::userAddress($user_id);
$country = $address['country'];
$state = $address['state'];

if (!empty(xprofile_get_field_data('Shorttext', get_the_author_meta('ID')) && $state)) {
    $separator = ', ';
}
?>

<!-- Banner Area Start -->
<div class="banner-user" style="background-image: url(<?php echo esc_url($bg_url); ?>);">
    <div class="banner-content">
        <div class="media">
            <?php if ($user_id) { ?>
            <div class="item-img">
                <a href="<?php bp_displayed_user_link(); ?>">
                  <?php bp_displayed_user_avatar('type=full'); ?>
                </a>
            </div>
            <div class="media-body">
                <h3 class="item-title">
                    <?php bp_displayed_user_fullname(); ?>                   
                </h3>
                <div class="item-subtitle">
                    <?php 
                        echo xprofile_get_field_data('Shorttext', get_the_author_meta('ID'));
                        if (!empty($state)) {
                            echo ' '.$state;
                        }
                        if (!empty($country)) {
                            echo ', '.$country.'.';
                        }
                    ?>
                </div>
                <?php Helper::cirkle_member_social_socials_info($user_id); ?>
                <ul class="user-meta">
                    <li><?php esc_html_e('Posts:', 'cirkle'); ?><span><?php echo Helper::cirkle_user_post_count($user_id); ?></span></li>
                    <li><?php 
                        $count = Helper::cirkle_count_user_comments($user_id);
                        printf(_n('Comment: <span>%s</span>', 'Comments <span>%s</span>', $count, 'cirkle'), number_format_i18n($count));
                    ?></li>
                    <li><?php esc_html_e('Views:', 'cirkle'); ?> <span><?php echo Helper::cirkle_get_postviews($user_id); ?></span></li>
                </ul>
                <?php
                    if (function_exists('bp_add_friend_button')) {
                        $is_friend = bp_is_friend($user_id);
                        if ($is_friend) {
                            bp_add_friend_button($user_id);
                        }
                    }
                ?>
            </div>
            <?php } ?>
        </div>
    </div>
</div>