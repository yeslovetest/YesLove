<?php
/**
 * @author  RadiusTheme
 * @since   1.0
 * @version 1.0
 */

namespace radiustheme\cirkle;
use radiustheme\cirkle\RDTheme;
use radiustheme\cirkle\Helper;
$nav_menu_args   = Helper::nav_menu_args();
$menu_btn = RDTheme::$options['header_social'] || RDTheme::$options['header_search'] || RDTheme::$options['header_link'] ? true : false;

$rdtheme_logo_width = (int) RDTheme::$options['logo_width'];
$rdtheme_menu_width = 8 - $rdtheme_logo_width;
$rdtheme_logo_class = "col-xl-{$rdtheme_logo_width} temp-logo-wrap";
if ( $menu_btn == true ) {
    $rdtheme_menu_width = $rdtheme_menu_width;
    $rdtheme_menu_align = ' d-flex justify-content-lg-start justify-content-center';
} else {
    $rdtheme_menu_width = $rdtheme_menu_width+4;
    $rdtheme_menu_align = ' d-flex justify-content-lg-end justify-content-end';
}
if ( RDTheme::$options['header_social'] == 1 ) {
    $rdtheme_menu_width = $rdtheme_menu_width;
    $menu_btn_cols = '4';
} else {
    $menu_btn_cols = '3';
    $rdtheme_menu_width = $rdtheme_menu_width;
}
$rdtheme_menu_class = "col-xl-{$rdtheme_menu_width}".$rdtheme_menu_align;

?>

<!--=====================================-->
<!--=         Header Area Start         =-->
<!--=====================================-->
<header class="header">
    <div id="rt-sticky-placeholder"></div>
    <div id="header-menu" class="header-menu menu-layout1">
        <div class="container-fluid">
            <div class="row align-items-center">
                <div class="<?php echo esc_html( $rdtheme_logo_class ) ; ?>">
                    <div class="temp-logo">
                        <?php get_template_part( 'template-parts/header/logo', 'light' ); ?>
                    </div>
                </div>
                <div class="<?php echo esc_html( $rdtheme_menu_class ) ; ?>">
                    <div class="mobile-nav-item hide-on-desktop-menu">
                        <div class="mobile-logo">
                            <?php get_template_part( 'template-parts/header/logo', 'mobile' ); ?>
                        </div>
                        <?php get_template_part('template-parts/header/mobile', 'menu'); ?>
                    </div>
                    <nav id="dropdown" class="template-main-menu">
                        <?php wp_nav_menu( $nav_menu_args ); ?>
                    </nav>
                </div>

                <?php if (!empty($menu_btn == true)) { ?>
                <div class="col-xl-<?php echo esc_attr( $menu_btn_cols ); ?> d-flex justify-content-end mobi-menu-wrap">
                    <div class="header-action">
                        <ul>
                            <?php if (!empty(RDTheme::$options['header_social'])) { ?>
                            <li class="header-social">
                                <?php get_template_part( 'template-parts/header/socials' ); ?>
                            </li>
                            <?php } if (!empty(RDTheme::$options['header_search'])) { ?>
                            <li class="header-search-icon">
                                <?php get_template_part( 'template-parts/header/header-search' ); ?>
                            </li>
                            <?php } if (!empty(RDTheme::$options['header_link']) && ( !is_user_logged_in() )) { ?>
                            <li class="login-btn">
                                <?php get_template_part( 'template-parts/header/header-link' ); ?>
                            </li>
                            <?php } ?>
                        </ul>
                    </div>
                </div>
                <?php } ?>
            </div>
        </div>
    </div>
</header>