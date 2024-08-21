<?php
/**
 * This file can be overridden by copying it to yourtheme/elementor-custom/posts/view-2.php
 * 
 * @author  RadiusTheme
 * @since   1.0
 * @version 1.0
 */

namespace radiustheme\Cirkle_Core;
use radiustheme\cirkle\Helper;
extract( $data );

$post_meta = $data['post_admin'] || $data['post_date'] ? true : false;
$excerpt = $data['excerpt'];

$cols = $data['cols'];
$pdate = $data['post_date'];
$padmin = $data['post_admin'];
$pcats = $data['post_cat'];

$has_entry_meta = ( $padmin || $pcats ) ? true : false;

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

if ( $grid_query->have_posts() ) : 

?>
<div class="row blog-grid">
  <?php 
    while ( $grid_query->have_posts() ) : $grid_query->the_post(); 
    $post_id = get_the_ID();
  ?>
  <div class="col-md-<?php echo esc_attr( $cols ); ?>">
    <article id="post-<?php the_ID(); ?>" <?php post_class( 'blog-box' ); ?>>
      <?php if ( has_post_thumbnail() ): ?>
      <div class="blog-img">
        <a href="<?php the_permalink(); ?>">
          <?php the_post_thumbnail('cirkle-size-1'); ?>
        </a>
        <?php if ( $pdate ){ ?>
        <div class="blog-date"><i class="icofont-calendar"></i><?php the_time( get_option( 'date_format' ) ); ?></div>
        <?php } ?>
      </div>
      <?php endif; ?>
      <div class="blog-content">
        <h3 class="blog-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
        <?php if ( $has_entry_meta ){ ?>
        <ul class="entry-meta">
          <?php if ( $padmin ){ ?>
          <li><i class="icofont-ui-user"></i><?php esc_html_e( 'by ', 'artex' ); ?> <a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) ); ?>"><?php the_author(); ?></a></li>
          <?php } if ( $pcats ){ ?>
          <li><i class="icofont-tag"></i><?php the_category( ', ' ); ?></li>
          <?php } ?>
        </ul>
        <?php } ?>
      </div>
      <?php if ( is_sticky() ) {
          echo '<sup class="meta-featured-post"> <i class="fas fa-thumbtack"></i> ' . esc_html__( 'Sticky', 'cirkle' ) . ' </sup>';
      } ?>
    </article>
  </div>
  <?php endwhile; wp_reset_postdata(); ?> 
</div>
<?php endif; ?>