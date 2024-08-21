<?php
/**
 * @author  RadiusTheme
 * @since   1.0
 * @version 1.0
 */

namespace radiustheme\cirkle;

if( function_exists( 'bcn_display') ){
	echo '<div class="breadcrumb-area"><div class="entry-breadcrumb">';
	bcn_display();
	echo '</div></div>';
}