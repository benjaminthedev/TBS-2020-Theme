<?php
/**
 * Template Tags used in Single Product Page
 *
 * @package cartzilla
 */
/**
 * Remove shop sidebar on single product page
 *
 * @since 1.0.0
 */
if ( ! function_exists( 'cartzilla_wc_product_remove_sidebar' ) ) {
    function cartzilla_wc_product_remove_sidebar() {
        if ( is_product() ) {
            remove_action( 'woocommerce_sidebar', 'woocommerce_get_sidebar' );
        }
    }
}

if ( ! function_exists( 'cartzilla_get_single_product_style' ) ) {
    function cartzilla_get_single_product_style() {

        $product_style = get_theme_mod( 'product_style', 'style-v2' );
    
        return sanitize_key( apply_filters( 'cartzilla_single_product_style', $product_style ) );
    }
}



/**
 * Displays the Page Title for WooCommerce's single product
 *
 * This function uses "cartzilla_is_wc_product_title" filter, which allows to control
 * Page Title visibility. You can completely disable page title:
 *
 *     add_filter( 'cartzilla_is_wc_product_title', '__return_false' );
 *
 * @since 1.0.0
 */
if ( ! function_exists( 'cartzilla_wc_product_title' ) ) {
    function cartzilla_wc_product_title() {
        $style = cartzilla_get_single_product_style();

        if ( ! (bool) apply_filters( 'cartzilla_is_wc_product_title', true ) ) {
            return;
        }

        ?>
        <div class="page-title-overlap pt-4 <?php echo cartzilla_wc_catalog_type() ===  'dark'  ? ( cartzilla_get_single_product_style() === 'style-v3' ? 'bg-accent' : 'bg-dark' ) : 'bg-secondary'; ?>">
            <div class="container d-lg-flex justify-content-between py-2 py-lg-3">
                <div class="order-lg-2 mb-3 mb-lg-0 pt-lg-2">
                    <?php cartzilla_breadcrumbs(); ?>
                </div>
                <div class="order-lg-1 pr-lg-4 text-center text-lg-left">
                    <h1 class="h3 <?php echo cartzilla_wc_catalog_type() ===  'dark'  ? 'text-light' : 'text-dark'; ?><?php echo cartzilla_get_single_product_style() === 'style-v1' ? ' mb-0' : ' mb-2';?>"><?php single_post_title(); ?></h1>
                    <?php if ( $style === 'style-v2') {
                        cartzilla_wc_product_rating();
                    } ?>
                </div>
            </div>
        </div>
        <?php
    }
}

/**
 * Before single product content
 *
 * Wraps the single product content in div.container
 *
 * @hooked woocommerce_before_single_product_summary 0
 *
 * @since 1.0.0
 */
if ( ! function_exists( 'cartzilla_wc_product_container_open' ) ) {
    function cartzilla_wc_product_container_open() {
        echo '<div class="container">';
    }
}

/**
 * After single product content
 *
 * Closes the wrapping div.
 *
 * @hooked woocommerce_after_single_product_summary 200
 *
 * @since 1.0.0
 */
if ( ! function_exists( 'cartzilla_wc_product_container_close' ) ) {
    function cartzilla_wc_product_container_close() {
        echo '</div>';
    }
}

/**
 * Before single product details (galley + summary)
 *
 * Wraps the single product summary in wrappers which match the theme markup.
 *
 * @hooked woocommerce_before_single_product_summary 0
 *
 * @since 1.0.0
 */
if ( ! function_exists( 'cartzilla_wc_product_details_before' ) ) {
    function cartzilla_wc_product_details_before() {
        // div.bg-light.box-shadow-lg.rounded-lg.px-4.py-3.mb-5 > div.px-lg-3 > div.row
        echo '<div class="product-summary bg-light box-shadow-lg rounded-lg px-4 py-3 mb-5"><div class="px-lg-3"><div class="row">';
    }
}

/**
 * After single product details (gallery + summary)
 *
 * Closes the wrapping divs.
 *
 * @hooked woocommerce_after_single_product_summary 100
 *
 * @since 1.0.0
 */
if ( ! function_exists( 'cartzilla_wc_product_details_after' ) ) {
    function cartzilla_wc_product_details_after() {
        echo '</div></div></div>';
    }
}

/**
 * Before single product summary
 *
 * Wraps the div.summary in div.col-lg-5... to match theme markup.
 *
 * @hooked
 *
 * @since 1.0.0
 */
if ( ! function_exists( 'cartzilla_wc_product_summary_before' ) ) {
    function cartzilla_wc_product_summary_before() {
        global $product;
        $attachment_ids = $product->get_gallery_image_ids(); ?>

        <div class="<?php if ( $attachment_ids ) : ?>col-lg-5<?php else: ?>col-lg-6<?php endif;?> pt-4 pt-lg-0 cz-image-zoom-pane"><div class="product-details ml-auto pb-3">
            <?php
    }
}

/**
 * After single product summary
 *
 * Closes the column div around div.summary
 *
 * @hooked woocommerce_after_single_product_summary 0
 *
 * @since 1.0.0
 */
if ( ! function_exists( 'cartzilla_wc_product_summary_after' ) ) {
    function cartzilla_wc_product_summary_after() {
        echo '</div></div>';
    }
}

/**
 * Output the product image and thumbnails before the single product summary.
 *
 * @see woocommerce_show_product_images()
 *
 * @hooked woocommerce_before_single_product_summary 20
 *
 * @since 1.0.0
 */
if ( ! function_exists( 'cartzilla_wc_product_images' ) ) {
    function cartzilla_wc_product_images() { 
        global $product;
        $attachment_ids = $product->get_gallery_image_ids();
        ?>
        <div class="<?php if ( $attachment_ids ) : ?>col-lg-7<?php else: ?>col-lg-5 offset-1<?php endif;?> pr-lg-0<?php echo cartzilla_get_single_product_style() === 'style-v1' ? ' pt-lg-4' : '' ;?>">
        <?php woocommerce_show_product_images();?>
        </div><?php
    }
}

if ( ! function_exists( 'cartzilla_row_wrap_open' ) ) {
    function cartzilla_row_wrap_open() { ?>
        <div class="row cartzilla-product-style-v2"><?php
    }
}

if ( ! function_exists( 'cartzilla_row_wrap_close' ) ) {
    function cartzilla_row_wrap_close() { ?>
        </div><?php
    }
}

if ( ! function_exists( 'cartzilla_yith_wcqv_product_summary_row_wrap_open' ) ) {
    function cartzilla_yith_wcqv_product_summary_row_wrap_open() { ?>
        <div class="row"><?php
    }
}

if ( ! function_exists( 'cartzilla_yith_wcqv_product_summary_row_wrap_close' ) ) {
    function cartzilla_yith_wcqv_product_summary_row_wrap_close() { ?>
        </div><?php
    }
}



/**
 * Output the product rating and "Add to wishlist" button (if applicable)
 *
 * @see woocommerce_template_single_rating()
 * @see single-product/rating.php
 *
 * @hooked woocommerce_single_product_summary 10
 *
 * @since 1.0.0
 */
if ( ! function_exists( 'cartzilla_wc_product_rating_wishlist' ) ) {
    function cartzilla_wc_product_rating_wishlist() {
        global $product;
        // Add the link "Add to wishlist"
        $position = get_option( 'yith_wcwl_button_position', 'add-to-cart' );

        ?>
        <div class="d-flex product-rating justify-content-between align-items-center mb-2">
            <?php
            if ( post_type_supports( 'product', 'comments' ) && wc_review_ratings_enabled() ) :
                $rating_count = $product->get_rating_count();
                $review_count = $product->get_review_count();
                if ( $rating_count > 0 ) : ?>
                    <a class="cartzilla-star-rating" href="#reviews" rel="nofollow" data-scroll>
                        <?php echo wc_get_rating_html( $product->get_average_rating(), $rating_count ) ?>
                        <span class="d-inline-block font-size-sm text-body align-middle ml-1 mt-n1">
                            <?php printf( _n( '%s review', '%s reviews', $review_count, 'cartzilla' ), esc_html( $review_count ) ); ?>
                        </span>
                    </a>
                <?php endif; ?>
            <?php endif; ?>

            <?php if( function_exists( 'cartzilla_add_to_wishlist_button' ) && $position === 'shortcode' ) {
                cartzilla_add_to_wishlist_button();
            } ?>
        </div>
        <?php
    }
}

/**
 * Output the product rating and "Add to wishlist" button (if applicable)
 *
 * @see woocommerce_template_single_rating()
 * @see single-product/rating.php
 *
 * @hooked woocommerce_single_product_summary 10
 *
 * @since 1.0.0
 */
if ( ! function_exists( 'cartzilla_quick_view_product_rating_wishlist' ) ) {
    function cartzilla_quick_view_product_rating_wishlist() {
        global $product;
        // Add the link "Add to wishlist"
        $position = get_option( 'yith_wcwl_button_position', 'add-to-cart' );

        ?>
        <div class="d-flex justify-content-between align-items-center mb-2">
            <?php
            if ( post_type_supports( 'product', 'comments' ) && wc_review_ratings_enabled() ) :
                $rating_count = $product->get_rating_count();
                $review_count = $product->get_review_count();
                if ( $rating_count > 0 ) : ?>
                    <a class="d-flex align-items-center" href="<?php echo esc_url( apply_filters( 'woocommerce_loop_product_link', get_the_permalink(), $product ) ); ?>/#reviews" rel="nofollow" data-scroll>
                        <?php echo wc_get_rating_html( $product->get_average_rating(), $rating_count ) ?>
                        <span class="d-inline-block font-size-sm text-body align-middle ml-1">
                            <?php printf( _n( '%s review', '%s reviews', $review_count, 'cartzilla' ), esc_html( $review_count ) ); ?>
                        </span>
                    </a>
                <?php endif; ?>
            <?php endif; ?>

            <?php if( function_exists( 'cartzilla_add_to_wishlist_button' ) && $position === 'shortcode' ) {
                cartzilla_add_to_wishlist_button();
            } ?>
        </div>
        <?php
    }
}


if ( ! function_exists( 'cartzilla_wc_product_rating' ) ) {
    function cartzilla_wc_product_rating() {
        global $product;

        ?>
        <div class="cartzilla-title-with-rating">
            <?php
            if ( post_type_supports( 'product', 'comments' ) && wc_review_ratings_enabled() ) :
                $rating_count = $product->get_rating_count();
                $review_count = $product->get_review_count();
                if ( $rating_count > 0 ) : ?>
                    <?php echo wc_get_rating_html( $product->get_average_rating(), $rating_count ) ?>
                    <span class="d-inline-block font-size-sm align-middle mt-1 ml-1 <?php echo cartzilla_wc_catalog_type() ===  'dark'  ? 'text-white' : 'text-body'; ?>">
                        <?php printf( _n( '%s review', '%s reviews', $review_count, 'cartzilla' ), esc_html( $review_count ) ); ?>
                    </span>
                <?php endif; ?>
            <?php endif; ?>
        </div>
        <?php
    }
}

/**
 * Get formatted product price
 *
 * @return string
 */
if ( ! function_exists( 'cartzilla_wc_product_price' ) ) {
    function cartzilla_wc_product_price() {
        global $product;

        return $product->get_price_html();
    }
}

/**
 * Output the product price and labels (sale, featured, etc)
 *
 * @see woocommerce_template_single_price()
 * @see woocommerce_show_product_sale_flash()
 * @see single-product/price.php
 * @see single-product/sale-flash.php
 *
 * @hooked woocommerce_single_product_summary 20
 *
 * @since 1.0.0
 */
if ( ! function_exists( 'cartzilla_wc_product_price_labels' ) ) {
    function cartzilla_wc_product_price_labels() {
        global $post, $product;

        ?>
        <div class="position-relative d-flex align-items-center">
            <div class="<?php echo esc_attr( apply_filters( 'woocommerce_product_price_class', 'price mb-3' ) ); ?>">
                <?php echo cartzilla_wc_product_price(); ?>
                <?php if ( $product->is_on_sale() ) : ?>
                    <?php echo apply_filters( 'woocommerce_sale_flash', '<span class="badge badge-danger badge-shadow align-middle mt-n2">' . esc_html_x( 'Sale', 'front-end', 'cartzilla' ) . '</span>', $post, $product ); ?>
                <?php endif; ?>
            </div>
            <?php if ( $product->get_type() == 'simple' ) {
                echo wc_get_stock_html( $product );  
            }?>
        </div>
        <?php
    }
}

/**
 * Output the product details panels
 *
 * @see woocommerce_template_single_excerpt()
 * @see single-product/short-description.php
 *
 * @hooked woocommerce_single_product_summary 40
 *
 * @since 1.0.0
 */
if ( ! function_exists( 'cartzilla_wc_product_excerpt' ) ) {
    function cartzilla_wc_product_excerpt() {
        global $post;

        if ( empty( $post->post_excerpt ) ) {
            return;
        }

        ?>
        
        <div class="product-desc">
            <?php echo apply_filters( 'woocommerce_short_description', $post->post_excerpt ); ?>
        </div>
        <?php
    }
}

/**
 * Output the product description
 *
 * @hooked woocommerce_after_single_product_summary 220
 *
 * @since 1.0.0
 */
if ( ! function_exists( 'cartzilla_wc_product_description' ) ) {
    function cartzilla_wc_product_description() {
        $style = cartzilla_get_single_product_style();
        ?>
        <div class="product-description container<?php echo cartzilla_get_single_product_style() === 'style-v2' ? ' pt-lg-3 pb-4 pb-sm-5' : ' py-md-3';?>">
            <?php the_content(); ?>
        </div>
        <?php
    }
}


/**
 * Output product reviews
 *
 * @hooked woocommerce_after_single_product_summary 240
 *
 * @since 1.0.0
 */
if( ! function_exists( 'cartzilla_wc_reviews' ) ) {
    function cartzilla_wc_reviews() {
        if ( ! comments_open() ) {
            return;
        }

        comments_template();
    }
}

/**
 * Display the overall product rating based on the reviews
 *
 * @hooked cartzilla_single_product_reviews_before 10
 *
 * @since 1.0.0
 */
if( ! function_exists( 'cartzilla_wc_reviews_overall' ) ) {
    function cartzilla_wc_reviews_overall() {
        /** @var WC_Product $product */
        global $product;

        // Count the total number of stars per each rating value (e.g. total number of fives, fours, etc)
        $comments = get_comments( [
            'fields'  => 'ids',
            'post_id' => $product->get_id(),
            'status'  => 'approve',
        ] );

        if ( empty( $comments ) ) {
            return;
        }

        // Count per rating.
        // Create an array with keys from 0 to 5 where each key is rating provided by user.
        // A key 0 will be used for invalid meta and will not be taken into account.
        $cpr = array_fill( 0, 6, 0 );
        foreach ( array_map( 'intval', $comments ) as $comment_ID ) {
            // TODO: may we get rid of get_comment_meta and make this query a little bit more performant?
            $comment_rating = (int) get_comment_meta( $comment_ID, 'rating', true );
            $cpr[ $comment_rating ] ++;
        }
        unset( $comment_ID );

        // Total recommended is a sum of fives and fours
        $total_recommended = $cpr[4] + $cpr[5];

        // A total number of reviews and an average product rating
        $total_reviews = $product->get_review_count();
        $avg_rating    = $product->get_average_rating();

        // With per rating.
        // Count the width of each progress bar for total number of fives, fours, etc.
        $wpr = array_fill( 0, 6, 0 );
        foreach ( $cpr as $k => $v ) {
            $wpr[ $k ] = round( ( $v * 100 ) / $total_reviews );
        }

        ?>
        <div class="row pb-3">
            <div class="col-lg-4 col-md-5">
                <h2 class="h3 mb-4"><?php
                    /* translators: 1: reviews count */
                    $reviews_title = sprintf( esc_html( _n( '%s review', '%s reviews', $total_reviews, 'cartzilla' ) ), esc_html( $total_reviews ) );
                    echo apply_filters( 'woocommerce_reviews_title', $reviews_title, $total_reviews, $product ); // WPCS: XSS ok.
                ?></h2>

                <?php echo wc_get_rating_html( $avg_rating ); ?>
               <?php if ( $avg_rating > 0  ) { ?>
                    <span class="d-inline-block align-middle ml-sm-2"><?php
                        /* translators: 1: average rating */
                        echo sprintf( esc_html_x( '%s overall rating', 'front-end', 'cartzilla'), esc_html( $avg_rating ) );
                    ?></span>
                <?php } ?>

                <p class="pt-3 font-size-sm text-muted"><?php
                    /* translators: 1: sum of fives and fours, 2: total number of reviews, 3: ratio (in percentage) of recommended to total */
                    echo sprintf( esc_html_x( '%d out of %d (%d%%)', 'front-end', 'cartzilla'),
                        $total_recommended,
                        $total_reviews,
                        round( ( $total_recommended * 100 ) / $total_reviews )
                    );
                ?><br><?php echo esc_html_x( 'customers recommended this product', 'front-end', 'cartzilla' ); ?></p>
            </div>
            <div class="col-lg-8 col-md-7">
                <div class="d-flex align-items-center mb-2">
                    <div class="text-nowrap mr-3">
                        <span class="d-inline-block align-middle text-muted">5</span>
                        <i class="czi-star-filled font-size-xs ml-1"></i>
                    </div>
                    <div class="w-100">
                        <div class="progress" style="height: 4px;">
                            <div class="progress-bar bg-success" role="progressbar" style="width: <?php echo absint( $wpr[5] ); ?>%;" aria-valuenow="<?php echo absint( $wpr[5] ); ?>" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                    <span class="text-muted ml-3"><?php echo absint( $cpr[5] ); ?></span>
                </div>
                <div class="d-flex align-items-center mb-2">
                    <div class="text-nowrap mr-3">
                        <span class="d-inline-block align-middle text-muted">4</span>
                        <i class="czi-star-filled font-size-xs ml-1"></i>
                    </div>
                    <div class="w-100">
                        <div class="progress" style="height: 4px;">
                            <div class="progress-bar" role="progressbar" style="width: <?php echo absint( $wpr[4] ); ?>%; background-color: #a7e453;" aria-valuenow="<?php echo absint( $wpr[4] ); ?>" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                    <span class="text-muted ml-3"><?php echo absint( $cpr[4] ); ?></span>
                </div>
                <div class="d-flex align-items-center mb-2">
                    <div class="text-nowrap mr-3">
                        <span class="d-inline-block align-middle text-muted">3</span>
                        <i class="czi-star-filled font-size-xs ml-1"></i>
                    </div>
                    <div class="w-100">
                        <div class="progress" style="height: 4px;">
                            <div class="progress-bar" role="progressbar" style="width: <?php echo absint( $wpr[3] ); ?>%; background-color: #ffda75;" aria-valuenow="<?php echo absint( $wpr[3] ); ?>" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                    <span class="text-muted ml-3"><?php echo absint( $cpr[3] ); ?></span>
                </div>
                <div class="d-flex align-items-center mb-2">
                    <div class="text-nowrap mr-3">
                        <span class="d-inline-block align-middle text-muted">2</span>
                        <i class="czi-star-filled font-size-xs ml-1"></i>
                    </div>
                    <div class="w-100">
                        <div class="progress" style="height: 4px;">
                            <div class="progress-bar" role="progressbar" style="width: <?php echo absint( $wpr[2] ); ?>%; background-color: #fea569;" aria-valuenow="<?php echo absint( $wpr[2] ); ?>" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                    <span class="text-muted ml-3"><?php echo absint( $cpr[2] ); ?></span>
                </div>
                <div class="d-flex align-items-center">
                    <div class="text-nowrap mr-3">
                        <span class="d-inline-block align-middle text-muted">1</span>
                        <i class="czi-star-filled font-size-xs ml-1"></i>
                    </div>
                    <div class="w-100">
                        <div class="progress" style="height: 4px;">
                            <div class="progress-bar bg-danger" role="progressbar" style="width: <?php echo absint( $wpr[1] ); ?>%;" aria-valuenow="<?php echo absint( $wpr[1] ); ?>" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                    <span class="text-muted ml-3"><?php echo absint( $cpr[1] ); ?></span>
                </div>
            </div>
        </div>
        <hr class="mt-4 pb-4 mb-3">
        <?php
    }
}

/**
 * Display reviewer's avatar, name, rating and date
 *
 * @param WP_Comment $comment
 *
 * @hooked woocommerce_review_before_comment_text 10
 *
 * @since 1.0.0
 */
if( ! function_exists( 'cartzilla_wc_review_before' ) ) {
    function cartzilla_wc_review_before( $comment ) {
        $verified = wc_review_is_from_verified_owner( $comment->comment_ID );
        $rating   = intval( get_comment_meta( $comment->comment_ID, 'rating', true ) );

        ?>
        <div class="d-flex mb-3">
            <div class="media align-items-center mr-4 pr-2">
                <?php echo get_avatar( $comment, apply_filters( 'woocommerce_review_gravatar_size', 50 ), '', get_comment_author( $comment ), [
                    'class' => 'rounded-circle',
                ] ); ?>
                <div class="media-body pl-3">
                    <h6 class="font-size-sm mb-0">
                        <?php comment_author( $comment ); ?>
                        <?php if ( 'yes' === get_option( 'woocommerce_review_rating_verification_label' ) && $verified ) : ?>
                            <i class="czi-check-circle ml-2 mt-n1 font-size-base align-middle text-success" data-toggle="tooltip" data-original-title="<?php echo esc_attr__( 'verified owner', 'cartzilla' ); ?>"></i>
                        <?php endif; ?>
                    </h6>
                    <span class="font-size-ms text-muted"><?php echo esc_html( get_comment_date( wc_date_format(), $comment ) ); ?></span>
                </div>
            </div>
            <div>
                <?php if ( $rating && wc_review_ratings_enabled() ) :
                    echo wc_get_rating_html( $rating ); // WPCS: XSS ok.
                endif; ?>
            </div>
        </div>
        <?php
    }
}

/**
 * Display the review text
 *
 * @param WP_Comment $comment
 *
 * @hooked woocommerce_review_comment_text 10
 *
 * @since 1.0.0
 */
if( ! function_exists( 'cartzilla_wc_review' ) ) {
    function cartzilla_wc_review( $comment ) {
        ?>
        <div class="font-size-md mb-2">
            <?php if ( '0' === $comment->comment_approved ) : ?>
                <em class="woocommerce-review__awaiting-approval">
                    <?php esc_html_e( 'Your review is awaiting approval', 'cartzilla' ); ?>
                </em>
            <?php else : ?>
                <?php comment_text( $comment ); ?>
            <?php endif; ?>
        </div>
        <?php
    }
}

if( ! function_exists( 'cartzilla_wc_product_tabs_wrap_open' ) ) {
    function cartzilla_wc_product_tabs_wrap_open() {
        ?>
        <div class="bg-light box-shadow-lg rounded-lg"><?php

    }
}

if( ! function_exists( 'cartzilla_wc_product_tabs_wrap_close' ) ) {
    function cartzilla_wc_product_tabs_wrap_close() {
        ?>
        </div><?php

    }
}

if ( ! function_exists( 'cartzilla_wc_product_info_tab' ) ) {
    function cartzilla_wc_product_info_tab() {

        remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30 );
        remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_sharing', 50 );

        do_action( 'cartzilla_info_tab_before_single_product_summary' );

        do_action( 'cartzilla_info_tab_single_product_summary' );

        do_action( 'cartzilla_info_tab_after_single_product_summary' );

    }
}

if ( ! function_exists( 'cartzilla_wc_product_specification_tab' ) ) {
    function cartzilla_wc_product_specification_tab() {
        global $product;
        $product_id = $product->get_id();
        $specifications = get_post_meta( $product_id, '_specifications', true );

        
        if ( ! empty( $specifications ) ) {
            echo apply_filters( 'the_content', wp_kses_post( $specifications ) );
        }
    }
}

if ( ! function_exists( 'cartzilla_wc_product_accssories' ) ) {
    function cartzilla_wc_product_accssories() {
        cartzilla_get_template( 'shop/single-product/accessories.php' );
    }
}



if ( ! function_exists( 'cartzilla_wc_product_tab_before_content' ) ) {
    function cartzilla_wc_product_tab_before_content( $key ) {
        if ( $key != 'get_info') {
            global $product;
            $product_image_id = $product->get_image_id();
            
            // Add the link "Add to wishlist"
            $position = get_option( 'yith_wcwl_button_position', 'add-to-cart' ); ?>
            <?php if ( ! ( $product->get_type() == 'grouped') )  : ?>
                <div class="product-before-content d-md-flex justify-content-between align-items-start pb-4 mb-4 border-bottom">
                    <div class="media align-items-center mr-md-3">
                       <?php echo wp_get_attachment_image( $product_image_id,'thumbnail', '', array( 'class' => 'product-image' ) ); ?>

                        <div class="mdeia-body pl-3">
                            <h6 class="font-size-base mb-2"><?php the_title(); ?></h6>
                             <span class="h4 font-weight-normal text-accent"><?php echo wp_kses_post( $product->get_price_html() ); ?></span>
                        </div>
                    </div>
                    <div class="single-add-to-cart d-flex pt-3 flex-direction">
                        
                        <?php woocommerce_template_single_add_to_cart(); ?>

                        <?php if( function_exists( 'cartzilla_add_to_wishlist_button' ) || cartzilla_is_yith_woocompare_activated() ): ?>
                            <div class="d-flex align-items-center mt-3">
                            <?php if( function_exists( 'cartzilla_add_to_wishlist_button' ) && $position === 'shortcode' ) { ?>
                                <div class="wishlist-icon w-100">
                                    <?php cartzilla_add_to_wishlist_button(); ?>
                                </div>
                            <?php  } ?>
                            
                            <?php if( cartzilla_is_yith_woocompare_activated() ) { ?>
                                <div class="w-100"> <?php cartzilla_add_to_compare_link(); ?> </div>
                            <?php } ?>
                        </div>
                    <?php endif; ?>

                    </div>
                </div><?php
            endif; 
        }
    }
}


if ( ! function_exists( 'cartzilla_wc_product_tabs' ) ) {
    function cartzilla_wc_product_tabs( $tabs = array() ) {
        global $product;

        $product_id = $product->get_id();
        $specifications = get_post_meta( $product_id, '_specifications', true );

        // Remove the description tab
        if ( isset( $tabs['description'] ) ) unset( $tabs['description'] );

        // Get Info tab - shows product content.
        $tabs['get_info'] = array(
            'title'    => esc_html__( 'General Info', 'cartzilla' ),
            'priority' => 10,
            'callback' => 'cartzilla_wc_product_info_tab',
        );

        if ( ! empty( $specifications ) && apply_filters( 'cartzilla_wc_product_enable_specification_tab', true ) ) {
            $tabs['specification'] = array(
                'title'    => esc_html__( 'Tech Specs', 'cartzilla' ),
                'priority' => 15,
                'callback' => 'cartzilla_wc_product_specification_tab'
            );
        }

        return $tabs;
    }
}

if ( ! function_exists( 'cartzilla_output_related_products' ) ) {
    function cartzilla_output_related_products() {
        if ( apply_filters( 'cartzilla_enable_related_products', get_theme_mod( 'enable_related_products', 'yes' ) ) ) {
            woocommerce_output_related_products();
        }
    }
}

if ( ! function_exists( 'cartzilla_wc_product_wishlist_compare' ) ) {
    function cartzilla_wc_product_wishlist_compare() { 
        // Add the link "Add to wishlist"
        $position = get_option( 'yith_wcwl_button_position', 'add-to-cart' ); 
        if( function_exists( 'cartzilla_add_to_wishlist_button' ) || cartzilla_is_yith_woocompare_activated() ):
        ?>
        <div class="d-flex mb-4 wishlist-and-compare-block mt-4">
            <?php if( function_exists( 'cartzilla_add_to_wishlist_button' ) && $position === 'shortcode' ) { ?>
                <div class="w-100">
                    <?php cartzilla_add_to_wishlist_button(); ?>
                </div>
            <?php  } ?>
            
            <?php if( cartzilla_is_yith_woocompare_activated() ) { ?>
                <div class="w-100 compare">
                    <?php cartzilla_add_to_compare_link(); ?>
                </div>
           <?php } ?>
            
        </div><?php endif;
        
    }
}

/** 
 * remove on single product panel 'Additional Information' since it already says it on tab.
 */
function cartzilla_get_sale_flash() {

    global $product;

    if ( $product->is_on_sale() ) {

        if ( ! $product->is_type( 'variable' ) ) {

            $max_percentage = ( ( $product->get_regular_price() - $product->get_sale_price() ) / $product->get_regular_price() ) * 100;

        } else {

            $max_percentage = 0;

            foreach ( $product->get_children() as $child_id ) {
                $variation = wc_get_product( $child_id );
                $price = $variation->get_regular_price();
                $sale = $variation->get_sale_price();
                if ( $price != 0 && ! empty( $sale ) ) {
                    $percentage = ( $price - $sale ) / $price * 100;
                }
                if ( $percentage > $max_percentage ) {
                    $max_percentage = $percentage;
                }
            }

        }

        echo "<span class='onsale d-inline-block bg-danger font-size-ms text-white rounded-sm py-1 px-2 mb-3'>-" . round($max_percentage) . "%</span>";

    }

}

if ( ! function_exists( 'cartzilla_wc_marketplace_single_product_before' ) ) {
    function cartzilla_wc_marketplace_single_product_before() { ?>
       <aside class="col-lg-4"><div class="cz-sidebar-static h-100 ml-auto border-left"><?php
    }
}

if ( ! function_exists( 'cartzilla_wc_marketplace_single_product_after' ) ) {
    function cartzilla_wc_marketplace_single_product_after() { ?>
        </div></aside><?php
    }
}


if ( ! function_exists( 'cartzilla_mp_product_details_before' ) ) {
    function cartzilla_mp_product_details_before() { ?>
        <div class="product-summary bg-light box-shadow-lg rounded-lg overflow-hidden mb-3"><div class="row"><?php
    }
}

if ( ! function_exists( 'cartzilla_mp_product_details_after' ) ) {
    function cartzilla_mp_product_details_after() { ?>
        </div></div><?php
    }
}

if ( ! function_exists( 'cartzilla_mp_product_left_column_wrap_open' ) ) {
    function cartzilla_mp_product_left_column_wrap_open() { ?>
        <section class="col-lg-8 pt-2 pt-lg-4 pb-4 mb-lg-3"><div class="pt-2 px-4 pr-lg-0 pl-xl-5 cz-gallery"><?php
    }
}

if ( ! function_exists( 'cartzilla_mp_product_left_column_wrap_close' ) ) {
    function cartzilla_mp_product_left_column_wrap_close() { ?>
       </div></section><?php
    }
}

if ( ! function_exists( 'cartzilla_marketplace_wishlist' ) ) {
    function cartzilla_marketplace_wishlist() { 
        // Add the link "Add to wishlist"
        $position = get_option( 'yith_wcwl_button_position', 'add-to-cart' );

        ?>
        <div class="py-2 mr-2">
            <?php if( function_exists( 'cartzilla_add_to_wishlist_button' ) && $position === 'shortcode' ) {
                cartzilla_add_to_wishlist_button();
            } ?>
        </div><?php
    }
}

if ( ! function_exists( 'cartzilla_marketplace_wishlist_share_wrap_open' ) ) {
    function cartzilla_marketplace_wishlist_share_wrap_open() { 
        if( function_exists( 'cartzilla_add_to_wishlist_button' ) || function_exists( 'cartzilla_display_jetpack_shares' ) ) { ?>
            <div class="d-flex flex-wrap justify-content-between align-items-center border-top pt-3"><?php 
        }
    }
}

if ( ! function_exists( 'cartzilla_marketplace_wishlist_share_wrap_close' ) ) {
    function cartzilla_marketplace_wishlist_share_wrap_close() { 
        if( function_exists( 'cartzilla_add_to_wishlist_button' ) || function_exists( 'cartzilla_display_jetpack_shares' ) ) { ?>
            </div><?php 
        }
    }
}

if( ! function_exists( 'cartzilla_product_sold_count' ) ) {
    function cartzilla_product_sold_count() {
    global $product;
       $units_sold = $product->get_total_sales();
       if ( $units_sold > 0 ) {
        ?>
            <div class="bg-secondary rounded p-3 mb-2">
                <?php echo apply_filters( 'cartzilla_sold_count_icon_icon', '<i class="czi-download h5 text-muted align-middle mb-0 mt-n1 mr-2"></i>' ); ?>
                <span class="d-inline-block h6 mb-0 mr-1"><?php echo esc_attr( $units_sold ); ?></span><span class="font-size-sm"><?php echo esc_html( sprintf( _nx( 'Sale', 'Sales', $units_sold, 'front-end', 'cartzilla' ), $units_sold ) ); ?></span>
           </div><?php
        }
    }
}

if( ! function_exists( 'cartzilla_dokan_product_author_info' ) ) {
    function cartzilla_dokan_product_author_info( $user_id = null ) {
        if( cartzilla_is_dokan_activated()): 
            if ( ! $user_id ) {
                $user_id = get_post_field( 'post_author', get_the_id() );
            }

            $user_data = get_userdata( $user_id );
            $store_info = dokan_get_store_info( $user_id );
            $storename = isset( $store_info['store_name'] ) && ! empty( $store_info['store_name'] ) ? $store_info['store_name'] : ( is_object( $user_data ) ? $user_data->display_name : '' );
            $gravatar_url = get_avatar_url( $user_id );

            if( ! empty( $storename ) ) :
                ?>
                <div class="bg-secondary rounded p-3 mb-2">
                    <a class="media align-items-center" href="<?php echo esc_url( dokan_get_store_url( $user_id ) ); ?>">
                        <img class="rounded-circle" width="50" src="<?php echo esc_url( $gravatar_url ); ?>" alt="<?php echo esc_attr( $storename ); ?>">
                        <div class="media-body pl-2">
                            <span class="font-size-ms text-muted"><?php echo esc_html__('Created by', 'cartzilla');?></span>
                            <h6 class="font-size-sm mb-0"><?php echo esc_attr( $storename ); ?></h6>
                        </div>
                    </a>
                </div>
                <?php
            endif;
        endif;
    }
}

if( ! function_exists( 'cartzilla_single_product_star_rating' ) ) {
    function cartzilla_single_product_star_rating() {
        global $product;
        $product_id     = $product->get_id();
        $review_count   = $product->get_review_count();
        $avg_rating     = number_format( $product->get_average_rating(), 1 );

        if ( wc_review_ratings_enabled() && $review_count > 0 ) : ?>
            <div class="bg-secondary rounded p-3 mb-2">
                <?php echo wc_get_rating_html( $product->get_average_rating() ); // WordPress.XSS.EscapeOutput.OutputNotEscaped. ?>
                 <span class="font-size-ms ml-2"><?php echo sprintf( esc_html_x( '%s / 5', 'front-end', 'cartzilla'), esc_html( $avg_rating ) );?></span>
                 <div class="font-size-ms text-muted"><?php echo esc_html( sprintf( _n( 'based on %s review', 'based on %s reviews', $review_count, 'cartzilla' ), $review_count ) ); ?></div>
             </div>
        <?php endif; 
    }
}

if( ! function_exists( 'cartzilla_wc_single_product_list' ) ) {
    function cartzilla_wc_single_product_list() { 
        ?>
        <ul class="list-unstyled font-size-sm product-meta-items">
            <?php do_action( 'cartzilla_product_meta' ); ?>
        </ul><?php

    }
}

if( ! function_exists( 'cartzilla_wc_product_publish_date' ) ) {
    function cartzilla_wc_product_publish_date() { 
    global $product;

    ?>
    <li class="d-flex justify-content-between mb-3 pb-3 border-bottom">
    <span class="text-dark font-weight-medium"><?php echo esc_html__('Released', 'cartzilla'); ?></span>
    <span class="text-muted"><?php echo get_the_date('F j, Y', $product->get_id());?></span></li><?php

    }
}

if( ! function_exists( 'cartzilla_wc_product_category_list' ) ) {
    function cartzilla_wc_product_category_list() { 
    global $product; 
    if ( count( $product->get_category_ids()) > 0 ): ?>

    <li class="d-flex justify-content-between mb-3 pb-3 border-bottom">
        <span class="text-dark font-weight-medium"><?php echo esc_html( sprintf( _nx( 'Category', 'Categories', count( $product->get_category_ids()), 'front-end', 'cartzilla' ), count( $product->get_category_ids()) ) ); ?></span>
        <span class="text-muted"><?php echo wc_get_product_category_list( $product->get_id() ); ?></span>
    </li><?php
    endif;

    }
}

if( ! function_exists( 'cartzilla_wc_product_tag_list' ) ) {
    function cartzilla_wc_product_tag_list() { 
    global $product; 
    if ( count( $product->get_tag_ids()) > 0 ):
    ?>

        <li class="d-flex justify-content-between mb-3 pb-3 border-bottom">
            <span class="text-dark font-weight-medium"><?php echo esc_html( sprintf( _nx( 'Tag', 'Tags', count( $product->get_tag_ids()), 'front-end', 'cartzilla' ), count( $product->get_tag_ids()) ) ); ?></span>
            <span class="text-muted"><?php echo wc_get_product_tag_list( $product->get_id() ); ?></span>

        </li><?php
    endif;

    }
}

if( ! function_exists( 'cartzilla_wc_product_attributes' ) ) {
    function cartzilla_wc_product_attributes() { 
        global $product;?>
        <li class="product-attribute"><?php echo wc_display_product_attributes( $product );?></li><?php
    }
}

if( ! function_exists( 'cartzilla_wc_product_modified_date' ) ) {
    function cartzilla_wc_product_modified_date() { 
        global $product;?>
        <li class="d-flex justify-content-between mb-3 pb-3 border-bottom">
            <span class="text-dark font-weight-medium"><?php echo esc_html__('Last update', 'cartzilla'); ?></span>
            <span class="text-muted"><?php echo wp_kses_post( $product->get_date_modified()->date('F j, Y') ); ?></span>
        </li><?php
    }
}

if( ! function_exists( 'cartzilla_gallery_image_size' ) ) {
    function cartzilla_gallery_image_size( $image_size ) { 
        $image_size = 'woocommerce_single';
        return $image_size;
        
    }
}

if ( ! function_exists( 'cartzilla_output_related_products_args' ) ) {
    function cartzilla_output_related_products_args( $args ) {

        if ( cartzilla_get_single_product_style() === 'style-v4' ){
            $columns = 5;
        } else {
            $columns = 4;
        }

        $args = array(
            'posts_per_page' => 8,
            'columns'        => apply_filters( 'cartzilla_related_products_columns', $columns )
        );
        return $args;
    }
}

if ( ! function_exists( 'cartzilla_wc_grocery_product_container_open' ) ) {
    function cartzilla_wc_grocery_product_container_open() { ?>

        <div class="container-fluid p-0"><div class="px-lg-3 pt-4"><div class="px-3 pt-2"><?php
    }
}

if ( ! function_exists( 'cartzilla_wc_grocery_product_container_close' ) ) {
    function cartzilla_wc_grocery_product_container_close() { ?>

        </div></div></div><?php
    }
}


if ( ! function_exists( 'cartzilla_toggle_before_single_product_hooks' ) ) {
    function cartzilla_toggle_before_single_product_hooks() {
        $style = cartzilla_get_single_product_style();
        if ( 'style-v4' === $style ) { 
            remove_action( 'woocommerce_before_single_product',                        'cartzilla_wc_product_title',            6 );
        } else {
            add_action( 'woocommerce_before_single_product',                        'cartzilla_wc_product_title',            6 );

        }

    }
}

if ( ! function_exists( 'cartzilla_wc_grocery_product_breadcrumb' ) ) {
    function cartzilla_wc_grocery_product_breadcrumb() { ?>

        <div class="mb-4">
            <?php cartzilla_breadcrumbs(); ?>
        </div><?php
    }
}

if ( ! function_exists( 'cartzilla_wc_grocery_product_wrap_open' ) ) {
    function cartzilla_wc_grocery_product_wrap_open() { ?>
        <section class="row no-gutters mx-n2 pb-5 mb-xl-3"><?php
    }
}

if ( ! function_exists( 'cartzilla_wc_grocery_product_wrap_close' ) ) {
    function cartzilla_wc_grocery_product_wrap_close() { ?>
        </section><?php
    }
}

if ( ! function_exists( 'cartzilla_wc_grocery_product_images_wrap_open' ) ) {
    function cartzilla_wc_grocery_product_images_wrap_open() { ?>
        <div class="col-xl-7 px-2 mb-3"><div class="h-100 bg-light rounded-lg p-4"><div class="cz-product-gallery"><?php
    }
}

if ( ! function_exists( 'cartzilla_wc_grocery_product_images_wrap_close' ) ) {
    function cartzilla_wc_grocery_product_images_wrap_close() { ?>
        </div></div></div><?php
    }
}

if ( ! function_exists( 'cartzilla_wc_grocery_product_summary_wrap_open' ) ) {
    function cartzilla_wc_grocery_product_summary_wrap_open() { ?>
        <div class="col-xl-5 px-2 mb-3"><div class="h-100 bg-light rounded-lg py-5 px-4 px-sm-5"><?php
    }
}


if ( ! function_exists( 'cartzilla_wc_grocery_product_summary_wrap_close' ) ) {
    function cartzilla_wc_grocery_product_summary_wrap_close() { ?>
        </div></div><?php
    }
}

if ( ! function_exists( 'cartzilla_grocery_product_title' ) ) {
    function cartzilla_grocery_product_title() {

        if ( ! (bool) apply_filters( 'cartzilla_is_grocery_product_title', true ) ) {
            return;
        }

        ?>
        
         <h1 class="h2"><?php single_post_title(); ?></h1><?php
    }
}

/**
 * Outputs product category(ies) in the product loop
 *
 * @since 1.0.0
 */
if ( ! function_exists( 'cartzilla_grocery_loop_product_category' ) ) {
    function cartzilla_grocery_loop_product_category() {
        global $product;

        $taxonomy = 'product_cat';
        $terms    = get_the_terms( $product->get_id(), $taxonomy );
        if ( empty( $terms ) || is_wp_error( $terms ) ) {
            return;
        }

        $links = [];
        foreach ( $terms as $term ) {
            $link = get_term_link( $term, $taxonomy );
            if ( is_wp_error( $link ) ) {
                continue;
            }

            $links[] = sprintf( '<a href="%s" class="d-inline-block product-meta font-size-sm pb-2" rel="tag">%s</a>',
                esc_url( $link ),
                esc_html( $term->name )
            );
        }


        echo apply_filters( 'cartzilla_template_loop_categories_html', wp_kses_post( sprintf( '<span class="woocommerce-loop-product__categories">%s</span>', implode( '<span class="text-muted">,</span> ', $links  ) ) ));
    }
}



if ( ! function_exists( 'cartzilla_grocery_product_add_to_cart_wrap' ) ) {
    function cartzilla_grocery_product_add_to_cart_wrap() { 
        $position = get_option( 'yith_wcwl_button_position', 'add-to-cart' ); ?>
        <div class="form-group d-flex flex-wrap align-items-center pt-1 pb-3 add-to-cart-wrap">
            <?php woocommerce_template_single_add_to_cart(); ?>
            <?php if( function_exists( 'cartzilla_add_to_wishlist_button' ) && $position === 'shortcode' ) { ?>
                <div class="wishlist-icon">
                    <?php cartzilla_add_to_wishlist_button(); ?>
                </div>
            <?php  } ?>
            
        </div><?php
    }
}

if ( ! function_exists( 'cartzilla_grocery_product_description' ) ) {
    function cartzilla_grocery_product_description() { ?>
        <div class="product-description mb-4">
            <?php the_content(); ?>
        </div>
        <?php
    }
}


if ( ! function_exists( 'cartzilla_toggle_single_product_hooks' ) ) {
    function cartzilla_toggle_single_product_hooks() {
        $style = cartzilla_get_single_product_style();
        if ( 'style-v4' === $style ) { 
            remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30 );

            add_action( 'woocommerce_before_single_product_summary',                'cartzilla_wc_grocery_product_container_open',   10 );
            add_action( 'woocommerce_before_single_product_summary',                'cartzilla_wc_grocery_product_breadcrumb',   20 );
            add_action( 'woocommerce_before_single_product_summary',                'cartzilla_wc_grocery_product_wrap_open',   30 );
            add_action( 'woocommerce_before_single_product_summary',                'cartzilla_wc_grocery_product_images_wrap_open',   40 );
            add_action( 'woocommerce_before_single_product_summary',                'woocommerce_show_product_images',   50 );
            add_action( 'woocommerce_before_single_product_summary',                'cartzilla_wc_grocery_product_images_wrap_close',   60 );

            add_action( 'woocommerce_before_single_product_summary',                'cartzilla_wc_grocery_product_summary_wrap_open',   70 );

            add_action( 'woocommerce_single_product_summary',                       'cartzilla_grocery_loop_product_category',   5 );
            add_action( 'woocommerce_single_product_summary',                       'cartzilla_grocery_product_title',   10 );
            add_action( 'woocommerce_single_product_summary',                       'cartzilla_wc_product_price_labels',   15 );
            add_action( 'woocommerce_single_product_summary',                       'cartzilla_grocery_product_add_to_cart_wrap',   20 );
            add_action( 'woocommerce_single_product_summary',                       'cartzilla_wc_product_additoinal_buttons_inline',   25 );
            add_action( 'woocommerce_single_product_summary',                       'cartzilla_grocery_product_description',   30 );
            add_action( 'woocommerce_single_product_summary',                       'cartzilla_wc_grocery_product_summary_wrap_close',   100 );

            add_action( 'woocommerce_after_single_product_summary',                'cartzilla_wc_grocery_product_wrap_close',   150 );
            add_action( 'woocommerce_after_single_product_summary',                 'cartzilla_wc_grocery_product_container_close',200 );
        } elseif ( 'style-v3' === $style ) { 
            add_filter( 'woocommerce_gallery_thumbnail_size',                       'cartzilla_gallery_image_size' ,         10);
            add_action( 'woocommerce_before_single_product_summary',                'cartzilla_wc_product_container_open',   10 );
            add_action( 'woocommerce_before_single_product_summary',                'cartzilla_mp_product_details_before',         15 );
            add_action( 'woocommerce_before_single_product_summary',                'cartzilla_mp_product_left_column_wrap_open',         20 );
            add_action( 'woocommerce_before_single_product_summary',                'woocommerce_show_product_images',         30 );
            add_action( 'woocommerce_before_single_product_summary',                'cartzilla_marketplace_wishlist_share_wrap_open',         40 );
            add_action( 'woocommerce_before_single_product_summary',                'cartzilla_marketplace_wishlist',         50 );

            add_action( 'woocommerce_before_single_product_summary',                'cartzilla_shares',         55 );
            add_action( 'woocommerce_before_single_product_summary',                'cartzilla_marketplace_wishlist_share_wrap_close',         60 );
            add_action( 'woocommerce_before_single_product_summary',                'cartzilla_mp_product_left_column_wrap_close',         70 );
            add_action( 'woocommerce_before_single_product_summary',                'cartzilla_wc_marketplace_single_product_before',   80 );
            add_action( 'woocommerce_single_product_summary',                       'cartzilla_wc_product_price_labels',    20 );
            add_action( 'woocommerce_single_product_summary',                       'cartzilla_wc_product_additoinal_buttons',    45 );
            add_action( 'woocommerce_single_product_summary',                       'cartzilla_dokan_product_author_info',    50 );
            add_action( 'woocommerce_single_product_summary',                       'cartzilla_product_sold_count',    60 );
            add_action( 'woocommerce_single_product_summary',                       'cartzilla_single_product_star_rating',    70 );
            add_action( 'woocommerce_single_product_summary',                       'cartzilla_wc_single_product_list',         80 ); 
            add_action( 'woocommerce_after_single_product_summary',                 'cartzilla_wc_marketplace_single_product_after',   10 );
            add_action( 'woocommerce_after_single_product_summary',                 'cartzilla_mp_product_details_after',         20 );
            add_action( 'woocommerce_after_single_product_summary',                 'cartzilla_wc_product_container_close',30 );
            add_action( 'woocommerce_after_single_product_summary',                 'cartzilla_wc_product_container_open',   40 );

            add_action( 'woocommerce_after_single_product_summary',                 'woocommerce_output_product_data_tabs',         50 );
            add_action( 'woocommerce_after_single_product_summary',                 'cartzilla_wc_product_container_close',60 );

            add_action( 'cartzilla_product_meta',                                    'cartzilla_wc_product_modified_date',         10 );
            add_action( 'cartzilla_product_meta',                                    'cartzilla_wc_product_publish_date',         20 );
            add_action( 'cartzilla_product_meta',                                    'cartzilla_wc_product_category_list',        30 );
            add_action( 'cartzilla_product_meta',                                    'cartzilla_wc_product_tag_list',             40 );
            add_action( 'cartzilla_product_meta',                                    'cartzilla_wc_product_attributes',           50 );

            /**
             * Reviews
             */
            remove_action( 'woocommerce_review_before',                             'woocommerce_review_display_gravatar',  10 );
            remove_action( 'woocommerce_review_before_comment_meta',                'woocommerce_review_display_rating',    10 );
            remove_action( 'woocommerce_review_meta',                               'woocommerce_review_display_meta',      10 );
            remove_action( 'woocommerce_review_comment_text',                       'woocommerce_review_display_comment_text',10 );
            add_action( 'cartzilla_single_product_reviews_before',                  'cartzilla_wc_reviews_overall' );
            add_action( 'woocommerce_review_before_comment_text',                   'cartzilla_wc_review_before' );
            add_action( 'woocommerce_review_comment_text',                          'cartzilla_wc_review' );
            
            
            ?><?php
            
        } elseif ( 'style-v2' === $style ) { 
            remove_action( 'woocommerce_review_before',                             'woocommerce_review_display_gravatar',  10 );
            remove_action( 'woocommerce_review_before_comment_meta',                'woocommerce_review_display_rating',    10 );
            remove_action( 'woocommerce_review_meta',                               'woocommerce_review_display_meta',      10 );
            remove_action( 'woocommerce_review_comment_text',                       'woocommerce_review_display_comment_text',10 );
            remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30 );
            remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_sharing', 50 );

            add_action( 'woocommerce_before_single_product_summary',                 'cartzilla_wc_product_container_open',   10 );
            add_action( 'woocommerce_after_single_product_summary',                  'cartzilla_wc_product_tabs_wrap_open', 5 );
            add_action( 'woocommerce_after_single_product_summary',                  'woocommerce_output_product_data_tabs', 10 );

            add_filter( 'woocommerce_product_tabs',                                  'cartzilla_wc_product_tabs',           20 );
            add_action( 'woocommerce_product_tabs_before_content',                   'cartzilla_wc_product_tab_before_content' );

            add_action( 'cartzilla_info_tab_before_single_product_summary',          'cartzilla_row_wrap_open',        10 );
            add_action( 'cartzilla_info_tab_before_single_product_summary',          'cartzilla_wc_product_images',         20 );
            add_action( 'cartzilla_info_tab_before_single_product_summary',          'cartzilla_wc_product_summary_before', 30 );

            add_action( 'cartzilla_info_tab_single_product_summary',                 'cartzilla_wc_product_price_labels',    20 );
            add_action( 'cartzilla_info_tab_single_product_summary',                 'woocommerce_template_single_add_to_cart',    40 );
            add_action( 'cartzilla_info_tab_single_product_summary',                 'cartzilla_wc_product_wishlist_compare',    50 );
            add_action( 'cartzilla_info_tab_single_product_summary',                 'cartzilla_wc_product_additoinal_buttons', 55 );
            add_action( 'cartzilla_info_tab_single_product_summary',                 'cartzilla_wc_product_excerpt',          60 );
            add_action( 'cartzilla_info_tab_single_product_summary',                 'woocommerce_template_single_meta',      65 );
            add_action( 'cartzilla_info_tab_single_product_summary',                 'cartzilla_shares',                     70 );

            add_action( 'cartzilla_info_tab_after_single_product_summary',            'cartzilla_wc_product_summary_after',   10 );
            add_action( 'cartzilla_info_tab_after_single_product_summary',            'cartzilla_row_wrap_close',        30 );

            add_action( 'cartzilla_single_product_reviews_before',                  'cartzilla_wc_reviews_overall' );
            add_action( 'woocommerce_review_before_comment_text',                   'cartzilla_wc_review_before' );
            add_action( 'woocommerce_review_comment_text',                          'cartzilla_wc_review' );

            add_action( 'woocommerce_after_single_product_summary',                 'cartzilla_wc_product_tabs_wrap_close',    15 );

            add_action( 'woocommerce_after_single_product_summary',                 'cartzilla_wc_product_container_close',16 );
            add_action( 'woocommerce_after_single_product_summary',                 'cartzilla_wc_product_description',    220 );

            add_action( 'woocommerce_after_single_product_summary',                 'cartzilla_wc_product_accssories',   270 ); 
          
            
        } else {
            add_action( 'woocommerce_before_single_product_summary',                'cartzilla_wc_product_container_open',   10 );
            add_action( 'woocommerce_after_single_product_summary',                 'cartzilla_wc_product_container_close',200 );
            add_action( 'woocommerce_before_single_product_summary',                'cartzilla_wc_product_details_before', 100 );
            add_action( 'woocommerce_before_single_product_summary',                'cartzilla_wc_product_images',         120 );
            add_action( 'woocommerce_before_single_product_summary',                'cartzilla_wc_product_summary_before', 200 );
            
            add_action( 'woocommerce_single_product_summary',                       'cartzilla_wc_product_rating_wishlist', 10 );
            add_action( 'woocommerce_single_product_summary',                       'cartzilla_wc_product_price_labels',    20 );
            add_action( 'woocommerce_single_product_summary',                       'cartzilla_wc_product_additoinal_buttons', 35 );
            add_action( 'woocommerce_single_product_summary',                       'cartzilla_wc_product_excerpt',         40 );
            add_action( 'woocommerce_single_product_summary',                       'cartzilla_shares',                     50 );
            
            add_action( 'woocommerce_after_single_product_summary',                 'cartzilla_wc_product_summary_after',    0 );
            add_action( 'woocommerce_after_single_product_summary',                 'cartzilla_wc_product_details_after',  100 );
            add_action( 'woocommerce_after_single_product_summary',                 'cartzilla_wc_product_description',    220 );
            
            /**
             * Reviews
             */
            remove_action( 'woocommerce_review_before',                             'woocommerce_review_display_gravatar',  10 );
            remove_action( 'woocommerce_review_before_comment_meta',                'woocommerce_review_display_rating',    10 );
            remove_action( 'woocommerce_review_meta',                               'woocommerce_review_display_meta',      10 );
            remove_action( 'woocommerce_review_comment_text',                       'woocommerce_review_display_comment_text',10 );
            add_action( 'woocommerce_after_single_product_summary',                 'cartzilla_wc_reviews',                240 );
            add_action( 'cartzilla_single_product_reviews_before',                  'cartzilla_wc_reviews_overall' );
            add_action( 'woocommerce_review_before_comment_text',                   'cartzilla_wc_review_before' );
            add_action( 'woocommerce_review_comment_text',                          'cartzilla_wc_review' );

        }
    }
}

if ( ! function_exists( 'cartzilla_wc_product_additoinal_buttons' ) ) {
    function cartzilla_wc_product_additoinal_buttons() {
        $product_id = get_the_ID();
        $product    = wc_get_product( $product_id );

        if ( ! $product instanceof WC_Product ) {
            return;
        }

        $custom_fields = cartzilla_general_product_data_custom_button_meta_args();
        uasort( $custom_fields, 'cartzilla_sort_priority_callback' );

        ob_start();
        if( ! empty ( $custom_fields ) ) {
            foreach ( $custom_fields as $key => $custom_field ) {
                $data = $product->get_meta( '_' . $key );
                $button_text = ! empty( $data['button_text'] ) ? $data['button_text'] : '';
                $button_url = ! empty( $data['button_url'] ) ? $data['button_url'] : '';
                $new_tab = ! empty( $data['new_tab'] ) ? $data['new_tab'] : 'no';

                if( ! empty( $button_text ) && ! empty( $button_url ) ) {
                    ?><a href="<?php echo esc_url( $button_url ); ?>" class="btn btn-block btn-outline-accent"<?php if( $new_tab === 'yes' ) echo esc_attr( ' target="_blank"' ); ?>><?php
                        echo wp_kses_post( $button_text );
                    ?></a><?php
                }
            }
        }
        $output = ob_get_clean();
        if( ! empty( $output ) ) {
            echo '<div class="product-additional-buttons mb-4">' . print_r( $output, true ) . '</div>';
        }
    }
}

if ( ! function_exists( 'cartzilla_wc_product_additoinal_buttons_inline' ) ) {
    function cartzilla_wc_product_additoinal_buttons_inline() {
        $product_id = get_the_ID();
        $product    = wc_get_product( $product_id );

        if ( ! $product instanceof WC_Product ) {
            return;
        }

        $custom_fields = cartzilla_general_product_data_custom_button_meta_args();
        uasort( $custom_fields, 'cartzilla_sort_priority_callback' );

        ob_start();
        if( ! empty ( $custom_fields ) ) {
            foreach ( $custom_fields as $key => $custom_field ) {
                $data = $product->get_meta( '_' . $key );
                $button_text = ! empty( $data['button_text'] ) ? $data['button_text'] : '';
                $button_url = ! empty( $data['button_url'] ) ? $data['button_url'] : '';
                $new_tab = ! empty( $data['new_tab'] ) ? $data['new_tab'] : 'no';

                if( ! empty( $button_text ) && ! empty( $button_url ) ) {
                    ?><a href="<?php echo esc_url( $button_url ); ?>" class="btn btn-outline-accent mb-2 mr-2"<?php if( $new_tab === 'yes' ) echo esc_attr( ' target="_blank"' ); ?>><?php
                        echo wp_kses_post( $button_text );
                    ?></a><?php
                }
            }
        }
        $output = ob_get_clean();
        if( ! empty( $output ) ) {
            echo '<div class="product-additional-buttons mb-4">' . print_r( $output, true ) . '</div>';
        }
    }
}
