<?php
/**
 * Template Hooks used in WooCommerce pages
 */

/**
 * Cart and mini-cart
 */
remove_action( 'woocommerce_cart_collaterals', 'woocommerce_cross_sell_display' );
remove_action( 'woocommerce_widget_shopping_cart_total', 'woocommerce_widget_shopping_cart_subtotal', 10 );
remove_action( 'woocommerce_widget_shopping_cart_buttons', 'woocommerce_widget_shopping_cart_button_view_cart', 10 );
remove_action( 'woocommerce_widget_shopping_cart_buttons', 'woocommerce_widget_shopping_cart_proceed_to_checkout', 20 );
add_filter( 'woocommerce_add_to_cart_fragments', 'cartzilla_wc_cart_fragments' );
add_action( 'woocommerce_after_cart', 'cartzilla_output_cross_sell_products' );

/**
 * Checkout
 */
remove_action( 'woocommerce_before_checkout_form', 'woocommerce_checkout_coupon_form', 10 );
remove_action( 'woocommerce_before_checkout_form', 'woocommerce_checkout_login_form', 10 );
add_action( 'woocommerce_after_checkout_form', 'woocommerce_checkout_coupon_form', 10 );

add_filter( 'woocommerce_default_address_fields', 'cartzilla_wc_checkout_address_fields' );
add_filter( 'woocommerce_billing_fields', 'cartzilla_wc_checkout_address_fields' );
add_filter( 'woocommerce_checkout_fields', 'cartzilla_wc_checkout_fields' );

add_action( 'cartzilla_header_before', 'cartzilla_wc_modal_in_checkout', 20 );

add_action( 'woocommerce_credit_card_form_start', 'cartzilla_row_open', 10 );
add_action( 'woocommerce_credit_card_form_end', 'cartzilla_row_close', 10 );

add_action( 'woocommerce_save_account_details', 'cartzilla_woocommerce_save_account_form_profile_pic_field' );