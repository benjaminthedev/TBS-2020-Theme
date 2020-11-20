<?php
/**
 * WooCommerce hooks
 *
 * @package Cartzilla
 */

/**
 * Products
 */
remove_action( 'woocommerce_before_main_content',              'woocommerce_output_content_wrapper', 10 );
remove_action( 'woocommerce_before_main_content',              'woocommerce_breadcrumb', 20 );
remove_action( 'woocommerce_before_shop_loop',                 'woocommerce_result_count', 20 );
remove_action( 'woocommerce_before_shop_loop',                 'woocommerce_catalog_ordering', 30 );
remove_action( 'woocommerce_after_shop_loop',                  'woocommerce_pagination', 10 );
remove_action( 'woocommerce_after_main_content',               'woocommerce_output_content_wrapper_end', 10 );
/**
 * Product loop item (tiles)
 */
remove_action( 'woocommerce_before_shop_loop_item',            'woocommerce_template_loop_product_link_open', 10 );
remove_action( 'woocommerce_before_shop_loop_item_title',      'woocommerce_show_product_loop_sale_flash', 10 );
remove_action( 'woocommerce_shop_loop_item_title',             'woocommerce_template_loop_product_title', 10 );
remove_action( 'woocommerce_after_shop_loop_item_title',       'woocommerce_template_loop_rating', 5 );
remove_action( 'woocommerce_after_shop_loop_item_title',       'woocommerce_template_loop_price', 10 );
remove_action( 'woocommerce_after_shop_loop_item',             'woocommerce_template_loop_product_link_close', 5 );
remove_action( 'woocommerce_after_shop_loop_item',             'woocommerce_template_loop_add_to_cart', 10 );

add_action( 'woocommerce_after_shop_loop',                     'cartzilla_wc_products_pagination', 100 );
add_filter( 'woocommerce_loop_add_to_cart_args',               'cartzilla_wc_loop_product_add_to_cart_args', 50, 2 );
add_filter( 'woocommerce_loop_add_to_cart_link',               'cartzilla_wc_loop_product_add_to_cart_link', 50, 2 );

add_filter( 'formatted_woocommerce_price',                     'cartzilla_decimal_price', 10, 5 );
add_filter('woocommerce_format_sale_price',                    'cartzilla_wc_format_sale_price', 10, 3);
add_filter( 'cartzilla_wc_catalog_ordering_label',             'cartzilla_custom_catalog_ordering_label' );


/**
 * Handheld Toolbar
 */
add_action( 'cartzilla_handheld_toolbar',                      'cartzilla_wc_handheld_toolbar_toggle_shop_sidebar', 20 );
add_action( 'cartzilla_handheld_toolbar',                      'cartzilla_wc_handheld_toolbar_toggle_cart', 60 );

/**
 * Product Categories
 */
// Remove default subcatgories
add_filter( 'woocommerce_product_loop_start',                   'cartzilla_remove_loop_start_subcatgories' );
add_action( 'woocommerce_before_shop_loop',                     'cartzilla_wc_maybe_show_product_subcategories', 20 );


/*Toggle hook*/
add_action( 'woocommerce_before_shop_loop',                     'cartzilla_toggle_shop_loop_hooks',         5 );


/*Product Loop*/
add_action( 'woocommerce_before_shop_loop_item',                'cartzilla_wc_loop_product_grid_view_wrap_open',         6 );
add_action( 'woocommerce_before_shop_loop_item',                'cartzilla_wc_loop_product_sale_flash',                 10 );
add_action( 'woocommerce_before_shop_loop_item',                'cartzilla_wc_loop_product_compare',                     21 );
add_action( 'woocommerce_before_shop_loop_item',                'cartzilla_wc_loop_product_add_to_wishlist',            20 );

add_action( 'woocommerce_before_shop_loop_item_title',          'cartzilla_wc_loop_product_grid_view_thumbnail_wrap_open',8 );
add_action( 'woocommerce_before_shop_loop_item_title',          'cartzilla_wc_loop_product_grid_view_thumbnail_wrap_close',15 );
add_action( 'woocommerce_before_shop_loop_item_title',          'cartzilla_wc_loop_product_body_content_wrap_open',        20 );
add_action( 'woocommerce_before_shop_loop_item_title',          'cartzilla_wc_loop_product_category',                      30 );

add_action( 'woocommerce_shop_loop_item_title',                 'cartzilla_wc_loop_product_title',                         40 );

add_action( 'woocommerce_after_shop_loop_item_title',           'cartzilla_wc_loop_product_price_rating',                  10 );
add_action( 'woocommerce_after_shop_loop_item_title',           'cartzilla_wc_loop_product_body_content_wrap_close',       20 );
add_action( 'woocommerce_after_shop_loop_item_title',           'cartzilla_wc_loop_product_hidden_body_content_wrap_open', 30 );
add_action( 'woocommerce_after_shop_loop_item_title',           'woocommerce_template_loop_add_to_cart',                   50 ); 
add_action( 'woocommerce_after_shop_loop_item_title',           'cartzilla_quick_view_link',                               60 ); 
add_action( 'woocommerce_after_shop_loop_item_title',           'cartzilla_wc_loop_product_hidden_body_content_wrap_close', 80 );

add_action( 'woocommerce_after_shop_loop_item',                 'cartzilla_wc_loop_product_grid_view_wrap_close',           10 );
add_action( 'woocommerce_after_shop_loop_item',                 'cartzilla_wc_loop_product_list_view_wrap_open',            20 );
add_action( 'woocommerce_after_shop_loop_item',                 'cartzilla_wc_loop_product_add_to_wishlist',                30 );
add_action( 'woocommerce_after_shop_loop_item',                 'cartzilla_wc_loop_product_list_view_inner_wrap_open',      40 );
add_action( 'woocommerce_after_shop_loop_item',                 'cartzilla_wc_loop_product_list_view_thumbnail_wrap_open',  50 );
add_action( 'woocommerce_after_shop_loop_item',                 'woocommerce_template_loop_product_thumbnail',              60 );
add_action( 'woocommerce_after_shop_loop_item',                 'cartzilla_wc_loop_product_list_view_thumbnail_wrap_close', 70 );
add_action( 'woocommerce_after_shop_loop_item',                 'cartzilla_wc_loop_product_body_content_wrap_open',         80 );
add_action( 'woocommerce_after_shop_loop_item',                 'cartzilla_wc_loop_product_category',                       90 );
add_action( 'woocommerce_after_shop_loop_item',                 'cartzilla_wc_loop_product_title',                         100 );
add_action( 'woocommerce_after_shop_loop_item',                 'cartzilla_wc_loop_product_price_rating',                  110 );
add_action( 'woocommerce_after_shop_loop_item',                 'cartzilla_wc_loop_product_hidden_body_content_wrap_open', 120 );
add_action( 'woocommerce_after_shop_loop_item',                 'woocommerce_template_loop_add_to_cart',                   140 );
add_action( 'woocommerce_after_shop_loop_item',                 'cartzilla_quick_view_link',                               145 ); 
add_action( 'woocommerce_after_shop_loop_item',                 'cartzilla_wc_loop_product_hidden_body_content_wrap_close',150 );
add_action( 'woocommerce_after_shop_loop_item',                 'cartzilla_wc_loop_product_body_content_wrap_close',       160 );
add_action( 'woocommerce_after_shop_loop_item',                 'cartzilla_wc_loop_product_list_view_inner_wrap_close',    170 );
add_action( 'woocommerce_after_shop_loop_item',                 'cartzilla_wc_loop_product_list_view_wrap_close',          200 );

/*Price Slider*/
add_filter( 'woocommerce_price_filter_widget_step',            'cartzilla_wc_widget_price_filter_step' );

/*Product List View*/
add_action( 'cartzilla_before_product_list_view_body',         'cartzilla_wc_product_list_thumbnail', 10 );
add_action( 'cartzilla_product_list_view_body',                'cartzilla_wc_product_list_title', 10 );
add_action( 'cartzilla_product_list_view_body',                'cartzilla_wc_product_list_meta', 20 );