<?php
/**
 * Login form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/global/form-login.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	    https://docs.woocommerce.com/document/template-structure/
 * @package 	WooCommerce/Templates
 * @version     3.6.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

?>
<form class="woocommerce-form woocommerce-form-login login" method="post" <?php echo isset( $hidden ) && $hidden ? 'style="display:none;"' : ''; ?>>

	<?php do_action( 'woocommerce_login_form_start' ); ?>

	<?php echo ! empty( $message ) ? wpautop( wptexturize( $message ) ) : ''; // @codingStandardsIgnoreLine ?>

	<div class="form-group">
		<label for="modal_username"><?php esc_html_e( 'Username or email', 'cartzilla' ); ?><span class="text-danger">*</span></label>
		<input type="text" class="form-control" name="username" id="modal_username" autocomplete="username" />
	</div>
	<div class="form-group">
		<label for="modal_password"><?php esc_html_e( 'Password', 'cartzilla' ); ?><span class="text-danger">*</span></label>
		<div class="password-toggle">
			<input class="form-control" type="password" name="password" id="modal_password" autocomplete="current-password" />
			<label class="password-toggle-btn">
				<input class="custom-control-input" type="checkbox">
				<i class="czi-eye password-toggle-indicator"></i>
				<span class="sr-only"><?php echo esc_html_x( 'Show password', 'front-end', 'cartzilla' ); ?></span>
			</label>
		</div>
	</div>

	<?php do_action( 'woocommerce_login_form' ); ?>

	<div class="form-group d-flex flex-wrap justify-content-between">
		<div class="custom-control custom-checkbox mb-2">
			<input class="custom-control-input" name="rememberme" type="checkbox" id="modal_rememberme" value="forever" />
			<label class="custom-control-label" for="modal_rememberme"><?php esc_html_e( 'Remember me', 'cartzilla' ); ?></label>
		</div>
		<a href="<?php echo esc_url( wp_lostpassword_url() ); ?>" class="font-size-sm"><?php esc_html_e( 'Lost your password?', 'cartzilla' ); ?></a>
	</div>

	<button type="submit" class="btn btn-primary btn-block btn-shadow" name="login" value="<?php esc_attr_e( 'Login', 'cartzilla' ); ?>"><?php esc_html_e( 'Login', 'cartzilla' ); ?></button>

	<?php wp_nonce_field( 'woocommerce-login', 'woocommerce-login-nonce' ); ?>
	<input type="hidden" name="redirect" value="<?php echo esc_url( $redirect ) ?>" />

	<?php do_action( 'woocommerce_login_form_end' ); ?>

</form>
