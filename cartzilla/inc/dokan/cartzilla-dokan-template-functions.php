<?php
/**
 * Template dokan functions
 *
 * Typically functions used in dokan templates or hooked {@see template-hooks.php}
 *
 * @package Cartzilla
 */
if ( ! function_exists( 'cartzilla_dokan_enqueue_scripts' ) ) {
    function cartzilla_dokan_enqueue_scripts() {
        wp_dequeue_script( 'dokan-tooltip' );
        wp_enqueue_script( 'dokan-form-validate' );
        WeDevs\Dokan\Assets::load_form_validate_script();
        wp_enqueue_script( 'dokan-vendor-registration' );
    }
}

if ( ! function_exists( 'cartzilla_dokan_dashboard_page_conatiner_open' ) ) {
    function cartzilla_dokan_dashboard_page_conatiner_open() {
        ?><div class="container mb-5 pb-3"><div class="bg-light box-shadow-lg rounded-lg overflow-hidden"><?php
    }
}

if ( ! function_exists( 'cartzilla_dokan_dashboard_page_conatiner_close' ) ) {
    function cartzilla_dokan_dashboard_page_conatiner_close() {
        ?></div></div><?php
    }
}

if ( ! function_exists( 'cartzilla_dokan_dashboard_content_area_open' ) ) {
    function cartzilla_dokan_dashboard_content_area_open() {
        ?><article class="dashboard-content-area"><?php
    }
}

if ( ! function_exists( 'cartzilla_dokan_dashboard_content_area_close' ) ) {
    function cartzilla_dokan_dashboard_content_area_close() {
        ?></article><?php
    }
}

if ( ! function_exists( 'cartzilla_dokan_store_page_row_open' ) ) {
    function cartzilla_dokan_store_page_row_open() {
        ?><div class="row"><?php
    }
}

if ( ! function_exists( 'cartzilla_dokan_store_page_row_close' ) ) {
    function cartzilla_dokan_store_page_row_close() {
        ?></div><?php
    }
}

if ( ! function_exists( 'cartzilla_dokan_dashboard_page_title' ) ) {
    function cartzilla_dokan_dashboard_page_title( $user_id = null ) {
        if ( ! $user_id ) {
            $user_id = dokan_get_current_user_id();
        }

        $user_data = get_userdata( $user_id );
        $user_registered = $user_data->user_registered;
        $store_info = dokan_get_store_info( $user_id );
        $storename = isset( $store_info['store_name'] ) && ! empty( $store_info['store_name'] ) ? $store_info['store_name'] : ( is_object( $user_data ) ? $user_data->display_name : '' );
        $gravatar_url = get_avatar_url( $user_id );
        $orders_count = ! empty( dokan_count_orders( $user_id ) ) ? dokan_count_orders( $user_id )->total : 0;
        $rating = dokan_get_seller_rating($user_id);

        $store_time_enabled = isset( $store_info['dokan_store_time_enabled'] ) ? $store_info['dokan_store_time_enabled'] : '';
        $store_open_notice = isset( $store_info['dokan_store_open_notice'] ) && ! empty( $store_info['dokan_store_open_notice'] ) ? $store_info['dokan_store_open_notice'] : esc_html__( 'Store Open', 'cartzilla' );
        $store_closed_notice = isset( $store_info['dokan_store_close_notice'] ) && ! empty( $store_info['dokan_store_close_notice'] ) ? $store_info['dokan_store_close_notice'] : esc_html__( 'Store Closed', 'cartzilla' );
        $show_store_open_close = dokan_get_option( 'store_open_close', 'dokan_appearance', 'on' );

        ?>
        <div class="page-title-overlap bg-accent pt-4">
            <div class="container d-flex flex-wrap flex-sm-nowrap justify-content-center justify-content-sm-between align-items-center pt-2">
                <div class="media media-ie-fix align-items-center pb-3">
                    <div class="img-thumbnail rounded-circle position-relative" style="width: 6.375rem;">
                        <?php if ( dokan_is_store_page () ) : ?>
                            <img class="rounded-circle w-100" src="<?php echo esc_url( $gravatar_url ); ?>" alt="<?php echo esc_attr( $storename ); ?>">
                        <?php else : ?>
                            <a href="<?php echo esc_url( dokan_get_store_url( $user_id ) ); ?>">
                                <img class="rounded-circle w-100" src="<?php echo esc_url( $gravatar_url ); ?>" alt="<?php echo esc_attr( $storename ); ?>">
                            </a>
                        <?php endif; ?>
                    </div>
                    <div class="media-body pl-3">
                        <?php if ( dokan_is_store_page () ) : ?>
                            <h3 class="text-light font-size-lg mb-0">
                                <?php echo esc_html( $storename ); ?>
                            </h3>
                        <?php else : ?>
                            <a href="<?php echo esc_url( dokan_get_store_url( $user_id ) ); ?>">
                                <h3 class="text-light font-size-lg mb-0">
                                    <?php echo esc_html( $storename ); ?>
                                </h3>
                            </a>
                        <?php endif; ?>
                        <span class="d-block text-light font-size-ms opacity-60 py-1">
                            <?php echo sprintf( esc_html__( "Member since %s.", 'cartzilla' ), date( "M Y", strtotime( $user_registered ) ) ); ?>
                        </span>
                        <?php if ( $show_store_open_close == 'on' && $store_time_enabled == 'yes') : ?>
                            <?php if ( dokan_is_store_open( $user_id ) ) : ?>
                                <span class="badge badge-success">
                                    <i class="czi-check mr-1"></i>
                                    <?php echo esc_attr( $store_open_notice ); ?>
                                </span>
                            <?php else : ?>
                                <span class="badge badge-danger">
                                    <i class="czi-close mr-1"></i>
                                    <?php echo esc_attr( $store_closed_notice ); ?>
                                </span>
                            <?php endif; ?>
                            </li>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="d-flex">
                    <div class="text-sm-right">
                        <div class="text-light font-size-base">
                            <?php esc_html_e( 'Total sales', 'cartzilla' ); ?>
                        </div>
                        <h3 class="text-light"><?php echo esc_html( $orders_count ); ?></h3>
                    </div>
                    <?php if( ! empty( $rating ) && $rating['count'] > 0 ) : ?>
                        <div class="text-sm-right ml-5">
                            <div class="text-light font-size-base">
                                <?php esc_html_e( 'Seller rating', 'cartzilla' ); ?>
                            </div>
                            <div class="star-rating">
                                <?php for ($i=0; $i < 5 ; $i++) : ?>
                                    <i class="sr-star <?php echo esc_attr( $rating['rating'] > $i ? 'czi-star-filled active' : 'czi-star' ); ?>"></i>
                                <?php endfor; ?>
                            </div>
                            <div class="text-light opacity-60 font-size-xs">
                                <?php
                                    $rating_count = absint( $rating['count'] );
                                    echo sprintf( _n( 'Based on %d review', 'Based on %d reviews', $rating_count, 'cartzilla' ), number_format_i18n( $rating_count ) );
                                ?>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <?php
    }
}

if ( ! function_exists( 'cartzilla_dokan_dashboard_sales_widgets_title' ) ) {
    function cartzilla_dokan_dashboard_sales_widgets_title() {
        ?><h2 class="h3 py-2 text-center text-sm-left"><?php
            echo apply_filters( 'cartzilla_dokan_dashboard_sales_widgets_title', esc_html__( 'Your sales / earnings', 'cartzilla' ) );
        ?></h2><?php
    }
}

if ( ! function_exists( 'cartzilla_dokan_dashboard_remove_default_widgets' ) ) {
    function cartzilla_dokan_dashboard_remove_default_widgets() {
        $dokan = dokan();
        $dokan_dashboard = $dokan->dashboard->templates->dashboard;
        remove_action( 'dokan_dashboard_left_widgets', array( $dokan_dashboard, 'get_big_counter_widgets' ), 10 );
        remove_action( 'dokan_dashboard_left_widgets', array( $dokan_dashboard, 'get_orders_widgets' ), 15 );
        remove_action( 'dokan_dashboard_left_widgets', array( $dokan_dashboard, 'get_products_widgets' ), 20 );
        remove_action( 'dokan_dashboard_right_widgets', array( $dokan_dashboard, 'get_sales_report_chart_widget' ), 10 );
        if( cartzilla_is_dokan_pro_activated() ) {
            $dokan_pro = dokan_pro();
            if( version_compare( $dokan_pro->version, '3.0.0' , '<' ) ) {
                $dokan_pro_dashboard = Dokan_Pro_Dashboard::init();
                remove_action( 'dokan_dashboard_left_widgets', array( $dokan_pro_dashboard, 'get_review_widget' ), 16 );
                remove_action( 'dokan_dashboard_right_widgets', array( $dokan_pro_dashboard, 'get_announcement_widget' ), 12 );
            } else {
                cartzilla_remove_class_action( 'dokan_dashboard_left_widgets', 'WeDevs\DokanPro\Dashboard', 'get_review_widget', 16 );
                cartzilla_remove_class_action( 'dokan_dashboard_right_widgets', 'WeDevs\DokanPro\Dashboard', 'get_announcement_widget', 12 );
            }

            if( version_compare( $dokan_pro->version, '3.0.0' , '<' ) ) {
                if( class_exists( 'Dokan_Pro_Settings' ) ) {
                    $dokan_pro_settings = Dokan_Pro_Settings::init();
                    remove_action( 'dokan_settings_form_bottom', array( $dokan_pro_settings, 'render_biography_form' ), 10, 2 );
                }
            } else {
                cartzilla_remove_class_action( 'dokan_settings_form_bottom', 'WeDevs\DokanPro\Settings', 'render_biography_form', 10 );
            }

            if( version_compare( $dokan_pro->version, '3.0.0' , '<' ) ) {
                if( class_exists( 'Dokan_Store_Support' ) ) {
                    $dokan_pro_store_support = Dokan_Store_Support::init();
                    remove_action( 'dokan_settings_form_bottom', array( $dokan_pro_store_support, 'add_support_btn_title_input' ), 13, 2 );
                }
            } else {
                cartzilla_remove_class_action( 'dokan_settings_form_bottom', 'WeDevs\DokanPro\Modules\StoreSupport\Module', 'add_support_btn_title_input', 13 );
            }

            if( version_compare( $dokan_pro->version, '3.0.0' , '<' ) ) {
                if( class_exists( 'Dokan_Live_Chat_Seller_Settings' ) ) {
                    $dokan_pro_live_chat = Dokan_Live_Chat_Seller_Settings::init();
                    remove_action( 'dokan_settings_form_bottom', array( $dokan_pro_live_chat, 'dokan_live_chat_seller_settings' ), 15, 2 );
                }
            } else {
                cartzilla_remove_class_action( 'dokan_settings_form_bottom', 'WeDevs\DokanPro\Modules\LiveChat\Module', 'dokan_live_chat_seller_settings', 15 );
            }

            if( class_exists( 'Dokan_Seller_Vacation_Store_Settings' ) ) {
                cartzilla_remove_class_action( 'dokan_settings_form_bottom', 'Dokan_Seller_Vacation_Store_Settings', 'store_settings_form', 10 );
            }

            if( version_compare( $dokan_pro->version, '3.0.0' , '<' ) ) {
                if( class_exists( 'Dokan_Product_Subscription' ) ) {
                    $dokan_product_subscription = Dokan_Product_Subscription::init();
                    remove_action( 'dokan_before_listing_product', array( $dokan_product_subscription, 'show_custom_subscription_info' ) );
                    $enable_option = get_option( 'dokan_product_subscription', array( 'enable_pricing' => 'off' ) );
                    if ( !( !isset( $enable_option['enable_pricing'] ) || $enable_option['enable_pricing'] != 'on' ) ) {
                        add_action( 'dokan_before_listing_product_widgets', 'cartzilla_dokan_show_custom_subscription_info' );
                    }
                }
            } elseif( $dokan_pro->module->is_active( 'product_subscription' ) ) {
                cartzilla_remove_class_action( 'dokan_before_listing_product', 'WeDevs\DokanPro\Modules\ProductSubscription\Module', 'show_custom_subscription_info' );
                $enable_option = get_option( 'dokan_product_subscription', array( 'enable_pricing' => 'off' ) );
                    if ( !( !isset( $enable_option['enable_pricing'] ) || $enable_option['enable_pricing'] != 'on' ) ) {
                        add_action( 'dokan_before_listing_product_widgets', 'cartzilla_dokan_show_custom_subscription_info' );
                    }
            }
        }
        add_action( 'dokan_dashboard_left_widgets', array( $dokan_dashboard, 'get_sales_report_chart_widget' ), 10 );
        add_action( 'dokan_dashboard_right_widgets', array( $dokan_dashboard, 'get_orders_widgets' ), 10 );

        $dokan_settings = $dokan->dashboard->templates->settings;
        remove_action( 'dokan_settings_content_area_header', array( $dokan_settings, 'render_settings_header' ), 10 );
        remove_action( 'dokan_settings_content_area_header', array( $dokan_settings, 'render_settings_help' ), 15 );
        remove_action( 'dokan_settings_content_area_header', array( $dokan_settings, 'render_settings_load_progressbar' ), 20 );
        remove_action( 'dokan_settings_content_area_header', array( $dokan_settings, 'render_settings_store_errors' ), 25 );

        add_action( 'dokan_settings_content_area_header', array( $dokan_settings, 'render_settings_help' ), 30 );
        add_action( 'dokan_settings_content_area_header', array( $dokan_settings, 'render_settings_load_progressbar' ), 40 );
        add_action( 'dokan_settings_content_area_header', array( $dokan_settings, 'render_settings_store_errors' ), 50 );
    }
}

if ( ! function_exists( 'cartzilla_dokan_dashboard_sales_overview_widget' ) ) {
    function cartzilla_dokan_dashboard_sales_overview_widget() {
        $user_id = dokan_get_current_user_id();
        $seller_balance = dokan_get_seller_balance( $user_id );
        $total_sales = dokan_author_total_sales( $user_id );
        $this_month_orders = cartzilla_dokan_report_data( 'day', '', '', '', $user_id );
        $this_month_sales = !empty( $this_month_orders ) && is_array( $this_month_orders ) && !empty( $this_month_orders[0] ) ? $this_month_orders[0]->order_total : 0;
        $this_month_start = date( 'n/j/Y', strtotime( date( 'Ym', current_time( 'timestamp' ) ) . '01' ) );
        $current_date = date( 'n/j/Y', current_time( 'timestamp' ) );
        ?>
        <div class="row mx-n2 pt-2">
            <div class="col-md-4 col-sm-6 px-2 mb-4">
                <div class="bg-secondary h-100 rounded-lg p-4 text-center">
                    <h3 class="font-size-sm text-muted">
                        <?php echo esc_html__( 'Earnings (this month)', 'cartzilla' ); ?>
                    </h3>
                    <p class="h2 mb-2"><?php echo wc_price( $this_month_sales ); ?></p>
                    <p class="font-size-ms text-muted mb-0"><?php echo sprintf( esc_html__( "Sales %s - %s", 'cartzilla' ), $this_month_start, $current_date ); ?></p>
                </div>
            </div>
            <div class="col-md-4 col-sm-6 px-2 mb-4">
                <div class="bg-secondary h-100 rounded-lg p-4 text-center">
                    <h3 class="font-size-sm text-muted">
                        <?php echo esc_html__( 'Your balance', 'cartzilla' ); ?>
                    </h3>
                    <p class="h2 mb-2"><?php echo wp_kses_post( $seller_balance ); ?></p>
                    <p class="font-size-ms text-muted mb-0"><?php echo sprintf( esc_html__( "To be paid on %s", 'cartzilla' ), $current_date ); ?></p>
                </div>
            </div>
            <div class="col-md-4 col-sm-12 px-2 mb-4">
                <div class="bg-secondary h-100 rounded-lg p-4 text-center">
                    <h3 class="font-size-sm text-muted">
                        <?php echo esc_html__( 'Lifetime earnings', 'cartzilla' ); ?>
                    </h3>
                    <p class="h2 mb-2"><?php echo wc_price( $total_sales ); ?></p>
                    <p class="font-size-ms text-muted mb-0"><?php echo esc_html__( 'Based on list price', 'cartzilla' ); ?></p>
                </div>
            </div>
        </div>
        <?php
    }
}

if ( ! function_exists( 'cartzilla_dokan_modify_dashboard_nav' ) ) {
    function cartzilla_dokan_modify_dashboard_nav( $urls ) {
        $user_id = dokan_get_current_user_id();
        $seller_balance = dokan_get_seller_balance( $user_id );
        $settings_sub_urls = $urls['settings']['sub'];
        unset($urls['settings']['sub'] );
        $urls = array_merge( $urls, $settings_sub_urls );

        $urls['account'] = array(
            'title'     => esc_html__( 'Account', 'cartzilla'),
            'divider'   => true,
            'pos'       => 2,
        );

        $urls['seller-dashboard'] = array(
            'title'     => esc_html__( 'Seller Dashboard', 'cartzilla'),
            'divider'   => true,
            'pos'       => 8,
        );

        $urls['settings']['title'] = esc_html__( 'Settings', 'cartzilla');
        $urls['settings']['icon'] = '<i class="czi-settings opacity-60 mr-2"></i>';
        $urls['settings']['pos'] = 4;

        $urls['orders']['title'] = esc_html__( 'Purchases', 'cartzilla');
        $urls['orders']['icon'] = '<i class="czi-basket opacity-60 mr-2"></i>';
        $urls['orders']['pos'] = 6;

        $urls['dashboard']['title'] = esc_html__( 'Sales', 'cartzilla') . '<span class="font-size-sm text-muted ml-auto">' . $seller_balance . '</span>';
        $urls['dashboard']['icon'] = '<i class="czi-dollar opacity-60 mr-2"></i>';

        $urls['products']['icon'] = '<i class="czi-package opacity-60 mr-2"></i>';
        $urls['withdraw']['icon'] = '<i class="czi-currency-exchange opacity-60 mr-2"></i>';

        if( isset( $urls['followers'] ) ) {
            $urls['followers']['icon'] = '<i class="czi-heart opacity-60 mr-2"></i>';
        }

        if( isset( $urls['coupons'] ) ) {
            $urls['coupons']['icon'] = '<i class="czi-discount opacity-60 mr-2"></i>';
        }

        if( isset( $urls['reviews'] ) ) {
            $urls['reviews']['icon'] = '<i class="czi-chat opacity-60 mr-2"></i>';
        }

        if( isset( $urls['reports'] ) ) {
            $urls['reports']['icon'] = '<i class="czi-document opacity-60 mr-2"></i>';
        }

        if( isset( $urls['support'] ) ) {
            $urls['support']['icon'] = '<i class="czi-support opacity-60 mr-2"></i>';
        }

        if( isset( $urls['tools'] ) ) {
            $urls['tools']['icon'] = '<i class="czi-filter-alt opacity-60 mr-2"></i>';
        }

        if( isset( $urls['verification'] ) ) {
            $urls['verification']['icon'] = '<i class="czi-check-circle opacity-60 mr-2"></i>';
        }

        if( isset( $urls['shipping'] ) ) {
            $urls['shipping']['icon'] = '<i class="czi-delivery opacity-60 mr-2"></i>';
        }

        if( isset( $urls['shipstation'] ) ) {
            $urls['shipstation']['icon'] = '<i class="czi-store opacity-60 mr-2"></i>';
        }

        if( isset( $urls['social'] ) ) {
            $urls['social']['icon'] = '<i class="czi-share-alt opacity-60 mr-2"></i>';
        }

        if( isset( $urls['seo'] ) ) {
            $urls['seo']['icon'] = '<i class="czi-globe opacity-60 mr-2"></i>';
        }

        if( isset( $urls['rma'] ) ) {
            $urls['rma']['icon'] = '<i class="czi-loading opacity-60 mr-2"></i>';
        }

        if( isset( $urls['return-request'] ) ) {
            $urls['return-request']['icon'] = '<i class="czi-reload opacity-60 mr-2"></i>';
        }

        unset( $urls['store'] );
        unset( $urls['payment'] );
        unset( $urls['back'] );

        return $urls;
    }
}

if ( ! function_exists( 'cartzilla_dokan_settings_content_area_title' ) ) {
    function cartzilla_dokan_settings_content_area_title() {
        global $wp;

        $settings_query_var = isset( $wp->query_vars['settings'] ) ? $wp->query_vars['settings'] : ( isset( $wp->query_vars['edit-account'] ) ? $wp->query_vars['edit-account'] : '' );

        $heading = apply_filters( 'dokan_dashboard_settings_heading_title', esc_html__( 'Settings', 'cartzilla' ), $settings_query_var );

        ?><h2 class="h3 py-2 text-center text-sm-left"><?php echo wp_kses_post( $heading ); ?></h2><?php
    }
}

if ( ! function_exists( 'cartzilla_dokan_settings_content_area_nav' ) ) {
    function cartzilla_dokan_settings_content_area_nav() {
        global $wp;
        $settings_tab_nav = apply_filters( 'cartzilla_dokan_settings_tab_nav', array(
            'store' => array(
                'title'      => esc_html__( 'Store Profile', 'cartzilla'),
                'icon_class' => 'czi-store',
                'url'        => dokan_get_navigation_url( 'settings/store' ),
                'pos'        => 10,
                'permission' => 'dokan_view_store_settings_menu'
            ),
            'edit-profile' => array(
                'title'      => esc_html__( 'Vendor Profile', 'cartzilla'),
                'icon_class' => 'czi-user',
                'url'        => dokan_get_navigation_url( 'edit-account' ),
                'pos'        => 20,
            ),
            'payment' => array(
                'title'      => esc_html__( 'Payments methods', 'cartzilla'),
                'icon_class' => 'czi-card',
                'url'        => dokan_get_navigation_url( 'settings/payment' ),
                'pos'        => 30,
                'permission' => 'dokan_view_store_payment_menu'
            ),
        ) );

        if( !empty( $settings_tab_nav ) && is_array( $settings_tab_nav ) && ( isset( $wp->query_vars['settings'] ) && in_array( $wp->query_vars['settings'], [ 'store', 'payment' ] ) || isset( $wp->query_vars['edit-account'] ) ) ) :
            $active_menu = isset( $wp->query_vars['settings'] ) ? $wp->query_vars['settings'] : ( isset( $wp->query_vars['edit-account'] ) ? 'edit-profile' : 'store' );
            ?>
            <ul class="nav nav-tabs nav-justified align-items-end">
                <?php foreach( $settings_tab_nav as $key => $item ) : ?>
                    <li class="nav-item">
                        <a href="<?php echo esc_attr( $item['url'] ); ?>" class="nav-link px-0<?php if( $active_menu == $key ) echo esc_attr( ' active' ); ?>">
                            <div class="d-none d-lg-block">
                                <?php if( isset( $item['icon_class'] ) && ! empty( $item['icon_class'] ) ) : ?>
                                    <i class="<?php echo esc_attr( $item['icon_class'] ); ?> opacity-60 mr-2"></i>
                                <?php endif;
                                if( isset( $item['title'] ) && ! empty( $item['title'] ) ) {
                                    echo wp_kses_post( $item['title'] );
                                } ?>
                            </div>
                            <div class="d-lg-none text-center">
                                <?php if( isset( $item['icon_class'] ) && ! empty( $item['icon_class'] ) ) : ?>
                                    <i class="<?php echo esc_attr( $item['icon_class'] ); ?> opacity-60 d-block font-size-xl mb-2"></i>
                                <?php endif; ?>
                                <?php if( isset( $item['title'] ) && ! empty( $item['title'] ) ) : ?>
                                    <span class="font-size-ms"><?php echo wp_kses_post( $item['title'] ); ?></span>
                                <?php endif; ?>
                            </div>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>
            <?php
        endif;
    }
}

if ( ! function_exists( 'cartzilla_dokan_withdraw_methods' ) ) {
    function cartzilla_dokan_withdraw_methods( $methods ) {
        if( isset( $methods['paypal'] ) ) {
            $methods['paypal']['callback'] = 'cartzilla_dokan_withdraw_method_paypal';
        }

        if( isset( $methods['bank'] ) ) {
            $methods['bank']['callback'] = 'cartzilla_dokan_withdraw_method_bank';
        }

        if( isset( $methods['skrill'] ) ) {
            $methods['skrill']['callback'] = 'cartzilla_dokan_withdraw_method_skrill';
        }

        return $methods;
    }
}

if ( ! function_exists( 'cartzilla_dokan_render_biography_form' ) ) {
    function cartzilla_dokan_render_biography_form( $vendor_id, $store_info ) {
        if( cartzilla_is_dokan_pro_activated() ) {
            $biography = ! empty( $store_info['vendor_biography'] ) ? $store_info['vendor_biography'] : '';
            ?>
            <div class="col-12">
                <div class="form-group">
                    <label for="vendor_biography"><?php esc_html_e( 'Biography', 'cartzilla' ); ?></label>
                    <?php
                        wp_editor( $biography, 'vendor_biography', [
                            'quicktags' => false
                        ] );
                    ?>
                </div>
            </div>
            <?php
        }
    }
}

if ( ! function_exists( 'cartzilla_dokan_add_support_btn_title_input' ) ) {
    function cartzilla_dokan_add_support_btn_title_input( $vendor_id, $store_info ) {
        if( cartzilla_is_dokan_pro_activated() ) {
            if( class_exists( 'Dokan_Store_Support' ) || ( version_compare( dokan_pro()->version, '3.0.0' , '>=' ) && dokan_pro()->module->is_active( 'store_support' ) ) ) {
                $support_text = isset( $profile_info['support_btn_name'] ) ? $profile_info['support_btn_name'] : '';
                $enable_support = isset( $profile_info['show_support_btn'] ) ? $profile_info['show_support_btn'] : 'yes';
                ?>
                <div class="col-12">
                    <div class="form-group">
                        <label><?php esc_html_e( 'Enable Support' , 'cartzilla' ) ?></label>
                        <div class="custom-control custom-checkbox d-block">
                            <input type="hidden" name="support_checkbox" value="no">
                            <input type="checkbox" id="support_checkbox" class="custom-control-input" name="support_checkbox" value="yes" <?php checked( $enable_support, 'yes' ); ?>>
                            <label class="custom-control-label" for="support_checkbox"><?php esc_html_e( 'Show support button in store', 'cartzilla' ); ?></label>
                        </div>
                    </div>
                </div>

                <div class="col-12">
                    <div class="form-group support-enable-check">
                        <label for="dokan_support_btn_name"><?php esc_html_e( 'Support Button text', 'cartzilla' ); ?></label>
                        <input id="dokan_support_btn_name" value="<?php echo wp_kses_post( $support_text ); ?>" name="dokan_support_btn_name" placeholder="<?php esc_html_e( 'Get Support', 'cartzilla'); ?>" class="form-control" type="text">
                        </div>
                    </div>
                <?php
            }
        }
    }
}
if ( ! function_exists( 'cartzilla_dokan_live_chat_seller_settings' ) ) {
    function cartzilla_dokan_live_chat_seller_settings( $vendor_id, $store_info ) {
        if( cartzilla_is_dokan_pro_activated() ) {
            if( ( class_exists( 'Dokan_Live_Chat_Seller_Settings' ) || ( version_compare( dokan_pro()->version, '3.0.0' , '>=' ) && dokan_pro()->module->is_active( 'live_chat' ) ) ) && dokan_get_option( 'enable', 'dokan_live_chat' ) === 'on' ) {
                $enable_chat = isset( $profile['live_chat'] ) ? $profile['live_chat'] : 'no';
                ?>
                <div class="col-12">
                    <div class="form-group">
                        <label><?php esc_html_e( 'Enable Live Chat' , 'cartzilla' ) ?></label>
                        <div class="custom-control custom-checkbox d-block">
                            <input type="hidden" name="live_chat" value="no">
                            <input type="checkbox" id="live_chat" class="custom-control-input" name="live_chat" value="yes" <?php checked( $enable_chat, 'yes' ); ?>>
                            <label class="custom-control-label" for="live_chat"><?php esc_html_e( 'Enable Live Chat', 'cartzilla'); ?></label>
                        </div>
                    </div>
                </div>
                <?php
            }
        }
    }
}

if ( ! function_exists( 'cartzilla_dokan_store_settings_form' ) ) {
    function cartzilla_dokan_store_settings_form( $current_user, $profile_info ) {
        if( class_exists( 'Dokan_Seller_Vacation_Store_Settings' ) ) {
            $closing_style_options = array(
                'instantly' => esc_html__( 'Instantly Close', 'cartzilla' ),
                'datewise'  => esc_html__( 'Date Wise Close', 'cartzilla' ),
            );

            $setting_go_vacation      = isset( $profile_info['setting_go_vacation'] ) ? esc_attr( $profile_info['setting_go_vacation'] ) : 'no';
            $settings_closing_style   = isset( $profile_info['settings_closing_style'] ) ? esc_attr( $profile_info['settings_closing_style'] ) : 'open';
            $setting_vacation_message = isset( $profile_info['setting_vacation_message'] ) ? esc_attr( $profile_info['setting_vacation_message'] ) : '';

            $show_schedules            = dokan_validate_boolean( $setting_go_vacation ) && ( 'datewise' === $settings_closing_style );
            $seller_vacation_schedules = dokan_seller_vacation_get_vacation_schedules( $profile_info );

            dokan_get_template(
                'store-settings.php',
                array(
                    'closing_style_options'     => $closing_style_options,
                    'setting_go_vacation'       => $setting_go_vacation,
                    'settings_closing_style'    => $settings_closing_style,
                    'setting_vacation_message'  => $setting_vacation_message,
                    'show_schedules'            => $show_schedules,
                    'seller_vacation_schedules' => $seller_vacation_schedules,
                ),
                '',
                trailingslashit( DOKAN_SELLER_VACATION_VIEWS )
            );
        }
    }
}

if ( ! function_exists( 'cartzilla_dokan_show_custom_subscription_info' ) ) {
    function cartzilla_dokan_show_custom_subscription_info() {
        $vendor_id = dokan_get_current_user_id();

        if ( dokan_is_seller_enabled( $vendor_id ) ) {

            $remaining_product = Helper::get_vendor_remaining_products( $vendor_id );

            if ( '-1' === $remaining_product ) {
                return printf( '<p class="dokan-info">%s</p>', esc_html__( 'You can add unlimited products', 'cartzilla' ) );
            }

            if ( $remaining_product == 0 || ! ( get_user_meta( dokan_get_current_user_id(), 'can_post_product', true ) == '1' ) ) {

                if( defined('DOKAN_PLUGIN_VERSION')() ) {
                    $permalink = dokan_get_navigation_url( 'subscription' );
                } else {
                    $page_id   = dokan_get_option( 'subscription_pack', 'dokan_product_subscription' );
                    $permalink = get_permalink( $page_id );
                }
                $info = sprintf( __( 'Sorry! You can not add or publish any more product. Please <a href="%s">update your package</a>.', 'cartzilla' ), $permalink );
                echo "<p class='dokan-info'>" . wp_kses_post( $info ) . "</p>";
                echo "<style>.dokan-add-product-link{display : none !important}</style>";
            } else {
                echo "<p class='dokan-info'>" . wp_kses_post( sprintf( esc_html__( 'You can add %d more product(s).', 'cartzilla' ), $remaining_product ) ) . "</p>";
            }
        }
    }
}

if ( ! function_exists( 'cartzilla_dokan_before_listing_product_widgets_title' ) ) {
    function cartzilla_dokan_before_listing_product_widgets_title() {
        $heading = apply_filters( 'cartzilla_dokan_before_listing_product_widgets_title', esc_html__( 'Your Products', 'cartzilla' ) );

        ?><h2 class="h3 py-2 text-center text-sm-left"><?php echo wp_kses_post( $heading ); ?></h2><?php
    }
}

if ( ! function_exists( 'cartzilla_dokan_vendor_default_default_container_open' ) ) {
    function cartzilla_dokan_vendor_default_default_container_open() {
        if ( dokan_is_store_page () ) {
            ?><div class="container py-5"><?php
        }
    }
}

if ( ! function_exists( 'cartzilla_dokan_vendor_default_default_container_close' ) ) {
    function cartzilla_dokan_vendor_default_default_container_close() {
        if ( dokan_is_store_page () ) {
            ?></div><?php
        }
    }
}

if ( ! function_exists( 'cartzilla_dokan_store_page_aside' ) ) {
    function cartzilla_dokan_store_page_aside( $store_user ) {
        do_action( 'cartzilla_dokan_store_page_aside_before', $store_user );
        do_action( 'cartzilla_dokan_store_page_aside', $store_user );
        do_action( 'cartzilla_dokan_store_page_aside_after', $store_user );
    }
}

if ( ! function_exists( 'cartzilla_dokan_store_page_aside_open' ) ) {
    function cartzilla_dokan_store_page_aside_open() {
        ?><aside class="col-lg-4"><?php
    }
}

if ( ! function_exists( 'cartzilla_dokan_store_page_aside_inner_open' ) ) {
    function cartzilla_dokan_store_page_aside_inner_open() {
        ?><div class="cz-sidebar-static h-100 border-right"><?php
    }
}

if ( ! function_exists( 'cartzilla_dokan_store_page_aside_content' ) ) {
    function cartzilla_dokan_store_page_aside_content( $store_user ) {
        $store_info   = $store_user->get_shop_info();
        $map_location = $store_user->get_location();

        if ( dokan_get_option( 'enable_theme_store_sidebar', 'dokan_general', 'off' ) == 'off' ) {

            do_action( 'dokan_sidebar_store_before', $store_user->data, $store_info );

            if ( ! dynamic_sidebar( 'sidebar-store' ) ) {
                $args = array(
                    'before_widget' => '<aside class="widget dokan-store-widget %s">',
                    'after_widget'  => '</aside>',
                    'before_title'  => '<h3 class="widget-title">',
                    'after_title'   => '</h3>',
                );

                if ( dokan()->widgets->is_exists( 'store_location' ) && dokan_get_option( 'store_map', 'dokan_general', 'on' ) == 'on'  && ! empty( $map_location ) ) {
                    the_widget( dokan()->widgets->store_location, array( 'title' => esc_html__( 'Store Location', 'cartzilla' ) ), $args );
                }

                if ( dokan()->widgets->is_exists( 'store_open_close' ) && dokan_get_option( 'store_open_close', 'dokan_general', 'on' ) == 'on' ) {
                    the_widget( dokan()->widgets->store_open_close, array( 'title' => esc_html__( 'Store Time', 'cartzilla' ) ), $args );
                }

                if ( dokan()->widgets->is_exists( 'store_contact_form' ) && dokan_get_option( 'contact_seller', 'dokan_general', 'on' ) == 'on' ) {
                    the_widget( dokan()->widgets->store_contact_form, array( 'title' => esc_html__( 'Contact Vendor', 'cartzilla' ) ), $args );
                }
            }

            do_action( 'dokan_sidebar_store_after', $store_user->data, $store_info );

        } else {
            get_sidebar( 'store' );
        }
    }
}

if ( ! function_exists( 'cartzilla_dokan_store_page_aside_vendor_about' ) ) {
    function cartzilla_dokan_store_page_aside_vendor_about( $store_user, $store_info ) {
        if( apply_filters( 'cartzilla_dokan_store_page_display_author_descrion', true ) ) {
            $author_description = get_user_meta( $store_user->ID, 'description', true );
            if( !empty( $author_description ) ) {
                ?><aside class="widget dokan-store-widget sidebar-about">
                    <h6><?php echo apply_filters( 'cartzilla_dokan_store_page_aside_vendor_about_title', esc_html__( 'About', 'cartzilla' ) ); ?></h6>
                    <p class="font-size-ms text-muted mb-0">
                        <?php echo wp_kses_post( $author_description ); ?>
                    </p>
                </aside><?php
            }
        }
    }
}

if ( ! function_exists( 'cartzilla_dokan_store_page_aside_contact_info' ) ) {
    function cartzilla_dokan_store_page_aside_contact_info( $store_user, $store_info ) {
        $vendor_name = $store_user->data->display_name;
        $store_address = apply_filters( 'cartzilla_dokan_store_page_display_store_address', true ) ? dokan_get_seller_address( $store_user->ID, false ) : false;
        $show_store_email = $store_info['show_email'] === 'yes' ? true : false;
        $store_email = $show_store_email && $store_user && $store_user->data && $store_user->data->user_email ? $store_user->data->user_email : false;
        $store_website = $store_user->data->user_url;
        $store_phone = $store_info['phone'];
        $social_fields = dokan_get_social_profile_fields();
        $social_info = isset( $store_info['social'] ) ? $store_info['social'] : array();

        if( !empty( $store_address ) || !empty( $store_email ) || !empty( $store_phone ) || !empty( $store_website ) || !empty( array_filter( $social_info ) ) ) {
            ?>
            <aside class="widget dokan-store-widget sidebar-contact">
                <h6><?php echo apply_filters( 'cartzilla_dokan_store_page_aside_contact_info_title', esc_html__( 'Contacts', 'cartzilla' ) ); ?></h6>

                <?php if( !empty( $store_address ) ) : ?>
                    <div class="store-address mb-2">
                        <i class="czi-location opacity-60 mr-2"></i>
                        <span class="d-inline-block align-top"><?php echo wp_kses_post( $store_address ); ?></span>
                    </div>
                <?php endif; ?>
                <?php if ( !empty( $store_email ) || !empty( $store_phone ) || !empty( $store_website ) ) : ?>
                    <ul class="list-unstyled font-size-sm">
                        <?php if( !empty( $store_email ) ) : ?>
                            <li class="store-email">
                                <a href="<?php echo esc_url( 'mailto:' . $store_email ) ?>" class="d-inline-block">
                                    <i class="czi-mail opacity-60 mr-2"></i>
                                    <?php echo wp_kses_post( $store_email ); ?>
                                </a>
                            </li>
                        <?php endif; ?>
                        <?php if( !empty( $store_phone ) ) : ?>
                            <li class="store-phone">
                                <a href="<?php echo esc_url( 'tel:' . $store_phone ) ?>" class="d-inline-block">
                                    <i class="czi-phone opacity-60 mr-2"></i>
                                    <?php echo wp_kses_post( $store_phone ); ?>
                                </a>
                            </li>
                        <?php endif; ?>
                        <?php if( !empty( $store_website ) ) : ?>
                            <li class="store-website">
                                <a href="<?php echo esc_url( $store_website ) ?>" class="d-inline-block">
                                    <i class="czi-globe opacity-60 mr-2"></i>
                                    <?php echo wp_kses_post( $store_website ); ?>
                                </a>
                            </li>
                        <?php endif; ?>
                    </ul>
                    <?php if ( !empty( array_filter( $social_info ) ) ) : ?>
                        <div class="social-profiles mt-3">
                            <?php foreach( $social_fields as $key => $field ) { ?>
                                <?php if ( isset( $social_info[ $key ] ) && !empty( $social_info[ $key ] ) ) { ?>
                                    <a class="social-btn sb-<?php echo esc_attr( $key ); ?> sb-outline sb-sm mr-2 mb-2" href="<?php echo esc_url( $social_info[ $key ] ); ?>" target="_blank">
                                        <i class="<?php echo esc_attr( $field['icon'] ); ?>"></i>
                                    </a>
                                <?php } ?>
                            <?php } ?>
                        </div>
                    <?php endif; ?>
                <?php endif; ?>
            </aside>
            <?php
        }
    }
}

if ( ! function_exists( 'cartzilla_dokan_store_page_aside_store_buttons' ) ) {
    function cartzilla_dokan_store_page_aside_store_buttons($store_user, $store_info) {
        if( has_action( 'dokan_after_store_tabs' ) ) :
            ?><aside class="widget dokan-store-widget sidebar-dokan-buttons">
                <ul class="list-unstyled font-size-sm d-flex align-items-center flex-wrap"><?php
                    do_action( 'dokan_after_store_tabs', $store_user->ID );
                ?></ul>
            </aside><?php
        endif;
    }
}

if ( ! function_exists( 'cartzilla_dokan_store_page_aside_inner_close' ) ) {
    function cartzilla_dokan_store_page_aside_inner_close() {
        ?></div><?php
    }
}

if ( ! function_exists( 'cartzilla_dokan_store_page_aside_close' ) ) {
    function cartzilla_dokan_store_page_aside_close() {
        ?></aside><?php
    }
}

if ( ! function_exists( 'cartzilla_dokan_profile_social_fields' ) ) {
    function cartzilla_dokan_profile_social_fields( $fields ) {
        $fields['fb']['icon'] = 'czi-facebook';
        $fields['gplus']['icon'] = 'czi-google';
        $fields['twitter']['icon'] = 'czi-twitter';
        $fields['pinterest']['icon'] = 'czi-pinterest';
        $fields['linkedin']['icon'] = 'czi-linkedin';
        $fields['youtube']['icon'] = 'czi-youtube';
        $fields['instagram']['icon'] = 'czi-instagram';
        $fields['flickr']['icon'] = 'fab fa-flickr';
        return $fields;
    }
}

if ( ! function_exists( 'cartzilla_dokan_store_page_main_open' ) ) {
    function cartzilla_dokan_store_page_main_open() {
        ?><section class="col-lg-8 pt-lg-4 pb-md-4"><div class="pt-2 px-4 pl-lg-0 pr-xl-5"><?php
    }
}

if ( ! function_exists( 'cartzilla_dokan_store_page_main_tabs' ) ) {
    function cartzilla_dokan_store_page_main_tabs( $store_user ) {
        $store_tabs = dokan_get_store_tabs( $store_user->id );
        if ( $store_tabs ) :
            global $wp;
            $current_url = home_url( add_query_arg( array(), $wp->request ) );
            $pos = strpos($current_url , '/page');
            if ( ! empty( $pos ) ) $current_url = substr($current_url,0,$pos);

            $filtered_store_tabs = [];
            foreach( $store_tabs as $key => $tab ) :
                if ( is_array( $tab ) && ! empty( $tab['url'] ) ) {
                    $filtered_store_tabs[$key] = $tab;
                }
            endforeach;
            if ( ! empty( $filtered_store_tabs ) ) :
                if ( count( $filtered_store_tabs ) > 1 ) :
                    ?>
                    <div class="dokan-store-tabs">
                        <ul class="nav nav-tabs nav-justified align-items-end">
                            <?php foreach( $filtered_store_tabs as $key => $tab ) : ?>
                                <?php if ( $tab['url'] ) :
                                    $link_class = 'nav-link px-2';
                                    if ( $tab['url'] === $current_url || $tab['url'] === $current_url . '/' ) {
                                        $link_class .= ' active';
                                    } ?>
                                    <li class="text-center flex-grow-1">
                                        <a href="<?php echo esc_url( $tab['url'] ); ?>" class="<?php echo esc_attr( $link_class ); ?>">
                                            <?php echo esc_html( $tab['title'] ); ?>
                                        </a>
                                    </li>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                    <?php
                else :
                    reset($filtered_store_tabs);
                    $first_key = key($filtered_store_tabs);
                    ?>
                    <h2 class="h3 pt-2 pb-4 mb-4 text-center text-sm-left border-bottom">
                        <?php echo esc_html( $filtered_store_tabs[$first_key]['title'] ); ?>
                        <?php if ( $first_key === 'products' ) :
                            $products = dokan()->product->all( [
                                'author'        => $store_user->id,
                                'post_type'     => 'product',
                                'post_status'   => 'publish',
                            ] );

                            if ( $products->have_posts() ) :
                                ?>
                                <span class="badge badge-secondary font-size-sm text-body align-middle ml-2">
                                    <?php echo esc_html( $products->post_count ); ?>
                                </span>
                                <?php
                            endif;
                            wp_reset_postdata();
                        endif; ?>
                    </h2>
                    <?php
                endif;
            endif;
        endif;
    }
}

if ( ! function_exists( 'cartzilla_dokan_store_page_main_close' ) ) {
    function cartzilla_dokan_store_page_main_close() {
        ?></div></section><?php
    }
}


if ( ! function_exists( 'cartzilla_toggle_dokan_product_loop_hooks' ) ) {
    function cartzilla_toggle_dokan_product_loop_hooks() {
        if( dokan_is_store_page() ) {
            cartzilla_toggle_shop_loop_hooks();
        }
    }
}
