<?php
/**
 * @author  RadiusTheme
 * @since   1.0
 * @version 1.0
 */

namespace radiustheme\cirkle;
use radiustheme\cirkle\RDTheme;
use radiustheme\cirkle\Helper;
use WP_Query;

trait CustomQueryTrait {

  static function generate_array_iterator_postfix( $array, $index, $postfix = ', ' ) {
    $length = count($array);
    if ($length) {
      $last_index = $length - 1;
      return $index < $last_index ? $postfix : '';
    }
  }

  public static function wp_set_temp_query( $query ){
    global $wp_query;
    $temp = $wp_query;
    $wp_query = $query;
    return $temp;
  }

  public static function wp_reset_temp_query( $temp ){
    global $wp_query;
    $wp_query = $temp;
    wp_reset_postdata();
  }

  public static function set_order_orderby($rd_field){
    $orderby = '';
    $order   = 'DESC';
    switch ( RDTheme::$options[ $rd_field ] ) {
      case 'title':
      case 'menu_order':
      $orderby = RDTheme::$options[ $rd_field ];
      $order = 'ASC';
      break;
    }
    if ( $orderby ) {
      $args['orderby'] = $orderby;
      $args['order'] = $order;
    }
    return $args;
  } 

  public static function set_args_orderby( $args, $rd_field ){
    $orderby = '';
    $order   = 'DESC';
    switch ( RDTheme::$options[ $rd_field ] ) {
      case 'title':
      case 'menu_order':
      $orderby = RDTheme::$options[ $rd_field ];
      $order = 'ASC';
      break;
    }
    if ( $orderby ) {
      $args['orderby'] = $orderby;
      $args['order'] = $order;
    }
    return $args;
  }

  /**
   * for setting up pagination for custom post type
   * we have to pass paged key
   */
  public static function set_args_paged ($args) {
    if ( get_query_var('paged') ) {
      $args['paged'] = get_query_var('paged');
    }
    elseif ( get_query_var('page') ) {
      $args['paged'] = get_query_var('page');
    }
    else {
      $args['paged'] = 1;
    }
    return $args;
  }

}
