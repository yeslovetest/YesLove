<?php
/**
 * @author  RadiusTheme
 * @since   1.0
 * @version 1.0
 */

namespace radiustheme\Cirkle_Core;

use \WP_Widget;
use \RT_Widget_Fields;
use radiustheme\Cirkle\Helper;

class Aboutme_Widget extends WP_Widget {
	public function __construct() {
		$id = CIRKLE_CORE_THEME_PREFIX . '_about_me';
		parent::__construct(
            $id, // Base ID
            esc_html__( 'A7: About Me', 'cirkle-core' ), // Name
            array( 'description' => esc_html__( 'Cirkle: About Me Widget', 'cirkle-core' )
        ) );
	}

	public function widget( $args, $instance ){

		echo wp_kses_post( $args['before_widget'] );
		global $wpdb;
		$title = $instance['title'];
		$desc = get_the_author_meta( 'description', bp_loggedin_user_id() );
	    ?>

        <div class="widget-user-about">
            <div class="widget-heading">
                <h3 class="widget-title"><?php echo esc_html( $title ); ?></h3>
            </div>
            <div class="user-info">
            	<?php if ( $desc ) { ?>
                <p><?php echo esc_html( $desc ); ?></p>
            	<?php } ?>
                <ul class="info-list">
                    <li><span><?php esc_html_e( 'Joined:', 'cirkle-core' ); ?></span><?php echo date("M Y", strtotime(get_userdata(bp_displayed_user_id( ))->user_registered)); ?></li>
                    <li><span><?php esc_html_e( 'E-mail:', 'cirkle-core' ); ?></span><?php echo xprofile_get_field_data( 'Email:', get_the_author_meta( 'ID' )); ?></li>
                    <li><span><?php esc_html_e( 'Address:', 'cirkle-core' ); ?></span><?php echo xprofile_get_field_data( 'Address:', get_the_author_meta( 'ID' )); ?></li>
                    <li><span><?php esc_html_e( 'Phone:', 'cirkle-core' ); ?></span><?php echo xprofile_get_field_data( 'Phone:', get_the_author_meta( 'ID' )); ?></li>
                    <li><span><?php esc_html_e( 'Country:', 'cirkle-core' ); ?></span><?php echo xprofile_get_field_data( 'Shorttext', get_the_author_meta( 'ID' )) ?></li>
                    <li><span><?php esc_html_e( 'Web:', 'cirkle-core' ); ?></span>
                    	<a href="<?php echo esc_url( xprofile_get_field_data( 'Website:', get_the_author_meta( 'ID' ))); ?>"><?php echo xprofile_get_field_data( 'Website:', get_the_author_meta( 'ID' )); ?></a>
                    </li>
                    <?php 
                    	$fb  = xprofile_get_field_data( 'Facebook', get_the_author_meta( 'ID' ));
                    	$tw  = xprofile_get_field_data( 'Twitter', get_the_author_meta( 'ID' ));
                    	$dri = xprofile_get_field_data( 'Dribbble', get_the_author_meta( 'ID' ));
                    	$be  = xprofile_get_field_data( 'Behance', get_the_author_meta( 'ID' ));
                    	$you = xprofile_get_field_data( 'YouTube', get_the_author_meta( 'ID' ));
                    	if ($fb || $tw || $dri || $be || $you) {
                    ?>
                    <li class="social-share"><span><?php esc_html_e( 'Social:', 'cirkle-core' ); ?></span>
                        <div class="social-icon">
                        	<?php if ($fb) { ?>
                            <a href="<?php echo esc_url( $fb ); ?>"><i class="icofont-facebook"></i></a>
                        	<?php } if ($tw) { ?>
                            <a href="<?php echo esc_url( $tw ); ?>"><i class="icofont-twitter"></i></a>
                            <?php } if ($dri) { ?>
                            <a href="<?php echo esc_url( $dri ); ?>"><i class="icofont-dribbble"></i></a>
                            <?php } if ($be) { ?>
                            <a href="<?php echo esc_url( $be ); ?>"><i class="icofont-behance"></i></a>
                            <?php } if ($you) { ?>
                            <a href="<?php echo esc_url( $you ); ?>"><i class="icofont-youtube"></i></a>
                        	<?php } ?>
                        </div>
                    </li>
                	<?php } ?>
                </ul>
            </div>
        </div>

        <?php 
		echo wp_kses_post( $args['after_widget'] );
	}

	public function update( $new_instance, $old_instance ){
		$instance          = array();

		$instance['title']  = ( ! empty( $new_instance['title'] ) ) ? sanitize_text_field( $new_instance['title'] ) : '';

		return $instance;
	}

	public function form( $instance ){
		$defaults = array(
			'title' => 'About Me',
		);
		$instance = wp_parse_args( (array) $instance, $defaults );

		$fields = array(
			'title'       => array(
				'label'   => esc_html__( 'Title', 'cirkle-core' ),
				'type'    => 'text',
			),
		);

		RT_Widget_Fields::display( $fields, $instance, $this );
	}
}