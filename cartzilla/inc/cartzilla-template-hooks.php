<?php
/**
 * Cartzilla hooks
 *
 * @package cartzilla
 */

add_action( 'cartzilla_before_site', 'wp_body_open', 0 );

/**
 * Page
 */
add_action( 'cartzilla_page', 'cartzilla_page_header', 10 );
add_action( 'cartzilla_page', 'cartzilla_page_content', 20 );

/**
 * Header
 */
add_action( 'cartzilla_header_before', 'cartzilla_handheld_sidebar' );
add_action( 'cartzilla_header', 'cartzilla_header' );

/**
 * Footer
 */
add_action( 'cartzilla_footer', 'cartzilla_footer' );
add_action( 'cartzilla_footer_after', 'cartzilla_scroll_to_top', 100 );
add_action( 'cartzilla_footer_after', 'cartzilla_handheld_toolbar', 120 );

/**
 * Protected Post Custom Password Form
 */
add_filter( 'the_password_form', 'cartzilla_post_protected_password_form' );

/**
 * Nav Menu Widget Handle Custom Fields
 */
add_filter( 'in_widget_form', 'cartzilla_custom_widget_nav_menu_options', 10, 3 );
add_filter( 'widget_update_callback', 'cartzilla_custom_widget_nav_menu_options_update', 10, 4 );
add_filter( 'widget_nav_menu_args', 'cartzilla_custom_widget_nav_menu_args', 20, 4 );

/**
 * Posts loop (WordPress home, posts listing)
 */
add_filter( 'excerpt_more', 'cartzilla_excerpt_more', 10 );
add_filter( 'the_excerpt', 'cartzilla_the_excerpt', 20 );
add_action( 'cartzilla_posts_before', 'cartzilla_posts_title', 50 );
add_action( 'cartzilla_loop_after', 'cartzilla_pagination', 20 );

add_action( 'cartzilla_posts_content_before', 'cartzilla_popular_posts', 10 );

/**
 * Single post
 */
add_action( 'cartzilla_single_post_before', 'cartzilla_post_title', 10 );
add_action( 'cartzilla_single_post_before', 'cartzilla_single_post_container_start', 20 );
add_action( 'cartzilla_single_post_before', 'cartzilla_single_post_row_start', 30 );

add_action( 'cartzilla_single_post', 'cartzilla_single_post_meta', 10 );
add_action( 'cartzilla_single_post', 'cartzilla_single_post_media', 20 );
add_action( 'cartzilla_single_post', 'cartzilla_single_post_contant', 30 );
add_action( 'cartzilla_single_post', 'cartzilla_single_post_tag_share', 40 );
add_action( 'cartzilla_single_post', 'cartzilla_post_navigation', 50 );
add_action( 'cartzilla_single_post', 'cartzilla_comments', 60 );

add_action( 'cartzilla_single_post_after', 'cartzilla_single_post_sidebar', 10 );
add_action( 'cartzilla_single_post_after', 'cartzilla_single_post_row_end', 20 );
add_action( 'cartzilla_single_post_after', 'cartzilla_single_post_container_end', 30 );
add_action( 'cartzilla_single_post_after', 'cartzilla_related_posts', 40 );

/**
 * Comments
 */
add_filter( 'get_comments_number', 'cartzilla_comments_number', 0 );
add_filter( 'comment_reply_link', 'cartzilla_comment_reply_link', 20, 2 );
add_filter( 'comment_form_default_fields', 'cartzilla_comment_form_default_fields', 20 );
add_action( 'wp_update_comment_count', 'cartzilla_comments_number_flush' );
add_action( 'comment_form_top', 'cartzilla_comment_form_before' );
add_action( 'comment_form', 'cartzilla_comment_form_after' );

/**
 * Toolbar
 */
add_action( 'cartzilla_handheld_toolbar', 'cartzilla_handheld_toolbar_toggle_blog_sidebar', 30 );
add_action( 'cartzilla_handheld_toolbar', 'cartzilla_handheld_toolbar_toggle_handheld_sidebar', 50 );

add_filter( 'cartzilla_header_layout', 'cartzilla_page_header_layout', 10);

add_filter( 'cartzilla_dropdown_tools_toggle', 'cartzilla_dropdown_tools_title', 10);
add_filter( 'cartzilla_dropdown_tools', 'cartzilla_dropdown_tools_language_currency', 10);

add_filter( 'pre_get_avatar_data', 'cartzilla_custom_uploaded_pre_avatar_override', 10, 2 );
add_filter( 'get_avatar_url', 'cartzilla_custom_uploaded_avatar_url_override', 10, 3 );
add_filter( 'get_avatar_data', 'cartzilla_custom_uploaded_avatar_override', 10, 2 );
