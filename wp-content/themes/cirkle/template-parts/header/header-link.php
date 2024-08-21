<?php
/**
 * @author  RadiusTheme
 * @since   1.0
 * @version 1.0
 */
use radiustheme\cirkle\RDTheme;


$text = RDTheme::$options['hlb_txt'];
$link = RDTheme::$options['hlb_link'];
if (!empty($link )) {
?>
<a href="<?php echo esc_url($link); ?>" class="item-btn"><?php echo esc_html($text); ?></a>
<?php } ?>
