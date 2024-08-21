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

<!--=====================================-->
<!--=        Footer Area Start          =-->
<!--=====================================-->
<footer class="footer-wrap footer-2 footer-dashboard">
    <?php if ( is_active_sidebar( 'footer-widgets' ) ) { ?>
    <div class="main-footer">
        <div class="container">
            <div class="row row-cols-lg-4 row-cols-sm-2 row-cols-1">
                <?php dynamic_sidebar( 'footer-widgets' ); ?>
            </div>
        </div>
    </div>
    <?php } ?>
    <div class="footer-bottom">
        <div class="footer-copyright"><?php echo wp_kses_stripslashes( RDTheme::$options['copyright_text'] ); ?></div>
    </div>
</footer>

