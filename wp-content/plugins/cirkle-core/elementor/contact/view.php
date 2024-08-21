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

<!--=====================================-->
<!--=          Contact Page Start       =-->
<!--=====================================-->
<div class="contact-page">
    <div class="contact-box-wrap">
        <div class="container">
            <div class="contact-form">
                <div class="row">
                    <div class="col-lg-7">
                        <div class="contact-box">
                            <h3 class="item-title"><?php echo esc_html( $data['title'] ); ?></h3>
                            <?php echo do_shortcode( $data['shortcode'] ); ?>
                        </div>
                    </div>
                    <div class="col-lg-5">
                        <div class="contact-box contact-method">
                            <h3 class="item-title"><?php echo esc_html( $data['list_title'] ); ?></h3>
                            <ul>
                            <?php foreach ( $data['rt_contact_list'] as $index => $item ) { ?>
                                <li>
                                    <i class="<?php echo esc_attr( $item['icon'] ); ?>"></i>
                                    <?php echo esc_html( $item['text'] ); ?>
                                </li>
                            <?php } ?>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>