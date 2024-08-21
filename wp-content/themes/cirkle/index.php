<?php
/**
 * @author  RadiusTheme
 * @since   1.0
 * @version 1.0
 */
namespace radiustheme\cirkle;
use radiustheme\cirkle\RDTheme;
use radiustheme\cirkle\Helper;
?>
<?php get_header(); ?>

<?php 
	$prefix = CIRKLE_THEME_CPT_PREFIX;
	$blog_grid = RDTheme::$options['blog_grid'];
?>

<!--=====================================-->
<!--=              Blog Start    	    =-->
<!--=====================================-->
<section class="blog-post-grid">
    <div class="container">
    	<div class="row justify-content-center gutters-40">
    		<div class="<?php Helper::the_layout_class(); ?>">
	    		<?php if ( have_posts() ) : ?>
	    			<div class="row grid">
						<?php
							if ( ( is_home() || is_archive() ) ) {
								while ( have_posts() ) : the_post();
									echo '<div class="col-md-'. esc_attr( $blog_grid ) .' col-xs-6 grid-item">';
									get_template_part( 'template-parts/content' ); 
									echo '</div>';
								endwhile;
							}
							else {
								while ( have_posts() ) : the_post();
									get_template_part( 'template-parts/content' );
								endwhile;
							}
						?>
						<?php else: ?>
							<?php get_template_part( 'template-parts/content', 'none' ); ?>
						<?php endif; ?>
					</div>
					<?php Helper::pagination(); ?>
				<?php wp_reset_postdata(); ?>
			</div>
			<?php Helper::cirkle_sidebar(); ?>
    	</div>
    </div>
</section>

<?php get_footer(); ?>
