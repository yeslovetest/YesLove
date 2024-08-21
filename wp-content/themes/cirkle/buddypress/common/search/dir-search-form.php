<?php
/**
 * Output the search form markup.
 *
 * @since 2.7.0
 * @version 3.0.0
 */
?>

<div id="<?php echo esc_attr( bp_current_component() ); ?>-dir-search" class="dir-search box-item search-box" role="search">
	<form method="get" id="search-<?php echo esc_attr( bp_current_component() ); ?>-form">
		<div class="input-group">
			<label for="<?php bp_search_input_name(); ?>" class="bp-screen-reader-text"><?php bp_search_placeholder(); ?></label>
			<input type="text" name="<?php echo esc_attr( bp_core_get_component_search_query_arg() ); ?>" id="<?php bp_search_input_name(); ?>" class="form-control" placeholder="<?php bp_search_placeholder(); ?>" />

			<div class="input-group-append">
				<button type="submit" id="<?php echo esc_attr( bp_get_search_input_name() ); ?>_submit" class="bp-search-submit members-search-submit search-btn" name="<?php bp_search_input_name(); ?>_submit">
					<i class="icofont-search"></i>
					<span id="button-text" class="bp-screen-reader-text"><?php echo esc_html_x( 'Search', 'button', 'cirkle' ); ?></span>
				</button>
	        </div>
	    </div>
	</form>
</div><!-- #<?php echo esc_attr( bp_current_component() ); ?>-dir-search -->
