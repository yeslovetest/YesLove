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

class Adv_Widget extends WP_Widget {
	public function __construct() {
		$id = CIRKLE_CORE_THEME_PREFIX . '_add';
		parent::__construct(
            $id, // Base ID
            esc_html__( 'A8: Advertisement', 'cirkle-core' ), // Name
            array( 'description' => esc_html__( 'Cirkle: Advertisement Widget', 'cirkle-core' )
        ) );
	}

	public function widget( $args, $instance ){

		echo wp_kses_post( $args['before_widget'] );

		$img = wp_get_attachment_image( $instance['img'], 'full' );
		$title = $instance['title'];
		$subtitle = $instance['subtitle'];
		$btn_txt = $instance['btn_txt'];
		$btn_link = $instance['btn_link'];

	    ?>

        <div class="widget-banner">
			<?php if ( !empty( $title ) ) { ?>
            <h3 class="item-title"><?php echo esc_html( $title ); ?></h3>
        	<?php } if ( !empty( $subtitle ) ) { ?>
            <div class="item-subtitle"><?php echo esc_html( $subtitle ); ?></div>
            <?php } if (!empty($btn_link)) { ?>
            <a href="<?php echo esc_url( $btn_link ); ?>" class="item-btn">
                <span class="btn-text"><?php echo esc_html( $btn_txt ); ?></span>
                <span class="btn-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="21px" height="10px">
                        <path fill-rule="evenodd" d="M16.671,9.998 L12.997,9.998 L16.462,6.000 L5.000,6.000 L5.000,4.000 L16.462,4.000 L12.997,0.002 L16.671,0.002 L21.003,5.000 L16.671,9.998 ZM17.000,5.379 L17.328,5.000 L17.000,4.621 L17.000,5.379 ZM-0.000,4.000 L3.000,4.000 L3.000,6.000 L-0.000,6.000 L-0.000,4.000 Z" />
                    </svg>
                </span>
            </a>
        	<?php } ?>
            <div class="item-img">
            	<?php 
	                if (!empty($img)) {
						echo $img; 
					} 
				?>
            </div>
        </div>

        <?php 
		echo wp_kses_post( $args['after_widget'] );
	}

	public function update( $new_instance, $old_instance ){
		$instance          = array();
		$instance['img']  = ( ! empty( $new_instance['img'] ) ) ? sanitize_text_field( $new_instance['img'] ) : '';
		$instance['title']  = ( ! empty( $new_instance['title'] ) ) ? sanitize_text_field( $new_instance['title'] ) : '';
		$instance['subtitle']  = ( ! empty( $new_instance['subtitle'] ) ) ? sanitize_text_field( $new_instance['subtitle'] ) : '';
		$instance['btn_txt'] = ( ! empty( $new_instance['btn_txt'] ) ) ? sanitize_text_field( $new_instance['btn_txt'] ) : '';
		$instance['btn_link'] = ( ! empty( $new_instance['btn_link'] ) ) ? sanitize_text_field( $new_instance['btn_link'] ) : '';

		return $instance;
	}

	public function form( $instance ){
		$defaults = array(
			'img'  => '',
			'title' => '',
			'subtitle' => '',
			'btn_txt'  => '',
			'btn_link' => '',
		);
		$instance = wp_parse_args( (array) $instance, $defaults );

		$fields = array(
			'img'       => array(
				'label' => esc_html__( 'Image', 'cirkle-core' ),
				'type'  => 'image',
			),
			'title'     => array(
				'label' => esc_html__( 'Title', 'cirkle-core' ),
				'type'  => 'text',
			),
			'subtitle'  => array(
				'label' => esc_html__( 'Sub Title', 'cirkle-core' ),
				'type'  => 'text',
			),
			'btn_txt'      => array(
				'label' => esc_html__( 'Button Text', 'cirkle-core' ),
				'type'  => 'text',
			),
			'btn_link'      => array(
				'label' => esc_html__( 'Button Link', 'cirkle-core' ),
				'type'  => 'text',
			),

		);

		RT_Widget_Fields::display( $fields, $instance, $this );
	}
}