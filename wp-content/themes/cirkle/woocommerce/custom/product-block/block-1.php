<?php
/**
 * @author  RadiusTheme
 * @since   1.0
 * @version 1.0
 */

namespace radiustheme\cirkle;
use radiustheme\cirkle\RDTheme;

global $product;

$product_id  = $product->get_id();

?>
<div class="rt-product-block block-box product-box">
    <?php woocommerce_show_product_loop_sale_flash(); ?>
    <div class="product-img">
        <a href="<?php the_permalink(); ?>"><?php woocommerce_template_loop_product_thumbnail(); ?></a>
        <div class="btn-icons">
        <?php
            if ( RDTheme::$options['quickview'] ) CKLWC_Functions::print_quickview_icon();
            if ( RDTheme::$options['wishlist'] ) CKLWC_Functions::print_add_to_wishlist_icon();
        ?>
        </div>
        <div class="rtin-buttons-woocart">
            <?php CKLWC_Functions::print_add_to_cart_icon( $product_id, true, true ); ?>
        </div>
    </div>
    <div class="product-content">
        <div class="item-category">
        <?php echo get_the_term_list( get_the_ID(), 'product_cat', '', ', ', '' ); ?>
        </div>
        <div class="title-price-box">
	        <h4 class="product-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
	        <?php if ( $price_html = $product->get_price_html() ) : ?>
	        <div class="product-price">
                <?php echo wp_kses( $price_html, 'alltext_allow' ); ?>
	        </div>
        	<?php endif; ?>
        </div>
    </div>
</div>