<?php  
/* 
    Template Name: Login/Register 
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
$hfc = '';
if (RDTheme::$options['login_page_header']) {
    $hfc = 'header-enable';
}
if (RDTheme::$options['login_page_footer']) {
    $hfc = $hfc.' footer-enable';
}

?>
<!doctype html>
<html <?php language_attributes(); ?>>

<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <?php wp_head(); ?>
</head>

<body <?php body_class( 'login-registration-body '. $hfc ); ?>>
    <?php wp_body_open(); ?>
    <!-- ============== Preloader ================== -->
    <?php
        if (RDTheme::$options['preloader']) {
            do_action('site_prealoader');
        } 
    ?>
    <!-- ============== Color Mode Swicth ================== -->
    <?php if ( RDTheme::$options['color_mode'] ) { ?>
    <div class="header__switch header__switch--wrapper">
        <span class="header__switch__settings"><i class="icofont-sun-alt"></i></span>
        <label class="header__switch__label" for="headerSwitchCheckbox">
            <input class="header__switch__input" type="checkbox" name="headerSwitchCheckbox" id="headerSwitchCheckbox">
            <span class="header__switch__main round"></span>
        </label>
        <span class="header__switch__dark"><i class="icofont-moon"></i></span>
    </div>
    <?php } ?>

    <!-- <div id="wrapper" class="wrapper"> -->
        <?php if (RDTheme::$options['login_page_header']) { ?>
        <div id="masthead" class="site-header">
            <?php 
                if ( class_exists( 'BuddyPress' ) && class_exists( 'bbPress' ) ) {
                    if ( is_buddypress() || is_bbpress() ) {
                        get_template_part('template-parts/header/header', RDTheme::$options['bp_header_style']);
                    } else {
                        get_template_part('template-parts/header/header', RDTheme::$options['header_style']);
                    }   
                } else {
                    get_template_part('template-parts/header/header', RDTheme::$options['header_style']);
                } 
            ?>
        </div>
        <?php } ?>
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
                        <ul class="nav nav-tabs" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link <?php echo $active1 ?>" data-toggle="tab" href="#login-tab" role="tab" aria-selected="true"><i class="icofont-users-alt-4"></i> <?php esc_html_e( 'Sign In', 'cirkle' ); ?> </a>
                            </li>
                            <?php if(empty($user_ID)) { ?>
                            <li class="nav-item">
                                <a class="nav-link <?php echo $active2 ?>" data-toggle="tab" href="#registration-tab" role="tab" aria-selected="false"><i class="icofont-download"></i> <?php esc_html_e( 'Registration', 'cirkle' ); ?></a>
                            </li>
                            <?php } ?>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane login-tab fade <?php echo $show1 ?>" id="login-tab" role="tabpanel">
                                <?php if ( !empty( RDTheme::$options['form_title'] ) ) { ?>
<!--                                 <h3 class="item-title"><?php echo esc_html( RDTheme::$options['form_title'] ); ?></h3> -->
								<h3 class="item-title">Sign in</h3>
								
                                <?php } ?>
                                <?php 
                                    if(empty($user_ID)) { ?>
                                        <?php
                                            if (isset($_GET['reason'])) {
                                                echo '<p class="alert-danger">';
                                                switch ($_GET['reason']) {
                                                    case 'invalid_username':
                                                        $warning = esc_html__( 'Incorrect Username', 'cirkle' );
                                                        break;
                                                    case 'incorrect_password':
                                                        $warning = esc_html__( 'Incorrect Password', 'cirkle' );
                                                        break;
                                                    default:
                                                        $warning = esc_html__( 'Error username or password', 'cirkle' );
                                                        break;
                                                }
                                                echo esc_html($warning);
                                                echo '</p>';
                                            } 
                                        ?>         
                                        <!-- Modal Content -->
                                        <form class="modal-form" action="<?php echo site_url( '/wp-login.php' ); ?>" method="post">
                                            <div class="login-form-body">
                                                <div class="form-group">
                                                    <input class="form-control" type="text" name="log" placeholder="<?php esc_attr_e( 'Username', 'cirkle' ); ?>" required>
                                                </div>
                                                <div class="form-group">
                                                    <input class="form-control" type="password" name="pwd" id="user_pass" placeholder="<?php esc_attr_e( 'Password', 'cirkle' ); ?>" required>
                                                </div>
                                                <div class="form-group mb-4 checking-box">
                                                    <div class="remember-me form-check">
                                                        <input type="checkbox" checked="checked" id="check" class="form-check-input"> 
                                                        <label for="check"><?php esc_html_e( 'Remember me', 'cirkle' ); ?></label>
                                                    </div>
<!--                                                     <div class="remember-me form-check">
                                                        <input type="checkbox" id="passcheck" class="form-check-input">
                                                        <label for="passcheck"><?php esc_html_e( 'Remember password ?', 'cirkle' ); ?></label>
                                                    </div> -->
                                                </div>
                                                <div class="form-group">
                                                    <button class="submit-btn btn" type="submit"><?php esc_html_e( 'Login', 'cirkle' ); ?></button>
                                                </div>
                                            </div>
                                            <?php 
                                                $shortcode = RDTheme::$options['social_login_shortcode'];
                                                if ( $shortcode ) {
                                                    echo sprintf( '<div class="social-login">%s</div>', do_shortcode( $shortcode ) );
                                                } 
                                            ?>
                                            <div class="form-footer">
                                                <span class="forget-psw"><a href="<?php echo wp_lostpassword_url(); ?>">
                                                    <?php esc_html_e( 'Forgot your password ?', 'cirkle' ); ?></a></span>
                                                <span class="back-to-site">
                                                    <a href="<?php echo esc_url( home_url('/') ); ?>"><i class="icofont-long-arrow-left"></i><?php esc_html_e( ' Back to Home', 'cirkle' ) . ' '. get_bloginfo( 'name' ); ?></a>
                                                </span>
                                            </div>
                                        </form>
                                    <?php } else { ?>
                                        <h6><?php esc_html_e( 'You Are Already Logged In', 'cirkle' ); ?></h6>
                                <?php } ?>
                            </div>
                            <div class="tab-pane registration-tab fade <?php echo $show2 ?>" id="registration-tab" role="tabpanel">
                                <h3 class="item-title"><?php esc_html_e( 'Create an account', 'cirkle' ); ?></h3>
                                <?php 
                                    if(empty($user_ID)) { 
                                        $registration_enabled = get_option('users_can_register');
                                        if($registration_enabled) {

                                            $all_country = Cirkle_Core::getCountryList();

                                        ?>
                                        <?php echo $error; 

                                        ?>
                                        <form id="cirkle_registration_form" class="cirkle_form" action="" method="POST">
                                            
                                            <div class="form-group">
                                                <?php do_action( 'bp_account_details_fields' ); ?>
                                            </div>
                                            <div class="form-group">
                                                <input name="user_fullname" id="user_fullname" type="text" class="form-control" placeholder="<?php esc_attr_e( 'Full Name', 'cirkle' ); ?>">
                                            </div>
                                            <div class="form-group">
                                                <input name="cirkle_user_login" id="cirkle_user_login" class="form-control" type="text" placeholder="<?php esc_attr_e( 'Username', 'cirkle' ); ?>" required>
                                            </div>
                                            <div class="form-group">
                                                <input name="cirkle_user_email" id="cirkle_user_email" class="form-control" type="email" placeholder="<?php esc_attr_e( 'Email', 'cirkle' ); ?>" required>
                                            </div>
                                            <div class="form-group">
                                                <input name="cirkle_user_pass" id="password" class="form-control" type="password" placeholder="<?php esc_attr_e( 'Password', 'cirkle' ); ?>" required>
                                            </div>
                                            <div class="form-group">
                                                <input name="cirkle_user_pass_confirm" id="password_again" class="form-control" type="password" placeholder="<?php esc_attr_e( 'Confirm Password', 'cirkle' ); ?>" required>
                                            </div>


                                            <div class="form-group">
                                                <select name="user_country" id="user_country" class="select2-search cirkle_field_country" data-state="">
                                                    <?php foreach ( $all_country as $option_key => $option_value ) : ?>
                                                        <option value="<?php echo esc_attr( $option_key ); ?>" <?php selected( $option_key, true ); ?>><?php echo esc_html( $option_value ); ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>

                                            <div class="form-group">
                                                <select name="user_state" id="user_state" class="select2-search cirkle_field_state" data-state="">
                                                    <option value=""><?php esc_html_e('Select a state', 'cirkle'); ?></option>
                                                </select>
                                            </div>

                                            <div class="form-group submit-btn-wrap">
                                                <input type="hidden" name="cirkle_csrf" value="<?php echo wp_create_nonce('cirkle-csrf'); ?>"/>
                                                <input type="submit" class="submit-btn" value="<?php esc_attr_e('Register', 'cirkle'); ?>"/>
                                            </div>
                                        </form>
                                    <?php } else { ?>
                                        <h6 class="cirkle_header"><?php esc_html_e( 'User registration is not enabled', 'cirkle' ); ?></h6>
                                    <?php } ?>
                                <?php 
                                    } else { ?>
                                        <h6><?php esc_html_e( 'You Are Already Registered', 'cirkle' ); ?></h6>
                                    <?php }
                                ?>
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

        <?php 
            if (RDTheme::$options['login_page_footer']) {
                get_template_part( 'template-parts/footer/footer', 2 ); 
            }
        ?>
    <!-- </div> -->
    <?php wp_footer(); ?>
</body>
</html>