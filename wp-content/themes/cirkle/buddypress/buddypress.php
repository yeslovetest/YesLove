<?php
/**
 * Cirkle Template - BuddyPress Entry Point
 * 
 * @package Cirkle
 * @since 1.0.0
 * @author RadiusTheme (https://www.radiustheme.com/)
 * 
 */

?>

<?php get_header(); ?>
<!-- Sidebar Left -->
<?php 
    if ( has_nav_menu( 'sidemenu' ) ) {
        // Sidebar Left
        get_template_part( 'template-parts/header/header', 'left' ); 
    }
?>
<!-- Page Content -->
<?php 
  if (have_posts()) {
    the_post();
        the_content();
	} 
?>
<?php get_footer(); ?>