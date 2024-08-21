<?php
/**
 * Display single product reviews (comments)
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product-reviews.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see         https://docs.woocommerce.com/document/template-structure/
 * @author      WooThemes
 * @package     WooCommerce/Templates
 * @version     4.3.0
 */
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

global $product;

?>
    <div id="reviews" class="woocommerce-Reviews">
        <div id="comments">

            <?php if ( have_comments() ) : ?>

                <ol class="commentlist">
                    <?php wp_list_comments( apply_filters( 'woocommerce_product_review_list_args', array( 'callback' => 'woocommerce_comments' ) ) );     ?>
                </ol>

                <?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) :
                    echo '<nav class="woocommerce-pagination">';
                    paginate_comments_links( apply_filters( 'woocommerce_comment_pagination_args', array(
                        'prev_text' => '&larr;',
                        'next_text' => '&rarr;',
                        'type'      => 'list',
                    ) ) );
                    echo '</nav>';
                endif; ?>

            <?php else : ?>

                <p class="woocommerce-noreviews"><?php esc_html_e( 'There are no reviews yet.', 'cirkle' ); ?></p>

            <?php endif; ?>
        </div>
        
        <div class="clear"></div>

        <h2 class="woocommerce-Reviews-title">
            <?php
                if ( get_option( 'woocommerce_enable_review_rating' ) === 'yes' ) {
                    /* translators: 1: reviews count 2: product name */
                    $count = $product->get_review_count();
                    printf( esc_html( _n( '%1$s review for %2$s', '%1$s reviews for %2$s', $count, 'cirkle' ) ), esc_html( $count ), '<span>' .     get_the_title() . '</span>' );
                } else {
                    _e( 'Reviews', 'cirkle' );
                }
            ?></h2>

        <?php if ( get_option( 'woocommerce_review_rating_verification_required' ) === 'no' || wc_customer_bought_product( '', get_current_user_id    (), $product->get_id() ) ) : ?>

            <div id="review_form_wrapper">
                <div id="review_form">
                    <?php
                        $commenter = wp_get_current_commenter();
                        $rdtheme_req = get_option( 'require_name_email' );
                        $rdtheme_aria_req = ( $rdtheme_req ? " required" : '' );
                        $comment_form = array(
                            'title_reply'          => have_comments() ? __( 'Write a Review', 'cirkle' ) : sprintf( __( 'Be the first to review “%s&rdquo;', 'cirkle' ), get_the_title() ),
                            'title_reply_to'       => __( 'Leave a Reply to %s', 'cirkle' ),
                            'title_reply_before'   => '<span id="reply-title" class="comment-reply-title">',
                            'title_reply_after'    => '</span>',
                            'comment_notes_after'  => '',
                            'fields'               => array(
                            	'<div class="row">
						            <div class="col-sm-4"><div class="form-group">',
						                'author' => '
						                <input id="author" class="form-control" name="author" value="' . esc_attr( $commenter['comment_author'] ) . '" type="text" placeholder="'.esc_attr__( 'Name', 'cirkle' ).'" size="30"' . $rdtheme_aria_req . '/>
						            </div></div>
						            <div class="col-sm-4"><div class="form-group">',
						                'email'  => '
						                <input id="email" class="form-control" name="email" value="' . esc_attr( $commenter['comment_author_email'] ) . '" type="email" placeholder="'.esc_attr__( 'E-mail', 'cirkle' ).'" size="30"' . $rdtheme_aria_req . '/>
						            </div></div>
						            <div class="col-sm-4"><div class="form-group">',
						                'website'  => '
						                <input id="website" class="form-control" name="website" value="' . esc_attr( $commenter['comment_author_url'] ) . '" type="text" placeholder="'.esc_attr__( 'Website', 'cirkle' ).'" size="30"' . $rdtheme_aria_req . '/>
						            </div></div>
						        </div>',

                            ),
                            'label_submit'  => __( 'Submit Review', 'cirkle' ),
                            'logged_in_as'  => '',
                            'comment_field' => '',
                        );

                        if ( $account_page_url = wc_get_page_permalink( 'myaccount' ) ) {
                            $comment_form['must_log_in'] = '<p class="must-log-in">' . sprintf( __( 'You must be <a href="%s">logged in</a> to post a review.', 'cirkle' ), esc_url( $account_page_url ) ) . '</p>';
                        }

                        if ( get_option( 'woocommerce_enable_review_rating' ) === 'yes' ) {
                            $comment_form['comment_field'] = '<div class="comment-form-rating"><label for="rating">' . esc_html__( 'Your rating', 'cirkle' ) . '</label><select name="rating" id="rating" aria-required="true" required>
                                <option value="">' . esc_html__( 'Rate&hellip;', 'cirkle' ) . '</option>
                                <option value="5">' . esc_html__( 'Perfect', 'cirkle' ) . '</option>
                                <option value="4">' . esc_html__( 'Good', 'cirkle' ) . '</option>
                                <option value="3">' . esc_html__( 'Average', 'cirkle' ) . '</option>
                                <option value="2">' . esc_html__( 'Not that bad', 'cirkle' ) . '</option>
                                <option value="1">' . esc_html__( 'Very poor', 'cirkle' ) . '</option>
                            </select></div>';
                        }

                        $comment_form['comment_field'] .= '<p class="comment-form-comment"><label for="comment">' . esc_html__( 'Your review', 'cirkle' ) . '&nbsp;<span class="required">*</span></label><textarea id="comment" name="comment" cols="45" rows="8" aria-required="true" required></textarea></p>';

                        comment_form( apply_filters( 'woocommerce_product_review_comment_form_args', $comment_form ) );
                    ?>
                </div>
            </div>

        <?php else : ?>

            <p class="woocommerce-verification-required"><?php esc_html_e( 'Only logged in customers who have purchased this product may leave a review.', 'cirkle' ); ?></p>

        <?php endif; ?>      
</div>