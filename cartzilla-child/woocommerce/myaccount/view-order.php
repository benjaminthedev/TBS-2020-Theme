<?php
/**
 * View Order
 *
 * Shows the details of a particular order on the account page.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/view-order.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.0.0
 */

defined( 'ABSPATH' ) || exit;

$notes = $order->get_customer_order_notes();

?>
<div class="d-none d-lg-flex justify-content-between align-items-center pt-lg-3 pb-4 pb-lg-5 mb-lg-3">
	<h6 class="font-size-base <?php echo cartzilla_wc_catalog_type() ===  'dark'  ? 'text-light' : 'text-dark'; ?> mb-0">
		<?php printf(
			/* translators: 1: order number 2: order date 3: order status */
			esc_html_x( 'Order #%1$s was placed on %2$s and is currently %3$s', 'front-end', 'cartzilla' ),
			'<span class="order-number">' . $order->get_order_number() . '</span>', // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			'<span class="order-date">' . wc_format_datetime( $order->get_date_created() ) . '</span>', // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			'<span class="order-status badge badge-' . $order->get_status() . ' font-size-sm ml-1">' . wc_get_order_status_name( $order->get_status() ) . '</span>' // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		); ?>
	</h6>
	<a class="btn btn-primary btn-sm" href="<?php echo esc_url( wc_logout_url() ); ?>">
		<i class="czi-sign-out mr-2"></i>
		<?php echo esc_html_x( 'Logout', 'front-end', 'cartzilla' ); ?>
	</a>
</div>

<?php if ( $notes ) : ?>
	<h2 class="h5 pb-2"><?php esc_html_e( 'Order updates', 'cartzilla' ); ?></h2>
	<div class="woocommerce-OrderUpdates">
		<?php foreach ( $notes as $note ) : ?>
		<div class="woocommerce-OrderUpdate card mb-3">
			<div class="card-body">
				<div class="font-size-md"><?php echo wpautop( wptexturize( $note->comment_content ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></div>
				<div class="font-size-sm text-muted">
					<i class="czi-time align-middle mr-1 mt-n1"></i>
					<?php echo date_i18n( esc_html__( 'l jS \o\f F Y, h:ia', 'cartzilla' ), strtotime( $note->comment_date ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
				</div>
			</div>
		</div>
		<?php endforeach; ?>
	</div>
<?php endif; ?>

<?php do_action( 'woocommerce_view_order', $order_id ); ?>
