<?php
/**
 * @author  RadiusTheme
 * @since   1.0
 * @version 1.0
 */

namespace radiustheme\cirkle;
use radiustheme\cirkle\Helper;
?>
<?php 
	if ( class_exists( 'WooCommerce' ) ) {
		if ( is_cart() || is_checkout() ) {
		    get_template_part( 'header', 'shop' );
		} else {
			get_header();
		}
	} else {
		get_header();
	}
?>
<div id="primary" class="page-content-area page-details-wrap-layout customize-content-selector section-padding">
	<div class="container">
		<div class="row justify-content-center gutters-40">		
			<div class="<?php Helper::the_layout_class(); ?>">		
				<main id="main" class="site-main page-content-main">
					<?php while ( have_posts() ) : the_post(); ?>
						<?php get_template_part( 'template-parts/content', 'page' ); ?>
						<?php
							if ( comments_open() || get_comments_number() ){
								comments_template();
							}
						?>
					<?php endwhile; ?>
				</main>
			</div>
			<?php Helper::cirkle_sidebar(); ?>
		</div>
	</div>
</div>
<?php 
	if ( class_exists( 'WooCommerce' ) ) {
		if ( is_cart() || is_checkout() ) {
		    get_template_part( 'footer', 'shop' );
		} else {
			get_footer();
		}
	} else {
		get_footer();
	} 
?>