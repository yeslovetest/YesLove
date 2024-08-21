<?php
/**
 * This file can be overridden by copying it to yourtheme/elementor-custom/members/view-1.php
 *
 * @author  RadiusTheme
 * @since   1.0
 * @version 1.0
 */

namespace radiustheme\Cirkle_Core;

use radiustheme\cirkle\RDTheme;
use radiustheme\cirkle\Helper;

$mpp = $data['posts_per_page'];
if (class_exists('BuddyPress')) {
?>
<div class="team-circle">
    <?php
    // Setup args for querying members.

    $members_args = array(
        'user_id'         => 0,
        'type'            => '',
        'per_page'        => $mpp,
        'populate_extras' => true,
        'search_terms'    => false,
    );
    if (bp_has_members($members_args)) {
        global $members_template;
        $left_tabs = $right_tabs = $tab_contents = '';
        while (bp_members()) {
            bp_the_member();
            $member_id = 'member_' . $members_template->current_member;
            $tab_item = sprintf('<li class="nav-item">
                        <a class="nav-link%s" data-toggle="tab" href="#%s" role="tab" aria-selected="true">
                            %s
                        </a>
                    </li>',
                $members_template->current_member === 0 ? ' active' : '',
                $member_id,
                bp_get_member_avatar('type=full'),
            );
            $tab_contents .= sprintf('<div class="tab-pane fade%s" id="%s" role="tabpanel">
                            <div class="team-box">
                                <div class="item-img">%s</div>
                                <div class="item-content">
                                    <h3 class="item-title"><a href="%s">%s</a></h3>
                                    %s
                                </div>
                            </div>
                        </div>',
                $members_template->current_member === 0 ? ' show active' : '',
                $member_id,
                bp_get_member_avatar('type=full'),
                bp_get_member_permalink(),
                bp_get_member_name(),
                RDTheme::$options['profile_groups_tab'] != 0 || bp_is_active( 'groups' ) ? sprintf('<div class="group-count"><a href="%s"><span>%s</span> - %s</a></div>', 
                    bp_get_member_permalink() . bp_get_groups_slug() . '/my-groups/',
                    bp_get_total_group_count_for_user( bp_get_member_user_id() ),
                    esc_html__( 'Groups', 'cirkle-core' )
                ): ""
            );
            if ($members_template->current_member <= 2) {
                $left_tabs .= $tab_item;
            } else {
                $right_tabs .= $tab_item;
            }
        }

        ?>
        <div class="row no-gutters">
            <div class="col-lg-4 col-sm-6">
                <ul class="nav nav-tabs nav-tabs-left" role="tablist">
                    <?php echo wp_kses_post($left_tabs); ?>
                </ul>
            </div>
            <?php if ($right_tabs): ?>
                <div class="col-lg-4 col-sm-6 order-lg-3">
                    <ul class="nav nav-tabs nav-tabs-right" role="tablist">
                        <?php echo wp_kses_post($right_tabs); ?>
                    </ul>
                </div>
            <?php endif; ?>
            <div class="col-lg-4 order-lg-2">
                <div class="tab-content">
                    <?php echo wp_kses_post( $tab_contents ); ?>
                </div>
            </div>
        </div>
        <?php if (is_array($data['rt_anim_shape'])) { ?>
        <ul class="shape-wrap">
            <?php foreach ( $data['rt_anim_shape'] as $index => $item ) { ?>
            <li><img src="<?php echo esc_url( $item['shape_image']['url'] ); ?>" alt="<?php esc_attr_e( 'shape', 'cirkle' ); ?>"></li>
            <?php } ?>
        </ul>
        <?php }
    } else { ?>
        <div class="widget-error">
            <?php esc_html_e('No one has signed up yet!', 'buddypress'); ?>
        </div>
    <?php } ?>
</div>
<?php } ?>

