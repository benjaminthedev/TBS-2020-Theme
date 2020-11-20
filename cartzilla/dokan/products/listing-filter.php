<?php
/**
 * Dokan Dashboard Product Listing
 * filter template
 *
 * @since 2.4
 *
 * @package dokan
 */

$get_data  = wp_unslash( $_GET ); // WPCS: CSRF ok.
$post_data = wp_unslash( $_POST ); // WPCS: CSRF ok.

do_action( 'dokan_product_listing_filter_before_form' );
?>
    <div class="col-12">

        <form class="dokan-product-date-filter row" method="get" >
            <?php do_action( 'dokan_product_listing_filter_from_start', $get_data ); ?>
            <div class="col-sm-4">
                <div class="form-group">
                    <?php cartzilla_dokan_product_listing_filter_months_dropdown( dokan_get_current_user_id() ); ?>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="form-group">
                    <?php
                        wp_dropdown_categories( array(
                            'show_option_none' => esc_html__( '- Select a category -', 'cartzilla' ),
                            'hierarchical'     => 1,
                            'hide_empty'       => 0,
                            'name'             => 'product_cat',
                            'id'               => 'product_cat',
                            'taxonomy'         => 'product_cat',
                            'title_li'         => '',
                            'class'            => 'product_cat custom-select chosen',
                            'exclude'          => '',
                            'selected'         => isset( $get_data['product_cat'] ) ? $get_data['product_cat'] : '-1',
                        ) );
                    ?>
                </div>
            </div>

            <?php do_action( 'dokan_product_listing_filter_from_end', $get_data ); ?>

            <?php
            if ( isset( $get_data['product_search_name'] ) ) { ?>
                <input type="hidden" name="product_search_name" value="<?php echo esc_attr( $get_data['product_search_name'] ); ?>">
            <?php }
            ?>

            <div class="col-sm-4 mb-3">
                <button type="submit" name="product_listing_filter" value="ok" class="btn btn-block dokan-btn dokan-btn-theme"><?php esc_html_e( 'Filter', 'cartzilla'); ?></button>
            </div>

        </form>
    </div>

    <?php do_action( 'dokan_product_listing_filter_before_search_form' ); ?>

    <div class="col-12">

        <form method="get" class="dokan-product-search-form row">

            <?php wp_nonce_field( 'dokan_product_search', 'dokan_product_search_nonce' ); ?>

            <div class="col-sm-8">
                <div class="form-group">
                    <input type="text" class="form-control" name="product_search_name" placeholder="<?php esc_html_e( 'Search Products', 'cartzilla' ) ?>" value="<?php echo isset( $get_data['product_search_name'] ) ? esc_attr( $get_data['product_search_name'] ) : '' ?>">
                </div>
            </div>

            <div class="col-sm-4 mb-3">
                <button type="submit" name="product_listing_search" value="ok" class="btn btn-block dokan-btn-theme"><?php esc_html_e( 'Search', 'cartzilla' ); ?></button>
            </div>

            <?php
            if ( isset( $get_data['product_cat'] ) ) { ?>
                <input type="hidden" name="product_cat" value="<?php echo esc_attr( $get_data['product_cat'] ); ?>">
            <?php }

            if ( isset( $get_data['date'] ) ) { ?>
                <input type="hidden" name="date" value="<?php echo esc_attr( $get_data['date'] ); ?>">
            <?php }
            ?>
        </form>
    </div>

    <?php do_action( 'dokan_product_listing_filter_after_form' ); ?>
