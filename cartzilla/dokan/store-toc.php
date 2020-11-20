<?php
/**
 * The Template for displaying all reviews.
 *
 * @package dokan
 * @package dokan - 2014 1.0
 */

$vendor       = dokan()->vendor->get( get_query_var( 'author' ) );
$vendor_info  = $vendor->get_shop_info();
$map_location = $vendor->get_location();
$store_style  = cartzilla_is_dokan_vendor_style_enabled();

get_header( 'shop' );
?>

<?php do_action( 'woocommerce_before_main_content' ); ?>
    
<?php if ( ! $store_style  ) : ?>

    <div class="container py-4 py-lg-5">

        <?php dokan_get_template_part( 'store-sidebar', '', array( 'store_user' => $vendor, 'store_info' => $vendor_info, 'map_location' => $map_location ) ); ?>

        <div id="primary" class="content-area dokan-single-store dokan-w8">
            <div id="dokan-content" class="site-content store-review-wrap woocommerce" role="main">

                <?php dokan_get_template_part( 'store-header' ); ?>

                <div id="store-toc-wrapper">
                    <div id="store-toc">
                        <?php
                        if( ! empty( $vendor->get_store_tnc() ) ):
                        ?>
                            <h2 class="headline"><?php esc_html_e( 'Terms And Conditions', 'cartzilla' ); ?></h2>
                            <div>
                                <?php
                                    echo wp_kses_post( nl2br( $vendor->get_store_tnc() ) );
                                ?>
                            </div>
                        <?php
                        endif;
                        ?>
                    </div><!-- #store-toc -->
                </div><!-- #store-toc-wrap -->

            </div><!-- #content .site-content -->
        </div><!-- #primary .content-area -->

        <div class="dokan-clearfix"></div>

    </div>

<?php else : ?>

    <?php 
        cartzilla_dokan_dashboard_page_title( $vendor->id );

        do_action( 'cartzilla_dokan_vendor_page_start', $vendor );

        ?>
        <div id="store-toc-wrapper">
            <div id="store-toc">
                <?php if( ! empty( $vendor->get_store_tnc() ) ) : ?>
                    <div>
                        <?php echo wp_kses_post( nl2br( $vendor->get_store_tnc() ) ); ?>
                    </div>
                <?php endif; ?>
            </div><!-- #store-toc -->
        </div><!-- #store-toc-wrap -->
        <?php

        do_action( 'cartzilla_dokan_vendor_page_end', $vendor );
    ?>

<?php endif; ?>

<?php do_action( 'woocommerce_after_main_content' ); ?>

<?php get_footer(); ?>
