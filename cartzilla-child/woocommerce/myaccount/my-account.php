<?php
/**
 * My Account page
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/my-account.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.5.0
 */

defined( 'ABSPATH' ) || exit;

?>
<div class="page-title-overlap <?php echo cartzilla_wc_catalog_type() ===  'dark'  ? ( cartzilla_get_shop_page_style() == 'style-v2' ? 'bg-accent' : 'bg-dark' ) : 'bg-secondary'; ?> pt-4">
	<div class="<?php echo cartzilla_get_shop_page_style() !== 'style-v3' ? 'container' : 'container-fluid';?> d-lg-flex justify-content-between py-2 py-lg-3">
		<div class="order-lg-2 mb-3 mb-lg-0 pt-lg-2">
			<?php cartzilla_breadcrumbs(); ?>
		</div>
		<div class="order-lg-1 pr-lg-4 text-center text-lg-left">
			<h1 class="h3 <?php echo cartzilla_wc_catalog_type() ===  'dark'  ? 'text-light' : 'text-dark'; ?> mb-0"><?php cartzilla_wc_account_title(); ?></h1>
		</div>
	</div>
</div>
<div class="<?php echo cartzilla_get_shop_page_style() !== 'style-v3' ? 'container' : 'container-fluid';?> pb-5 mb-2 mb-md-3">
	<div class="row">
		<aside class="col-lg-4 pt-4 pt-lg-0">
			<div class="cz-sidebar-static rounded-lg box-shadow-lg px-0 pb-0 mb-5 mb-lg-0">
				<div class="px-4 mb-4">
					<div class="media align-items-center">
						<div class="img-thumbnail rounded-circle position-relative" style="width: 6.375rem;">
							<?php echo get_avatar( $current_user, 90, '', esc_html( $current_user->display_name ), [ 'class' => 'rounded-circle' ] ); ?>
						</div>
						<div class="media-body pl-3">
							<h3 class="font-size-base mb-0"><?php echo esc_html( $current_user->display_name ); ?></h3>
							<span class="text-accent font-size-sm"><?php echo esc_html( $current_user->user_email ); ?></span>
						</div>
					</div>
				</div>
				<?php
				/**
				 * My Account navigation.
				 *
				 * @since 2.6.0
				 */
				do_action( 'woocommerce_account_navigation' );
				?>
			</div>
		</aside>
		<section class="col-lg-8">
			<div class="woocommerce-MyAccount-content">
				<?php
				/**
				 * My Account content.
				 *
				 * @since 2.6.0
				 */
				do_action( 'woocommerce_account_content' );
				?>
			</div>
		</section>
	</div>
</div>
