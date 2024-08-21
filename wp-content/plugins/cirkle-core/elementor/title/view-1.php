<?php
/**
 * This file can be overridden by copying it to yourtheme/elementor-custom/title/view-1.php
 * 
 * @author  RadiusTheme
 * @since   1.0
 * @version 1.0
 */

namespace radiustheme\Cirkle_Core;
$align = $data['align'];
$heading_tag_html = sprintf( '<%1$s %2$s class="item-title">%3$s</%1$s>', $data['heading_tag'], $this->get_render_attribute_string( 'title' ), $data['title'] );
?>

<div class="section-heading align-<?php echo esc_attr( $align ); ?>">
	<?php if (!empty($data['subtitle'] )) { ?>
		<div class="item-subtitle"><?php echo $data['subtitle']; ?></div>
	<?php } echo $heading_tag_html; ?>
	<?php if (!empty($data['desc'] )) {
		echo $data['desc']; 
	} ?>
</div>

