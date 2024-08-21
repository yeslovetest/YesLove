<?php
/**
 * BuddyPress Members directory search
 *
 * @package Cirkle
 * @since 1.0.0
 * @author RadiusTheme (https://www.radiustheme.com/)
 */

// Do not allow direct access over web.
defined( 'ABSPATH' ) || exit;
?>
<div class="box-item search-box">
	<form method="get" class="bp-dir-search-form" id="members-dir-search-form" role="search">
		<div class="input-group">
			<label for="members-search" class="bp-screen-reader-text"><?php esc_html_e('Search', 'cirkle') ;?></label>
			<?php $query_arg = bp_core_get_component_search_query_arg( 'members' );?>
			<input id="members-search"  class="search-input members-search-input form-control" name="<?php echo esc_attr( $query_arg ); ?>" type="search"  placeholder="<?php echo esc_attr( bp_get_search_default_text('members')); ?>" />
			<div class="input-group-append">
				<button type="submit" id="members-search-submit" class="bp-search-submit members-search-submit search-btn" name="members_search_submit">
					<i class="icofont-search"></i>
					<span id="button-text" class="bp-screen-reader-text"><?php echo esc_html_x( 'Search', 'button', 'cirkle' ); ?></span>
				</button>
	        </div>
		</div>
	</form>
</div>
