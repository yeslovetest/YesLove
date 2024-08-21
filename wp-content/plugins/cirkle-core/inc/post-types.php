<?php
/**
 * @author  RadiusTheme
 * @since   1.0
 * @version 1.0
 */

namespace radiustheme\Cirkle_Core;
use \RT_Posts;
use radiustheme\cirkle\RDTheme;

if ( !class_exists( 'RT_Posts' ) ) {
	return;
}

$prefix = CIRKLE_CORE_THEME_PREFIX;

$post_types = array(
	"{$prefix}_service"  => array(
		'title'          => __( 'Service', 'cirkle-core' ),
		'plural_title'   => __( 'Services', 'cirkle-core' ),
		'menu_icon'      => 'dashicons-admin-post',
		'show_in_rest'   => true,
		'supports'       => array( 'title', 'thumbnail', 'editor', 'excerpt' ),
	),
	"{$prefix}_portfolio"  => array(
		'title'          => __( 'Portfolio', 'cirkle-core' ),
		'plural_title'   => __( 'Portfolios', 'cirkle-core' ),
		'menu_icon'      => 'dashicons-admin-post',
		'show_in_rest'   => true,
		// 'rewrite'        => RDTheme::$options['dadas'],
		'supports'       => array( 'title', 'thumbnail', 'editor', 'excerpt' ),
	),
	"{$prefix}_team"  => array(
		'title'          => __( 'Team', 'cirkle-core' ),
		'plural_title'   => __( 'Teams', 'cirkle-core' ),
		'menu_icon'      => 'dashicons-admin-post',
		'show_in_rest'   => true,
		'supports'       => array( 'title', 'thumbnail', 'editor' ),
	),
);
$taxonomies = array(
	"{$prefix}_portfolio_category" => array(
		'title'        => __( 'Portfolio Category', 'fototag-core' ),
		'plural_title' => __( 'Categories', 'fototag-core' ),
		'post_types'   => "{$prefix}_portfolio",
		'show_in_rest'   => true,
	),
);

$Posts = RT_Posts::getInstance();
$Posts->add_post_types( $post_types );
$Posts->add_taxonomies( $taxonomies );