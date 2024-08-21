<?php
/**
 *
 * This file can be overridden by copying it to yourtheme/elementor-custom/button/view-3.php
 *
 * @author  RadiusTheme
 * @since   1.0
 * @version 1.0
 */

namespace radiustheme\Cirkle_Core;
extract( $data );
	$attr = '';
	if ( !empty( $data['url']['url'] ) ) {
		$attr  = 'href="' . $data['url']['url'] . '"';
		$attr .= !empty( $data['url']['is_external'] ) ? ' target="_blank"' : '';
		$attr .= !empty( $data['url']['nofollow'] ) ? ' rel="nofollow"' : '';
	}
if ( !empty( $data['url']['url'] ) ) {	
?>

<div class="cirkle-btn">
	<a <?php echo $attr; ?> class="btn-fill"><span class="top-left"></span><span class="bottom-right"></span><?php echo esc_html( $data['btntext'] ); ?></a>
</div>
<?php } ?>
