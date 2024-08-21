<?php
/**
 * This file can be overridden by copying it to yourtheme/elementor-custom/testimonial/view-1.php
 * 
 * @author  RadiusTheme
 * @since   1.0
 * @version 1.0
 */

namespace radiustheme\Cirkle_Core;
extract( $data );
$slides = array();
foreach ( $data['testimonials'] as $slide ) {
	$slides[] = array(
		'id'          => 'slide-' . time().rand( 1, 99 ),
		'picture'     => $slide['picture']['id'] ? $slide['picture']['id'] : '',
		'testi_name'  => $slide['testi_name'],
		'testi_desig' => $slide['testi_desig'],
		'content' 	  => $slide['content'],
	);
}
if (is_rtl()) {
    $rtl = true;
    $dir = 'rtl';
} else {
    $rtl = false;
    $dir = 'ltr';
}
$slick_content = array(
    'autoplaySpeed' => $data['slider_autoplay_speed'],
    'dots'          => false,
    'arrows'        => $data['slider_arrow'] == 'yes' ? true : false,
    'fade'          => true,
    'autoplay'      => $data['slider_autoplay'] == 'yes' ? true : false,
    'asNavFor'      => ".slick-nav",
    'rtl'           => $rtl,
);

$slick_content2 = array(
    'slidesToShow'     => $data['slide_to_show'],
    'slidesToShowTab'  => $data['slide_to_show_tab'],
    'autoplaySpeed'    => $data['slider_autoplay_speed'],
    'dots'             => false,
    'arrows'           => $data['slider_arrow'] == 'yes' ? true : false,
    'autoplay'         => $data['slider_autoplay'] == 'yes' ? true : false,
    'asNavFor'         => ".slick-slider",
    'centerMode'       => true,
    'focusOnSelect'    => true,
    'rtl' => $rtl,
);

$slick_content = htmlspecialchars(wp_json_encode($slick_content), ENT_QUOTES, 'UTF-8');
$slick_content2 = htmlspecialchars(wp_json_encode($slick_content2), ENT_QUOTES, 'UTF-8');

?>
<div class="testimonial-carousel">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-7">
                <div class="testimonial-box">
                    <div class="slick-carousel slick-slider" data-slick='<?php echo $slick_content; ?>'>
                        <?php foreach ( $data['testimonials'] as $slide ) { ?>
                        <div class="slick-slide">
                            <div class="testimonial-content">
                                <h3 class="item-title"><?php echo wp_kses_stripslashes( $slide['testi_name'] ); ?></h3>
                                <div class="item-subtitle"><?php echo wp_kses_stripslashes( $slide['testi_desig'] ); ?></div>
                                <p><?php echo wp_kses_stripslashes( $slide['content'] ); ?></p>
                            </div>
                        </div>
                        <?php } ?>
                    </div>
                    <div class="slick-nav slick-carousel" data-slick='<?php echo $slick_content2; ?>'>
                        <?php foreach ( $data['testimonials'] as $slide ) { ?>
                        <div class="nav-item">
                            <img src="<?php echo esc_url($slide['picture']['url']); ?>" alt="<?php esc_attr_e( 'Slider Image', 'cirkle' ); ?>">
                        </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <ul class="testimonial-shape-wrap">
        <?php foreach ( $data['shape_list'] as $shape ) { ?>
        <li><img src="<?php echo esc_url($shape['shape']['url']); ?>" alt="<?php esc_attr_e( 'Shape', 'cirkle' ); ?>"></li>
        <?php } ?>
    </ul>
</div>