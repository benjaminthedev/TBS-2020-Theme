<?php
    global $post;
?>

<?php do_action( 'dokan_dashboard_wrap_start' ); ?>

    <div class="dokan-dashboard-wrap">

        <?php

            /**
             *  dokan_dashboard_content_before hook
             *
             *  @hooked get_dashboard_side_navigation
             *
             *  @since 2.4
             */
            do_action( 'dokan_dashboard_content_before' );
        ?>

        <section class="col-lg-8 pt-lg-4 pb-4 mb-3 dokan-product-listing">

            <?php

            /**
             *  dokan_dashboard_content_before hook
             *
             *  @hooked get_dashboard_side_navigation
             *
             *  @since 2.4
             */
            do_action( 'dokan_dashboard_content_inside_before' );
            do_action( 'dokan_before_listing_product' );
            ?>

            <div class="dokan-product-listing-area pt-2 px-4 pl-lg-0 pr-xl-5 cartzilla-dokan-product-listing">
                <?php

                    /**
                     *  dokan_dashboard_before_widgets hook
                     *
                     *  @hooked dokan_show_profile_progressbar
                     *
                     *  @since 2.4
                     */
                    do_action( 'dokan_before_listing_product_widgets' );
                ?>

                <div class="product-listing-top">
                    <?php dokan_product_listing_status_filter(); ?>

                    <?php if ( dokan_is_seller_enabled( get_current_user_id() ) ): ?>
                        <span class="dokan-add-product-link">
                            <?php if ( current_user_can( 'dokan_add_product' ) ): ?>
                                <a href="<?php echo esc_url( dokan_get_navigation_url( 'new-product' ) ); ?>" class="dokan-btn dokan-btn-theme <?php echo esc_attr( ( 'on' == dokan_get_option( 'disable_product_popup', 'dokan_selling', 'off' ) ) ? '' : 'dokan-add-new-product' ); ?>">
                                    <i class="fa fa-briefcase">&nbsp;</i>
                                    <?php esc_html_e( 'Add new product', 'cartzilla' ); ?>
                                </a>
                            <?php endif ?>

                            <?php
                                do_action( 'dokan_after_add_product_btn' );
                            ?>
                        </span>
                    <?php endif; ?>
                </div>

                <?php dokan_product_dashboard_errors(); ?>

                <div class="row">
                    <?php dokan_product_listing_filter(); ?>
                </div>

                <div class="dokan-dashboard-product-listing-wrapper">

                    <form id="product-filter" method="POST" class="dokan-form-inline">
                        <div class="row">
                            <div class="col-sm-8">
                                <div class="form-group">
                                    <label for="bulk-product-action-selector" class="screen-reader-text"><?php esc_html_e( 'Select bulk action', 'cartzilla' ); ?></label>

                                    <select name="status" id="bulk-product-action-selector" class="custom-select chosen">
                                        <?php foreach ( $bulk_statuses as $key => $bulk_status ) : ?>
                                            <option class="bulk-product-status" value="<?php echo esc_attr( $key ) ?>"><?php echo esc_attr( $bulk_status ); ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-4 mb-3">
                                <?php wp_nonce_field( 'bulk_product_status_change', 'security' ); ?>
                                <input type="submit" name="bulk_product_status_change" id="bulk-product-action" class="btn btn-block dokan-btn-theme" value="<?php esc_attr_e( 'Apply', 'cartzilla' ); ?>">
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table dokan-table dokan-table-striped product-listing-table dokan-inline-editable-table" id="dokan-product-list-table">
                                <thead>
                                    <tr>
                                        <th id="cb" class="manage-column column-cb check-column">
                                            <label for="cb-select-all"></label>
                                            <input id="cb-select-all" class="dokan-checkbox" type="checkbox">
                                        </th>
                                        <th><?php esc_html_e( 'Product', 'cartzilla' ); ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $pagenum       = isset( $_GET['pagenum'] ) ? absint( $_GET['pagenum'] ) : 1;
                                    $post_statuses = array( 'publish', 'draft', 'pending', 'future' );
                                    $get_data      = wp_unslash( $_GET );

                                    $args = array(
                                        'posts_per_page' => 15,
                                        'paged'          => $pagenum,
                                        'author'         => get_current_user_id(),
                                        'tax_query'      => array(
                                            array(
                                                'taxonomy' => 'product_type',
                                                'field'    => 'slug',
                                                'terms'    => apply_filters( 'dokan_product_listing_exclude_type', array() ),
                                                'operator' => 'NOT IN',
                                            ),
                                        ),
                                    );

                                    if ( isset( $get_data['post_status']) && in_array( $get_data['post_status'], $post_statuses ) ) {
                                        $args['post_status'] = $get_data['post_status'];
                                    }

                                    if( isset( $get_data['date'] ) && $get_data['date'] != 0 ) {
                                        $args['m'] = $get_data['date'];
                                    }

                                    if( isset( $get_data['product_cat'] ) && $get_data['product_cat'] != -1 ) {
                                        $args['tax_query'][] = array(
                                            'taxonomy' => 'product_cat',
                                            'field' => 'id',
                                            'terms' => (int) $get_data['product_cat'],
                                            'include_children' => false,
                                        );
                                    }

                                    if ( isset( $get_data['product_search_name']) && !empty( $get_data['product_search_name'] ) ) {
                                        $args['s'] = $get_data['product_search_name'];
                                    }

                                    $original_post = $post;
                                    $product_args  = apply_filters( 'dokan_pre_product_listing_args', $args, $get_data );
                                    $product_query = dokan()->product->all( apply_filters( 'dokan_product_listing_arg', $product_args ) );

                                    if ( $product_query->have_posts() ) {
                                        while ($product_query->have_posts()) {
                                            $product_query->the_post();

                                            $row_actions = dokan_product_get_row_action( $post );
                                            $tr_class = ( $post->post_status == 'pending' ) ? 'danger' : '';
                                            $view_class = ($post->post_status == 'pending' ) ? 'dokan-hide' : '';
                                            $product = wc_get_product( $post->ID );

                                            $row_args = array(
                                                'post' => $post,
                                                'product' => $product,
                                                'tr_class' => $tr_class,
                                                'row_actions' => $row_actions,
                                            );

                                            dokan_get_template_part( 'products/products-listing-row', '', $row_args );

                                            do_action( 'dokan_product_list_table_after_row', $product, $post );
                                        }

                                    } else {
                                    ?>
                                        <tr>
                                            <td colspan="11"><?php esc_html_e( 'No product found', 'cartzilla' ); ?></td>
                                        </tr>
                                    <?php } ?>
                                </tbody>

                            </table>
                        </div>
                    </form>
                </div>
                <?php
                    wp_reset_postdata();

                    $pagenum      = isset( $_GET['pagenum'] ) ? absint( $_GET['pagenum'] ) : 1;
                    $base_url = dokan_get_navigation_url('products');

                    if ( $product_query->max_num_pages > 1 ) {
                        $page_links = paginate_links( array(
                            'current'   => $pagenum,
                            'total'     => $product_query->max_num_pages,
                            'base'      => $base_url. '%_%',
                            'format'    => '?pagenum=%#%',
                            'add_args'  => false,
                            'type'      => 'array',
                            'prev_next' => false,
                        ) );

                        echo '<hr class="my-3">';
                        echo '<nav class="d-flex justify-content-center pt-2 cartzilla-shop-pagination w-100" aria-label="' . esc_attr_x( 'Page navigation', 'front-end', 'cartzilla' ) . '">';
                        echo '<ul class="pagination">';
                        foreach( $page_links as $link ) :
                            if ( false !== strpos( $link, 'current' ) ) :
                                echo '<li class="page-item active">' . str_replace( 'page-numbers', 'page-link', $link ) . '</li>';
                            else :
                                echo '<li class="page-item">' . str_replace( 'page-numbers', 'page-link', $link ) . '</li>';
                            endif;
                        endforeach;
                        echo "</ul>";
                        echo '</div>';
                    }

                    /**
                     *  dokan_dashboard_before_widgets hook
                     *
                     *  @hooked dokan_show_profile_progressbar
                     *
                     *  @since 2.4
                     */
                    do_action( 'dokan_after_listing_product_widgets' );
                ?>
            </div>

            <?php

            /**
             *  dokan_dashboard_content_before hook
             *
             *  @hooked get_dashboard_side_navigation
             *
             *  @since 2.4
             */
            do_action( 'dokan_dashboard_content_inside_after' );
            do_action( 'dokan_after_listing_product' );
            ?>

        </section><!-- #primary .content-area -->

        <?php

        /**
         *  dokan_dashboard_content_after hook
         *
         *  @since 2.4
         */
        do_action( 'dokan_dashboard_content_after' );
        ?>
    </div>

<?php do_action( 'dokan_dashboard_wrap_end' ); ?>
