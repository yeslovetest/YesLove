<?php
/**
 * @author  RadiusTheme
 * @since   1.0
 * @version 1.0
 */

namespace radiustheme\cirkle;
use radiustheme\cirkle\RDTheme;
use radiustheme\cirkle\Helper;

/*---------------------------------------------------------------------------------*/
/*  WooCommerce settings
/*---------------------------------------------------------------------------------*/

class CKLWC_Functions {

	protected static $instance = null;

	public function __construct() {
		/* Theme supports for WooCommerce */
		add_action( 'after_setup_theme', array( $this, 'theme_support' ) );

		/* ====== Shop/Archive Wrapper ====== */
		// Remove
		add_filter( 'woocommerce_show_page_title',        '__return_false' );
		remove_action( 'woo_main_before',                 'woo_display_breadcrumbs', 10 );
		remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20, 0 );
		remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10 );
		remove_action( 'woocommerce_sidebar',             'woocommerce_get_sidebar', 10 );
		remove_action( 'woocommerce_after_main_content',  'woocommerce_output_content_wrapper_end', 10 );
		remove_action( 'woocommerce_after_shop_loop',     'woocommerce_pagination', 10 );
		remove_action( 'woocommerce_cart_collaterals',    'woocommerce_cross_sell_display' );
		remove_action( 'woocommerce_before_shop_loop', 'woocommerce_result_count', 20 );
		remove_action( 'woocommerce_before_shop_loop', 'woocommerce_output_all_notices', 10 );
		remove_action( 'woocommerce_before_shop_loop', 'woocommerce_result_count', 20 );
		// Add
		add_action( 'woocommerce_before_shop_loop', 'woocommerce_output_all_notices', 20 );
		add_action( 'woocommerce_before_shop_loop', 'woocommerce_result_count', 10 );
		add_action( 'loop_shop_per_page',                  array( $this, 'artex_loop_shop_per_page' ), 20 );
		add_action( 'woocommerce_after_shop_loop',         array( $this, 'artex_products_paginations' ), 10 );
		add_action( 'rt_product_cats_loop',                array( $this, 'woocommerce_product_category' ), 100 );
		
		/* Yith Wishlist */ 
		if ( function_exists( 'YITH_WCWL_Frontend' ) && class_exists( 'YITH_WCWL_Ajax_Handler' )  ) {
			$wishlist_init = YITH_WCWL_Frontend();
			remove_action( 'wp_head',                                   array( $wishlist_init, 'add_button' ) );
			add_action( 'wp_ajax_cirkle_add_to_wishlist',                array( $this, 'add_to_wishlist' ) );
			add_action( 'wp_ajax_nopriv_cirkle_add_to_wishlist',         array( $this, 'add_to_wishlist' ) );
		}

		/* ====== Shop/Details ====== */
		remove_action( 'woocommerce_product_description_heading',  '__return_null' );
		remove_action( 'woocommerce_after_single_product_summary',  'woocommerce_upsell_display', 15 );
		// Single Product Layout
		add_action( 'init', array( $this, 'single_product_layout_hooks' ) );

		/* ====== Checkout Page ====== */
		add_filter( 'woocommerce_checkout_fields', array( $this, 'artex_checkout_fields' ) );

		/* ====== Mini Cart ====== */
		add_action( 'cirkle_woo_cart_icon', array( $this, 'cirkle_wc_cart_count' ) );
		add_action( 'woocommerce_add_to_cart_fragments', array( $this, 'cirkle_header_add_to_cart_fragment' ) );
		add_action( 'wp_ajax_cirkle_product_remove', array( $this, 'cirkle_product_remove' ) );
        add_action( 'wp_ajax_nopriv_cirkle_product_remove', array( $this, 'cirkle_product_remove' ) );
	}
	public static function instance() {
		if ( null == self::$instance ) {
			self::$instance = new self;
		}
		return self::$instance;
	}

	public function theme_support() {
		add_theme_support( 'woocommerce', array(
			'gallery_thumbnail_image_width' => 150,
			'thumbnail_image_width' => 450
		) );
		add_theme_support( 'wc-product-gallery-zoom' );
		add_theme_support( 'wc-product-gallery-slider' );
		add_theme_support( 'wc-product-gallery-lightbox' );
		add_post_type_support( 'product', 'page-attributes' );
	}

	public function loop_shop_columns(){
		$cols = RDTheme::$options['products_cols_width'];
		return $cols.' '.'products-list-wrap';
	}

	public function artex_products_paginations(){
		Helper::pagination();
	}

	// Template Loader
	public static function get_template_part( $template, $args = array() ){
		extract( $args );

		$template = '/' . $template . '.php';

		if ( file_exists( get_stylesheet_directory() . $template ) ) {
			$file = get_stylesheet_directory() . $template;
		}
		else {
			$file = get_template_directory() . $template;
		}

		require $file;
	}
	public static function get_custom_template_part( $template, $args = array() ){
		$template = 'woocommerce/custom/template-parts/' . $template;
		self::get_template_part( $template, $args );
	}

	/* = Single Page
	=============================================================================*/
	public function single_product_layout_hooks() {
		// Remove Action
		remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_title', 5 );
		remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_rating', 10 );
		remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 10 );
		remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 20 );
		remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30 );
		remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40 );
		remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_sharing', 50 );
		remove_action( 'woocommerce_after_single_product_summary',  'woocommerce_output_related_products', 20 );
		add_filter( 'woocommerce_product_description_heading', '__return_null' );
		add_filter( 'woocommerce_product_additional_information_heading', '__return_null' );

		// Add Action
		add_action( 'woocommerce_single_product_summary', array( $this, 'cirkle_show_cats_single_product' ), 5 );
		add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_title', 5 );
		add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 10 );
		add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 20 );
		add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 30 );
		add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 40 );

		add_action( 'cirkle_pd_related_posts', 'woocommerce_output_related_products' );
		add_filter( 'woocommerce_output_related_products_args', array( $this, 'cirkle_related_products_settings' ), 9999 );

		// Add to cart button
		add_action( 'woocommerce_before_add_to_cart_button', array( $this, 'add_to_cart_button_wrapper_start' ), 3 );
		add_action( 'woocommerce_after_add_to_cart_button',  array( $this, 'add_to_cart_button_wrapper_end' ), 90 );
	}

	public function cirkle_pd_related_posts(){
		//Function for related product hook
	}

	public function add_to_cart_button_wrapper_start(){
		echo '<div class="single-add-to-cart-wrapper">';
	}

	public function add_to_cart_button_wrapper_end(){
		echo '</div>';
	}

	public function cirkle_related_products_settings( $args ) {
		$args['posts_per_page'] = RDTheme::$options['related_products_per_page']; // # of related products
		$args['columns'] = RDTheme::$options['related_products_cols']; // # of columns per row
		return $args;
	}
 
	public function cirkle_show_cats_single_product() {
	    global $product;
	   ?>
	   <div class="product_cat_meta">
	   <?php echo wc_get_product_category_list( $product->get_id(), ', ', '<span class="posted_in">' . _n( '', '', count( $product->get_category_ids() ), 'cirkle' ) . ' ', '</span>' ); ?> 
	   </div>
	   <?php
	}
 
	/* = Shop Page
	=============================================================================*/
	public static function get_product_thumbnail( $product, $thumb_size = 'woocommerce_thumbnail' ) {
		$thumbnail   = $product->get_image( $thumb_size, array(), false );
		if ( !$thumbnail ) {
			$thumbnail = wc_placeholder_img( $thumb_size );
		}
		return $thumbnail;
	}

	public static function get_product_thumbnail_link( $product, $thumb_size = 'woocommerce_thumbnail' ) {
		return '<a href="'.esc_attr( $product->get_permalink() ).'">'.self::get_product_thumbnail( $product, $thumb_size ).'</a>';
	}

	public static function print_quickview_icon( $icon = true, $text = false ){
		if ( !function_exists( 'YITH_WCQV_Frontend' ) ) {
			return false;
		}

		if ( is_shop() && !RDTheme::$options['wc_shop_quickview_icon'] ) {
			return false;
		}

		if ( is_product() && !RDTheme::$options['wc_product_quickview_icon'] ) {
			return false;
		}

		global $product;

		$html = '';

		if ( $icon ) {
			$html .= '<i class="icofont-eye-open"></i>';
		}

		if ( $text ) {
			$html .= '<span>' . esc_html__( 'QuickView', 'cirkle' ) . '</span>';
		}
		// wp_kses_post( $data )

		?>
		<a href="#" class="yith-wcqv-button" data-product_id="<?php echo esc_attr( $product->get_id() ); ?>" title="<?php esc_attr_e( 'QuickView', 'cirkle' ); ?>">
			<?php echo wp_kses_post($html); ?>
		</a>
		<?php
	}

	public static function print_add_to_cart_icon( $product_id, $icon = true, $text = true ){
		global $product;
		$quantity = 1;
		$class = implode( ' ', array_filter( array(
			'action-cart',
			'product_type_' . $product->get_type(),
			$product->is_purchasable() && $product->is_in_stock() ? 'add_to_cart_button' : '',
			$product->supports( 'ajax_add_to_cart' ) ? 'ajax_add_to_cart' : '',
		) ) );

		$html = '';

		$product_cart_id = WC()->cart->generate_cart_id( $product_id );
	    $in_cart = WC()->cart->find_product_in_cart( $product_cart_id );

		 if ( $in_cart ) {
			if ( $text ) {
				$html .= '<span>Already in cart</span>';
			}
		} else {
			if ( $text ) {
				$html .= '<span>' . $product->add_to_cart_text() . '</span>';
			}
		}
		
	    if ( $in_cart ) {
			echo sprintf( '<a rel="nofollow" title="%s" href="%s" data-quantity="%s" data-product_id="%s" data-product_sku="%s">' . $html . '<i class="icofont-check"></i></a>',
				esc_attr( $product->add_to_cart_text() ),
				esc_url( wc_get_cart_url() ),
				esc_attr( isset( $quantity ) ? $quantity : 1 ),
				esc_attr( $product->get_id() ),
				esc_attr( $product->get_sku() )
			);
		} else {
			echo sprintf( '<a rel="nofollow" title="%s" href="%s" data-quantity="%s" data-product_id="%s" data-product_sku="%s" class="%s">' . $html . '</a>',
				esc_attr( $product->add_to_cart_text() ),
				esc_url( $product->add_to_cart_url() ),
				esc_attr( isset( $quantity ) ? $quantity : 1 ),
				esc_attr( $product->get_id() ),
				esc_attr( $product->get_sku() ),
				esc_attr( isset( $class ) ? $class : 'action-cart' )
			);
		}
	}

    public function artex_loop_shop_per_page( $products ) {
        // Return the number of products you wanna show per page.
        $shop_posts_per_page = RDTheme::$options['products_per_page'];
        if (!empty($shop_posts_per_page)) {
           $products = $shop_posts_per_page;
        } else {
            $products = '9';
        }
        return $products;
    }

	public static function print_compare_icon( $icon = true, $text = true ){
		if ( !class_exists( 'YITH_Woocompare' ) ) {
			return false;
		}

		if ( is_shop() && !RDTheme::$options['wc_shop_compare_icon'] ) {
			return false;
		}

		if ( is_product() && !RDTheme::$options['wc_product_compare_icon'] ) {
			return false;
		}

		global $product;
		global $yith_woocompare;
		$id  = $product->get_id();
		$url = method_exists( $yith_woocompare->obj, 'add_product_url' ) ? $yith_woocompare->obj->add_product_url( $id ) : '';

		$html = '';

		if ( $icon ) {
			$html .= '<i class="icofont-random"></i>';
		}

		// if ( $text ) {
		// 	$html .= '<span>' . esc_html__( 'Add to Compare', 'cirkle' ) . '</span>';
		// }

		?>
		<a href="<?php echo esc_url( $url );?>" class="compare" data-product_id="<?php echo esc_attr( $id );?>" title="<?php esc_attr_e( 'Add To Compare', 'cirkle' ); ?>"><?php echo wp_kses_post( $html ); ?></a>
		<?php
	}

	// Wishlist
	public static function print_add_to_wishlist_icon( $icon = true, $text = false ){
		// echo "Hello";
		// exit;
		if ( !defined( 'YITH_WCWL' ) ) {
			return false;
		}

		if ( is_shop() && !RDTheme::$options['wc_shop_wishlist_icon'] ) {
			return false;
		}

		if ( is_product() && !RDTheme::$options['wc_product_wishlist_icon'] ) {
			return false;
		}

		self::get_custom_template_part( 'wishlist-icon', compact( 'icon', 'text' ) );
	}

	// Wishlist 2
	public static function print_add_to_wishlist2_icon( $icon = true, $text = true ){
		if ( !defined( 'YITH_WCWL' ) ) {
			return false;
		}

		if ( is_shop() && !RDTheme::$options['wc_shop_wishlist_icon'] ) {
			return false;
		}

		if ( is_product() && !RDTheme::$options['wc_product_wishlist_icon'] ) {
			return false;
		}

		self::get_custom_template_part( 'wishlist2-icon', compact( 'icon', 'text' ) );
	}

	public function add_to_wishlist() {
		\YITH_WCWL_Ajax_Handler::add_to_wishlist();
		wp_die();
	}

	public static function get_stock_status() {
		global $product;
		return $product->is_in_stock() ? esc_html__( 'In Stock', 'cirkle' ) : esc_html__( 'Out of Stock', 'cirkle' );
	}

	public function woocommerce_product_category() {
	    global $post;
	    $terms = get_the_terms( $post->ID, 'product_cat' );
	    $nterms = get_the_terms( $post->ID, 'product_tag'  );
        foreach ($terms  as $term  ) {                    
            $product_cat_id = $term->term_id;              
            $product_cat_name = $term->name; 
            $product_cat_link = $term->name;            
            break;
        }
	    echo wp_kses( $product_cat_name, 'alltext_allow' );
	}

	// WooCommerce Checkout Fields Hook
    public function artex_checkout_fields( $fields ) {
        $fields['billing']['billing_first_name']['placeholder'] = esc_html__( 'First Name', 'cirkle' );
        $fields['billing']['billing_first_name']['label'] = false;
        $fields['billing']['billing_last_name']['placeholder'] = esc_html__( 'Last Name', 'cirkle' );
        $fields['billing']['billing_last_name']['label'] = false;

        $fields['billing']['billing_company']['placeholder'] = esc_html__( 'Company Name', 'cirkle' );
        $fields['billing']['billing_company']['label'] = false;

        $fields['billing']['billing_country']['placeholder'] = esc_html__( 'Country', 'cirkle' );
        $fields['billing']['billing_country']['label'] = esc_html__( 'Select Your Country', 'cirkle' );

        $fields['billing']['billing_address_1']['placeholder'] = esc_html__( 'Street Address', 'cirkle' );
        $fields['billing']['billing_address_1']['label'] = false;
        $fields['billing']['billing_address_2']['placeholder'] = esc_html__( 'Apartment, Unite ( optional )', 'cirkle' );
        $fields['billing']['billing_address_2']['label'] = false;

        $fields['billing']['billing_city']['placeholder'] = esc_html__( 'Town / City', 'cirkle' );
        $fields['billing']['billing_city']['label'] = false;

        $fields['billing']['billing_state']['placeholder'] = esc_html__( 'County', 'cirkle' );
        $fields['billing']['billing_state']['label'] = false;

        $fields['billing']['billing_postcode']['placeholder'] = esc_html__( 'Post Code / Zip', 'cirkle' );
        $fields['billing']['billing_postcode']['label'] = false;

        $fields['billing']['billing_email']['placeholder'] = esc_html__( 'Email Address', 'cirkle' );
        $fields['billing']['billing_email']['label'] = false;

        $fields['billing']['billing_phone']['placeholder'] = esc_html__( 'Phone', 'cirkle' );
        $fields['billing']['billing_phone']['label'] = false;

        return $fields;
    }

    /*------------------------------------------------------------------*/
    /* Woo Mini Cart
    /*------------------------------------------------------------------*/

    //Minicart Callback Function
    public static function CirkleWooMiniCart(){
        ob_start();
        if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
            do_action( 'cirkle_woo_cart_icon' );
        }
        $woo_cart_out = ob_get_clean();
        $woo_cart_out = '<div class="header-action-item mini-cart-items header-shop-cart">'. $woo_cart_out .'</div>';
        echo wp_kses( $woo_cart_out, 'alltext_allow' );
    }

    /**
     * Add Cart icon and count to header if WC is active
     */
    public function cirkle_cart_items(){
        $empty_cart = '<li class="cart-item d-flex align-items-center"><h5 class="text-center no-cart-items">'. apply_filters( 'cirkle_woo_mini_cart_empty', esc_html__('Your cart is empty', 'cirkle') ) .'</h5></li>';

        if(is_null(WC()->cart)) {
        	return $empty_cart;
		} 

		if ( WC()->cart->get_cart_contents_count() == 0 ) return $empty_cart;

        ob_start();
        
        $shop_page_url = get_permalink( wc_get_page_id( 'cart' ) );
        $remove_loader = apply_filters('woo_mini_cart_loader', Helper::get_img( 'spinner2.gif' ));
            foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
            ?>
                <li class="cart-item d-flex align-items-center">
	                <?php
	                    $_product   = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
	                    $product_id = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );
	                    if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_cart_item_visible', true, $cart_item, $cart_item_key ) ) {
	                        $product_permalink = apply_filters( 'woocommerce_cart_item_permalink', $_product->is_visible() ? $_product->get_permalink( $cart_item ) : '', $cart_item, $cart_item_key );
	                ?>
	                <div class="cart-single-product">
						<div class="media">
							<div class="cart-product-img">
								<?php
		                            $thumbnail = apply_filters( 'woocommerce_cart_item_thumbnail', $_product->get_image(), $cart_item, $cart_item_key );
		                            if ( ! $product_permalink ) {
		                                echo ( ''. $thumbnail );
		                            } else {
		                                printf( '<a href="%s">%s</a>', esc_url( $product_permalink ), $thumbnail );
		                            }
		                        ?>
							</div>
							<div class="media-body cart-content">
								<ul>
									<li class="minicart-title">
										<div class="cart-title-line1">
											<?php echo apply_filters( 'woocommerce_cart_item_name', sprintf( '<a href="%s">%s</a>', esc_url( $product_permalink ), $_product->get_title() ), $cart_item, $cart_item_key ); ?>
										</div>
										<div class="cart-title-line2 product-cats">
											<?php echo wc_get_product_category_list( $_product->get_id(), ', ', '<span class="posted_in">' . _n( '', '', count( $_product->get_category_ids() ), 'cirkle' ) . ' ', '</span>' ); ?> 
										</div>
										<div class="cart-title-line3">
										<?php echo apply_filters( 'woocommerce_cart_item_price', WC()->cart->get_product_price( $_product ), $cart_item, $cart_item_key ); ?> &#9747; <?php echo esc_attr( $cart_item['quantity'] ); ?>
										</div>
									</li>
									<li class="minicart-remove">
										<?php
				                            echo apply_filters(
				                                'woocommerce_cart_item_remove_link',
				                                sprintf(
				                                    '<a href="%s" class="remove_from_cart_button remove-cart-item" aria-label="%s" data-product_id="%s" data-cart_item_key="%s" data-product_sku="%s"><i class="icofont-close-line"></i></a>',
				                                    esc_url( wc_get_cart_remove_url( $cart_item_key ) ),
				                                    esc_attr__( 'Remove this item', 'cirkle' ),
				                                    esc_attr( $product_id ),
				                                    esc_attr( $cart_item_key ),
				                                    esc_attr( $_product->get_sku() )
				                                ),
				                                $cart_item_key
				                            );
				                        ?>
									</li>
								</ul>
							</div>
							<span class="remove-item-overlay text-center"><img src="<?php echo esc_url($remove_loader); ?>" alt="<?php esc_attr_e('Loader..', 'cirkle') ?>" /></span>
						</div>
					</div>
	                <?php
	                    }//if
	                ?>
                </li>
                <?php
                }//foreach
            ?>
            <?php if ( sizeof( WC()->cart->get_cart() ) > 0 ) : ?>
            <li class="cart-btn">
                <div class="checkout-link">
                    <a href="<?php echo wc_get_cart_url(); ?>"><?php _e( 'View All Product', 'cirkle' ); ?></a>
                </div>
            </li>
            <?php endif; ?>
        <?php 
        $out = ob_get_clean();
        return $out;
    }

    public function cirkle_wc_cart_count() {
     
        if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
     
   			if(!is_null(WC()->cart)) {
			    $count = WC()->cart->cart_contents_count;
			} else {
				$count = 0;
			}
            $cart_link = function_exists( 'wc_get_cart_url' ) ? wc_get_cart_url() : $woocommerce->cart->get_cart_url();
            ?>
            <div class="cart-list-trigger only-count-part">
	            <button class="dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false">
                    <i class="icofont-shopping-cart"></i>
                    <?php if ( $count > 0 ) echo '<span class="notify-count">' . $count . '</span>'; ?>
                </button>
                <div class="cart-wrapper dropdown-menu dropdown-menu-right">
                	<?php if( $count > 0 ) { ?>
	            	<div class="item-heading">
                        <h6 class="heading-title"> 
                        	<?php esc_html_e( 'Shopping Cart:', 'cirkle' ) ?>
                        	<?php if ( $count > 0 ) echo '<span class="notify-count">' . $count . '</span>'; ?>
                        </h6>
                    </div>
                	<?php } ?>
                    <ul class="minicart">
		            	<?php echo wp_kses_stripslashes( $this->cirkle_cart_items() ); ?>
		            </ul>
                </div>
            </div>
            <?php
        }
    }


    /**
     * Ensure cart contents update when products are added to the cart via AJAX
     */
    public function cirkle_header_add_to_cart_fragment( $fragments ) {
        ob_start();

        if(!is_null(WC()->cart)) {
		    $count = WC()->cart->cart_contents_count;
		} else {
			$count = 0;
		}
        $cart_link = function_exists( 'wc_get_cart_url' ) ? wc_get_cart_url() : $woocommerce->cart->get_cart_url();

        ?>
            <div class="header-action-item mini-cart-items header-shop-cart feagment-part">
            	<div class="cart-list-trigger">
	                <button class="dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false">
	                    <i class="icofont-shopping-cart"></i>
	                    <?php if ( $count > 0 ) echo '<span class="notify-count">' . $count . '</span>'; ?>
	                </button>
	                <div class="cart-wrapper dropdown-menu dropdown-menu-right">
	                	<?php if ( $count > 0 ) { ?>
		            	<div class="item-heading">
	                        <h6 class="heading-title"> 
	                        	<?php esc_html_e( 'Shopping Cart:', 'cirkle' ) ?>
	                        	<?php if ( $count > 0 ) echo '<span class="notify-count">' . $count . '</span>'; ?>
	                        </h6>
	                    </div>
	                	<?php } ?>
		                <ul class="minicart">
		                	<?php echo wp_kses_stripslashes( $this->cirkle_cart_items() ); ?>
		                </ul>
		            </div>
	            </div>
            </div>
        <?php
        $fragments['.mini-cart-items'] = ob_get_clean();
         
        return $fragments;
    }

    public function cirkle_wc_cart_ajax() {
        $output = '';
        if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
        	if(!is_null(WC()->cart)) {
			    $count = WC()->cart->cart_contents_count;
			} else {
				$count = 0;
			}
            $cart_link = function_exists( 'wc_get_cart_url' ) ? wc_get_cart_url() : $woocommerce->cart->get_cart_url();
            ob_start();
            ?>
            <div class="cart-list-trigger ajax-count-part">
	            <button class="dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false">
	                <i class="icofont-shopping-cart"></i>
	                <?php if ( $count > 0 ) echo '<span class="notify-count">' . $count . '</span>'; ?>
	            </button>
	            <div class="cart-wrapper dropdown-menu dropdown-menu-right">
	            	<?php if ( $count > 0 ) { ?>
	            	<div class="item-heading">
                        <h6 class="heading-title"> 
                        	<?php esc_html_e( 'Shopping Cart:', 'cirkle' ) ?>
                        	<?php if ( $count > 0 ) echo '<span class="notify-count">' . $count . '</span>'; ?>
                        </h6>
                    </div>
                	<?php } ?>
		            <ul class="minicart">
		            	<?php echo wp_kses_stripslashes( $this->cirkle_cart_items() ); ?>
		            </ul>
		        </div>
	        </div>
            <?php
            $output = ob_get_clean();
        }
        return  $output;
    }

    public function cirkle_product_remove() {
        global $woocommerce;
        foreach ($woocommerce->cart->get_cart() as $cart_item_key => $cart_item){
            if($cart_item['product_id'] == $_POST['product_id'] ){
                $woocommerce->cart->remove_cart_item($cart_item_key);
            }
        }
        $return["mini_cart"] = $this->cirkle_wc_cart_ajax();
        echo json_encode($return);
        exit();
    }
}

CKLWC_Functions::instance();