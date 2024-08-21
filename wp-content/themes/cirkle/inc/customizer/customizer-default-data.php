<?php
// Customizer Default Data
if ( ! function_exists( 'rttheme_generate_defaults' ) ) {
    function rttheme_generate_defaults() {
        $customizer_defaults = array(

            /* = General Area
            =======================================================*/ 
            'logo'               => '',
            'logo_mobile'        => '',
            'logo_width'         => 2,            
            'preloader'          => 1,
            'page_scrolltop'     => '',
            'sticky_header'      => 1,
            'fixed_header'       => 1,
            'cirkle_breadcrumb'  => '',
            'page_banner_img'    => '',
            'page_banner_bgimg'  => '', 
            'preloader_image'    => '', 

            /* = Contact & Social Area
            =======================================================*/
            'social_facebook'  => '#',
            'social_twitter'   => '#',
            'social_linkedin'  => '#',
            'social_youtube'   => '#',
            'social_pinterest' => '#',
            'social_instagram' => '#',
            'social_login_shortcode' => '',
            
            /* = Header Area
            =======================================================*/
            'header_style'          => 1,
            'bp_header_style'       => 2,
            'header_social'         => '',
            'header_search'         => '',
            'header_link'           => '',
            'header_cart'           => '',
            'header_friend'         => '',
            'header_message'        => '',
            'header_notification'   => '',
            'header_cart'           => '',
            'header_profile'        => '',
            'hlb_txt'               => '',
            'hlb_link'              => '',
            'cirkle_has_banner'     => '',
            'banner_bg_img'         => '',
            'banner_img'            => '',
            'banner_bg_color'       => '#2d5be3',
            'banner_bg_opacity'     => '75',
            'banner_padding_top'    => '',
            'banner_padding_bottom' => '',


            /* = Pages Area
            =======================================================*/
            //Page layout 
            'page_layout'        => 'full-width',

            //Single Page layout
            'single_post_layout' => 'full-width',
            'single_post_menu_bg_img' => '',
            'single_post_menu_bg_color' => '',
            'cirkle_menu_bg_opacity' => '75',
            'cirkle_breadcrumb' => '',
            'cirkle_menu_bg_height' => '',


            /* = Blog Area
            =======================================================*/
            //Blog Post
            'blog_grid'    => 4,
            'meta_cats'    => 1, 
            'meta_admin'   => 1, 
            'meta_date'    => 1, 
            'meta_react'   => 1,
            'meta_comnts'  => 1,
            'excerpt_length' => 30,
            'blog_breadcrumb_title' => '',

            //Single Post layout
            'post_cats'    => 1,
            'post_admin'   => 1,
            'post_date'    => 1,
            'post_comnts'  => 1,
            'post_share'   => '',
            'post_react'   => '',
            'meta_react_text' => 'Choose your <span>Reaction!</span>',
            'related_post' => '',
            'related_post_title' => '',
            'post_per_page' => 5,


            /* = Portfolio Area
            =======================================================*/
            //Portfolio Post
            'portfolio_style'          => 1,
            'portfolio_archive_number' => 9,
            'portfolio_grid_cols'      => '4', 
            'portfolio_excerpt_length' => '50', 
            'p4_slide_to_show' => '3', 
            
            //Single portfolio
            'single_portfolio_layout' => 1,
            'portfolio_share' => 1,
            'single_portfolio_slug' => 'portfolio',
            'portfolio_details_socials' => '',

            /* = Service Area
            =======================================================*/
            'single_service_slug' => 'service',

            /* = Team Area
            =======================================================*/
            'team_details_page_title' => 'Single Team',
            'team_details_page_subtitle' => 'We Designed Your Space for Creating',
            'team_details_banner_img' => '',
            'single_team_slug' => 'team',


            /* = Footer Area 
            =======================================================*/
            //Footer
            'footer_style'   => 1,
            'copyright_text' => 'Copyright © 2021 Cirkle by <a href="https://www.radiustheme.com">RadiusTheme</a>.',

            //Footer
            'footer_widgets_column' => 3,
            'footer2_widgets_column' => 3,

            //Footer 1
            'f1_top_img' => '',
            'footer1_bg_img' => '',
            'footer1_bg_color' => '',
            'footer1_bg_opacity' => '',
            //Footer 2
            'footer2_bg_img' => '',
            'footer2_bg_color' => '',
            'footer2_bg_opacity' => '',

            
            /* = Body Typo Area
            =======================================================*/
            'typo_body' => json_encode(
                array(
                    'font' => 'Roboto',
                    'regularweight' => 'normal',
                )
            ),
            'typo_body_size' => '16px',
            'typo_body_height'=> '28px',

            /* = Menu Typo Area
            =======================================================*/
            //Menu Typography
            'typo_menu' => json_encode(
                array(
                    'font' => 'Roboto',
                    'regularweight' => '500',
                )
            ),
            'typo_menu_size' => '16px',
            'typo_menu_height' => '28px',

            //Sub Menu Typography
            'typo_submenu_size' => '14px',
            'typo_submenu_height' => '24px',

            /* = Heading Typo Area
            =======================================================*/
            //Heading Typography
            'typo_heading' => json_encode(
                array(
                    'font' => 'Nunito',
                    'regularweight' => '700',
                )
            ),

            //H1
            'typo_h1' => json_encode(
                array(
                    'font' => '',
                    'regularweight' => '700',
                )
            ),
            'typo_h1_size' => '42px',
            'typo_h1_height' => '48px',

            //H2
            'typo_h2' => json_encode(
                array(
                    'font' => '',
                    'regularweight' => '700',
                )
            ),
            'typo_h2_size' => '36px',
            'typo_h2_height' => '42px',

            //H3
            'typo_h3' => json_encode(
                array(
                    'font' => '',
                    'regularweight' => '700',
                )
            ),
            'typo_h3_size' => '28px',
            'typo_h3_height' => '36px',

            //H4
            'typo_h4' => json_encode(
                array(
                    'font' => '',
                    'regularweight' => '700',
                )
            ),
            'typo_h4_size' => '24px',
            'typo_h4_height' => '32px',

            //H5
            'typo_h5' => json_encode(
                array(
                    'font' => '',
                    'regularweight' => '700',
                )
            ),
            'typo_h5_size' => '18px',
            'typo_h5_height' => '28px',

            //H6
            'typo_h6' => json_encode(
                array(
                    'font' => '',
                    'regularweight' => '700',
                )
            ),
            'typo_h6_size'   => '15px',
            'typo_h6_height' => '26px',

            /* = Site Color Area
            =======================================================*/
            //Color Mode
            'color_mode'     => 1,
            'code_mode_type' => 'light-mode',
            'color_black'    => '#18191a',
            'color_dark'     => '#242526',
            'color_bd_text'  => '#b0b3b8',
            'color_border'   => '#242526',

            //Base Color
            'primary_color'   => '#2d5be3',
            'secondary_color' => '#5edfff',

            // Menu
            'menu_text_color'       => '#ffffff',
            'menu_text_hover_color' => '#ffffff',
            
            // Submenu
            'submenu_bg_color'    => '#ffffff',
            'submenu_text_color'  => '#444444',
            'submenu_htext_color' => '#2d5be3',

            // Banner Color
            'nf_bg_color1'    => '#ff9800',
            'nf_bg_color2'    => '#ffea00',

            /* = 404 Error Area
            =======================================================*/
            'error_page_banner'   => '404 Error Page',
            'error_page_title'    => '404',
            'error_page_subtitle' => 'Sorry We Can not Find That Page!',
            'error_desc_text'     => 'There are many variations of passages of Lorem Ipsum available but the majority have some form by injected humour.',
            'error_buttontext'    => 'Take Me Home',  


            /* = Login Page
            =======================================================*/
            'cirkle_login_page_type' => 1,
            'login_page_header' => '',
            'login_page_footer' => '',
            'loginbg'        => '',
            'form_title'     => 'Sign In Your Account',
            'mapbg'          => '', 
            'location_icon1' => '', 
            'location_icon2' => '', 
            'location_icon3' => '', 
            'location_icon4' => '', 
            'registration_captcha_shortcode' => '', 


            /* = BuddyPress 
            ====================================================*/
            'logout_use_condition' => '',
            // Profile
            'profile_about_tab'    => 1,
            'profile_friends_tab'  => 1,
            'profile_groups_tab'   => 1,
            'profile_message_tab'  => 1,
            'profile_photos_tab'   => 1,
            'profile_videos_tab'   => 1,
            'profile_badges_tab'   => 1,
            'profile_forums_tab'   => 1,
            'profile_Settings_tab' => 1,
            // Tab text
            'bp_timeline_tab_text' => esc_html__( 'Timeline', 'cirkle' ),
            'bp_profile_tab_text'  => esc_html__( 'About', 'cirkle' ),
            'bp_friends_tab_text'  => esc_html__( 'Friends', 'cirkle' ),
            'bp_groups_tab_text'   => esc_html__( 'Groups', 'cirkle' ),
            'bp_messages_tab_text' => esc_html__( 'Messages', 'cirkle' ),
            'bp_photos_tab_text'   => esc_html__( 'Photos', 'cirkle' ),
            'bp_videos_tab_text'   => esc_html__( 'Videos', 'cirkle' ),
            'bp_badges_tab_text'   => esc_html__( 'Badges', 'cirkle' ),
            'bp_forums_tab_text'   => esc_html__( 'Forums', 'cirkle' ),
            'bp_settings_tab_text' => esc_html__( 'Settings', 'cirkle' ),
            // Tab position
            'bp_timeline_tab_p' => 10,
            'bp_profile_tab_p'  => 20,
            'bp_friends_tab_p'  => 30,
            'bp_groups_tab_p'   => 40,
            'bp_messages_tab_p' => 50,
            'bp_photos_tab_p'   => 60,
            'bp_videos_tab_p'   => 70,
            'bp_badges_tab_p'   => 80,
            'bp_forums_tab_p'   => 90,
            'bp_settings_tab_p' => 100,
            
            //Member
            'cirkle_mb_img'       => '',
            'cirkle_mb_shape_img' => '',
            'member_per_page'     => '8',
            'member_banner_title' => 'All Member Profiles',
            'member_banner_desc'  => 'Browse all the members of the community!',

            //Gruops
            'cirkle_gb_img'       => '',
            'cirkle_gb_shape_img' => '',
            'groups_per_page'     => '8',
            'groups_banner_title' => 'All Groups',
            'group_btn_profile'   => '',

            //Newsfeed
            'cirkle_nb_img'         => '',
            'cirkle_nb_shape_img'   => '',
            'newsfeed_banner_title' => 'Members Newsfeed',
            'newsfeed_banner_desc'  => 'Check what your friends have been up to!',

            //Newsfeed
            'cirkle_fb_img'       => '',
            'cirkle_fb_shape_img' => '',
            'forum_banner_title'  => 'Our Forums',
            

            /* = WooCommerce 
            ====================================================*/
            // Woo Common Features
            'shop_header_style' => '2',
            'shop_footer_style' => '2',
            'woo_banner_bgimg'  => '',
            'woo_banner_bgimage_overlay' => 'full-width',

            // Shop Page
            'wishlist' => '1',
            'quickview' => '1',
            'compare' => '1',
            'products_per_page' => '9',
            'products_cols_width' => '4',
            'wc_shop_compare_icon' => '1',
            'wc_shop_wishlist_icon' => '1',
            'wc_shop_quickview_icon' => '1',
            'woo_page_layout' => 'full-width',

            // Product Details
            'cklwc_related_product' => '1',
            'related_products_per_page' => '3',
            'related_products_cols' => '3',
            'wc_product_wishlist_icon' => '1',
            'wc_product_quickview_icon' => '1',
            'woo_product_details_layout' => 'full-width',
            
        );

        return apply_filters( 'rttheme_customizer_defaults', $customizer_defaults );
    }
}


