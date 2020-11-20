<?php

add_action( 'pt-ocdi/before_content_import_execution', 'cartzilla_ocdi_before_content_import_execution_remove_dokan_default_pages' );

add_filter( 'pt-ocdi/import_files', 'cartzilla_ocdi_import_files' );

add_action( 'pt-ocdi/after_import', 'cartzilla_ocdi_after_import_setup' );

add_action( 'pt-ocdi/before_widgets_import', 'cartzilla_ocdi_before_widgets_import' );

add_action( 'admin_init', 'cartzilla_tgmpa_demo_selector_update' );

add_filter( 'pt-ocdi/plugin_intro_text', 'cartzilla_ocdi_plugin_intro_text' );

add_filter( 'pt-ocdi/confirmation_dialog_options', 'cartzilla_ocdi_confirmation_dialog_options', 10 );

add_filter( 'wp_import_post_data_processed', 'cartzilla_ocdi_wp_import_post_data_processed', 99, 2 );

add_filter( 'wxr_importer.pre_process.post_meta', 'cartzilla_wp_import_post_meta_data_processed', 99, 2 );

add_action( 'admin_enqueue_scripts', 'cartzilla_ocdi_admin_styles' );