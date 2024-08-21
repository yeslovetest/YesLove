<?php
/**
 * This file can be overridden by copying it to yourtheme/elementor-custom/posts/view-1.php
 * 
 * @author  RadiusTheme
 * @since   1.0
 * @version 1.0
 */

namespace radiustheme\Cirkle_Core;
use radiustheme\cirkle\Helper;
extract( $data );

$post_meta = $data['post_admin'] || $data['post_date'] ? true : false;

$cols = $data['cols'];
$pcom = $data['post_comments'];
$pdate = $data['post_date'];
$pcats = $data['post_cat'];
$preact = $data['post_react'];

$excerpt_length = $data['excerpt'];

$post_id = get_the_ID();

$comments_html   = '';  
$comments_number = number_format_i18n( get_comments_number($post_id) );
$comments_html  .= $comments_number < 10 && $comments_number > 0 ? '0'.$comments_number : $comments_number;

$has_entry_meta = ( $pdate || $preact || $pcom ) ? true : false;

if ( $has_entry_meta == true ) {
    $metas = 'meta-true';
} else {
    $metas = 'meta-false';
}

$like  = CIRKLE_BANNER_DUMMY_IMG.'reaction/1.png';
$love  = CIRKLE_BANNER_DUMMY_IMG.'reaction/2.png';
$love2 = CIRKLE_BANNER_DUMMY_IMG.'reaction/3.png';
$laugh = CIRKLE_BANNER_DUMMY_IMG.'reaction/4.png';
$amz   = CIRKLE_BANNER_DUMMY_IMG.'reaction/5.png';
$wipe  = CIRKLE_BANNER_DUMMY_IMG.'reaction/6.png';
$anger = CIRKLE_BANNER_DUMMY_IMG.'reaction/7.png';

// $grid_query= null;
// $args = array(
//   'post_type'      => 'post',
//   'post_status'    => 'publish',
//   'posts_per_page' => $data['number'],
//   'offset'         => $data['post_offset'],
// );

$grid_query= null;
if ( $query_type == 'cats' && !empty( $postbycats ) ) {
    $args = array(
        'post_type'      => 'post',
        'post_status'    => 'publish',
        'posts_per_page' => $number,
        'orderby'        => $orderby,
        'tax_query' => array(
            array(
                'taxonomy' => 'category',
                'field' => 'id',
                'terms' => $postbycats
            )
        ),
    );
} elseif ( $query_type == 'titles' && !empty( $postbytitle ) ) {
    $args = array(
        'post_type'      => 'post',
        'post_status'    => 'publish',
        'posts_per_page' => $number,
        'orderby'        => $orderby,
        'taxonomy'       => 'category',
        'post__in'       => $postbytitle
    );
} else {
    $args = array(
        'post_type'      => 'post',
        'post_status'    => 'publish',
        'posts_per_page' => $number,
        'orderby'        => $orderby,
        'offset'         => $post_offset,
        'taxonomy'       => 'category'
    );
}

 
$grid_query = new \WP_Query( $args );

if ( $grid_query->have_posts() ): 

?>

<div class="row">
  <?php 
    while ( $grid_query->have_posts() ) : $grid_query->the_post(); 
      $post_id = get_the_ID();
      if ( has_post_thumbnail() ){
        $thumb_img = '';
      } else {
        $thumb_img = 'no-image';
      }
  ?>
  <div class="col-xl-<?php echo esc_attr( $cols ); ?> col-md-6">
    <article id="post-<?php the_ID(); ?>" <?php post_class( 'block-box user-blog' ); ?>>
      <?php if ( has_post_thumbnail() ): ?>
      <div class="blog-img">
          <a href="<?php the_permalink(); ?>"><?php the_post_thumbnail('cirkle-size-1'); ?></a>
      </div>
      <?php endif; ?>
      <div class="blog-content <?php echo esc_attr ( $metas ); ?>">
          <?php if ( $pcats && has_category() ){ ?>
          <div class="blog-category">
              <?php the_category( ', ' ); ?>
          </div>
          <?php } ?>
          <h3 class="blog-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
          <?php if ( $pdate ){ ?>
          <div class="blog-date"><i class="icofont-calendar"></i> <?php the_time( get_option( 'date_format' ) ); ?> </div>
          <?php } ?>
          <p><?php echo Helper::cirkle_excerpt( $excerpt_length ); ?></p>
      </div>
      <?php if ( $has_entry_meta ){ ?>
      <div class="blog-meta">
          <ul>
              <?php if ( $preact ){ ?>
              <li class="blog-reaction">
                  <div class="reaction-icon">
                      <img src="<?php echo esc_url( $like ); ?>" alt="icon">
                      <img src="<?php echo esc_url( $laugh ); ?>" alt="icon">
                      <img src="<?php echo esc_url( $love ); ?>" alt="icon">
                  </div>
                  <div class="meta-text">+ 15 others</div>
              </li>
              <?php } if ( $pcom ){ ?>
              <li><i class="icofont-comment"></i> <?php echo wp_kses_post( $comments_html ); ?> </li>
              <?php } ?>
          </ul>
      </div>
      <?php } if ( is_sticky() ) {
          echo '<sup class="meta-featured-post"> <i class="fas fa-thumbtack"></i> ' . esc_html__( 'Sticky', 'cirkle' ) . ' </sup>';
      } ?>
  </article>
  </div>
  <?php endwhile; wp_reset_postdata(); ?> 
</div>
<?php endif; ?>


