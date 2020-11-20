<?php
/**
 * Template Hooks used in Single Product
 *
 * @package cartzilla
 */
/**
 * Single product
 */
remove_action( 'woocommerce_before_single_product_summary',             'woocommerce_show_product_sale_flash',  10 );
remove_action( 'woocommerce_before_single_product_summary',             'woocommerce_show_product_images',      20 );
remove_action( 'woocommerce_single_product_summary',                    'woocommerce_template_single_title',     5 );
remove_action( 'woocommerce_single_product_summary',                    'woocommerce_template_single_rating',   10 );
remove_action( 'woocommerce_single_product_summary',                    'woocommerce_template_single_price',    10 );
remove_action( 'woocommerce_single_product_summary',                    'woocommerce_template_single_excerpt',  20 );
remove_action( 'woocommerce_single_product_summary',                    'woocommerce_template_single_meta',     40 );
remove_action( 'woocommerce_after_single_product_summary',              'woocommerce_output_product_data_tabs', 10 );
remove_action( 'woocommerce_after_single_product_summary',              'woocommerce_upsell_display',           15 ); 
remove_action( 'woocommerce_single_product_summary',                    'woocommerce_template_single_sharing',  50 );// TODO: enable in future releases
remove_action( 'woocommerce_after_single_product_summary',              'woocommerce_output_related_products',  20 ); // TODO: enable in future releases
add_action( 'template_redirect',                                        'cartzilla_wc_product_remove_sidebar' );



add_action( 'woocommerce_before_single_product',                        'cartzilla_toggle_before_single_product_hooks',         5 );

add_action( 'woocommerce_after_single_product_summary',                 'cartzilla_toggle_shop_loop_hooks', 1 );

add_action( 'woocommerce_after_single_product_summary',                 'woocommerce_upsell_display',          250 ); 
add_action( 'woocommerce_after_single_product_summary',                 'cartzilla_output_related_products',   260 ); 


/** 
 * remove on single product panel 'Additional Information' since it already says it on tab.
 */
add_filter('woocommerce_output_related_products_args', 'cartzilla_output_related_products_args');

//Toggle style

add_action( 'woocommerce_before_single_product_summary',			     'cartzilla_toggle_single_product_hooks',5 );


/**
 * Notices
 */
remove_action( 'woocommerce_cart_is_empty', 'woocommerce_output_all_notices', 5 );
remove_action( 'woocommerce_shortcode_before_product_cat_loop', 'woocommerce_output_all_notices', 10 );
remove_action( 'woocommerce_before_shop_loop', 'woocommerce_output_all_notices', 10 );
remove_action( 'woocommerce_before_single_product', 'woocommerce_output_all_notices', 10 );
remove_action( 'woocommerce_before_cart', 'woocommerce_output_all_notices', 10 );
remove_action( 'woocommerce_before_checkout_form_cart_notices', 'woocommerce_output_all_notices', 10 );
remove_action( 'woocommerce_before_checkout_form', 'woocommerce_output_all_notices', 10 );
remove_action( 'woocommerce_account_content', 'woocommerce_output_all_notices', 5 );
remove_action( 'woocommerce_before_customer_login_form', 'woocommerce_output_all_notices', 10 );
remove_action( 'woocommerce_before_lost_password_form', 'woocommerce_output_all_notices', 10 );
remove_action( 'before_woocommerce_pay', 'woocommerce_output_all_notices', 10 );
remove_action( 'woocommerce_before_reset_password_form', 'woocommerce_output_all_notices', 10 );

remove_action( 'woocommerce_after_checkout_form', 'woocommerce_output_all_notices', 10 );

add_action( 'cartzilla_footer_after', 'woocommerce_output_all_notices', 100 );



