<?php
/**
 * This file can be overridden by copying it to yourtheme/elementor-custom/title/view-3.php
 * 
 * @author  RadiusTheme
 * @since   1.0
 * @version 1.0
 */

namespace radiustheme\Cirkle_Core;

$heading_tag_html = sprintf( '<%1$s %2$s class="section-title title has-animation">%3$s</%1$s>', $data['heading_tag'], $this->get_render_attribute_string( 'title' ), $data['title'] ); 
?>

<div class="section-heading project-content">
	<?php if (!empty($data['subtitle'] )) { ?>
    <div class="section-sub-title sub-title has-animation"><?php echo $data['subtitle']; ?></div>
    <?php } echo $heading_tag_html; ?>
    <?php if (!empty($data['desc'] )) { ?>
    <div class="section-paragraph description has-animation"><?php echo $data['desc']; ?></div>
	<?php } if (!empty($data['link_url'] )) { ?>
	<a href="<?php echo esc_url( $data['link_url'] ); ?>" class="has-animation item-btn btn-text button-dark"><?php echo esc_html( $data['link_text'] ); ?></a>
	<?php } ?>
</div>