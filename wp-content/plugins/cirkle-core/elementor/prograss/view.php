<?php
/**
 * This file can be overridden by copying it to yourtheme/elementor-custom/prograssbar/view.php
 * 
 * @author  RadiusTheme
 * @since   1.0
 * @version 1.0
 */

namespace radiustheme\Cirkle_Core;
?>
<div class="progress-box">
  <div class="media">
    <?php if (!empty($data['icon'])) { ?>
    <div class="item-icon">
      <i class="<?php echo esc_attr($data['icon']); ?>"></i>
    </div>
    <?php } ?>
    <div class="media-body">
      <?php if (!empty($data['title'])) { ?>
      <div class="item-title"><?php echo esc_html( $data['title'] ); ?></div>
      <?php } if (!empty( $data['text'] )) { ?>
      <div class="item-subtitle"><?php echo esc_html( $data['text'] ); ?></div>
      <?php } ?>
    </div>
  </div>
</div>