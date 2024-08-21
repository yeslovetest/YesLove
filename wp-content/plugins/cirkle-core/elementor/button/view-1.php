<?php
/**
 *
 * This file can be overridden by copying it to yourtheme/elementor-custom/button/view-1.php
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
	<a <?php echo $attr; ?> class="button-slide">
	    <span class="btn-text"><?php echo esc_html( $data['btntext'] ); ?></span>
	    <span class="btn-icon">
	        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="21px" height="10px">
	            <path fill-rule="evenodd" fill="rgb(255, 255, 255)" d="M16.671,9.998 L12.997,9.998 L16.462,6.000 L5.000,6.000 L5.000,4.000 L16.462,4.000 L12.997,0.002 L16.671,0.002 L21.003,5.000 L16.671,9.998 ZM17.000,5.379 L17.328,5.000 L17.000,4.621 L17.000,5.379 ZM-0.000,4.000 L3.000,4.000 L3.000,6.000 L-0.000,6.000 L-0.000,4.000 Z"></path>
	        </svg>
	    </span>
	</a>
</div>


<?php } ?>

