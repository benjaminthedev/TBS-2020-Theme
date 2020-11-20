<?php
/**
 * dokan functions
 *
 * Typically functions used in dokan.
 *
 * @package Cartzilla
 */
if ( ! function_exists( 'cartzilla_is_dokan_vendor_style_enabled' ) ) {
    function cartzilla_is_dokan_vendor_style_enabled() {
        return apply_filters( 'cartzilla_is_dokan_vendor_style_enabled', 'yes' === get_theme_mod( 'is_dokan_vendor_style_enabled', 'yes' ) );
    }
}

if ( ! function_exists( 'cartzilla_dokan_report_data' ) ) {
    function cartzilla_dokan_report_data( $group_by = 'day', $year = '', $start = '', $end = '', $seller_id = '' ) {
        global $wpdb;

        $_post_data   = wp_unslash( $_POST ); // WPCS: CSRF ok.
        $group_by     = apply_filters( 'dokan_report_group_by', $group_by );
        $start_date   = isset( $_post_data['start_date'] ) ? sanitize_text_field ( $_post_data['start_date'] ): $start; // WPCS: CSRF ok.
        $end_date     = isset( $_post_data['end_date'] ) ? sanitize_text_field( $_post_data['end_date'] ): $end; // WPCS: CSRF ok.
        $current_year = date( 'Y' );

        if ( ! $start_date ) {
            $start_date = date( 'Y-m-d', strtotime( date( 'Ym', current_time( 'timestamp' ) ) . '01' ) );

            if ( $group_by == 'year' ) {
                $start_date = $year . '-01-01';
            }
        }

        if ( ! $end_date ) {
            $end_date = date( 'Y-m-d', current_time( 'timestamp' ) );

            if ( $group_by == 'year' && ( $year < $current_year ) ) {
                $end_date = $year . '-12-31';
            }
        }

        $date_where = '';

        if ( 'day' == $group_by ) {
            $group_by_query = 'YEAR(p.post_date), MONTH(p.post_date), DAY(p.post_date)';
            $date_where     = " AND DATE(p.post_date) >= '$start_date' AND DATE(p.post_date) <= '$end_date'";
        } else {
            $group_by_query = 'YEAR(p.post_date), MONTH(p.post_date)';
            $date_where     = " AND DATE(p.post_date) >= '$start_date' AND DATE(p.post_date) <= '$end_date'";
        }

        $left_join    = apply_filters( 'dokan_report_left_join', $date_where );
        $date_where   = apply_filters( 'dokan_report_where', $date_where );
        $seller_where = $seller_id ? "seller_id = {$seller_id}" : "seller_id != " . 0;

        $sql = "SELECT
                    SUM((do.order_total - do.net_amount)) as earning,
                    SUM(do.order_total) as order_total,
                    COUNT(DISTINCT p.ID) as total_orders,
                    p.post_date as order_date
                FROM {$wpdb->prefix}dokan_orders do
                LEFT JOIN $wpdb->posts p ON do.order_id = p.ID
                $left_join
                WHERE
                    $seller_where AND
                    p.post_status != 'trash' AND
                    do.order_status IN ('wc-on-hold', 'wc-completed', 'wc-processing')
                    $date_where
                GROUP BY $group_by_query";

        $data = $wpdb->get_results( $sql ); // phpcs:ignore WordPress.DB.PreparedSQL

        return $data;
    }
}

if ( ! function_exists( 'cartzilla_dokan_dashboard_nav' ) ) {
    function cartzilla_dokan_dashboard_nav( $active_menu = '' ) {

        $nav_menu          = dokan_get_dashboard_nav();
        $active_menu_parts = explode( '/', $active_menu );

        if ( isset( $active_menu_parts[1] ) ) {
            if( in_array($active_menu_parts[1], ['store', 'payment']) && $active_menu_parts[0] == 'settings' ) {
                $active_menu = $active_menu_parts[0];
            } else {
                $active_menu = $active_menu_parts[1];
            }
        } elseif( $active_menu_parts[0] == 'edit-account' ) {
            $active_menu = 'settings';
        }

        $urls = $nav_menu;

        $menu = '';

        if( isset( $urls['account'] ) ) {
            $menu .= sprintf( '<div class="bg-secondary p-4"><h3 class="font-size-sm mb-0 text-muted">%s</h3></div>', $urls['account']['title'] );
            unset( $urls['account'] );
        }

        $menu .= '<ul class="dokan-dashboard-menu list-unstyled mb-0">';

        foreach ( $urls as $key => $item ) {
            if( isset( $item['url'], $item['icon'], $item['title'] ) ) {
                $class = $item === end( $urls ) ? 'mb-0 ' : 'border-bottom mb-0 ';
                $class .= ( $active_menu == $key ) ? $key . ' active' : $key;
                $menu .= sprintf( '<li class="%s"><a href="%s" class="nav-link-style d-flex align-items-center px-4 py-3">%s %s</a></li>', $class, $item['url'], $item['icon'], $item['title'] );
            } elseif( isset( $item['title'], $item['divider'] ) ) {
                $menu .= '</ul>';
                $menu .= sprintf( '<div class="bg-secondary p-4"><h3 class="font-size-sm mb-0 text-muted">%s</h3></div>', $item['title'] );
                $menu .= '<ul class="dokan-dashboard-menu list-unstyled mb-0">';
            }
        }

        $common_links_urls = apply_filters( 'cartzilla_dokan_dashboard_nav_common_link_urls', array(
            'logout' => array(
                'title'      => esc_html__( 'Sign out', 'cartzilla'),
                'icon'       => '<i class="czi-sign-out opacity-60 mr-2"></i>',
                'url'        => wp_logout_url( home_url() ),
                'pos'        => 10,
            ),
        ) );

        if( ! empty( $common_links_urls ) && is_array( $common_links_urls ) ) {
            foreach ( $common_links_urls as $key => $item ) {
                if( isset( $item['url'], $item['icon'], $item['title'] ) ) {
                    $common_link_item_class = 'border-top mb-0 ';
                    $menu .= sprintf( '<li class="%s"><a href="%s" class="nav-link-style d-flex align-items-center px-4 py-3">%s %s</a></li>', $common_link_item_class, $item['url'], $item['icon'], $item['title'] );
                }
            }
        }

        $menu .= '</ul>';

        return $menu;
    }
}

if ( ! function_exists( 'cartzilla_dokan_withdraw_method_paypal' ) ) {
    function cartzilla_dokan_withdraw_method_paypal( $store_settings ) {
        global $current_user;

        $email = isset( $store_settings['payment']['paypal']['email'] ) ? esc_attr( $store_settings['payment']['paypal']['email'] ) : $current_user->user_email ;
        ?>
        <div class="input-group">
            <div class="input-group-prepend">
                <span class="input-group-text"><?php esc_html_e( 'E-mail', 'cartzilla' ); ?></span>
            </div>
            <input value="<?php echo esc_attr( $email ); ?>" name="settings[paypal][email]" class="form-control email" placeholder="you@domain.com" type="text">
        </div>
        <?php
    }
}

if ( ! function_exists( 'cartzilla_dokan_withdraw_method_skrill' ) ) {
    function cartzilla_dokan_withdraw_method_skrill( $store_settings ) {
        global $current_user;

        $email = isset( $store_settings['payment']['skrill']['email'] ) ? esc_attr( $store_settings['payment']['skrill']['email'] ) : $current_user->user_email ;
        ?>
        <div class="input-group">
            <div class="input-group-prepend">
                <span class="input-group-text"><?php esc_html_e( 'E-mail', 'cartzilla' ); ?></span>
            </div>
            <input value="<?php echo esc_attr( $email ); ?>" name="settings[skrill][email]" class="form-control email" placeholder="you@domain.com" type="text">
        </div>
        <?php
    }
}

if ( ! function_exists( 'cartzilla_dokan_withdraw_method_bank' ) ) {
    function cartzilla_dokan_withdraw_method_bank( $store_settings ) {
        $account_name   = isset( $store_settings['payment']['bank']['ac_name'] ) ? $store_settings['payment']['bank']['ac_name'] : '';
        $account_number = isset( $store_settings['payment']['bank']['ac_number'] ) ? $store_settings['payment']['bank']['ac_number'] : '';
        $bank_name      = isset( $store_settings['payment']['bank']['bank_name'] ) ? $store_settings['payment']['bank']['bank_name'] : '';
        $bank_addr      = isset( $store_settings['payment']['bank']['bank_addr'] ) ? $store_settings['payment']['bank']['bank_addr'] : '';
        $routing_number = isset( $store_settings['payment']['bank']['routing_number'] ) ? $store_settings['payment']['bank']['routing_number'] : '';
        $iban           = isset( $store_settings['payment']['bank']['iban'] ) ? $store_settings['payment']['bank']['iban'] : '';
        $swift_code     = isset( $store_settings['payment']['bank']['swift'] ) ? $store_settings['payment']['bank']['swift'] : '';
        ?>
        <div class="form-group">
            <input name="settings[bank][ac_name]" value="<?php echo esc_attr( $account_name ); ?>" class="form-control" placeholder="<?php esc_attr_e( 'Your bank account name', 'cartzilla' ); ?>" type="text">
        </div>

        <div class="dokan-form-group">
            <input name="settings[bank][ac_number]" value="<?php echo esc_attr( $account_number ); ?>" class="form-control" placeholder="<?php esc_attr_e( 'Your bank account number', 'cartzilla' ); ?>" type="text">
        </div>

        <div class="dokan-form-group">
            <input name="settings[bank][bank_name]" value="<?php echo esc_attr( $bank_name ); ?>" class="form-control" placeholder="<?php esc_attr_e( 'Name of bank', 'cartzilla' ) ?>" type="text">
        </div>

        <div class="dokan-form-group">
            <textarea name="settings[bank][bank_addr]" rows="5" class="form-control" placeholder="<?php esc_attr_e( 'Address of your bank', 'cartzilla' ) ?>"><?php echo esc_html( $bank_addr ); ?></textarea>
        </div>

        <div class="dokan-form-group">
            <input name="settings[bank][routing_number]" value="<?php echo esc_attr( $routing_number ); ?>" class="form-control" placeholder="<?php esc_attr_e( 'Routing number', 'cartzilla' ) ?>" type="text">
        </div>

        <div class="dokan-form-group">
            <input name="settings[bank][iban]" value="<?php echo esc_attr( $iban ); ?>" class="form-control" placeholder="<?php esc_attr_e( 'IBAN', 'cartzilla' ) ?>" type="text">
        </div>

        <div class="dokan-form-group">
            <input value="<?php echo esc_attr( $swift_code ); ?>" name="settings[bank][swift]" class="form-control" placeholder="<?php esc_attr_e( 'Swift code', 'cartzilla' ); ?>" type="text">
        </div> <!-- .dokan-form-group -->
        <?php
    }
}

if ( ! function_exists( 'cartzilla_dokan_product_listing_filter_months_dropdown' ) ) {
    function cartzilla_dokan_product_listing_filter_months_dropdown( $user_id ) {
        global $wpdb, $wp_locale;

        $months = $wpdb->get_results(
            $wpdb->prepare(
                "SELECT DISTINCT YEAR( post_date ) AS year, MONTH( post_date ) AS month
                FROM $wpdb->posts
                WHERE post_type = 'product'
                AND post_author = %d
                ORDER BY post_date DESC",
                $user_id
            )
        );

        /**
         * Filter the 'Months' drop-down results.
         *
         * @since 2.1
         *
         * @param object $months    The months drop-down query results.
         */
        $months      = apply_filters( 'months_dropdown_results', $months, 'product' );
        $month_count = count( $months );

        if ( ! $month_count || ( 1 == $month_count && 0 == $months[0]->month ) ) {
            return;
        }

        $date = isset( $_GET['date'] ) ? (int) $_GET['date'] : 0;
        ?>
        <select name="date" id="filter-by-date" class="custom-select">
            <option<?php selected( $date, 0 ); ?> value="0"><?php esc_html_e( 'All dates', 'cartzilla' ); ?></option>
        <?php
        foreach ( $months as $arc_row ) {
            if ( 0 == $arc_row->year ) {
                continue;
            }

            $month = zeroise( $arc_row->month, 2 );
            $year = $arc_row->year;

            printf(
                "<option %s value='%s' >%s</option>\n",
                selected( $date, $year . $month, false ),
                esc_attr( $year . $month ),
                /* translators: 1: month name, 2: 4-digit year */
                sprintf( esc_html__( '%1$s %2$d', 'cartzilla' ), esc_html( $wp_locale->get_month( $month ) ), esc_html( $year ) ) // phpcs:ignore WordPress.XSS.EscapeOutput.OutputNotEscaped
            );
        }
        ?>
        </select>
        <?php
    }
}

if ( ! function_exists( 'cartzilla_dokan_store_product_content_nav' ) ) {
    function cartzilla_dokan_store_product_content_nav() {
        global $wp_query;
        $posts_per_page = intval( get_query_var( 'posts_per_page' ) );
        $paged = intval( get_query_var( 'paged' ) );
        $numposts = $wp_query->found_posts;
        $max_page = $wp_query->max_num_pages;
        if ( $numposts <= $posts_per_page ) {
            return;
        }
        if ( empty( $paged ) || $paged == 0 ) {
            $paged = 1;
        }
        $pages_to_show = 7;
        $pages_to_show_minus_1 = $pages_to_show - 1;
        $half_page_start = floor( $pages_to_show_minus_1 / 2 );
        $half_page_end = ceil( $pages_to_show_minus_1 / 2 );
        $start_page = $paged - $half_page_start;
        if ( $start_page <= 0 ) {
            $start_page = 1;
        }
        $end_page = $paged + $half_page_end;
        if ( ($end_page - $start_page) != $pages_to_show_minus_1 ) {
            $end_page = $start_page + $pages_to_show_minus_1;
        }
        if ( $end_page > $max_page ) {
            $start_page = $max_page - $pages_to_show_minus_1;
            $end_page = $max_page;
        }
        if ( $start_page <= 0 ) {
            $start_page = 1;
        }

        echo '<nav class="d-flex justify-content-between pt-2 cartzilla-dokan-products-pagination w-100 pb-4 pb-md-0">';

        echo '<ul class="pagination">';
        if ( $paged > 1 ) {
            echo '<li class="page-item"><a class="page-link" href="' . get_pagenum_link( $paged - 1 ) . '"><i class="czi-arrow-left mr-2"></i>' . esc_html_x( 'Prev', 'front-end', 'cartzilla' ) . '</a></li>';
        }
        echo '</ul>';

        echo '<ul class="pagination">';
            echo '<li class="page-item d-sm-none"><span class="page-link page-link-static">' . $paged . '/' . $max_page . '</span></li>';
            for ($i = $start_page; $i <= $end_page; $i++) {
                if ( $i == $paged ) {
                    echo '<li class="page-item active d-none d-sm-block"><span class="page-link">' . esc_html( $i ) . '</span></li>';
                } else {
                    echo '<li class="page-item d-none d-sm-block"><a href="' . esc_url( get_pagenum_link( $i ) ) . '" class="page-link">' . esc_html( number_format_i18n( $i ) ) . '</a></li>';
                }
            }
        echo '</ul>';

        echo '<ul class="pagination">';
        if ( $paged < $max_page ) {
            echo '<li class="page-item"><a class="page-link" href="' . get_pagenum_link( $paged + 1 ) . '">' . esc_html_x( 'Next', 'front-end', 'cartzilla' ) . '<i class="czi-arrow-right ml-2"></i></a></li>';
        }
        echo '</ul>';

        echo '</nav>';
    }
}

if ( ! function_exists( 'cartzilla_review_pagination' ) ) {
    function cartzilla_review_pagination( $id, $post_type, $limit, $status ) {
        global $wpdb;

        $total = $wpdb->get_var(
            "SELECT COUNT(*)
            FROM $wpdb->comments, $wpdb->posts
            WHERE   $wpdb->posts.post_author='$id' AND
            $wpdb->posts.post_status='publish' AND
            $wpdb->comments.comment_post_ID=$wpdb->posts.ID AND
            $wpdb->comments.comment_approved='$status' AND
            $wpdb->posts.post_type='$post_type'"
        );

        $current = max( get_query_var( 'paged' ), 1 );

        $num_of_pages = ceil( $total / $limit );

        if ( $num_of_pages <= 1 ) {
            return;
        }

        $links = paginate_links( array(
            'base'      => dokan_get_store_url( $id ) . 'reviews/%_%',
            'format'    => 'page/%#%',
            'add_args'  => false,
            'current'   => $current,
            'total'     => $num_of_pages,
            'prev_next' => false,
            'type'      => 'array',
            'end_size'  => 3,
            'mid_size'  => 3,
        ) );

        ?>
        <nav class="d-flex justify-content-between pt-2 cartzilla-shop-pagination w-100" aria-label="<?php
        /* translators: aria-label for products navigation wrapper */
        echo esc_attr_x( 'Page navigation', 'front-end', 'cartzilla' ); ?>">
            <ul class="pagination">
                <?php if ( $current && 1 < $current ) : ?>
                    <li class="page-item">
                        <a class="page-link" href="<?php echo get_pagenum_link( $current - 1 ); ?>">
                            <i class="czi-arrow-left mr-2"></i><?php
                            /* translators: label for previous products link */
                            echo esc_html_x( 'Prev', 'front-end', 'cartzilla' ); ?>
                        </a>
                    </li>
                <?php endif; ?>
            </ul>
            <ul class="pagination">
                <li class="page-item d-sm-none">
                    <span class="page-link page-link-static"><?php echo esc_html( "{$current} / {$num_of_pages}" ); ?></span>
                </li>
                <?php foreach( $links as $link ) : ?>
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
                <?php if ( $current && $current < $num_of_pages ) : ?>
                    <li class="page-item">
                        <a class="page-link" href="<?php echo get_pagenum_link( $current + 1 ); ?>"><?php
                            /* translators: label for next products link */
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

if ( ! function_exists( 'cartzilla_dokan_vendor_page_columns' ) ) {
    function cartzilla_dokan_vendor_page_columns( $columns ) {
        return 2;
    }
}

if ( ! function_exists( 'cartzilla_dokan_vendor_page_columns_reset' ) ) {
    function cartzilla_dokan_vendor_page_columns_reset( $columns ) {
        return wc_get_loop_prop( 'columns' );
    }
}