<?php
/**
 * @author  RadiusTheme
 * @since   1.0
 * @version 1.0.2
 */

namespace radiustheme\cirkle;
use radiustheme\cirkle\RDTheme;

trait LayoutTrait {
  public static function has_sidebar() {
    return ( self::has_full_width() ) ? false : true;
  }

  /**
   * It will determine whether content will take full width or not 
   * this is determine by 2 parameters - redux theme option and active sidebar
   * @return boolean [description]
   */
  public static function has_full_width() {
    $theme_option_full_width = ( RDTheme::$layout == 'full-width' ) ? true : false;

    if ( is_page( 'members' ) && ! is_active_sidebar( 'member-widgets' ) ) {
      $not_active_sidebar = ! is_active_sidebar( 'member-widgets' );
    } elseif ( class_exists( 'bbPress' ) && is_bbpress() && ! is_active_sidebar( 'bbpress-widgets' ) ) {
      $not_active_sidebar = ! is_active_sidebar( 'bbpress-widgets' );
    } elseif ( class_exists( 'WooCommerce' ) && ! is_active_sidebar( 'woo-sidebar' ) ) {
      if ( is_product() && RDTheme::$layout = 'full-width' ) {
        $not_active_sidebar = ! is_active_sidebar( 'woo-sidebar' ); 
      } else if ( is_shop() && RDTheme::$layout = 'full-width' ) {
        $not_active_sidebar = ! is_active_sidebar( 'woo-sidebar' ); 
      }
    } else {
      $not_active_sidebar = ! is_active_sidebar( 'sidebar' );
    }

    $bool = $theme_option_full_width || $not_active_sidebar;

    return  $bool;
  }

  public static function the_layout_class() {
    if (Helper::cirkle_plugin_is_active('buddypress') && Helper::cirkle_plugin_is_active('bbpress')) {
      if ( bp_is_group_single() && is_active_sidebar( 'group-widgets' )) {
        $layout_class = 'col-xl-8';
      } elseif ( bp_is_user_groups() && !bp_is_group_single() ) {
        $layout_class = 'col-xl-12';
      } elseif ( bp_is_current_component( 'photos' )) {
        $layout_class = 'col-xl-12';
      } elseif ( bp_is_current_component( 'videos' )) {
        $layout_class = 'col-xl-12';
      } elseif ( bp_is_current_component( 'badges' )) {
        $layout_class = 'col-xl-12';
      } elseif ( bp_is_user() && is_active_sidebar('profile-widgets')) {
        $layout_class = 'col-xl-8';
      } elseif ( bp_is_activity_component('activity') && is_active_sidebar('profile-widgets')) {
        $layout_class = 'col-xl-8';
      } elseif ( is_bbpress() && is_active_sidebar('bbpress-widgets') ) {
        $layout_class = 'col-xl-8';
      } elseif (bp_is_groups_component()) {
        $layout_class = 'col-xl-12';
      } elseif ( is_page( 'members' ) && is_active_sidebar('member-widgets')) {
        $layout_class = 'col-xl-8';
      } else {
        $layout_class = self::has_sidebar() ? 'col-xl-8' : 'col-12';
      }
    } else {
      $layout_class = self::has_sidebar() ? 'col-xl-8' : 'col-12';
    }

    if ( RDTheme::$layout == 'right-sidebar' ) {
      $layout_class = $layout_class.' order-xl-1';
    } elseif ( RDTheme::$layout == 'left-sidebar' ) {
      $layout_class = $layout_class.' order-xl-2';
    } else {
      $layout_class = $layout_class;
    }

    echo apply_filters( 'cirkle_layout_class', $layout_class );
  }

  public static function the_sidebar_class() {
    if (Helper::cirkle_plugin_is_active('buddypress')) {
      if ( is_page( 'members' ) && is_active_sidebar('member-widgets') ) {
        if ( RDTheme::$layout == 'right-sidebar' ) {
          echo apply_filters( 'rt_sidebar_class', 'col-xl-4 order-xl-2' );
        } else {
          echo apply_filters( 'rt_sidebar_class', 'col-xl-4 order-xl-1' );
        }
      } else {
        if ( RDTheme::$layout == 'right-sidebar' ) {
          echo apply_filters( 'rt_sidebar_class', 'col-xl-4 order-xl-2' );
        } else {
          echo apply_filters( 'rt_sidebar_class', 'col-xl-4 order-xl-1' );
        }
      }
    } else {
      if ( RDTheme::$layout == 'right-sidebar' ) {
        echo apply_filters( 'rt_sidebar_class', 'col-xl-4 order-xl-2' );
      } else {
        echo apply_filters( 'rt_sidebar_class', 'col-xl-4 order-xl-1' );
      }
    }
  }

  public static function cirkle_sidebar() {
    if ( RDTheme::$layout == 'right-sidebar' || RDTheme::$layout == 'left-sidebar' && ! self::has_full_width() ) {
      get_sidebar();
    }
  }
}
