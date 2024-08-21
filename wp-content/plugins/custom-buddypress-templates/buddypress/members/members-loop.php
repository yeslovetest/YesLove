<?php
/**
 * BuddyPress - Members Loop
 *
 * @package Cirkle
 * @since 1.0.2
 * @author RadiusTheme (https://www.radiustheme.com/)
 *
 */

use radiustheme\cirkle\RDTheme;
use radiustheme\cirkle\Helper;

if (function_exists('bp_get_total_site_member_count')) {
    $member_count = bp_get_total_site_member_count();
} else {
    $member_count = 0;
}
$mpp = RDTheme::$options['member_per_page'];

do_action('bp_before_members_loop');
?>

<?php if (bp_get_current_member_type()) : ?>
    <p class="current-member-type"><?php bp_current_member_type_message(); ?></p>
<?php endif; ?>

<?php
$listing_option = get_option('buddypress_templates_listing_option', 'all_members');

if ($listing_option === 'professionals_only') {
    $member_args = array(
        'member_type' => array('professionals'),
        'per_page'    => $mpp,
    );
} elseif ($listing_option === 'verified_professionals') {
    $member_args = array(
        'member_type'   => array('professionals'),
        'per_page'      => $mpp,
        'meta_query'    => array(
            array(
                'key'     => 'bp_verified_member',
                'value'   => 1,
                'compare' => '=',
            ),
        ),
    );
} else {
    $member_args = array(
        'per_page' => $mpp,
    );
}

if (bp_has_members($member_args)) : ?>

    <?php do_action('bp_before_directory_members_list'); ?>

    <ul id="cirkle-members-list" class="item-list" aria-live="assertive" aria-relevant="all">
        <?php while (bp_members()) : bp_the_member();
            $user_id = bp_get_member_user_id();
            $verified = get_user_meta($user_id, 'bp_verified_member', true);
            if ($listing_option === 'all_members' ||
                ($listing_option === 'professionals_only' && bp_get_member_type(bp_get_member_user_id()) === 'professionals') ||
                ($listing_option === 'verified_professionals' && bp_get_member_type(bp_get_member_user_id()) === 'professionals' && $verified == 1)) :
        ?>
            <li <?php bp_member_class(array('user-list-view', 'forum-member')); ?>>
                <div class="widget-author block-box">
                    <div class="author-heading">
                        <?php
                        $dir     = 'members';
                        Helper::banner_img($user_id, $dir);
                        ?>
                        <div class="profile-img">
                            <a href="<?php bp_member_permalink(); ?>">
                                <?php bp_member_avatar('type=full'); ?>
                            </a>
                        </div>
                        <div class="profile-name">
                            <h5 class="author-name <?php echo Helper::cirkle_is_user_online($user_id); ?>">
                                <a href="<?php bp_member_permalink(); ?>"><?php bp_member_name(); ?></a>
                                <?php echo Helper::cirkle_get_verified_badge($user_id); ?>
                            </h5>
                            <div class="author-location">
                                <span class="activity" data-livestamp="<?php bp_core_iso8601_date(bp_get_member_last_active(array('relative' => false))); ?>">
                                    <?php bp_member_last_active(); ?>
                                </span>
                            </div>
                        </div>
                        <div class="author-bio">
                            <?php
                            $bio = xprofile_get_field_data('bio', $user_id);
                            if (!empty($bio)) {
                                echo esc_html($bio);
                            } else {
                                echo esc_html__('Bio not available', 'cirkle');
                            }
                            ?>
                        </div>
                    </div>
                    <!-- action hook -->
                </div>
            </li>
        <?php
            endif;
        endwhile;
        ?>

    </ul>

    <?php do_action('bp_after_directory_members_list'); ?>

    <?php bp_member_hidden_fields(); ?>
    <?php if ($member_count > $mpp) : ?>
        <div id="pag-bottom" class="pagination">
            <div class="pagination-links" id="member-dir-pag-bottom">
                <?php bp_members_pagination_links(); ?>
            </div>
        </div>
    <?php endif; ?>

<?php else : ?>

    <div id="message" class="info">
        <p><?php esc_html_e('Sorry, no members were found.', 'cirkle'); ?></p>
    </div>

<?php endif; ?>

<?php do_action('bp_after_members_loop'); ?>