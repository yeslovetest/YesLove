<?php

/**
 * @author  RadiusTheme
 * @since   1.0
 * @version 1.0
 */

use radiustheme\cirkle\RDTheme;
use radiustheme\cirkle\Helper;

$description = get_bloginfo( 'description', 'display' );
$site_desc = '';

if ( $description || is_customize_preview() ){
	$site_desc = 'have-site-description';
}
?>

<!-- Sidebar Left -->
<div class="fixed-sidebar <?php echo esc_attr( $site_desc ); ?>">
	<div class="fixed-sidebar-left small-sidebar">
		<div class="sidebar-toggle">
			<button class="toggle-btn toggler-open">
				<span></span>
				<span></span>
				<span></span>
			</button>
		</div>
		<div class="sidebar-menu-wrap">
			<div class="mfCustomScrollbar" data-mcs-theme="dark" data-mcs-axis="y">
				<?php Helper::sidebar_icon_menu(); ?>
			</div>
		</div>
	</div>
	<div class="fixed-sidebar-left large-sidebar">
		<div class="sidebar-toggle">
			<div class="sidebar-logo">
				<?php get_template_part('template-parts/header/logo', 'light'); ?>
			</div>
			<button class="toggle-btn toggler-close">
				<span></span>
				<span></span>
				<span></span>
			</button>
		</div>
		<div class="sidebar-menu-wrap">
			<div class="mCustomScrollbar" data-mcs-theme="dark" data-mcs-axis="y">
				<?php Helper::sidebar_icon_text_menu(); ?>
			</div>
		</div>
	</div>
</div>