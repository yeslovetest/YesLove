<?php
/**
 * @author  RadiusTheme
 * @since   1.0
 * @version 1.0
 */

namespace radiustheme\Cirkle_Core;
use radiustheme\cirkle\RDTheme;
use radiustheme\cirkle\Helper;

class Custom_Widgets_Init {

	public $widgets;
	protected static $instance = null;
	public function __construct() {
		$widgets = array(
			'clogin'    => 'CBP_Login_Widget',
			'cmember'   => 'CBP_Members_Widget',
			'cgroup'    => 'CBP_Groups_Widget',
			'cfriends'  => 'CBP_Friends_Widget',
			'forums'    => 'CBBP_Forums_Widget',
			'bblogin'   => 'CBBP_Login_Widget',
			'about'     => 'About_Widget',
			'ad-widget' => 'Adv_Widget',
			'about-me'  => 'Aboutme_Widget',
		);
		$this->widgets = $widgets;
		add_action( 'widgets_init', array( $this, 'cirkle_bp_widgets' ), 100 );
		add_action( 'widgets_init', array( $this, 'custom_widgets' ), 5 );

		add_filter('widget_form_callback', array( $this, 'ifinger_widget_form_extend'), 10, 2);
		add_filter( 'widget_update_callback', array( $this, 'ifinger_widget_update'), 10, 2 );
		add_filter( 'dynamic_sidebar_params', array( $this, 'ifinger_dynamic_sidebar_params'), 0 );
	}

	public static function instance() {
		if ( null == self::$instance ) {
			self::$instance = new self;
		}
		return self::$instance;
	}

	public function cirkle_bp_widgets() {
		if (Helper::cirkle_plugin_is_active('buddypress')) {
			register_sidebar( array(
				'name'          => esc_html__( 'Profile Widgets', 'cirkle' ),
				'id'            => 'profile-widgets',
				'description'   => esc_html__('Profile Sidebar widgets', 'cirkle'),
				'before_widget' => '<div class="widget widget-memebers"><div id="%1$s" class="%2$s">',
				'after_widget'  => '</div></div>',
				'before_title'  => '<div class="widget-heading"><h3 class="widget-title">',
				'after_title'   => '</h3></div>',
			) );
			register_sidebar( array(
				'name'          => esc_html__( 'Member Widgets', 'cirkle' ),
				'id'            => 'member-widgets',
				'description'   => esc_html__('Member Sidebar widgets', 'cirkle'),
				'before_widget' => '<div class="widget widget-memebers"><div id="%1$s" class="%2$s">',
				'after_widget'  => '</div></div>',
				'before_title'  => '<div class="widget-heading"><h3 class="widget-title">',
				'after_title'   => '</h3></div>',
			) );
			register_sidebar( array(
				'name'          => esc_html__( 'Group Widgets', 'cirkle' ),
				'id'            => 'group-widgets',
				'description'   => esc_html__('Group Sidebar widgets', 'cirkle'),
				'before_widget' => '<div class="widget widget-group"><div id="%1$s" class="%2$s">',
				'after_widget'  => '</div></div>',
				'before_title'  => '<div class="widget-heading"><h3 class="widget-title">',
				'after_title'   => '</h3></div>',
			) );
			register_sidebar( array(
				'name'          => esc_html__( 'Forum Widgets', 'cirkle' ),
				'id'            => 'bbpress-widgets',
				'description'   => esc_html__('Forum Sidebar widgets', 'cirkle'),
				'before_widget' => '<div class="widget widget-groups"><div id="%1$s" class="%2$s">',
				'after_widget'  => '</div></div>',
				'before_title'  => '<div class="widget-heading"><h3 class="widget-title">',
				'after_title'   => '</h3></div>',
			) );
			if ( class_exists( 'woocommerce' ) ) {
				register_sidebar( array(
					'name'          => esc_html__( 'Shop Widgets', 'cirkle' ),
					'id'            => 'woo-sidebar',
					'description'   => esc_html__('Products Page Sidebar widgets', 'cirkle'),
					'before_widget' => '<div class="widget widget-groups"><div id="%1$s" class="%2$s">',
					'after_widget'  => '</div></div>',
					'before_title'  => '<div class="widget-heading"><h3 class="widget-title">',
					'after_title'   => '</h3></div>',
				) );
			}
		}	
	}


	/*====================================================================================*/ 
	/* - Add a custom class in every widget
	/*====================================================================================*/ 
	public function ifinger_widget_form_extend( $instance, $widget ) {
	  $row = '';
	  if ( !isset($instance['classes']) )
	    $instance['classes'] = null;   
	    $row .= "<p><label>Custom Class:</label>\t<input type='text' name='widget-{$widget->id_base}[{$widget->number}][classes]' id='widget-{$widget->id_base}-{$widget->number}-classes' class='widefat' value='{$instance['classes']}'/>\n";
	    $row .= "</p>\n";
	    echo $row;
	    return $instance;
	}

	public function ifinger_widget_update( $instance, $new_instance ) {
	  $instance['classes'] = $new_instance['classes'];
	  return $instance;
	}

	// Value add in widget
	public function ifinger_dynamic_sidebar_params( $params ) {
	    global $wp_registered_widgets;
	    $widget_id    = $params[0]['widget_id'];
	    $widget_obj   = $wp_registered_widgets[$widget_id];
	    $widget_opt   = get_option($widget_obj['callback'][0]->option_name);
	    $widget_num   = $widget_obj['params'][0]['number'];    
	    if ( isset($widget_opt[$widget_num]['classes']) && !empty($widget_opt[$widget_num]['classes']) )
	      $params[0]['before_widget'] = preg_replace( '/class="/', "class=\"{$widget_opt[$widget_num]['classes']} ", $params[0]['before_widget'], 1 );
	    return $params;
	}

	public function custom_widgets() {
		if ( !class_exists( 'RT_Widget_Fields' ) ) return;

		foreach ( $this->widgets as $filename => $classname ) {
			$file  = dirname(__FILE__) . '/' . $filename . '.php';
			$class = __NAMESPACE__ . '\\' . $classname;
			require_once $file;
			register_widget( $class );
		}
	}

}

Custom_Widgets_Init::instance();