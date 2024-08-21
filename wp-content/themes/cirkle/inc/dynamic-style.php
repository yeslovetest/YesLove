<?php
/**
 * @author  RadiusTheme
 * @since   1.0
 * @version 1.0
 */

namespace radiustheme\cirkle;
use radiustheme\cirkle\RDTheme;
use radiustheme\cirkle\Helper;

/*-------------------------------------
	Typography Variable
-------------------------------------*/
$cirkle = CIRKLE_THEME_PREFIX_VAR;

/* = Body Typo Area
=======================================================*/
$typo_body = json_decode( RDTheme::$options['typo_body'], true );
if ($typo_body['font'] == 'Inherit') {
	$typo_body['font'] = 'Roboto';
} else {
	$typo_body['font'] = $typo_body['font'];
}

/* = Menu Typo Area
=======================================================*/
$typo_menu = json_decode( RDTheme::$options['typo_menu'], true );
if ($typo_menu['font'] == 'Inherit') {
	$typo_menu['font'] = 'Nunito';
} else {
	$typo_menu['font'] = $typo_menu['font'];
}


/* = Heading Typo Area
=======================================================*/
$typo_heading = json_decode( RDTheme::$options['typo_heading'], true );
if ($typo_heading['font'] == 'Inherit') {
	$typo_heading['font'] = 'Nunito';
} else {
	$typo_heading['font'] = $typo_heading['font'];
}
$typo_h1 = json_decode( RDTheme::$options['typo_h1'], true );
if ($typo_h1['font'] == 'Inherit') {
	$typo_h1['font'] = 'Nunito';
} else {
	$typo_h1['font'] = $typo_h1['font'];
}
$typo_h2 = json_decode( RDTheme::$options['typo_h2'], true );
if ($typo_h2['font'] == 'Inherit') {
	$typo_h2['font'] = 'Nunito';
} else {
	$typo_h2['font'] = $typo_h2['font'];
}
$typo_h3 = json_decode( RDTheme::$options['typo_h3'], true );
if ($typo_h3['font'] == 'Inherit') {
	$typo_h3['font'] = 'Nunito';
} else {
	$typo_h3['font'] = $typo_h3['font'];
}
$typo_h4 = json_decode( RDTheme::$options['typo_h4'], true );
if ($typo_h4['font'] == 'Inherit') {
	$typo_h4['font'] = 'Nunito';
} else {
	$typo_h4['font'] = $typo_h4['font'];
}
$typo_h5 = json_decode( RDTheme::$options['typo_h5'], true );
if ($typo_h5['font'] == 'Inherit') {
	$typo_h5['font'] = 'Nunito';
} else {
	$typo_h5['font'] = $typo_h5['font'];
}
$typo_h6 = json_decode( RDTheme::$options['typo_h6'], true );
if ($typo_h6['font'] == 'Inherit') {
	$typo_h6['font'] = 'Nunito';
} else {
	$typo_h6['font'] = $typo_h6['font'];
}

/*-------------------------------------
#. Typography
---------------------------------------*/

?>

body {
	font-family: '<?php echo esc_html( $typo_body['font'] ); ?>', sans-serif;
	font-size: <?php echo esc_html( RDTheme::$options['typo_body_size'] ) ?>;
	line-height: <?php echo esc_html( RDTheme::$options['typo_body_height'] ); ?>;
	font-weight : <?php echo esc_html( $typo_body['regularweight'] ) ?>;
	font-style: normal;
}
nav.template-main-menu > ul li a,
.footer-modern .footer-menu,
.template-main-menu nav > ul,
.mean-container .mean-nav {
	font-family: '<?php echo esc_html( $typo_menu['font'] ); ?>', sans-serif;
	font-size: <?php echo esc_html( RDTheme::$options['typo_menu_size'] ) ?>;
	line-height: <?php echo esc_html( RDTheme::$options['typo_menu_height'] ); ?>;
	font-weight : <?php echo esc_html( $typo_menu['regularweight'] ) ?>;
	font-style: normal;
}

nav.template-main-menu ul li ul.children li a, 
nav.template-main-menu ul li ul.sub-menu li a {
	font-family: '<?php echo esc_html( $typo_menu['font'] ); ?>', sans-serif;
	font-size: <?php echo esc_html( RDTheme::$options['typo_submenu_size'] ) ?>;
	line-height: <?php echo esc_html( RDTheme::$options['typo_submenu_height'] ); ?>;
	font-weight : <?php echo esc_html( $typo_menu['regularweight'] ) ?>;
	font-style: normal;
}

h1,h2,h3,h4,h5,h6 {
	font-family: '<?php echo esc_html( $typo_heading['font'] ); ?>', sans-serif !important;
	font-weight : <?php echo esc_html( $typo_heading['regularweight'] ); ?>;
}
<?php if (!empty($typo_h1['font'])) { ?>
h1 {
	font-family: '<?php echo esc_html( $typo_h1['font'] ); ?>', sans-serif !important;
	font-weight : <?php echo esc_html( $typo_h1['regularweight'] ); ?>;
}
<?php } ?>
h1 {
	font-size: <?php echo esc_html( RDTheme::$options['typo_h1_size'] ); ?>;
	line-height: <?php echo esc_html(  RDTheme::$options['typo_h1_height'] ); ?>;
	font-style: normal;
}
@media (max-width: 575px) {
	h1 {
	    font-size: 40px;
	}
}
<?php if (!empty($typo_h2['font'])) { ?>
h2 {
	font-family: '<?php echo esc_html( $typo_h2['font'] ); ?>', sans-serif !important;
	font-weight : <?php echo esc_html( $typo_h2['regularweight'] ); ?>;
}
<?php } ?>
h2 {
	font-size: <?php echo esc_html( RDTheme::$options['typo_h2_size'] ); ?>;
	line-height: <?php echo esc_html( RDTheme::$options['typo_h2_height'] ); ?>;
	font-style: normal;
}
@media (max-width: 575px) {
	h2 {
	    font-size: 32px;
	}
}
<?php if (!empty($typo_h3['font'])) { ?>
h3 {
	font-family: '<?php echo esc_html( $typo_h3['font'] ); ?>', sans-serif !important;
	font-weight : <?php echo esc_html( $typo_h3['regularweight'] ); ?>;
}
<?php } ?>
h3 {
	font-size: <?php echo esc_html( RDTheme::$options['typo_h3_size'] ); ?>;
	line-height: <?php echo esc_html(  RDTheme::$options['typo_h3_height'] ); ?>;
	font-style: normal;
}
@media (max-width: 575px) {
	h3 {
	    font-size: 24px;
	}
}
<?php if (!empty($typo_h4['font'])) { ?>
h4 {
	font-family: '<?php echo esc_html( $typo_h4['font'] ); ?>', sans-serif !important;
	font-weight : <?php echo esc_html( $typo_h4['regularweight'] ); ?>;
}
<?php } ?>
h4 {
	font-size: <?php echo esc_html( RDTheme::$options['typo_h4_size'] ); ?>;
	line-height: <?php echo esc_html(  RDTheme::$options['typo_h4_height'] ); ?>;
	font-style: normal;
}
@media (max-width: 575px) {
	h4 {
	    font-size: 22px;
	}
}
<?php if (!empty($typo_h5['font'])) { ?>
h5 {
	font-family: '<?php echo esc_html( $typo_h5['font'] ); ?>', sans-serif !important;
	font-weight : <?php echo esc_html( $typo_h5['regularweight'] ); ?>;
}
<?php } ?>
h5 {
	font-size: <?php echo esc_html( RDTheme::$options['typo_h5_size'] ); ?>;
	line-height: <?php echo esc_html(  RDTheme::$options['typo_h5_height'] ); ?>;
	font-style: normal;
}
<?php if (!empty($typo_h6['font'])) { ?>
h6 {
	font-family: '<?php echo esc_html( $typo_h6['font'] ); ?>', sans-serif !important;
	font-weight : <?php echo esc_html( $typo_h6['regularweight'] ); ?>;
}
@media (max-width: 575px) {
	h5 {
	    font-size: 18px;
	}
}
<?php } ?>
h6 {
	font-size: <?php echo esc_html( RDTheme::$options['typo_h6_size'] ); ?>;
	line-height: <?php echo esc_html(  RDTheme::$options['typo_h6_height'] ); ?>;
	font-style: normal;
}

<?php 
	/*-------------------------------------
	#. Cirkle Color Settings
	---------------------------------------*/
	// Menu Color
	$menu_text_color = RDTheme::$options['menu_text_color'];
	$menu_text_hover_color = RDTheme::$options['menu_text_hover_color'];
	// Sub Menu Color
	$subm_bg_color = RDTheme::$options['submenu_bg_color'];
	$subm_txt_color = RDTheme::$options['submenu_text_color'];
	$subm_htxt_color = RDTheme::$options['submenu_htext_color'];
	// Banner Menu Color
	$nf_bg_color1 = RDTheme::$options['nf_bg_color1'];
	$nf_bg_color2 = RDTheme::$options['nf_bg_color2'];
?>

<?php 
	/* = Cirkle Menu Color
	==============================================*/
	if (!empty( $menu_text_color )) {
?>
header nav.template-main-menu>ul>li>a {
	color: <?php echo esc_html( $menu_text_color ); ?>;
}
<?php } if (!empty( $menu_text_hover_color )) { ?>
nav.template-main-menu>ul>li>a:hover {
	color: <?php echo esc_html( $menu_text_hover_color ); ?>;
}

<?php }
	if (!empty( $subm_bg_color )) {
	/* = Cirkle Dropdown Menu Color
	==============================================*/
?>
nav.template-main-menu>ul>li.mega-menu.mega-menu-col-2 ul.children, 
nav.template-main-menu>ul>li.mega-menu.mega-menu-col-2 ul.sub-menu,
nav.template-main-menu>ul>li ul.children, 
nav.template-main-menu>ul>li ul.sub-menu {
	background-color: <?php echo esc_html( $subm_bg_color ); ?>;
}
nav.template-main-menu>ul>li.mega-menu.mega-menu-col-2 ul.children:before, 
nav.template-main-menu>ul>li.mega-menu.mega-menu-col-2 ul.sub-menu:before,
nav.template-main-menu>ul>li ul.children:before, 
nav.template-main-menu>ul>li ul.sub-menu:before {
    border-bottom: 10px solid <?php echo esc_html( $subm_bg_color ); ?>;
}
<?php } if (!empty( $subm_txt_color )) { ?>
nav.template-main-menu>ul>li ul.children li a, 
nav.template-main-menu>ul>li ul.sub-menu li a {
	color: <?php echo esc_html( $subm_txt_color ); ?>;
}
<?php } if (!empty( $subm_htxt_color )) { ?>
nav.template-main-menu>ul>li ul.children li a:focus, 
nav.template-main-menu>ul>li ul.children li a:hover, 
nav.template-main-menu>ul>li ul.sub-menu li a:focus, 
nav.template-main-menu>ul>li ul.sub-menu li a:hover {
    color: <?php echo esc_html( $subm_htxt_color ); ?>;
}
<?php } 
if (!empty( $nf_bg_color1 || $nf_bg_color2 )) {
	/* = Banner Background Color
	==============================================*/
?>

.newsfeed-banner {
    background-image: linear-gradient(to right,<?php echo esc_html( $nf_bg_color1 ); ?>,<?php echo esc_html( $nf_bg_color2 ); ?>);
}


<?php }
	$primary_color = RDTheme::$options['primary_color'];

	if (!empty( $primary_color )) {
	/* = Cirkle Base Primary Color
	==============================================*/
?>
		<?php //Color ?>
		.fixed-header .header-control .dropdown-friend .dropdown-menu .item-body .media .item-title a:hover,
		.fixed-header .header-control .dropdown-admin .dropdown-menu .admin-options a:hover i,
		.fixed-header .header-control .dropdown-admin .dropdown-menu .admin-options a:hover,
		.bbp-replies .bbp-reply-header .bbp-meta span.bbp-header a.bbp-topic-permalink,
		.bbp-topics li.bbp-body li.bbp-topic-title .topic-meta-content a:hover,
		.why-choose-box .features-list .media:hover .media-body .item-title,
		ul.minicart>li .media .cart-content ul li .cart-title-line1 a:hover,
		.profile-item-body .profile .bp-widget .profile-fields td.data a,
		ul.minicart>li .media .cart-content ul li .cart-title-line3 span,
		.post-view .post-body .post-friends-view .profile-name a:hover,
		.fixed-sidebar .sidebar-menu-wrap .side-menu .menu-link:hover,
		#bbpress-forums li.bbp-body ul li .bbp-forum-content a:hover, 
		.user-single-blog .blog-entry-header .entry-meta li a:hover,
		ul.minicart>li .media .cart-content ul li .cart-title-line3,
		.blog-grid .blog-box .blog-content .entry-meta li a:hover,
		.messages .profile-item-body .messages-notices a:hover,
		.user-single-blog .blog-entry-header .entry-meta li i,
		#bbpress-forums li.bbp-body ul li .meta-info a:hover,
		.product-box .product-content .item-category a:hover,
		.product-box .product-content .product-title a:hover,
		.user-search-bar .user-view-switcher li.active a,
		.cirkle-group-list li .item .item-title a:hover,
		.user-blog .blog-content .blog-title a:hover,
		.product-box .product-content .product-price,
		form.woocommerce-cart-form table.cart td a, 
		form.woocommerce-cart-form table.cart th a,
		.user-blog .blog-content .entry-meta li i,
		.single-product .product-content p.price,
		.dropdown-message .media .item-title a,
		footer .widget_nav_menu ul li a:hover,
		.widget-author .author-name a:hover,
		.footer-bottom .footer-copyright a,
		.woocommerce-privacy-policy-link,
		figure.wp-block-table table th a,
		.section-heading .item-subtitle,
		.user-blog .blog-meta ul li i,
		.woocommerce-message::before,
		.woocommerce-info::before,
		.scrollup:hover,
		.comment-text a,
		.profile p a,
		a.showcoupon {
			color: <?php echo esc_html( $primary_color ); ?> !important;
		}

		<?php //Background Color ?>
		.woocommerce-account .addresses .title h3:before, .woocommerce-additional-fields h2:after, .woocommerce-additional-fields h2:before, .woocommerce-additional-fields h3:after, .woocommerce-additional-fields h3:before, .woocommerce-billing-fields h2:after, .woocommerce-billing-fields h2:before, .woocommerce-billing-fields h3:after, .woocommerce-billing-fields h3:before, .woocommerce-customer-details h2:after, .woocommerce-customer-details h2:before, .woocommerce-customer-details h3:after, .woocommerce-customer-details h3:before, .woocommerce-order-details h2:after, .woocommerce-order-details h2:before, 
		.cart-collaterals h2:after, .cart-collaterals h2:before, .cart-collaterals h3:after, .cart-collaterals h3:before, 
		.wc-order-review-wrapper h2:after, .wc-order-review-wrapper h2:before, .wc-order-review-wrapper h3:after, 
		.woocommerce-account .addresses .title h2:before, .woocommerce-account .addresses .title h3:after, 
		.wc-order-review-wrapper h3:before, .woocommerce-account .addresses .title h2:after, 
		.woocommerce-order-details h3:after, .woocommerce-order-details h3:before,
		.bbp-replies li.bbp-body .cirkle-type-topic .bbp-reply-author-info .author-reply-content .title-user-status .bbp-author-role,
		.bbp-pagination-links a:hover, .bbp-pagination-links span:hover, .pagination a:hover, .pagination span:hover,
		.contact-page .contact-box-wrap .contact-box .item-title:before,
		.banner-newsletter .newsletter-box .frm-fluent-form .ff_submit_btn_wrapper .ff-btn-submit,
		.single-product .product-content .single-add-to-cart-wrapper .single_add_to_cart_button,
		.bbp-pagination-links span.page-numbers.current, .pagination span.page-numbers.current,
		.settings .profile-item-body h2:after, .settings .profile-item-body h2:before,
		.fixed-header .header-control .dropdown .dropdown-menu .item-footer .view-btn,
		.woocommerce a.button, .woocommerce button.button, .woocommerce input.button,
		.settings .profile-item-body .standard-form .submit input[type=submit],
		.group-main-page .tabs-with-search div.dir-search .search-btn:hover,
		.contact-page .contact-box-wrap .contact-form .fluentform .ff-btn,
		.contact-page .contact-box-wrap .contact-box .item-title:after,
		.woocommerce div.product .woocommerce-tabs ul.tabs li a:after,
		.post-input-tab .post-footer .submit-btn input[type=submit],
		.groups-popular .groups-box .item-content .groups-member,
		.why-choose-box .features-list .media:hover .item-icon,
		.bbpress-wrapper h2:after, .bbpress-wrapper h2:before,
		.bp-avatar-nav ul.avatar-nav-items li.current a,
		.user-search-bar .input-group .search-btn:hover,
		.about-us-img .item-video .video-icon .play-btn,
		.user-blog .blog-content .blog-category a,
		.blog-grid .blog-box .blog-img .blog-date,
		.messages-options-nav input[type=submit], 
		.message-search form input[type=submit],
		.profile h2:after, .profile h2:before,
		.create-form-body input[type=submit],
		.user-top-header .menu-list li:after,
		.footer-box .footer-title:before,
		.footer-box .footer-title:after,
		ul.minicart>li .checkout-link a,
		#bbpress-forums li.bbp-header,
		.bp-unverified-badge-tooltip, 
		.pagination ul li.active a,
		.fixed-header .header-menu,
		.bp-verified-badge-tooltip,
		.pagination ul li a:hover,
		.woocommerce span.onsale,
		.form-group .submit-btn,
		input#bp-browse-button,
		#bp-data-export button, 
		li.more-badges a,
		.tooltip-inner,
		.xm-tooltip,
		.rt-sticky,
		.scrollup {
		    background-color: <?php echo esc_html( $primary_color ); ?> !important;
		}
		<?php //Border Color ?>
		.bp-avatar-nav ul.avatar-nav-items li.current {
			border-color: <?php echo esc_html( $primary_color ); ?>;
		}
		.bp-unverified-badge-tooltip[x-placement=top] .bp-unverified-badge-tooltip-arrow, 
		.bp-unverified-badge-tooltip[x-placement=top] .bp-verified-badge-tooltip-arrow, 
		.bp-verified-badge-tooltip[x-placement=top] .bp-unverified-badge-tooltip-arrow, 
		.bp-verified-badge-tooltip[x-placement=top] .bp-verified-badge-tooltip-arrow,
		.bs-tooltip-top .arrow::before,
		.woocommerce-message,
		.woocommerce-info {
		    border-top-color: <?php echo esc_html( $primary_color ); ?>;
		}
		.bs-tooltip-right .arrow::before {
		    border-right-color: <?php echo esc_html( $primary_color ); ?>;
		}

		.bs-tooltip-bottom .arrow::before {
		    border-bottom-color: <?php echo esc_html( $primary_color ); ?>;
		}

		.widget-banner .item-btn svg path {
		    fill: <?php echo esc_html( $primary_color ); ?>;
		}

		.team-circle .team-box .item-img:before {
		    background-color: rgba(<?php echo Helper::hex2rgb( $primary_color ); ?>,.85);
		}

<?php } ?>



<?php
	$secondary_color = RDTheme::$options['secondary_color'];

	if (!empty( $secondary_color )) {
	/* = Cirkle Base Secondary Color
	==============================================*/
?>
<?php //Color ?>
.fixed-header .header-control .dropdown-friend .dropdown-menu .item-body .media .item-title a,
.user-earned-grid .gamipress-achievement-description h2.gamipress-achievement-title a:hover,
.bbp-replies .bbp-reply-header .bbp-meta span.bbp-reply-post-date:before,
.bbp-replies .bbp-reply-header .bbp-meta a.bbp-reply-permalink,
.cart-collaterals .cart_totals .wc-proceed-to-checkout a:hover,
.contact-page .contact-box-wrap .contact-method ul li i,
.blog-grid .blog-box .blog-content .blog-title a:hover,
.dropdown-menu .item-heading h6.heading-title span,
.location-box .item-content button.btn:hover:hover,
form.woocommerce-cart-form table.cart td a:hover, 
form.woocommerce-cart-form table.cart th a:hover,
.quantity .input-group-btn span.quantity-btn i,
.header-action ul .header-search-icon a:hover,
.header-action ul .header-social a:hover,
.progress-box .media .item-icon {
	color: <?php echo esc_html( $secondary_color ); ?> !important;
}
<?php //Background Color ?>
.single-product .product-content .single-add-to-cart-wrapper .single_add_to_cart_button:hover,
.category-markup.tag-html blockquote:before, .category-post-formats.tag-quote blockquote:before, 
.wp-block-quote.has-text-align-right:before, .wp-block-quote.is-large:before, 
.wp-block-quote.is-style-large:before, blockquote.wp-block-quote:before,
.comment-text blockquote:before, .page-content-main blockquote:before, 
.fixed-header .header-control .dropdown .dropdown-menu .item-footer .view-btn:hover,
.bp-verified-member .item-title > a:after, .bp-verified-member > .author > a:after, 
.contact-page .contact-box-wrap .contact-form .fluentform .ff-btn:hover,
.bp-verified-badge, .bp-verified-member .member-name-item > a:after, 
ul.minicart>li .media .cart-content ul li.minicart-remove a:hover,
.post-input-tab .post-footer .submit-btn input[type=submit]:hover,
.widget-author .author-statistics li.action .friendship-button i,
.group-main-page .tabs-with-search div.dir-search .search-btn,
.loadmore-badges .lmbtn-box .gamipress-load-more-button:hover,
.fixed-header .header-control .input-group .submit-btn,
.fixed-header .header-control .header2-login a:hover,
.location-box .item-content button.btn:hover:before,
.user-single-blog .blog-content blockquote:before,
.user-blog .blog-content .blog-category a:hover,
.user-timeline-header .menu-list li a:before,
.bp-verified-member .member-name > a:after,
.user-group .member-thumb li:last-child a,
.post-input-tab .nav-tabs .nav-link:after,
.user-search-bar .input-group .search-btn,
.header-action ul .login-btn a:hover,
.quantity .input-group-btn:hover,
.widget-banner .item-btn:hover,
.form-group .submit-btn:hover,
.item-options a:hover,
.button-slide:after {
    background-color: <?php echo esc_html( $secondary_color ); ?> !important;
}
<?php //Border Color ?>
ul.minicart>li .media .cart-content ul li.minicart-remove a:hover, 
.item-options a:hover,
#drag-drop-area {
	border-color: <?php echo esc_html( $secondary_color ); ?>;
}
<?php } ?>


<?php 
	$color_black = RDTheme::$options['color_black'];
	$color_dark = RDTheme::$options['color_dark'];
	$color_bd_text = RDTheme::$options['color_bd_text'];
	$color_border = RDTheme::$options['color_border'];
?>

<?php // 01 Black Background Color ?>
[data-theme="dark-mode"] #bbpress-forums .bbp-pagination-links span.current, 
[data-theme="dark-mode"] #bbpress-forums .bbp-pagination-links a:hover, 
[data-theme="dark-mode"] #bbpress-forums .bbp-topic-pagination a:hover,
[data-theme="dark-mode"] .loadmore-badges .lmbtn-box .gamipress-load-more-button:hover,
[data-theme="dark-mode"] .user-search-bar .input-group .search-btn,
[data-theme="dark-mode"] .bg-link-water,
[data-theme="dark-mode"] .rt-sticky,
[data-theme="dark-mode"] body {
    background-color: <?php echo esc_html( $color_black ); ?> !important;
}
<?php // 02 Dark Background Color ?>
[data-theme="dark-mode"] .fixed-header .header-control .input-group .submit-btn,
[data-theme="dark-mode"] .fixed-sidebar .sidebar-menu-wrap,
[data-theme="dark-mode"] .fixed-sidebar .sidebar-toggle,
[data-theme="dark-mode"] .fixed-header .header-menu,
[data-theme="dark-mode"] input#bp-browse-button,
[data-theme="dark-mode"] .block-box {
    background-color: <?php echo esc_html( $color_dark ); ?> !important;
}
[data-theme="dark-mode"] .banner-newsletter .newsletter-box .frm-fluent-form .ff_submit_btn_wrapper .ff-btn-submit:hover,
[data-theme="dark-mode"] .contact-page .contact-box-wrap .contact-form .fluentform .ff-btn:hover {
	color: #ffffff !important;
	background-color: <?php echo esc_html( $secondary_color ); ?> !important;
}
[data-theme="dark-mode"] .single-product .product-content .single-add-to-cart-wrapper .single_add_to_cart_button,
[data-theme="dark-mode"] .messages .profile-item-body .item-list-tabs .message-search form input[type=submit],
[data-theme="dark-mode"] .cirkle-message-details .standard-form .message-content .submit input[type=submit],
[data-theme="dark-mode"] .bp-avatar-nav ul.avatar-nav-items li.current a,
[data-theme="dark-mode"] .post-input-tab .nav-tabs .nav-link:after,
[data-theme="dark-mode"] .messages-options-nav input[type=submit],

[data-theme="dark-mode"] #bbpress-forums li.bbp-header,
[data-theme="dark-mode"] .item-options a:hover {
	background-color: #2c2c2c !important;
}
[data-theme="dark-mode"] .post-view .post-footer .post-share .share-list {
	background-color: #3e3e3e !important;
}
[data-theme="dark-mode"] .contact-page .contact-box-wrap .contact-box .item-title:before,
[data-theme="dark-mode"] .contact-page .contact-box-wrap .contact-box .item-title:after,
[data-theme="dark-mode"] .settings .profile-item-body h2:before,
[data-theme="dark-mode"] .settings .profile-item-body h2:after,
[data-theme="dark-mode"] .form-check input[type=checkbox]:checked+label:before,
[data-theme="dark-mode"] .login-page-wrap .tab-content .item-title:before,
[data-theme="dark-mode"] .login-page-wrap .tab-content .item-title:after,
[data-theme="dark-mode"] .bbpress-wrapper h2:before,
[data-theme="dark-mode"] .bbpress-wrapper h2:after,
[data-theme="dark-mode"] .profile h2:before,
[data-theme="dark-mode"] .profile h2:after {
	background-color: #8793a3 !important;
}
[data-theme="dark-mode"] .settings .profile-item-body .standard-form .submit input[type=submit],
[data-theme="dark-mode"] .group-main-page .tabs-with-search div.dir-search .search-btn,
[data-theme="dark-mode"] .user-group .member-thumb li:last-child a,
[data-theme="dark-mode"] .contact-page .contact-box-wrap .contact-form .fluentform .ff-btn,
[data-theme="dark-mode"] .woocommerce span.onsale,
[data-theme="dark-mode"] .user-blog .blog-content .woocommerce span.onsale,
[data-theme="dark-mode"] #bp-data-export button {
	background-color: #35353e !important;
}
<?php // 03 Black/Dark Background Text Color ?>
[data-theme="dark-mode"] .loadmore-badges .lmbtn-box .gamipress-load-more-button:hover,
[data-theme="dark-mode"] .user-single-blog .blog-entry-header .entry-meta li i,
[data-theme="dark-mode"] .product-box .product-content .product-price,
[data-theme="dark-mode"] .single-product .product-content p.price,
[data-theme="dark-mode"] .dropdown-message .media .item-title a,
[data-theme="dark-mode"] .woocommerce-info::before {
	color: <?php echo esc_html( $color_bd_text ); ?> !important;
}
[data-theme="dark-mode"] ul.minicart>li .media .cart-content ul li .cart-title-line3 span,
[data-theme="dark-mode"] ul.minicart>li .media .cart-content ul li .cart-title-line3,
[data-theme="dark-mode"] .quantity .input-group-btn span.quantity-btn i,
[data-theme="dark-mode"] .fixed-header .header-control .header2-login a,
[data-theme="dark-mode"] form.woocommerce-cart-form table.cart td a,
[data-theme="dark-mode"] .section-heading .item-subtitle,
[data-theme="dark-mode"] .section-heading .item-title,
[data-theme="dark-mode"] .button-slide {
	color: #e4e6eb !important;
}
[data-theme="dark-mode"] .elementor-section-wrap .elementor-section.banner-newsletter,
[data-theme="dark-mode"] .elementor-section-wrap .elementor-section.dark-bg,
[data-theme="dark-mode"] .why-choose-fluid .why-choose-content,
[data-theme="dark-mode"] .footer-wrap .main-footer,
[data-theme="dark-mode"] .breadcrumbs-banner,
[data-theme="dark-mode"] .banner-newsletter,
[data-theme="dark-mode"] .button-slide,
[data-theme="dark-mode"] .banner-apps,
[data-theme="dark-mode"] .hero-banner,
[data-theme="dark-mode"] .footer-wrap,
[data-theme="dark-mode"] .dark-bg {
    background-color: <?php echo esc_html( $color_dark ); ?> !important;
}

<?php // 04. Black/Dark Border Color ?>
[data-theme="dark-mode"] .form-check input[type=checkbox]:checked+label:before {
	border-color: #8793a3 !important;
}
[data-theme="dark-mode"] ul.minicart>li .media .cart-content ul li.minicart-remove a:hover, 
[data-theme="dark-mode"] .item-options a:hover, #drag-drop-area,
[data-theme="dark-mode"] .bp-avatar-nav ul.avatar-nav-items li {
	border-color: #2c2c2c;
}