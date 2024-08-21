<?php
/**
 * @author  RadiusTheme
 * @since   1.0
 * @version 1.0
 */

namespace radiustheme\cirkle;
$previous = get_previous_post();
$next = get_next_post();
if ($previous && $next) {
    $cols = '6';
} else {
   $cols = '12'; 
}
if ( $previous || $next ):

?>

<div class="thumb-pagination">
    <div class="row">
        <?php if ( $previous ): ?>
        <div class="col-md-<?php echo esc_attr( $cols ); ?>">
            <a href="<?php echo esc_url( get_permalink( $previous ) ); ?>" class="pg-prev">
                <div class="media">
                    <?php if ( has_post_thumbnail( $previous ) ): ?>
                    <div class="item-img">
                        <?php echo get_the_post_thumbnail( $previous, 'thumbnail' ); ?>
                    </div>
                    <?php endif; ?>
                    <div class="media-body">
                        <h5 class="item-title"><?php echo get_the_title( $previous ); ?></h5>
                        <div class="item-subtitle"><?php esc_html_e( 'Previous Post', 'cirkle' ); ?></div>
                    </div>
                </div>
            </a>
        </div>
        <?php endif; if ( $next ): ?>
        <div class="col-md-<?php echo esc_attr( $cols ); ?>">
            <a href="<?php echo esc_url( get_permalink( $next ) ); ?>" class="pg-next">
                <div class="media">
                    <div class="media-body">
                        <h5 class="item-title"><?php echo get_the_title( $next ); ?></h5>
                        <div class="item-subtitle"><?php esc_html_e( 'Next Post', 'cirkle' );?></div>
                    </div>
                    <?php if ( has_post_thumbnail( $next ) ): ?>
                    <div class="item-img">
                        <?php echo get_the_post_thumbnail( $next, 'thumbnail' ); ?>
                    </div>
                    <?php endif; ?>
                </div>
            </a>
        </div>
        <?php endif; ?>
    </div>
</div>
<?php endif; ?>