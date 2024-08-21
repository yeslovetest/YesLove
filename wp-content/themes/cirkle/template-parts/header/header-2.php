<?php
/**
 * @author  RadiusTheme
 * @since   1.0
 * @version 1.0
 */
namespace radiustheme\cirkle;
use radiustheme\cirkle\RDTheme;
use radiustheme\cirkle\Helper;
$nav_menu_args   = Helper::nav_menu_args();

$fixed_header = RDTheme::$options['fixed_header'];
if (!empty($fixed_header)) {
  $fixed = 'fixed-header-fixed';
} else {
  $fixed = 'fixed-header-not-fixed';
}

$menu_btn = RDTheme::$options['header_search'] || RDTheme::$options['header_social'] || RDTheme::$options['header_link'] || RDTheme::$options['header_cart'] || RDTheme::$options['header_friend'] || RDTheme::$options['header_message'] || RDTheme::$options['header_notification'] ? true : false;

$cart = RDTheme::$options['header_cart'] && class_exists( 'WooCommerce' ) ? true : false;

$friend = RDTheme::$options['header_friend'] && is_user_logged_in() && RDTheme::$options['profile_friends_tab'] ? true : false;

$message = RDTheme::$options['header_message'] && is_user_logged_in() && RDTheme::$options['profile_message_tab'] ? true : false;

$notification = RDTheme::$options['header_notification'] && is_user_logged_in() ? true : false;
$profile = RDTheme::$options['header_profile'] && is_user_logged_in() ? true : false;
$menu_btn2 = $cart || $friend || $message || $notification ? true : false;

?>
<header class="fixed-header <?php echo esc_attr( $fixed ); ?>">
  <div class="header-menu menu-layout2">
      <div class="navbar">
          <div class="nav-item d-sm-block">
            <div class="header-logo">
              <?php get_template_part( 'template-parts/header/logo', 'light' ); ?>
            </div>
          </div>
          <div class="nav-item nav-top-menu">
              <nav id="dropdown" class="template-main-menu">
                <?php wp_nav_menu( $nav_menu_args ); ?>
              </nav>
          </div>
          <?php if (!empty($menu_btn == true)){ ?>
          <div class="nav-item header-control">
              <?php if (!empty(RDTheme::$options['header_search'])) { ?>
              <div class="inline-item d-none d-md-block">
                <?php get_template_part( 'template-parts/header/header-search2' ); ?>
              </div>
              <?php } if (!empty($menu_btn2 == true)) { ?>
              <div class="inline-item d-flex align-items-center">
                <?php if ( $cart == true ) {
                  get_template_part( 'template-parts/header/woo', 'minicart' );
                } 
                if ( class_exists( 'BuddyPress' ) ) {
                  if ( $friend == true ) {
                    get_template_part( 'template-parts/header/friends', 'request' );
                  } if ( $message == true ) {
                    get_template_part( 'template-parts/header/messages' );
                  } if ( $notification == true ) {
                    get_template_part( 'template-parts/header/notifications' );
                  } 
                }
                ?>
              </div>
              <?php } if ( $profile == true ) { 
                  if ( class_exists( 'BuddyPress' ) ) {
                ?>
              <div class="inline-item logged-user">
                <?php get_template_part( 'template-parts/header/logged-user' ); ?>
              </div>
              <?php }
              } else { ?>
              <div class="inline-item header2-login">
                <?php get_template_part( 'template-parts/header/header-link' ); ?>
              </div>
              <?php } ?>
              <?php get_template_part('template-parts/header/mobile', 'menu'); ?>
          </div>
          <?php } ?>
      </div>
  </div>
</header>