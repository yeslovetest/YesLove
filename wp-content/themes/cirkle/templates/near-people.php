<?php
/**
 * Template Name: Near People Search List
 */

use radiustheme\cirkle\Helper;

get_header();

    $country = '';
    if (isset($_GET['user_country'])){
        $country = sanitize_text_field( $_GET['user_country'] );
    }
    $state = '';
    if (isset($_GET['user_state'])) {
        $state = sanitize_text_field( $_GET['user_state'] );
    }
    $args['meta_query'][] = array(
        'key' => 'user_country',
        'value' => $country,
        'compare' => "="
    );
    if (!empty($state)) {
        $args['meta_query'][] = array(
            'key' => 'user_state',
            'value' => $state,
            'compare' => "="
        );
    }
    $users = new WP_User_Query( $args );
    $users = $users->get_results(); 

?>

<!-- search-result-area -->
<section class="near-people-search-result-area bg-link-water">
    <div class="container">
        <div class="row justify-content-center">
            <?php if ($users) {
                foreach ($users as $user) {
            ?> 
            <div class="col-xl-4">
                <div class="widget-author user-group">
                    <div class="author-heading">
                        <?php 
                            $dir = 'members';
                            $user_id = $user->ID;
                            Helper::banner_img( $user_id, $dir ); 
                        ?>
                        <div class="profile-img">
                            <a href="<?php echo bp_core_get_user_domain( $user->ID ); ?>">
                                <?php echo bp_core_fetch_avatar ( array( 'item_id' => $user->ID, 'type' => 'full' ) ) ; ?>
                            </a>
                        </div>
                        <div class="profile-name">
                            <h4 class="author-name"><a href="<?php echo bp_core_get_user_domain( $user->ID ); ?>"><?php echo esc_html( $user->display_name); ?></a></h4>
                            <div class="author-location"><?php echo xprofile_get_field_data( 'Shorttext', get_the_author_meta( 'ID' )) ?></div>
                        </div>
                    </div>
                    <?php 
                        $members_args = array(
                            'user_id'         => absint( $user->ID ),
                            'type'            => 'active',
                            'max'             => 5,
                            'populate_extras' => 1,
                        );
                    if ( bp_has_members( $members_args ) ) : ?>
                    <ul class="member-thumb">
                        <?php while ( bp_members() ) : bp_the_member(); ?>
                        <li><a href="<?php bp_member_permalink(); ?>"><?php bp_member_avatar(); ?></a></li>
                        <?php endwhile; ?>
                        <?php if ( friends_get_total_friend_count( $user->ID ) > 5 ) { ?>
                        <li><a href="<?php echo bp_core_get_user_domain( $user->ID ).'friends'; ?>"><i class="icofont-plus"></i></a></li>
                        <?php } ?>
                    </ul>
                    <?php endif; ?>
                    <ul class="author-statistics">
                        <li>
                            <a href="<?php echo bp_core_get_user_domain( $user->ID ); ?>"><span class="item-number"><?php echo Helper::cirkle_user_post_count( $user->ID ); ?></span> <span class="item-text"><?php esc_html_e( 'Posts', 'cirkle' ); ?></span></a>
                        </li>
                        <li>
                            <a href="<?php echo bp_core_get_user_domain( $user->ID ); ?>"><span class="item-number"><?php echo Helper::cirkle_count_user_comments( $user->ID ); ?></span> <span class="item-text"><?php esc_html_e( 'Comments', 'cirkle' ); ?></span></a>
                        </li>
                    </ul>
                </div>
            </div>
            <?php } } else {
                echo 'no users found';
            } ?>
        </div>
    </div>
</section>
<!-- search-result-area-end -->

<?php get_footer(); ?>