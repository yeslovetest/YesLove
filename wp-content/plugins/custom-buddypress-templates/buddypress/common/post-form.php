<?php
/**
 * BuddyPress - Activity Post Form
 *
 * @package BuddyPress
 * @subpackage bp-legacy
 * @version 3.0.0
 */

?>

<form action="<?php bp_activity_post_form_action(); ?>" method="post" id="whats-new-form" name="whats-new-form">

	<?php

	/**
	 * Fires before the activity post form.
	 *
	 * @since 1.2.0
	 */
	do_action( 'bp_before_activity_post_form' ); ?>

	<div id="whats-new-content">
		<div class="block-box post-input-tab">
		    <ul class="nav nav-tabs" role="tablist">
		        <li class="nav-item" role="presentation" data-toggle="tooltip" data-placement="top" title="<?php esc_attr_e( 'STATUS', 'cirkle' ) ?>">
		            <a class="nav-link active" data-toggle="tab" href="#post-status" role="tab" aria-selected="true"><i class="icofont-copy"></i><?php esc_html_e( 'Status', 'cirkle' ); ?></a>
		        </li>
		    </ul>
		    <div class="tab-content">
		        <div class="tab-pane fade show active" id="post-status" role="tabpanel">
		            <div class="post-status-box">
				        <textarea class="bp-suggestions" name="whats-new" id="whats-new" placeholder="<?php esc_attr_e( 'Share what are you thinking . . .', 'cirkle' ); ?>" cols="50" rows="10" <?php if ( bp_is_group() ) : ?>data-suggestions-group-id="<?php echo esc_attr( (int) bp_get_current_group_id() ); ?>" <?php endif; ?>
						><?php if ( isset( $_GET['r'] ) ) : ?>@<?php echo esc_textarea( $_GET['r'] ); ?> <?php endif; ?></textarea>
						<?php do_action('cirkle_media_uploading_field'); ?>
					</div>
		        </div>
		    </div>
		    <div class="post-footer">
		        <div id="cirkle-whats-new-options">
	        		<?php 
		        		if( function_exists('mediapress')){
		        			if ( mediapress()->is_bp_active() ) { ?>
						<div class="cirkle-media-btn">
							<?php do_action('cirkle_media_uploading_btn'); ?>
						</div>
						<?php }
						} 
					?>
					<?php if ( bp_is_active( 'groups' ) && !bp_is_my_profile() && !bp_is_group() ) : ?>
						<div id="whats-new-post-in-box">
							<?php esc_html_e( 'Post in', 'cirkle' ); ?>:
							<label for="whats-new-post-in" class="bp-screen-reader-text"><?php
								/* translators: accessibility text */
								esc_html_e( 'Post in', 'cirkle' );
							?></label>
							<select id="whats-new-post-in" name="whats-new-post-in">
								<option selected="selected" value="0"><?php esc_html_e( 'My Profile', 'cirkle' ); ?></option>
								<?php if ( bp_has_groups( 'user_id=' . bp_loggedin_user_id() . '&type=alphabetical&max=100&per_page=100&populate_extras=0&update_meta_cache=0' ) ) :
									while ( bp_groups() ) : bp_the_group(); ?>
										<option value="<?php bp_group_id(); ?>"><?php bp_group_name(); ?></option>
									<?php endwhile;
								endif; ?>
							</select>
							<input type="hidden" id="whats-new-post-object" name="whats-new-post-object" value="groups" />
						</div>
					<?php elseif ( bp_is_group_activity() ) : ?>
						<input type="hidden" id="whats-new-post-object" name="whats-new-post-object" value="groups" />
						<input type="hidden" id="whats-new-post-in" name="whats-new-post-in" value="<?php bp_group_id(); ?>" />
					<?php endif; ?>
					<div class="submit-btn">
						<div id="whats-new-submit">
							<input type="submit" name="aw-whats-new-submit" id="aw-whats-new-submit" value="<?php esc_attr_e( 'Post', 'cirkle' ); ?>" />
						</div>
					</div>
					<?php
					/**
					 * Fires at the end of the activity post form markup.
					 *
					 * @since 1.2.0
					 */
					do_action( 'bp_activity_post_form_options' ); ?>
				</div><!-- #whats-new-options -->
		    </div>
		</div>
	</div><!-- #whats-new-content -->

	<?php wp_nonce_field( 'post_update', '_wpnonce_post_update' ); ?>
	<?php
	/**
	 * Fires after the activity post form.
	 *
	 * @since 1.2.0
	 */
	do_action( 'bp_after_activity_post_form' ); ?>

</form><!-- #whats-new-form -->
