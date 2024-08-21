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

class Contact_Widget extends WP_Widget {
	public function __construct() {
		$id = CIRKLE_CORE_THEME_PREFIX . '_contact';
		parent::__construct(
            $id, // Base ID
            esc_html__( 'A2: Contact', 'cirkle-core' ), // Name
            array( 'description' => esc_html__( 'Cirkle: Contact Widget', 'cirkle-core' )
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

	    $address = $instance['address'];
	    $phone = $instance['phone'];
		$email = $instance['email'];
		$ver = $instance['ver'];
		$phone_url = str_replace(' ', '', $phone);
        echo wp_kses_stripslashes( $html );

        if ($ver == 2) {
        ?>
        <ul class="footer-address">
			<?php if (!empty( $address )) { ?>
	        <li><i class="fas fa-map-marker-alt"></i><?php echo esc_html( $address ); ?></li>
	    	<?php } if (!empty( $email )) { ?>
			<li><i class="fas fa-envelope"></i> <a href="mailto:<?php echo sanitize_email( $email ); ?>"><?php echo sanitize_email( $email ); ?></a></li>
			<?php } if (!empty( $phone )) { ?>
			<li><i class="fas fa-phone"></i> <a href="tel:<?php echo esc_attr( $phone_url ); ?>"><?php echo esc_html( $phone ); ?></a></li>
			<?php } ?>
		</ul>		
    	<?php } else { ?>
		<ul class="footer-address">
			<?php if (!empty( $address )) { ?>
			<li><?php echo esc_html( $address ); ?></li>
			<?php } if (!empty( $phone )) { ?>
			<li><span><a href="tel:<?php echo esc_attr( $phone_url ); ?>"><?php echo esc_html( $phone ); ?></a></span></li>
			<?php } if (!empty( $email )) { ?>
			<li><a href="mailto:<?php echo sanitize_email( $email ); ?>"><?php echo sanitize_email( $email ); ?></a></li>
			<?php } ?>
		</ul>

        <?php }
		echo wp_kses_post( $args['after_widget'] );
	}

	public function update( $new_instance, $old_instance ){
		$instance          = array();

		$instance['title']  = ( ! empty( $new_instance['title'] ) ) ? sanitize_text_field( $new_instance['title'] ) : '';

		$instance['address']  = ( ! empty( $new_instance['address'] ) ) ? sanitize_text_field( $new_instance['address'] ) : '';

		$instance['email'] = ( ! empty( $new_instance['email'] ) ) ? sanitize_email( $new_instance['email'] ) : '';

		$instance['phone'] = ( ! empty( $new_instance['phone'] ) ) ? sanitize_text_field( $new_instance['phone'] ) : '';

		$instance['ver'] = ( ! empty( $new_instance['ver'] ) ) ? sanitize_text_field( $new_instance['ver'] ) : '';

		return $instance;
	}

	public function form( $instance ){
		$defaults = array(
			'title'  => '',
			'address' => '',
			'phone' => '',
			'email'	=> '',
			'ver'	=> '1',
		);
		$instance = wp_parse_args( (array) $instance, $defaults );

		$version = array(
			'1' => __( 'Version 1', 'metro-core' ),
			'2' => __( 'Version 2', 'metro-core' ),
		);

		$fields = array(
			'title'       => array(
				'label'   => esc_html__( 'Title', 'cirkle-core' ),
				'type'    => 'text',
			),
			'address' => array(
				'label'   => esc_html__( 'Address', 'cirkle-core' ),
				'type'    => 'textarea',
			),
			'phone' => array(
				'label'   => esc_html__( 'Phone', 'cirkle-core' ),
				'type'    => 'text',
			),
			'email'        => array(
				'label'   => esc_html__( 'Email', 'cirkle-core' ),
				'type'    => 'text',
			),
			'ver' => array(
				'label'   => esc_html__( 'Version', 'cirkle-core' ),
				'type'    => 'select',
				'options' => $version,
			),
		);

		RT_Widget_Fields::display( $fields, $instance, $this );
	}
}