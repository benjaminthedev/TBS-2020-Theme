<?php
/**
 * Cartzilla dokan hooks
 *
 * @package cartzilla
 */

/*
 * Dequeue Dokan Tooltip Script
 */
add_action( 'dokan_enqueue_scripts', 'cartzilla_dokan_enqueue_scripts' );

/*
 * Dashboard
 */
add_action( 'dokan_dashboard_wrap_start', 'cartzilla_dokan_dashboard_page_conatiner_open', 999 );
add_action( 'dokan_dashboard_wrap_end', 'cartzilla_dokan_dashboard_page_conatiner_close', 999 );

add_action( 'dokan_before_new_product_inside_content_area', 'cartzilla_dokan_dashboard_content_area_open', 999 );
add_action( 'dokan_after_new_product_inside_content_area', 'cartzilla_dokan_dashboard_content_area_close', 999 );
add_action( 'dokan_product_content_inside_area_before', 'cartzilla_dokan_dashboard_content_area_open', 999 );
add_action( 'dokan_product_content_inside_area_after', 'cartzilla_dokan_dashboard_content_area_close', 999 );

add_filter( 'dokan_get_dashboard_nav', 'cartzilla_dokan_modify_dashboard_nav', 30 );
add_filter( 'dokan_withdraw_methods', 'cartzilla_dokan_withdraw_methods', 20 );

add_action( 'dokan_dashboard_wrap_start', 'cartzilla_dokan_dashboard_remove_default_widgets', 5 );
add_action( 'dokan_dashboard_wrap_start', 'cartzilla_dokan_dashboard_page_title', 10 );

add_action( 'dokan_dashboard_before_widgets', 'cartzilla_dokan_dashboard_sales_widgets_title', 5 );
add_action( 'dokan_dashboard_before_widgets', 'cartzilla_dokan_dashboard_sales_overview_widget', 8 );

add_action( 'dokan_settings_content_area_header', 'cartzilla_dokan_settings_content_area_title', 10 );
add_action( 'dokan_settings_content_area_header', 'cartzilla_dokan_settings_content_area_nav', 20 );

add_action( 'dokan_dashboard_edit_account_area_header', 'cartzilla_dokan_settings_content_area_title', 10 );
add_action( 'dokan_dashboard_edit_account_area_header', 'cartzilla_dokan_settings_content_area_nav', 20 );

add_action( 'dokan_settings_form_bottom', 'cartzilla_dokan_store_settings_form', 10, 2 );
add_action( 'dokan_settings_form_bottom', 'cartzilla_dokan_render_biography_form', 10, 2 );
add_action( 'dokan_settings_form_bottom', 'cartzilla_dokan_add_support_btn_title_input', 13, 2 );
add_action( 'dokan_settings_form_bottom', 'cartzilla_dokan_live_chat_seller_settings', 15, 2 );

add_action( 'dokan_before_listing_product_widgets', 'cartzilla_dokan_before_listing_product_widgets_title', 5 );

/*
 * Vendor Page
 */
add_action( 'cartzilla_dokan_vendor_page_start', 'cartzilla_dokan_dashboard_page_conatiner_open', 99 );
add_action( 'cartzilla_dokan_vendor_page_start', 'cartzilla_dokan_store_page_row_open', 110 );
add_action( 'cartzilla_dokan_vendor_page_start', 'cartzilla_dokan_store_page_aside', 130 );
add_action( 'cartzilla_dokan_vendor_page_start', 'cartzilla_dokan_store_page_main_open', 150 );
add_action( 'cartzilla_dokan_vendor_page_start', 'cartzilla_dokan_store_page_main_tabs', 160 );
add_action( 'cartzilla_dokan_vendor_page_end', 'cartzilla_dokan_store_page_main_close', 99 );
add_action( 'cartzilla_dokan_vendor_page_end', 'cartzilla_dokan_dashboard_page_conatiner_close', 99 );

add_action( 'cartzilla_dokan_store_page_aside', 'cartzilla_dokan_store_page_aside_open', 10 );
add_action( 'cartzilla_dokan_store_page_aside', 'cartzilla_dokan_store_page_aside_inner_open', 20 );
add_action( 'cartzilla_dokan_store_page_aside', 'cartzilla_dokan_store_page_aside_content', 30 );
add_action( 'cartzilla_dokan_store_page_aside', 'cartzilla_dokan_store_page_aside_inner_close', 50 );
add_action( 'cartzilla_dokan_store_page_aside', 'cartzilla_dokan_store_page_aside_close', 999 );

add_action( 'dokan_sidebar_store_before', 'cartzilla_dokan_store_page_aside_vendor_about', 10, 2 );
add_action( 'dokan_sidebar_store_before', 'cartzilla_dokan_store_page_aside_contact_info', 20, 2 );
add_action( 'dokan_sidebar_store_before', 'cartzilla_dokan_store_page_aside_store_buttons', 30, 2 );

add_filter( 'dokan_profile_social_fields', 'cartzilla_dokan_profile_social_fields', 20 );

add_action( 'woocommerce_before_main_content', 'cartzilla_toggle_dokan_product_loop_hooks' );
