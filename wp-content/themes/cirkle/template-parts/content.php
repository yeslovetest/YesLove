<?php
/**
 * @author  RadiusTheme
 * @since   1.0
 * @version 1.0
 */

namespace radiustheme\cirkle;
use radiustheme\cirkle\RDTheme;
use radiustheme\cirkle\Helper;

$excerpt_length = RDTheme::$options['excerpt_length'];
$post_id = get_the_ID();
$mcats = RDTheme::$options['meta_cats'];
$madmin = RDTheme::$options['meta_admin'];
$mdate = RDTheme::$options['meta_date'];
$mreact = RDTheme::$options['meta_react'];
$mcom = RDTheme::$options['meta_comnts'];
$pcats = '';
$pcom = '';
$adminpic = 'icon';
$comments_html   = '';  
$comments_number = number_format_i18n( get_comments_number( $post_id ) );
$comments_html  .= $comments_number < 10 && $comments_number > 0 ? '0'.$comments_number : $comments_number;

$has_entry_meta = ( $mdate || $mreact || $mcom ) ? true : false;

if ( $has_entry_meta == true ) {
    $metas = 'meta-true';
} else {
    $metas = 'meta-false';
}

?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'block-box user-blog' ); ?>>
    <?php if ( has_post_thumbnail() ): ?>
    <div class="blog-img">
        <a href="<?php the_permalink(); ?>"><?php the_post_thumbnail('cirkle-size-1'); ?></a>
    </div>
    <?php endif; ?>
    <div class="blog-content <?php echo esc_attr ( $metas ); ?>">
        <?php if ( $mcats && has_category() ){ ?>
        <div class="blog-category">
            <?php the_category( ' ' ); ?>
        </div>
        <?php } ?>
        <h3 class="blog-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
        <?php echo Helper::cirkle_get_post_meta( $post_id, $madmin, $mdate, $pcom, $pcats, $adminpic ); ?> 
        <p><?php echo Helper::cirkle_excerpt( $excerpt_length ); ?></p>
    </div>
    <?php if ( $has_entry_meta ){ ?>
    <div class="blog-meta">
        <ul>
            <?php if ( function_exists( 'rtreact_post_reactions_html' ) ) {
              if ( $mreact ){  
            ?>
            <li class="blog-post-reactions"><?php rtreact_post_reactions_html( get_the_ID() ); ?></li>
            <?php }
            }
            if ( $mcom ){ ?>
            <li><i class="icofont-comment"></i> <?php echo wp_kses( $comments_html, 'alltext_allow' ); ?> </li>
            <?php } ?>
        </ul>
    </div>
    <?php } if ( is_sticky() ) {
        echo '<sup class="meta-featured-post"> <i class="fas fa-thumbtack"></i> ' . esc_html__( 'Sticky', 'cirkle' ) . ' </sup>';
    } ?>
</article>
