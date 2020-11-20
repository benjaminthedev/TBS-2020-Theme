<?php
/**
 * Thankyou page
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/thankyou.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.7.0
 */

defined( 'ABSPATH' ) || exit;

?>
<div class="<?php echo cartzilla_get_shop_page_style() !== 'style-v3' ? 'container' : 'container-fluid';?> py-5 my-3">
	<div class="woocommerce-order">

		<?php if ( $order ) : ?>

			<?php do_action( 'woocommerce_before_thankyou', $order->get_id() ); ?>

			<?php if ( $order->has_status( 'failed' ) ) : ?>

				<div class="woocommerce-thankyou-order-failed alert alert-danger alert-with-icon font-size-sm">
					<div class="alert-icon-box">
						<i class="alert-icon czi-announcement font-size-base"></i>
					</div>
					<?php esc_html_e( 'Unfortunately your order cannot be processed as the originating bank/merchant has declined your transaction. Please attempt your purchase again.', 'cartzilla' ); ?>
				</div>
				<div class="woocommerce-thankyou-order-failed-actions mb-4">
					<a href="<?php echo esc_url( $order->get_checkout_payment_url() ); ?>" class="button pay btn btn-primary mr-3"><?php esc_html_e( 'Pay', 'cartzilla' ); ?></a>
					<?php if ( is_user_logged_in() ) : ?>
						<a href="<?php echo esc_url( wc_get_page_permalink( 'myaccount' ) ); ?>" class="button pay btn btn-outline-primary"><?php esc_html_e( 'My account', 'cartzilla' ); ?></a>
					<?php endif; ?>
				</div>

			<?php else : ?>

				<h1 class="woocommerce-thankyou-order-received h4 pb-3 text-center"><?php echo apply_filters( 'woocommerce_thankyou_order_received_text', esc_html__( 'Thank you. Your order has been received.', 'cartzilla' ), $order ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></h1>
				<div class="woocommerce-order-overview woocommerce-thankyou-order-details order_details row mx-n2">

					<div class="woocommerce-order-overview__order order col-md-4 col-sm-6 mb-3 px-2">
						<div class="bg-secondary rounded-lg p-3 text-center font-size-md">
							<?php esc_html_e( 'Order number:', 'cartzilla' ); ?>
							<span class="font-weight-medium"><?php echo wp_kses_post( $order->get_order_number() ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></span>
						</div>
					</div>

					<div class="woocommerce-order-overview__date date col-md-4 col-sm-6 mb-3 px-2">
						<div class="bg-secondary rounded-lg p-3 text-center font-size-md">
							<?php esc_html_e( 'Date:', 'cartzilla' ); ?>
							<span class="font-weight-medium"><?php echo wc_format_datetime( $order->get_date_created() ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></span>
						</div>
					</div>

					<div class="woocommerce-order-overview__total total col-md-4 col-sm-6 mb-3 px-2">
						<div class="bg-secondary rounded-lg p-3 text-center font-size-md">
							<?php esc_html_e( 'Total:', 'cartzilla' ); ?>
							<span class="font-weight-medium"><?php echo wp_kses_post( $order->get_formatted_order_total() ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></span>
						</div>
					</div>

					<?php if ( is_user_logged_in() && $order->get_user_id() === get_current_user_id() && $order->get_billing_email() ) : ?>
						<div class="woocommerce-order-overview__email email col-sm-6 mb-3 px-2">
							<div class="bg-secondary rounded-lg p-3 text-center font-size-md">
								<?php esc_html_e( 'Email:', 'cartzilla' ); ?>
								<span class="font-weight-medium"><?php echo wp_kses_post( $order->get_billing_email() ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></span>
							</div>
						</div>
					<?php endif; ?>

					<?php if ( $order->get_payment_method_title() ) : ?>
						<div class="woocommerce-order-overview__payment-method method col-sm-6 mb-3 px-2">
							<div class="bg-secondary rounded-lg p-3 text-center font-size-md">
								<?php esc_html_e( 'Payment method:', 'cartzilla' ); ?>
								<span class="font-weight-medium"><?php echo wp_kses_post( $order->get_payment_method_title() ); ?></span>
							</div>
						</div>
					<?php endif; ?>

				</div>

			<?php endif; ?>

			<?php do_action( 'woocommerce_thankyou_' . $order->get_payment_method(), $order->get_id() ); ?>
			<?php do_action( 'woocommerce_thankyou', $order->get_id() ); ?>

		<?php else : ?>

			<div class="text-center">
				<h1 class="h4 pb-3"><?php echo esc_html_x( 'Order not found', 'front-end', 'cartzilla' ); ?></h1>
				<?php if ( wc_get_page_id( 'shop' ) > 0 ) : ?>
					<div class="return-to-shop">
						<a class="button wc-backward btn btn-primary" href="<?php echo esc_url( apply_filters( 'woocommerce_return_to_shop_redirect', wc_get_page_permalink( 'shop' ) ) ); ?>">
							<i class="czi-arrow-left mr-1"></i>
							<?php esc_html_e( 'Return to shop', 'cartzilla' ); ?>
						</a>
					</div>
				<?php endif; ?>
			</div>

		<?php endif; ?>

	</div>
</div>
