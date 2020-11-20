<?php
/**
 * Checkout coupon form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/form-coupon.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.4.4
 */

defined( 'ABSPATH' ) || exit;

if ( ! wc_coupons_enabled() ) { // @codingStandardsIgnoreLine.
	return;
}

?>
<div class="row mt-2">
	<div class="col-lg-8">
		<div class="cz-sidebar-static rounded-lg box-shadow-lg mw-100">
			<div class="woocommerce-form-coupon-toggle">
				<?php echo apply_filters( 'woocommerce_checkout_coupon_message', sprintf( '<a class="showcoupon font-size-sm font-weight-medium nav-link-style" href="#">%s</a>', esc_html__( 'Have a coupon?', 'cartzilla' ) ) ); ?>
			</div>
			<form class="checkout_coupon woocommerce-form-coupon mt-2" method="post" style="display:none" id="cz-checkout-coupon">
				<div class="form-group">
					<input type="text" name="coupon_code" class="input-text form-control" placeholder="<?php esc_attr_e( 'Coupon code', 'cartzilla' ); ?>" id="coupon_code" value=""/>
				</div>
				<button type="submit" class="button btn btn-outline-primary btn-sm btn-block" name="apply_coupon" value="<?php esc_attr_e( 'Apply coupon', 'cartzilla' ); ?>"><?php esc_html_e( 'Apply coupon', 'cartzilla' ); ?></button>
			</form>
		</div>
	</div>
</div>

