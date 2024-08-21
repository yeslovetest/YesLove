<?php
/**
 * @author  RadiusTheme
 * @since   1.0
 * @version 1.0
 */

use radiustheme\cirkle\RDTheme;

?>
<div class="single-product">
    <div class="row">
        <div class="col-lg-6">
            <div class="product-gallery">
                <?php do_action( 'woocommerce_before_single_product_summary' ); ?>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="product-content">
                <?php do_action( 'woocommerce_single_product_summary' ); ?>
            </div>
        </div>
    </div>
</div>
<div class="single-product-info">
    <?php do_action( 'woocommerce_after_single_product_summary' ); ?>
</div>
<?php if ( RDTheme::$options['cklwc_related_product'] == 1 ) { ?>
<div class="related-product">
    <?php do_action( 'cirkle_pd_related_posts' ); ?>
</div>
<?php } ?>