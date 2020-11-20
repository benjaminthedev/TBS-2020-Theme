<?php
/**
 * Order tracking form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/order/form-tracking.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.6.0
 */

defined( 'ABSPATH' ) || exit;

global $post;

?>
<div class="row justify-content-center pt-4">
	<div class="col-lg-8 col-md-10">
		<h1 class="h3 mb-4"><?php echo esc_html_x( 'Order tracking form', 'front-end', 'cartzilla' ); ?></h1>
		<p class="font-size-md"><?php esc_html_e( 'To track your order please enter your Order ID in the box below and press the "Track" button. This was given to you on your receipt and in the confirmation email you should have received.', 'cartzilla' ); ?></p>
		<div class="card py-2 mt-4">
			<form action="<?php echo esc_url( get_permalink( $post->ID ) ); ?>" method="post" class="woocommerce-form woocommerce-form-track-order track_order card-body">
				<div class="form-group">
					<label for="orderid"><?php esc_html_e( 'Order ID', 'cartzilla' ); ?></label>
					<input class="form-control" type="text" name="orderid" id="orderid" value="<?php echo isset( $_REQUEST['orderid'] ) ? esc_attr( wp_unslash( $_REQUEST['orderid'] ) ) : ''; ?>" placeholder="<?php esc_attr_e( 'Found in your order confirmation email.', 'cartzilla' ); ?>" /><?php // @codingStandardsIgnoreLine ?>
				</div>
				<div class="form-group">
					<label for="order_email"><?php esc_html_e( 'Billing email', 'cartzilla' ); ?></label>
					<input class="form-control" type="text" name="order_email" id="order_email" value="<?php echo isset( $_REQUEST['order_email'] ) ? esc_attr( wp_unslash( $_REQUEST['order_email'] ) ) : ''; ?>" placeholder="<?php esc_attr_e( 'Email you used during checkout.', 'cartzilla' ); ?>" /><?php // @codingStandardsIgnoreLine ?>
				</div>
				<button type="submit" class="btn btn-primary" name="track" value="<?php esc_attr_e( 'Track', 'cartzilla' ); ?>"><?php esc_html_e( 'Track', 'cartzilla' ); ?></button>
				<?php wp_nonce_field( 'woocommerce-order_tracking', 'woocommerce-order-tracking-nonce' ); ?>
			</form>
		</div>
	</div>
</div>
