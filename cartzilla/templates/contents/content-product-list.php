<?php
/**
 * Product List View
 *
 * @package Cartzilla/WooCommerce
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $product;

$classes[] = 'product-list widget py-2 mb-0';

?>
<li <?php post_class( $classes ); ?>>

	<?php
	/**
	 * @hooked cartzilla_wrap_product_outer - 10
	 */
	do_action( 'cartzilla_before_product_list' ); ?>

	<div class="media align-items-center">

		<?php
		/**
		 * @hooked cartzilla_product_media_object - 10
		 */
		do_action( 'cartzilla_before_product_list_view_body' ); ?>

		<div class="media-body">
			<?php
			/**
			 * @hooked cartzilla_template_loop_categories - 10
			 * @hooked woocommerce_template_loop_product_link_open - 20
			 * @hooked woocommerce_template_loop_product_title - 30
			 * @hooked woocommerce_template_loop_product_link_close - 40
			 * @hooked cartzilla_wrap_price_and_add_to_cart - 50
			 * @hooked woocommerce_template_loop_price - 60
			 * @hooked woocommerce_template_loop_add_to_cart - 70
			 * @hooked cartzilla_wrap_price_and_add_to_cart_close - 80
			 */
			do_action( 'cartzilla_product_list_view_body' ); ?>
		</div>
	</div>
	<?php
	/**
	 * @hooked cartzilla_wrap_product_outer_close - 10
	 */
	do_action( 'cartzilla_after_product_list' ); ?>

</li>
