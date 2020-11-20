<?php
/**
 * WooCommerce template functions
 *
 * Typically functions used in templates or hooked {@see wc-template-hooks.php}
 *
 * @package Cartzilla
 */

if ( ! function_exists( 'cartzilla_get_shop_page_style' ) ) {
    function cartzilla_get_shop_page_style() {

        $product_style = get_theme_mod( 'shop_page_style', 'style-v1' );
    
        return sanitize_key( apply_filters( 'cartzilla_shop_page_style', $product_style ) );
    }
}


if ( ! function_exists( 'cartzilla_remove_loop_start_subcatgories' ) ) {
    function cartzilla_remove_loop_start_subcatgories( $loop_html = '' ) {
        ob_start();

        wc_set_loop_prop( 'loop', 0 );

        wc_get_template( 'loop/loop-start.php' );

        return ob_get_clean();
    }
}

if ( ! function_exists( 'cartzilla_wc_maybe_show_product_subcategories' ) ) {
    function cartzilla_wc_maybe_show_product_subcategories() {
        wc_set_loop_prop( 'loop', 0 );
        $product_cat_columns = apply_filters( 'cartzilla_product_cat_columns', 3 );
        $product_columns     = absint( max( 1, wc_get_loop_prop( 'columns', wc_get_default_products_per_row() ) ) );
        wc_set_loop_prop( 'columns', $product_cat_columns );
        $wc_sub_categories = woocommerce_maybe_show_product_subcategories( '' );
        wc_set_loop_prop( 'columns', $product_columns );
        if ( ! empty( $wc_sub_categories ) ) {
            ?><section class="section-product-categories">
                <div class="d-none">
                    <h2 class="section-title h3 mb-0"><?php echo sprintf( esc_html__( '%s Categories', 'cartzilla' ), woocommerce_page_title( false ) ); ?></h2>
                </div>

                <ul class="list-unstyled loop-product-categories row columns-<?php echo esc_attr( $product_cat_columns ); ?>"><?php echo wp_kses_post(  $wc_sub_categories ); ?></ul></section><?php
        }
    }
}

if ( ! function_exists( 'cartzilla_enable_cz_filters' ) ) {
    function cartzilla_enable_cz_filters() {
        return apply_filters( 'cartzilla_enable_cz_filters', false );
    }
}

if ( ! function_exists( 'cartzilla_get_shop_catalog_mode' ) ) {
    /**
     * Shop Catelog Mode
     * 
     * @return bool
     */
    function cartzilla_get_shop_catalog_mode() {
        return apply_filters( 'cartzilla_shop_catalog_mode', false );
    }
}



/**
 * Outputs the sale badge
 *
 * @since 1.0.0
 */
if ( ! function_exists( 'cartzilla_wc_loop_product_sale_flash' ) ) {
    function cartzilla_wc_loop_product_sale_flash() {
        global $post, $product;

        if ( ! $product->is_on_sale() ) {
            return;
        }

        echo apply_filters( 'woocommerce_sale_flash', '<span class="badge badge-danger badge-shadow">' . esc_html__( 'Sale', 'cartzilla' ) . '</span>', $post, $product );
    }
}

/**
 * Outputs the "Add to wishlist" button in product tile
 *
 * @since 1.0.0
 */
if ( ! function_exists( 'cartzilla_wc_loop_product_add_to_wishlist' ) ) {
    function cartzilla_wc_loop_product_add_to_wishlist() {
        // check if Add to wishlist button is enabled for loop
        $enabled_on_loop = 'yes' == get_option( 'yith_wcwl_show_on_loop', 'no' );
        // Add the link "Add to wishlist"
        $position = get_option( 'yith_wcwl_loop_position', 'after_add_to_cart' );

        if( $enabled_on_loop && $position === 'shortcode' ){ 
            cartzilla_add_to_wishlist();
        }
    }
}

if ( ! function_exists( 'cartzilla_wc_loop_product_compare' ) ) {
    function cartzilla_wc_loop_product_compare() {
        if( cartzilla_is_yith_woocompare_activated() ) { 
            cartzilla_add_to_compare_link(); 
        }
    }
}

/**
 * Outputs product category(ies) in the product loop
 *
 * @since 1.0.0
 */
if ( ! function_exists( 'cartzilla_wc_loop_product_category' ) ) {
    function cartzilla_wc_loop_product_category() {
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

            $links[] = sprintf( '<a href="%s" class="d-inline-block product-meta font-size-xs pb-1" rel="tag">%s</a>',
                esc_url( $link ),
                esc_html( $term->name )
            );
        }


        echo apply_filters( 'cartzilla_template_loop_categories_html', wp_kses_post( sprintf( '<span class="woocommerce-loop-product__categories">%s</span>', implode( '<span class="text-muted">,</span> ', $links  ) ) ));
    }
}

/**
 * Show the product title in the product loop
 *
 * @since 1.0.0
 */
if ( ! function_exists( 'cartzilla_wc_loop_product_title' ) ) {
    function cartzilla_wc_loop_product_title() {
        global $product;

        $is_list = false !== strpos( cartzilla_wc_products_layout(), 'list' );
        $class   = [
            'woocommerce-loop-product__title',
            'product-title',
            cartzilla_wc_view_current() === 'list' ? 'font-size-base' : 'font-size-sm',
        ];

        $class = apply_filters( 'woocommerce_product_loop_title_classes', cartzilla_get_classes( $class ) );
        $link  = apply_filters( 'woocommerce_loop_product_link', get_the_permalink(), $product );

        echo sprintf( '<h3 class="%3$s"><a href="%2$s">%1$s</a></h3>', // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
            get_the_title(),
            esc_url( $link ),
            esc_attr( $class )
        );
    }
}

/**
 * Outputs product price and rating in the product loop
 *
 * @since 1.0.0
 */
if ( ! function_exists( 'cartzilla_wc_loop_product_price_rating' ) ) {
    function cartzilla_wc_loop_product_price_rating() {
        global $product;
        ?>
        <div class="d-flex justify-content-between">
            <?php if ( $price_html = $product->get_price_html() ) : ?>
                <div class="product-price">
                    <span class="text-accent"><?php echo wp_kses_post( $price_html ); ?></span>
                </div>
            <?php endif;?>
            <?php if ( wc_review_ratings_enabled() ) : ?>
                <?php echo wc_get_rating_html( $product->get_average_rating() ); // WordPress.XSS.EscapeOutput.OutputNotEscaped. ?>
            <?php endif; ?>
        </div>
        <?php

    }
}

if ( ! function_exists( 'cartzilla_decimal_price' ) ) {
    function cartzilla_decimal_price( $formatted_price, $price, $decimal_places, $decimal_separator, $thousand_separator ) {
        $_formatted_price = explode( $decimal_separator, $formatted_price );
        $formatted_price = $_formatted_price[0];
        if( isset( $_formatted_price[1] ) ) {
            $formatted_price .= $decimal_separator . '<small>' . $_formatted_price[1] . '</small>';
        }

        return $formatted_price;
    }
}

if ( ! function_exists( 'cartzilla_wc_format_sale_price' ) ) {
    function cartzilla_wc_format_sale_price( $price, $regular_price, $sale_price ) {
        $price = '<ins>' . ( is_numeric( $sale_price ) ? wc_price( $sale_price ) : $sale_price ) . '</ins> <del class="font-size-sm text-muted">' . ( is_numeric( $regular_price ) ? wc_price( $regular_price ) : $regular_price ) . '</del>';
        return $price;
    }
}

if ( ! function_exists( 'cartzilla_wc_loop_product_add_to_cart_args' ) ) {
    function cartzilla_wc_loop_product_add_to_cart_args( $args, $product ) {
        $args['class'] = cartzilla_get_classes( [
            'btn',
            $product->is_purchasable() && $product->is_in_stock() ? 'btn-primary' : 'btn-secondary',
            'btn-sm',
            cartzilla_wc_view_current() === 'grid' ? 'btn-block' : '',// add .btn-block for grid tiles
            'mb-2',
            cartzilla_get_shop_page_style() !== 'style-v3' ? '' : 'btn-shadow',
            isset( $args['class'] ) ? $args['class'] : '',
        ] );

        // Custom attributes
        if ( ! isset( $args['attributes'] ) ) {
            $args['attributes'] = [];
        }

        $args['attributes']['data-toggle'] = 'toast';
        $args['attributes']['data-target'] = '#cart-toast';

        return $args;
    }
}

if ( ! function_exists( 'cartzilla_wc_loop_product_v2_add_to_cart_args' ) ) {
    function cartzilla_wc_loop_product_v2_add_to_cart_args( $args, $product ) {
        $args['class'] = str_replace( 'btn-primary', 'btn-light', $args['class'] );
        $args['class'] = str_replace( 'btn-secondary', 'btn-light', $args['class'] );
        $args['class'] = str_replace( 'btn-sm', 'btn-icon btn-shadow', $args['class'] );
        $args['class'] = str_replace( 'mb-2', 'mx-2', $args['class'] );
        $args['class'] = str_replace( 'btn-block', '', $args['class'] );
        return $args;
    }
}



/**
 * Add arguments to "Add to cart" button in the product loop
 *
 * @param array $args "Add to cart" arguments
 * @param WC_Product $product Product object
 *
 * @return array
 *
 * @since 1.0.0
 */
if ( ! function_exists( 'cartzilla_mp_loop_product_add_to_cart_args' ) ) {
    function cartzilla_mp_loop_product_add_to_cart_args( $args, $product ) {
        // Custom classes
        $args['class'] = cartzilla_get_classes( [
            'btn',
            $product->is_purchasable() && $product->is_in_stock() ? 'btn-light' : 'btn-secondary',
            'btn-icon btn-shadow font-size-base mx-2',
            isset( $args['class'] ) ? $args['class'] : '',
        ] );

        // Custom attributes
        if ( ! isset( $args['attributes'] ) ) {
            $args['attributes'] = [];
        }

        $args['attributes']['data-toggle'] = 'toast';
        $args['attributes']['data-target'] = '#cart-toast';

        return $args;
    }
}

if ( ! function_exists( 'cartzilla_wc_loop_product_add_to_cart_link' ) ) {
    function cartzilla_wc_loop_product_add_to_cart_link( $a, $product ) {
        $additional_icon_class=" font-size-sm mr-1";

        if ( $product->is_purchasable() && $product->is_in_stock() ) {
            if ( $product instanceof WC_Product_Variable ) {
                $icon = '<i class="czi-filter-alt'. $additional_icon_class . '"></i>';
            } elseif ( $product instanceof  WC_Product_Grouped ) {
                $icon = '<i class="czi-bag'. $additional_icon_class . '"></i>';
            } else {
                $icon = '<i class="czi-cart'. $additional_icon_class . '"></i>';
            }

            return preg_replace( '/<a(.*?)>(.*)<\/a>/i', '<a$1>' . $icon . '$2</a>', $a, 1);
        }

        return $a;
    }
}

if ( ! function_exists( 'cartzilla_wc_loop_product_v2_add_to_cart_link' ) ) {
    function cartzilla_wc_loop_product_v2_add_to_cart_link( $a, $product ) {
        $a = str_replace( 'font-size-sm mr-1', 'font-size-base', $a );
        return $a;
    }
}

if ( ! function_exists( 'cartzilla_wc_loop_product_v3_add_to_cart_link' ) ) {
    function cartzilla_wc_loop_product_v3_add_to_cart_link( $a, $product ) {
        $a = str_replace( 'font-size-sm mr-1', 'font-size-base ml-1', $a );
        $a = str_replace( 'mb-2', 'mb-0', $a );
        $a = str_replace( '<i class="', '+<i class="', $a );
        return $a;
    }
}

if ( ! function_exists( 'cartzilla_grocery_add_to_cart_text' ) ) {
    function cartzilla_grocery_add_to_cart_text() {
        return false;
    }
}

/**
 * Display the prev / next buttons to navigate through products list.
 *
 * Light version.
 *
 * @since 1.0.0
 */
if ( ! function_exists( 'cartzilla_wc_products_navigation_light' ) ) {
    function cartzilla_wc_products_navigation_light() {
        if ( wc_get_loop_prop( 'is_paginated' ) && woocommerce_products_will_display() ) :
            $total   = (int) wc_get_loop_prop( 'total_pages' );
            $current = (int) wc_get_loop_prop( 'current_page' );

            if ( $current && 1 < $current ) : ?>
                <a class="nav-link-style nav-link-light mr-3" href="<?php echo get_pagenum_link( $current - 1 ); ?>">
                    <i class="czi-arrow-left"></i>
                </a>
            <?php endif; ?>
            <span class="font-size-md text-light"><?php echo esc_html( "{$current} / {$total}" ); ?></span>
            <?php if ( $current && $current < $total ) : ?>
                <a class="nav-link-style nav-link-light ml-3" href="<?php echo get_pagenum_link( $current + 1 ); ?>">
                    <i class="czi-arrow-right"></i>
                </a>
            <?php endif;
            unset( $total, $current );
        endif;
    }
}

/**
 * Display the prev / next buttons to navigate through products list.
 *
 * Dark version.
 *
 * @since 1.0.0
 */
if ( ! function_exists( 'cartzilla_wc_products_navigation_dark' ) ) {
    function cartzilla_wc_products_navigation_dark() {
        if ( wc_get_loop_prop( 'is_paginated' ) && woocommerce_products_will_display() ) :
            $total   = (int) wc_get_loop_prop( 'total_pages' );
            $current = (int) wc_get_loop_prop( 'current_page' );

            if ( $current && 1 < $current ) : ?>
                <a class="nav-link-style mr-3" href="<?php echo get_pagenum_link( $current - 1 ); ?>">
                    <i class="czi-arrow-left"></i>
                </a>
            <?php endif; ?>
            <span class="font-size-md"><?php echo esc_html( "{$current} / {$total}" ); ?></span>
            <?php if ( $current && $current < $total ) : ?>
                <a class="nav-link-style ml-3" href="<?php echo get_pagenum_link( $current + 1 ); ?>">
                    <i class="czi-arrow-right"></i>
                </a>
            <?php endif;
            unset( $total, $current );
        endif;
    }
}

/**
 * Display the view switcher. Light version.
 *
 * @since 1.0.0
 */
if ( ! function_exists( 'cartzilla_wc_products_views_light' ) ) {
    function cartzilla_wc_products_views_light() {
        if ( 'subcategories' !== woocommerce_get_loop_display_mode() ) {
            $current_view = cartzilla_wc_view_current();
            $views        = cartzilla_wc_views();

            foreach ( $views as $view => $content ) {
                echo sprintf( '<a class="btn btn-icon nav-link-style ml-2 %3$s" href="%1$s">%2$s</a>',
                    esc_url( add_query_arg( 'view', rawurlencode( $view ), false ) ),
                    wp_kses_post( $content ),
                    $view === $current_view ? 'bg-light text-dark disabled opacity-100' : 'nav-link-light'

                );
            }
        }
    }
}

/**
 * Display the view switcher. Dark version.
 *
 * @since 1.0.0
 */
if ( ! function_exists( 'cartzilla_wc_products_views_dark' ) ) {
    function cartzilla_wc_products_views_dark() {
        if ( 'subcategories' !== woocommerce_get_loop_display_mode() ) {
            $current_view = cartzilla_wc_view_current();
            $views        = cartzilla_wc_views();

            foreach ( $views as $view => $content ) {
                echo sprintf( '<a class="btn btn-icon nav-link-style ml-2 %3$s" href="%1$s">%2$s</a>',
                    esc_url( add_query_arg( 'view', rawurlencode( $view ), false ) ),
                    wp_kses_post( $content ),
                    $view === $current_view ? 'bg-primary text-light disabled opacity-100' : ''
                );
            }
        }
    }
}

/**
 * Outputs a paginated navigation to next/previous set of products, when applicable
 *
 * @hooked woocommerce_after_shop_loop 100
 *
 * @since 1.0.0
 */
if ( ! function_exists( 'cartzilla_wc_products_pagination' ) ) {
    function cartzilla_wc_products_pagination() {
        if ( ! wc_get_loop_prop( 'is_paginated' ) || ! woocommerce_products_will_display() ) {
            return;
        }

        $total   = (int) wc_get_loop_prop( 'total_pages' );
        $current = (int) wc_get_loop_prop( 'current_page' );
        $base    = esc_url_raw( add_query_arg( 'product-page', '%#%', false ) );
        $format  = '?product-page=%#%';

        if ( ! wc_get_loop_prop( 'is_shortcode' ) ) {
            $format = '';
            $base   = esc_url_raw( str_replace( 999999999, '%#%', remove_query_arg( 'add-to-cart', get_pagenum_link( 999999999, false ) ) ) );
        }

        if ( $total <= 1 ) {
            return;
        }

        $links = paginate_links( apply_filters( 'woocommerce_pagination_args', array( // WPCS: XSS ok.
            'base'      => $base,
            'format'    => $format,
            'add_args'  => false,
            'current'   => max( 1, $current ),
            'total'     => $total,
            'prev_next' => false,
            'type'      => 'array',
            'end_size'  => 3,
            'mid_size'  => 3,
        ) ) );

        ?>
        <nav class="d-flex justify-content-between pt-2 cartzilla-shop-pagination w-100" aria-label="<?php
        /* translators: aria-label for products navigation wrapper */
        echo esc_attr_x( 'Page navigation', 'front-end', 'cartzilla' ); ?>">
            <ul class="pagination">
                <?php if ( $current && 1 < $current ) : ?>
                    <li class="page-item">
                        <a class="page-link" href="<?php echo get_pagenum_link( $current - 1 ); ?>">
                            <i class="czi-arrow-left mr-2"></i><?php
                            /* translators: label for previous products link */
                            echo esc_html_x( 'Prev', 'front-end', 'cartzilla' ); ?>
                        </a>
                    </li>
                <?php endif; ?>
            </ul>
            <ul class="pagination">
                <li class="page-item d-sm-none">
                    <span class="page-link page-link-static"><?php echo esc_html( "{$current} / {$total}" ); ?></span>
                </li>
                <?php foreach( $links as $link ) : ?>
                    <?php if ( false !== strpos( $link, 'current' ) ) : ?>
                        <li class="page-item active d-none d-sm-block">
                            <?php echo str_replace( 'page-numbers', 'page-link', $link ); ?>
                        </li>
                    <?php else : ?>
                        <li class="page-item d-none d-sm-block">
                            <?php echo str_replace( 'page-numbers', 'page-link', $link ); ?>
                        </li>
                    <?php endif; ?>
                <?php endforeach; ?>
            </ul>
            <ul class="pagination">
                <?php if ( $current && $current < $total ) : ?>
                    <li class="page-item">
                        <a class="page-link" href="<?php echo get_pagenum_link( $current + 1 ); ?>"><?php
                            /* translators: label for next products link */
                            echo esc_html_x( 'Next', 'front-end', 'cartzilla' ); ?>
                            <i class="czi-arrow-right ml-2"></i>
                        </a>
                    </li>
                <?php endif; ?>
            </ul>
        </nav>
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
if ( ! function_exists( 'cartzilla_wc_reviews' ) ) {
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
if ( ! function_exists( 'cartzilla_wc_reviews_overall' ) ) {
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
                <span class="d-inline-block align-middle ml-sm-2"><?php
                    /* translators: 1: average rating */
                    echo sprintf( esc_html_x( '%s overall rating', 'front-end', 'cartzilla'), esc_html( $avg_rating ) );
                ?></span>
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
if ( ! function_exists( 'cartzilla_wc_review_before' ) ) {
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
                            <i class="czi-check-circle ml-2 mt-n1 font-size-base align-middle text-success" data-toggle="tooltip" title="<?php echo esc_attr__( 'verified owner', 'cartzilla' ); ?>"></i>
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
if ( ! function_exists( 'cartzilla_wc_review' ) ) {
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

/**
 * Returns the available views where key is a view name and value is a view icon
 *
 * Theme support grid and list view modes.
 *
 * @return array
 *
 * @since 1.0.0
 */
if ( ! function_exists( 'cartzilla_wc_views' ) ) {
    function cartzilla_wc_views() {
        return (array) apply_filters( 'cartzilla_wc_views', [
            'grid' => '<i class="czi-view-grid"></i>',
            'list' => '<i class="czi-view-list"></i>',
        ] );
    }
}

/**
 * Returns the current view mode
 *
 * @return string
 *
 * @since 1.0.0
 */
if ( ! function_exists( 'cartzilla_wc_view_current' ) ) {
    function cartzilla_wc_view_current() {
        if ( ! empty( $_GET['view'] ) ) {
            $current = $_GET['view'];
        } elseif ( ! empty( $_COOKIE[ CARTZILLA_WC_VIEW_COOKIE ] ) ) {
            $current = $_COOKIE[ CARTZILLA_WC_VIEW_COOKIE ];
        } else {
            $current = get_theme_mod( 'cartzilla_catalog_layout', 'grid' );
        }

        return (string) apply_filters( 'cartzilla_wc_view_current', sanitize_key( $current ) );
    }
}

/**
 * Save current view in a cookie if set.
 *
 * @since 1.0.0
 */
if ( ! function_exists( 'cartzilla_wc_view_set' ) ) {
    function cartzilla_wc_view_set() {
        if ( empty( $_GET['view'] ) ) {
            return;
        }

        $current_view = sanitize_key( $_GET['view'] );

        if ( isset( $_COOKIE[ CARTZILLA_WC_VIEW_COOKIE ] ) && $current_view === $_COOKIE[ CARTZILLA_WC_VIEW_COOKIE ] ) {
            return;
        }

        setcookie( CARTZILLA_WC_VIEW_COOKIE, $current_view, 3 * DAY_IN_SECONDS, COOKIEPATH, COOKIE_DOMAIN );
    }
}

/**
 * Modify the layout based on user's view.
 *
 * @param string $layout
 *
 * @return string
 *
 * @since 1.0.0
 */
if ( ! function_exists( 'cartzilla_wc_view_layout' ) ) {
    function cartzilla_wc_view_layout( $layout ) {
        $current_view = cartzilla_wc_view_current();
        list( $view, $sidebar ) = explode( '-', $layout );
        if ( $view !== $current_view ) {
            $layout = "{$current_view}-{$sidebar}";
        }

        return $layout;
    }
}

/**
 * Display the Page Title inside My Account
 *
 * @since 1.0.0
 */
if ( ! function_exists( 'cartzilla_wc_account_title' ) ) {
    function cartzilla_wc_account_title() {
        global $wp;

        $endpoints = wc_get_account_menu_items();
        $title     = esc_html_x( 'My Account', 'front-end', 'cartzilla' );
        foreach ( $endpoints as $endpoint => $label ) {
            if ( isset( $wp->query_vars[ $endpoint ] ) ) {
                $title = $label;
            } elseif ( isset( $wp->query_vars['view-order'] ) ) {
                $order_id = $wp->query_vars['view-order'];
                $order = wc_get_order( $order_id );

                if ( $order && current_user_can( 'view_order', $order_id ) ) {
                    /* translators: 1: order number */
                    $title = sprintf( esc_html_x( 'Order #%s', 'front-end', 'cartzilla' ), $order->get_order_number() );
                } else {
                    $title = esc_html_x( 'View order', 'front-end', 'cartzilla' );
                }
                break;
            } elseif ( isset( $wp->query_vars['page'] ) || empty( $wp->query_vars ) ) {
                // Dashboard is not an endpoint, so needs a custom check.
                $title = esc_html_x( 'Dashboard', 'front-end', 'cartzilla' );
                break;
            }
        }

        echo apply_filters( 'cartzilla_wc_account_title', $title );
    }
}

/**
 * Outputs the number of active orders
 *
 * By active we mean the orders with statuses "pending", "processing", "on hold", "failed".
 *
 * TODO: maybe add caching?
 *
 * @since 1.0.0
 */
if ( ! function_exists( 'cartzilla_wc_account_orders_count' ) ) {
    function cartzilla_wc_account_orders_count() {
        $orders = wc_get_orders( apply_filters( 'cartzilla_wc_account_orders_count_args', [
            'status'   => [ 'pending', 'processing', 'on-hold', 'failed' ],
            'customer' => get_current_user_id(),
            'return'   => 'ids',
            'limit'    => - 1,
            'paginate' => false,
        ] ) );

        echo count( $orders );
    }
}

/**
 * Outputs the number of available downloads
 *
 * TODO: maybe add caching?
 *
 * @since 1.0.0
 */
if ( ! function_exists( 'cartzilla_wc_account_downloads_count' ) ) {
    function cartzilla_wc_account_downloads_count() {
        $downloads = WC()->customer->get_downloadable_products();
        echo count( $downloads );
    }
}

/**
 * Add sidebar toggle to the toolbar for shop pages
 *
 * This toggle should be present only on shop pages and only for layouts with sidebar.
 *
 * @since 1.0.0
 */
if ( ! function_exists( 'cartzilla_wc_handheld_toolbar_toggle_shop_sidebar' ) ) {
    function cartzilla_wc_handheld_toolbar_toggle_shop_sidebar() {

        $_cz_is_filters_active = cartzilla_is_active_sidebars( [
            'shop-filters-column-1',
            'shop-filters-column-2',
            'shop-filters-column-3',
        ] );


        if ( ( is_shop() || is_product_taxonomy() ) && !( $_cz_is_filters_active && cartzilla_enable_cz_filters() ) && ( get_theme_mod( 'shop_sidebar', 'no-sidebar' ) != 'no-sidebar' ) ) : ?>
            <a href="#shop-sidebar" data-toggle="sidebar" class="d-table-cell cz-handheld-toolbar-item">
                <span class="cz-handheld-toolbar-icon">
                    <i class="czi-filter-alt"></i>
                </span>
                <span class="cz-handheld-toolbar-label"><?php echo esc_html_x( 'Filters', 'front-end', 'cartzilla' ); ?></span>
            </a>
        <?php
        endif;
    }
}

/**
 * Add cart toggle (actually link to cart) to the toolbar
 *
 * @since 1.0.0
 */
if ( ! function_exists( 'cartzilla_wc_handheld_toolbar_toggle_cart' ) ) {
    function cartzilla_wc_handheld_toolbar_toggle_cart() {
        ?>
        <a href="<?php echo esc_url( wc_get_cart_url() ); ?>" class="d-table-cell cz-handheld-toolbar-item cz-handheld-toolbar-cart">
            <span class="cz-handheld-toolbar-icon">
                <i class="czi-cart"></i>
                <span class="badge badge-primary badge-pill"><?php echo absint( is_a( WC()->cart, 'WC_Cart' ) ? WC()->cart->get_cart_contents_count() : 0 ); ?></span>
            </span>
            <?php if( is_a( WC()->cart, 'WC_Cart' ) ) : ?>
                <span class="cz-handheld-toolbar-label"><?php echo strip_tags( WC()->cart->get_cart_subtotal() ); ?></span>
            <?php endif; ?>
        </a>
        <?php
    }
}


/**
 * Outputs the modal login form for checkout page.
 *
 * Modal should be as high as possible in DOM, that's why attached to "wp_body_open" action.
 *
 * @since 1.0.0
 */
if ( ! function_exists( 'cartzilla_wc_modal_in_checkout' ) ) {
    function cartzilla_wc_modal_in_checkout() {
        if ( ! is_checkout() || is_user_logged_in() || 'no' === get_option( 'woocommerce_enable_checkout_login_reminder' ) ) {
            return;
        }

        ?>
        <div class="modal fade" tabindex="-1" role="dialog" id="cz-checkout-login">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title"><?php echo esc_html_x( 'Login to your account', 'front-end', 'cartzilla' ); ?></h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="<?php echo esc_html_x( 'Close', 'front-end', 'cartzilla' ); ?>">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <?php
                        woocommerce_login_form( [
                            'message'  => esc_html__( 'If you have shopped with us before, please enter your details below. If you are a new customer, please proceed to the Billing section.', 'cartzilla' ),
                            'redirect' => wc_get_checkout_url(),
                            'hidden'   => false,
                        ] );
                        ?>
                    </div>
                </div>
            </div>
        </div>
        <?php
    }
}

if ( ! function_exists( 'cartzilla_shop_view_content_wrapper_open' ) ) {
    function cartzilla_shop_view_content_wrapper_open() {
        $current_view = cartzilla_wc_view_current();
        if ( $current_view === 'grid') {
            $additional_class = 'grid-view';
        } else {
            $additional_class = 'list-view';
        }
        ?><div class="<?php echo esc_attr( $additional_class ); ?>"><?php
    }
}

if ( ! function_exists( 'cartzilla_shop_view_content_wrapper_close' ) ) {
    function cartzilla_shop_view_content_wrapper_close() {
        ?></div><?php
    }
}

if ( ! function_exists( 'cartzilla_wc_loop_product_grid_view_wrap_open' ) ) {
    function cartzilla_wc_loop_product_grid_view_wrap_open() {
        ?><div class="cartzilla-product-grid"><div class="card product-card"><?php
    }
}

if ( ! function_exists( 'cartzilla_wc_loop_product_grid_view_wrap_close' ) ) {
    function cartzilla_wc_loop_product_grid_view_wrap_close() {
        ?></div>
        <hr class="d-sm-none">
        </div><?php
    }
}

if ( ! function_exists( 'cartzilla_wc_loop_product_grid_view_thumbnail_wrap_open' ) ) {
    function cartzilla_wc_loop_product_grid_view_thumbnail_wrap_open() {
        global $product;
        ?><a class="card-img-top d-block overflow-hidden" href="<?php echo esc_url( apply_filters( 'woocommerce_loop_product_link', get_the_permalink(), $product ) ); ?>"><?php
    }
}

if ( ! function_exists( 'cartzilla_wc_loop_product_grid_view_thumbnail_wrap_close' ) ) {
    function cartzilla_wc_loop_product_grid_view_thumbnail_wrap_close() {
        ?></a><?php
    }
}

if ( ! function_exists( 'cartzilla_wc_loop_product_body_content_wrap_open' ) ) {
    function cartzilla_wc_loop_product_body_content_wrap_open() {
        ?><div class="card-body py-2"><?php
    }
}

if ( ! function_exists( 'cartzilla_wc_loop_product_body_content_wrap_close' ) ) {
    function cartzilla_wc_loop_product_body_content_wrap_close() {
        ?></div><?php
    }
}

if ( ! function_exists( 'cartzilla_wc_loop_product_hidden_body_content_wrap_open' ) ) {
    function cartzilla_wc_loop_product_hidden_body_content_wrap_open() {
        ?><div class="card-body card-body-hidden"><?php
    }
}

if ( ! function_exists( 'cartzilla_wc_loop_product_hidden_body_content_wrap_close' ) ) {
    function cartzilla_wc_loop_product_hidden_body_content_wrap_close() {
        ?></div><?php
    }
}

if ( ! function_exists( 'cartzilla_wc_loop_product_list_view_wrap_open' ) ) {
    function cartzilla_wc_loop_product_list_view_wrap_open() {
        ?><div class="cartzilla-product-list"><div class="card product-card product-list"><?php
    }
}


if ( ! function_exists( 'cartzilla_wc_loop_product_list_view_wrap_close' ) ) {
    function cartzilla_wc_loop_product_list_view_wrap_close() {
        ?></div>
        <hr class="pt-3 mt-3">
        </div><?php
    }
}

if ( ! function_exists( 'cartzilla_wc_loop_product_list_view_inner_wrap_open' ) ) {
    function cartzilla_wc_loop_product_list_view_inner_wrap_open() {
        ?><div class="d-sm-flex align-items-center"><?php
    }
}

if ( ! function_exists( 'cartzilla_wc_loop_product_list_view_inner_wrap_close' ) ) {
    function cartzilla_wc_loop_product_list_view_inner_wrap_close() {
        ?></div><?php
    }
}

if ( ! function_exists( 'cartzilla_wc_loop_product_list_view_thumbnail_wrap_open' ) ) {
    function cartzilla_wc_loop_product_list_view_thumbnail_wrap_open() {
        global $product;
        ?><a class="product-list-thumb" href="<?php echo esc_url( apply_filters( 'woocommerce_loop_product_link', get_the_permalink(), $product ) ); ?>"><?php
    }
}

if ( ! function_exists( 'cartzilla_wc_loop_product_list_view_thumbnail_wrap_close' ) ) {
    function cartzilla_wc_loop_product_list_view_thumbnail_wrap_close() {
        ?></a><?php
    }
}

if ( ! function_exists( 'cartzilla_wc_catalog_orderby' ) ) {
    function cartzilla_wc_catalog_orderby( $options ) {
        $options = array(
            'popularity' => esc_html__( 'Popularity', 'cartzilla' ),
            'price'      => esc_html__( 'Low - High Price', 'cartzilla' ),
            'price-desc' => esc_html__( 'High - Low Price', 'cartzilla' ),
            'rating'     => esc_html__( 'Average Rating', 'cartzilla' ),
            'title-asc'  => esc_html__( 'A - Z Order', 'cartzilla' ),
            'title-desc' => esc_html__( 'Z - A Order', 'cartzilla' ),
           
        );
        return $options;
    }
}

if ( ! function_exists( 'cartzilla_mp_catalog_orderby' ) ) {
    function cartzilla_mp_catalog_orderby( $options ) {
        $options = array(
            'date'       => esc_html__( 'Newest', 'cartzilla' ),
            'popularity' => esc_html__( 'Bestsellers', 'cartzilla' ),
            'rating'     => esc_html__( 'Popular', 'cartzilla' ),
            'price'      => esc_html__( 'Low Price', 'cartzilla' ),
            'price-desc' => esc_html__( 'High Price', 'cartzilla' ),
           
        );
        return $options;
    }
}

if ( ! function_exists( 'cartzilla_shop_control_bar' ) ) {
    function cartzilla_shop_control_bar() {

        if ( ! woocommerce_products_will_display()) {
            return;
        }

        $shop_sidebar = cartzilla_wc_products_sidebar();

        $_cz_is_filters_active = cartzilla_is_active_sidebars( [
            'shop-filters-column-1',
            'shop-filters-column-2',
            'shop-filters-column-3',
        ] );

        if ( !( $_cz_is_filters_active && cartzilla_enable_cz_filters() ) ) : ?>
            <div class="d-flex justify-content-center justify-content-sm-between align-items-center pt-2 pt-lg-2 pb-4 pb-lg-5 mb-2 mb-lg-0">
                <div class="d-flex flex-wrap">
                    <div class="form-inline flex-nowrap mr-3 mr-sm-4 pb-3">
                        <?php woocommerce_catalog_ordering(); ?>
                    </div>
                </div>
                <div class="d-flex pb-3">
                    <?php if ( cartzilla_wc_catalog_type() === 'dark' ) {
                            cartzilla_wc_products_navigation_light();
                        } else {
                            cartzilla_wc_products_navigation_dark();
                        }
                    ?>
                </div>
                <div class="d-none d-sm-flex pb-3">
                    <?php if ( cartzilla_wc_catalog_type() === 'dark' ) {
                            cartzilla_wc_products_views_light();
                        } else {
                            cartzilla_wc_products_views_dark();
                        }
                    ?>
                </div>
            </div>
        <?php endif; 
    }
}


if ( ! function_exists( 'cartzilla_wc_catalog_ordering' ) ) {
    function cartzilla_wc_catalog_ordering() {
        ob_start();
        woocommerce_catalog_ordering();
        $wc_catalog_ordering = ob_get_clean();
        if ( ! empty( $wc_catalog_ordering ) ) : ?>
        <div class="form-inline flex-nowrap mr-3 mr-sm-4 pb-3">
       

            <label class="text-light opacity-75 text-nowrap mr-2 d-none d-sm-block"><?php echo sprintf( wp_kses_post( __( 'Sort by: %s', 'cartzilla' ) ), $wc_catalog_ordering ); ?></label>
        </div><?php
        endif;
    }    
}


if ( ! function_exists( 'cartzilla_quick_view_link' ) ) {
    function cartzilla_quick_view_link() {
        if( apply_filters( 'cartzilla_enable_shop_quick_view', true ) ) :
            ?>
            <a href="#quick-view" rel="nofollow" data-product_id="<?php echo esc_attr( get_the_ID() ); ?>" class="nav-link-style font-size-ms product_quick_view" data-toggle="modal" data-target="#quick-view">
                <?php echo apply_filters( 'cartzilla_shop_quick_view_icon', '<i class="czi-eye align-middle mr-1"></i>' ); ?>
                <?php echo apply_filters( 'cartzilla_shop_quick_view_text', esc_html__( 'Quick View', 'cartzilla')); ?>
            </a> <?php
        endif;
    }
}

if ( ! function_exists( 'cartzilla_quick_view_wrapper' ) ) {
    function cartzilla_quick_view_wrapper() {
        if( apply_filters( 'cartzilla_enable_shop_quick_view', TRUE ) ) :
            
            
            // Load Single Product Gallery Scripts
            $assets_path = str_replace( array( 'http:', 'https:' ), '', WC()->plugin_url() ) . '/assets/';
            $suffix      = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';
                wp_enqueue_script( 'wc-add-to-cart-variation' );
                wp_enqueue_script('tooltip');
                wp_enqueue_script( 'flexslider');
                wp_enqueue_script( 'wc-single-product');
            
            ?>
            <div class="quick-view-wrapper single-product style-v1">
                <div class="modal fade modal-quick-view" id="quick-view" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog modal-xl">
                        <div class="modal-content">
                            <div class="modal-body p-0">
                                <div id="modal-quick-view-ajax-content" class="cd-quick-view"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php
        endif;
    }
}

if ( ! function_exists( 'cartzilla_product_quick_view' ) ) {
    function cartzilla_product_quick_view() {
        if( isset( $_REQUEST['product_id'] ) ) {
            $product_id = $_REQUEST['product_id'];

            cartzilla_get_template( 'shop/product-quick-view.php', array( 'id' => $product_id ) );
        }
        die();
    }
}

function cartzilla_wc_widget_price_filter_step( $step ) {
    return 1;
}


add_action( 'wp_footer', 'cartzilla_quick_view_wrapper' );
add_action( 'wp_ajax_product_quick_view', 'cartzilla_product_quick_view');
add_action( 'wp_ajax_nopriv_product_quick_view', 'cartzilla_product_quick_view');


if ( ! function_exists( 'cartzilla_get_brands_taxonomy' ) ) {
    /**
     * Products Brand Taxonomy
     * 
     * @return string
     */
    function cartzilla_get_brands_taxonomy() {
        return apply_filters( 'cartzilla_product_brand_taxonomy', '' );
    }
}

/**
 * 
 * Shop Jumbotron
 * 
 */

if ( ! function_exists( 'cartzilla_shop_archive_header' ) ) {
    function cartzilla_shop_archive_header() {
        $static_block_id = '';
        $brands_taxonomy = cartzilla_get_brands_taxonomy();

        if( is_shop() ) {
            $static_block_id = apply_filters( 'cartzilla_shop_jumbotron_id', get_theme_mod( 'cartzilla_wc_jumbotron', '' ) ); 
        } else if ( is_product_category() || is_tax( $brands_taxonomy ) ) {
            $term               = get_term_by( 'slug', get_query_var('term'), get_query_var('taxonomy') );
            $term_id            = $term->term_id;
            $static_block_id    = get_term_meta( $term_id, 'static_block_id', true );
        }


        if( cartzilla_is_mas_static_content_activated() && ! empty( $static_block_id ) ) {

            $static_block = get_post( $static_block_id );
            $content = isset( $static_block->post_content ) ? $static_block->post_content : '';
            echo '<div class="archive-top-jumbotron">' . apply_filters( 'the_content', $content ) . '</div>';
        }
    }
}


if( ! function_exists( 'cartzilla_archive_middle_jumbotron' ) ) {
    function cartzilla_archive_middle_jumbotron() {
        $static_block_id = '';
        $brands_taxonomy = cartzilla_get_brands_taxonomy();

        if( is_shop() ) {
            $static_block_id = apply_filters( 'cartzilla_shop_middle_jumbotron_id', get_theme_mod( 'cartzilla_wc_middle_jumbotron', '' ) ); 
        } else if ( is_product_category() || is_tax( $brands_taxonomy ) ) {
            $term               = get_term_by( 'slug', get_query_var('term'), get_query_var('taxonomy') );
            $term_id            = $term->term_id;
            $static_block_id    = get_term_meta( $term_id, 'static_block_middle_id', true );
        }


        if( cartzilla_is_mas_static_content_activated() && ! empty( $static_block_id ) ) {

            $static_block = get_post( $static_block_id );
            $content = isset( $static_block->post_content ) ? $static_block->post_content : '';
            echo '<li class="archive-middle-jumbotron w-100">' . apply_filters( 'the_content', $content ) . '</li>';
        }
    }
}

/* Market Place - style v2 Functions*/

if( ! function_exists( 'cartzilla_mp_loop_product_wrap_open' ) ) {
    function cartzilla_mp_loop_product_wrap_open() {
        ?>
        <div class="card product-card-alt"><?php
    }
}

if( ! function_exists( 'cartzilla_mp_loop_product_wrap_close' ) ) {
    function cartzilla_mp_loop_product_wrap_close() {
        ?>
        </div><?php
    }
}

if( ! function_exists( 'cartzilla_mp_loop_product_thumbnail_wrap_open' ) ) {
    function cartzilla_mp_loop_product_thumbnail_wrap_open() {
        ?>
        <div class="product-thumb"><?php
    }
}

if( ! function_exists( 'cartzilla_mp_loop_product_thumbnail_wrap_close' ) ) {
    function cartzilla_mp_loop_product_thumbnail_wrap_close() {
        ?>
        </div><?php
    }
}

if( ! function_exists( 'cartzilla_mp_loop_product_card_action_wrap_open' ) ) {
    function cartzilla_mp_loop_product_card_action_wrap_open() {
        ?>
        <div class="product-card-actions"><?php
    }
}

if( ! function_exists( 'cartzilla_mp_loop_product_card_action_wrap_close' ) ) {
    function cartzilla_mp_loop_product_card_action_wrap_close() {
        ?>
        </div><?php
    }
}

if( ! function_exists( 'cartzilla_mp_quick_view_link' ) ) {
    function cartzilla_mp_quick_view_link() {
        global $product;
        if( apply_filters( 'cartzilla_enable_shop_quick_view', true ) ) :
            ?>
            <a href="<?php echo esc_url( apply_filters( 'woocommerce_loop_product_link', get_the_permalink(), $product ) ); ?>" class="btn btn-light btn-icon btn-shadow font-size-base mx-2" >
                <?php echo apply_filters( 'cartzilla_shop_quick_view_icon', '<i class="czi-eye"></i>' ); ?>
            </a> <?php
        endif;
    }
}

if( ! function_exists( 'cartzilla_mp_loop_product_thumb_overlay' ) ) {
    function cartzilla_mp_loop_product_thumb_overlay() {
        global $product;
        ?><a class="product-thumb-overlay" href="<?php echo esc_url( apply_filters( 'woocommerce_loop_product_link', get_the_permalink(), $product ) ); ?>"></a><?php
    }
}

if( ! function_exists( 'cartzilla_mp_loop_product_card_body_wrap_open' ) ) {
    function cartzilla_mp_loop_product_card_body_wrap_open() {
        ?>
        <div class="card-body"><?php
    }
}

if( ! function_exists( 'cartzilla_mp_loop_product_card_body_wrap_close' ) ) {
    function cartzilla_mp_loop_product_card_body_wrap_close() {
        ?>
        </div><?php
    }
}

if( ! function_exists( 'cartzilla_mp_loop_product_category_wishlist_wrap_open' ) ) {
    function cartzilla_mp_loop_product_category_wishlist_wrap_open() {
        ?>
        <div class="d-flex flex-wrap justify-content-between align-items-start pb-2 product-category-list"><?php
    }
}

if( ! function_exists( 'cartzilla_mp_loop_product_category_wishlist_wrap_close' ) ) {
    function cartzilla_mp_loop_product_category_wishlist_wrap_close() {
        ?>
        </div><?php
    }
}

if( ! function_exists( 'cartzilla_mp_loop_product_category' ) ) {
    function cartzilla_mp_loop_product_category() {
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

            $links[] = sprintf( '<a href="%s" class="product-meta font-weight-medium" rel="tag">%s</a>',
                esc_url( $link ),
                esc_html( $term->name )
            );
        }
        ?>
        <div class="text-muted font-size-xs mr-1">
            <?php cartzilla_dokan_product_author_name();?>
            <?php echo apply_filters( 'cartzilla_template_loop_categories_html', wp_kses_post( sprintf( '<span class="cartzilla-product-card-alt-categories">%s</span>', implode( '<span class="product-meta font-weight-medium">,</span> ', $links  ) ) )); ?>
        </div><?php

    }
}

if( ! function_exists( 'cartzilla_mp_loop_product_rating' ) ) {
    function cartzilla_mp_loop_product_rating() {
    global $product;
    if ( wc_review_ratings_enabled() ) : 
         echo wc_get_rating_html( $product->get_average_rating() ); // WordPress.XSS.EscapeOutput.OutputNotEscaped. 
     endif; 
    }
}

if( ! function_exists( 'cartzilla_mp_loop_product_price_wrap_open' ) ) {
    function cartzilla_mp_loop_product_price_wrap_open() {
        ?>
        <div class="d-flex flex-wrap justify-content-between align-items-center"><?php
    }
}

if( ! function_exists( 'cartzilla_mp_loop_product_price_wrap_close' ) ) {
    function cartzilla_mp_loop_product_price_wrap_close() {
        ?>
        </div><?php
    }
}

if( ! function_exists( 'cartzilla_mp_loop_product_price' ) ) {
    function cartzilla_mp_loop_product_price() {
        global $product;
        if ( $price_html = $product->get_price_html() ) : ?>
            <div class="bg-faded-accent text-accent rounded-sm py-1 px-2">
                <?php echo wp_kses_post( $price_html ); ?>
            </div>
        <?php endif;
 
    }
}

if( ! function_exists( 'cartzilla_markatplace_shop_control_bar' ) ) {
    function cartzilla_markatplace_shop_control_bar() {
        global $wp_query;
        if ( ! woocommerce_products_will_display()) {
            return;
        }
        ?><div class="bg-light box-shadow-lg rounded-lg mt-n5 mb-4">
            <div class="d-flex align-items-center pl-2">
                <div class="input-group-overlay">
                    <form role="search" method="get" class="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
                        <div class="input-group-overlay">
                            <div class="input-group-prepend-overlay">
                                <span class="input-group-text"><i class="czi-search"></i></span>
                            </div>
                            <input type="search" name="s" class="form-control prepended-form-control border-0 box-shadow-0" value="<?php echo get_search_query(); ?>" placeholder="<?php echo esc_html_x( 'Search in this category...', 'front-end', 'cartzilla' ); ?>">
                            <?php if ( is_product_category() ) { ?>
                                <input type="hidden" name="product_cat" value="<?php echo esc_attr($wp_query->get_queried_object()->slug);?>">
                            <?php } ?>
                            <input type="hidden" class="form-control" name="post_type" value="product">

                        </div>
                    </form>
                </div>
                <div class="d-flex align-items-center">
                    <?php woocommerce_catalog_ordering(); ?>
                </div>
                <div class="d-none d-md-flex align-items-center border-left pl-4">
                    <?php if ( wc_get_loop_prop( 'is_paginated' ) && woocommerce_products_will_display() ) :
                        $total   = (int) wc_get_loop_prop( 'total_pages' );
                        $current = (int) wc_get_loop_prop( 'current_page' ); ?>

                            <span class="font-size-md text-nowrap mr-4"><?php echo esc_html__( 'Pages', 'cartzilla' ); ?> <?php echo esc_html( "{$current} / {$total}" ); ?>
                            </span>
                            <?php if ( $current && 1 < $current ) { ?>
                                <a class="nav-link-style p-4 border-left" href="<?php echo get_pagenum_link( $current - 1 ); ?>"><span class="d-inline-block py-1">
                                        <i class="czi-arrow-left"></i>
                                </span></a>
                            <?php } else {  ?>
                                <span class="nav-link-style p-4 border-left"><span class="d-inline-block py-1">
                                        <i class="czi-arrow-left"></i>
                                </span></span>
                            <?php } ?>

                            <?php if ( $current && $current < $total ) { ?>
                                <a class="nav-link-style p-4 border-left" href="<?php echo get_pagenum_link( $current + 1 ); ?>"><span class="d-inline-block py-1">
                                        <i class="czi-arrow-right"></i>
                                    </span></a>
                            <?php } else {  ?>
                                <span class="nav-link-style p-4 border-left"><span class="d-inline-block py-1">
                                        <i class="czi-arrow-right"></i>
                                </span></span>
                            <?php } ?>
                        <?php unset( $total, $current );
                    endif; ?>
                </div>
            </div>
        </div><?php
    }
}

if( ! function_exists( 'cartzilla_markatplace_product_wrap_open' ) ) {
    function cartzilla_markatplace_product_wrap_open() {
        ?>
        <div class="marketplace-products"><?php
    }
}

if( ! function_exists( 'cartzilla_markatplace_product_wrap_close' ) ) {
    function cartzilla_markatplace_product_wrap_close() {
        ?>
        </div><?php
    }
}


if( ! function_exists( 'cartzilla_mp_loop_product_sold_count' ) ) {
    function cartzilla_mp_loop_product_sold_count() {
    global $product;
       $units_sold = $product->get_total_sales();
       if ( $units_sold > 0 ) {
        ?>
            <div class="font-size-sm mr-2">
                <?php echo apply_filters( 'cartzilla_sold_count_icon_icon', '<i class="czi-download text-muted mr-1"></i>' ); ?>
                <span class="font-size-xs"><?php echo esc_html( sprintf( _nx( '%s Sale', '%s Sales', $units_sold, 'front-end', 'cartzilla' ), $units_sold ) ); ?></span>
           </div><?php
        }
    }
}

if( ! function_exists( 'cartzilla_dokan_product_author_name' ) ) {
    function cartzilla_dokan_product_author_name( $user_id = null ) {
        if( cartzilla_is_dokan_activated() ) :
            if ( ! $user_id ) {
                $user_id = get_post_field( 'post_author', get_the_id() );
            }

            $user_data = get_userdata( $user_id );
            $store_info = dokan_get_store_info( $user_id );
            $storename = isset( $store_info['store_name'] ) && ! empty( $store_info['store_name'] ) ? $store_info['store_name'] : ( is_object( $user_data ) ? $user_data->display_name : '' );

            if( ! empty( $storename ) ) :
                ?>
                <span class="cartzilla-store-name">
                    <?php echo esc_html__('by', 'cartzilla'); ?>
                    <a class="product-meta font-weight-medium" href="<?php echo esc_url( dokan_get_store_url( $user_id ) ); ?>">
                        <?php echo esc_attr( $storename ); ?>
                    </a><?php echo esc_html__('in', 'cartzilla'); ?>
                </span>
                <?php
            endif;
        endif;
    }
}

/* Grocery - style v3 Functions*/

if( ! function_exists( 'cartzilla_grocery_catalog_wrap_open' ) ) {
    function cartzilla_grocery_catalog_wrap_open() {
        ?>
        <div class="px-3 pt-2"><?php
    }
}

if( ! function_exists( 'cartzilla_grocery_catalog_wrap_close' ) ) {
    function cartzilla_grocery_catalog_wrap_close() {
        ?>
        </div><?php
    }
}

if( ! function_exists( 'cartzilla_grocery_breadcrumb_wrap' ) ) {
    function cartzilla_grocery_breadcrumb_wrap() { ?>
        <div class="mb-4">
            <?php cartzilla_breadcrumbs(); ?>
        </div><?php
    }
}

if( ! function_exists( 'cartzilla_grocery_title_wrap' ) ) {
    function cartzilla_grocery_title_wrap() { ?>
        <section class="d-md-flex justify-content-between align-items-center mb-4 pb-2">
            <h1 class="h2 mb-3 mb-md-0 mr-3"><?php woocommerce_page_title(); ?></h1>
            <div class="d-flex align-items-center">
                <?php woocommerce_catalog_ordering(); ?>
            </div>
        </section><?php
    }
}


if ( ! function_exists( 'cartzilla_grocery_catalog_orderby' ) ) {
    function cartzilla_grocery_catalog_orderby( $options ) {
        $options = array(
            'popularity' => esc_html__( 'Popular', 'cartzilla' ),
            'price'      => esc_html__( 'Cheap', 'cartzilla' ),
            'price-desc' => esc_html__( 'Expensive', 'cartzilla' ),
           
        );
        return $options;
    }
}

if ( ! function_exists( 'cartzilla_grocery_product_wrap_open' ) ) {
    function cartzilla_grocery_product_wrap_open() { ?>
        <div class="grocery-products"><?php
        
    }
}

if ( ! function_exists( 'cartzilla_grocery_product_wrap_close' ) ) {
    function cartzilla_grocery_product_wrap_close() { ?>
        </div><?php
        
    }
}

if ( ! function_exists( 'cartzilla_grocery_product_inner_wrap_open' ) ) {
    function cartzilla_grocery_product_inner_wrap_open() { ?>
        <div class="card product-card card-static pb-3"><?php
        
    }
}

if ( ! function_exists( 'cartzilla_grocery_product_inner_wrap_close' ) ) {
    function cartzilla_grocery_product_inner_wrap_close() { ?>
        </div><?php
        
    }
}

if( ! function_exists( 'cartzilla_grocery_loop_product_price' ) ) {
    function cartzilla_grocery_loop_product_price() {
        global $product;
        if ( $price_html = $product->get_price_html() ) : ?>
            <div class="product-price">
                <span class="text-accent">
                    <?php echo wp_kses_post( $price_html ); ?>
                </span>
            </div>
        <?php endif;
 
    }
}

if( ! function_exists( 'cartzilla_grocery_product_floating_button_wrap_open' ) ) {
    function cartzilla_grocery_product_floating_button_wrap_open() { ?>
        <div class="product-floating-btn"><?php
    }
}

if( ! function_exists( 'cartzilla_grocery_product_floating_button_wrap_close' ) ) {
    function cartzilla_grocery_product_floating_button_wrap_close() { ?>
        </div><?php
    }
}

if( ! function_exists( 'cartzilla_wc_products_pagination_wrap_open' ) ) {
    function cartzilla_wc_products_pagination_wrap_open() { ?>
        <div class="pt-4 pb-5 mb-4 card-static-pagination"><?php
    }
}

if( ! function_exists( 'cartzilla_wc_products_pagination_wrap_close' ) ) {
    function cartzilla_wc_products_pagination_wrap_close() { ?>
        </div><?php
    }
}


if( ! function_exists( 'cartzilla_toggle_shop_loop_hooks' ) ) {
    function cartzilla_toggle_shop_loop_hooks() {
        $style = cartzilla_get_shop_page_style();

        if ( 'style-v3' === $style ) {
            remove_action( 'woocommerce_before_shop_loop',                 'cartzilla_shop_control_bar',             15 );
            remove_action( 'woocommerce_before_shop_loop',                 'cartzilla_shop_archive_header',          29 );
            remove_action( 'woocommerce_before_shop_loop',                 'cartzilla_shop_view_content_wrapper_open', 30 );
            remove_action( 'woocommerce_after_shop_loop',                  'cartzilla_shop_view_content_wrapper_close', 99 );

            add_filter( 'woocommerce_catalog_orderby',                     'cartzilla_grocery_catalog_orderby', 10 );

            add_action( 'woocommerce_before_shop_loop',                    'cartzilla_grocery_catalog_wrap_open',            15 );
            add_action( 'woocommerce_before_shop_loop',                    'cartzilla_grocery_breadcrumb_wrap',              20 );
            add_action( 'woocommerce_before_shop_loop',                    'cartzilla_grocery_title_wrap',                   30 );
            add_action( 'woocommerce_before_shop_loop',                    'cartzilla_grocery_product_wrap_open',            40 );
            add_action( 'woocommerce_after_shop_loop',                     'cartzilla_grocery_product_wrap_close',           10 );

            add_action( 'woocommerce_after_shop_loop',                     'cartzilla_grocery_catalog_wrap_close',           100 );

            add_filter( 'woocommerce_product_add_to_cart_text',            'cartzilla_grocery_add_to_cart_text' );
            add_action( 'woocommerce_after_shop_loop',                     'cartzilla_wc_products_pagination_wrap_open',      99 );
            add_action( 'woocommerce_after_shop_loop',                     'cartzilla_wc_products_pagination_wrap_close',     101);
            add_filter( 'woocommerce_loop_add_to_cart_link',               'cartzilla_wc_loop_product_v3_add_to_cart_link', 60, 2 );
            cartzilla_add_shop_loop_item_v3_hooks();
        } elseif ( 'style-v2' === $style ) { 
            remove_action( 'woocommerce_before_shop_loop',                 'cartzilla_shop_control_bar',             15 );
            remove_action( 'woocommerce_before_shop_loop',                 'cartzilla_shop_archive_header',          29 );
            remove_action( 'woocommerce_before_shop_loop',                 'cartzilla_shop_view_content_wrapper_open', 30 );
            remove_action( 'woocommerce_after_shop_loop',                  'cartzilla_shop_view_content_wrapper_close', 99 );
            
            add_action( 'woocommerce_before_shop_loop',                    'cartzilla_markatplace_shop_control_bar',             15 );
            add_action( 'woocommerce_before_shop_loop',                    'cartzilla_markatplace_product_wrap_open',            20 );
            add_action( 'woocommerce_after_shop_loop',                     'cartzilla_markatplace_product_wrap_close',           99 );

            add_filter( 'woocommerce_catalog_orderby',                     'cartzilla_mp_catalog_orderby', 10 );
            add_filter( 'woocommerce_loop_add_to_cart_args',               'cartzilla_wc_loop_product_v2_add_to_cart_args', 60, 2 );
            add_filter( 'woocommerce_loop_add_to_cart_link',               'cartzilla_wc_loop_product_v2_add_to_cart_link', 60, 2 );
            cartzilla_add_shop_loop_item_v2_hooks();
        } else {
            add_filter( 'woocommerce_catalog_orderby',                     'cartzilla_wc_catalog_orderby',                         10 );
            add_action( 'woocommerce_before_shop_loop',                    'cartzilla_shop_control_bar',             15 );
            add_action( 'woocommerce_before_shop_loop',                    'cartzilla_shop_archive_header',          29 );
            add_action( 'woocommerce_before_shop_loop',                    'cartzilla_shop_view_content_wrapper_open', 30 );
            add_action( 'woocommerce_after_shop_loop',                     'cartzilla_shop_view_content_wrapper_close', 99 );
        }
    }
}

if( ! function_exists( 'cartzilla_add_shop_loop_item_v3_hooks' ) ) {
    function cartzilla_add_shop_loop_item_v3_hooks() {
        remove_action( 'woocommerce_before_shop_loop_item',             'cartzilla_wc_loop_product_grid_view_wrap_open',         6 );
        remove_action( 'woocommerce_before_shop_loop_item',             'cartzilla_wc_loop_product_compare',            21 );
        remove_action( 'woocommerce_after_shop_loop_item_title',        'cartzilla_wc_loop_product_price_rating',                  10 );
        remove_action( 'woocommerce_after_shop_loop_item_title',        'cartzilla_wc_loop_product_hidden_body_content_wrap_open', 30 );
        remove_action( 'woocommerce_after_shop_loop_item_title',        'cartzilla_mas_wcvs_loop_variation', 40 );
        remove_action( 'woocommerce_after_shop_loop_item',              'cartzilla_mas_wcvs_loop_variation', 130 );
        remove_action( 'woocommerce_after_shop_loop_item_title',        'woocommerce_template_loop_add_to_cart',                   50 ); 
        remove_action( 'woocommerce_after_shop_loop_item_title',        'cartzilla_quick_view_link',                               60 ); 
        remove_action( 'woocommerce_after_shop_loop_item_title',        'cartzilla_wc_loop_product_hidden_body_content_wrap_close', 80 );

        remove_action( 'woocommerce_after_shop_loop_item',              'cartzilla_wc_loop_product_grid_view_wrap_close',           10 );
        remove_action( 'woocommerce_after_shop_loop_item',              'cartzilla_wc_loop_product_list_view_wrap_open',            20 );
        remove_action( 'woocommerce_after_shop_loop_item',              'cartzilla_wc_loop_product_add_to_wishlist',                30 );
        remove_action( 'woocommerce_after_shop_loop_item',              'cartzilla_wc_loop_product_list_view_inner_wrap_open',      40 );
        remove_action( 'woocommerce_after_shop_loop_item',              'cartzilla_wc_loop_product_list_view_thumbnail_wrap_open',  50 );
        remove_action( 'woocommerce_after_shop_loop_item',              'woocommerce_template_loop_product_thumbnail',              60 );
        remove_action( 'woocommerce_after_shop_loop_item',              'cartzilla_wc_loop_product_list_view_thumbnail_wrap_close', 70 );
        remove_action( 'woocommerce_after_shop_loop_item',              'cartzilla_wc_loop_product_body_content_wrap_open',         80 );
        remove_action( 'woocommerce_after_shop_loop_item',              'cartzilla_wc_loop_product_category',                       90 );
        remove_action( 'woocommerce_after_shop_loop_item',              'cartzilla_wc_loop_product_title',                         100 );
        remove_action( 'woocommerce_after_shop_loop_item',              'cartzilla_wc_loop_product_price_rating',                  110 );
        remove_action( 'woocommerce_after_shop_loop_item',              'cartzilla_wc_loop_product_hidden_body_content_wrap_open', 120 );
        remove_action( 'woocommerce_after_shop_loop_item',              'woocommerce_template_loop_add_to_cart',                   140 );
        remove_action( 'woocommerce_after_shop_loop_item',              'cartzilla_quick_view_link',                               145 ); 
        remove_action( 'woocommerce_after_shop_loop_item',              'cartzilla_wc_loop_product_hidden_body_content_wrap_close',150 );
        remove_action( 'woocommerce_after_shop_loop_item',              'cartzilla_wc_loop_product_body_content_wrap_close',       160 );
        remove_action( 'woocommerce_after_shop_loop_item',              'cartzilla_wc_loop_product_list_view_inner_wrap_close',    170 );
        remove_action( 'woocommerce_after_shop_loop_item',              'cartzilla_wc_loop_product_list_view_wrap_close',          200 );


        add_action( 'woocommerce_before_shop_loop_item',                'cartzilla_grocery_product_inner_wrap_open',                 6 );

        add_action( 'woocommerce_after_shop_loop_item_title',           'cartzilla_grocery_loop_product_price',                     10 );

        add_action( 'woocommerce_after_shop_loop_item_title',           'cartzilla_grocery_product_floating_button_wrap_open',       30 );
        add_action( 'woocommerce_after_shop_loop_item_title',           'woocommerce_template_loop_add_to_cart',                     40 );
        add_action( 'woocommerce_after_shop_loop_item_title',           'cartzilla_grocery_product_floating_button_wrap_close',      50 );

        add_action( 'woocommerce_after_shop_loop_item',                 'cartzilla_grocery_product_inner_wrap_close',               10 );
    }
}

if( ! function_exists( 'cartzilla_remove_shop_loop_item_v3_hooks' ) ) {
    function cartzilla_remove_shop_loop_item_v3_hooks() {
        add_action( 'woocommerce_before_shop_loop_item',            'cartzilla_wc_loop_product_grid_view_wrap_open',         6 );
        add_action( 'woocommerce_before_shop_loop_item',            'cartzilla_wc_loop_product_compare',            21 );
        add_action( 'woocommerce_after_shop_loop_item_title',       'cartzilla_wc_loop_product_price_rating',                  10 );
        add_action( 'woocommerce_after_shop_loop_item_title',       'cartzilla_wc_loop_product_hidden_body_content_wrap_open', 30 );
        add_action( 'woocommerce_after_shop_loop_item_title',       'cartzilla_mas_wcvs_loop_variation', 40 );
        add_action( 'woocommerce_after_shop_loop_item',             'cartzilla_mas_wcvs_loop_variation', 130 );
        add_action( 'woocommerce_after_shop_loop_item_title',       'woocommerce_template_loop_add_to_cart',                   50 ); 
        add_action( 'woocommerce_after_shop_loop_item_title',       'cartzilla_quick_view_link',                               60 ); 
        add_action( 'woocommerce_after_shop_loop_item_title',       'cartzilla_wc_loop_product_hidden_body_content_wrap_close', 80 );

        add_action( 'woocommerce_after_shop_loop_item',             'cartzilla_wc_loop_product_grid_view_wrap_close',           10 );
        add_action( 'woocommerce_after_shop_loop_item',             'cartzilla_wc_loop_product_list_view_wrap_open',            20 );
        add_action( 'woocommerce_after_shop_loop_item',             'cartzilla_wc_loop_product_add_to_wishlist',                30 );
        add_action( 'woocommerce_after_shop_loop_item',             'cartzilla_wc_loop_product_list_view_inner_wrap_open',      40 );
        add_action( 'woocommerce_after_shop_loop_item',             'cartzilla_wc_loop_product_list_view_thumbnail_wrap_open',  50 );
        add_action( 'woocommerce_after_shop_loop_item',             'woocommerce_template_loop_product_thumbnail',              60 );
        add_action( 'woocommerce_after_shop_loop_item',             'cartzilla_wc_loop_product_list_view_thumbnail_wrap_close', 70 );
        add_action( 'woocommerce_after_shop_loop_item',             'cartzilla_wc_loop_product_body_content_wrap_open',         80 );
        add_action( 'woocommerce_after_shop_loop_item',             'cartzilla_wc_loop_product_category',                       90 );
        add_action( 'woocommerce_after_shop_loop_item',             'cartzilla_wc_loop_product_title',                         100 );
        add_action( 'woocommerce_after_shop_loop_item',             'cartzilla_wc_loop_product_price_rating',                  110 );
        add_action( 'woocommerce_after_shop_loop_item',             'cartzilla_wc_loop_product_hidden_body_content_wrap_open', 120 );
        add_action( 'woocommerce_after_shop_loop_item',             'woocommerce_template_loop_add_to_cart',                   140 );
        add_action( 'woocommerce_after_shop_loop_item',             'cartzilla_quick_view_link',                               145 ); 
        add_action( 'woocommerce_after_shop_loop_item',             'cartzilla_wc_loop_product_hidden_body_content_wrap_close',150 );
        add_action( 'woocommerce_after_shop_loop_item',             'cartzilla_wc_loop_product_body_content_wrap_close',       160 );
        add_action( 'woocommerce_after_shop_loop_item',             'cartzilla_wc_loop_product_list_view_inner_wrap_close',    170 );
        add_action( 'woocommerce_after_shop_loop_item',             'cartzilla_wc_loop_product_list_view_wrap_close',          200 );

        remove_action( 'woocommerce_before_shop_loop_item',         'cartzilla_grocery_product_inner_wrap_open',                 6 );

        remove_action( 'woocommerce_after_shop_loop_item_title',    'cartzilla_grocery_loop_product_price',                     10 );

        remove_action( 'woocommerce_after_shop_loop_item_title',    'cartzilla_grocery_product_floating_button_wrap_open',       30 );
        remove_action( 'woocommerce_after_shop_loop_item_title',    'woocommerce_template_loop_add_to_cart',                     40 );
        remove_action( 'woocommerce_after_shop_loop_item_title',    'cartzilla_grocery_product_floating_button_wrap_close',      50 );

        remove_action( 'woocommerce_after_shop_loop_item',          'cartzilla_grocery_product_inner_wrap_close',               10 );
    }
}

if( ! function_exists( 'cartzilla_add_shop_loop_item_v2_hooks' ) ) {
    function cartzilla_add_shop_loop_item_v2_hooks() {
        remove_action( 'woocommerce_before_shop_loop_item',             'cartzilla_wc_loop_product_grid_view_wrap_open',         6 );
        remove_action( 'woocommerce_before_shop_loop_item',             'cartzilla_wc_loop_product_sale_flash',                 10 );
        remove_action( 'woocommerce_before_shop_loop_item',             'cartzilla_wc_loop_product_compare',            21 );
        remove_action( 'woocommerce_before_shop_loop_item',             'cartzilla_wc_loop_product_add_to_wishlist',            20 );

        remove_action( 'woocommerce_before_shop_loop_item_title',       'cartzilla_wc_loop_product_grid_view_thumbnail_wrap_open',8 );
        remove_action( 'woocommerce_before_shop_loop_item_title',       'woocommerce_template_loop_product_thumbnail', 10 );
        remove_action( 'woocommerce_before_shop_loop_item_title',       'cartzilla_wc_loop_product_grid_view_thumbnail_wrap_close',15 );
        remove_action( 'woocommerce_before_shop_loop_item_title',       'cartzilla_wc_loop_product_body_content_wrap_open',        20 );
        remove_action( 'woocommerce_before_shop_loop_item_title',       'cartzilla_wc_loop_product_category',                      30 );

        remove_action( 'woocommerce_shop_loop_item_title',              'cartzilla_wc_loop_product_title',                         40 );

        remove_action( 'woocommerce_after_shop_loop_item_title',        'cartzilla_wc_loop_product_price_rating',                  10 );
        remove_action( 'woocommerce_after_shop_loop_item_title',        'cartzilla_wc_loop_product_body_content_wrap_close',       20 );
        remove_action( 'woocommerce_after_shop_loop_item_title',        'cartzilla_wc_loop_product_hidden_body_content_wrap_open', 30 );
        remove_action( 'woocommerce_after_shop_loop_item_title',        'cartzilla_mas_wcvs_loop_variation', 40 );
        remove_action( 'woocommerce_after_shop_loop_item',              'cartzilla_mas_wcvs_loop_variation', 130 );
        remove_action( 'woocommerce_after_shop_loop_item_title',        'woocommerce_template_loop_add_to_cart',                   50 ); 
        remove_action( 'woocommerce_after_shop_loop_item_title',        'cartzilla_quick_view_link',                               60 ); 
        remove_action( 'woocommerce_after_shop_loop_item_title',        'cartzilla_wc_loop_product_hidden_body_content_wrap_close', 80 );

        remove_action( 'woocommerce_after_shop_loop_item',              'cartzilla_wc_loop_product_grid_view_wrap_close',           10 );
        remove_action( 'woocommerce_after_shop_loop_item',              'cartzilla_wc_loop_product_list_view_wrap_open',            20 );
        remove_action( 'woocommerce_after_shop_loop_item',              'cartzilla_wc_loop_product_add_to_wishlist',                30 );
        remove_action( 'woocommerce_after_shop_loop_item',              'cartzilla_wc_loop_product_list_view_inner_wrap_open',      40 );
        remove_action( 'woocommerce_after_shop_loop_item',              'cartzilla_wc_loop_product_list_view_thumbnail_wrap_open',  50 );
        remove_action( 'woocommerce_after_shop_loop_item',              'woocommerce_template_loop_product_thumbnail',              60 );
        remove_action( 'woocommerce_after_shop_loop_item',              'cartzilla_wc_loop_product_list_view_thumbnail_wrap_close', 70 );
        remove_action( 'woocommerce_after_shop_loop_item',              'cartzilla_wc_loop_product_body_content_wrap_open',         80 );
        remove_action( 'woocommerce_after_shop_loop_item',              'cartzilla_wc_loop_product_category',                       90 );
        remove_action( 'woocommerce_after_shop_loop_item',              'cartzilla_wc_loop_product_title',                         100 );
        remove_action( 'woocommerce_after_shop_loop_item',              'cartzilla_wc_loop_product_price_rating',                  110 );
        remove_action( 'woocommerce_after_shop_loop_item',              'cartzilla_wc_loop_product_hidden_body_content_wrap_open', 120 );
        remove_action( 'woocommerce_after_shop_loop_item',              'woocommerce_template_loop_add_to_cart',                   140 );
        remove_action( 'woocommerce_after_shop_loop_item',              'cartzilla_quick_view_link',                               145 ); 
        remove_action( 'woocommerce_after_shop_loop_item',              'cartzilla_wc_loop_product_hidden_body_content_wrap_close',150 );
        remove_action( 'woocommerce_after_shop_loop_item',              'cartzilla_wc_loop_product_body_content_wrap_close',       160 );
        remove_action( 'woocommerce_after_shop_loop_item',              'cartzilla_wc_loop_product_list_view_inner_wrap_close',    170 );
        remove_action( 'woocommerce_after_shop_loop_item',              'cartzilla_wc_loop_product_list_view_wrap_close',          200 );

        add_action( 'woocommerce_before_shop_loop_item',               'cartzilla_mp_loop_product_wrap_open',               10 );
        add_action( 'woocommerce_before_shop_loop_item',               'cartzilla_mp_loop_product_thumbnail_wrap_open',     20 );
        add_action( 'woocommerce_before_shop_loop_item',               'cartzilla_add_to_wishlist',                         30 );
        add_action( 'woocommerce_before_shop_loop_item',               'cartzilla_mp_loop_product_card_action_wrap_open',   40 );
        add_action( 'woocommerce_before_shop_loop_item',               'cartzilla_mp_quick_view_link',                      50 );
        add_action( 'woocommerce_before_shop_loop_item',               'woocommerce_template_loop_add_to_cart',             60 );
        add_action( 'woocommerce_before_shop_loop_item',               'cartzilla_mp_loop_product_card_action_wrap_close',  70 );
        add_action( 'woocommerce_before_shop_loop_item',               'cartzilla_mp_loop_product_thumb_overlay',           80 );
        add_action( 'woocommerce_before_shop_loop_item',               'woocommerce_template_loop_product_thumbnail',       90 );
        add_action( 'woocommerce_before_shop_loop_item',               'cartzilla_mp_loop_product_thumbnail_wrap_close',   100 );

        add_action( 'woocommerce_before_shop_loop_item_title',         'cartzilla_mp_loop_product_card_body_wrap_open',      0 );
        add_action( 'woocommerce_before_shop_loop_item_title',         'cartzilla_mp_loop_product_category_wishlist_wrap_open',20 );
        add_action( 'woocommerce_before_shop_loop_item_title',         'cartzilla_mp_loop_product_category',                   40 );

        add_action( 'woocommerce_before_shop_loop_item_title',         'cartzilla_mp_loop_product_rating',                     50 );
        add_action( 'woocommerce_before_shop_loop_item_title',         'cartzilla_mp_loop_product_category_wishlist_wrap_close',60 );
        
        add_action( 'woocommerce_shop_loop_item_title',                'cartzilla_wc_loop_product_title',                       10 );
        
        add_action( 'woocommerce_after_shop_loop_item_title',          'cartzilla_mp_loop_product_price_wrap_open',             10 );
        add_action( 'woocommerce_after_shop_loop_item_title',          'cartzilla_mp_loop_product_sold_count',                  20 );
        add_action( 'woocommerce_after_shop_loop_item_title',          'cartzilla_mp_loop_product_price',                       30 );
        add_action( 'woocommerce_after_shop_loop_item_title',          'cartzilla_mp_loop_product_price_wrap_close',            40 );
        add_action( 'woocommerce_after_shop_loop_item_title',          'cartzilla_mp_loop_product_card_body_wrap_close',        50 );

        add_action( 'woocommerce_after_shop_loop_item',                'cartzilla_mp_loop_product_wrap_close',                 200 );
    }
}

if( ! function_exists( 'cartzilla_remove_shop_loop_item_v2_hooks' ) ) {
    function cartzilla_remove_shop_loop_item_v2_hooks() {
        add_action( 'woocommerce_before_shop_loop_item',                'cartzilla_wc_loop_product_grid_view_wrap_open',         6 );
        add_action( 'woocommerce_before_shop_loop_item',                'cartzilla_wc_loop_product_sale_flash',                 10 );
        add_action( 'woocommerce_before_shop_loop_item',                'cartzilla_wc_loop_product_compare',            21 );
        add_action( 'woocommerce_before_shop_loop_item',                'cartzilla_wc_loop_product_add_to_wishlist',            20 );

        add_action( 'woocommerce_before_shop_loop_item_title',      'cartzilla_wc_loop_product_grid_view_thumbnail_wrap_open',8 );
        add_action( 'woocommerce_before_shop_loop_item_title',      'woocommerce_template_loop_product_thumbnail', 10 );
        add_action( 'woocommerce_before_shop_loop_item_title',      'cartzilla_wc_loop_product_grid_view_thumbnail_wrap_close',15 );
        add_action( 'woocommerce_before_shop_loop_item_title',      'cartzilla_wc_loop_product_body_content_wrap_open',        20 );
        add_action( 'woocommerce_before_shop_loop_item_title',      'cartzilla_wc_loop_product_category',                      30 );

        add_action( 'woocommerce_shop_loop_item_title',             'cartzilla_wc_loop_product_title',                         40 );

        add_action( 'woocommerce_after_shop_loop_item_title',       'cartzilla_wc_loop_product_price_rating',                  10 );
        add_action( 'woocommerce_after_shop_loop_item_title',       'cartzilla_wc_loop_product_body_content_wrap_close',       20 );
        add_action( 'woocommerce_after_shop_loop_item_title',       'cartzilla_wc_loop_product_hidden_body_content_wrap_open', 30 );
        add_action( 'woocommerce_after_shop_loop_item_title',       'woocommerce_template_loop_add_to_cart',                   50 ); 
        add_action( 'woocommerce_after_shop_loop_item_title',       'cartzilla_quick_view_link',                               60 ); 
        add_action( 'woocommerce_after_shop_loop_item_title',       'cartzilla_wc_loop_product_hidden_body_content_wrap_close', 80 );

        add_action( 'woocommerce_after_shop_loop_item',             'cartzilla_wc_loop_product_grid_view_wrap_close',           10 );
        add_action( 'woocommerce_after_shop_loop_item',             'cartzilla_wc_loop_product_list_view_wrap_open',            20 );
        add_action( 'woocommerce_after_shop_loop_item',             'cartzilla_wc_loop_product_add_to_wishlist',                30 );
        add_action( 'woocommerce_after_shop_loop_item',             'cartzilla_wc_loop_product_list_view_inner_wrap_open',      40 );
        add_action( 'woocommerce_after_shop_loop_item',             'cartzilla_wc_loop_product_list_view_thumbnail_wrap_open',  50 );
        add_action( 'woocommerce_after_shop_loop_item',             'woocommerce_template_loop_product_thumbnail',              60 );
        add_action( 'woocommerce_after_shop_loop_item',             'cartzilla_wc_loop_product_list_view_thumbnail_wrap_close', 70 );
        add_action( 'woocommerce_after_shop_loop_item',             'cartzilla_wc_loop_product_body_content_wrap_open',         80 );
        add_action( 'woocommerce_after_shop_loop_item',             'cartzilla_wc_loop_product_category',                       90 );
        add_action( 'woocommerce_after_shop_loop_item',             'cartzilla_wc_loop_product_title',                         100 );
        add_action( 'woocommerce_after_shop_loop_item',             'cartzilla_wc_loop_product_price_rating',                  110 );
        add_action( 'woocommerce_after_shop_loop_item',             'cartzilla_wc_loop_product_hidden_body_content_wrap_open', 120 );
        add_action( 'woocommerce_after_shop_loop_item',             'woocommerce_template_loop_add_to_cart',                   140 );
        add_action( 'woocommerce_after_shop_loop_item',             'cartzilla_quick_view_link',                               145 ); 
        add_action( 'woocommerce_after_shop_loop_item',             'cartzilla_wc_loop_product_hidden_body_content_wrap_close',150 );
        add_action( 'woocommerce_after_shop_loop_item',             'cartzilla_wc_loop_product_body_content_wrap_close',       160 );
        add_action( 'woocommerce_after_shop_loop_item',             'cartzilla_wc_loop_product_list_view_inner_wrap_close',    170 );
        add_action( 'woocommerce_after_shop_loop_item',             'cartzilla_wc_loop_product_list_view_wrap_close',          200 );

        remove_action( 'woocommerce_before_shop_loop_item',            'cartzilla_mp_loop_product_wrap_open',               10 );
        remove_action( 'woocommerce_before_shop_loop_item',            'cartzilla_mp_loop_product_thumbnail_wrap_open',     20 );
        remove_action( 'woocommerce_before_shop_loop_item',            'cartzilla_add_to_wishlist',                         30 );
        remove_action( 'woocommerce_before_shop_loop_item',            'cartzilla_mp_loop_product_card_action_wrap_open',   40 );
        remove_action( 'woocommerce_before_shop_loop_item',            'cartzilla_mp_quick_view_link',                      50 );
        remove_action( 'woocommerce_before_shop_loop_item',            'woocommerce_template_loop_add_to_cart',             60 );
        remove_action( 'woocommerce_before_shop_loop_item',            'cartzilla_mp_loop_product_card_action_wrap_close',  70 );
        remove_action( 'woocommerce_before_shop_loop_item',            'cartzilla_mp_loop_product_thumb_overlay',           80 );
        remove_action( 'woocommerce_before_shop_loop_item',            'woocommerce_template_loop_product_thumbnail',       90 );
        remove_action( 'woocommerce_before_shop_loop_item',            'cartzilla_mp_loop_product_thumbnail_wrap_close',   100 );

        remove_action( 'woocommerce_before_shop_loop_item_title',          'cartzilla_mp_loop_product_card_body_wrap_open',      0 );
        remove_action( 'woocommerce_before_shop_loop_item_title',          'cartzilla_mp_loop_product_category_wishlist_wrap_open',20 );
        remove_action( 'woocommerce_before_shop_loop_item_title',          'cartzilla_mp_loop_product_category',                   40 );

        remove_action( 'woocommerce_before_shop_loop_item_title',          'cartzilla_mp_loop_product_rating',                     50 );
        remove_action( 'woocommerce_before_shop_loop_item_title',          'cartzilla_mp_loop_product_category_wishlist_wrap_close',60 );
        
        remove_action( 'woocommerce_shop_loop_item_title',                 'cartzilla_wc_loop_product_title',                       10 );
        
        remove_action( 'woocommerce_after_shop_loop_item_title',           'cartzilla_mp_loop_product_price_wrap_open',             10 );
        remove_action( 'woocommerce_after_shop_loop_item_title',           'cartzilla_mp_loop_product_sold_count',                  20 );
        remove_action( 'woocommerce_after_shop_loop_item_title',           'cartzilla_mp_loop_product_price',                       30 );
        remove_action( 'woocommerce_after_shop_loop_item_title',           'cartzilla_mp_loop_product_price_wrap_close',            40 );
        remove_action( 'woocommerce_after_shop_loop_item_title',           'cartzilla_mp_loop_product_card_body_wrap_close',        50 );

        remove_action( 'woocommerce_after_shop_loop_item',                 'cartzilla_mp_loop_product_wrap_close',                 200 );
    }
}

if( ! function_exists( 'cartzilla_wc_product_list_thumbnail' ) ) {
    function cartzilla_wc_product_list_thumbnail() {
    global $product;
    $product_image_id = $product->get_image_id();?>

    <a href="<?php echo esc_url( $product->get_permalink() ); ?>" class="d-block mr-2">
        <?php echo wp_get_attachment_image( $product_image_id,'thumbnail', '', array( 'class' => 'product-image', 'style' => 'width: 64px' ) ); ?>
    </a><?php

    }
}

if( ! function_exists( 'cartzilla_wc_product_list_title' ) ) {
    function cartzilla_wc_product_list_title() {
    global $product;?>

    <h6 class="widget-product-title">
        <a href="<?php echo esc_url( $product->get_permalink() ); ?>">
            <?php echo wp_kses_post( $product->get_name() ); ?>
        </a>
    </h6><?php

    }
}

if( ! function_exists( 'cartzilla_wc_product_list_meta' ) ) {
    function cartzilla_wc_product_list_meta() {
    global $product;?>

    <div class="widget-product-meta">
        <?php echo wp_kses_post( $product->get_price_html() ); ?>
    </div><?php

    }
}
