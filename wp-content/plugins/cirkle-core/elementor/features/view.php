<?php
/**
 * This file can be overridden by copying it to yourtheme/elementor-custom/lists/view.php
 * 
 * @author  RadiusTheme
 * @since   1.0
 * @version 1.0
 */

namespace radiustheme\Cirkle_Core;

?>
<div class="why-choose-box">                          
    <ul class="features-list">
        <?php foreach ( $data['rt_feature_list'] as $index => $item ) { ?>
        <li>
            <div class="media">
                <div class="item-icon">
                    <i class="<?php echo $item['list_icon']; ?>"></i>
                </div>
                <div class="media-body">
                    <h3 class="item-title"><?php echo $item['list_title']; ?></h3>
                    <p><?php echo $item['list_text']; ?></p>
                </div>
            </div>
        </li>
        <?php } ?>
    </ul>
</div>