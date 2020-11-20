<?php
/**
 * My Addresses
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/my-address.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 2.6.0
 */

defined( 'ABSPATH' ) || exit;

$customer_id = get_current_user_id();

if ( ! wc_ship_to_billing_address_only() && wc_shipping_enabled() ) {
	$get_addresses = apply_filters(
		'woocommerce_my_account_get_addresses',
		array(
			'billing'  => esc_html__( 'Billing address', 'cartzilla' ),
			'shipping' => esc_html__( 'Shipping address', 'cartzilla' ),
		),
		$customer_id
	);
} else {
	$get_addresses = apply_filters(
		'woocommerce_my_account_get_addresses',
		array(
			'billing' => esc_html__( 'Billing address', 'cartzilla' ),
		),
		$customer_id
	);
}

?>
<div class="d-none d-lg-flex justify-content-between align-items-center pt-lg-3 pb-4 pb-lg-5 mb-lg-4">
	<h6 class="font-size-base <?php echo cartzilla_wc_catalog_type() ===  'dark'  ? 'text-light' : 'text-dark'; ?> mb-0"><?php echo apply_filters( 'woocommerce_my_account_my_address_description', esc_html__( 'The following addresses will be used on the checkout page by default.', 'cartzilla' ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></h6>
	<a class="btn btn-primary btn-sm" href="<?php echo esc_url( wc_logout_url() ); ?>">
		<i class="czi-sign-out mr-2"></i>
		<?php echo esc_html_x( 'Logout', 'front-end', 'cartzilla' ); ?>
	</a>
</div>
<div class="row">
	<?php foreach ( $get_addresses as $name => $address_title ) : ?>
	<?php $address = wc_get_account_formatted_address( $name ); ?>
		<div class="col-sm-6 mb-4 mb-sm-0">
			<div class="border rounded-lg p-4 h-100">
				<h2 class="woocommerce-column__title h6"><?php echo esc_html( $address_title ); ?></h2>
				<ul class="font-size-sm list-unstyled mb-0">
					<?php if ( ! empty( $address ) ) : ?>
						<li class="woocommerce-customer-details--address d-flex">
							<i class="czi-location opacity-60 mr-2 mt-1"></i>
							<div><?php echo wp_kses_post( $address ); ?></div>
						</li>
						<li class="woocommerce-customer-details--edit pt-2">
							<a class="btn btn-outline-primary btn-sm" href="<?php echo esc_url( wc_get_endpoint_url( 'edit-address', $name ) ); ?>">
								<i class="czi-edit mr-1"></i>
								<?php esc_html_e( 'Edit', 'cartzilla' ); ?>
							</a>
						</li>
					<?php else: ?>
						<li class="woocommerce-customer-details--address--empty">
							<?php esc_html_e( 'You have not set up this type of address yet.', 'cartzilla' ); ?>
						</li>
						<li class="woocommerce-customer-details--edit pt-2">
							<a class="btn btn-outline-primary btn-sm" href="<?php echo esc_url( wc_get_endpoint_url( 'edit-address', $name ) ); ?>">
								<i class="czi-add font-size-xs mr-1"></i>
								<?php esc_html_e( 'Add', 'cartzilla' ); ?>
							</a>
						</li>
					<?php endif; ?>
				</ul>
			</div>
		</div>
	<?php endforeach; ?>
</div>
