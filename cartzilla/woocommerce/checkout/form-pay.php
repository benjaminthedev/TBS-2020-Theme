<?php
/**
 * Pay for order form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/form-pay.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.4.0
 */

defined( 'ABSPATH' ) || exit;

$totals = $order->get_order_item_totals(); // phpcs:ignore WordPress.WP.GlobalVariablesOverride.OverrideProhibited

?>
<div class="page-title-overlap <?php echo cartzilla_wc_catalog_type() ===  'dark'  ? ( cartzilla_get_shop_page_style() == 'style-v2' ? 'bg-accent' : 'bg-dark' ) : 'bg-secondary'; ?> pt-4">
	<div class="container d-lg-flex justify-content-between py-2 py-lg-3">
		<div class="order-lg-2 mb-3 mb-lg-0 pt-lg-2">
			<?php cartzilla_breadcrumbs(); ?>
		</div>
		<div class="order-lg-1 pr-lg-4 text-center text-lg-left">
			<h1 class="h3 <?php echo cartzilla_wc_catalog_type() ===  'dark'  ? 'text-light' : 'text-dark'; ?> mb-0"><?php echo esc_html( get_the_title( wc_get_page_id( 'checkout' ) ) ); ?></h1>
		</div>
	</div>
</div>
<div class="container pb-5 mb-2 mb-md-4">
		<div class="row">
			<section class="col-lg-8">
				<div class="d-flex justify-content-between align-items-center pt-3 pb-3 pb-md-5 my-1">
					<h2 class="h6 text-light mb-0"><?php esc_html_e( 'Order number:', 'cartzilla' ); ?>&nbsp;#<?php echo esc_html( $order->get_order_number() ); ?></h2>
				</div>
				<?php if ( count( $order->get_items() ) > 0 ) : ?>
					<div class="shop_table shop_table_responsive cart woocommerce-cart-form__contents">
						<?php
						/** @var WC_Order_Item_Product $item */
						foreach ( $order->get_items() as $item_id => $item ) :
							if ( ! apply_filters( 'woocommerce_order_item_visible', true, $item ) ) {
								continue;
							}

							/** @var WC_Product $product */
							$product = $item->get_product();

							?>
							<div class="<?php echo esc_attr( apply_filters( 'woocommerce_order_item_class', 'order_item d-sm-flex justify-content-between align-items-center my-4 pb-3 border-bottom', $item, $order ) ); ?>">
								<div class="media d-block d-sm-flex align-items-center text-center text-sm-left">
									<div class="product-thumbnail d-inline-block mx-auto mr-sm-4 mb-2 mb-sm-0" style="width: 10rem;">
										<?php if ( $product ) : ?>
											<?php if ( $product->is_visible() ) : ?>
												<a href="<?php echo esc_url( $product->get_permalink() ); ?>" class="d-block">
													<?php echo apply_filters( 'woocommerce_order_item_thumbnail', $product->get_image(), $item, $order ); ?>
												</a>
											<?php else: ?>
												<div>
													<?php echo apply_filters( 'woocommerce_order_item_thumbnail', $product->get_image(), $item, $order ); ?>
												</div>
											<?php endif; ?>
										<?php else: ?>
											<?php echo wc_placeholder_img(); ?>
										<?php endif; ?>
									</div>
									<div class="media-body">
										<div class="product-name">
											<h3 class="product-title font-size-base mb-2">
												<?php if ( $product && $product->is_visible() ) : ?>
													<a href="<?php echo esc_url( $product->get_permalink() ); ?>"><?php echo esc_html( $product->get_name() ); ?></a>
												<?php else: ?>
												    <?php echo esc_html( $item->get_name() ); ?>
												<?php endif; ?>
											</h3>
										</div>
										<div class="product-meta">
											<?php
											do_action( 'woocommerce_order_item_meta_start', $item_id, $item, $order, false );
											wc_display_item_meta( $item, [
												'before'       => '<ul class="wc-item-meta font-size-sm list-unstyled"><li>',
												'label_before' => '<span class="wc-item-meta-label text-muted mr-1">',
												'label_after'  => ':</span> ',
											] );
											do_action( 'woocommerce_order_item_meta_end', $item_id, $item, $order, false );
											?>
										</div>
										<div class="font-size-base mb-2 mb-sm-0">
											<span class="product-price text-accent"><?php echo wp_kses_post( $order->get_formatted_line_subtotal( $item ) ); ?></span><?php // @codingStandardsIgnoreLine ?>
											<span class="product-quantity text-muted"><?php echo apply_filters( 'woocommerce_order_item_quantity_html', sprintf( '&times;&nbsp;%s', esc_html( $item->get_quantity() ) ), $item ); ?></span><?php // @codingStandardsIgnoreLine ?>
										</div>
									</div>
								</div>
							</div>
						<?php endforeach; ?>
					</div>
				<?php endif; ?>
			</section>
			<aside class="col-lg-4 pt-4 pt-lg-0">
				<form id="order_review" method="post">
					<div class="cz-sidebar-static rounded-lg box-shadow-lg ml-lg-auto">
						<h2 class="h6 mb-3 pb-1 text-center"><?php echo esc_html_x( 'Order totals', 'front-end', 'cartzilla' ); ?></h2>
						<?php if ( $totals ) : ?>
							<?php foreach ( $totals as $total ) : ?>
								<div class="d-flex justify-content-between align-items-center font-size-md mb-2 pb-1">
									<span class="mr-2"><?php echo esc_html( $total['label'] ); ?></span>
									<span class="text-right"><?php echo wp_kses_post( $total['value'] ); ?></span>
								</div>
							<?php endforeach; ?>
						<?php endif; ?>
						<?php if ( $order->needs_payment() ) : ?>
							<ul class="wc_payment_methods payment_methods methods list-unstyled border-top pt-4 mt-4">
								<?php
								if ( ! empty( $available_gateways ) ) {
									foreach ( $available_gateways as $gateway ) {
										wc_get_template( 'checkout/payment-method.php', array( 'gateway' => $gateway ) );
									}
								} else {
									echo '<li class="woocommerce-notice woocommerce-notice--info woocommerce-info font-size-sm text-muted">' . apply_filters( 'woocommerce_no_available_payment_methods_message', WC()->customer->get_billing_country() ? esc_html__( 'Sorry, it seems that there are no available payment methods for your state. Please contact us if you require assistance or wish to make alternate arrangements.', 'cartzilla' ) : esc_html__( 'Please fill in your details above to see available payment methods.', 'cartzilla' ) ) . '</li>'; // @codingStandardsIgnoreLine
								}
								?>
							</ul>
						<?php endif; ?>
						<div class="border-top pt-4">
							<?php wc_get_template( 'checkout/terms.php' ); ?>

							<?php do_action( 'woocommerce_pay_order_before_submit' ); ?>

							<?php echo apply_filters( 'woocommerce_pay_order_button_html', '<button type="submit" class="btn btn-primary btn-block" id="place_order" value="' . esc_attr( $order_button_text ) . '" data-value="' . esc_attr( $order_button_text ) . '">' . esc_html( $order_button_text ) . '</button>' ); // @codingStandardsIgnoreLine ?>

							<?php do_action( 'woocommerce_pay_order_after_submit' ); ?>
						</div>
					</div>
					<input type="hidden" name="woocommerce_pay" value="1" />
					<?php wp_nonce_field( 'woocommerce-pay', 'woocommerce-pay-nonce' ); ?>
				</form>
			</aside>
		</div>
</div>
