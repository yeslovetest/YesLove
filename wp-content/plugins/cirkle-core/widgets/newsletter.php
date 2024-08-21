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

class Newsletter_Widget extends WP_Widget {
	public function __construct() {
		$id = CIRKLE_CORE_THEME_PREFIX . '_newsletter';
		parent::__construct(
            $id, // Base ID
            esc_html__( 'A3: Newsletter', 'cirkle-core' ), // Name
            array( 'description' => esc_html__( 'Cirkle: Newsletter Widget', 'cirkle-core' )
        ) );
	}

	public function widget( $args, $instance ){

		echo wp_kses_post( $args['before_widget'] );

		if ( !empty( $instance['title'] ) ) {
			$html = apply_filters( 'widget_title', $instance['title'] );
			$html = $args['before_title'] . $html .$args['after_title'];
		}
		else {
			$html = '';
		}
	    $form = $instance['form'];
		$desc = $instance['desc'];

	    echo wp_kses_stripslashes( $html );

	    ?>
		<?php 
			echo do_shortcode( $form ); 
			if ( !empty( $desc ) ) {
		?>
		<p class="footer-paragraph"><?php echo wp_kses_post( $desc ); ?></p>
        <?php }
		echo wp_kses_post( $args['after_widget'] );
	}

	public function update( $new_instance, $old_instance ){
		$instance          = array();

		$instance['title']  = ( ! empty( $new_instance['title'] ) ) ? sanitize_text_field( $new_instance['title'] ) : '';

		$instance['form'] = ( ! empty( $new_instance['form'] ) ) ? wp_kses_post( $new_instance['form'] ) : '';

		$instance['desc'] = ( ! empty( $new_instance['desc'] ) ) ? sanitize_text_field( $new_instance['desc'] ) : '';


		return $instance;
	}

	public function form( $instance ){
		$defaults = array(
			'title'  => '',
			'form' => '',
			'desc'	=> '',
		);
		$instance = wp_parse_args( (array) $instance, $defaults );

		$fields = array(
			'title'       => array(
				'label'   => esc_html__( 'Title', 'cirkle-core' ),
				'type'    => 'text',
			),
			'form' => array(
				'label'   => esc_html__( 'Form Shortcode', 'cirkle-core' ),
				'type'    => 'textarea',
			),
			'desc'        => array(
				'label'   => esc_html__( 'Description', 'cirkle-core' ),
				'type'    => 'textarea',
			),

		);

		RT_Widget_Fields::display( $fields, $instance, $this );
	}
}