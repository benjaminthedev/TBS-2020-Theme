<?php

/**
 * Template Hooks used in WooCommerce
 */

require_once get_template_directory() . '/inc/woocommerce/template-hooks/product-item.php';
require_once get_template_directory() . '/inc/woocommerce/template-hooks/single-product.php';
require_once get_template_directory() . '/inc/woocommerce/template-hooks/wc-pages.php';

/**
 * Woocommerce Breadcrumb
 */
add_filter( 'cartzilla_breadcrumbs_provider', 'cartzilla_wc_provider' );
add_filter( 'cartzilla_order_tracking_provider', 'cartzilla_wc_provider' );
add_action( 'cartzilla_breadcrumbs_woocommerce', 'cartzilla_wc_breadcrumbs' );

/**
 * Departments menu
 */
add_filter( 'cartzilla_is_departments_menu', 'cartzilla_wc_departments_visibility' );
add_filter( 'cartzilla_departments_menu_args', 'cartzilla_wc_departments_menu_args' );

/**
 * Modal
 */
add_action( 'cartzilla_header_before', 'cartzilla_wc_modal_in_navbar', 20 );