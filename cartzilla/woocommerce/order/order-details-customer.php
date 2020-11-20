<?php
/**
 * Order Customer Details
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/order/order-details-customer.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.4.4
 */

defined( 'ABSPATH' ) || exit;

$show_shipping = ! wc_ship_to_billing_address_only() && $order->needs_shipping_address();
?>
<section class="woocommerce-customer-details">
	<div class="row pt-4">
		<div class="col-sm-6 mb-4 mb-sm-0">
			<div class="border rounded-lg p-4 h-100">
				<h2 class="woocommerce-column__title h6"><?php esc_html_e( 'Billing address', 'cartzilla' ); ?></h2>
				<ul class="font-size-sm list-unstyled">
					<li class="woocommerce-customer-details--address d-flex">
						<i class="czi-location opacity-60 mr-2 mt-1"></i>
						<div><?php echo wp_kses_post( $order->get_formatted_billing_address( esc_html__( 'N/A', 'cartzilla' ) ) ); ?></div>
					</li>
					<?php if ( $order->get_billing_phone() ) : ?>
						<li class="woocommerce-customer-details--phone d-flex">
							<i class="czi-mobile opacity-60 mr-2 mt-1"></i>
							<div><?php echo esc_html( $order->get_billing_phone() ); ?></div>
						</li>
					<?php endif; ?>
					<?php if ( $order->get_billing_email() ) : ?>
						<li class="woocommerce-customer-details--email d-flex">
							<i class="czi-mail opacity-60 mr-2 mt-1"></i>
							<div><?php echo esc_html( $order->get_billing_email() ); ?></div>
						</li>
					<?php endif; ?>
				</ul>
			</div>
		</div>
		<?php if ( $show_shipping ) : ?>
			<div class="col-sm-6">
				<div class="border rounded-lg p-4 h-100">
					<h2 class="woocommerce-column__title h6"><?php esc_html_e( 'Shipping address', 'cartzilla' ); ?></h2>
					<ul class="font-size-sm list-unstyled">
						<li class="woocommerce-customer-details--address d-flex">
							<i class="czi-location opacity-60 mr-2 mt-1"></i>
							<div><?php echo wp_kses_post( $order->get_formatted_shipping_address( esc_html__( 'N/A', 'cartzilla' ) ) ); ?></div>
						</li>
					</ul>
				</div>
			</div>
		<?php endif; ?>
	</div>

	<?php do_action( 'woocommerce_order_details_after_customer_details', $order ); ?>

</section>
