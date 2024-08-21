<?php
/**
 * @author  RadiusTheme
 * @since   1.0
 * @version 1.0
 */

namespace radiustheme\cirkle;
use radiustheme\cirkle\RDTheme;
use radiustheme\cirkle\Helper;
$cirkle = CIRKLE_THEME_PREFIX_VAR;
if ( is_404() ) {
	$rdtheme_title = RDTheme::$options['error_page_banner'];
}
elseif ( is_search() ) {
	$rdtheme_title = esc_html__( 'Search Results for : ', 'cirkle' ) . get_search_query();
}
elseif ( is_home() ) {
	if (!empty(RDTheme::$options['blog_breadcrumb_title'])) {
		$rdtheme_title = RDTheme::$options['blog_breadcrumb_title'];
	} elseif ( get_option( 'page_for_posts' ) ) {
		$rdtheme_title = get_the_title( get_option( 'page_for_posts' ) );
	}
	else {
		$rdtheme_title = apply_filters( "{$cirkle}_blog_title", esc_html__( 'All Posts', 'cirkle' ) );
	}
}
elseif ( is_archive() ) {
	$cpt = CIRKLE_THEME_CPT_PREFIX;
	if ( is_post_type_archive( "{$cpt}_gallery" ) ) {
		$rdtheme_title = esc_html__( 'All Gallery', 'cirkle' );
	}
	elseif ( is_post_type_archive( "{$cpt}_team" ) ) {
		$rdtheme_title = esc_html__( 'All Team Member', 'cirkle' );
	}
	else {
		$rdtheme_title = get_the_archive_title();
	}
} elseif (is_single()) {
	$rdtheme_title  = get_the_title();

} else {
	$id                        = get_the_ID(); //$post->ID;
	$fitness_custom_page_title = get_post_meta( $id, 'cirkle_custom_page_title', true );
	if (!empty($fitness_custom_page_title)) {
		$rdtheme_title = get_post_meta( $id, 'cirkle_custom_page_title', true );
	 } else { 
		$rdtheme_title = get_the_title();	                   
 	}
}

if ( class_exists( 'WooCommerce' ) ) {
	if (is_shop()) {
		$rdtheme_title = esc_html__( 'Shop', 'cirkle' );
	} else {
		$rdtheme_title = $rdtheme_title;
	}
}

$img_id = RDTheme::$options['banner_img'];
$size = 'full';

?>

<!--=====================================-->
<!--=          Banner Start       		=-->
<!--=====================================-->
<section class="breadcrumbs-banner">
    <div class="container">
        <div class="breadcrumbs-area">
            <h1><?php echo wp_kses( $rdtheme_title, 'alltext_allow' ); ?></h1>
            <?php if ( RDTheme::$has_breadcrumb == '1' || RDTheme::$has_breadcrumb  != "off" ): ?>
				<?php get_template_part( 'template-parts/content', 'breadcrumb' );?>
			<?php endif; ?>
        </div>
    </div>
    <?php if (!empty($img_id)) { ?>
    <div class="breadcrumb-animate-img" data-sal="slide-up" data-sal-duration="1000">
        <?php echo Helper::cirkle_get_attach_img( $img_id, $size ); ?>
    </div>
	<?php } ?>
</section>

<!--=====================================-->
<!--=         Inner Banner Start    	=-->
<!--=====================================-->