<?php
/**
 * Checkout Form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/form-checkout.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.5.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// If checkout registration is disabled and not logged in, the user cannot checkout.
if ( ! $checkout->is_registration_enabled() && $checkout->is_registration_required() && ! is_user_logged_in() ) : ?>
	<div class="page-title <?php echo cartzilla_wc_catalog_type() ===  'dark'  ? 'bg-dark' : 'bg-secondary'; ?> py-4">
		<div class="d-lg-flex justify-content-between py-2 py-lg-3 <?php echo cartzilla_get_shop_page_style() !== 'style-v3' ? 'container' : 'container-fluid';?>">
			<div class="order-lg-2 mb-3 mb-lg-0 pt-lg-2">
				<?php cartzilla_breadcrumbs(); ?>
			</div>
			<div class="order-lg-1 pr-lg-4 text-center text-lg-left">
				<h1 class="h3 <?php echo cartzilla_wc_catalog_type() ===  'dark'  ? 'text-light' : 'text-dark'; ?> mb-0"><?php echo esc_html( get_the_title( wc_get_page_id( 'checkout' ) ) ); ?></h1>
			</div>
		</div>
	</div>
	<div class="<?php echo cartzilla_get_shop_page_style() !== 'style-v3' ? 'container' : 'container-fluid';?> py-4">
		<p><?php echo apply_filters( 'woocommerce_checkout_must_be_logged_in_message', esc_html__( 'You must be logged in to checkout.', 'cartzilla' ) ); ?></p>
	</div>

	<?php return; ?>

<?php endif; ?>

<div class="page-title-overlap <?php echo cartzilla_wc_catalog_type() ===  'dark'  ? ( cartzilla_get_shop_page_style() == 'style-v2' ? 'bg-accent' : 'bg-dark' ) : 'bg-secondary'; ?> pt-4">
	<div class="<?php echo cartzilla_get_shop_page_style() !== 'style-v3' ? 'container' : 'container-fluid';?> d-lg-flex justify-content-between py-2 py-lg-3">
		<div class="order-lg-2 mb-3 mb-lg-0 pt-lg-2">
			<?php cartzilla_breadcrumbs(); ?>
		</div>
		<div class="order-lg-1 pr-lg-4 text-center text-lg-left">
			<h1 class="h3 <?php echo cartzilla_wc_catalog_type() ===  'dark'  ? 'text-light' : 'text-dark'; ?> mb-0"><?php echo esc_html( get_the_title( wc_get_page_id( 'checkout' ) ) ); ?></h1>
		</div>
	</div>
</div>
<div class="<?php echo cartzilla_get_shop_page_style() !== 'style-v3' ? 'container' : 'container-fluid';?> pb-5 mb-2 mb-md-4">
	
	<?php do_action( 'woocommerce_before_checkout_form', $checkout ); ?>

	<form name="checkout" method="post" class="checkout woocommerce-checkout" action="<?php echo esc_url( wc_get_checkout_url() ); ?>" enctype="multipart/form-data">
		<div class="row">
			<section class="col-lg-8">
				<div class="d-flex justify-content-between align-items-center pt-3 pb-4 pb-md-5 my-1">
					<?php if ( wc_ship_to_billing_address_only() && WC()->cart->needs_shipping() ) : ?>
						<h2 class="h6 <?php echo cartzilla_wc_catalog_type() ===  'dark'  ? 'text-light' : 'text-dark'; ?> mb-0"><?php esc_html_e( 'Billing &amp; Shipping', 'cartzilla' ); ?></h2>
					<?php else : ?>
						<h2 class="h6 <?php echo cartzilla_wc_catalog_type() ===  'dark'  ? 'text-light' : 'text-dark'; ?> mb-0"><?php esc_html_e( 'Billing details', 'cartzilla' ); ?></h2>
					<?php endif; ?>
					<?php if ( ! is_user_logged_in() && 'yes' === get_option( 'woocommerce_enable_checkout_login_reminder' ) ) : ?>
						<div class="cz-checkout-login-form">
							<span class="text-light mr-1"><?php echo apply_filters( 'woocommerce_checkout_login_message', esc_html__( 'Returning customer?', 'cartzilla' ) ); ?></span>
							<a class="btn btn-primary btn-sm pl-2" href="#cz-checkout-login" data-toggle="modal">
								<?php echo esc_html__( 'Click here to login', 'cartzilla' ); ?>
							</a>
						</div>
					<?php else: ?>
						<a class="btn <?php echo cartzilla_get_shop_page_style() == 'style-v2' ? 'btn-outline-light' : 'btn-outline-primary'; ?> btn-sm pl-2" href="<?php echo esc_url( get_permalink( wc_get_page_id( 'cart' ) ) ); ?>">
							<i class="czi-arrow-left mr-2"></i>
							<?php echo esc_html_x( 'Back to cart', 'front-end', 'cartzilla' ); ?>
						</a>
					<?php endif; ?>
				</div>

				<?php if ( $checkout->get_checkout_fields() ) : ?>

					<?php do_action( 'woocommerce_checkout_before_customer_details' ); ?>

					<div id="customer_details" class="pt-3 pt-md-0">
						<?php do_action( 'woocommerce_checkout_billing' ); ?>
						<?php do_action( 'woocommerce_checkout_shipping' ); ?>
					</div>

					<?php do_action( 'woocommerce_checkout_after_customer_details' ); ?>

				<?php endif; ?>

			</section>
			<aside class="col-lg-4 pt-4 pt-lg-0">
				<div class="cz-sidebar-static rounded-lg box-shadow-lg ml-lg-auto">
					<?php do_action( 'woocommerce_checkout_before_order_review_heading' ); ?>

					<h2 class="h6 mb-3 pb-1 text-center" id="order_review_heading"><?php esc_html_e( 'Your order', 'cartzilla' ); ?></h2>

					<?php do_action( 'woocommerce_checkout_before_order_review' ); ?>

					<div id="order_review" class="woocommerce-checkout-review-order">
						<?php do_action( 'woocommerce_checkout_order_review' ); ?>
					</div>

					<?php do_action( 'woocommerce_checkout_after_order_review' ); ?>
				</div>
			</aside>
		</div>
	</form>

	<?php do_action( 'woocommerce_after_checkout_form', $checkout ); ?>

	<?php if ( ! is_user_logged_in() && 'yes' === get_option( 'woocommerce_enable_checkout_login_reminder' ) ) : ?>

	<?php endif; ?>

</div>
