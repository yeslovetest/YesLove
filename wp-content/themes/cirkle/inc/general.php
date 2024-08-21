<?php

/**
 * @author  RadiusTheme
 * @since   1.0
 * @version 1.0
 */

namespace radiustheme\cirkle;

use radiustheme\cirkle\RDTheme;
use radiustheme\cirkle\Helper;

class General_Setup {

	public function __construct(){
		add_action('after_setup_theme',                       array($this, 'theme_setup'));
		add_action('widgets_init',                            array($this, 'register_sidebars'), 0);
		add_filter('body_class',                              array($this, 'body_classes'));
		add_filter('post_class',                              array($this, 'post_classes'));
		add_filter('wp_list_categories',                      array($this, 'cirkle_cat_count_span'));
		add_filter('get_archives_link',                       array($this, 'cirkle_archive_cat_count_span'));
		add_action('wp_head',                                 array($this, 'noscript_hide_preloader'), 1);
		add_filter('get_search_form',                         array($this, 'search_form'));
		add_filter('comment_form_fields',                     array($this, 'move_textarea_to_bottom'));
		add_filter('excerpt_more',                            array($this, 'excerpt_more'));
		add_filter('elementor/widgets/wordpress/widget_args', array($this, 'elementor_widget_args'));
		add_action('wp_head',                                 array($this, 'cirkle_pingback_header'), 996);
		add_action('site_prealoader',                         array($this, 'cirkle_preloader'));
		add_action('wp_footer',                               array($this, 'scroll_to_top_html'), 1);
		add_action('wp_kses_allowed_html',                    array($this, 'cirkle_kses_allowed_html'), 10, 2);
		add_action('template_redirect',                       array($this, 'w3c_validator'));
		add_filter( 'upload_mimes', 						  array($this, 'cc_mime_types' ));

		// custom side menu
		add_action('wp_update_nav_menu_item', 				  array(&$this, 'cirkle_sidemenu_update'), 10, 2 );
		add_action('wp_nav_menu_item_custom_fields',		  array(&$this, 'cirkle_sidemenu'), 10, 2 );

		// ajax
		add_action('wp_ajax_load_more_ports',                 array(&$this, 'rdt_load_more_func'));
		add_action('wp_ajax_nopriv_load_more_ports', 		  array(&$this, 'rdt_load_more_func'));

		//get member
		add_action('wp_ajax_ajax_search_member',              array(&$this, 'ajax_search_member'));
		add_action('wp_ajax_nopriv_ajax_search_member', 	  array(&$this, 'ajax_search_member'));

		//get group
		add_action('wp_ajax_ajax_search_group',               array(&$this, 'ajax_search_group'));
		add_action('wp_ajax_nopriv_ajax_search_group', 		  array(&$this, 'ajax_search_group'));

		//get post
		add_action('wp_ajax_ajax_search_post',                array(&$this, 'ajax_search_post'));
		add_action('wp_ajax_nopriv_ajax_search_post', 		  array(&$this, 'ajax_search_post'));

		//get product
		add_action('wp_ajax_ajax_search_product',             array(&$this, 'ajax_search_product'));
		add_action('wp_ajax_nopriv_ajax_search_product', 	  array(&$this, 'ajax_search_product'));

		//color mode
		add_filter( 'language_attributes', 					  array($this, 'filter_language_attributes'), 10, 2 ); 
		
	}


	// define the language_attributes callback 
	public function filter_language_attributes( $output, $doctype ) { 
	    $attributes = array();
	
        if ( function_exists( 'is_rtl' ) && is_rtl() )
            $attributes[] = 'dir="rtl"';

        if ( $lang = get_bloginfo('language') ) {
            if ( get_option('html_type') == 'text/html' || $doctype == 'html' )
                $attributes[] = "lang=\"$lang\"";

            if ( get_option('html_type') != 'text/html' || $doctype == 'xhtml' )
                $attributes[] = "xml:lang=\"$lang\"";
        }

        $color_mode = RDTheme::$options['code_mode_type'];
        $attributes[] = 'data-theme="' . esc_attr( $color_mode ) . '"';

        $output = implode( ' ', $attributes );

	    return $output; 
	} 


	public function ajax_search_member() {
		$value = isset( $_POST['value'] ) ? sanitize_text_field( $_POST['value'] ) : '';

		$data = '';		
		if ( bp_has_members( array(
				'per_page' => 5,
				'search_terms'    => $value,      
	        	'search_columns'  => array('name'),
			) ) ) :
			while ( bp_members() ) : bp_the_member(); 
				$user_id = bp_get_member_user_id();
				$data .= '<li>
				<div class="author-heading">
                    <div class="item-avatar">
                        <a href="'.bp_get_member_permalink().'">'.bp_get_member_avatar().'</a>
                    </div>
                    <div class="item">
                        <h4 class="item-title fn">
                        	<a href="'.bp_get_member_permalink().'">'.bp_get_member_name().'</a>'
                        	. Helper::cirkle_get_verified_badge( $user_id ).'
                        </h4>
                        <div class="item-meta">'.bp_get_member_last_active().'</div>
                    </div>
                </div>
				</li>';
			endwhile; 
		endif; 
		wp_send_json_success( $data );
	}

	public function ajax_search_group() {
		$value = isset( $_POST['value'] ) ? sanitize_text_field( $_POST['value'] ) : '';

		$data = ''; 		
		if ( bp_has_groups( array(
			'per_page' => 5,
			'search_terms'    => $value,      
	        'search_columns'  => array('name'),
		) ) ) :
			while ( bp_groups() ) : bp_the_group(); 
				$data .= '<li>
				<div class="author-heading">
                    <div class="item-avatar">
                        <a href="'.bp_get_group_permalink().'">'.bp_get_group_avatar( 'type=thumb&width=50&height=30' ).'</a>
                    </div>
                    <div class="item">
                        <h4 class="item-title fn">'.bp_get_group_link().'</h4>
                        <div class="item-meta">'.bp_get_group_type().'</div>
                    </div>
                </div>
				</li>';
			endwhile; 
		endif; 

		wp_send_json_success( $data );
	}

	public function ajax_search_post() {
		$value = isset( $_POST['value'] ) ? sanitize_text_field( $_POST['value'] ) : '';

		$data = '';
		$the_query = new \WP_Query( 
			array( 
				'posts_per_page' => 5, 
				's' => $value, 
				'post_type' => 'post' 
			) 
		);

	    if( $the_query->have_posts() ) :
	        while( $the_query->have_posts() ): $the_query->the_post();  
	        	$data .= '<li>
				<div class="author-heading">
                    <div class="item-avatar">
                        <a href="'.get_the_permalink().'">'.get_the_post_thumbnail(get_the_ID(), array('thumbnail')).'</a>
                    </div>
                    <div class="item">
                        <h4 class="item-title fn">
                        	<a href="'.get_the_permalink().'">'.get_the_title().'</a>
                        </h4>
                        <div class="item-meta">'.get_the_date().'</div>
                    </div>
                </div>
				</li>';
	        endwhile;
			wp_reset_postdata();  
		else: 

	    endif;

		wp_send_json_success( $data );
	}
	
	public function ajax_search_product() {
		$value = isset( $_POST['value'] ) ? sanitize_text_field( $_POST['value'] ) : '';

		$data = '';
		$the_query = new \WP_Query( 
			array( 
				'posts_per_page' => 5, 
				's' => $value, 
				'post_type' => 'product' 
			) 
		);

	    if( $the_query->have_posts() ) :
	        while( $the_query->have_posts() ): $the_query->the_post();  
	        	$data .= '<li>
				<div class="author-heading">
                    <div class="item-avatar">
                        <a href="'.get_the_permalink().'">'.get_the_post_thumbnail(get_the_ID(), array('thumbnail')).'</a>
                    </div>
                    <div class="item">
                        <h4 class="item-title fn">
                        	<a href="'.get_the_permalink().'">'.get_the_title().'</a>
                        </h4>
                        <div class="item-meta">'.get_the_date().'</div>
                    </div>
                </div>
				</li>';
	        endwhile;
			wp_reset_postdata();  
		else: 

	    endif;

		wp_send_json_success( $data );
	}

	// Add a pingback url
	public function cirkle_pingback_header(){
		if (is_singular() && pings_open()) {
			printf('<link rel="pingback" href="%s">', esc_url(get_bloginfo('pingback_url')));
		}
	}
	// Theme setup
	public function theme_setup(){
		$prefix = CIRKLE_THEME_PREFIX;

		// Theme supports
		add_theme_support('title-tag');
		add_theme_support('post-thumbnails');
		add_theme_support('automatic-feed-links');
		add_theme_support('wp-block');
		add_theme_support('html5', array('comment-list', 'comment-form', 'search-form', 'gallery', 'caption'));
		add_editor_style();
		add_theme_support('admin-bar', array('callback' => '__return_false'));
		// for gutenberg support
		remove_theme_support( 'widgets-block-editor' );
		add_theme_support('align-wide');
		add_theme_support('editor-color-palette', array(
			array(
				'name'  => esc_html__('Primary', 'cirkle'),
				'slug'  => 'cirkle-primary',
				'color' => '#2d5be3',
			),
			array(
				'name'  => esc_html__('Secondary', 'cirkle'),
				'slug'  => 'cirkle-secondary',
				'color' => '#34b7f1',
			),
			array(
				'name'  => esc_html__('Light', 'cirkle'),
				'slug'  => 'cirkle-light',
				'color' => '#ffffff',
			),
			array(
				'name'  => esc_html__('Black', 'cirkle'),
				'slug'  => 'cirkle-black',
				'color'  => '#000000',
			),
			array(
				'name'  => esc_html__('Dark', 'cirkle'),
				'slug'  => 'cirkle-dark',
				'color'  => '#0a0a0a',
			),

		));
		add_theme_support('editor-font-sizes', array(
			array(
				'name' => esc_html__('Small', 'cirkle'),
				'size'  => 12,
				'slug'  => 'small'
			),
			array(
				'name'  => esc_html__('Normal', 'cirkle'),
				'size'  => 16,
				'slug'  => 'normal'
			),
			array(
				'name'  => esc_html__('Large', 'cirkle'),
				'size'  => 32,
				'slug'  => 'large'
			),
			array(
				'name'  => esc_html__('Huge', 'cirkle'),
				'size'  => 48,
				'slug'  => 'huge'
			)
		));

		add_theme_support( 'wp-block-styles' );
		add_theme_support( 'responsive-embeds' );
		add_theme_support( 'editor-styles' );

		// Image sizes
		add_image_size("cirkle-size-1", 530, 430, true);  // Blog Grid Size

		// Register menus
		register_nav_menus(array(
			'primary'  => esc_html__('Primary', 'cirkle'),
			'sidemenu' => esc_html__('Side Menu', 'cirkle'),
		));

		// Custom Logo
		add_theme_support('custom-logo', array(
			'height'      => 65,
			'width'       => 245,
			'flex-height' => true,
			'header-text' => array('site-title', 'site-description'),
		));

		// Set up the WordPress core custom background feature.
		add_theme_support('custom-background', apply_filters('cirkle_custom_background_args', array(
			'default-color' => 'ffffff',
			'default-image' => '',
		)));
	}
	// Sidebar register for widgets
	public function register_sidebars(){

		if ( RDTheme::$layout == 'full-width') {
			register_sidebar(array(
				'name'          => esc_html__('Sidebar Widgets', 'cirkle'),
				'id'            => 'sidebar',
				'description'   => esc_html__('Sidebar widgets area', 'cirkle'),
				'before_widget' => '<div id="%1$s" class="widget %2$s single-sidebar">',
				'after_widget'  => '</div>',
				'before_title'  => '<div class="widget-section-heading heading-dark"><h3 class="widget-title">',
				'after_title'   => '</h3></div>',
			));
		}
		register_sidebar(array(
			'name'          => esc_html__('Footer Widgets', 'cirkle'),
			'id'            => 'footer-widgets',
			'description'   => esc_html__('Footer widgets area', 'cirkle'),
			'before_widget' => '<div class="col justify-content-lg-center"><div id="%1$s" class="widget %2$s footer-box">',
			'after_widget'  => '</div></div>',
			'before_title'  => '<h3 class="footer-title">',
			'after_title'   => '</h3>',
		));
	}
	
	// Add body class by filter
	public function body_classes( $classes ){
		if ( function_exists( 'is_buddypress' ) ) {
			if ( is_buddypress() ) {
				$classes[] = 'bg-link-water';
			} 
		}
		if ( function_exists( 'is_bbpress' ) ) {
			if ( is_bbpress() ) {
				$classes[] = 'bg-link-water';
			} 
		}
		if ( class_exists( 'WooCommerce' ) ) {
			if ( is_woocommerce() || is_cart() || is_checkout() ) {
				$classes[] = 'bg-link-water';
			}
		}

		if ( !has_nav_menu( 'sidemenu' ) ) {
			$classes[] = 'left-side-icon-menu-none';
		}
		if (RDTheme::$options['sticky_header']) {
			$classes[] = 'sticky-header';
		}

		$classes[] = 'header-style-' . RDTheme::$header_style;

		// Sidebar
		$classes[] = (RDTheme::$layout == 'full-width') ? 'no-sidebar' : 'has-sidebar';

		return $classes;
	}

	
	// Add post class by filter
	public function post_classes($classes){
		$post_thumb = '';
		if (has_post_thumbnail()) {
			$classes[] = 'have-post-thumb';
		}
		return $classes;
	}

	// Artex Sidebar Menu
	public function cirkle_sidemenu_update($menu_id, $menu_item_db_id) {
		$menu_icon = isset($_POST['_cirkle_menu_icon'][$menu_item_db_id]) ? esc_attr($_POST['_cirkle_menu_icon'][$menu_item_db_id]) : '';
		update_post_meta($menu_item_db_id, '_cirkle_menu_icon', $menu_icon);
	}

	public function cirkle_sidemenu($item_id, $item) {
		$cirkle_menu_icon = get_post_meta($item_id, '_cirkle_menu_icon', true);
		?>
		<p class="cirkle-menu-icon description description-wide">
			<label for="cirkle-menu-icon-<?php echo esc_attr( $item_id ); ?>">
				<?php _e('Select menu icon', 'cirkle'); ?>
			</label>
			<select name="_cirkle_menu_icon[<?php echo esc_attr( $item_id ); ?>]" id="cirkle-menu-icon-<?php echo esc_attr( $item_id ); ?>">
				<option value="icofont-newspaper" <?php if($cirkle_menu_icon == 'icofont-newspaper'){ echo ' selected="selected"'; } ?>><?php esc_html_e( 'Newspaper Icon m', 'cirkle' ); ?></option>
				<option value="icofont-list" <?php if($cirkle_menu_icon == 'icofont-list'){ echo ' selected="selected"'; } ?>><?php esc_html_e( 'List Icon', 'cirkle' ); ?> </option>
				<option value="icofont-users-alt-2" <?php if($cirkle_menu_icon == 'icofont-users-alt-2'){ echo ' selected="selected"'; } ?>><?php esc_html_e( 'Users alt 2', 'cirkle' ); ?> </option>
				<option value="icofont-users-alt-4" <?php if($cirkle_menu_icon == 'icofont-users-alt-4'){ echo ' selected="selected"'; } ?>><?php esc_html_e( 'Users alt 4', 'cirkle' ); ?> </option>
				<option value="icofont-photobucket" <?php if($cirkle_menu_icon == 'icofont-photobucket'){ echo ' selected="selected"'; } ?>><?php esc_html_e( 'Photobucket', 'cirkle' ); ?> </option>
				<option value="icofont-play-alt-1" <?php if($cirkle_menu_icon == 'icofont-play-alt-1'){ echo ' selected="selected"'; } ?>><?php esc_html_e( 'Play Alt 1', 'cirkle' ); ?> </option>
				<option value="icofont-calendar" <?php if($cirkle_menu_icon == 'icofont-calendar'){ echo ' selected="selected"'; } ?>><?php esc_html_e( 'Calendar', 'cirkle' ); ?> </option>
				<option value="icofont-ui-text-chat" <?php if($cirkle_menu_icon == 'icofont-ui-text-chat'){ echo ' selected="selected"'; } ?>><?php esc_html_e( 'Ui text chat', 'cirkle' ); ?> </option>
				<option value="icofont-shopping-cart" <?php if($cirkle_menu_icon == 'icofont-shopping-cart'){ echo ' selected="selected"'; } ?>><?php esc_html_e( 'Shopping cart', 'cirkle' ); ?></option>
			</select>
		</p>
		<?php
	}

	/*----------------------------------------------------------------------------------------*/
	/* Categories/Archive List count wrap by span
    /*----------------------------------------------------------------------------------------*/
	public function cirkle_cat_count_span($links){
		$links = str_replace('(', '<span class="float-right">(', $links);
		$links = str_replace(')', ')</span>', $links);
		return $links;
	}
	public function cirkle_archive_cat_count_span($links){
		$links = str_replace('(', '<span class="float-right">(', $links);
		$links = str_replace(')', ')</span>', $links);
		return $links;
	}

	public function noscript_hide_preloader(){
		// Hide preloader if js is disabled
		echo '<noscript><style>#preloader{display:none;}</style></noscript>';
	}

	public function search_form(){
		$output = '
		<form role="search" method="get" class="search-form" action="' . esc_url(home_url('/')) . '">
			<div class="widget-search-box">
				<div class="search-input-group">		   
			    	<input type="text" class="search-query" placeholder="' . esc_attr__('Search Keywords ...', 'cirkle') . '" value="' . get_search_query() . '" name="s" />
			        <button class="btn search-button" type="submit">
			            <span class="icofont-search" aria-hidden="true"></span>
			        </button>
				</div>
			</div>
		</form>
		';
		return $output;
	}

	public function move_textarea_to_bottom($fields){
		$temp = $fields['comment'];
		unset($fields['comment']);
		$fields['comment'] = $temp;
		return $fields;
	}

	public function excerpt_more(){
		return esc_html__('...', 'cirkle');
	}

	public function elementor_widget_args($args){
		$args['before_widget'] = '<div class="widget single-sidebar padding-bottom1">';
		$args['after_widget']  = '</div>';
		$args['before_title']  = '<h3>';
		$args['after_title']   = '</h3>';
		return $args;
	}

	public function cc_mime_types($mimes){
		$mimes['svg'] = 'image/svg+xml';
		return $mimes;
	}

	public function cirkle_preloader(){
		echo '<div id="preloader"></div>';
	}

	public function scroll_to_top_html(){
		// Back-to-top link
		if (RDTheme::$options['page_scrolltop'] == '1') {
			echo '<a href="#wrapper" data-type="section-switch" class="scrollup"><i class="icofont-bubble-up"></i></a>';
		}
	}

	public function cirkle_kses_allowed_html($tags, $context){
		switch ($context) {
			case 'social':
				$tags = array(
					'a' => array('href' => array()),
					'b' => array()
				);
				return $tags;
			case 'alltext_allow':
				$tags = array(
					'a' => array(
						'class' => array(),
						'href'  => array(),
						'rel'   => array(),
						'title' => array(),
						'target' => array(),
					),
					'abbr' => array(
						'title' => array(),
					),
					'b' => array(),
					'br' => array(),
					'blockquote' => array(
						'cite'  => array(),
					),
					'cite' => array(
						'title' => array(),
					),
					'code' => array(),
					'del' => array(
						'datetime' => array(),
						'title' => array(),
					),
					'dd' => array(),
					'div' => array(
						'class' => array(),
						'title' => array(),
						'style' => array(),
						'id' => array(),
					),
					'dl' => array(),
					'dt' => array(),
					'em' => array(),
					'h1' => array(),
					'h2' => array(),
					'h3' => array(),
					'h4' => array(),
					'h5' => array(),
					'h6' => array(),
					'i' => array(),
					'img' => array(
						'alt'    => array(),
						'class'  => array(),
						'height' => array(),
						'src'    => array(),
						'srcset' => array(),
						'width'  => array(),
					),
					'li' => array(
						'class' => array(),
					),
					'ol' => array(
						'class' => array(),
					),
					'p' => array(
						'class' => array(),
					),
					'q' => array(
						'cite' => array(),
						'title' => array(),
					),
					'span' => array(
						'class' => array(),
						'title' => array(),
						'style' => array(),
					),
					'strike' => array(),
					'strong' => array(),
					'ul' => array(
						'class' => array(),
					),
				);
				return $tags;
			default:
				return $tags;
		}
	}


	/* - Ajax Callback Function
	--------------------------------------------------------*/
	public function rdt_load_more_func(){

		$posts_no = RDTheme::$options['portfolio_archive_number'];
		$page = (isset($_GET['pageNumber'])) ? $_GET['pageNumber'] : 0;

		query_posts(array(
			'post_type' => 'cirkle_portfolio',
			'posts_per_page' => $posts_no,
			'post_status'   => 'publish',
			'paged'          => $page,
			'post__not_in' => get_option('sticky_posts')
		));

		if (have_posts()) : while (have_posts()) : the_post();

				$cols = RDTheme::$options['portfolio_grid_cols'];
				$location = get_post_meta(get_the_ID(), "cirkle_portfolio_location", true);

			?>

				<div class="col-lg-<?php echo esc_attr($cols); ?> col-md-6 col-12 gallery-item masonry-item single-grid-item">
					<div class="project-layout2">
						<div class="item-figure">
							<?php the_post_thumbnail('cirkle-size-2'); ?>
							<div class="item-icon">
								<a href="<?php echo esc_url(get_the_post_thumbnail_url()); ?>" class="popup-zoom" data-fancybox-group="gallery" title="<?php echo esc_attr(get_the_title()); ?>">
									<span class="line1"></span>
									<span class="line2"></span>
								</a>
							</div>
						</div>
						<div class="item-content">
							<h3 class="item-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
							<div class="item-sub-title"><?php echo esc_html($location); ?></div>
						</div>
					</div>
				</div>

	<?php endwhile;
		endif;
		wp_reset_query();
		die();
	} // End of ajax callback function

	public function w3c_validator(){
		/*----------------------------------------------------------------------------------------------------*/
		/*  W3C validator passing code
		/*----------------------------------------------------------------------------------------------------*/
		ob_start(function ($buffer) {
			$buffer = str_replace(array('<script type="text/javascript">', "<script type='text/javascript'>"), '<script>', $buffer);
			return $buffer;
		});
		ob_start(function ($buffer2) {
			$buffer2 = str_replace(array("<script type='text/javascript' src"), '<script src', $buffer2);
			return $buffer2;
		});
		ob_start(function ($buffer3) {
			$buffer3 = str_replace(array('type="text/css"', "type='text/css'", 'type="text/css"',), '', $buffer3);
			return $buffer3;
		});
		ob_start(function ($buffer4) {
			$buffer4 = str_replace(array('<iframe frameborder="0" scrolling="no" marginheight="0" marginwidth="0"',), '<iframe', $buffer4);
			return $buffer4;
		});
		ob_start(function ($buffer5) {
			$buffer5 = str_replace(array('aria-required="true"',), '', $buffer5);
			return $buffer5;
		});
	}
}
new General_Setup;
