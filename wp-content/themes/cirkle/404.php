<?php
/**
 * @author  RadiusTheme
 * @since   1.0
 * @version 1.0
 */

namespace radiustheme\cirkle;
use radiustheme\cirkle\RDTheme;

get_header();

?>

<!--=====================================-->
<!--=           404 Area Start          =-->
<!--=====================================-->
<section class="error-404-wrap text-center">
	<div class="container">
		<?php if (!empty(RDTheme::$options['error_page_title'])) { ?>
		<h1 class="main-title"><?php echo esc_html( RDTheme::$options['error_page_title'] ); ?></h1>
		<?php } if (!empty(RDTheme::$options['error_page_subtitle'])) { ?>
		<h3 class="sub-title"><?php echo esc_html( RDTheme::$options['error_page_subtitle'] ); ?></h3>	
		<?php } if (!empty(RDTheme::$options['error_desc_text'])) { ?>
		<p class="item-paragraph"><?php echo esc_html( RDTheme::$options['error_desc_text'] ); ?></p>
		<?php } ?>
		<form class="search-form" action="<?php echo esc_url( home_url( '/' ) ) ?>" method="get">
			<input type="text" name='s' value="<?php get_search_query() ?>" class="form-control" placeholder="<?php esc_attr_e( 'Search here', 'cirkle' ); ?>">
			<button type="submit" id="quick-search" class="btn btn-custom"><i class="icofont-search"></i></button>
	  	</form>
	  	<?php if (!empty(RDTheme::$options['error_buttontext'])) { ?>
		<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="btn-text"><?php echo esc_html( RDTheme::$options['error_buttontext'] ); ?></a>
		<?php } ?>
	</div>	
</section>
<!--=====================================-->
<!--=           404 Area End            =-->
<!--=====================================-->			

<?php get_footer(); ?>