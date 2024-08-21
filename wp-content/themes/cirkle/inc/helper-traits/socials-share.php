<?php
/**
 * @author  RadiusTheme
 * @since   1.0
 * @version 1.0
 */

namespace radiustheme\cirkle;
use radiustheme\cirkle\RDTheme;

trait SocialShares {

  public static $sharers = [];
  public static $defaults = [];

  /**
   * generate all social share options
   * @return [type] [description]
   */
  public static function generate_defults() {
    $url   = urlencode( get_permalink() );
    $title = urlencode( get_the_title() );
    $defaults = [
      'facebook' => [
        'url'  => "http://www.facebook.com/sharer.php?u=$url",
        'icon' => 'icofont-facebook',
        'class' => 'bg-fb',
      ],
      'twitter'  => [
        'url'  => "https://twitter.com/intent/tweet?source=$url&text=$title:$url",
        'icon' => 'icofont-twitter',
        'class' => 'bg-twitter',
      ],
      'linkedin' => [
        'url'  => "http://www.linkedin.com/shareArticle?mini=true&url=$url&title=$title",
        'icon' => 'icofont-linkedin',
        'class' => 'bg-linkedin',
      ],
      'pinterest'=> [
        'url'  => "http://pinterest.com/pin/create/button/?url=$url&description=$title",
        'icon' => 'icofont-pinterest',
        'class' => 'bg-pinterest',
      ],
    ];
    self::$defaults = $defaults;
  }

  public static function filter_defaults(){
    foreach ( self::$defaults as $key => $value ) {
      if ( !$value ) {
        unset( $defaults[$key] );
      }
    }
    self::$sharers = apply_filters( 'rdtheme_social_sharing_icons', self::$defaults );
  }

  public static function render(){
    self::generate_defults();
    self::filter_defaults();
  ?> 
  <ul class="blog-share">
    <?php foreach ( self::$sharers as $key => $sharer ): ?>
      <li><a href="<?php echo esc_attr( $sharer['url'] ); ?>" class="<?php echo esc_attr( $sharer['class'] ); ?>"><i class="<?php echo esc_attr( $sharer['icon'] ); ?>"></i></a></li>
    <?php endforeach ?>
  </ul>
   <?php
  }

  public static function render2(){
    self::generate_defults();
    self::filter_defaults();
  ?> 
  <ul class="share-list">
    <?php foreach ( self::$sharers as $key => $sharer ): ?>
      <li><a href="<?php echo esc_attr( $sharer['url'] ); ?>" class="<?php echo esc_attr( $sharer['class'] ); ?>"><i class="<?php echo esc_attr( $sharer['icon'] ); ?>"></i></a></li>
    <?php endforeach ?>
  </ul>

   <?php
  }



}




