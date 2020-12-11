<?php
/**
 * Template functions used in WooCommerce pages
 */
function cartzilla_wc_cart_coupon( $coupon ) {
	if ( is_string( $coupon ) ) {
		$coupon = new WC_Coupon( $coupon );
	}

	$discount_amount_html = '';

	$amount               = WC()->cart->get_coupon_discount_amount( $coupon->get_code(), WC()->cart->display_cart_ex_tax );
	$discount_amount_html = '-' . wc_price( $amount );

	if ( $coupon->get_free_shipping() && empty( $amount ) ) {
		$discount_amount_html = esc_html__( 'Free shipping coupon', 'cartzilla' );
	}

	$discount_amount_html = apply_filters( 'woocommerce_coupon_discount_amount_html', $discount_amount_html, $coupon );
	$coupon_html          = $discount_amount_html;

	echo wp_kses( apply_filters( 'woocommerce_cart_totals_coupon_html', $coupon_html, $coupon, $discount_amount_html ), array_replace_recursive( wp_kses_allowed_html( 'post' ), array( 'a' => array( 'data-coupon' => true ) ) ) ); // phpcs:ignore PHPCompatibility.PHP.NewFunctions.array_replace_recursiveFound
}

/**
 * Outputs coupon remove link.
 *
 * @param string|WC_Coupon $coupon Coupon data or code.
 *
 * @since 1.0.0
 */
function cartzilla_wc_cart_coupon_remove( $coupon ) {
	if ( is_string( $coupon ) ) {
		$coupon = new WC_Coupon( $coupon );
	}

	echo '<a  class="mr-1" href="' . esc_url( add_query_arg( 'remove_coupon', rawurlencode( $coupon->get_code() ), defined( 'WOOCOMMERCE_CHECKOUT' ) ? wc_get_checkout_url() : wc_get_cart_url() ) ) . '" class="woocommerce-remove-coupon" data-coupon="' . esc_attr( $coupon->get_code() ) . '"><i class="czi-close-circle"></i></a>';
}

/**
 * Modify checkout billing fields.
 *
 * @param array $fields
 *
 * @return array
 *
 * @since 1.0.0
 */
function cartzilla_wc_checkout_address_fields( $fields ) {
	foreach ( $fields as $field => &$args ) {
		switch ( $field ) {
				case 'billing_email':
				$args['class']       = [ 'form-group', 'col-sm-12' ];
				$args['input_class'] = [ 'form-control' ];
				break;
			case 'first_name':
			case 'last_name':
			case 'billing_phone':
				$args['class']       = [ 'form-group', 'col-sm-6' ];
				$args['input_class'] = [ 'form-control' ];
				break;

			case 'country':
				$args['class']       = [ 'form-group', 'col-sm-6', 'address-field', 'update_totals_on_change' ];
				$args['input_class'] = [ 'form-control' ];
				break;

			case 'company':	
			case 'address_1':
				$args['class']       = [ 'form-group', 'col-sm-12', 'address-field' ];
				$args['input_class'] = [ 'form-control' ];
				break;

			case 'address_2':
			case 'city':
			case 'state':
			case 'postcode':
				$args['class']       = [ 'form-group', 'col-sm-6', 'address-field' ];
				$args['input_class'] = [ 'form-control' ];
				break;
		}
	}

	return $fields;
}

/**
 * Modify other checkout fields, like account, order, etc.
 *
 * @param array $fields
 *
 * @return array
 *
 * @since 1.0.0
 */
function cartzilla_wc_checkout_fields( $fields ) {
	if ( ! empty( $fields['account'] ) ) {
		if ( 'no' === get_option( 'woocommerce_registration_generate_username' ) ) {
			$fields['account']['account_username']['class']       = [ 'form-group', 'col-sm-12' ];
			$fields['account']['account_username']['input_class'] = [ 'form-control' ];
		}

		if ( 'no' === get_option( 'woocommerce_registration_generate_password' ) ) {
			$fields['account']['account_password']['class']       = [ 'form-group', 'col-sm-12' ];
			$fields['account']['account_password']['input_class'] = [ 'form-control' ];
		}
	}

	if ( ! empty( $fields['order'] ) ) {
		if ( isset( $fields['order']['order_comments'] ) ) {
			$fields['order']['order_comments']['class']       = [ 'form-group' ];
			$fields['order']['order_comments']['input_class'] = [ 'form-control' ];
		}
	}


	return $fields;
}


if ( ! function_exists( 'cartzilla_row_open' ) ) {
    function cartzilla_row_open() { ?>
        <div class="row"><?php
    }
}

if ( ! function_exists( 'cartzilla_row_close' ) ) {
    function cartzilla_row_close() { ?>
        </div><?php
    }
}

if ( ! function_exists( 'cartzilla_output_cross_sell_products' ) ) {
    function cartzilla_output_cross_sell_products() {
        if ( apply_filters( 'cartzilla_enable_cross_sell_products', true ) ) {
            woocommerce_cross_sell_display( 4, 4 );
        }
    }
}

if ( ! function_exists( 'cartzilla_woocommerce_save_account_form_profile_pic_field' ) ) {
    function cartzilla_woocommerce_save_account_form_profile_pic_field( $user_id ) {
        if ( ! current_user_can( 'edit_user', $user_id ) ) { return false; }
        update_user_meta( $user_id, '_cartzilla_custom_avatar_id', absint( $_POST['cartzilla_custom_avatar_id'] ) );
    }
}