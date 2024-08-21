<?php

namespace radiustheme\cirkle;
use radiustheme\cirkle\RDTheme;
trait DataTrait {

  public static function cirkle_get_post_meta( $post_id, $padmin, $pdate, $pcom, $pcats, $adminpic ) { 
      $post_meta_holder= "";
      $comments_number = get_comments_number($post_id);
      $comments_text   = sprintf( _n( '%s Comment', '%s Comments', $comments_number, 'cirkle' ), number_format_i18n( $comments_number ) );

      $post_meta  = $padmin || $pdate || $pcom || $pshare ? true : false;

      if ( $post_meta ){
    ?>
      <ul class="entry-meta">
        <?php if ( $padmin ){ ?>
          <li>
            <?php 
            if ( $adminpic == 'icon' ) {
              echo '<i class="icofont-user-suited"></i>';
            } else {
              if (Helper::plugin_is_active('buddypress')) {
                echo bp_core_fetch_avatar ( array( 'item_id' => get_the_author_meta( 'ID' ), 'type' => 'full' ) ) ;
              } else { 
                echo get_avatar( get_the_author_meta( 'ID' ), 'full' );
              }
            }
            ?>
            <?php esc_html_e( 'By ', 'cirkle' ); ?><a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) ); ?>"><?php the_author(); ?></a>
          </li>
        <?php } if ( $pdate ){ ?>
          <li><i class="icofont-calendar"></i> <?php the_time( get_option( 'date_format' ) ); ?> </li>
        <?php } if ( $pcom ){ ?>
          <li><i class="icofont-comment"></i> <?php echo wp_kses_stripslashes( $comments_text ); ?> </li>
        <?php } if ( $pcats && has_category() ){ ?>
          <li><i class="icofont-tag"></i> <?php the_category( ', ' ); ?></li>
        <?php } ?>
      </ul>
    <?php }
    return $post_meta_holder;
  }

  public static function cirkle_get_attach_img( $img_id, $size ) {
    $attach_img = '';
    if (!empty( $img_id )) {
      $attach_img = wp_get_attachment_image( $img_id, $size );
    } else {
      $attach_img = '';
    }
    return $attach_img;
  }

  public static function socials(){
    $rdtheme_socials = array(
      'social_facebook' => array(
        'icon' => 'icofont-facebook',
        'url'  => RDTheme::$options['social_facebook'],
      ),
      'social_twitter' => array(
        'icon' => 'icofont-twitter',
        'url'  => RDTheme::$options['social_twitter'],
      ),     
      'social_linkedin' => array(
        'icon' => 'icofont-linkedin',
        'url'  => RDTheme::$options['social_linkedin'],
      ),
      'social_youtube' => array(
        'icon' => 'icofont-youtube',
        'url'  => RDTheme::$options['social_youtube'],
      ),
      'social_pinterest' => array(
        'icon' => 'icofont-pinterest',
        'url'  => RDTheme::$options['social_pinterest'],
      ),
      'social_instagram' => array(
        'icon' => 'icofont-instagram',
        'url'  => RDTheme::$options['social_instagram'],
      ),
      
    );
    return array_filter( $rdtheme_socials, array( __CLASS__ , 'filter_social' ) );
  } 

  public static function filter_social( $args ){
    return ( $args['url'] != '' );
  }


  /*----------------------------------------------------------------------------------------*/
  /*  Search Form Call Function
  /*----------------------------------------------------------------------------------------*/
  public static function goto_template_name( $name = 'templates/near-people.php' ){
      $url = '#';
      $q = new \WP_Query( array(
          'post_type' => 'page',
          'meta_key'  => '_wp_page_template',
          'meta_value'=> $name
      ));

      if( $q->have_posts() ){
          while( $q->have_posts() ):
              $q->the_post();
              $url = get_the_permalink( get_the_ID() );
          endwhile;
      }
      
      return $url;
  }

  public static function hex2rgb($hex) {
    $hex = str_replace("#", "", $hex);
    if(strlen($hex) == 3) {
      $r = hexdec(substr($hex,0,1).substr($hex,0,1));
      $g = hexdec(substr($hex,1,1).substr($hex,1,1));
      $b = hexdec(substr($hex,2,1).substr($hex,2,1));
    } else {
      $r = hexdec(substr($hex,0,2));
      $g = hexdec(substr($hex,2,2));
      $b = hexdec(substr($hex,4,2));
    }
    $rgb = "$r, $g, $b";
    return $rgb;
  }

}