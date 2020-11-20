<?php
/**
 * Login Form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/form-login.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 4.1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

do_action( 'woocommerce_before_customer_login_form' ); ?>

<div class="<?php echo cartzilla_get_shop_page_style() !== 'style-v3' ? 'container' : 'container-fluid';?> pt-5 bt-2 pb-5 mb-2 mb-md-4" id="customer_login">
	<div class="row">
		<div class="col-md-6 mx-md-auto">
			<div class="card border-0 box-shadow">
				<div class="card-body">
					<h2 class="h4 mb-3"><?php esc_html_e( 'Login', 'cartzilla' ); ?></h2>

					<form class="woocommerce-form woocommerce-form-login login" method="post">

						<?php do_action( 'woocommerce_login_form_start' ); ?>

						<div class="woocommerce-form-row woocommerce-form-row--wide form-group">
							<label for="username"><?php esc_html_e( 'Username or email address', 'cartzilla' ); ?><span class="text-danger">*</span></label>
							<input type="text" class="woocommerce-Input woocommerce-Input--text input-text form-control" name="username" id="username" autocomplete="username" value="<?php echo ( ! empty( $_POST['username'] ) ) ? esc_attr( wp_unslash( $_POST['username'] ) ) : ''; ?>" /><?php // @codingStandardsIgnoreLine ?>
						</div>
						<div class="woocommerce-form-row woocommerce-form-row--wide form-group">
							<label for="password"><?php esc_html_e( 'Password', 'cartzilla' ); ?><span class="text-danger">*</span></label>
							<div class="password-toggle">
								<input class="woocommerce-Input woocommerce-Input--text input-text form-control" type="password" name="password" id="password" autocomplete="current-password" />
								<label class="password-toggle-btn">
									<input class="custom-control-input" type="checkbox">
									<i class="czi-eye password-toggle-indicator"></i>
									<span class="sr-only"><?php echo esc_html_x( 'Show password', 'front-end', 'cartzilla' ); ?></span>
								</label>
							</div>
						</div>

						<?php do_action( 'woocommerce_login_form' ); ?>

						<div class="form-group d-flex flex-wrap justify-content-between mb-0">
							<div class="custom-control custom-checkbox mb-2">
								<input class="woocommerce-form__input woocommerce-form__input-checkbox custom-control-input" name="rememberme" type="checkbox" id="rememberme" value="forever" />
								<label class="woocommerce-form__label woocommerce-form__label-for-checkbox woocommerce-form-login__rememberme custom-control-label" for="rememberme"><?php esc_html_e( 'Remember me', 'cartzilla' ); ?></label>
							</div>
							<div class="woocommerce-LostPassword lost_password">
								<a class="font-size-sm" href="<?php echo esc_url( wp_lostpassword_url() ); ?>"><?php esc_html_e( 'Lost your password?', 'cartzilla' ); ?></a>
							</div>
						</div>

						<hr class="mt-4">
	                	<div class="text-right pt-4">
							<button type="submit" class="woocommerce-button button woocommerce-form-login__submit btn btn-primary" name="login" value="<?php esc_attr_e( 'Log in', 'cartzilla' ); ?>"><i class="<?php echo esc_attr( apply_filters( 'front_login_form_button_icon', 'czi-sign-in' ) ); ?> mr-2 ml-n21"></i><?php esc_html_e( 'Log in', 'cartzilla' ); ?></button>
						</div>

						<?php do_action( 'woocommerce_login_form_end' ); ?>

						<?php wp_nonce_field( 'woocommerce-login', 'woocommerce-login-nonce' ); ?>
					</form>
				</div>
			</div>
		</div>
		
		<?php if ( 'yes' === get_option( 'woocommerce_enable_myaccount_registration' ) ) : ?>
			<div class="col-md-6 pt-4 mt-3 mt-md-0">
				<h2 class="h4 mb-3"><?php esc_html_e( 'Register', 'cartzilla' ); ?></h2>

				<form method="post" class="woocommerce-form woocommerce-form-register register" <?php do_action( 'woocommerce_register_form_tag' ); ?> >

					<?php do_action( 'woocommerce_register_form_start' ); ?>

					<?php if ( 'no' === get_option( 'woocommerce_registration_generate_username' ) ) : ?>

						<div class="woocommerce-form-row woocommerce-form-row--wide form-group">
							<label for="reg_username"><?php esc_html_e( 'Username', 'cartzilla' ); ?><span class="text-danger">*</span></label>
							<input type="text" class="woocommerce-Input woocommerce-Input--text input-text form-control" name="username" id="reg_username" autocomplete="username" value="<?php echo ( ! empty( $_POST['username'] ) ) ? esc_attr( wp_unslash( $_POST['username'] ) ) : ''; ?>" /><?php // @codingStandardsIgnoreLine ?>
						</div>

					<?php endif; ?>

					<div class="woocommerce-form-row woocommerce-form-row--wide form-group">
						<label for="reg_email"><?php esc_html_e( 'Email address', 'cartzilla' ); ?><span class="text-danger">*</span></label>
						<input type="email" class="woocommerce-Input woocommerce-Input--text input-text form-control" name="email" id="reg_email" autocomplete="email" value="<?php echo ( ! empty( $_POST['email'] ) ) ? esc_attr( wp_unslash( $_POST['email'] ) ) : ''; ?>" /><?php // @codingStandardsIgnoreLine ?>
					</div>

					<?php if ( 'no' === get_option( 'woocommerce_registration_generate_password' ) ) : ?>

						<div class="woocommerce-form-row woocommerce-form-row--wide form-group">
							<label for="reg_password"><?php esc_html_e( 'Password', 'cartzilla' ); ?><span class="text-danger">*</span></label>
							<div class="password-toggle">
								<input type="password" class="woocommerce-Input woocommerce-Input--text input-text form-control" name="password" id="reg_password" autocomplete="new-password" />
								<label class="password-toggle-btn">
									<input class="custom-control-input" type="checkbox">
									<i class="czi-eye password-toggle-indicator"></i>
									<span class="sr-only"><?php echo esc_html_x( 'Show password', 'front-end', 'cartzilla' ); ?></span>
								</label>
							</div>
						</div>

					<?php else : ?>

						<p class="font-size-sm text-muted"><?php esc_html_e( 'A password will be sent to your email address.', 'cartzilla' ); ?></p>

					<?php endif; ?>

					<?php do_action( 'woocommerce_register_form' ); ?>

	            	<div class="text-right">
						<button type="submit" class="woocommerce-Button woocommerce-button button woocommerce-form-register__submit btn btn-primary" name="register" value="<?php esc_attr_e( 'Register', 'cartzilla' ); ?>"><i class="<?php echo esc_attr( apply_filters( 'front_registration_form_button_icon', 'czi-user' ) ); ?> mr-2 ml-n1"></i><?php esc_html_e( 'Register', 'cartzilla' ); ?></button>


					</div>

					<?php do_action( 'woocommerce_register_form_end' ); ?>

					<?php wp_nonce_field( 'woocommerce-register', 'woocommerce-register-nonce' ); ?>
				</form>
			</div>
		<?php endif; ?>
	</div>
</div>

<?php do_action( 'woocommerce_after_customer_login_form' );
