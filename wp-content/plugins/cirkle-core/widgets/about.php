<?php
/**
 * @author  RadiusTheme
 * @since   1.0
 * @version 1.0
 */

namespace radiustheme\Cirkle_Core;

use \WP_Widget;
use \RT_Widget_Fields;
use radiustheme\Cirkle\RDTheme;
use radiustheme\Cirkle\Helper;

class About_Widget extends WP_Widget {
	public function __construct() {
		$id = CIRKLE_CORE_THEME_PREFIX . '_about';
		parent::__construct(
            $id, // Base ID
            esc_html__( 'A6: About', 'cirkle-core' ), // Name
            array( 'description' => esc_html__( 'Cirkle: About Widget', 'cirkle-core' )
        ) );
	}

	public function widget( $args, $instance ){

		echo wp_kses_post( $args['before_widget'] );

		$title = $instance['title'];

		if (!empty($instance['logo'])) {
			$logo1 = wp_get_attachment_image( $instance['logo'], 'full', '', ["class" => "logo-dark"] );
		} else {
			$logo1 = '';
		} if (!empty($instance['logo2'])) {
			$logo2 = wp_get_attachment_image( $instance['logo2'], 'full', '', ["class" => "logo-light"] );
		} else {
			$logo2 = '';
		}
		
		$desc = $instance['desc'];

	    ?>

		<div class="footer-box">
            <div class="footer-logo">
                <a href="<?php echo esc_url( home_url('/') ); ?>">
				<?php 
					if (!empty($logo1 || $logo2 )) {
						echo $logo1;
						echo $logo2;
					} else {
						echo $title; 
					}
				?>
			</a>
            </div>
            <p><?php echo $desc; ?></p>
        </div>

        <?php 
		echo wp_kses_post( $args['after_widget'] );
	}

	public function update( $new_instance, $old_instance ){
		$instance          = array();

		$instance['title']  = ( ! empty( $new_instance['title'] ) ) ? sanitize_text_field( $new_instance['title'] ) : '';

		$instance['logo']  = ( ! empty( $new_instance['logo'] ) ) ? sanitize_text_field( $new_instance['logo'] ) : '';
		$instance['logo2']  = ( ! empty( $new_instance['logo2'] ) ) ? sanitize_text_field( $new_instance['logo2'] ) : '';

		$instance['desc'] = ( ! empty( $new_instance['desc'] ) ) ? sanitize_text_field( $new_instance['desc'] ) : '';

		return $instance;
	}

	public function form( $instance ){
		$defaults = array(
			'title' => '',
			'logo'  => '',
			'logo2' => '',
			'desc'	=> '',
		);
		$instance = wp_parse_args( (array) $instance, $defaults );

		$fields = array(
			'title'       => array(
				'label'   => esc_html__( 'Title', 'cirkle-core' ),
				'type'    => 'text',
			),
			'logo'       => array(
				'label'   => esc_html__( 'Dark Logo', 'cirkle-core' ),
				'type'    => 'image',
			),
			'logo2'       => array(
				'label'   => esc_html__( 'Light Logo', 'cirkle-core' ),
				'type'    => 'image',
			),
			'desc'        => array(
				'label'   => esc_html__( 'Description', 'cirkle-core' ),
				'type'    => 'textarea',
			),

		);

		RT_Widget_Fields::display( $fields, $instance, $this );
	}
}