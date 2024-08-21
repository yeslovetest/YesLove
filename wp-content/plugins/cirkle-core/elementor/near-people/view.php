<?php
/**
 * This file can be overridden by copying it to yourtheme/elementor-custom/near-people/view.php
 * 
 * @author  RadiusTheme
 * @since   1.0
 * @version 1.0
 */

use radiustheme\cirkle\Helper;
extract( $data );
?>

<div class="location-box">
    <div class="item-img">
        <?php echo wp_get_attachment_image( $location_img['id'], 'full' ); ?>
    </div>
    <div class="item-content">
        <form action="<?php echo esc_url( Helper::goto_template_name() ); ?>" method="get">
            <div class="form-group form-destination">
                <input type="hidden" name="user_country" value="<?php echo esc_attr( $data['user_country'] ); ?>">
            </div>
            <div class="form-group form-date">
                <input type="hidden"  name="user_state" value="<?php echo esc_attr( $data['user_state'] ); ?>" class="date">
            </div>
            <button type="submit" class="btn">
                <?php  
                    if ( $data['user_country'] && $data['user_state'] ) {
                        echo esc_html( Cirkle_Core::getStateByCountry($data['user_country'])[$data['user_state']] ); 
                        echo ', ';
                    }
                    if ( $data['user_country'] ) {
                        echo esc_html( Cirkle_Core::getCountryList($data['user_country']) ); 
                    } 
                    
                ?>
            </button>
        </form>
    </div>
</div>
