<?php
/**
 * WooCommerce Template Functions.
 *
 * @package cartzilla
 */

require_once get_template_directory() . '/inc/woocommerce/template-tags/product-item.php';
require_once get_template_directory() . '/inc/woocommerce/template-tags/single-product.php';
require_once get_template_directory() . '/inc/woocommerce/template-tags/wc-pages.php';
/**
 * Cartzilla WooCommerce Provider.
 *
 * @since 1.0.0
 */

if ( ! function_exists( 'cartzilla_wc_provider' ) ) {
    function cartzilla_wc_provider( $provider ) {
        return 'woocommerce';
    }
}

/**
 * Display the WooCommerce's breadcrumbs
 *
 * Integrate built-in WooCommerce's breadcrumbs into Cartzilla theme
 *
 * Note: remove breadcrumbs from their default place first.
 *
 * @see cartzilla_breadcrumbs()
 * @see archive-product.php
 * @see single-product.php
 * @see cartzilla_breadcrumbs()
 *
 * @hooked cartzilla_breadcrumbs_woocommerce
 *
 * @since 1.0.0
 */
if ( ! function_exists( 'cartzilla_wc_breadcrumbs' ) ) {
    function cartzilla_wc_breadcrumbs() {
        $style = cartzilla_get_shop_page_style();
        woocommerce_breadcrumb( [
            'delimiter'   => '',
            'wrap_before' => '<nav class="woocommerce-breadcrumb" aria-label="breadcrumb"><ol class="breadcrumb breadcrumb-light mt-n1">',
            'wrap_after'  => '</ol></nav>',
            'before'      => '<li class="breadcrumb-item d-flex'. esc_attr( $style !== 'style-v3' ? ' mt-1' : '') . '">',
            'after'       => '</li>',
        ] );
    }
}

/**
 * Display a link to the "Order tracking" page.
 *
 * @see cartzilla_order_tracking()
 *
 * @since 1.0.0
 */
if ( ! function_exists( 'cartzilla_wc_order_tracking' ) ) {
    function cartzilla_wc_order_tracking() {
        $page = get_theme_mod( 'cartzilla_order_tracking_page' );
        $text = get_theme_mod( 'cartzilla_order_tracking_page_text', __( 'Order tracking', 'cartzilla' ) );
        $icon_class = get_theme_mod( 'cartzilla_order_tracking_page_icon', 'czi-location' );
        $layout = get_theme_mod( 'header_type', '1-level-light' );

        if ( empty( $page ) ) {
            return;
        }

        $class = '';
        if ( $layout === 'electronics-store' ) {
            $class = 'topbar-link ml-3 border-left border-light pl-3 d-none d-md-inline-block';
        } else {
            $class = 'topbar-link d-none d-md-inline-block';
        }

        echo sprintf(
            '<a class="%3$s" href="%1$s"><i class="czi-location"></i>%2$s</a>',
            esc_url( get_permalink( $page ) ),
            esc_html( $text ),
            $icon_class
        );
    }
}

add_action( 'cartzilla_order_tracking_woocommerce', 'cartzilla_wc_order_tracking' );

/**
 * Cart Fragments
 *
 * Ensure cart contents update when products are added to the cart via AJAX.
 *
 * @param array $fragments Fragments to refresh via AJAX.
 * @return array Fragments to refresh via AJAX.
 */
if ( ! function_exists( 'cartzilla_wc_cart_fragments' ) ) {
    function cartzilla_wc_cart_fragments( $fragments ) {
        // Navbar toggle
        if ( cartzilla_navbar_is_cart() ) {
            ob_start();
            cartzilla_navbar_cart();
            $fragments['div.cartzilla-cart'] = ob_get_clean();

            ob_start();
            cartzilla_navbar_cart_toggle();
            $fragments['div.cartzilla-cart-toggle'] = ob_get_clean();

            ob_start();
            cartzilla_navbar_cart_toggle_v3();
            $fragments['div.cartzilla-cart-toggle-v3'] = ob_get_clean();
        }

        // Toolbar toggle
        ob_start();
        cartzilla_wc_handheld_toolbar_toggle_cart();
        $fragments['a.cz-handheld-toolbar-cart'] = ob_get_clean();

        return $fragments;
    }
}

/**
 * Returns if a variations radio enabled or not
 */
if ( ! function_exists( 'cartzilla_is_wc_single_product_variations_radio_style' ) ) {
    function cartzilla_is_wc_single_product_variations_radio_style() {
        $single_product_style = cartzilla_get_single_product_style();
        $radio_enable = false;
        if ( is_product() && $single_product_style === 'style-v3' ) {
            $radio_enable = true;
        }

        return apply_filters( 'cartzilla_is_wc_single_product_variations_radio_style', $radio_enable, $single_product_style );
    }
}

/**
 * Returns if a sidebar for Shop is available or not
 */
if( ! function_exists( 'cartzilla_shop_has_sidebar' ) ) {
    function cartzilla_shop_has_sidebar() {
        $layout = cartzilla_wc_products_sidebar();

        return $layout !== 'no-sidebar';
    }
}

/**
 * Returns the sidebar of shop page chosen by user
 */
if( ! function_exists( 'cartzilla_wc_products_sidebar' ) ) {
    function cartzilla_wc_products_sidebar() {

    $available_sidebars = array( 'left-sidebar', 'right-sidebar', 'no-sidebar' );
    if ( cartzilla_is_woocommerce_activated() && ( is_shop() || is_product_category() || is_tax( 'product_label' ) || is_tax( get_object_taxonomies( 'product' ) ) ) ) {
        if( is_active_sidebar( 'sidebar-shop' ) ) {
            $sidebar = get_theme_mod( 'shop_sidebar', 'left-sidebar' );
        } else {
            $sidebar = 'no-sidebar';
        }
    } else {
        $sidebar = 'left-sidebar';
    }

    if ( ! in_array( $sidebar, $available_sidebars ) ) {
        $sidebar = 'right-sidebar';
    }

    return sanitize_key( apply_filters( 'cartzilla_shop_sidebar', $sidebar ) );

    }
}

/**
 * Returns the layout of shop page chosen by user
 */
if( ! function_exists( 'cartzilla_wc_products_layout' ) ) {
    function cartzilla_wc_products_layout() {

        $layout = get_theme_mod( 'cartzilla_catalog_layout', 'grid' );
        $sidebar = cartzilla_wc_products_sidebar();

        /*
         * If sidebar is empty - we should load the template without the sidebar.
         * Just keep the user preferences on list or grid layout.
         */
        if ( $sidebar === 'no-sidebar' || ! is_active_sidebar( 'sidebar-shop' ) ) {
            $layout = "{$layout}-no-sidebar";
        }

        /**
         * Filter the layout type
         *
         * NOTE: this is a part of the file name, so if you want to add a custom
         * layout in the child theme you have to follow the file name convention.
         * Your file should be named posts-{$layout}.php
         *
         * You can add your custom template part to
         * /theme-child/templates/blog/posts-{$layout}.php
         *
         * @param string $layout Layout
         */
        return sanitize_key( apply_filters( 'cartzilla_catalog_layout', $layout ) );
    }
}

/**
 * Get woocommerce page title background skin based on customizer settings
 *
 * @return string
 */
if( ! function_exists( 'cartzilla_wc_catalog_type' ) ) {
    function cartzilla_wc_catalog_type() {
        return sanitize_key( apply_filters( 'cartzilla_wc_catalog_type', get_theme_mod( 'cartzilla_catalog_type', 'dark' ) ) );
    }
}

/**
 * Make sure we have non-empty categories, which we can automatically add to Departments menu.
 *
 * @param bool $is Show or hide the departments menu
 *
 * @return bool
 */
if ( ! function_exists( 'cartzilla_wc_departments_visibility' ) ) {
    function cartzilla_wc_departments_visibility( $is ) {
        if ( false !== $is ) {
            $categories = get_terms( apply_filters( 'cartzilla_wc_departments_fb_terms_args', [
                'taxonomy'   => 'product_cat',
                'orderby'    => 'meta_value_num',
                'meta_key'   => 'order',
                'hide_empty' => false,
                'parent'     => 0,
                'fields'         => 'count',
            ] ) );

            return (int) $categories > 0;
        }

        return $is;
    }
}

/**
 * Add fallback to "Departments" menu
 *
 * @param array $args Menu args {@see wp_nav_menu()}
 *
 * @return array
 *
 * @see cartzilla_wc_departments_fallback()
 * @see cartzilla_departments_menu()
 *
 * @since 1.0.0
 */
if ( ! function_exists( 'cartzilla_wc_departments_menu_args' ) ) {
    function cartzilla_wc_departments_menu_args( $args ) {
        $args['fallback_cb'] = 'cartzilla_wc_departments_fallback';

        return $args;
    }
}

/**
 * "Departments" menu fallback
 *
 * @see cartzilla_wc_departments_menu_args()
 *
 * @since 1.0.0
 */
if ( ! function_exists( 'cartzilla_wc_departments_fallback' ) ) {
    function cartzilla_wc_departments_fallback() {
        $categories = get_terms( apply_filters( 'cartzilla_wc_departments_fb_terms_args', [
            'taxonomy'   => 'product_cat',
            'orderby'    => 'meta_value_num',
            'meta_key'   => 'order',
            'hide_empty' => false,
            'parent'     => 0,
            'number'     => 6,
        ] ) );

        if ( empty( $categories ) || is_wp_error( $categories ) ) {
            return;
        }

        ?>
        <div class="dropdown-menu px-2 pl-0 pb-4">
            <div class="d-flex flex-wrap cz-departments-grid">
                <?php foreach ( $categories as $category ) :
                    $child_cats = get_terms( apply_filters( 'cartzilla_wc_departments_fb_child_terms_args', [
                        'taxonomy'   => 'product_cat',
                        'orderby'    => 'meta_value_num',
                        'meta_key'   => 'order',
                        'hide_empty' => false,
                        'parent'     => $category->term_id,
                        'number'     => 3,
                    ] ) ); ?>
                    <div class="mega-dropdown-column pt-4 px-3">
                        <div class="d-block">
                            <a href="<?php echo esc_url( get_term_link( $category ) ); ?>" class="d-block overflow-hidden rounded-lg mb-3">
                                <?php woocommerce_subcategory_thumbnail( $category ); ?>
                            </a>
                            <h6 class="font-size-base mb-3"><?php echo esc_html( $category->name ); ?></h6>
                            <?php if( ! empty( $child_cats ) ) : ?>
                                <ul class="widget-list">
                                <?php foreach ($child_cats as $child_cat) : ?>
                                    <li class="widget-list-item">
                                        <a class="widget-list-link" href="<?php echo esc_url( get_term_link( $child_cat ) ); ?>"><?php echo esc_html( $child_cat->name ); ?></a>
                                    </li>
                                <?php endforeach; ?>
                                </ul>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
        <?php
    }
}
/**
 * "Product Categories" menu fallback
 *
 * @see cartzilla_wc_product_categories_args()
 *
 * @since 1.0.0
 */
if ( ! function_exists( 'cartzilla_product_categories' ) ) {
    function cartzilla_product_categories( $args ) {
        $defaults = apply_filters( 'cartzilla_wc_product_categories_args', array(
            'parent'             => 0,
            'number'             => 6,
            'order'              => 'DESC',
            'orderby'            => 'date',
            'hide_empty'         => false,
            'taxonomy'           => 'product_cat',
            'slug'               => '',
        ));
        $args = wp_parse_args( $args, $defaults );

        $args['slug']         = is_array( $args['slug'] ) ? $args['slug'] : explode( ',', $args['slug'] );
        $categories            = get_terms( $args );

        if ( empty( $categories ) || is_wp_error( $categories ) ) {
            return;
        }

        ?>

        <div class="container">
            <div class="row product-categories-grid pt-5">
                <?php foreach ( $categories as $category ) :
                    $child_cats = get_terms( apply_filters( 'cartzilla_wc_product_child_categories_args', [
                        'taxonomy'   => 'product_cat',
                        'orderby'    => 'meta_value_num',
                        'meta_key'   => 'order',
                        'hide_empty' => false,
                        'parent'     => $category->term_id,
                        'number'     => 6,
                    ] ) );

                    ?>

                    <div class="col-md-4 col-sm-6 mb-3">
                        <div class="card border-0">
                            <a class="d-block overflow-hidden rounded-lg product-categories-grid__image" href="<?php echo esc_url( get_term_link( $category ) ); ?>">
                                <?php woocommerce_subcategory_thumbnail( $category ); ?>

                            </a>

                            <div class="card-body">
                                <h2 class="h5"><?php echo esc_html( $category->name ); ?></h2>

                                <?php if( ! empty( $child_cats ) ) : ?>
                                    <ul class="list-unstyled font-size-sm mb-0">
                                    <?php foreach ($child_cats as $child_cat) : ?>
                                        <li class="d-flex align-items-center justify-content-between">
                                            <a class="nav-link-style" href="<?php echo esc_url( get_term_link( $child_cat ) ); ?>"><i class="czi-arrow-right-circle mr-2"></i><?php echo esc_html( $child_cat->name ); ?></a>
                                            <?php if ( $child_cat->count > 0 ) { ?>
                                                <span class="font-size-ms text-muted"><?php echo esc_html( $child_cat->count ); ?></span>
                                            <?php } ?>
                                        </li>
                                    <?php endforeach; ?>
                                        <li>...</li>
                                        <li class="view-all d-flex align-items-center justify-content-between"><a href="<?php echo esc_url( get_term_link( $category ) ); ?>" class="nav-link-style"><i class="czi-arrow-right-circle mr-2"></i><?php echo esc_html__( 'View All', 'cartzilla' ); ?></a><span class="font-size-ms text-muted"><?php echo esc_html( $category->count );?></span></li>
                                    </ul>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div><?php
    }
}


/**
 * Outputs the modal login form (triggered in the navbar).
 *
 * @since 1.0.0
 */
if ( ! function_exists( 'cartzilla_wc_modal_in_navbar' ) ) {
    function cartzilla_wc_modal_in_navbar() {
        if ( ! cartzilla_navbar_is_account() || is_user_logged_in() ) {
            return;
        }
        $has_registration_form = get_option( 'woocommerce_enable_myaccount_registration' ) === 'yes';
        ?>
        <div class="modal fade" tabindex="-1" role="dialog" id="cz-sign-in-modal">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <?php if ( $has_registration_form ) : ?>
                        <ul class="nav nav-tabs card-header-tabs" role="tablist">
                            <li class="nav-item"><a class="nav-link active" href="#signin-tab" data-toggle="tab" role="tab" aria-selected="true"><i class="czi-unlocked mr-2 mt-n1"></i>Sign in</a></li>
                            <li class="nav-item"><a class="nav-link" href="#signup-tab" data-toggle="tab" role="tab" aria-selected="false"><i class="czi-user mr-2 mt-n1"></i>Sign up</a></li>
                        </ul>
                        <?php else: ?>
                        <h5 class="modal-title"><?php echo esc_html_x( 'Login to your account', 'front-end', 'cartzilla' ); ?></h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <?php endif; ?>
                    </div>
                    <div class="modal-body<?php if ( $has_registration_form ): ?> tab-content<?php endif; ?>">
                        <div id="signin-tab" class="tab-pane fade show active">
                        <?php
                            woocommerce_login_form( [
                                'redirect' => get_permalink( wc_get_page_id( 'myaccount' ) ),
                            ] );
                        ?>
                        </div>
                        <?php if ( $has_registration_form ): ?>
                        <div id="signup-tab" class="tab-pane fade">
                            <?php cartzilla_wc_registration_form(); ?>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
        <?php
    }
}

if ( ! function_exists( 'cartzilla_wc_registration_form' ) ) {
    /**
     * Registration Form
     */
    function cartzilla_wc_registration_form() {
        ?><form method="post" class="woocommerce-form woocommerce-form-register register" <?php do_action( 'woocommerce_register_form_tag' ); ?> >

            <?php do_action( 'woocommerce_register_form_start' ); ?>

            <?php if ( 'no' === get_option( 'woocommerce_registration_generate_username' ) ) : ?>

                <div class="woocommerce-form-row woocommerce-form-row--wide form-group">
                    <label for="reg_username"><?php esc_html_e( 'Username', 'cartzilla' ); ?><span class="text-danger">*</span></label>
                    <input type="text" class="woocommerce-Input woocommerce-Input--text input-text form-control" name="username" id="reg_username" autocomplete="username" value="<?php echo ( ! empty( $_POST['username'] ) ) ? esc_attr( wp_unslash( $_POST['username'] ) ) : ''; ?>" /><?php // @codingStandardsIgnoreLine ?>
                </div>

            <?php endif; ?>

            <div class="woocommerce-form-row woocommerce-form-row--wide form-group">
                <label for="reg_email"><?php esc_html_e( 'Email address', 'cartzilla' ); ?><span class="text-danger">*</span></label>
                <input type="email" class="woocommerce-Input woocommerce-Input--text input-text form-control" name="email" id="reg_email" autocomplete="email" value="<?php echo ( ! empty( $_POST['email'] ) ) ? esc_attr( wp_unslash( $_POST['email'] ) ) : ''; ?>" /><?php // @codingStandardsIgnoreLine ?>
            </div>

            <?php if ( 'no' === get_option( 'woocommerce_registration_generate_password' ) ) : ?>

                <div class="woocommerce-form-row woocommerce-form-row--wide form-group">
                    <label for="reg_password"><?php esc_html_e( 'Password', 'cartzilla' ); ?><span class="text-danger">*</span></label>
                    <div class="password-toggle">
                        <input type="password" class="woocommerce-Input woocommerce-Input--text input-text form-control" name="password" id="reg_password" autocomplete="new-password" />
                        <label class="password-toggle-btn">
                            <input class="custom-control-input" type="checkbox">
                            <i class="czi-eye password-toggle-indicator"></i>
                            <span class="sr-only"><?php echo esc_html_x( 'Show password', 'front-end', 'cartzilla' ); ?></span>
                        </label>
                    </div>
                </div>

            <?php else : ?>

                <p class="font-size-sm text-muted"><?php esc_html_e( 'A password will be sent to your email address.', 'cartzilla' ); ?></p>

            <?php endif; ?>

            <?php do_action( 'woocommerce_register_form' ); ?>

            <div class="text-right">
                <button type="submit" class="woocommerce-Button woocommerce-button button woocommerce-form-register__submit btn btn-primary" name="register" value="<?php esc_attr_e( 'Register', 'cartzilla' ); ?>"><i class="<?php echo esc_attr( apply_filters( 'front_registration_form_button_icon', 'czi-user' ) ); ?> mr-2 ml-n1"></i><?php esc_html_e( 'Register', 'cartzilla' ); ?></button>


            </div>

            <?php do_action( 'woocommerce_register_form_end' ); ?>

            <?php wp_nonce_field( 'woocommerce-register', 'woocommerce-register-nonce' ); ?>
        </form><?php
    }
}

if ( ! function_exists( 'cartzilla_general_product_data_custom_button_meta_args' ) ) {
    function cartzilla_general_product_data_custom_button_meta_args() {
        $args = apply_filters( 'cartzilla_general_product_data_custom_button_meta_args', [
            'preview' => [
                'label_base'    => __( 'Demo', 'cartzilla' ),
                'priority'      => 10,
            ],
            'docs' => [
                'label_base'    => __( 'Docs', 'cartzilla' ),
                'priority'      => 20,
            ],
        ] );

        return $args;
    }
}

if ( ! function_exists( 'cartzilla_wc_my_account_endpoint_dropdown' ) ) {
    function cartzilla_wc_my_account_endpoint_dropdown() {
        $endpoints = wc_get_account_menu_items();
        if( array_filter( $endpoints ) ) {
            $default_icons = [
                'dashboard' => 'czi-home',
                'orders' => 'czi-bag',
                'downloads' => 'czi-cloud-download',
                'edit-address' => 'czi-location',
                'edit-account' => 'czi-user',
                'payment-methods' => 'czi-card',
                'customer-logout' => 'czi-sign-out',
            ];
            ?><ul class="dropdown-menu dropdown-menu-right" style="min-width: 14rem;">
                <?php foreach( $endpoints as $endpoint => $label ) :
                    $default_icon = isset( $default_icons[$endpoint] ) ? $default_icons[$endpoint] : '';
                    $icon_class = get_theme_mod( "cartzilla_wc_endpoint_{$endpoint}_icon", $default_icon );
                    ?>
                    <?php if ( $endpoint === 'customer-logout' ) : ?>
                        <li class="dropdown-divider"></li>
                    <?php endif; ?>
                    <li class="<?php echo wc_get_account_menu_item_classes( $endpoint ); ?>">
                        <a class="dropdown-item d-flex align-items-center" href="<?php echo esc_url( wc_get_account_endpoint_url( $endpoint ) ); ?>">
                            <?php if( ! empty( $icon_class ) ) : ?>
                                <i class="<?php echo esc_attr( $icon_class ); ?> opacity-60 mt-n1 mr-2"></i>
                            <?php endif; ?>
                            <?php echo esc_html( $label ); ?>
                            <?php if( $endpoint === 'orders' ) : ?>
                                <span class="font-size-xs text-muted ml-auto"><?php cartzilla_wc_account_orders_count(); ?></span>
                            <?php elseif( $endpoint === 'downloads' ) : ?>
                                <span class="font-size-xs text-muted ml-auto"><?php is_a( WC()->customer, 'WC_Customer' ) ? cartzilla_wc_account_downloads_count() : 0; ?></span>
                            <?php endif; ?>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul><?php
        }
    }
}