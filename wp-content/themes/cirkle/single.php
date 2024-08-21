<?php
/**
 * @author  RadiusTheme
 * @since   1.0
 * @version 1.0
 */

namespace radiustheme\cirkle;
use radiustheme\cirkle\Helper;

?>

<?php get_header(); ?>
<!--=====================================-->
<!--=         Blog Start    	=-->
<!--=====================================-->
<section class="blog-details-wrap-layout">
    <div class="container">
        <div id="main" class="site-main">
			<?php while ( have_posts() ) : the_post(); ?>
				<?php get_template_part( 'template-parts/content-single' ); ?>
			<?php endwhile; ?>
		</div>
    </div>
</section>
<?php get_footer(); ?>