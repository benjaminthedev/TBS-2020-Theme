<?php
/**
 * The Template for displaying all single posts.
 *
 * @package dokan
 * @package dokan - 2014 1.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

$store_user   = dokan()->vendor->get( get_query_var( 'author' ) );
$store_info   = $store_user->get_shop_info();
$map_location = $store_user->get_location();
$store_style  = cartzilla_is_dokan_vendor_style_enabled();

get_header( 'shop' );

if ( function_exists( 'yoast_breadcrumb' ) ) {
    yoast_breadcrumb( '<p id="breadcrumbs">', '</p>' );
}
?>
<?php do_action( 'woocommerce_before_main_content' ); ?>

<?php if ( ! $store_style  ) : ?>

    <div class="container py-4 py-lg-5">

        <?php dokan_get_template_part( 'store-sidebar', '', array( 'store_user' => $store_user, 'store_info' => $store_info, 'map_location' => $map_location ) ); ?>

        <div id="dokan-primary" class="dokan-single-store dokan-w8 pt-4 py-md-0">
            <div id="dokan-content" class="store-page-wrap woocommerce" role="main">

                <?php dokan_get_template_part( 'store-header' ); ?>

                <?php do_action( 'dokan_store_profile_frame_after', $store_user->data, $store_info ); ?>

                <?php if ( have_posts() ) { ?>

                    <div class="seller-items">

                        <?php woocommerce_product_loop_start(); ?>

                            <?php while ( have_posts() ) : the_post(); ?>

                                <?php wc_get_template_part( 'content', 'product' ); ?>

                            <?php endwhile; // end of the loop. ?>

                        <?php woocommerce_product_loop_end(); ?>

                    </div>

                    <?php dokan_content_nav( 'nav-below' ); ?>

                <?php } else { ?>

                    <p class="dokan-info"><?php esc_html_e( 'No products were found of this vendor!', 'cartzilla' ); ?></p>

                <?php } ?>

            </div>
        </div><!-- .dokan-single-store -->

        <div class="dokan-clearfix"></div>

    </div>

<?php else : ?>

    <?php 
        cartzilla_dokan_dashboard_page_title( $store_user->id );

        do_action( 'cartzilla_dokan_vendor_page_start', $store_user );

        if ( have_posts() ) { ?>

            <div class="seller-items">

                <?php add_filter( 'cartzilla_loop_shop_columns', 'cartzilla_dokan_vendor_page_columns' ); ?>

                <?php woocommerce_product_loop_start(); ?>

                    <?php while ( have_posts() ) : the_post(); ?>

                        <?php wc_get_template_part( 'content', 'product' ); ?>

                    <?php endwhile; // end of the loop. ?>

                <?php woocommerce_product_loop_end(); ?>

                <?php add_filter( 'cartzilla_loop_shop_columns', 'cartzilla_dokan_vendor_page_columns_reset' ); ?>

            </div>

            <?php cartzilla_dokan_store_product_content_nav(); ?>

        <?php } else { ?>

            <p class="dokan-info"><?php esc_html_e( 'No products were found of this vendor!', 'cartzilla' ); ?></p>

        <?php }

        do_action( 'cartzilla_dokan_vendor_page_end', $store_user );
    ?>

<?php endif; ?>

<?php do_action( 'woocommerce_after_main_content' ); ?>

<?php get_footer( 'shop' ); ?>
