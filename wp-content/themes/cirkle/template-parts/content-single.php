<?php
/**
 * @author  RadiusTheme
 * @since   1.0
 * @version 1.0
 */

namespace radiustheme\cirkle;
use radiustheme\cirkle\Socials;
use radiustheme\cirkle\RDTheme;
use radiustheme\cirkle\Helper;
// global $post;
$post_id = get_the_ID();
$pcats = RDTheme::$options['post_cats'];
$padmin = RDTheme::$options['post_admin'];
$pdate = RDTheme::$options['post_date'];
$pcom = RDTheme::$options['post_comnts'];
$pshare = RDTheme::$options['post_share'];
$preact = RDTheme::$options['post_react'];
$preact_text = RDTheme::$options['meta_react_text'];
$related_post = RDTheme::$options['related_post'];
$adminpic = 'pic';

$mdate = RDTheme::$options['meta_date'];
$mcom = RDTheme::$options['meta_comnts'];
$mreact = RDTheme::$options['meta_react'];
$has_entry_meta = ( $mdate || $mreact || $mcom ) ? true : false;

if ( RDTheme::$options['post_share'] == "1" ){
    $meta_cols = '9';
    $tags_shares = '';
} else {
    $meta_cols = '12';
    $tags_shares = 'tags-shares-none';
}

$mcom = RDTheme::$options['meta_comnts'];
$has_entry_meta = ( $mdate || $mreact || $mcom ) ? true : false;

$comments_number = number_format_i18n( get_comments_number($post_id) );
$comments_html   = $comments_number;  
$comments_html   = $comments_number < 2 ? esc_html__( 'Comment ' , 'cirkle' ).$comments_html : esc_html__( 'Comments ' , 'cirkle' ).$comments_html;
?>

<div id="post-<?php the_ID(); ?>" class="block-box user-single-blog">
    <?php if ( has_post_thumbnail() ){ ?>   
    <div class="blog-thumbnail">
        <?php the_post_thumbnail(); ?>
    </div>
    <?php } ?>
    <div class="blog-content-wrap">
        <div class="blog-entry-header">
            <div class="row align-items-center">
                <div class="col-lg-<?php echo esc_attr( $meta_cols ); ?>">
                    <?php echo Helper::cirkle_get_post_meta( $post_id, $padmin, $pdate, $pcom, $pcats, $adminpic ); ?> 
                </div>
                <?php if ( RDTheme::$options['post_share'] == "1" ){ ?>
                <div class="col-lg-3">
                    <?php Helper::render(); ?>
                </div>
                <?php } ?>
            </div>
        </div>
        <div class="blog-content">
            <?php the_content(); ?>
            <?php wp_link_pages( array(
                'before'      => '<div class="cirkle-page-links"><span class="page-links-title">' . esc_html__( 'Pages:', 'cirkle' ) . '</span>',
                'after'       => '</div>',
                'link_before' => '<span>',
                'link_after'  => '</span>',
                ) );
            ?>
        </div>
        <?php 
            if ( is_user_logged_in() ) {
                 if ($preact) {
        ?>
            <?php if ( function_exists( 'rtreact_post_reactions_html' ) ) { ?>
            <div class="blog-footer">
                <div class="blog-post-reactions"><?php rtreact_post_reactions_html( get_the_ID() ); ?></div>
                <div class="item-label"><?php wp_kses_stripslashes( $preact_text ); ?></div>
                <div class="post-react"></div>
            </div>
            <?php } 
            } ?>
        <?php } if ( comments_open() || get_comments_number() ){ ?>
        <div class="blog-comment-form">
            <?php comments_template(); ?> 
        </div>
        <?php } ?>
    </div>
</div>


 


<?php if ($related_post) { 
    $per_page = RDTheme::$options['post_per_page'];
    $args = array(
        'post_type' => 'post',
        'category__in' => wp_get_post_categories(get_the_ID()),
        'post__not_in' => array(get_the_ID()),
        'posts_per_page' => $per_page,
        'orderby' => 'date',
    );
    $my_query = new \WP_Query($args);
    if( $my_query->have_posts() ) {
?>
<div class="realated-blog">
    <?php if (!empty( RDTheme::$options['related_post_title'] )) { ?>
    <div class="block-box blog-heading">
        <h3 class="heading-title"><?php echo esc_html( RDTheme::$options['related_post_title'] ); ?></h3>
    </div>
    <?php } ?>
    <div class="row">
        <?php 
        while ($my_query->have_posts()) : $my_query->the_post(); ?>
        <div class="col-lg-4">
            <div class="block-box user-blog">
                <?php if ( has_post_thumbnail() ){ ?> 
                <div class="blog-img">
                    <a href="<?php the_permalink(); ?>"><?php the_post_thumbnail('cirkle-size-1'); ?></a>
                </div>
                <?php } ?>
                <div class="blog-content">
                    <?php if ( $pcats && has_category() ){ ?>
                    <div class="blog-category">
                        <?php the_category( ' ' ); ?>
                    </div>
                    <?php } ?>
                    <h3 class="blog-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                    <div class="blog-date"><i class="icofont-calendar"></i> <?php the_time( get_option( 'date_format' ) ); ?> </div>
                    <p><?php echo Helper::cirkle_excerpt(15); ?></p>
                </div>
                <?php if ( $has_entry_meta ){ ?>
                <div class="blog-meta">
                    <ul>
                        <?php if ( function_exists( 'rtreact_post_reactions_html' ) ) { ?>
                        <li class="blog-post-reactions"><?php rtreact_post_reactions_html( get_the_ID() ); ?></li>
                        <?php }
                        if ( $mcom ){ ?>
                        <li><i class="icofont-comment"></i> <?php echo wp_kses( $comments_html, 'alltext_allow' ); ?> </li>
                        <?php } ?>
                    </ul>
                </div>
                <?php } ?>
            </div>
        </div>
        <?php endwhile; ?>
    </div>
</div>
<?php }
 wp_reset_query();
}
?>