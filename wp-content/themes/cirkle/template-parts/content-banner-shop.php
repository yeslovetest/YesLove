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

if (is_shop() || is_product()) {
	$rdtheme_title = esc_html__( 'Love & Mental Health Products', 'cirkle' );
} else {
	$rdtheme_title = get_the_title();
}

?>

<!--=====================================-->
<!--=          Banner Start       		=-->
<!--=====================================-->
<div class="product-breadcrumb block-box">
    <div class="breadcrumb-area">
        <h1 class="item-title"><?php echo wp_kses( $rdtheme_title, 'alltext_allow' ); ?></h1>
        <?php if ( RDTheme::$has_breadcrumb == '1' || RDTheme::$has_breadcrumb  != "off" ): ?>
			<?php get_template_part( 'template-parts/content', 'breadcrumb' );?>
		<?php endif; ?>
    </div>
</div>

<!--=====================================-->
<!--=         Inner Banner Start    	=-->
<!--=====================================-->