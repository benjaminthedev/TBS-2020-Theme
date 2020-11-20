<?php
/**
 * My Account Dashboard
 *
 * Shows the first intro screen on the account dashboard.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/dashboard.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see         https://docs.woocommerce.com/document/template-structure/
 * @package     WooCommerce/Templates
 * @version     4.4.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

?>
<div class="d-flex justify-content-between align-items-center pt-lg-2 pb-4 pb-lg-5 mb-lg-3">
	<h6 class="font-size-base <?php echo cartzilla_wc_catalog_type() ===  'dark'  ? 'text-light' : 'text-dark'; ?> mb-0"><?php
		/* translators: 1: current username */
		echo sprintf( esc_html_x( 'Hello, %s', 'front-end', 'cartzilla' ), esc_html( $current_user->display_name ) );
	?></h6>
	<a class="btn btn-primary btn-sm d-none d-lg-inline-block" href="<?php echo esc_url( wc_logout_url() ); ?>">
		<i class="czi-sign-out mr-2"></i>
		<?php echo esc_html_x( 'Logout', 'front-end', 'cartzilla' ); ?>
	</a>
</div>
<div class="card text-center py-4 mb-4">
	<div class="card-body">
		<i class="czi-home text-muted h2 font-weight-normal opacity-60 mb-4"></i>
		<h5 class="pb-2"><?php echo esc_html_x( 'From your account dashboard you can:', 'front-end', 'cartzilla' ); ?></h5>
		<a href="<?php echo esc_url( wc_get_endpoint_url( 'orders' ));?>" class="btn btn-outline-primary btn-sm m-2"><?php echo esc_html_x( 'View orders', 'front-end', 'cartzilla' ); ?></a>
		<a href="<?php echo esc_url(wc_get_endpoint_url( 'edit-address'));?>" class="btn btn-outline-primary btn-sm m-2"><?php echo esc_html_x( 'Manage addresses', 'front-end', 'cartzilla' ); ?></a>
		<a href="<?php echo esc_url( wc_get_endpoint_url( 'edit-account' ));?>" class="btn btn-outline-primary btn-sm m-2"><?php echo esc_html_x( 'Edit account details', 'front-end', 'cartzilla' ); ?></a>
	</div>
</div>

<?php
/**
 * My Account dashboard.
 *
 * @since 2.6.0
 */
do_action( 'woocommerce_account_dashboard' );

/**
 * Deprecated woocommerce_before_my_account action.
 *
 * @deprecated 2.6.0
 */
do_action( 'woocommerce_before_my_account' );

/**
 * Deprecated woocommerce_after_my_account action.
 *
 * @deprecated 2.6.0
 */
do_action( 'woocommerce_after_my_account' );

/* Omit closing PHP tag at the end of PHP files to avoid "headers already sent" issues. */
