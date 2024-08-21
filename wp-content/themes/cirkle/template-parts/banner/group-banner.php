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

    global $bp;
    $bg_url = $args['bg_url'];
    $admin_id = $args['admin_id'];
    $gid = bp_get_group_id();

?>

<!-- Banner Area Start -->
<div class="banner-user banner-user-group" style="background-image: url(<?php echo esc_url( $bg_url ); ?>);">
    <div class="banner-content">
        <div class="media">
            <div class="item-img">
                <?php bp_group_avatar(); ?>
            </div>
            <div class="media-body">
                <h3 class="item-title"><?php echo esc_html( bp_get_group_name() ); ?></h3>
                <div class="item-subtitle"><?php echo bp_core_get_userlink( $admin_id ); ?></div>
                <?php if (RDTheme::$options['group_btn_profile']) { ?>
                <div class="group-btn">
                    <?php echo bp_group_join_button(); ?>
                </div>
                <?php } ?>
                <ul class="user-meta">
                    <li><?php esc_html_e( 'Group Type: ', 'cirkle' ); ?><span><?php bp_group_type(); ?></span></li>
                    <li>
                        <?php
                            printf( _nx( 'Members <span class="item-number">%d</span>', 'Members: <span class="item-number">%d</span>', bp_get_group_total_members( false ),'Group member count', 'cirkle' ), bp_get_group_total_members( false )  );
                        ?>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>