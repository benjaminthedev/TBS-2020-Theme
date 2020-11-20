<?php

function cartzilla_ocdi_before_content_import_execution_remove_dokan_default_pages() {
    if( cartzilla_is_dokan_activated() ) {
        $dashboard_page = get_page_by_title( 'Dashboard' );
        $my_order_page = get_page_by_title( 'My Orders' );
        $store_list_page = get_page_by_title( 'Store List' );

        if( isset( $dashboard_page->ID ) && $dashboard_page->ID > 0 ) {
            wp_delete_post( $dashboard_page->ID, true );
        }

        if( isset( $my_order_page->ID ) && $my_order_page->ID > 0 ) {
            wp_delete_post( $my_order_page->ID, true );
        }

        if( isset( $store_list_page->ID ) && $store_list_page->ID > 0 ) {
            wp_delete_post( $store_list_page->ID, true );
        }
    }
}

function cartzilla_ocdi_import_files() {
    $dd_path = trailingslashit( get_template_directory() ) . 'assets/dummy-data/';
    return apply_filters( 'cartzilla_ocdi_files_args', array(
        array(
            'import_file_name'             => 'Cartzilla - Fashion',
            'categories'                   => array( 'Fashion' ),
            'local_import_file'            => $dd_path . 'main/dummy-data.xml',
            'local_import_widget_file'     => $dd_path . 'main/widgets.wie',
            'local_import_customizer_file' => $dd_path . 'main/customizer.dat',
            'import_preview_image_url'     => 'https://madrasthemes.github.io/themeforest/wordpress/cartzilla/assets/images/screenshots/main.jpg',
            'import_notice'                => esc_html__( 'Import process may take 3-5 minutes. If you facing any issues please contact our support.', 'cartzilla' ),
            'preview_url'                  => 'https://demo.madrasthemes.com/cartzilla/',
        ),
        array(
            'import_file_name'             => 'Cartzilla - Electronics',
            'categories'                   => array( 'Electronics' ),
            'local_import_file'            => $dd_path . 'electronics/dummy-data.xml',
            'local_import_widget_file'     => $dd_path . 'electronics/widgets.wie',
            'local_import_customizer_file' => $dd_path . 'electronics/customizer.dat',
            'import_preview_image_url'     => 'https://madrasthemes.github.io/themeforest/wordpress/cartzilla/assets/images/screenshots/electronics.jpg',
            'import_notice'                => esc_html__( 'Import process may take 3-5 minutes. If you facing any issues please contact our support.', 'cartzilla' ),
            'preview_url'                  => 'https://demo.madrasthemes.com/cartzilla-electronics/',
        ),
        array(
            'import_file_name'             => 'Cartzilla - Marketplace',
            'categories'                   => array( 'Marketplace' ),
            'local_import_file'            => $dd_path . 'marketplace/dummy-data.xml',
            'local_import_widget_file'     => $dd_path . 'marketplace/widgets.wie',
            'local_import_customizer_file' => $dd_path . 'marketplace/customizer.dat',
            'import_preview_image_url'     => 'https://madrasthemes.github.io/themeforest/wordpress/cartzilla/assets/images/screenshots/marketplace.jpg',
            'import_notice'                => esc_html__( 'Import process may take 3-5 minutes. If you facing any issues please contact our support.', 'cartzilla' ),
            'preview_url'                  => 'https://demo.madrasthemes.com/cartzilla-marketplace/',
        ),
        array(
            'import_file_name'             => 'Cartzilla - Grocery',
            'categories'                   => array( 'Grocery' ),
            'local_import_file'            => $dd_path . 'grocery/dummy-data.xml',
            'local_import_widget_file'     => $dd_path . 'grocery/widgets.wie',
            'local_import_customizer_file' => $dd_path . 'grocery/customizer.dat',
            'import_preview_image_url'     => 'https://madrasthemes.github.io/themeforest/wordpress/cartzilla/assets/images/screenshots/grocery.jpg',
            'import_notice'                => esc_html__( 'Import process may take 3-5 minutes. If you facing any issues please contact our support.', 'cartzilla' ),
            'preview_url'                  => 'https://demo.madrasthemes.com/cartzilla-grocery/',
        ),
        array(
            'import_file_name'             => 'Cartzilla - Help Center',
            'categories'                   => array( 'Help Center' ),
            'local_import_file'            => $dd_path . 'helpcenter/dummy-data.xml',
            'local_import_widget_file'     => $dd_path . 'helpcenter/widgets.wie',
            'local_import_customizer_file' => $dd_path . 'helpcenter/customizer.dat',
            'import_preview_image_url'     => 'https://madrasthemes.github.io/themeforest/wordpress/cartzilla/assets/images/screenshots/helpcenter.jpg',
            'import_notice'                => esc_html__( 'Import process may take 3-5 minutes. If you facing any issues please contact our support.', 'cartzilla' ),
            'preview_url'                  => 'https://demo.madrasthemes.com/cartzilla-helpcenter/',
        ),
    ) );
}

function cartzilla_ocdi_after_import_setup( $selected_import ) {

    // Assign menus to their locations.
    if ( 'Cartzilla - Grocery' === $selected_import['import_file_name'] ) {
        $primary                        = get_term_by( 'name', 'Main Menu', 'nav_menu' );
        $handheld                       = get_term_by( 'name', 'Main Menu', 'nav_menu' );
        $footer                         = get_term_by( 'name', 'Footer', 'nav_menu' );
        $departments                    = get_term_by( 'name', 'Shop Departments', 'nav_menu' );
        $social_media                   = get_term_by( 'name', 'Social Media', 'nav_menu' );
    } elseif( 'Cartzilla - Help Center' === $selected_import['import_file_name'] ) {
        $primary                        = get_term_by( 'name', 'Documentation Menu', 'nav_menu' );
        $handheld                       = get_term_by( 'name', 'Documentation Menu', 'nav_menu' );
        $footer                         = get_term_by( 'name', 'Footer', 'nav_menu' );
        $departments                    = get_term_by( 'name', 'Departments', 'nav_menu' );
        $social_media                   = get_term_by( 'name', 'Social Media', 'nav_menu' );
    } else {
        $primary                        = get_term_by( 'name', 'Primary', 'nav_menu' );
        $handheld                       = get_term_by( 'name', 'Handheld', 'nav_menu' );
        $footer                         = get_term_by( 'name', 'Footer', 'nav_menu' );
        $departments                    = get_term_by( 'name', 'Departments', 'nav_menu' );
        $social_media                   = get_term_by( 'name', 'Social Media', 'nav_menu' );
    }

    $nav_menu_locations = array(
        'primary'                   => $primary->term_id,
        'handheld'                  => $handheld->term_id,
        'footer'                    => $footer->term_id,
        'departments'               => $departments->term_id,
        'social_media'              => $social_media->term_id,
    );

    if ( 'Cartzilla - Fashion' === $selected_import['import_file_name'] ) {
        unset( $nav_menu_locations['departments'] );
    }

    set_theme_mod( 'nav_menu_locations', $nav_menu_locations );

    // Assign front page and posts page (blog page) and other pages
    $front_page_id                  = get_page_by_title( 'Fashion Store v.1' );
    $blog_page_id                   = get_page_by_title( 'Blog' );
    $shop_page_id                   = get_page_by_title( 'Shop' );
    $cart_page_id                   = get_page_by_title( 'Cart' );
    $checkout_page_id               = get_page_by_title( 'Checkout' );
    $myaccount_page_id              = get_page_by_title( 'My account' );
    $wishlist_page_id               = get_page_by_title( 'Wishlist' );

    if ( 'Cartzilla - Electronics' === $selected_import['import_file_name'] ) {
        $front_page_id = get_page_by_title( 'Home' );
        cartzilla_ocdi_import_wpforms( 'electronics' );

        if( cartzilla_is_mas_wcvs_activated() ) {
            cartzilla_ocdi_import_after_mas_wcvs_setup();
        }
    } elseif ( 'Cartzilla - Marketplace' === $selected_import['import_file_name'] ) {
        $front_page_id = get_page_by_title( 'Home' );
        cartzilla_ocdi_import_wpforms( 'marketplace' );
        cartzilla_ocdi_import_after_dokan_setup();
    } elseif ( 'Cartzilla - Grocery' === $selected_import['import_file_name'] ) {
        $front_page_id = get_page_by_title( 'Home' );
        cartzilla_ocdi_import_wpforms( 'grocery' );
    } elseif ( 'Cartzilla - Fashion' === $selected_import['import_file_name'] ) {
        cartzilla_ocdi_import_wpforms( 'main' );

        if( cartzilla_is_mas_wcvs_activated() ) {
            cartzilla_ocdi_import_after_mas_wcvs_setup();
        }
    } elseif ( 'Cartzilla - Help Center' === $selected_import['import_file_name'] ) {
        $settings = get_option( 'wedocs_settings', [] );
        if ( isset( $settings['docs_home'] ) ) {
            wp_delete_post( $settings['docs_home'], true );
        }
        $front_page_id = get_page_by_title( 'Documentation' );
        $settings['docs_home'] = $front_page_id->ID;
        update_option( 'wedocs_settings', $settings );
    }

    update_option( 'show_on_front', 'page' );
    update_option( 'page_on_front', $front_page_id->ID );
    update_option( 'page_for_posts', $blog_page_id->ID );
    update_option( 'woocommerce_shop_page_id', $shop_page_id->ID );
    update_option( 'woocommerce_cart_page_id', $cart_page_id->ID );
    update_option( 'woocommerce_checkout_page_id', $checkout_page_id->ID );
    update_option( 'woocommerce_myaccount_page_id', $myaccount_page_id->ID );
    update_option( 'yith_wcwl_wishlist_page_id', $wishlist_page_id->ID );

    // Enable Registration on "My Account" page
    update_option( 'woocommerce_enable_myaccount_registration', 'yes' );

    // Update Wishlist Position
    update_option( 'yith_wcwl_button_position', 'shortcode' );

    // Assign MAS Brand Attribute
    update_option( 'mas_wc_brands_brand_taxonomy', 'pa_brands' );

    if ( function_exists( 'wc_delete_product_transients' ) ) {
        wc_delete_product_transients();
    }
    if ( function_exists( 'wc_delete_shop_order_transients' ) ) {
        wc_delete_shop_order_transients();
    }
    if ( function_exists( 'wc_delete_expired_transients' ) ) {
        wc_delete_expired_transients();
    }

}

function cartzilla_ocdi_before_widgets_import() {

    $sidebars_widgets = get_option('sidebars_widgets');
    $all_widgets = array();

    array_walk_recursive( $sidebars_widgets, function ($item, $key) use ( &$all_widgets ) {
        if( ! isset( $all_widgets[$key] ) ) {
            $all_widgets[$key] = $item;
        } else {
            $all_widgets[] = $item;
        }
    } );

    if( isset( $all_widgets['array_version'] ) ) {
        $array_version = $all_widgets['array_version'];
        unset( $all_widgets['array_version'] );
    }

    $new_sidebars_widgets = array_fill_keys( array_keys( $sidebars_widgets ), array() );

    $new_sidebars_widgets['wp_inactive_widgets'] = $all_widgets;
    if( isset( $array_version ) ) {
        $new_sidebars_widgets['array_version'] = $array_version;
    }

    update_option( 'sidebars_widgets', $new_sidebars_widgets );
}


function cartzilla_ocdi_wp_import_post_data_processed( $postdata, $data ) {
    $site_upload_dir_find_urls = array(
        'https://demo.madrasthemes.com/cartzilla/wp-content/uploads/sites/73',
        'https://demo.madrasthemes.com/cartzilla-electronics/wp-content/uploads/sites/76',
        'https://demo.madrasthemes.com/cartzilla-marketplace/wp-content/uploads/sites/74',
        'https://demo.madrasthemes.com/cartzilla-grocery/wp-content/uploads/sites/75',
        'https://demo.madrasthemes.com/cartzilla-helpcenter/wp-content/uploads/sites/78',
    );
    $site_upload_dir_url = $upload_dir = wp_get_upload_dir();
    $postdata = str_replace( $site_upload_dir_find_urls, $site_upload_dir_url['baseurl'], $postdata );

    $site_content_find_urls = array(
        'https://demo.madrasthemes.com/cartzilla/wp-content/',
        'https://demo.madrasthemes.com/cartzilla-electronics/wp-content/',
        'https://demo.madrasthemes.com/cartzilla-marketplace/wp-content/',
        'https://demo.madrasthemes.com/cartzilla-grocery/wp-content/',
        'https://demo.madrasthemes.com/cartzilla-helpcenter/',
    );
    $site_content_url = content_url( '/' );
    $postdata = str_replace( $site_content_find_urls, $site_content_url, $postdata );

    $site_home_find_urls = array(
        'https://demo.madrasthemes.com/cartzilla/',
        'https://demo.madrasthemes.com/cartzilla-electronics/',
        'https://demo.madrasthemes.com/cartzilla-marketplace/',
        'https://demo.madrasthemes.com/cartzilla-grocery/',
        'https://demo.madrasthemes.com/cartzilla-helpcenter/',
    );
    $site_home_url = home_url( '/' );
    $postdata = str_replace( $site_home_find_urls, $site_home_url, $postdata );

    if( defined( 'PT_OCDI_VERSION' ) && version_compare( PT_OCDI_VERSION, '2.6.0' , '<' ) ) {
        return wp_slash( $postdata );
    }

    return $postdata;
}

function cartzilla_wp_import_post_meta_data_processed( $meta_item, $post_id ) {

    if( isset( $meta_item['value'] ) ) {
        $site_home_find_urls = array(
            'https://demo.madrasthemes.com/cartzilla/',
            'https://demo.madrasthemes.com/cartzilla-electronics/',
            'https://demo.madrasthemes.com/cartzilla-marketplace/',
            'https://demo.madrasthemes.com/cartzilla-grocery/',
            'https://demo.madrasthemes.com/cartzilla-helpcenter/',
        );
        $site_home_url = home_url( '/' );
        $meta_item['value'] = str_replace( $site_home_find_urls, $site_home_url, $meta_item['value'] );
    }

    return $meta_item;
}

function cartzilla_ocdi_confirmation_dialog_options( $options ) {
    $tgmpa_instance = call_user_func( array( get_class( $GLOBALS['tgmpa'] ), 'get_instance' ) );
    $selected_demo = get_option( 'cartzilla_tgmpa_selected_demo', '' );

    $dialogClass = 'wp-dialog';

    if( true !== $tgmpa_instance->is_tgmpa_complete() ) {
        $dialogClass .= ' disable-import-btn';
    }

    return array_merge( $options, array(
        'dialogClass' => $dialogClass,
    ) );
}

function cartzilla_ocdi_plugin_intro_text( $default_text ) {
    ob_start();
    cartzilla_tgmpa_demo_selector_notice();
    $notice_info = ob_get_clean();

    return $default_text . $notice_info;
}

if( ! function_exists( 'cartzilla_tgmpa_demo_selector_update' ) ) {
    function cartzilla_tgmpa_demo_selector_update() {

        if( isset( $_GET[ 'cartzilla_tgmpa_selected_demo' ] ) && in_array( $_GET[ 'cartzilla_tgmpa_selected_demo' ], array( 'main', 'grocery', 'marketplace', 'electronics', 'helpcenter' ) ) ) {
            update_option( 'cartzilla_tgmpa_selected_demo', strtolower( $_GET[ 'cartzilla_tgmpa_selected_demo' ] ) );
            // Redirect and strip query string.
            wp_redirect( esc_url_raw( admin_url( 'themes.php?page=pt-one-click-demo-import' ) ) );
        }
    }
}

if( ! function_exists( 'cartzilla_tgmpa_demo_selector_notice' ) ) {
    function cartzilla_tgmpa_demo_selector_notice() {
        $selected_demo = get_option( 'cartzilla_tgmpa_selected_demo', '' );
        $demos = array(
            'main'        => esc_html__( 'Fashion', 'cartzilla' ),
            'electronics' => esc_html__( 'Electronics', 'cartzilla' ),
            'marketplace' => esc_html__( 'Marketplace', 'cartzilla' ),
            'grocery'     => esc_html__( 'Grocery', 'cartzilla' ),
            'helpcenter'  => esc_html__( 'Help Center', 'cartzilla' ),
        );
        ?>
        <div id="cartzilla-tgmpa-demo-selector-notice" class="notice notice-info">
            <p><strong><?php esc_html_e( 'Cartzilla Select Demo', 'cartzilla' ); ?></strong> &#8211; <?php esc_html_e( 'We should select any one demo here to install recommended plugins.', 'cartzilla' ); ?></p>
            <p>
                <?php foreach ( $demos as $key => $value ) { ?>
                    <a href="<?php echo esc_url( add_query_arg( 'cartzilla_tgmpa_selected_demo', $key, admin_url( 'admin.php' ) ) ); ?>" class="button<?php echo esc_attr( $selected_demo == $key ? '-primary' : '' ); ?>"><?php echo esc_html( $value ); ?></a>
                <?php } ?>
            </p>
        </div>
        <?php
    }
}

function cartzilla_ocdi_admin_styles() {
    $selected_demo = get_option( 'cartzilla_tgmpa_selected_demo', '' );

    if( $selected_demo == 'main' ) {
        $selected_demo = 'cartzilla - fashion';
    } elseif ( $selected_demo == 'marketplace' ) {
        $selected_demo = 'cartzilla - marketplace';
    } elseif ( $selected_demo == 'electronics' ) {
        $selected_demo = 'cartzilla - electronics';
    } elseif ( $selected_demo == 'grocery' ) {
        $selected_demo = 'cartzilla - grocery';
    } elseif( $selected_demo == 'helpcenter' ) {
        $selected_demo = 'cartzilla - help center';
    }

    $style = "
    .js-ocdi-gl-item-container .js-ocdi-gl-item:not([data-name='" . $selected_demo . "']):not([data-name='']) .button-primary,
    .wp-dialog:not(.disable-import-btn) .cartzilla-ocdi-install-plugin-instructions,
    .wp-dialog.disable-import-btn .cartzilla-ocdi-import-instructions,
    .wp-dialog.disable-import-btn .ui-dialog-buttonpane button.button-primary {
        display: none;
    }
    ";
    wp_add_inline_style( 'ocdi-main-css', $style );
}


function cartzilla_ocdi_import_wpforms( $demo_path = 'main' ) {
    if ( ! function_exists( 'wpforms' ) ) {
        return;
    }

    $forms = [
        [
            'file' => 'wpforms-contact-form.json'
        ],
        [
            'file' => 'wpforms-CV-form.json'
        ],
        [
            'file' => 'wpforms-subscribe-form.json'
        ],
    ];

    foreach ( $forms as $form ) {
        ob_start();
        cartzilla_get_template( $form['file'], array(), 'assets/dummy-data/' . $demo_path . '/wpforms/' );
        $form_json = ob_get_clean();
        $form_data = json_decode( $form_json, true );

        if ( empty( $form_data[0] ) ) {
            continue;
        }
        $form_data = $form_data[0];
        $form_title = $form_data['settings']['form_title'];

        if( !empty( $form_data['id'] ) ) {
            $form_content = array(
                'field_id' => '0',
                'settings' => array(
                    'form_title' => sanitize_text_field( $form_title ),
                    'form_desc'  => '',
                ),
            );

            // Merge args and create the form.
            $form = array(
                'import_id'     => (int) $form_data['id'],
                'post_title'    => esc_html( $form_title ),
                'post_status'   => 'publish',
                'post_type'     => 'wpforms',
                'post_content'  => wpforms_encode( $form_content ),
            );

            $form_id = wp_insert_post( $form );
        } else {
            // Create initial form to get the form ID.
            $form_id   = wpforms()->form->add( $form_title );
        }

        if ( empty( $form_id ) ) {
            continue;
        }

        $form_data['id'] = $form_id;
        // Save the form data to the new form.
        wpforms()->form->update( $form_id, $form_data );
    }
}

function cartzilla_ocdi_import_after_dokan_setup() {
    $dokan_pages = get_option( 'dokan_pages' );

    $dashboard_page = get_page_by_title( 'Dashboard' );
    $my_order_page = get_page_by_title( 'My Orders' );
    $store_list_page = get_page_by_title( 'Store List' );

    if( isset( $dashboard_page->ID ) && $dashboard_page->ID > 0 ) {
        $dokan_pages['dashboard'] = $dashboard_page->ID;
    }

    if( isset( $my_order_page->ID ) && $my_order_page->ID > 0 ) {
        $dokan_pages['my_orders'] = $my_order_page->ID;
    }

    if( isset( $store_list_page->ID ) && $store_list_page->ID > 0 ) {
        $dokan_pages['store_listing'] = $store_list_page->ID;
    }

    update_option( 'dokan_pages', $dokan_pages );

    $products = wc_get_products( array(
        'limit' => 4,
        'orderby' => 'random'
    ) );

    $users_info = array(
        array(
            'user_data' =>  array(
                'role'       => 'seller',
                'user_login' => 'createx',
                'user_pass'  => wp_generate_password(),
            ),
            'store_data' => array(
                'store_name' => 'Createx',
                'enabled' => 'yes',
            ),
            'products' => array_slice( $products, 0, 2 )
        ),
        array(
            'user_data' =>  array(
                'role'       => 'seller',
                'user_login' => 'madrasthemes',
                'user_pass'  => wp_generate_password(),
            ),
            'store_data' => array(
                'store_name' => 'MadrasThemes',
                'enabled' => 'yes',
            ),
            'products' => array_slice( $products, 2, 2 )
        )
    );

    foreach ( $users_info as $key => $user_info ) {
        $user_id = wp_insert_user( $user_info['user_data'] );
        if ( ! is_wp_error( $user_id ) ) {
            // Update user meta
            $store_id = dokan()->vendor->update( $user_id, $user_info['store_data'] );

            // Update vendor of a product
            foreach ( $user_info['products'] as $key => $product ) {
                dokan_override_product_author( $product, $user_id );
            }
        }
    }

    $user_id = get_current_user_id();
    $store_data = array(
        'enabled' => 'yes',
    );
    $store_id = dokan()->vendor->update( $user_id, $store_data );
}

function cartzilla_ocdi_import_after_mas_wcvs_setup() {
    $attrubutes_to_update = array( 'color' => 'color', 'size' => 'label' );

    foreach ( $attrubutes_to_update as $name => $type ) {
        $id = wc_attribute_taxonomy_id_by_name( $name );
        $args = array(
            'type' => $type
        );
        wc_update_attribute( $id, $args );
    }
}

