<?php

/**
 * Search 
 *
 * @package bbPress
 * @subpackage Theme
 */

// Exit if accessed directly
defined( 'ABSPATH' ) || exit;

if ( bbp_allow_search() ) : ?>

	<div class="block-box user-search-bar">
		<form role="search" method="get" id="bbp-search-form">
			<div class="input-group">
				<label class="screen-reader-text hidden" for="bbp_search"><?php esc_html_e( 'Search for:', 'cirkle' ); ?></label>
				<input type="hidden" name="action" value="bbp-search-request" />
				<input type="text" class="form-control" value="<?php bbp_search_terms(); ?>" name="bbp_search" id="bbp_search" placeholder="<?php esc_attr_e( 'Search for:', 'cirkle' ); ?>" />
				<div class="input-group-append">
                    <button class="search-btn" type="submit" id="bbp_search_submit"><i class="icofont-search"></i></button>
                </div>
			</div>
		</form>
	</div>

<?php endif;
