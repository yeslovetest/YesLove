<?php
/**
 * This file can be overridden by copying it to yourtheme/elementor-custom/title/view-1.php
 *
 * @author  RadiusTheme
 * @since   1.0
 * @version 1.0
 */

use radiustheme\cirkle\RDTheme;
use radiustheme\cirkle\Helper;

$mpp = $data['posts_per_page'];


if (function_exists('bp_has_groups') && class_exists('BuddyPress')) {
    $group_args = array(
        'type'            => 'popular',
        'per_page'        => $mpp,
        'max'             => $mpp,
    );

    if ( bp_has_groups( $group_args ) ) :
?>

    <div class="groups-popular">
        <div class="row gutters-15 justify-content-center">
            <?php while ( bp_groups() ) : bp_the_group(); ?>
            <div class="col-lg-3 col-md-4 col-sm-6">
                <div class="groups-box">
                    <div class="item-img">
                        <?php 
                            $bg_url = bp_attachments_get_attachment('url', array(
                                'object_dir' => 'groups',
                                'item_id' => bp_get_group_id(),
                            ));

                            if (empty($bg_url)) {
                                $bg_url = CIRKLE_BANNER_DUMMY_IMG.'dummy-banner.jpg';
                            } else {
                                $bg_url = $bg_url;
                            }
                            
                        ?>
                        <img src="<?php echo esc_url( $bg_url ); ?>" alt="cover">
                    </div>
                    <div class="item-content">
                        <h3 class="item-title"><?php bp_group_link(); ?></h3>
                        <div class="groups-member">
                            <?php
                            printf( _nx( '<span class="item-number">%d</span> <span class="item-text">Member</span>', '<span class="item-number">%d</span> <span class="item-text"> Members</span>', bp_get_group_total_members( false ),'Group member count', 'cirkle' ), bp_get_group_total_members( false )  );
                            ?>
                        </div>
                    </div>
                </div>
            </div>
            <?php endwhile; ?>
        </div>
        <?php else: ?>
            <p><?php esc_html_e( 'There have no groups', 'cirkle' ); ?></p>
        <?php endif; ?>
    </div>

<?php } ?>
