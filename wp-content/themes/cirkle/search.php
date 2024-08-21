<?php
/**
 * @author  RadiusTheme
 * @since   1.0
 * @version 1.0
 */

namespace radiustheme\cirkle;
use radiustheme\cirkle\RDTheme;
use radiustheme\cirkle\Helper;

$blog_grid = RDTheme::$options['blog_grid'];

?>

<?php get_header(); ?>

<!--=====================================-->
<!--=         Search page wrapper    	=-->
<!--=====================================-->
<section class="section search-page">
    <div class="container">
    	<div class="row justify-content-center gutters-40">
	    	<div class="<?php Helper::the_layout_class(); ?>">
	    		<?php if ( have_posts() ) :?>
	    			<div class="row grid">
					<?php while ( have_posts() ) : the_post(); ?>
						<?php 
							echo '<div class="col-md-'. esc_attr( $blog_grid ) .' col-xs-6 grid-item">';
							get_template_part( 'template-parts/content', 'search' ); 
							echo '</div>';
						?>
					<?php endwhile; ?>
					</div>
					<?php Helper::pagination(); ?>
				<?php else:?>
					<?php get_template_part( 'template-parts/content', 'none' );?>
				<?php endif;?>
	        </div>
	        <?php Helper::cirkle_sidebar(); ?>
    	</div>
    </div>
</section>
<?php get_footer(); ?>