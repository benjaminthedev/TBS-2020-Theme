<?php
/**
 * Edit address form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/form-edit-address.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.6.0
 */

defined( 'ABSPATH' ) || exit;

$page_title = ( 'billing' === $load_address ) ? esc_html__( 'Billing address', 'cartzilla' ) : esc_html__( 'Shipping address', 'cartzilla' );

do_action( 'woocommerce_before_edit_account_address_form' ); ?>

<?php if ( ! $load_address ) : ?>
	<?php wc_get_template( 'myaccount/my-address.php' ); ?>
<?php else : ?>
	<div class="d-none d-lg-flex justify-content-between align-items-center pt-lg-3 pb-4 pb-lg-5 mb-lg-4">
		<h6 class="font-size-base <?php echo cartzilla_wc_catalog_type() ===  'dark'  ? 'text-light' : 'text-dark'; ?> mb-0"><?php echo apply_filters( 'woocommerce_my_account_edit_address_title', $page_title, $load_address ); // @codingStandardsIgnoreLine ?></h6>
		<a class="btn btn-primary btn-sm" href="<?php echo esc_url( wc_logout_url() ); ?>">
			<i class="czi-sign-out mr-2"></i>
			<?php echo esc_html_x( 'Logout', 'front-end', 'cartzilla' ); ?>
		</a>
	</div>

	<form method="post">

		<div class="woocommerce-address-fields">

			<?php do_action( "woocommerce_before_edit_address_form_{$load_address}" ); ?>

			<div class="woocommerce-address-fields__field-wrapper row">
				<?php
				foreach ( $address as $key => $field ) {
					woocommerce_form_field( $key, $field, wc_get_post_data_by_key( $key, $field['value'] ) );
				}
				?>
			</div>

			<?php do_action( "woocommerce_after_edit_address_form_{$load_address}" ); ?>

		</div>

		<button type="submit" class="btn btn-primary" name="save_address" value="<?php esc_attr_e( 'Save address', 'cartzilla' ); ?>"><?php esc_html_e( 'Save address', 'cartzilla' ); ?></button>

		<input type="hidden" name="action" value="edit_address" />
		<?php wp_nonce_field( 'woocommerce-edit_address', 'woocommerce-edit-address-nonce' ); ?>
	</form>

<?php endif; ?>

<?php do_action( 'woocommerce_after_edit_account_address_form' ); ?>
