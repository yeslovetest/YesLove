<?php
/**
 * @author  RadiusTheme
 * @since   1.0
 * @version 1.0
 */

namespace radiustheme\cirkle;
use radiustheme\cirkle\RDTheme;
use radiustheme\cirkle\Helper;

$top_imgs = RDTheme::$options['f1_top_img'];
$top_imgs = explode(',', $top_imgs);

if ( is_active_sidebar( 'footer-widgets' ) ) {
    $footer_widget = 'active-footer-widgets';
} else {
    $footer_widget = 'deactive-footer-widgets';
}
if ( RDTheme::$options['footer1_bg_img']) {
    $fbs = ' footer-bg-shape';
} else {
    $fbs = ''; 
}
$footer_class = $footer_widget.$fbs;

?>

<!--=====================================-->
<!--=        Footer Area Start          =-->
<!--=====================================-->
<footer class="footer-wrap footer-1 <?php echo esc_attr( $footer_class ); ?>">
    <?php if ( is_active_sidebar( 'footer-widgets' ) ) { 
        if (!empty( $top_imgs )) {
    ?>
    <ul class="footer-top-image">
        <?php 
            $i = 0;
            foreach ($top_imgs as $key => $value) { 
                $i++;
                if ($i == 1 ) {
                    $delay = 400;
                } elseif ($i == 2 ) {
                    $delay = 500;
                } elseif ($i == 3 ) {
                    $delay = 300;
                } elseif ($i == 4 ) {
                    $delay = 600;
                } elseif ($i == 5 ) {
                    $delay = 200;
                } elseif ($i == 6 ) {
                    $delay = 700;
                } elseif ($i == 7 ) {
                    $delay = 100;
                } elseif ($i == 8 ) {
                    $delay = 800;
                } else {
                    $delay = 0;
                }
                $img_id = attachment_url_to_postid( $value );
                $size = attachment_url_to_postid( $value );  
        ?>
            <li data-sal="slide-up" data-sal-duration="500" data-sal-delay="<?php echo esc_attr( $delay ); ?>">
                <?php echo Helper::cirkle_get_attach_img( $img_id, $size ); ?>
            </li>
        <?php } ?>
    </ul>
    <?php } ?>
    <div class="main-footer">
        <div class="container">
            <div class="row row-cols-lg-4 row-cols-sm-2 row-cols-1">
                <?php dynamic_sidebar( 'footer-widgets' ); ?>
            </div>
        </div>
    </div>
    <?php } ?>
    <div class="footer-bottom">
        <div class="footer-copyright"><?php echo wp_kses( RDTheme::$options['copyright_text'], 'alltext_allow' ); ?></div>
    </div>
</footer> 