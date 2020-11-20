<?php
/**
 * Lost password reset form.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/form-reset-password.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.5.5
 */

defined( 'ABSPATH' ) || exit;

do_action( 'woocommerce_before_reset_password_form' );
?>
<div class="container pb-5">
	<div class="row justify-content-center pt-5 mt-md-2">
		<div class="col-lg-8">
			<form method="post" class="woocommerce-ResetPassword lost_reset_password">

				<p><?php echo apply_filters( 'woocommerce_reset_password_message', esc_html__( 'Enter a new password below.', 'cartzilla' ) ); ?></p><?php // @codingStandardsIgnoreLine ?>

				<div class="woocommerce-form-row woocommerce-form-row--first form-group">
					<label for="password_1"><?php esc_html_e( 'New password', 'cartzilla' ); ?><span class="text-danger">*</span></label>
					<div class="password-toggle">
						<input type="password" class="woocommerce-Input woocommerce-Input--text input-text form-control" name="password_1" id="password_1" autocomplete="new-password" />
						<label class="password-toggle-btn">
							<input class="custom-control-input" type="checkbox">
							<i class="czi-eye password-toggle-indicator"></i>
							<span class="sr-only"><?php echo esc_html_x( 'Show password', 'front-end', 'cartzilla' ); ?></span>
						</label>
					</div>
				</div>
				<div class="woocommerce-form-row woocommerce-form-row--last form-group">
					<label for="password_2"><?php esc_html_e( 'Re-enter new password', 'cartzilla' ); ?><span class="text-danger">*</span></label>
					<div class="password-toggle">
						<input type="password" class="woocommerce-Input woocommerce-Input--text input-text form-control" name="password_2" id="password_2" autocomplete="new-password" />
						<label class="password-toggle-btn">
							<input class="custom-control-input" type="checkbox">
							<i class="czi-eye password-toggle-indicator"></i>
							<span class="sr-only"><?php echo esc_html_x( 'Show password', 'front-end', 'cartzilla' ); ?></span>
						</label>
					</div>
				</div>

				<input type="hidden" name="reset_key" value="<?php echo esc_attr( $args['key'] ); ?>" />
				<input type="hidden" name="reset_login" value="<?php echo esc_attr( $args['login'] ); ?>" />

				<?php do_action( 'woocommerce_resetpassword_form' ); ?>

				<input type="hidden" name="wc_reset_password" value="true" />
				<button type="submit" class="woocommerce-Button button btn btn-primary" value="<?php esc_attr_e( 'Save', 'cartzilla' ); ?>"><?php esc_html_e( 'Save', 'cartzilla' ); ?></button>

				<?php wp_nonce_field( 'reset_password', 'woocommerce-reset-password-nonce' ); ?>

			</form>
		</div>
	</div>
</div>
<?php
do_action( 'woocommerce_after_reset_password_form' );

