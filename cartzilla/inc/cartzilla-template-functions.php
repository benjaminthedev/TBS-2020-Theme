<?php
/**
 * Template functions
 *
 * Typically functions used in templates or hooked {@see template-hooks.php}
 *
 * @package Cartzilla
 */

/**
 * Return a list of available links to social networks
 *
 * @return array
 */

if( ! function_exists( 'cartzilla_get_socials' ) ) {
    function cartzilla_get_socials() {
        $socials = [];
        $mods    = get_theme_mods();
        if ( ! empty( $mods ) ) {
            $prefix = 'social_';
            foreach ( (array) $mods as $key => $value ) {
                if ( false === strpos( $key, $prefix ) ) {
                    continue;
                }

                $network = str_replace( $prefix, '', $key );

                $socials[ $network ] = $value;
            }
            unset( $key, $value );
        }

        return (array) apply_filters( 'cartzilla_socials', $socials );
    }
}

/**
 * Display the site header
 *
 * @return array
 */
if( ! function_exists( 'cartzilla_header' ) ) {
    function cartzilla_header() {
        global $post;
        $static_content_id = apply_filters( 'cartzilla_header_static_content_id', '' );

        if ( is_page() && isset( $post->ID ) ) {
            $clean_page_meta_values = get_post_meta( $post->ID, '_headerStaticContentID', true );

            if ( isset( $clean_page_meta_values ) && $clean_page_meta_values ) {
                $static_content_id = $clean_page_meta_values;
            }
        }

        if( cartzilla_is_mas_static_content_activated() && ! empty( $static_content_id ) ) {
            echo do_shortcode( '[mas_static_content id=' . $static_content_id . ' wrap=0]' );
        } else {
            $layout = cartzilla_header_layout();
            get_template_part( 'templates/header/header', $layout );
        }
    }
}

/**
 * Returns the template slug used for header.
 *
 * @return string
 *
 * @see header.php
 * @see templates/header/header-*.php
 */
if( ! function_exists( 'cartzilla_header_layout' ) ) {
    function cartzilla_header_layout() {
        $layout = get_theme_mod( 'header_type', '1-level-light' );

        /**
         * Filter the layout type
         *
         * NOTE: this is a part of the file name, so if you want to add a custom
         * layout in the child theme you have to follow the file name convention.
         * Your file should be named header-{$layout}.php
         *
         * You can add your custom template part to
         * /theme-child/templates/header/header-{$layout}.php
         *
         * @param string $layout Layout
         */
        return sanitize_key( apply_filters( 'cartzilla_header_layout', $layout ) );
    }
}

if( ! function_exists( 'cartzilla_page_header_layout' ) ) {
    function cartzilla_page_header_layout( $layout ) {
        global $post;
        if ( is_page() && isset( $post->ID ) ) {
            $header_meta_values = get_post_meta( $post->ID, '_headerStyle', true );

            if ( isset( $header_meta_values ) && $header_meta_values ) {
                $layout = $header_meta_values;
            }
        }
        return $layout;
    }
}



/**
 * Enable or disable the full-width header
 *
 * @return bool
 */
if( ! function_exists( 'cartzilla_header_is_fw' ) ) {
    function cartzilla_header_is_fw() {
        return (bool) apply_filters( 'cartzilla_header_is_fw', 'yes' === get_theme_mod( 'header_is_full_width', 'no' ) );
    }
}

/**
 * Enable or disable sticky header
 *
 * @return bool
 */
if( ! function_exists( 'cartzilla_header_is_sticky' ) ) {
    function cartzilla_header_is_sticky() {
        return (bool) apply_filters( 'cartzilla_header_is_sticky', 'yes' === get_theme_mod( 'header_is_sticky', 'yes' ) );
    }
}

/**
 * Returns the logo for desktop
 *
 * @return string
 */
if( ! function_exists( 'cartzilla_get_logo' ) ) {
    function cartzilla_get_logo() {
        $current_header = cartzilla_header_layout();

        // Classes for logo wrappers should differs in multilevel headers
        $classes = in_array( $current_header, [ '3-level-light', '3-level-dark', 'electronics-store', 'grocery' ] )
            ? 'navbar-brand d-none d-sm-block mr-3 flex-shrink-0'
            : 'navbar-brand d-none d-sm-block mr-4 order-lg-1';

        // Append .custom-logo-link for customizer preview
        $classes .= ' custom-logo-link';
        $cartzilla_custom_logo_id = apply_filters( 'cartzilla_custom_logo', '');

        if ( !empty( $cartzilla_custom_logo_id ) ) {

            $cartzilla_custom_image_attr = [
                'class' => 'custom-logo',
            ];

            // If the logo alt attribute is empty, get the site title
            $cartzilla_custom_logo_alt = get_post_meta( $cartzilla_custom_logo_id , '_wp_attachment_image_alt', true );
            if ( empty( $cartzilla_custom_logo_alt ) ) {
                $cartzilla_custom_image_attr['alt'] = get_bloginfo( 'name', 'display' );
            }

            $cartzilla_custom_logo_meta  = wp_get_attachment_metadata( $cartzilla_custom_logo_id );
            $cartzilla_custom_logo_width = isset( $cartzilla_custom_logo_meta['width'] ) ? (int) $cartzilla_custom_logo_meta['width'] : 284;

            $html = sprintf(
                '<a href="%1$s" class="%4$s" rel="home" style="width: %3$dpx;">%2$s</a>',
                esc_url( home_url( '/' ) ),
                wp_get_attachment_image( $cartzilla_custom_logo_id, 'full', false, $cartzilla_custom_image_attr ),
                (float) $cartzilla_custom_logo_width / 2,
                $classes
            );
        } elseif ( has_custom_logo() ) {
            // User uploads a real logo through Customizer

            $logo_id   = (int) get_theme_mod( 'custom_logo' );
            $logo_attr = [
                'class' => 'custom-logo',
            ];

            // If the logo alt attribute is empty, get the site title
            $logo_alt = get_post_meta( $logo_id, '_wp_attachment_image_alt', true );
            if ( empty( $logo_alt ) ) {
                $logo_attr['alt'] = get_bloginfo( 'name', 'display' );
            }

            $meta  = wp_get_attachment_metadata( $logo_id );

            $width = isset( $meta['width'] ) ? (int) $meta['width'] : 284;

            $html = sprintf(
                '<a href="%1$s" class="%4$s" rel="home" style="width: %3$dpx;">%2$s</a>',
                esc_url( home_url( '/' ) ),
                wp_get_attachment_image( $logo_id, 'full', false, $logo_attr ),
                (float) $width / 2,
                $classes
            );
        } elseif( apply_filters( 'cartzilla_default_logo', false ) ) {
            // Theme fallback logo

            // Fallback logo may be light or dark depending on current header layout
            $logo_variant = false !== strpos( $current_header, 'dark' ) ? 'light' : 'dark';
            $logo_img     = sprintf( '<img src="%s" alt="%s" class="custom-logo">',
                esc_url( get_template_directory_uri() . "/assets/img/logo-{$logo_variant}.png" ),
                esc_attr( get_bloginfo( 'name', 'display' ) )
            );

            $html = sprintf(
                '<a href="%1$s" class="%3$s" rel="home" style="width: 142px;">%2$s</a>',
                esc_url( home_url( '/' ) ),
                $logo_img,
                $classes
            );
        } else {
            $html = sprintf(
                '<h1 class="site-title mb-0"><a href="%1$s" class="%3$s" rel="home">%2$s</a></h1>',
                esc_url( home_url( '/' ) ),
                get_bloginfo( 'name', 'display' ),
                $classes
            );
        }

        return (string) apply_filters( 'cartzilla_logo', $html );
    }
}

/**
 * Display the desktop logo.
 */
if( ! function_exists( 'cartzilla_logo' ) ) {
    function cartzilla_logo() {
        echo cartzilla_get_logo();
    }
}

/**
 * Returns a logo for mobile
 *
 * @return string
 */
if( ! function_exists( 'cartzilla_get_mobile_logo' ) ) {
    function cartzilla_get_mobile_logo() {
        $current_header = cartzilla_header_layout();

        // Classes for logo wrappers should differs in multilevel headers
        $classes = in_array( $current_header, [ '3-level-light', '3-level-dark' ] )
            ? 'navbar-brand d-sm-none mr-2'
            : 'navbar-brand d-sm-none mr-2 order-lg-1';

        // Append .mobile-logo-link for customizer preview
        $classes .= ' mobile-logo-link';
        $mobile_custom_logo_id = apply_filters( 'cartzilla_custom_mobile_logo', '');
        $mobile_logo_id = (int) get_theme_mod( 'mobile_logo' );

        if ( ! empty ($mobile_custom_logo_id ) ) {
            $mobile_custom_logo_attr = [
                'class' => 'mobile-logo',
            ];

            // If the logo alt attribute is empty, get the site title
            $mobile_custom_logo_alt = get_post_meta( $mobile_custom_logo_id, '_wp_attachment_image_alt', true );
            if ( empty( $mobile_custom_logo_alt ) ) {
                $mobile_custom_logo_attr['alt'] = get_bloginfo( 'name', 'display' );
            }

            $mobile_custom_logo_meta  = wp_get_attachment_metadata( $mobile_custom_logo_id );
            $mobile_custom_logo_width = isset( $mobile_custom_logo_meta['width'] ) ? (int) $mobile_custom_logo_meta['width'] : 148;

            $html = sprintf(
                '<a href="%1$s" class="%4$s" rel="home" style="width: %3$dpx;">%2$s</a>',
                esc_url( home_url( '/' ) ),
                wp_get_attachment_image( $mobile_custom_logo_id, 'full', false, $mobile_custom_logo_attr ),
                (float) $mobile_custom_logo_width / 2,
                $classes
            );

        } elseif ( $mobile_logo_id ) {
            // User uploads a mobile logo via Customizer
            $mobile_logo_attr = [
                'class' => 'mobile-logo',
            ];

            // If the logo alt attribute is empty, get the site title
            $mobile_logo_alt = get_post_meta( $mobile_logo_id, '_wp_attachment_image_alt', true );
            if ( empty( $mobile_logo_alt ) ) {
                $mobile_logo_attr['alt'] = get_bloginfo( 'name', 'display' );
            }

            $mobile_logo_meta  = wp_get_attachment_metadata( $mobile_logo_id );
            $mobile_logo_width = isset( $mobile_logo_meta['width'] ) ? (int) $mobile_logo_meta['width'] : 148;

            $html = sprintf(
                '<a href="%1$s" class="%4$s" rel="home" style="width: %3$dpx;">%2$s</a>',
                esc_url( home_url( '/' ) ),
                wp_get_attachment_image( $mobile_logo_id, 'full', false, $mobile_logo_attr ),
                (float) $mobile_logo_width / 2,
                $classes
            );
        } elseif ( has_custom_logo() ) {
            // If mobile logo not set use the desktop logo

            $custom_logo_id   = (int) get_theme_mod( 'custom_logo' );
            $custom_logo_attr = [
                'class' => 'mobile-logo',
            ];

            // If the logo alt attribute is empty, get the site title
            $custom_logo_alt = get_post_meta( $custom_logo_id, '_wp_attachment_image_alt', true );
            if ( empty( $custom_logo_alt ) ) {
                $custom_logo_attr['alt'] = get_bloginfo( 'name', 'display' );
            }

            $custom_logo_meta  = wp_get_attachment_metadata( $custom_logo_id );
            $custom_logo_width = isset( $custom_logo_meta['width'] ) ? (int) $custom_logo_meta['width'] : 148;

            $html = sprintf(
                '<a href="%1$s" class="%4$s" rel="home" style="width: %3$dpx;">%2$s</a>',
                esc_url( home_url( '/' ) ),
                wp_get_attachment_image( $custom_logo_id, 'full', false, $custom_logo_attr ),
                (float) $custom_logo_width / 2,
                $classes
            );
        } elseif( apply_filters( 'cartzilla_default_logo', false ) ) {
            // Theme fallback logo

            // Fallback logo may be light or dark depending on current header layout
            $logo_variant = false !== strpos( $current_header, 'dark' ) ? 'light' : 'dark';
            $logo_img     = sprintf( '<img src="%s" alt="%s" class="mobile-logo">',
                esc_url( get_template_directory_uri() . "/assets/img/logo-icon-{$logo_variant}.png" ),
                esc_attr( get_bloginfo( 'name', 'display' ) )
            );

            $html = sprintf(
                '<a href="%1$s" class="%3$s" rel="home" style="width: 74px;">%2$s</a>',
                esc_url( home_url( '/' ) ),
                $logo_img,
                $classes
            );
        } else {
            $html = sprintf(
                '<h1 class="site-title mb-0"><a href="%1$s" class="%3$s" rel="home">%2$s</a></h1>',
                esc_url( home_url( '/' ) ),
                get_bloginfo( 'name', 'display' ),
                $classes
            );
        }

        return (string) apply_filters( 'cartzilla_mobile_logo', $html );
    }
}

/**
 * Display a logo for mobile
 */
if( ! function_exists( 'cartzilla_mobile_logo' ) ) {
    function cartzilla_mobile_logo() {
        echo cartzilla_get_mobile_logo();
    }
}

/**
 * Display the primary menu
 *
 * @uses has_nav_menu()
 * @uses wp_nav_menu()
 * @uses WP_Bootstrap_Navwalker()
 */
if( ! function_exists( 'cartzilla_primary_menu' ) ) {
    function cartzilla_primary_menu() {
        if ( ! has_nav_menu( 'primary' ) ) {
            return;
        }

        $headerPrimaryMenuSlug = apply_filters( 'cartzilla_primary_menu' , '' );

        $args = apply_filters( 'cartzilla_primary_menu_args', [
            'theme_location' => 'primary',
            'fallback_cb'    => false,
            'items_wrap'     => '<ul class="%2$s">%3$s</ul>',
            'container'      => false,
            'menu_class'     => 'navbar-nav',
            'walker'         => new WP_Bootstrap_Navwalker(),
            'classes'        => array(
                'nav-link'        => 'nav-link',
                'dropdown-toggle' => 'dropdown-toggle',
                'dropdown'        => 'dropdown',
                'dropdown-item'   => 'dropdown-item',
                'dropdown-menu'   => array( 'sub-menu', 'dropdown-menu' )
            )
        ] );

        if( ! empty ( $headerPrimaryMenuID ) && $headerPrimaryMenuID > 0 ) {
            $args['menu'] = $headerPrimaryMenuID;
        } elseif( ! empty( $headerPrimaryMenuSlug ) ) {
            $args['menu'] = $headerPrimaryMenuSlug;
        }

        wp_nav_menu( $args );
    }
}

/**
 * Display the handheld sidebar
 *
 * Contains the menu assigned to a "Handheld" menu location and "Departments" menu
 *
 * @since 1.0.0
 */
if( ! function_exists( 'cartzilla_handheld_sidebar' ) ) {
    function cartzilla_handheld_sidebar() {
        $is_handheld_menu    = has_nav_menu( 'handheld' );
        $is_departments_menu = has_nav_menu( 'departments' );

        ?>
        <div class="cz-sidebar cz-offcanvas" id="cz-handheld-sidebar">
            <div class="cz-sidebar-header box-shadow-sm">
                <span class="font-weight-medium"><?php echo esc_html_x( 'Menu', 'front-end', 'cartzilla' ); ?></span>
                <button class="close ml-auto" type="button" data-dismiss="sidebar" aria-label="<?php echo esc_attr_x( 'Close', 'front-end', 'cartzilla' ); ?>">
                    <span class="d-inline-block font-size-xs font-weight-normal align-middle">
                        <?php echo esc_html_x( 'Close', 'front-end', 'cartzilla' ); ?>
                    </span>
                    <span class="d-inline-block align-middle ml-2" aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="cz-sidebar-body" data-simplebar data-simplebar-auto-hide="true">
                <?php if ( cartzilla_is_woocommerce_activated() ) : ?>
                    <?php the_widget( 'WC_Widget_Product_Search', 'title=' ); ?>
                <?php else : ?>
                    <form role="search" method="get" class="search-form mb-3" action="<?php echo esc_url( home_url( '/' ) ); ?>">
                        <div class="input-group-overlay">
                            <div class="input-group-prepend-overlay">
                                <span class="input-group-text"><i class="czi-search"></i></span>
                            </div>
                            <input type="search" name="s" class="form-control prepended-form-control" value="<?php echo get_search_query(); ?>" placeholder="<?php echo esc_html_x( 'Search site...', 'front-end', 'cartzilla' ); ?>">
                        </div>
                    </form>
                <?php endif; ?>

                <?php if ( $is_handheld_menu && $is_departments_menu ) : ?>
                    <ul class="nav flex-nowrap nav-tabs nav-justified mb-1" role="tablist">
                        <li class="nav-item">
                            <a href="#cz-handheld-sidebar-menu-tab" class="nav-link active" data-toggle="tab" role="tab">
                                <?php echo esc_html_x( 'Menu', 'front-end', 'cartzilla' ); ?>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#cz-handheld-sidebar-departments-tab" class="nav-link" data-toggle="tab" role="tab">
                                <?php cartzilla_departments_title(); ?>
                            </a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane fade show active" id="cz-handheld-sidebar-menu-tab" role="tabpanel">
                            <nav class="cz-handheld-menu">
                                <?php cartzilla_handheld_menu(); ?>
                            </nav>
                        </div>
                        <div class="tab-pane fade" id="cz-handheld-sidebar-departments-tab" role="tabpanel">
                            <nav class="cz-handheld-menu">
                                <?php cartzilla_handheld_departments_menu( [ 'ids' => [ 'menu-item-prefix' => 'handheld-departments' ] ] ); ?>
                            </nav>
                        </div>
                    </div>
                <?php elseif ( $is_handheld_menu ) : ?>
                    <nav class="cz-handheld-menu">
                        <?php cartzilla_handheld_menu(); ?>
                    </nav>
                <?php elseif ( $is_departments_menu ) : ?>
                    <nav class="cz-handheld-menu">
                        <?php cartzilla_handheld_departments_menu( [ 'ids' => [ 'menu-item-prefix' => 'handheld-departments' ] ] ); ?>
                    </nav>
                <?php endif; ?>

                <?php if ( has_filter( 'cartzilla_dropdown_tools_toggle' ) ) : ?>
                    <div class="btn-group dropdown disable-autohide mt-4 w-100">
                        <button class="btn btn-outline-secondary btn-sm btn-block dropdown-toggle" type="button" data-toggle="dropdown">
                            <?php cartzilla_dropdown_tools_toggle(); ?>
                        </button>
                        <ul class="dropdown-menu w-100">
                            <?php cartzilla_dropdown_tools(); ?>
                        </ul>
                    </div>
                <?php endif; ?>

            </div>
        </div>
        <?php
    }
}

/**
 * Display the handheld menu
 *
 * @uses wp_nav_menu()
 * @uses WP_Bootstrap_Navwalker()
 *
 * @since 1.0.0
 */
if( ! function_exists( 'cartzilla_handheld_menu' ) ) {
    function cartzilla_handheld_menu() {
        $args = apply_filters( 'cartzilla_handheld_menu_args', [
            'theme_location' => 'handheld',
            'depth'          => 3,
            'items_wrap'     => '<ul>%3$s</ul>',
            'fallback_cb'    => false,
            'container'      => false,
            'walker'         => new WP_Bootstrap_Navwalker(),
            'classes'        => array(
                'nav-link'        => '',
                'dropdown-toggle' => '',
                'dropdown'        => 'dropdown',
                'dropdown-item'   => 'dropdown-item',
                'dropdown-menu'   => array( 'sub-menu' )
            ),
            'ids'             => array(
                'menu-item-prefix'          => 'handheld',
            ),
            'data_toggle'   => 'collapse',
            'toggle_button' => true,
        ] );

        wp_nav_menu( $args );
    }
}

/**
 * Display the "Departments" menu inside the handheld sidebar
 *
 * @uses wp_nav_menu()
 * @uses WP_Bootstrap_Navwalker()
 *
 * @since 1.0.0
 */
if( ! function_exists( 'cartzilla_handheld_departments_menu' ) ) {
    function cartzilla_handheld_departments_menu( $args = [] ) {
        $headerHandheldDepartmentMenuSlug = apply_filters( 'cartzilla_header_handheld_department_menu' , '' );

        $default_args = apply_filters( 'cartzilla_handheld_departments_menu_args', [
            'theme_location'  => 'departments',
            'depth'           => 3,
            'items_wrap'      => '<ul>%3$s</ul>',
            'fallback_cb'     => false,
            'container'       => false,
            'walker'          => new WP_Bootstrap_Navwalker(),
            'classes'         => array(
                'nav-link'        => '',
                'dropdown-toggle' => '',
                'dropdown'        => 'dropdown',
                'dropdown-item'   => 'dropdown-item',
                'dropdown-menu'   => array( 'sub-menu' )
            ),
            'data_toggle'   => 'collapse',
            'toggle_button' => true,
        ] );

        if( ! empty ( $headerHandheldDepartmentMenuID ) && $headerHandheldDepartmentMenuID > 0 ) {
            $args['menu'] = $headerHandheldDepartmentMenuID;
        } elseif( ! empty( $headerHandheldDepartmentMenuSlug ) ) {
            $args['menu'] = $headerHandheldDepartmentMenuSlug;
        }

        $args = wp_parse_args( $args, $default_args );

        wp_nav_menu( $args );
    }
}

/**
 * Display the "Primary" menu inside the offcanvas sidebar
 *
 * @uses wp_nav_menu()
 * @uses WP_Bootstrap_Navwalker()
 *
 * @since 1.0.0
 */
if( ! function_exists( 'cartzilla_offcanvas_primary_menu' ) ) {
    function cartzilla_offcanvas_primary_menu() {
        $headerOffcanvasMenuSlug = apply_filters( 'cartzilla_offcanvas_primary_menu' , '' );

        $args = apply_filters( 'cartzilla_offcanvas_primary_menu_args', [
            'theme_location'  => 'primary',
            'depth'           => 3,
            'items_wrap'      => '<ul>%3$s</ul>',
            'fallback_cb'     => false,
            'container'       => false,
            'walker'          => new WP_Bootstrap_Navwalker(),
            'classes'        => array(
                'nav-link'        => '',
                'dropdown-toggle' => '',
                'dropdown'        => 'dropdown',
                'dropdown-item'   => 'dropdown-item',
                'dropdown-menu'   => array( 'sub-menu' )
            ),
            'data_toggle'   => 'collapse',
            'toggle_button' => true,
        ] );

        if( ! empty ( $headerOffcanvasMenuID ) && $headerOffcanvasMenuID > 0 ) {
            $args['menu'] = $headerOffcanvasMenuID;
        } elseif( ! empty( $headerOffcanvasMenuSlug ) ) {
            $args['menu'] = $headerOffcanvasMenuSlug;
        }

        wp_nav_menu( $args );
    }
}

/**
 * Outputs the handheld toolbar
 *
 * @since 1.0.0
 */
if( ! function_exists( 'cartzilla_handheld_toolbar' ) ) {
    function cartzilla_handheld_toolbar() {
        ?>
        <div class="cz-handheld-toolbar">
            <div class="d-table table-layout-fixed w-100">
                <?php
                /**
                 * Display tools in toolbar
                 */
                do_action( 'cartzilla_handheld_toolbar' );
                ?>
            </div>
        </div>
        <?php
    }
}

/**
 * Outputs the sidebar toggle in the handheld toolbar
 *
 * This toggle should be only the blog page.
 *
 * @since 1.0.0
 */
if( ! function_exists( 'cartzilla_handheld_toolbar_toggle_blog_sidebar' ) ) {
    function cartzilla_handheld_toolbar_toggle_blog_sidebar() {
        if ( ( is_home() || is_single() || ( 'post' == get_post_type() && ( is_category() || is_tag() || is_author() || is_date() || is_year() || is_month() || is_time() ) ) )
             && cartzilla_posts_sidebar() !== 'no-sidebar'
        ) : ?>
            <a href="#blog-sidebar" data-toggle="sidebar" class="d-table-cell cz-handheld-toolbar-item">
                <div class="cz-handheld-toolbar-icon">
                    <i class="czi-sign-in"></i>
                </div>
                <span class="cz-handheld-toolbar-label"><?php echo esc_html_x( 'Sidebar', 'front-end', 'cartzilla' ); ?></span>
            </a>
        <?php
        endif;
    }
}

/**
 * Add handheld sidebar toggle to the handheld toolbar
 *
 * @since 1.0.0
 */
if( ! function_exists( 'cartzilla_handheld_toolbar_toggle_handheld_sidebar' ) ) {
    function cartzilla_handheld_toolbar_toggle_handheld_sidebar() {
        ?>
        <a href="#cz-handheld-sidebar" data-toggle="sidebar" class="d-table-cell cz-handheld-toolbar-item">
            <span class="cz-handheld-toolbar-icon">
                <i class="czi-menu"></i>
            </span>
            <span class="cz-handheld-toolbar-label"><?php echo esc_html_x( 'Menu', 'front-end', 'cartzilla' ); ?></span>
        </a>
        <?php
    }
}

/**
 * Display the navbar classes
 *
 * @param string $custom Custom classes
 */
if( ! function_exists( 'cartzilla_navbar_class' ) ) {
    function cartzilla_navbar_class( $custom = '' ) {
        $classes = [];

        $classes[] = 'navbar';
        $classes[] = 'navbar-expand-lg';

        if ( ! empty( $custom ) ) {
            $classes[] = $custom;
        }

        /**
         * Filter the navbar classes
         *
         * This filter allows you to easily add (or remove)
         * custom classes to the navbar
         *
         * @param array $classes A list of classes
         */
        $classes = (array) apply_filters( 'cartzilla_navbar_class', $classes );

        echo esc_attr( cartzilla_get_classes( $classes ) );
    }
}

/**
 * Show or hide a search in navbar section
 *
 * This may be a search icon for headers like simple or topbar+navbar
 * or a search field for multilevel header.
 *
 * @return bool
 */
if( ! function_exists( 'cartzilla_navbar_is_search' ) ) {
    function cartzilla_navbar_is_search() {
        return (bool) apply_filters( 'cartzilla_navbar_is_search',
            'yes' === get_theme_mod( 'navbar_is_search', 'yes' )
        );
    }
}

/**
 * Show or hide a category dropdown in navbar search section
 *
 * This may be a search icon for headers like simple or topbar+navbar
 * or a search field for multilevel header.
 *
 * @return bool
 */
if( ! function_exists( 'cartzilla_navbar_search_is_category_dropdown' ) ) {
    function cartzilla_navbar_search_is_category_dropdown() {
        return (bool) apply_filters( 'cartzilla_navbar_search_is_category_dropdown',
            'yes' === get_theme_mod( 'navbar_search_is_category_dropdown', 'yes' )
        );
    }
}

/**
 * Show or hide account tool in navbar section
 *
 * @return bool
 */
if( ! function_exists( 'cartzilla_navbar_is_account' ) ) {
    function cartzilla_navbar_is_account() {
        return (bool) apply_filters( 'cartzilla_navbar_is_account',
            // is WooCommerce activated?
            cartzilla_is_woocommerce_activated()
            // should Cartzilla show account (based on Customizer setting)?
            && 'yes' === get_theme_mod( 'navbar_is_account', 'yes' )
            // is user can register somehow?
            && ( get_option( 'users_can_register' ) || 'yes' === get_option( 'woocommerce_enable_signup_and_login_from_checkout' ) || 'yes' === get_option( 'woocommerce_enable_myaccount_registration' ) || is_user_logged_in() )
        );
    }
}

/**
 * Display the Topbar classes.
 *
 * @param string $custom Custom classes
 */
if( ! function_exists( 'cartzilla_topbar_class' ) ) {
    function cartzilla_topbar_class( $custom = '' ) {
        $classes = [];

        $classes[] = 'topbar';

        if ( ! empty( $custom ) ) {
            $classes[] = $custom;
        }

        /**
         * Filter the topbar class
         *
         * @param array $classes A list of topbar classes
         */
        $classes = (array) apply_filters( 'cartzilla_topbar_class', array_filter( $classes ) );

        echo esc_attr( cartzilla_get_classes( $classes ) );
    }
}

/**
 * Get topbar skin based on customizer settings
 *
 * @return string
 */
if( ! function_exists( 'cartzilla_topbar_skin' ) ) {
    function cartzilla_topbar_skin() {
        return sanitize_key( apply_filters( 'cartzilla_topbar_skin', get_theme_mod( 'topbar_skin', 'dark' ) ) );
    }
}

/**
 * Display the dropdown links in Hendheld Topbar section
 */
if( ! function_exists( 'topbar_handheld_dropdown' ) ) {
    function topbar_handheld_dropdown( $dropdown_postion = '' ) {
        $dropdown_title = apply_filters( 'cartzilla_topbar_handheld_dropdown_title', get_theme_mod( 'topbar_handheld_dropdown_title', __( 'Useful links', 'cartzilla' ) ) );

        $support_link  = apply_filters( 'cartzilla_site_info_support_link',  get_theme_mod( 'support_info_link', 'tel:+100331697720' ) );
        $support_icon  = apply_filters( 'cartzilla_site_info_support_icon',  get_theme_mod( 'support_info_icon', 'czi-support' ) );
        $support_text  = apply_filters( 'cartzilla_site_info_support_text',  get_theme_mod( 'support_info_text', '(00) 33 169 7720' ) );

        $order_tracking_page = get_option( 'cartzilla_order_tracking_page' );
        $order_tracking_page_icon = get_theme_mod( 'cartzilla_order_tracking_page_icon', 'czi-location' );
        $order_tracking_page_text = get_theme_mod( 'cartzilla_order_tracking_page_text', __( 'Order tracking', 'cartzilla' ) );

        $lines = [];

        if( ! empty( $support_link ) && ! empty( $support_text ) ) {
            $lines[] = '<li><a href="' . esc_url( $support_link ) . '" class="dropdown-item">' . ( !empty( $support_icon ) ? '<i class="' . esc_attr( $support_icon ) . ' text-muted mr-2"></i>' : '' ) . esc_html( $support_text ) . '</a></li>';
        }

        if( absint( $order_tracking_page ) > 0 && $order_tracking_page_text ) {
            $lines[] = '<li><a href="' . get_permalink( $order_tracking_page ) . '" class="dropdown-item">' . ( !empty( $support_icon ) ? '<i class="' . esc_attr( $order_tracking_page_icon ) . ' text-muted mr-2"></i>' : '' ) . esc_html( $order_tracking_page_text ) . '</a></li>';
        }

        $lines = apply_filters( 'cartzilla_topbar_handheld_dropdown_content', $lines );

        if( ! empty( $lines ) ) :
            ?>
            <div class="topbar-text dropdown d-md-none" data-cz-customizer="topbar_handheld_dropdown">
                <a class="topbar-link dropdown-toggle" href="#" data-toggle="dropdown" aria-expanded="false"><?php echo esc_html( $dropdown_title ); ?></a>
                <ul class="dropdown-menu<?php if( !empty( $dropdown_postion ) ) echo esc_attr( ' dropdown-menu-' . $dropdown_postion ); ?>">
                    <?php echo implode( '', $lines ); ?>
                </ul>
            </div>
            <?php
        endif;
    }
}

/**
 * Display the promo line(s) in Topbar section
 */
if( ! function_exists( 'cartzilla_topbar_promo' ) ) {
    function cartzilla_topbar_promo() {
        $promo = apply_filters( 'cartzilla_enable_topbar_promo', get_theme_mod( 'topbar_promo' ) );

        $lines = [];
        if ( $promo ) {
            $lines = array_map( function ( $line ) {
                return '<div class="topbar-text">' . wp_kses_post( trim( $line ) ) . '</div>';
            }, explode( PHP_EOL, $promo ) );
        }

        if ( $promo ) : ?>
            <div class="cz-carousel cz-controls-static d-none d-md-block" data-cz-customizer="topbar_promo">
                <div class="cz-carousel-inner" data-carousel-options='{"mode":"gallery", "nav": false}'>
                    <?php echo implode( '', $lines ); ?>
                </div>
            </div>
        <?php elseif ( is_customize_preview() ) : ?>
            <div class="cz-carousel cz-controls-static d-none d-md-block" data-cz-customizer="topbar_promo">
                <div class="cz-carousel-inner" data-carousel-options='{"mode": "gallery", "nav": false}'>
                    <div class="topbar-text"><?php esc_html_e( 'Free shipping for order over $200', 'cartzilla' ) ?></div>
                    <div class="topbar-text"><?php esc_html_e( 'We return money within 30 days', 'cartzilla' ) ?></div>
                    <div class="topbar-text"><?php esc_html_e( 'Friendly 24/7 customer support', 'cartzilla' ) ?></div>
                </div>
            </div>
        <?php
        endif;
    }
}

if ( ! function_exists( 'cartzilla_site_info_support' ) ):
    /**
     * Displays Support Information
     *
     */
    function cartzilla_site_info_support() {
        $support_link  = apply_filters( 'cartzilla_site_info_support_link',  get_theme_mod( 'support_info_link', 'tel:+100331697720' ) );
        $support_icon  = apply_filters( 'cartzilla_site_info_support_icon',  get_theme_mod( 'support_info_icon', 'czi-support' ) );
        $support_title = apply_filters( 'cartzilla_site_info_support_title', get_theme_mod( 'support_info_title', 'Support') );
        $support_text  = apply_filters( 'cartzilla_site_info_support_text',  get_theme_mod( 'support_info_text', '+1 (00) 33 169 7720' ) );


        if ( apply_filters( 'cartzilla_enable_support_info','yes' === get_theme_mod( 'support_info', 'yes' ) ) ) : ?>
            <div class="d-flex mb-3">
                <i class="<?php echo esc_attr( $support_icon ); ?> h4 mb-0 font-weight-normal text-primary mt-1 mr-1"></i>
                <div class="pl-2">
                    <div class="text-muted font-size-sm"><?php echo esc_html( $support_title ); ?></div>
                    <a class="nav-link-style font-size-md" href="<?php echo esc_url( $support_link ); ?>"><?php echo wp_kses_post( $support_text ); ?></a>
                </div>
            </div><?php
        endif;
    }
endif;

if ( ! function_exists( 'cartzilla_site_info_contact' ) ):
    /**
     * Displays Support Information
     *
     */
    function cartzilla_site_info_contact() {
        $contact_link  = apply_filters( 'cartzilla_site_info_contact_link',  get_theme_mod( 'contact_info_link', 'mailto:customer@example.com' ) );
        $contact_icon  = apply_filters( 'cartzilla_site_info_contact_icon',  get_theme_mod( 'contact_info_icon', 'czi-mail' ) );
        $contact_title = apply_filters( 'cartzilla_site_info_contact_title', get_theme_mod( 'contact_info_title', 'Email' ) );
        $contact_text  = apply_filters( 'cartzilla_site_info_contact_text',  get_theme_mod( 'contact_info_text', 'customer@example.com' ) );

        if ( 'yes' === get_theme_mod( 'contact_info', 'yes' ) ) : ?>
            <div class="d-flex mb-3">
                <i class="<?php echo esc_attr( $contact_icon ); ?> h5 mb-0 font-weight-normal text-primary mt-1 mr-1"></i>
                <div class="pl-2">
                    <div class="text-muted font-size-sm"><?php echo esc_html( $contact_title ); ?></div><a class="nav-link-style font-size-md" href="<?php echo esc_url( $contact_link ); ?>"><?php echo wp_kses_post( $contact_text ); ?></a>
                </div>
          </div><?php
      endif;
    }
endif;

/**
 * Display the site footer
 *
 * @return array
 */
if( ! function_exists( 'cartzilla_footer' ) ) {
    function cartzilla_footer() {
        global $post;
        $static_content_id = apply_filters( 'cartzilla_footer_static_content_id', '' );

        if ( is_page() && isset( $post->ID ) ) {
            $clean_page_meta_values = get_post_meta( $post->ID, '_footerStaticContentId', true );

            if ( isset( $clean_page_meta_values ) && $clean_page_meta_values ) {
                $static_content_id = $clean_page_meta_values;
            }
        }

        if( cartzilla_is_mas_static_content_activated() && ! empty( $static_content_id ) ) {
            echo do_shortcode( '[mas_static_content id=' . $static_content_id . ' wrap=0]' );
        } else {

            $layout = cartzilla_footer_version();
            get_template_part( 'templates/footer/footer', $layout );

        }
    }
}


/**
 * Returns the slug used to load the right footer template
 *
 * @return string
 *
 * @see footer.php
 * @see templates/footer/*.php
 */
if( ! function_exists( 'cartzilla_footer_version' ) ) {
    function cartzilla_footer_version() {
        $version = get_theme_mod( 'footer_version', 'v1' );

        /**
         * Filter the footer slug
         *
         * NOTE: this is a part of the file name, so if you want to add a custom
         * version in the child theme you have to follow the file name convention.
         *
         * Your file should be named {$version}.php
         *
         * You can add your custom template part to
         * /theme-child/templates/footer/{$version}.php
         *
         * @param string $version Version
         */
        return sanitize_key( apply_filters( 'cartzilla_footer_version', $version ) );
    }
}

/**
 * Returns the slug used to load the right footer template
 *
 * @return string
 *
 * @see footer.php
 * @see templates/footer/*.php
 */
if( ! function_exists( 'cartzilla_footer_layout' ) ) {
    function cartzilla_footer_layout() {
        $layout = apply_filters( 'cartzilla_footer_type', get_theme_mod( 'footer_type', 'dark' ) );

        /**
         * Filter the footer slug
         *
         * NOTE: this is a part of the file name, so if you want to add a custom
         * layout in the child theme you have to follow the file name convention.
         *
         * Your file should be named footer-{$layout}.php
         *
         * You can add your custom template part to
         * /theme-child/templates/footer/footer-{$layout}.php
         *
         * @param string $layout Layout
         */
        return sanitize_key( apply_filters( 'cartzilla_footer_layout', $layout ) );
    }
}

/**
 * Returns the logo for use in footer section
 *
 * @return string
 */
if( ! function_exists( 'cartzilla_get_footer_logo' ) ) {
    function cartzilla_get_footer_logo() {

        $logo_id = (int) get_theme_mod( 'footer_logo' );
        $footer_custom_logo_id = apply_filters( 'cartzilla_custom_footer_logo', '');
        if ( !empty ($footer_custom_logo_id)) {
            $footer_custom_logo_attr = [
                'class' => 'footer-logo',
            ];

            // If the logo alt attribute is empty, get the site title
            $footer_custom_logo_alt = get_post_meta( $footer_custom_logo_id, '_wp_attachment_image_alt', true );
            if ( empty( $footer_custom_logo_alt ) ) {
                $footer_custom_logo_attr['alt'] = get_bloginfo( 'name', 'display' );
            }

            $footer_custom_logo_meta  = wp_get_attachment_metadata( $footer_custom_logo_id );
            $footer_custom_logo_width = isset( $footer_custom_logo_meta['width'] ) ? (int) $footer_custom_logo_meta['width'] : 284;

            $html = sprintf(
                '<a href="%1$s" class="d-inline-block align-middle mt-n1 mr-3 footer-logo-link" rel="home" style="width: %3$dpx;">%2$s</a>',
                esc_url( home_url( '/' ) ),
                wp_get_attachment_image( $footer_custom_logo_id, 'full', false, $footer_custom_logo_attr ),
                (float) $footer_custom_logo_width / 2
            );

        } elseif ( $logo_id ) {

            $attr = [
                'class' => 'footer-logo d-block',
            ];

            // If the logo alt attribute is empty, get the site title
            $alt = get_post_meta( $logo_id, '_wp_attachment_image_alt', true );
            if ( empty( $alt ) ) {
                $attr['alt'] = get_bloginfo( 'name', 'display' );
            }

            $meta  = wp_get_attachment_metadata( $logo_id );
            $width = isset( $meta['width'] ) ? (int) $meta['width'] : 284;

            $html = sprintf(
                '<a href="%1$s" class="d-inline-block align-middle mt-n1 mr-3 footer-logo-link" rel="home" style="width: %3$dpx;">%2$s</a>',
                esc_url( home_url( '/' ) ),
                wp_get_attachment_image( $logo_id, 'full', false, $attr ),
                (float) $width / 2
            );

        }  elseif( apply_filters( 'cartzilla_default_logo', false ) ) {
            // Fallback logo may be light or dark depending on current header layout
            $cur_footer = cartzilla_footer_layout();
            $variant    = in_array( $cur_footer, [ 'dark' ] ) ? 'light' : 'dark';

            $img = sprintf( '<img src="%s" alt="%s" class="footer-logo d-block">',
                esc_url( get_template_directory_uri() . "/assets/img/footer-logo-{$variant}.png" ),
                esc_attr( get_bloginfo( 'name', 'display' ) )
            );

            $html = sprintf(
                '<a href="%1$s" class="d-inline-block align-middle mt-n1 mr-3 footer-logo-link" rel="home" style="width: 142px;">%2$s</a>',
                esc_url( home_url( '/' ) ),
                $img
            );
        } else {
            $html = sprintf(
                '<h1 class="site-title mb-0"><a href="%1$s" class="d-inline-block align-middle mt-n1 mr-3 footer-logo-link" rel="home">%2$s</a></h1>',
                esc_url( home_url( '/' ) ),
                get_bloginfo( 'name', 'display' )
            );
        }

        return (string) apply_filters( 'cartzilla_footer_logo', $html );
    }
}

/**
 * Display a logo in footer
 */
if( ! function_exists( 'cartzilla_footer_logo' ) ) {
    function cartzilla_footer_logo() {
        echo cartzilla_get_footer_logo();
    }
}

/**
 * Returns the Payment Methods displayed in footer (or any other image)
 *
 * TODO: make sure customizer preview works properly
 *
 * @return string
 */
if( ! function_exists( 'cartzilla_get_footer_pm' ) ) {
    function cartzilla_get_footer_pm() {
        $html = '';
        if ( apply_filters( 'cartzilla_enable_footer_payment_method' , true ) ) {
            $attachment_id = get_theme_mod( 'footer_payment_methods' );
            $custom_payment_id = apply_filters('footer_custom_payment_methods', '' );
            if ( $custom_payment_id ) {
                $custom_meta  = wp_get_attachment_metadata( $custom_payment_id );
                $width = (int) $custom_meta['width'];

                $html = sprintf( '<div class="d-inline-block payment-methods" style="width: %dpx">%s</div>',
                    (float) $width / 2,
                    wp_get_attachment_image( $custom_payment_id, 'full' )
                );
            } elseif ( $attachment_id ) {
                $meta  = wp_get_attachment_metadata( $attachment_id );
                $width = (int) $meta['width'];

                $html = sprintf( '<div class="d-inline-block payment-methods" style="width: %dpx">%s</div>',
                    (float) $width / 2,
                    wp_get_attachment_image( $attachment_id, 'full' )
                );
            } elseif ( is_customize_preview() ) {
                $html = '<div class="d-inline-block payment-methods"><img></div>';
            }
        }

        return (string) apply_filters( 'cartzilla_footer_payment_methods', $html );
    }
}

/**
 * Display the "Payment Methods" image in footer
 */
if( ! function_exists( 'cartzilla_footer_pm' ) ) {
    function cartzilla_footer_pm() {
        echo cartzilla_get_footer_pm();
    }
}

/**
 * Display the footer menu
 */
if( ! function_exists( 'cartzilla_footer_menu' ) ) {
    function cartzilla_footer_menu() {
        if ( ! has_nav_menu( 'footer' ) ) {
            return;
        }

        $footerPrimaryMenuSlug = apply_filters( 'cartzilla_footer_menu' , '' );

        $nav_menu_args = apply_filters( 'cartzilla_footer_menu_args', [
            'theme_location' => 'footer',
            'fallback_cb'    => false,
            'depth'          => 1,
            'items_wrap'     => '<ul class="%2$s">%3$s</ul>',
            'container'      => false,
            'menu_class'     => 'd-flex flex-wrap justify-content-center justify-content-md-start footer-menu',
            'walker'         => new WP_Bootstrap_Navwalker(),
            'classes'        => array(
                'nav-link'        => '',
                'dropdown-toggle' => 'dropdown-toggle',
                'dropdown'        => 'dropdown',
                'dropdown-item'   => 'dropdown-item',
                'dropdown-menu'   => array( 'sub-menu', 'dropdown-menu' )
            )
        ] );

        if( ! empty ( $footerPrimaryMenuID ) && $footerPrimaryMenuID > 0 ) {
            $nav_menu_args['menu'] = $footerPrimaryMenuID;
        } elseif( ! empty( $footerPrimaryMenuSlug ) ) {
            $nav_menu_args['menu'] = $footerPrimaryMenuSlug;
        }

        wp_nav_menu( $nav_menu_args );
    }
}

/**
 * Display the footer social menu
 */
if( ! function_exists( 'cartzilla_social_menu' ) ) {
    function cartzilla_social_menu() {
        $layout = function_exists( 'cartzilla_footer_layout' ) ? cartzilla_footer_layout() : 'dark';
        $footer = function_exists( 'cartzilla_footer_version' ) ? cartzilla_footer_version() : 'v1';
        $footerSocialMenuId = apply_filters( 'cartzilla_footer_social_menu' , '' );

        if ( has_nav_menu( 'social_media' ) && apply_filters( 'cartzilla_enable_footer_social_icons', true ) ) {
            $social_menu_args = array(
                'theme_location'    => 'social_media',
                'container'         => false,
                'menu_class'        => 'social-menu list-inline mb-0',
                'depth'             => 1,
                'item_class'        => 'list-inline-item mr-0',
                'walker'            => new WP_Bootstrap_Navwalker(),
                'disable_schema'    => true,
                'disable_data_attr' => true,
                'classes'        => array(
                    'nav-link'        => 'social-btn mb-2 '. esc_attr( $footer == 'v1' ? 'ml-2' : 'mr-1' ).' ' . esc_attr( $layout == 'light' ? 'sb-outline' : 'sb-light' ) . '',
                )
            );

            if( ! empty ( $footerSocialMenuId ) && $footerSocialMenuId > 0 ) {
                $social_menu_args['menu'] = $footerSocialMenuId;
            } elseif( ! empty( $footerSocialMenuSlug ) ) {
                $social_menu_args['menu'] = $footerSocialMenuSlug;
            }

            wp_nav_menu( $social_menu_args );
        }
    }
}

if( ! function_exists( 'cartzilla_footer_statistics' ) ) {
    function cartzilla_footer_statistics() {
        $layout = function_exists( 'cartzilla_footer_layout' ) ? cartzilla_footer_layout() : 'dark';
        $site_id =  get_current_blog_id();
        $site_users = count_users( 'time', $site_id );
        $all_statistics = array();

        if( cartzilla_is_woocommerce_activated() && apply_filters( 'cartzilla_footer_statistics_products', true ) ) {
            $total_products = count( get_posts( array('post_type' => 'product', 'post_status' => 'publish', 'fields' => 'ids', 'posts_per_page' => '-1') ) );
            $all_statistics['product'] = array(
                'title'     => esc_html__( 'Products', 'cartzilla' ),
                'value'     => $total_products,
                'priority'  => 10,
            );
        }

        if( apply_filters( 'cartzilla_footer_statistics_members', true ) ) {
            $all_statistics['members'] = array(
                'title'     => esc_html__( 'Members', 'cartzilla' ),
                'value'     => $site_users['total_users'],
                'priority'  => 20,
            );
        }

        if( cartzilla_is_dokan_activated() && apply_filters( 'cartzilla_footer_statistics_sellers', true ) && isset( $site_users['avail_roles'] ) && isset( $site_users['avail_roles']['seller'] ) ) {
            $all_statistics['sellers'] = array(
                'title'     => esc_html__( 'Vendors', 'cartzilla' ),
                'value'     => $site_users['avail_roles']['seller'],
                'priority'  => 30,
            );
        }

        $all_statistics = apply_filters( 'cartzilla_footer_statistics', $all_statistics );

        if( ! empty( $all_statistics ) ) {
            uasort( $all_statistics, 'cartzilla_sort_priority_callback' );
            $last_key = key( array_slice( $all_statistics, -1 ) );
            foreach ( $all_statistics as $key => $statistics ) {
                $classes = 'd-inline-block mr-3';

                if( $key !== $last_key ) {
                    $classes .= ' pr-3 border-right';

                    if( $layout === 'dark' ) {
                        $classes .= ' border-light';
                    } else {
                        $classes .= ' border-dark';
                    }
                }

                ?>
                <h6 class="<?php echo esc_attr( $classes ); ?>">
                    <span class="text-primary"><?php echo esc_html( $statistics['value'] ); ?></span> 
                    <span class="font-weight-normal <?php echo esc_attr( $layout === 'dark' ? 'text-white' : 'text-secondery' ); ?>"><?php echo esc_html( $statistics['title'] ); ?></span>
                </h6>
                <?php
            }
        }
    }
}

if( ! function_exists( 'cartzilla_header_social_menu' ) ) {
    function cartzilla_header_social_menu() {
        if ( has_nav_menu( 'social_media' ) && apply_filters( 'cartzilla_enable_header_social_icons', 'yes' === get_theme_mod( 'header_social_menu', 'yes' ) ) ) {
            $social_links_title = apply_filters( 'cartzilla_header_social_menu_title', get_theme_mod( 'header_social_menu_title', 'Follow us' ) ); 
            if ( !empty ( $social_links_title )) {
                ?><h6 class="pt-2 pb-1"><?php echo wp_kses_post( $social_links_title ); ?></h6><?php
            }

            wp_nav_menu( array(
                'theme_location'    => 'social_media',
                'container'         => false,
                'menu_class'        => 'social-menu list-inline mb-0',
                'depth'             => 1,
                'item_class'        => 'list-inline-item mr-0',
                'walker'            => new WP_Bootstrap_Navwalker(),
                'disable_schema'    => true,
                'disable_data_attr' => true,
                'classes'        => array(
                    'nav-link'        => 'social-btn mr-2 mb-2 sb-outline',
                )
            ) );
        }
    }
}

if ( ! function_exists( 'cartzilla_footer_static_content' ) ) {
    /**
     * Display the static content in footer
     */
    function cartzilla_footer_static_content() {
        $layout = function_exists( 'cartzilla_footer_layout' ) ? cartzilla_footer_layout() : 'dark';

        $footerStaticContentId = apply_filters( 'cartzilla_footer_static_block_id', get_theme_mod( 'cartzilla_footer_jumbotron', '' ) );

        if( cartzilla_is_mas_static_content_activated() && ! empty( $footerStaticContentId ) ) {
            echo do_shortcode( '[mas_static_content id=' . $footerStaticContentId . ' class="footer-static-content"]' ); ?>
            <hr class="<?php if( $layout == 'dark' ) echo esc_attr( 'hr-light ' ) ?>pb-4 mb-3"><?php
        }
        
    }
}

/**
 * Returns the markup for a single icon displayed in Footer Services section
 *
 * @param string $icon
 *
 * @return string
 */
if( ! function_exists( 'cartzilla_get_footer_service_icon' ) ) {
    function cartzilla_get_footer_service_icon( $icon = '' ) {
        $html = '';
        if ( $icon ) {
            $html = sprintf(
                '<span class="service-icon"><i class="%s text-primary" style="font-size: 2.25rem;"></i></span>',
                sanitize_key( $icon )
            );
        } elseif ( is_customize_preview() ) {
            $html = '<span class="service-icon"></span>';
        }

        return (string) apply_filters( 'cartzilla_footer_service_icon', $html, $icon );
    }
}

/**
 * Echoes the icon of single service in Footer Services section
 *
 * @param string $icon Typically the result of {@see get_theme_mod()} call.
 */
if( ! function_exists( 'cartzilla_footer_service_icon' ) ) {
    function cartzilla_footer_service_icon( $icon = '' ) {
        echo cartzilla_get_footer_service_icon( $icon );
    }
}

/**
 * Returns the markup for a single title displayed in Footer Services section
 *
 * @param string $title
 *
 * @return string
 */
if( ! function_exists( 'cartzilla_get_footer_service_title' ) ) {
    function cartzilla_get_footer_service_title( $title = '' ) {
        $html = '';
        if ( $title ) {
            $html = sprintf( '<span class="service-title">%s</span>', esc_html( $title ) );
        } elseif ( is_customize_preview() ) {
            $html = '<span class="service-title"></span>';
        }

        return (string) apply_filters( 'cartzilla_footer_service_title', $html, $title );
    }
}

/**
 * Echoes the title of single service in Footer Services section
 *
 * @param string $title Typically the result of {@see get_theme_mod()} call.
 */
if( ! function_exists( 'cartzilla_footer_service_title' ) ) {
    function cartzilla_footer_service_title( $title = '' ) {
        echo cartzilla_get_footer_service_title( $title );
    }
}

/**
 * Returns the markup for a single title displayed in Footer Services section
 *
 * @param string $subtitle
 *
 * @return string
 */
if( ! function_exists( 'cartzilla_get_footer_service_subtitle' ) ) {
    function cartzilla_get_footer_service_subtitle( $subtitle = '' ) {
        $html = '';
        if ( $subtitle ) {
            $html = sprintf( '<span class="service-subtitle">%s</span>', esc_html( $subtitle ) );
        } elseif ( is_customize_preview() ) {
            $html = '<span class="service-subtitle"></span>';
        }

        return (string) apply_filters( 'cartzilla_footer_service_subtitle', $html, $subtitle );
    }
}

/**
 * Echoes the subtitle of single service in Footer Services section
 *
 * @param string $subtitle Typically the result of {@see get_theme_mod()} call.
 */
if( ! function_exists( 'cartzilla_footer_service_subtitle' ) ) {
    function cartzilla_footer_service_subtitle( $subtitle = '' ) {
        echo cartzilla_get_footer_service_subtitle( $subtitle );
    }
}

/**
 * Enable or disable copyright
 *
 * @return bool
 */
if( ! function_exists( 'cartzilla_is_copyright' ) ) {
    function cartzilla_is_copyright() {
        return (bool) apply_filters( 'cartzilla_is_copyright', '' !== get_theme_mod( 'copyright' ) );
    }
}

/**
 * Get site copyright
 *
 * @return string
 */
if( ! function_exists( 'cartzilla_get_copyright' ) ) {
    function cartzilla_get_copyright() {
        /* translators: site copyright */
        $default   = wp_kses_post( __( '&copy; All rights reserved. Made by <a href="https://createx.studio/" target="_blank" rel="noopener noreferrer">Createx Studio</a>', 'cartzilla' ) );
        $copyright = get_theme_mod( 'copyright', $default );

        return (string) apply_filters( 'cartzilla_copyright', $copyright );
    }
}

/**
 * Display a copyright in footer
 */
if( ! function_exists( 'cartzilla_copyright' ) ) {
    function cartzilla_copyright() {
        echo cartzilla_get_copyright();
    }
}

/**
 * Display scroll to top button
 *
 * @hooked cartzilla_footer_after 100
 */
if( ! function_exists( 'cartzilla_scroll_to_top' ) ) {
    function cartzilla_scroll_to_top() {
        if ( false === (bool) apply_filters( 'cartzilla_scroll_to_top', true ) ) {
            return;
        }

        ?>
        <a class="btn-scroll-top" href="#" data-scroll="true">
            <span class="btn-scroll-top-tooltip text-muted font-size-sm mr-2"><?php
                /* translators: action for scroll to top button */
                esc_html_e( 'Top', 'cartzilla' ); ?></span>
            <i class="btn-scroll-top-icon czi-arrow-up"></i>
        </a>
        <?php
    }
}

/**
 * Returns  the string in the "more" link displayed after a trimmed excerpt
 *
 * @hooked excerpt_more 10
 *
 * @return string
 */
if( ! function_exists( 'cartzilla_excerpt_more' ) ) {
    function cartzilla_excerpt_more() {
        return '...';
    }
}

/**
 * Remove all HTML tags from the excerpt
 *
 * @hooked the_excerpt 20
 *
 * @param string $output The excerpt
 *
 * @return string
 */
if( ! function_exists( 'cartzilla_the_excerpt' ) ) {
    function cartzilla_the_excerpt( $output ) {
        return strip_tags( $output );
    }
}

/**
 * Prints meta information for the current post-date/time.
 */
if( ! function_exists( 'cartzilla_posted_on' ) ) {
    function cartzilla_posted_on() {
        echo esc_html( get_the_date() );
    }
}

/**
 * Prints HTML with meta information for the current author.
 */
if( ! function_exists( 'cartzilla_posted_by' ) ) {
    function cartzilla_posted_by() {
        if ( ! cartzilla_post_is_author() ) {
            return;
        }

        $author_id = get_the_author_meta( 'ID' );
        $author    = get_the_author();

        echo sprintf(
            '<a class="blog-entry-meta-link" href="%1$s">
                <div class="blog-entry-author-ava">%3$s</div>
                %2$s
            </a>',
            esc_url( get_author_posts_url( $author_id ) ),
            esc_html( $author ),
            get_avatar( $author_id, 52, '', $author )
        );
    }
}

/**
 * Displays a paginated navigation to next/previous set of posts, when applicable.
 *
 * Used in blog (home), archives, search
 *
 * @since 1.0.0
 */
if( ! function_exists( 'cartzilla_pagination' ) ) {
    function cartzilla_pagination() {
        $max_pages = isset( $GLOBALS['wp_query']->max_num_pages ) ? $GLOBALS['wp_query']->max_num_pages : 1;
        if ( $max_pages < 2 ) {
            return;
        }

        $paged = get_query_var( 'paged' ) ? (int) get_query_var( 'paged' ) : 1;
        $links = paginate_links( apply_filters( 'cartzilla_posts_pagination_args', [
            'type'      => 'array',
            'mid_size'  => 2,
            'prev_next' => false,
        ] ) );

        ?>
        <nav class="d-flex justify-content-between pt-2" aria-label="<?php
        /* translators: aria-label for posts navigation wrapper */
        echo esc_attr_x( 'Posts navigation', 'front-end', 'cartzilla' ); ?>">
            <ul class="pagination">
                <?php if ( $paged && 1 < $paged ) : ?>
                    <li class="page-item">
                        <a class="page-link" href="<?php echo esc_url( get_previous_posts_page_link() ); ?>">
                            <i class="czi-arrow-left mr-2"></i>
                            <?php
                            /* translators: label for previous posts link */
                            echo esc_html_x( 'Prev', 'front-end', 'cartzilla' ); ?>
                        </a>
                    </li>
                <?php endif; ?>
            </ul>
            <ul class="pagination">
                <li class="page-item d-sm-none">
                    <span class="page-link page-link-static"><?php echo esc_html( "{$paged} / {$max_pages}" ); ?></span>
                </li>
                <?php foreach ( $links as $link ) : ?>
                    <?php if ( false !== strpos( $link, 'current' ) ) : ?>
                        <li class="page-item active d-none d-sm-block">
                            <?php echo str_replace( 'page-numbers', 'page-link', $link ); ?>
                        </li>
                    <?php else : ?>
                        <li class="page-item d-none d-sm-block">
                            <?php echo str_replace( 'page-numbers', 'page-link', $link ); ?>
                        </li>
                    <?php endif; ?>
                <?php endforeach; ?>
            </ul>
            <ul class="pagination">
                <?php if ( $paged && $paged < $max_pages ) : ?>
                    <li class="page-item">
                        <a class="page-link" href="<?php echo esc_url( get_next_posts_page_link() ); ?>">
                            <?php
                            /* translators: label for next posts link */
                            echo esc_html_x( 'Next', 'front-end', 'cartzilla' ); ?>
                            <i class="czi-arrow-right ml-2"></i>
                        </a>
                    </li>
                <?php endif; ?>
            </ul>
        </nav>
        <?php
    }
}

/**
 * Returns the sidebar used for posts listing.
 *
 * @return string
 *
 * @see index.php
 * @see archive.php
 * @see templates/blog/posts-*.php
 */
if( ! function_exists( 'cartzilla_posts_sidebar' ) ) {
    function cartzilla_posts_sidebar() {
        $sidebar = get_theme_mod( 'blog_sidebar', 'right-sidebar' );

        if( ! is_active_sidebar( 'blog-sidebar' ) ) {
            $sidebar = 'no-sidebar';
        }

        return sanitize_key( apply_filters( 'cartzilla_posts_sidebar', $sidebar ) );
    }
}

/**
 * Returns the template slug used for posts listing.
 *
 * @return string
 *
 * @see index.php
 * @see archive.php
 * @see templates/blog/posts-*.php
 */
if( ! function_exists( 'cartzilla_posts_layout' ) ) {
    function cartzilla_posts_layout() {
        $layout = get_theme_mod( 'blog_layout', 'list' );

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
        return sanitize_key( apply_filters( 'cartzilla_posts_layout', $layout ) );
    }
}

/**
 * Returns the template slug used for posts listing when posts not found
 *
 * @return string
 *
 * @see index.php
 * @see archive.php
 * @see templates/blog/none-*.php
 */
if( ! function_exists( 'cartzilla_posts_not_found_layout' ) ) {
    function cartzilla_posts_not_found_layout() {
        $layout = cartzilla_posts_sidebar();

        /**
         * Filter the layout type
         *
         * NOTE: this is a part of the file name, so if you want to add a custom
         * layout in the child theme you have to follow the file name convention.
         * Your file should be named none[-{$layout}].php
         *
         * You can add your custom template part to
         * /theme-child/templates/blog/none[-{$layout}].php
         *
         * @param string $layout
         */
        return sanitize_key( apply_filters( 'cartzilla_posts_not_found_layout', $layout ) );
    }
}



/**
 * Display the Page Title in blog (posts listing)
 *
 * This function uses "cartzilla_is_posts_title" filter, which allows to control
 * Page Title visibility. You can completely disable page title:
 *
 *     add_filter( 'cartzilla_is_posts_title', '__return_false' );
 *
 * @hooked cartzilla_posts_before 50
 */
if( ! function_exists( 'cartzilla_posts_title' ) ) {
    function cartzilla_posts_title() {
        if ( ! (bool) apply_filters( 'cartzilla_is_posts_title', true ) ) {
            return;
        }

        if ( is_home() && 'posts' == get_option( 'show_on_front' ) ) {
            // for home page without static page
            $title = get_theme_mod( 'blog_title', esc_html_x( 'Blog', 'front-end', 'cartzilla' ) );
        } elseif ( is_home() && ! is_front_page() ) {
            // applicable for home with static page
            $title = single_post_title( '', false );
        } elseif ( is_archive() ) {
            // archive page
            $title = get_the_archive_title(); 
        }

        if ( empty( $title ) ) {
            $title = apply_filters( 'cartzilla_blog_title', esc_html_x( 'Blog', 'front-end', 'cartzilla' ) );
        }

        $background = get_theme_mod( 'blog_title_background', 'light' );

        ?>
        <div class="page-title py-4 <?php echo esc_attr( $background == 'light' ? 'bg-secondary' : 'bg-dark' ) ?>">
            <div class="<?php echo ! ( function_exists( 'cartzilla_get_shop_page_style' ) && cartzilla_get_shop_page_style() === 'style-v3' ) ? 'container' : 'container-fluid';?> d-lg-flex justify-content-between py-2 py-lg-3">
                <div class="order-lg-2 mb-3 mb-lg-0 pt-lg-2">
                    <?php cartzilla_breadcrumbs(); ?>
                </div>
                <div class="order-lg-1 pr-lg-4 text-center text-lg-left">
                    <h1 class="h3 mb-0<?php if( $background !== 'light' ) echo esc_attr( ' text-light' ) ?>"><?php echo strip_tags( $title ); ?></h1>
                </div>
            </div>
        </div>
        <?php
    }
}

if ( ! function_exists( 'cartzilla_popular_posts' ) ) {
    function cartzilla_popular_posts() { 
        if ( is_paged() ) {
            return;
        }

        if ( apply_filters( 'cartzilla_enable_popular_posts', 'yes' === get_theme_mod( 'enable_popular_posts', 'no' ) ) ) {

            $popular_posts_args =apply_filters( 'cartzilla_popular_posts_args', [
                'posts_type' => 'post',
                'post_status' => 'publish',
                'posts_per_page' => 5,
                'orderby' => 'comment_count',
                'order'=> 'DESC',
                'ignore_sticky_posts' => true,
                'meta_query'          => [
                    [
                        'key'     => '_thumbnail_id',
                        'compare' => 'EXISTS',
                    ],
                ]
            ] );

            $popular_posts_loop = new WP_Query( $popular_posts_args );

            if ( ! $popular_posts_loop->have_posts() ) {
                return;
            }

            $carousel_options = apply_filters( 'cartzilla_popular_posts_carousel_options', [
                'items'        => 2,
                'nav'          => false,
                'autoHeight'   => true,
                'rtl'          => is_rtl() ? true : false,
                'textDirection' => 'ltr',
                'responsive' => [
                    '0'     => [ 'items' => 1 ],
                    '480'   => [ 'items' => 1 ],
                    '768'   => [ 'items' => 2, 'gutter' => 20 ],
                    '992'   => [ 'items' => 2, 'gutter' => 30 ],
                    '1200'  => [ 'items' => 2 ],
                ]
            ] );

            ?>
            <div class="featured-posts-carousel cz-carousel pt-5" dir="ltr">
                <div class="cz-carousel-inner" data-carousel-options="<?php echo esc_attr( json_encode( $carousel_options ) ); ?>">
                    <?php while( $popular_posts_loop->have_posts() ): $popular_posts_loop->the_post(); ?>
                        <?php get_template_part( 'templates/blog/content', 'featured' ); ?>
                    <?php endwhile; ?>
                    <?php wp_reset_postdata(); ?>
                </div>
            </div>
            <?php
        }
    }
}

/**
 * Returns the slug for a template used to display single post
 *
 * Single post layout is depends on Blog Layout setting in Customizer.
 * If user wants one without a sidebar we should not load it no matter active it or not.
 *
 * @return string
 *
 * @see single.php
 * @see templates/blog/post-*.php
 */
if( ! function_exists( 'cartzilla_post_layout' ) ) {
    function cartzilla_post_layout() {
        $blog_single_layout = get_theme_mod( 'blog_single_layout', 'right-sidebar' );

        if ( ! is_active_sidebar( 'blog-sidebar' ) ) {
            $blog_single_layout = 'no-sidebar';
        }

        /**
         * Filter the layout slug
         *
         * NOTE: this is a part of the file name, so if you want to add a custom
         * layout in the child theme you have to follow the file name convention.
         * Your file should be named post-{$layout}.php
         *
         * You can add your custom template part to
         * /theme-child/templates/blog/post-{$layout}.php
         *
         * @param string $layout Layout
         */
        return sanitize_key( apply_filters( 'cartzilla_post_layout', $blog_single_layout ) );
    }
}

/**
 * Displays the Page Title for single post
 *
 * This function uses "cartzilla_is_post_title" filter, which allows to control
 * Page Title visibility. You can completely disable page title:
 *
 *     add_filter( 'cartzilla_is_post_title', '__return_false' );
 *
 * @hooked cartzilla_single_before 50
 */
if( ! function_exists( 'cartzilla_post_title' ) ) {
    function cartzilla_post_title() {
        if ( ! (bool) apply_filters( 'cartzilla_is_post_title', true ) ) {
            return;
        }

        $background = get_theme_mod( 'blog_title_background', 'light' );

        ?>
        <div class="page-title py-4 <?php echo esc_attr( $background == 'light' ? 'bg-secondary' : 'bg-dark' ) ?>">
            <div class="<?php echo ! ( function_exists( 'cartzilla_get_shop_page_style' ) && cartzilla_get_shop_page_style() === 'style-v3' ) ? 'container' : 'container-fluid';?> d-lg-flex justify-content-between py-2 py-lg-3">
                <div class="order-lg-2 mb-3 mb-lg-0 pt-lg-2">
                    <?php cartzilla_breadcrumbs(); ?>
                </div>
                <div class="order-lg-1 pr-lg-4 text-center text-lg-left">
                    <h1 class="h3 mb-0<?php if( $background !== 'light' ) echo esc_attr( ' text-light' ) ?>"><?php single_post_title(); ?></h1>
                </div>
            </div>
        </div>
        <?php
    }
}

if( ! function_exists( 'cartzilla_single_post_container_start' ) ) {
    function cartzilla_single_post_container_start() {
        ?><div class="container pb-5"><?php
    }
}

if( ! function_exists( 'cartzilla_single_post_row_start' ) ) {
    function cartzilla_single_post_row_start() {
        $blog_layout = function_exists( 'cartzilla_post_layout' ) ? cartzilla_post_layout() : 'right-sidebar';
        $has_sidebar = in_array( $blog_layout, [ 'left-sidebar', 'right-sidebar' ] ) ? true : false;
        ?><div class="row pt-5<?php if( ! $has_sidebar ) echo esc_attr( ' justify-content-center' ); ?>"><?php
    }
}

if( ! function_exists( 'cartzilla_single_post_meta' ) ) {
    function cartzilla_single_post_meta() {
        ?>
        <div class="d-flex flex-wrap justify-content-between align-items-center pb-4 mt-n1">
            <?php do_action( 'cartzilla_single_post_meta_before' ); ?>
            <div class="d-flex align-items-center font-size-sm mb-2">
                <?php cartzilla_posted_by(); ?>
                <span class="blog-entry-meta-divider"></span>
                <span class="text-muted"><?php cartzilla_posted_on(); ?></span>
            </div>
            <div class="font-size-sm mb-2">
                <?php if ( comments_open() || get_comments_number() ) : ?>
                    <a class="blog-entry-meta-link text-nowrap"
                       href="<?php echo get_comments_number() ? '#comments' : '#respond'; ?>"
                       data-scroll
                    >
                        <i class="czi-message"></i>
                        <?php echo esc_html( get_comments_number() ); ?>
                    </a>
                <?php endif; ?>
            </div>
            <?php do_action( 'cartzilla_single_post_meta_after' ); ?>
        </div>
        <?php
    }
}

if( ! function_exists( 'cartzilla_single_post_media' ) ) {
    function cartzilla_single_post_media() {
        $post_format = get_post_format();

        if ( 'video' === $post_format && !empty( get_post_meta( get_the_ID(), '_video_field', true ) ) ) {
            cartzilla_post_video();    
        } elseif ( 'audio' == $post_format && !empty( get_post_meta( get_the_ID(), '_audio_field', true ) ) ) {
            cartzilla_post_audio();
        } elseif ( 'gallery' == $post_format && !empty( get_post_meta( get_the_ID(), '_gallery_images', true ) ) ) {
            cartzilla_post_gallery();
        }  elseif ( cartzilla_can_show_post_thumbnail() ) {
            cartzilla_single_post_thumbnail();
        }
    }
}

if( ! function_exists( 'cartzilla_can_show_post_thumbnail' ) ) {
    function cartzilla_can_show_post_thumbnail() {
        return apply_filters( 'cartzilla_can_show_post_thumbnail', ! post_password_required() && ! is_attachment() && has_post_thumbnail() );
    }
}

if ( ! function_exists( 'cartzilla_single_post_thumbnail' ) ) {
    function cartzilla_single_post_thumbnail() {

        if ( ! cartzilla_can_show_post_thumbnail() && ('image' !== $post_format || 'standard' !== $post_format || 'aside' !== $post_format || 'status' !== $post_format )) {
            return;
        }
        $caption = get_the_post_thumbnail_caption() ? get_the_post_thumbnail_caption() : get_post_meta(get_post_thumbnail_id(), '_wp_attachment_image_alt', true);

        ?>
        <div class="cz-gallery">
            <a class="gallery-item rounded-lg mb-grid-gutter" href="<?php the_post_thumbnail_url('full') ?>" <?php if( !empty($caption) ) echo 'data-sub-html="<h6 class=&quot;font-size-sm text-light&quot;>' . esc_html( $caption ) . '</h6>"' ?>>
                <?php the_post_thumbnail('full'); ?>
                <?php if( !empty($caption) ) : ?>
                    <span class="gallery-item-caption"><?php echo esc_html( $caption ); ?></span>
                <?php endif; ?>
            </a>
        </div>
        <?php
    }
}

if ( ! function_exists( 'cartzilla_post_gallery' ) ) {
    /**
     * Displays post gallery when applicable
     */
    function cartzilla_post_gallery() {
        $clean_post_format_gallery_meta_values = get_post_meta( get_the_ID(), '_gallery_images', true );
        $attachments = json_decode( stripslashes( $clean_post_format_gallery_meta_values ), true );
        if ( ! empty( $attachments ) ) :

            $count = count( $attachments );

            $carousel_options = apply_filters( 'cartzilla_post_gallery_carousel_options', [
                'items'        => $count > 4 ? 4 : $count,
                'nav'          => false,
                'autoHeight'   => true,
                'rtl'          => is_rtl() ? true : false,
                'responsive' => [
                    '0'     => [ 'items' => 1 ],
                    '480'   => [ 'items' => 1 ],
                    '768'   => [ 'items' => $count > 2 ? 2 : $count, 'gutter' => 20 ],
                    '992'   => [ 'items' => $count > 3 ? 3 : $count, ],
                    '1200'  => [ 'items' => $count > 4 ? 4 : $count, 'gutter' => 30 ],
                ]
            ] );

            ?>
            <div class="cz-gallery cz-carousel">
                <div class="cz-carousel-inner" data-carousel-options="<?php echo esc_attr( json_encode( $carousel_options ) ); ?>">
                    <?php foreach( $attachments as $attachment ) : 
                        $caption = !empty( $attachment['caption'] ) ? $attachment['caption'] : $attachment['alt']; ?>
                        <a class="gallery-item rounded-lg mb-grid-gutter" href="<?php echo wp_get_attachment_image( $attachment['id'], 'full' ); ?>" <?php if( !empty($caption) ) echo 'data-sub-html="<h6 class=&quot;font-size-sm text-light&quot;>' . esc_html( $caption ) . '</h6>"' ?>>
                            <?php echo wp_get_attachment_image( $attachment['id'], 'post-thumbnail' ); ?>
                            <?php if( !empty($caption) ) : ?>
                                <span class="gallery-item-caption"><?php echo esc_html( $caption ); ?></span>
                            <?php endif; ?>
                        </a>
                    <?php endforeach; ?>
                </div>
            </div>
            <?php

        endif;
    }
}

if ( ! function_exists( 'cartzilla_post_audio' ) ) {
    /**
     * Displays post audio when applicable
     */
    function cartzilla_post_audio() {
        $embed_audio  = get_post_meta( get_the_ID(), '_audio_field', true );

        if ( isset($embed_audio) && $embed_audio != '' ) {
            // Embed Audio

            if( !empty($embed_audio) ) {
                ?><div class="post-media"><?php 
                // run oEmbed for known sources to generate embed code from audio links
                echo apply_filters( 'the_content', $embed_audio )

                ?></div><!-- .article__attachment--video --><?php
            }

        }
    }
}

if ( ! function_exists( 'cartzilla_post_video' ) ) {
    /**
     * Displays post video when applicable
     */
    function cartzilla_post_video() {
        $embed_video  = get_post_meta( get_the_ID(), '_video_field', true );

        if ( isset($embed_video) && $embed_video != '' ) {
            // Embed Audio

            if( !empty($embed_video) ) {
                ?><div class="video-container post-media"><?php 
                // run oEmbed for known sources to generate embed code from audio links
                echo apply_filters( 'the_content', $embed_video )

                ?></div><!-- .article__attachment--video --><?php
            }

        }
    }
}

if( ! function_exists( 'cartzilla_single_post_contant' ) ) {
    function cartzilla_single_post_contant() {
        the_content();
        $link_pages = wp_link_pages(
        array(
            'before' => '<div class="page-links"><span class="d-block text-secondary mb-2">' . esc_html__( 'Pages:', 'cartzilla' ) . '</span><nav class="pagination mb-0">',
            'after'  => '</nav></div>',
            'link_before' => '<span class="page-link">',
            'link_after'  => '</span>',
            'echo'   => 0,
        )
    );

    $link_pages = str_replace( 'post-page-numbers', 'post-page-numbers page-item', $link_pages );
    $link_pages = str_replace( 'current', 'current active', $link_pages );
    echo wp_kses_post( $link_pages );
    }
}

if( ! function_exists( 'cartzilla_single_post_tag_share' ) ) {
    function cartzilla_single_post_tag_share() {
        ?>
        <div class="d-flex flex-wrap justify-content-between w-100 pt-2 pb-4 mb-1">
            <div class="mt-3 mr-3">
                <?php the_tags( '<div class="tagcloud">', ' ', '</div>' ); ?>
            </div>
            <?php cartzilla_shares(); ?>
        </div>
        <?php
    }
}

/**
 * Displays the theme implementation of related posts in a single post template
 *
 * @see single.php
 * @see templates/blog/post-{$layout}.php
 * @hooked cartzilla_related_posts_default
 *
 * @since 1.0.0
 */
if( ! function_exists( 'cartzilla_related_posts' ) ) {
    function cartzilla_related_posts() {
        $post_id = get_the_ID();
        $related_posts = get_post_meta( $post_id, '_relatedPosts', true );

        $related_posts = json_decode( stripslashes( $related_posts ), true );

        if ( empty( $related_posts ) ) {
            return;
        }

        $related_post_ids = array_column( $related_posts, 'id' );

        $query   = new WP_Query( [
            'post_type'           => 'post',
            'post_status'         => 'publish',
            'post__in'            => $related_post_ids,
            'posts_per_page'      => - 1,
            'ignore_sticky_posts' => true,
            'orderby'             => 'post__in',
        ] );

        if ( ! $query->have_posts() ) {
            return;
        }

        $options = apply_filters( 'cartzilla_related_posts_carousel_args', [
            'items'      => 2,
            'controls'   => false,
            'autoHeight' => true,
            'responsive' => [
                0    => [ 'items' => 1 ],
                740  => [ 'items' => 2, 'gutter' => 20 ],
                900  => [ 'items' => 3, 'gutter' => 20 ],
                1100 => [ 'items' => 3, 'gutter' => 30 ],
            ],
        ] );

        ?>
        <div class="bg-secondary py-5">
            <div class="container py-3" dir="ltr">
                <h2 class="h4 text-center pb-4"><?php
                    /* translators: related posts heading */
                    echo esc_html_x( 'You may also like', 'front-end', 'cartzilla'); ?></h2>
                <div class="cz-carousel">
                    <div class="cz-carousel-inner" data-carousel-options='<?php echo json_encode( $options ); ?>'>
                        <?php
                        while ( $query->have_posts() ):
                            $query->the_post();
                            get_template_part( 'templates/blog/loop', 'related' );
                        endwhile;
                        wp_reset_postdata(); ?>
                    </div>
                </div>
            </div>
        </div>
        <?php
    }
}

if( ! function_exists( 'cartzilla_single_post_sidebar' ) ) {
    function cartzilla_single_post_sidebar() {
        $blog_layout = function_exists( 'cartzilla_post_layout' ) ? cartzilla_post_layout() : 'right-sidebar';
        $has_sidebar = in_array( $blog_layout, [ 'left-sidebar', 'right-sidebar' ] ) ? true : false;
        ?>
        <?php if( $has_sidebar ) : ?>
            <aside class="col-lg-4">
                <?php get_sidebar(); ?>
            </aside>
        <?php endif;?>
        <?php
    }
}

if( ! function_exists( 'cartzilla_single_post_container_end' ) ) {
    function cartzilla_single_post_container_end() {
        ?></div><?php
    }
}

if( ! function_exists( 'cartzilla_single_post_row_end' ) ) {
    function cartzilla_single_post_row_end() {
        ?></div><?php
    }
}

/**
 * Show or hide author on post entry tile
 *
 * @return bool
 */
if( ! function_exists( 'cartzilla_post_is_author' ) ) {
    function cartzilla_post_is_author() {
        return (bool) apply_filters( 'cartzilla_post_is_author', true );
    }
}

/**
 * Returns HTML markup for popover content used in post prev/next navigation
 *
 * @param null|WP_Post $post
 *
 * @return string
 */
if( ! function_exists( 'cartzilla_post_get_popover' ) ) {
    function cartzilla_post_get_popover( $post = null ) {
        $post = get_post( $post );

        ob_start();
        setup_postdata( $GLOBALS['post'] =& $post );
        get_template_part( 'templates/blog/content', 'popover' );
        wp_reset_postdata();

        return ob_get_clean();
    }
}

/**
 * Returns a list of WP_Term under "category" taxonomy
 *
 * @param null|int $post_id
 *
 * @return array|WP_Term[]
 */
if( ! function_exists( 'cartzilla_post_get_categories' ) ) {
    function cartzilla_post_get_categories( $post_id = null ) {
        $post_id = $post_id ?: get_the_ID();

        $categories = get_the_terms( $post_id, 'category' );
        if ( empty( $categories ) || is_wp_error( $categories ) ) {
            return [];
        }

        return $categories;
    }
}

/**
 * Navigate though posts
 *
 * Designed to use in a single post context
 */
if( ! function_exists( 'cartzilla_post_navigation' ) ) {
    function cartzilla_post_navigation() {
        // Detect the home page url
        if ( 'page' == get_option( 'show_on_front' ) ) {
            $page_for_posts = get_option( 'page_for_posts' );
            if ( ! empty( $page_for_posts ) ) {
                $posts_url = get_permalink( $page_for_posts );
            } else {
                $posts_url = site_url();
            }
            unset( $page_for_posts );
        } else {
            $posts_url = home_url( '/' );
        }

        $prev_post = get_previous_post();
        $next_post = get_next_post();

        ?>
        <nav class="entry-navigation w-100" aria-label="<?php
        /* translators: prev/next post navigation in a single post context */
        echo esc_html_x( 'Post navigation', 'front-end', 'cartzilla' ); ?>">
            <?php if ( $prev_post ) : ?>
                <a class="entry-navigation-link" href="<?php the_permalink( $prev_post ); ?>"
                   data-toggle="popover"
                   data-placement="top"
                   data-trigger="hover"
                   data-html="true"
                   data-content="<?php echo esc_html( cartzilla_post_get_popover( $prev_post ) ); ?>"
                >
                    <i class="czi-arrow-left mr-2"></i>
                    <span class="d-none d-sm-inline"><?php
                        /* translators: previous post in post navigation */
                        echo esc_html_x( 'Prev post', 'front-end', 'cartzilla' ); ?></span>
                </a>
            <?php endif; ?>
            <a class="entry-navigation-link" href="<?php echo esc_url( $posts_url ); ?>">
                <i class="czi-view-list mr-2"></i>
                <span class="d-none d-sm-inline"><?php
                    /* translators: inside prev/next post navigation */
                    echo esc_html_x( 'All posts', 'front-end', 'cartzilla' ); ?></span>
            </a>
            <?php if ( $next_post ) : ?>
                <a class="entry-navigation-link" href="<?php the_permalink( $next_post ); ?>"
                   data-toggle="popover"
                   data-placement="top"
                   data-trigger="hover"
                   data-html="true"
                   data-content="<?php echo esc_html( cartzilla_post_get_popover( $next_post ) ); ?>"
                >
                    <span class="d-none d-sm-inline"><?php
                        /* translators: next post in post navigation */
                        echo esc_html_x( 'Next post', 'front-end', 'cartzilla' ); ?></span>
                    <i class="czi-arrow-right ml-2"></i>
                </a>
            <?php endif; ?>
        </nav>
        <?php
    }
}

/**
 * Load comments template
 *
 * This SHOULD be used within the loop.
 *
 * @since 1.0.0
 */
if( ! function_exists( 'cartzilla_comments' ) ) {
    function cartzilla_comments() {
        // If comments are open or we have at least one comment, load up the comment template.
        if ( comments_open() || get_comments_number() ) :
            comments_template();
        endif;
    }
}

/**
 * Displays navigation to next/previous set of comments, when applicable.
 *
 * @since 1.0.0
 */
if( ! function_exists( 'cartzilla_comments_navigation' ) ) {
    function cartzilla_comments_navigation() {
        if ( absint( get_comment_pages_count() ) === 1 ) {
            return;
        }

        /* translators: label for link to the previous comments page */
        $prev_text = esc_html_x( 'Older comments', 'front-end', 'cartzilla' );
        $prev_link = get_previous_comments_link( '<i class="czi-arrow-left mr-2"></i>' . $prev_text );

        /* translators: label for link to the next comments page */
        $next_text = esc_html_x( 'Newer comments', 'front-end', 'cartzilla' );
        $next_link = get_next_comments_link( $next_text . '<i class="czi-arrow-right ml-2"></i>' );

        ?>
        <nav class="navigation comment-navigation d-flex justify-content-between mt-4" role="navigation">
            <h3 class="screen-reader-text sr-only"><?php
                /* translators: navigation through comments */
                echo esc_html_x( 'Comment navigation', 'front-end', 'cartzilla' ); ?></h3>
            <?php if ( $prev_link ) : ?>
                <ul class="pagination">
                    <li class="page-item">
                        <?php echo str_replace( '<a ', '<a class="page-link" ', $prev_link ); ?>
                    </li>
                </ul>
            <?php endif; ?>
            <?php if ( $next_link ) : ?>
                <ul class="pagination">
                    <li class="page-item">
                        <?php echo str_replace( '<a ', '<a class="page-link" ', $next_link ); ?>
                    </li>
                </ul>
            <?php endif; ?>
        </nav>
        <?php
    }
}

/**
 * Don't count pingbacks or trackbacks when determining the number of comments for a post.
 *
 * Comments number is cached for 6 hours!
 *
 * @param string $count Number of comments, pingbacks and trackbacks
 *
 * @return int
 */
if( ! function_exists( 'cartzilla_comments_number' ) ) {
    function cartzilla_comments_number( $count ) {
        global $id;

        /**
         * Filter for enabling the counting pingbacks and trackbacks when
         * determining the number of comments on a post. Default is disabled.
         *
         * @param bool $is_count Default is false.
         */
        if ( null === $id || apply_filters( 'cartzilla_count_pingbacks_trackbacks', false ) ) {
            return $count;
        }

        $cache_key   = 'comments_number_for_' . $id;
        $cache_group = 'comments';

        $comment_count = wp_cache_get( $cache_key, $cache_group );
        if ( false === $comment_count ) {
            $comment_count = 0;
            $comments      = get_approved_comments( $id );
            foreach ( $comments as $comment ) {
                if ( $comment->comment_type === '' ) {
                    $comment_count ++;
                }
            }

            wp_cache_set( $cache_key, $comment_count, $cache_group, 6 * HOUR_IN_SECONDS );
        }

        return $comment_count;
    }
}

/**
 * Flush the comments number cache when the post comment count updates
 *
 * @param int $post_id Post ID
 */
if( ! function_exists( 'cartzilla_comments_number_flush' ) ) {
    function cartzilla_comments_number_flush( $post_id ) {
        $cache_key   = 'comments_number_for_' . $post_id;
        $cache_group = 'comments';

        wp_cache_delete( $cache_key, $cache_group );
    }
}

/**
 * Open the comment form wrappers
 *
 * @see cartzilla_comment_form_after()
 *
 * @hooked comment_form_top 10
 *
 * @since 1.0.0
 */
if( ! function_exists( 'cartzilla_comment_form_before' ) ) {
    function cartzilla_comment_form_before() {
        if ( function_exists( 'is_product' ) && is_product() ) {
            return;
        }

        ?>
        <div class="card border-0 box-shadow">
        <div class="card-body">
        <div class="media">
        <?php
        if ( is_user_logged_in() ) {
            $user = wp_get_current_user();
            echo get_avatar( $user->ID, 50, '', esc_html( $user->display_name ), [
                'class' => 'rounded-circle mr-3',
            ] );
        } else {
            echo get_avatar( 0, 50, '', '', [
                'class' => 'rounded-circle mr-3',
            ] );
        }
        ?><div class="media-body"><?php
    }
}

/**
 * Close the comment form wrappers
 *
 * @see cartzilla_comment_form_before()
 *
 * @hooked comment_form 10
 *
 * @since 1.0.0
 */
if( ! function_exists( 'cartzilla_comment_form_after' ) ) {
    function cartzilla_comment_form_after() {
        if ( function_exists( 'is_product' ) && is_product() ) {
            return;
        }

        ?>
        </div>
        </div>
        </div>
        </div>
        <?php
    }
}

/**
 * Edit comment reply link markup
 *
 * 1. Update set of classes
 * 2. Add icon inside <a> element
 *
 * @param string $link The HTML markup for the comment reply link.
 * @param array $args An array of arguments overriding the defaults.
 *
 * @return string
 */
if( ! function_exists( 'cartzilla_comment_reply_link' ) ) {
    function cartzilla_comment_reply_link( $link, $args ) {
        return str_replace(
            [
                'comment-reply-link',
                '\'>'
            ],
            [
                'comment-reply-link nav-link-style font-size-sm font-weight-medium',
                '\'><i class="czi-reply mr-2"></i>'
            ],
            $link
        );
    }
}

/**
 * Filters the default comment form fields.
 *
 * @param string[] $fields Array of the default comment fields.
 *
 * @return array
 */
if( ! function_exists( 'cartzilla_comment_form_default_fields' ) ) {
    function cartzilla_comment_form_default_fields( $fields ) {
        $commenter = wp_get_current_commenter();
        $is_req    = (bool) get_option( 'require_name_email', 1 );

        // Remove url field
        unset( $fields['url'] );

        // Update other fields
        $fields['author'] = sprintf(
            '<div class="form-group comment-form-author">
                <label for="author">%1$s%4$s</label>
                <input type="text" name="author" id="author" class="form-control" value="%2$s" maxlength="245" %3$s>
            </div>',
            /* translators: comment author name */
            esc_html_x( 'Your name', 'front-end', 'cartzilla' ),
            esc_attr( $commenter['comment_author'] ),
            $is_req ? 'required' : '',
            $is_req ? '<span class="text-danger">*</span>' : ''
        );

        $fields['email'] = sprintf(
            '<div class="form-group comment-form-email">
                <label for="email">%1$s%4$s</label>
                <input type="email" name="email" id="email" class="form-control" value="%2$s" maxlength="100" aria-describedby="email-notes" %3$s>
            </div>',
            /* translators: comment author e-mail */
            esc_html_x( 'Your email', 'front-end', 'cartzilla' ),
            esc_attr( $commenter['comment_author_email'] ),
            $is_req ? 'required' : '',
            $is_req ? '<span class="text-danger">*</span>' : ''
        );

        if ( isset( $fields['cookies'] ) ) {
            $consent           = empty( $commenter['comment_author_email'] ) ? '' : ' checked="checked"';
            $fields['cookies'] = sprintf(
                '<div class="custom-control custom-checkbox mb-3 comment-form-cookies-consent">
                    <input type="checkbox" id="wp-comment-cookies-consent" name="wp-comment-cookies-consent" class="custom-control-input" value="yes"' . $consent . '>
                    <label class="custom-control-label" for="wp-comment-cookies-consent">%s</label>
                </div>',
                esc_html_x( 'Save my name and email in this browser for the next time I comment.', 'front-end', 'cartzilla' )
            );
        }

        return $fields;
    }
}

/**
 * Show or hide the departments menu
 *
 * NOTE: this function should rely only on the value from Customizer
 * See {@see cartzilla_departments_menu()} for more details.
 *
 * @return bool
 */
if( ! function_exists( 'cartzilla_departments_is_visible' ) ) {
    function cartzilla_departments_is_visible() {
        return (bool) apply_filters( 'cartzilla_is_departments_menu', 'yes' === get_theme_mod( 'is_departments_menu' ) );
    }
}

/**
 * Display the "Departments" menu
 *
 * This function should output a menu. In case when user doesn't assign any menu to this theme location,
 * Cartzilla will output the fallback menu. Fallback menu will use the product categories (WooCommerce).
 * You can find fallback functions in {@see inc/woocommerce/wc-template-functions.php}
 *
 * @since 1.0.0
 */
if( ! function_exists( 'cartzilla_departments_menu' ) ) {
    function cartzilla_departments_menu() {
        $headerDepartmentMenuSlug = apply_filters( 'cartzilla_header_department_menu' , '' );

        $args = apply_filters( 'cartzilla_departments_menu_args', [
            'theme_location' => 'departments',
            'fallback_cb'    => false,
            'container'      => false,
            'depth'          => 3,
            'items_wrap'     => '<ul class="%2$s">%3$s</ul>',
            'menu_class'     => 'dropdown-menu',
            'walker'         => new Cartzilla_Departments_Menu_Walker(),
            'classes'        => array(
                'nav-link'        => '',
                'dropdown-toggle' => 'dropdown-toggle',
                'dropdown'        => 'dropdown',
                'dropdown-item'   => 'dropdown-item',
                'dropdown-menu'   => array( 'sub-menu', 'dropdown-menu' )
            )
        ] );

        if( ! empty ( $headerDepartmentMenuID ) && $headerDepartmentMenuID > 0 ) {
            $args['menu'] = $headerDepartmentMenuID;
        } elseif( ! empty( $headerDepartmentMenuSlug ) ) {
            $args['menu'] = $headerDepartmentMenuSlug;
        }

        wp_nav_menu( $args );
    }
}

/**
 * Output the "Departments" menu title
 *
 * @since 1.0.0
 */
if( ! function_exists( 'cartzilla_departments_title' ) ) {
    function cartzilla_departments_title() {
        $title = get_theme_mod( 'departments_menu_title' );
        if ( empty( $title ) ) {
            $title = esc_html_x( 'Departments', 'front-end', 'cartzilla' );
        }

        echo esc_html( apply_filters( 'cartzilla_departments_menu_title', $title ) );
    }
}

/**
 * Outputs the label for dropdown tools toggle
 *
 * @since 1.0.0
 */
if( ! function_exists( 'cartzilla_dropdown_tools_toggle' ) ) {
    function cartzilla_dropdown_tools_toggle() {
        /**
         * Toggle contents should be populated with active integrations.
         *
         * @param array $labels Dropdown toggle label(s).
         */
        $labels = (array) apply_filters( 'cartzilla_dropdown_tools_toggle', [] );

        echo implode( '&nbsp;/&nbsp;', array_filter( $labels ) );
    }
}

/**
 * Outputs the dropdown tools
 *
 * Note: each tool should be wrapped in <li> tag, because they are inside the <ul> list.
 *
 * @since 1.0.0
 */
if( ! function_exists( 'cartzilla_dropdown_tools' ) ) {
    function cartzilla_dropdown_tools() {
        /**
         * Outputs the tools inside the dropdown
         */
        do_action( 'cartzilla_dropdown_tools' );
    }
}

/**
 * Display the "Add to Wishlist" button
 *
 * @since 1.0.0
 */
if( ! function_exists( 'cartzilla_add_to_wishlist' ) ) {
    function cartzilla_add_to_wishlist() {
        /**
         * Wishlist provider
         *
         * @param string $provider
         */
        $provider = apply_filters( 'cartzilla_wishlist_provider', 'default' );

        /**
         * Display the "Add to Wishlist" button by specific provider
         *
         * The dynamic part refers to provider. See filter "cartzilla_wishlist_provider" above.
         */
        do_action( "cartzilla_add_to_wishlist_{$provider}" );

        /**
         * Display the "Add to Wishlist" button
         *
         * @param string $provider
         */
        do_action( 'cartzilla_add_to_wishlist', $provider );
    }
}

/**
 * Display the "Compare" button
 *
 * @since 1.0.0
 */
if( ! function_exists( 'cartzilla_compare' ) ) {
    function cartzilla_compare() {
        /**
         * Compare provider
         *
         * @param string $provider
         */
        $provider = apply_filters( 'cartzilla_compare_provider', 'default' );

        /**
         * Display the "Compare" button by specific provider
         *
         * The dynamic part refers to provider. See filter "cartzilla_compare_provider" above.
         */
        do_action( "cartzilla_compare_{$provider}" );

        /**
         * Display the "Compare" button
         *
         * @param string $provider
         */
        do_action( 'cartzilla_compare', $provider );
    }
}

/**
 * Display breadcrumbs
 *
 * Contains the action hook to be able to output third-party breadcrumbs.
 *
 * @since 1.0.0
 */
if( ! function_exists( 'cartzilla_breadcrumbs' ) ) {
    function cartzilla_breadcrumbs() {
        /**
         * Breadcrumbs provider
         *
         * @param string $provider
         */
        $provider = apply_filters( 'cartzilla_breadcrumbs_provider', 'default' );

        /**
         * Display the breadcrumbs by specific provider
         *
         * The dynamic part refers to provider. See filter "cartzilla_breadcrumbs_provider" above.
         */
        do_action( "cartzilla_breadcrumbs_{$provider}" );

        /**
         * Display the breadcrumbs
         *
         * @param string $provider Breadcrumbs provider
         */
        do_action( 'cartzilla_breadcrumbs', $provider );
    }
}

/**
 * Display the Share Buttons.
 *
 * This template tag contains the action hook to be able to output third-party share buttons.
 *
 * @since 1.0.0
 */
if( ! function_exists( 'cartzilla_shares' ) ) {
    function cartzilla_shares() {
        /**
         * Share buttons provider
         *
         * @param string $provider
         */
        $provider = apply_filters( 'cartzilla_shares_provider', 'default' );

        /**
         * Display the share buttons by specific provider
         *
         * The dynamic part refers to provider. See filter "cartzilla_shares_provider" above.
         */
        do_action( "cartzilla_shares_{$provider}" );

        /**
         * Display the share buttons
         *
         * @param string $provider Share buttons provider
         */
        do_action( 'cartzilla_shares', $provider );
    }
}

/**
 * Display the language switcher
 *
 * @since 1.0.0
 */
if( ! function_exists( 'cartzilla_language_switcher' ) ) {
    function cartzilla_language_switcher() {
        /**
         * Language switcher provider
         *
         * @param string $provider
         */
        $provider = apply_filters( 'cartzilla_language_switcher_provider', 'default' );

        /**
         * Display the language switcher by specific provider
         *
         * The dynamic part refers to provider. See filter "cartzilla_language_switcher_provider" above.
         */
        do_action( "cartzilla_language_switcher_{$provider}" );

        /**
         * Display the language switcher
         *
         * @param string $provider
         */
        do_action( 'cartzilla_language_switcher', $provider );
    }
}

/**
 * Display the currency switcher
 *
 * @since 1.0.0
 */
if( ! function_exists( 'cartzilla_currency_switcher' ) ) {
    function cartzilla_currency_switcher() {
        /**
         * Currency switcher provider
         *
         * @param string $provider
         */
        $provider = apply_filters( 'cartzilla_currency_switcher_provider', 'default' );

        /**
         * Display the currency switcher by specific provider
         *
         * The dynamic part refers to provider. See filter "cartzilla_currency_switcher_provider" above.
         */
        do_action( "cartzilla_currency_switcher_{$provider}" );

        /**
         * Display the currency switcher
         *
         * @param string $provider
         */
        do_action( 'cartzilla_currency_switcher', $provider );
    }
}

/**
 * Display a link to the "Order tracking" page
 *
 * @since 1.0.0
 */
if( ! function_exists( 'cartzilla_order_tracking' ) ) {
    function cartzilla_order_tracking() {
        /**
         * Order tracking provider
         *
         * @param string $provider
         */
        $provider = apply_filters( 'cartzilla_order_tracking_provider', 'default' );

        /**
         * Display a link to the "Order tracking" page by specific provider
         *
         * The dynamic part refers to provider. See filter "cartzilla_order_tracking_provider" above.
         */
        do_action( "cartzilla_order_tracking_{$provider}" );

        /**
         * Display a link to the "Order tracking" page
         *
         * @param string $provider
         */
        do_action( 'cartzilla_order_tracking', $provider );
    }
}

/**
 * Show or hide "mini cart" in navbar section
 *
 * @return bool
 */
if( ! function_exists( 'cartzilla_navbar_is_cart' ) ) {
    function cartzilla_navbar_is_cart() {
        return (bool) apply_filters( 'cartzilla_navbar_is_cart',
            cartzilla_is_woocommerce_activated()
            && 'yes' === get_theme_mod( 'navbar_is_cart', 'yes' )
        );
    }
}


/**
 * Outputs the mini cart dropdown
 *
 * @uses woocommerce_mini_cart()
 *
 * @since 1.0.0
 */
if( ! function_exists( 'cartzilla_navbar_cart' ) ) {
    function cartzilla_navbar_cart() {
        if ( cartzilla_is_woocommerce_activated() ) {
            ?>
            <div class="cartzilla-cart dropdown-menu dropdown-menu-right" style="width: 20rem;">
                <div class="widget widget-cart px-3 pt-2 pb-3">
                    <?php woocommerce_mini_cart(); ?>
                </div>
            </div><?php
        }
    }
}

/**
 * Outputs the mini cart toggle
 *
 * Applicable for headers v1 and v2.
 *
 * @since 1.0.0
 */
if( ! function_exists( 'cartzilla_navbar_cart_toggle' ) ) {
    function cartzilla_navbar_cart_toggle() {
        if ( cartzilla_is_woocommerce_activated() ) {
            ?>
            <div class="cartzilla-cart-toggle d-flex">

                <a class="navbar-tool-icon-box bg-secondary dropdown-toggle" href="<?php echo esc_url( wc_get_cart_url() ); ?>">
                    <span class="navbar-tool-label"><?php echo absint( is_a( WC()->cart, 'WC_Cart' ) ? WC()->cart->get_cart_contents_count() : 0 ); ?></span>
                    <i class="navbar-tool-icon czi-cart"></i>
                </a>
            </div>
            <?php
        }
    }
}

/**
 * Outputs the mini cart toggle for headers 3 level
 *
 * @uses WC()
 *
 * @since 1.0.0
 */
if( ! function_exists( 'cartzilla_navbar_cart_toggle_v3' ) ) {
    function cartzilla_navbar_cart_toggle_v3() {
        if ( cartzilla_is_woocommerce_activated() ) {
            ?>
            <div class="d-flex align-items-center cartzilla-cart-toggle-v3">
                <a class="navbar-tool-icon-box bg-secondary dropdown-toggle" href="<?php echo esc_url( wc_get_cart_url() ); ?>">
                    <span class="navbar-tool-label"><?php echo absint( is_a( WC()->cart, 'WC_Cart' ) ? WC()->cart->get_cart_contents_count() : 0 ); ?></span>
                    <i class="navbar-tool-icon czi-cart"></i>
                </a>
                <a class="navbar-tool-text" href="<?php echo esc_url( wc_get_cart_url() ); ?>">
                    <small><?php echo esc_html_x( 'My Cart', 'front-end', 'cartzilla' ); ?></small>
                    <?php if( is_a( WC()->cart, 'WC_Cart' ) ) : ?>
                        <?php echo strip_tags( WC()->cart->get_cart_subtotal() ); ?>
                    <?php endif; ?>
                </a>
            </div>
        <?php
        }
    }
}

/**
 * Returns the registered name for a post type
 *
 * This function was designed to use on a search results page.
 *
 * @param string $post_type Post type
 *
 * @return string
 */
if( ! function_exists( 'cartzilla_search_post_type_name' ) ) {
    function cartzilla_search_post_type_name( $post_type ) {
        $post_type_name = '';

        if ( ! empty( $post_type ) ) {
            $post_type_obj = get_post_type_object( $post_type );
            if ( ! empty( $post_type_obj ) ) {
                $post_type_name = $post_type_obj->name;
            }
        }

        return $post_type_name;
    }
}

if ( ! function_exists( 'cz_get_post_featured_icon' ) ) {
    /**
     * Displays Post Featured Icon
     *
     * @return boolean
     *
     */
     function cz_get_post_featured_icon( $thepostid = null ) {
         global $post;

         $thepostid = isset( $thepostid )? $thepostid : $post->ID;

         $post_featured_icon = get_post_meta( $thepostid, '_post_featured_icon', true );

         $featured_icon = ! empty( $post_featured_icon ) ? $post_featured_icon : false;

         return $featured_icon;
     }
}

if ( ! function_exists( 'cartzilla_page_header' ) ) {
    function cartzilla_page_header() {

        global $post;
        $hide_page_header = false;

        if ( isset( $post->ID ) ) {
            $page_header_meta_values = get_post_meta( $post->ID, '_hidePageHeader', true );
            if ( isset( $page_header_meta_values ) && $page_header_meta_values ) {
                $hide_page_header = $page_header_meta_values;
            }
        }

        if ( cartzilla_is_woocommerce_activated() && ( is_cart() || is_checkout() || is_account_page() )) {
            $hide_page_header = apply_filters('cartzilla_show_site_content_wc_page_header' , true );
        }

        if( ! $hide_page_header ) {
            if ( is_page() && apply_filters( 'cartzilla_show_site_content_page_header', true ) ) : ?>
            <?php if ( apply_filters( 'cartzilla_show_site_content_page_title', true ) ) : ?>
            <div class="bg-secondary py-4">
                <div class="container d-lg-flex justify-content-between py-2 py-lg-3">
                    <div class="text-center text-lg-left">
                        <h1 class="h3 mb-0"><?php echo esc_html( apply_filters( 'cartzilla_site_content_page_title', get_the_title() ) ); ?></h1>
                    </div>
                </div>
            </div>
            <?php endif; ?>
        <?php endif;
        }
    }
}

if ( ! function_exists( 'cartzilla_page_content' ) ) {
    function cartzilla_page_content() { 

        global $post;

        $page_meta_values = get_post_meta( $post->ID, '_disableContainer', true );

        $article_content_additional_class = '';

        if ( ! ( isset( $page_meta_values ) && $page_meta_values) ) {
            if ( cartzilla_is_woocommerce_activated() && ( is_cart() || is_checkout() || is_account_page()) ) {
                $article_content_additional_class .= apply_filters('cartzilla_wc_page_content_container_class', '');
            } elseif ( ( function_exists( 'cartzilla_get_shop_page_style' ) && cartzilla_get_shop_page_style() === 'style-v3' ) ) {
                $article_content_additional_class .= ' container-fluid';
            } else {
                $article_content_additional_class .= ' container';
            }
            
        }

        ?>
        <div class="article__content article__content--page<?php echo esc_attr( $article_content_additional_class ); ?>">
            <div class="page__content">
                <?php the_content(); ?>
            </div>

            <?php
                $link_pages = wp_link_pages(
                array(
                    'before' => '<div class="page-links"><span class="d-block text-secondary mb-2">' . esc_html__( 'Pages:', 'cartzilla' ) . '</span><nav class="pagination mb-0">',
                    'after'  => '</nav></div>',
                    'link_before' => '<span class="page-link">',
                    'link_after'  => '</span>',
                    'echo'   => 0,
                )
            );

            $link_pages = str_replace( 'post-page-numbers', 'post-page-numbers page-item', $link_pages );
            $link_pages = str_replace( 'current', 'current active', $link_pages );
            echo wp_kses_post( $link_pages );

            ?>
        </div><!-- .entry-content --><?php
    }
}

if ( ! function_exists( 'cartzilla_custom_widget_nav_menu_options' ) ) :
    function cartzilla_custom_widget_nav_menu_options( $widget, $return, $instance ) {
        // Are we dealing with a nav menu widget?
        if ( 'nav_menu' == $widget->id_base ) {
            $is_social_icon_menu = isset( $instance['is_social_icon_menu'] ) ? $instance['is_social_icon_menu'] : '';
            ?>
                <p>
                    <input class="checkbox" type="checkbox" id="<?php echo esc_attr( $widget->get_field_id('is_social_icon_menu') ); ?>" name="<?php echo esc_attr( $widget->get_field_name('is_social_icon_menu') ); ?>" <?php checked( true , $is_social_icon_menu ); ?> />
                    <label for="<?php echo esc_attr( $widget->get_field_id('is_social_icon_menu') ); ?>">
                        <?php esc_html_e( 'Is Social Icon Menu', 'cartzilla' ); ?>
                    </label>
                </p>
            <?php
        }
    }
endif;

if ( ! function_exists( 'cartzilla_custom_widget_nav_menu_options_update' ) ) :
    function cartzilla_custom_widget_nav_menu_options_update( $instance, $new_instance, $old_instance, $widget ) {
        if ( 'nav_menu' == $widget->id_base ) {
            if ( isset( $new_instance['is_social_icon_menu'] ) && ! empty( $new_instance['is_social_icon_menu'] ) ) {
                $instance['is_social_icon_menu'] = 1;
            }
        }

        return $instance;
    }
endif;

if ( ! function_exists( 'cartzilla_custom_widget_nav_menu_args' ) ) :
    function cartzilla_custom_widget_nav_menu_args( $nav_menu_args, $nav_menu, $args, $instance ) {
        $layout = function_exists( 'cartzilla_footer_layout' ) ? cartzilla_footer_layout() : 'dark';
        if( isset( $instance['is_social_icon_menu'] ) && ! empty( $instance['is_social_icon_menu'] ) ) {
            $social_nav_menu_args =   array(
                'container'         => false,
                'menu_class'        => 'social-menu list-inline mb-0',
                'depth'             => 1,
                'item_class'        => 'list-inline-item mr-0 mb-0',
                'walker'            => new WP_Bootstrap_Navwalker(),
                'disable_schema'    => true,
                'disable_data_attr' => true,
                'classes'        => array(
                    'nav-link'        => 'social-btn mr-2 mb-2 ' . esc_attr( $layout == 'light' ? 'sb-outline' : 'sb-light' ) . '',
                )
            );

            $nav_menu_args = array_merge( $nav_menu_args, $social_nav_menu_args );
        }

        return $nav_menu_args;
    }
endif;

if ( ! function_exists( 'cartzilla_dropdown_tools_title' ) ) :
    function cartzilla_dropdown_tools_title( $titles ) {
        $titles = array( strtoupper( get_bloginfo( 'language' ) ) );
        if( cartzilla_is_woocommerce_activated() ) {
            $titles[] = get_woocommerce_currency_symbol();
        }
        return $titles;
    }
endif;

if ( ! function_exists( 'cartzilla_dropdown_tools_language_currency' ) ) :
    function cartzilla_dropdown_tools_language_currency() {
        if( cartzilla_is_woocommerce_activated() ) {
            ?>
            <li class="dropdown-item">
                <select class="custom-select custom-select-sm">
                    <option value="<?php echo get_woocommerce_currency(); ?>">
                        <?php echo get_woocommerce_currency_symbol(); ?>
                        <?php echo get_woocommerce_currency(); ?>
                    </option>
                </select>
            </li>
            <?php
        }
        ?>
        <li>
            <a class="dropdown-item pb-1" href="#">
                <?php echo strtoupper( get_bloginfo( 'language' ) ); ?>
            </a>
        </li>
        
        <?php
    }
endif;

if ( ! function_exists( 'cartzilla_search_form' ) ) {
    function cartzilla_search_form( $args = array() ) {

        $defaults =  apply_filters( 'cartzilla_hero_search_form_default_args', array(
            'keywordsPlaceholderText' => apply_filters( 'cartzilla_search_placehler_text', 'Start your search' ),
            'dropdownText' => apply_filters( 'cartzilla_search_dropdown_text', 'All categories' ),
        ) );

        $args = wp_parse_args( $args, $defaults );
        extract( $args ); ?>
        <?php if ( cartzilla_is_woocommerce_activated() ) : ?>
            <form class="hero-search-form" method="get" action="<?php echo esc_url( home_url( '/'  ) ); ?>" autocomplete="off">

            <div class="input-group input-group-overlay input-group-lg">
                <div class="input-group-prepend-overlay">
                    <span class="input-group-text"><i class="czi-search"></i></span>
                </div>

                <input class="form-control form-control-lg prepended-form-control rounded-right-0" type="text" placeholder="<?php echo esc_attr( $args['keywordsPlaceholderText'] ) ?>" name="s" value="<?php echo esc_attr( get_search_query() ); ?>">
                    <div class="input-group-append">

                        <?php $selected_cat = isset( $_GET['product_cat'] ) ? $_GET['product_cat'] : "0";
                        wp_dropdown_categories( apply_filters( 'cartzilla_search_dropdown_categories_filter_args', array(
                            'show_option_all'   => $args['dropdownText'],
                            'taxonomy'          => 'product_cat',
                            'hide_if_empty'     => 1,
                            'name'              => 'product_cat',
                            'selected'          => $selected_cat,
                            'value_field'       => 'slug',
                            'class'             => 'custom-select',
                            'hierarchical' => 1,
                            'depth' => 1
                        ) ) );?>
                    </div>
                    <input type="hidden" id="search-param" name="post_type" value="product" />
              </div>

            </form>
            <?php else : ?>
            <form class="hero-search-form" method="get" action="<?php echo esc_url( home_url( '/'  ) ); ?>" autocomplete="off">

                <div class="input-group input-group-overlay input-group-lg">
                    <div class="input-group-prepend-overlay">
                        <span class="input-group-text"><i class="czi-search"></i></span>
                    </div>

                    <input class="form-control form-control-lg prepended-form-control rounded-right-0" type="text" placeholder="<?php echo esc_attr( $args['keywordsPlaceholderText'] ) ?>" name="s" value="<?php echo esc_attr( get_search_query() ); ?>" />
                        <div class="input-group-append">
                            <?php $selected_cat = isset( $_GET['category'] ) ? $_GET['category'] : "0";
                            wp_dropdown_categories( apply_filters( 'cartzilla_search_dropdown_categories_filter_args', array(
                                'show_option_all'   => $args['dropdownText'],
                                'taxonomy'          => 'category',
                                'hide_if_empty'     => 1,
                                'name'              => 'category',
                                'selected'          => $selected_cat,
                                'value_field'       => 'slug',
                                'class'             => 'custom-select'
                            ) ) );?>
                        </div>
                        <input type="hidden" id="search-param" name="post_type" value="product" />
                  </div>
                
                <input type="hidden" id="search-param" name="post_type" value="product" />
            </form>
        <?php endif;
    }
}

if ( ! function_exists( 'cartzilla_post_protected_password_form' ) ) :
    function cartzilla_post_protected_password_form() {
        global $post;

        $label = 'pwbox-'.( empty( $post->ID ) ? rand() : $post->ID ); ?>

        <form class="protected-post-form input-group front-protected-post-form" action="<?php echo esc_url( site_url( 'wp-login.php?action=postpass', 'login_post' ) ); ?>" method="post">
            <p><?php echo esc_html__( 'This content is password protected. To view it please enter your password below:', 'cartzilla' ); ?></p>
            <div class="d-flex align-items-center w-md-85">
                <label class="text-secondary mb-0" for="<?php echo esc_attr( $label ); ?>"><?php echo esc_html__( 'Password:', 'cartzilla' ); ?></label>
                <div class="d-flex flex-grow-1 ml-3" style="height: 52px;">
                    <input class="h-100 form-control rounded-left" name="post_password" id="<?php echo esc_attr( $label ); ?>" type="password" style="border-top-right-radius: 0; border-bottom-right-radius: 0;"/>
                    <input type="submit" name="Submit" class="btn btn-primary rounded-right h-100 w-md-30" value="<?php echo esc_attr( "Submit" ); ?>" style="border-top-left-radius: 0; border-bottom-left-radius: 0; transform: none;"/>
                </div>
            </div>
        </form><?php
    }
endif;

if ( ! function_exists( 'cartzilla_custom_uploaded_pre_avatar_override' ) ) :
    function cartzilla_custom_uploaded_pre_avatar_override( $args, $id_or_email ) {
        // Get user data.
        if ( is_numeric( $id_or_email ) ) {
            $user = get_user_by( 'id', (int) $id_or_email );
        } elseif ( is_object( $id_or_email ) ) {
            if( $id_or_email instanceof WP_User ) {
                $user = $id_or_email;
            } elseif ( $id_or_email instanceof WP_Post ) {
                // Post object.
                $user = get_user_by( 'id', (int) $id_or_email->post_author );
            } elseif ( $id_or_email instanceof WP_Comment ) {
                $comment = $id_or_email;
                if ( empty( $comment->user_id ) ) {
                    $user = get_user_by( 'id', $comment->user_id );
                } else {
                    $user = get_user_by( 'email', $comment->comment_author_email );
                }
                if ( ! $user ) {
                    return $args;
                }
            } else {
                return $args;
            }
        } elseif ( is_string( $id_or_email ) ) {
            $user = get_user_by( 'email', $id_or_email );
        } else {
            return $args;
        }
        if ( ! $user ) {
            return $args;
        }
        $user_id = $user->ID;

        // Get the post the user is attached to.
        $size = $args['size'];

        $img_id = get_user_meta( $user_id, '_cartzilla_custom_avatar_id', true );

        // Attempt to get the image in the right size.
        if( 0 < absint( $img_id ) ) {
            $args['url'] = wp_get_attachment_image_url( $img_id, array( $size, $size ) );
        }
        return $args;
    }
endif;

if ( ! function_exists( 'cartzilla_custom_uploaded_avatar_url_override' ) ) :
    function cartzilla_custom_uploaded_avatar_url_override( $url, $id_or_email, $args ) {
        // Get user data.
        if( $id_or_email instanceof WP_User ) {
            $user = $id_or_email;
        } elseif ( $id_or_email instanceof WP_Post ) {
            // Post object.
            $user = get_user_by( 'id', (int) $id_or_email->post_author );
        } elseif ( $id_or_email instanceof WP_Comment ) {
            if( is_a( $id_or_email, 'WP_User' ) ) {
                $user = $id_or_email;
            } elseif( is_a( $id_or_email, 'WP_Comment' ) ) {
                $comment = $id_or_email;
                if ( empty( $comment->user_id ) ) {
                    $user = get_user_by( 'id', $comment->user_id );
                } else {
                    $user = get_user_by( 'email', $comment->comment_author_email );
                }
                if ( ! $user ) {
                    return $url;
                }
            } else {
                return $url;
            }
        } elseif ( is_string( $id_or_email ) ) {
            $user = get_user_by( 'email', $id_or_email );
        } else {
            return $url;
        }
        if ( ! $user ) {
            return $url;
        }
        $user_id = $user->ID;

        // Get the post the user is attached to.
        $size = $args['size'];

        //Find ID of attachment saved user meta
        $img_id = get_user_meta( $user_id, '_cartzilla_custom_avatar_id', true );

        if( 0 < absint( $img_id ) ) {
            //return image url
            return wp_get_attachment_image_url( $img_id, array( $size, $size ) );
        }

        //return normal
        return $url;
    }
endif;

if ( ! function_exists( 'cartzilla_custom_uploaded_avatar_override' ) ) :
    function cartzilla_custom_uploaded_avatar_override( $args, $id_or_email ) {
        $email_hash = '';
        $user       = false;
        $email      = false;

        // Process the user identifier.
        if ( is_numeric( $id_or_email ) ) {
            $user = get_user_by( 'id', absint( $id_or_email ) );
        } elseif ( is_string( $id_or_email ) ) {
            if ( strpos( $id_or_email, '@md5.gravatar.com' ) ) {
                // MD5 hash.
                list( $email_hash ) = explode( '@', $id_or_email );
            } else {
                // Email address.
                $email = $id_or_email;
            }
        } elseif ( $id_or_email instanceof WP_User ) {
            // User object.
            $user = $id_or_email;
        } elseif ( $id_or_email instanceof WP_Post ) {
            // Post object.
            $user = get_user_by( 'id', (int) $id_or_email->post_author );
        } elseif ( $id_or_email instanceof WP_Comment ) {
            if ( ! empty( $id_or_email->user_id ) ) {
                $user = get_user_by( 'id', (int) $id_or_email->user_id );
            }
            if ( ( ! $user || is_wp_error( $user ) ) && ! empty( $id_or_email->comment_author_email ) ) {
                $email = $id_or_email->comment_author_email;
            }
        }
     
        if ( ! $email_hash ) {
            if ( $user ) {
                $email = $user->user_email;
            }
     
            if ( $email ) {
                $email_hash = md5( strtolower( trim( $email ) ) );
            }
        }
     
        if ( $email_hash ) {
            $args['found_avatar'] = true;
            $gravatar_server      = hexdec( $email_hash[0] ) % 3;
        } else {
            $gravatar_server = rand( 0, 2 );
        }
     
        $url_args = array(
            's' => $args['size'],
            'd' => $args['default'],
            'f' => $args['force_default'] ? 'y' : false,
            'r' => $args['rating'],
        );
     
        if ( is_ssl() ) {
            $url = 'https://secure.gravatar.com/avatar/' . $email_hash;
        } else {
            $url = sprintf( 'http://%d.gravatar.com/avatar/%s', $gravatar_server, $email_hash );
        }
     
        $url = add_query_arg(
            rawurlencode_deep( array_filter( $url_args ) ),
            set_url_scheme( $url, $args['scheme'] )
        );

        if( isset( $args['extra_attr'] ) ) {
            $args['extra_attr'] .= ' gurl="' . $url . '"';
        } else {
            $args['extra_attr'] = 'gurl="' . $url . '"';
        }

        return $args;
    }
endif;
