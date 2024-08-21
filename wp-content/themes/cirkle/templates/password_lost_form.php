<?php  
/* 
    Template Name: Lost Password
*/  
/**
 * @author  RadiusTheme
 * @since   1.0
 * @version 1.0.4
 */

use radiustheme\cirkle\RDTheme;
use radiustheme\cirkle\Helper;
use radiustheme\cirkle\BuddyPress_Setup;

global $user_ID;

?>

<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <?php wp_head(); ?>
</head>


<!--=====================================-->
<!--=          Header Menu Start        =-->
<!--=====================================-->
<div class="login-page-wrap">
    <div class="content-wrap">
        <div class="login-content">
            <div class="item-logo">
                <?php 
                    $circleBuddy = new BuddyPress_Setup();
                    $error = $circleBuddy->cirkle_register_messages();
                    if (!empty( $error )) {
                        $active1 = '';
                        $show1 = '';
                        $active2 = 'active';
                        $show2 = 'show active';
                    } else {
                        $active1 = 'active';
                        $show1 = 'show active';
                        $active2 = '';
                        $show2 = '';
                    }
                    get_template_part( 'template-parts/header/logo', 'light' ); 
                ?>
            </div>
            
            <div class="login-form-wrap">
                <div class="tab-content">
                    <div id="password-lost-form" class="widecolumn">
                        <h3><?php _e( 'Forgot Your Password?', 'personalize-login' ); ?></h3>
                        <p>
                            <?php
                                _e(
                                    "Enter your email address and we'll send you a link you can use to pick a new password.",
                                    'personalize_login'
                                );
                            ?>
                        </p>
                     
                        <form id="lostpasswordform" action="<?php echo wp_lostpassword_url(); ?>" method="post">
                            <p class="form-row">
                                <label for="user_login"><?php _e( 'Email', 'personalize-login' ); ?>
                                <input type="text" name="user_login" id="user_login">
                            </p>
                     
                            <p class="lostpassword-submit">
                                <input type="submit" name="submit" class="lostpassword-button"
                                       value="<?php _e( 'Reset Password', 'personalize-login' ); ?>"/>
                            </p>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="map-line">
            <?php echo wp_get_attachment_image( RDTheme::$options['mapbg'], 'full' ); ?>
            <ul class="map-marker">
                <?php if ( !empty( RDTheme::$options['location_icon1'] ) ) { ?>
                <li><?php echo wp_get_attachment_image( RDTheme::$options['location_icon1'], 'full' ); ?></li>
                <?php } if ( !empty( RDTheme::$options['location_icon2'] ) ) { ?>
                <li><?php echo wp_get_attachment_image( RDTheme::$options['location_icon2'], 'full' ); ?></li>
                <?php } if ( !empty( RDTheme::$options['location_icon3'] ) ) { ?>
                <li><?php echo wp_get_attachment_image( RDTheme::$options['location_icon3'], 'full' ); ?></li>
                <?php } if ( !empty( RDTheme::$options['location_icon4'] ) ) { ?>
                <li><?php echo wp_get_attachment_image( RDTheme::$options['location_icon4'], 'full' ); ?></li>
                <?php } ?>
            </ul>
        </div>
    </div>
</div>
  

<?php wp_footer(); ?>