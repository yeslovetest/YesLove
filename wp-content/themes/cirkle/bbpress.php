<?php
/**
 * @author  RadiusTheme
 * @since   1.0
 * @version 1.0
 */

use radiustheme\cirkle\RDTheme;
use radiustheme\cirkle\Helper;
?>

<?php get_header(); ?>
<?php 
    if ( has_nav_menu( 'sidemenu' ) ) {
        // Sidebar Left
        get_template_part( 'template-parts/header/header', 'left' ); 
    }
?>

<!-- Page Content -->
<?php
	$page_title = RDTheme::$options['forum_banner_title'];
	$size = 'full';

	$img_id = RDTheme::$options['cirkle_fb_img'];
	$page_img = Helper::cirkle_get_attach_img( $img_id, $size );

	$img_id2 = RDTheme::$options['cirkle_fb_shape_img'];
	$page_shape_img = Helper::cirkle_get_attach_img( $img_id2, $size );
?>

<!-- Banner Area Start -->
<div class="newsfeed-banner">
    <div class="media">
        <div class="item-icon">
            <i class="icofont-speech-comments"></i>
        </div>
        <?php while ( have_posts() ) : the_post(); ?>
			<div class="media-body">
	            <h3 class="item-title"><?php echo esc_html( $page_title ) ?></h3>
	            <?php bbp_breadcrumb(); ?>
	        </div>
		<?php endwhile; // end of the loop. ?>
    </div>
    <?php if (!empty( $page_shape_img || $page_img )) { ?>
    <ul class="animation-img">
        <li data-sal="slide-down" data-sal-duration="800" data-sal-delay="400"><?php echo wp_kses( $page_shape_img, 'alltext_allow' ); ?></li>
        <li data-sal="slide-up" data-sal-duration="500"><?php echo wp_kses( $page_img, 'alltext_allow' ); ?></li>
    </ul>
    <?php } ?>
</div>
<div class="bbpress-content-wrap main-layout">
	<div class="row">
		<div class="<?php Helper::the_layout_class(); ?>">
		   <?php while ( have_posts() ) : the_post(); ?>
				<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
					<div class="entry-content">
						<?php the_content(); ?>
						<?php wp_link_pages( array( 'before' => '<div class="page-links">' . __( 'Pages:', 'cirkle' ), 'after' => '</div>' ) ); ?>
					</div><!-- .entry-content -->
				</article><!-- #post -->
				<?php comments_template( '', true ); ?>
			<?php endwhile; // end of the loop. ?>
		</div>
		<?php Helper::cirkle_sidebar(); ?>
	</div>
</div>
<?php get_footer(); ?>