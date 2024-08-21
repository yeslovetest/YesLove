<?php
/**
 * This file can be overridden by copying it to yourtheme/elementor-custom/chooseus/view.php
 * 
 * @author  RadiusTheme
 * @since   1.0
 * @version 1.0
 */

namespace radiustheme\Cirkle_Core;
extract( $data );
$align = $data['align'];
$text = $data['btntext'];
$url = $data['btnurl']['url'];
$bg_image = $data['bg_image']['url'];
$heading_tag_html = sprintf( '<%1$s %2$s class="item-title">%3$s</%1$s>', $data['heading_tag'], $this->get_render_attribute_string( 'title' ), $data['title'] );

if (!empty($data['side_image']['url'])) {
	$col = '6';
} else {
	$col = '12';
}

?>
<div class="why-choose-fluid">
    <div class="container-fluid full-width">
        <div class="row no-gutters">
            <div class="col-lg-<?php echo esc_attr( $col ); ?>">
                <div class="why-choose-content" style="background-image: url(<?php echo esc_url( $bg_image ); ?>)">
                    <div class="content-box">
                        <?php
				        	echo $heading_tag_html; 
				        	if (!empty($data['desc'] )) {
				        		echo $data['desc'];
				        	}
				        	if ( !empty( $url ) ) {
				        ?>
					        <a href="<?php echo esc_url( $url ); ?>" class="button-slide">
					            <span class="btn-text"><?php echo esc_html( $text ); ?></span>
					            <span class="btn-icon">
					                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="21px" height="10px">
					                    <path fill-rule="evenodd" fill="rgb(255, 255, 255)" d="M16.671,9.998 L12.997,9.998 L16.462,6.000 L5.000,6.000 L5.000,4.000 L16.462,4.000 L12.997,0.002 L16.671,0.002 L21.003,5.000 L16.671,9.998 ZM17.000,5.379 L17.328,5.000 L17.000,4.621 L17.000,5.379 ZM-0.000,4.000 L3.000,4.000 L3.000,6.000 L-0.000,6.000 L-0.000,4.000 Z" />
					                </svg>
					            </span>
					        </a>
				        <?php } ?>
                    </div>
                </div>
            </div>
            <?php if (!empty($data['side_image']['url'])) { ?>
            <div class="col-lg-6">
                <div class="why-choose-img">
                    <div class="image-box">
                        <?php echo wp_get_attachment_image( $side_image['id'], 'full' ); ?>
                    </div>
                </div>
            </div>
        	<?php } ?>
        </div>
    </div>
</div>
