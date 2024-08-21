<?php

/**
 * @author  RadiusTheme
 * @since   1.0
 * @version 1.0
 */

namespace radiustheme\cirkle;


class RDTheme
{

    protected static $instance = null;

    // Sitewide static variables
    public static $options = null;

    // Template specific variables
    public static $layout = null;
    public static $sidebar = null;
    public static $header_style = null;
    public static $footer_style = null;
    public static $has_cursor = null;
    public static $has_scrolltop = null;
    public static $has_breadcrumb = null;
    public static $has_banner = null;
    public static $trans_menu = null;
    public static $bgimg = null;
    public static $bgcolor = null;
    public static $opacity = null;
    public static $banner_pt = null;
    public static $banner_pb = null;

    private function __construct(){
        add_action('after_setup_theme', array($this, 'set_options'));
        add_action('customize_preview_init', array($this, 'set_options'));
    }

    public static function instance(){
        if (null == self::$instance) {
            self::$instance = new self;
        }
        return self::$instance;
    }

    public function set_options() {
        $defaults  = rttheme_generate_defaults();
        $newData = [];
        foreach ($defaults as $key => $dValue) {
            $value = get_theme_mod($key, $defaults[$key]);
            $newData[$key] = $value;
        }
        self::$options  = $newData;
    }

}

RDTheme::instance();

