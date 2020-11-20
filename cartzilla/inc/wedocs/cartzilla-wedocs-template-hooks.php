<?php
/**
 * Cartzilla WeDocs Hooks
 *
 * @package Cartzilla/WeDocs
 */
remove_action( 'wedocs_before_main_content', 'wedocs_template_wrapper_start', 10 );
remove_action( 'wedocs_after_main_content', 'wedocs_template_wrapper_end', 10 );

add_action( 'cartzilla_wedocs_entry_footer', 'cz_wedocs_submit_request_modal_single_doc', 10 );
add_action( 'cartzilla_wedocs_entry_footer', 'cz_wedocs_display_helpful_feedback', 20 );
add_action( 'cartzilla_wedocs_entry_footer', 'cz_wedocs_display_comments', 30 );

/**
 * Helpcenter Page Template
 *
 * @see  cartzilla_helpcenter_header()
 * @see  storefront_page_content()
 */
add_action( 'cartzilla_helpcenter', 'cz_helpcenter_hero', 10 );
add_action( 'cartzilla_helpcenter', 'cz_helpcenter_wedocs', 20 );
add_action( 'cartzilla_helpcenter', 'cz_helpcenter_popular_articles', 30 );
add_action( 'cartzilla_helpcenter', 'cz_wedocs_submit_request_modal_home', 40 );

/**
 * WeDocs Sidebar
 *
 */
add_action( 'cz_wedocs_sidebar', 'cz_wedocs_sidebar_related_articles', 10 );