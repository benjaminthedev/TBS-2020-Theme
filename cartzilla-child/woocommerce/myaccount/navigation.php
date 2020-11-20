<?php
/**
 * My Account navigation
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/navigation.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 2.6.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

do_action( 'woocommerce_before_account_navigation' );

$default_icons = [
	'dashboard' => 'czi-home',
	'orders' => 'czi-bag',
	'downloads' => 'czi-cloud-download',
	'edit-address' => 'czi-location',
	'edit-account' => 'czi-user',
	'payment-methods' => 'czi-card',
	'customer-logout' => 'czi-sign-out',
];

?>

<nav class="woocommerce-MyAccount-navigation">
	<ul class="list-unstyled mb-0">
		<?php foreach ( wc_get_account_menu_items() as $endpoint => $label ) :
			$default_icon = isset( $default_icons[$endpoint] ) ? $default_icons[$endpoint] : '';
			$icon_class = get_theme_mod( "cartzilla_wc_endpoint_{$endpoint}_icon", $default_icon );
			if ( $endpoint === 'customer-logout' ) : ?>
				<li class="<?php echo wc_get_account_menu_item_classes( $endpoint ); ?> border-top d-lg-none mb-0">
					<a href="<?php echo esc_url( wc_get_account_endpoint_url( $endpoint ) ); ?>" class="nav-link-style d-block px-4 py-3">
						<?php if( ! empty( $icon_class ) ) : ?>
							<i class="<?php echo esc_attr( $icon_class ); ?> align-middle opacity-60 mr-2"></i>
						<?php endif; ?>
						<?php echo esc_html( $label ); ?>
					</a>
				</li>
			<?php else : ?>
				<li class="<?php echo wc_get_account_menu_item_classes( $endpoint ); ?> border-top mb-0">
					<a href="<?php echo esc_url( wc_get_account_endpoint_url( $endpoint ) ); ?>" class="nav-link-style d-flex align-items-center px-4 py-3">
						<?php if( ! empty( $icon_class ) ) : ?>
							<i class="<?php echo esc_attr( $icon_class ); ?> align-middle opacity-60 mr-2"></i>
						<?php endif; ?>
						<?php echo esc_html( $label ); ?>
						<?php if( $endpoint === 'orders' ) : ?>
							<span class="font-size-sm text-muted ml-auto"><?php cartzilla_wc_account_orders_count(); ?></span>
						<?php elseif( $endpoint === 'downloads' ) : ?>
							<span class="font-size-sm text-muted ml-auto"><?php is_a( WC()->customer, 'WC_Customer' ) ? cartzilla_wc_account_downloads_count() : 0; ?></span>
						<?php endif; ?>
					</a>
				</li>
			<?php endif; ?>
		<?php endforeach; ?>
	</ul>
</nav>

<?php do_action( 'woocommerce_after_account_navigation' ); ?>
