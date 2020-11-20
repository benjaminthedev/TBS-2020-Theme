<?php
/**
 * Lost password form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/form-lost-password.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.5.2
 */

defined( 'ABSPATH' ) || exit;

do_action( 'woocommerce_before_lost_password_form' );
?>
<div class="container py-4 py-lg-5 my-4">
	<div class="row justify-content-center">
		<div class="col-lg-8 col-md-10">
			<form method="post" class="woocommerce-ResetPassword lost_reset_password">

				<h2 class="h3 mb-4"><?php echo esc_html_x( 'Lost your password?', 'front-end', 'cartzilla' ); ?></h2>
				<p class="font-size-md"><?php echo esc_html_x( 'Change your password following instructions below. This helps to keep your new password secure.', 'front-end', 'cartzilla' ); ?></p>
				<ol class="list-unstyled font-size-md">
					<li>
						<span class="text-primary mr-2">1.</span>
						<?php echo esc_html_x( 'Please enter your username or email address.', 'front-end', 'cartzilla' ); ?>
					</li>
					<li>
						<span class="text-primary mr-2">2.</span>
						<?php echo esc_html_x( 'You will receive a link to create a new password via email.', 'front-end', 'cartzilla' ); ?>
					</li>
				</ol>

				<div class="card py-2 mt-4">
					<div class="card-body">
						<div class="form-group">
							<label for="user_login"><?php esc_html_e( 'Username or email', 'cartzilla' ); ?></label>
							<input class="woocommerce-Input woocommerce-Input--text input-text form-control" type="text" name="user_login" id="user_login" autocomplete="username" />
						</div>
		
						<?php do_action( 'woocommerce_lostpassword_form' ); ?>
		
						<input type="hidden" name="wc_reset_password" value="true" />
						<button type="submit" class="woocommerce-Button button btn btn-primary" value="<?php esc_attr_e( 'Reset password', 'cartzilla' ); ?>"><?php esc_html_e( 'Reset password', 'cartzilla' ); ?></button>
		
						<?php wp_nonce_field( 'lost_password', 'woocommerce-lost-password-nonce' ); ?>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>
<?php
do_action( 'woocommerce_after_lost_password_form' );
