<?php
/**
 * The Template for displaying all reviews.
 *
 * @package dokan
 * @package dokan - 2014 1.0
 */

$store_user = dokan()->vendor->get( get_query_var( 'author' ) );
$store_info = dokan_get_store_info( $store_user->id );
$map_location = isset( $store_info['location'] ) ? esc_attr( $store_info['location'] ) : '';
$store_style  = cartzilla_is_dokan_vendor_style_enabled();

get_header( 'shop' );
?>

<?php do_action( 'woocommerce_before_main_content' ); ?>

<?php if ( ! $store_style  ) : ?>

    <div class="container py-4 py-lg-5">

        <?php dokan_get_template_part( 'store-sidebar', '', array( 'store_user' => $store_user, 'store_info' => $store_info, 'map_location' => $map_location ) ); ?>

        <div id="dokan-primary" class="dokan-single-store dokan-w8">
            <div id="dokan-content" class="store-review-wrap woocommerce" role="main">

                <?php dokan_get_template_part( 'store-header' ); ?>


                <?php
                $dokan_template_reviews = version_compare( dokan_pro()->version, '3.0.0' , '<' ) ? Dokan_Pro_Reviews::init() : dokan_pro()->review;;
                $id                     = $store_user->id;
                $post_type              = 'product';
                $limit                  = 20;
                $status                 = '1';
                $comments               = $dokan_template_reviews->comment_query( $id, $post_type, $limit, $status );
                ?>

                <div id="reviews">
                    <div id="comments">

                        <?php do_action( 'dokan_review_tab_before_comments' ); ?>

                        <h2 class="headline"><?php esc_html_e( 'Vendor Review', 'cartzilla' ); ?></h2>

                        <ol class="commentlist">
                            <?php
                                $comment_list = $dokan_template_reviews->render_store_tab_comment_list( $comments , $store_user->id);
                                echo ! empty( $comment_list ) ? $comment_list : '';
                            ?>
                        </ol>

                    </div>
                </div>

                <?php
                $review_pagination = $dokan_template_reviews->review_pagination( $id, $post_type, $limit, $status );
                echo ! empty( $review_pagination ) ? $review_pagination : '';
                ?>

            </div><!-- #content .site-content -->
        </div><!-- #primary .content-area -->
    </div>

<?php else : ?>

    <?php 
        cartzilla_dokan_dashboard_page_title( $store_user->id );

        do_action( 'cartzilla_dokan_vendor_page_start', $store_user );

        $dokan_template_reviews = version_compare( dokan_pro()->version, '3.0.0' , '<' ) ? Dokan_Pro_Reviews::init() : dokan_pro()->review;;
        $id                     = $store_user->id;
        $post_type              = 'product';
        $limit                  = 20;
        $status                 = '1';
        $comments               = $dokan_template_reviews->comment_query( $id, $post_type, $limit, $status );
        ?>

        <div id="reviews">
            <div id="comments">

                <?php do_action( 'dokan_review_tab_before_comments' ); ?>

                <h3 class="headline"><?php esc_html_e( 'Vendor Review', 'cartzilla' ); ?></h3>

                <ol class="commentlist">
                    <?php
                        $comment_list = $dokan_template_reviews->render_store_tab_comment_list( $comments , $store_user->id);
                        echo ! empty( $comment_list ) ? $comment_list : '';
                    ?>
                </ol>

            </div>
        </div>

        <?php
        echo cartzilla_review_pagination( $id, $post_type, $limit, $status );

        do_action( 'cartzilla_dokan_vendor_page_end', $store_user );
    ?>

<?php endif; ?>

<?php do_action( 'woocommerce_after_main_content' ); ?>

<?php get_footer(); ?>
