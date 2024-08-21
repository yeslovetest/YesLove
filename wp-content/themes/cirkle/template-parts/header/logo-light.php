<?php 
namespace radiustheme\cirkle;
use radiustheme\cirkle\RDTheme;
use radiustheme\cirkle\Helper;
// Logo
$rdtheme_light_logo = empty( Helper::rt_the_logo_light() ) ? get_bloginfo( 'name' ) : Helper::rt_the_logo_light();
if ( !empty( Helper::rt_the_logo_light() ) ){
	$logo_class = 'img-logo';
} else {
	$logo_class = 'txt-logo';
}
?>
<div class="header-logo light-logo <?php echo esc_attr( $logo_class ); ?>">
	<a href="<?php echo esc_url( home_url( '/' ) ); ?>">
	    <?php if ( !empty( Helper::rt_the_logo_light() ) ){
	        echo Helper::rt_the_logo_light();
	    } else {
	        echo wp_kses( $rdtheme_light_logo, 'alltext_allow' );
	    } ?>
	</a>
	<?php 
	  if ( display_header_text() == true ) {
	    $description = get_bloginfo( 'description', 'display' );
	    if ( $description || is_customize_preview() ) : ?>
	      <div class="site-description"><?php echo esc_html( $description ); ?></div>
	    <?php endif; 
	  }
	?>
</div>