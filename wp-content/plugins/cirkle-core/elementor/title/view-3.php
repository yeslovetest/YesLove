<?php
/**
 * This file can be overridden by copying it to yourtheme/elementor-custom/title/view-3.php
 * 
 * @author  RadiusTheme
 * @since   1.0
 * @version 1.0
 */

namespace radiustheme\Cirkle_Core;

$heading_tag_html = sprintf( '<%1$s %2$s class="section-title">%3$s</%1$s>', $data['heading_tag'], $this->get_render_attribute_string( 'title' ), $data['title'] ); 
?>

<div class="section-heading heading-layout3">
	<?php 
		echo $heading_tag_html;
		if (!empty($data['desc'] )) { ?>
		<div class="section-paragraph"><?php echo $data['desc']; ?></div>
	<?php } ?>
</div>