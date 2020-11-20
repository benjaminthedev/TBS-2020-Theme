<?php
/**
 * Edit account form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/form-edit-account.php.
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

defined( 'ABSPATH' ) || exit; ?>

<div class="d-none d-lg-flex justify-content-between align-items-center pt-lg-3 pb-4 pb-lg-5 mb-lg-3">
	<h6 class="font-size-base <?php echo cartzilla_wc_catalog_type() ===  'dark'  ? 'text-light' : 'text-dark'; ?> mb-0"><?php echo esc_html_x( 'Update you profile details below:', 'front-end', 'cartzilla' ); ?></h6>
	<a class="btn btn-primary btn-sm" href="<?php echo esc_url( wc_logout_url() ); ?>">
		<i class="czi-sign-out mr-2"></i>
		<?php echo esc_html_x( 'Logout', 'front-end', 'cartzilla' ); ?>
	</a>
</div>

<?php do_action( 'woocommerce_before_edit_account_form' ); ?>

<form class="woocommerce-EditAccountForm edit-account" action="" method="post" <?php do_action( 'woocommerce_edit_account_form_tag' ); ?> >

	<?php do_action( 'woocommerce_edit_account_form_start' ); ?>

	<div class="cartzilla-pp-wrap bg-secondary rounded-lg p-4 mb-4">
		<div class="media align-items-center">
			<?php
			require_once(ABSPATH . "wp-admin" . '/includes/image.php');
			require_once(ABSPATH . "wp-admin" . '/includes/file.php');
			require_once(ABSPATH . "wp-admin" . '/includes/media.php');
			wp_enqueue_media();

			$gravatar_id = ! empty( get_user_meta( $user->ID, '_cartzilla_custom_avatar_id', true ) ) ? get_user_meta( $user->ID, '_cartzilla_custom_avatar_id', true ) : 0;
			?>
			<?php echo get_avatar( $user, 90, '', esc_html( $user->display_name ) ); ?>
			<div class="media-body pl-3">
				<a href="#" class="cartzilla-pp-add-change btn btn-light btn-shadow btn-sm mb-2">
					<i class="czi-loading mr-2"></i>
					<?php echo esc_html_x( 'Change profile picture', 'front-end', 'cartzilla' ); ?>
				</a>
				<a href="#" class="cartzilla-pp-remove btn btn-light btn-shadow btn-sm mb-2<?php echo esc_attr( $gravatar_id ? '' : ' d-none' ); ?>">
					<i class="czi-close mr-2"></i>
					<?php echo esc_html_x( 'Remove', 'front-end', 'cartzilla' ); ?>
				</a>
				<div class="p mb-0 font-size-ms text-muted"><?php echo esc_html_x( 'Upload JPG, GIF or PNG image.', 'front-end', 'cartzilla' ); ?></div>
				<input type="hidden" name="cartzilla_custom_avatar_id" class="cartzilla-pp-file-field" value="<?php echo esc_attr( $gravatar_id ); ?>">
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col-sm-6">
			<div class="woocommerce-form-row woocommerce-form-row--first form-group">
				<label for="account_first_name"><?php esc_html_e( 'First name', 'cartzilla' ); ?><span class="text-danger">*</span></label>
				<input type="text" class="woocommerce-Input woocommerce-Input--text input-text form-control" name="account_first_name" id="account_first_name" autocomplete="given-name" value="<?php echo esc_attr( $user->first_name ); ?>" />
			</div>
		</div>
		<div class="col-sm-6">
			<div class="woocommerce-form-row woocommerce-form-row--last form-group">
				<label for="account_last_name"><?php esc_html_e( 'Last name', 'cartzilla' ); ?><span class="text-danger">*</span></label>
				<input type="text" class="woocommerce-Input woocommerce-Input--text input-text form-control" name="account_last_name" id="account_last_name" autocomplete="family-name" value="<?php echo esc_attr( $user->last_name ); ?>" />
			</div>
		</div>
	</div>

	<div class="woocommerce-form-row woocommerce-form-row--wide form-group">
		<label for="account_display_name"><?php esc_html_e( 'Display name', 'cartzilla' ); ?><span class="text-danger">*</span></label>
		<input type="text" class="woocommerce-Input woocommerce-Input--text input-text form-control" name="account_display_name" id="account_display_name" value="<?php echo esc_attr( $user->display_name ); ?>" />
		<small class="form-text text-muted"><?php esc_html_e( 'This will be how your name will be displayed in the account section and in reviews', 'cartzilla' ); ?></small>
	</div>

	<div class="woocommerce-form-row woocommerce-form-row--wide form-group">
		<label for="account_email"><?php esc_html_e( 'Email address', 'cartzilla' ); ?><span class="text-danger">*</span></label>
		<input type="email" class="woocommerce-Input woocommerce-Input--email input-text form-control" name="account_email" id="account_email" autocomplete="email" value="<?php echo esc_attr( $user->user_email ); ?>" />
	</div>

	<div class="woocommerce-form-row woocommerce-form-row--wide form-group">
		<label for="password_current"><?php echo esc_html_x( 'Current password', 'front-end', 'cartzilla' ); ?></label>
		<div class="password-toggle">
			<input type="password" class="woocommerce-Input woocommerce-Input--password input-text form-control" name="password_current" id="password_current" autocomplete="off" />
			<label class="password-toggle-btn">
				<input class="custom-control-input" type="checkbox">
				<i class="czi-eye password-toggle-indicator"></i>
				<span class="sr-only"><?php echo esc_html_x( 'Show password', 'front-end', 'cartzilla' ); ?></span>
			</label>
		</div>
		<small class="form-text text-muted"><?php echo esc_html_x( 'Leave blank to leave unchanged', 'front-end', 'cartzilla' ); ?></small>
	</div>
	<div class="woocommerce-form-row woocommerce-form-row--wide form-group">
		<label for="password_1"><?php echo esc_html_x( 'New password', 'front-end', 'cartzilla' ); ?></label>
		<div class="password-toggle">
			<input type="password" class="woocommerce-Input woocommerce-Input--password input-text form-control" name="password_1" id="password_1" autocomplete="off" />
			<label class="password-toggle-btn">
				<input class="custom-control-input" type="checkbox">
				<i class="czi-eye password-toggle-indicator"></i>
				<span class="sr-only"><?php echo esc_html_x( 'Show password', 'front-end', 'cartzilla' ); ?></span>
			</label>
		</div>
		<small class="form-text text-muted"><?php echo esc_html_x( 'Leave blank to leave unchanged', 'front-end', 'cartzilla' ); ?></small>
	</div>
	<div class="woocommerce-form-row woocommerce-form-row--wide form-group">
		<label for="password_2"><?php esc_html_e( 'Confirm new password', 'cartzilla' ); ?></label>
		<div class="password-toggle">
			<input type="password" class="woocommerce-Input woocommerce-Input--password input-text form-control" name="password_2" id="password_2" autocomplete="off" />
			<label class="password-toggle-btn">
				<input class="custom-control-input" type="checkbox">
				<i class="czi-eye password-toggle-indicator"></i>
				<span class="sr-only"><?php echo esc_html_x( 'Show password', 'front-end', 'cartzilla' ); ?></span>
			</label>
		</div>
	</div>

	<?php do_action( 'woocommerce_edit_account_form' ); ?>

	<button type="submit" class="woocommerce-Button button btn btn-primary" name="save_account_details" value="<?php esc_attr_e( 'Save changes', 'cartzilla' ); ?>"><?php esc_html_e( 'Save changes', 'cartzilla' ); ?></button>
	<input type="hidden" name="action" value="save_account_details" />
	<?php wp_nonce_field( 'save_account_details', 'save-account-details-nonce' ); ?>

	<?php do_action( 'woocommerce_edit_account_form_end' ); ?>

</form>

<?php do_action( 'woocommerce_after_edit_account_form' ); ?>
