<?php 
namespace radiustheme\cirkle;
use radiustheme\cirkle\Helper;
// Logo
$rt_the_logo_mobile = empty( Helper::rt_the_logo_mobile() ) ? get_bloginfo( 'name' ) : Helper::rt_the_logo_mobile();
?>
<a href="<?php echo esc_url( home_url( '/' ) ); ?>">
    <?php if ( !empty( Helper::rt_the_logo_mobile() ) ){
        echo Helper::rt_the_logo_mobile();
    } else {
        echo wp_kses( $rt_the_logo_mobile, 'alltext_allow' );
    } ?>
</a>