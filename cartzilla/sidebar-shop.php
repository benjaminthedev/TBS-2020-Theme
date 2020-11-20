<?php
/**
 * The sidebar containing the shop sidebar widget area.
 *
 * @package cartzilla
 */

if ( ! is_active_sidebar( 'sidebar-shop' ) ) {
    return;
}

$sidebar_class = 'shop-sidebar col-lg-4';
$sidebar_inner_class ='';

$_cz_is_filters_active = cartzilla_is_active_sidebars( [
	'shop-filters-column-1',
	'shop-filters-column-2',
	'shop-filters-column-3',
] );

$shop_sidebar = cartzilla_wc_products_sidebar();
if ( $_cz_is_filters_active && cartzilla_enable_cz_filters() ) {
	$sidebar_inner_class = 'cz-sidebar-static pt-4';
	if ( $shop_sidebar === 'right-sidebar') {
		$sidebar_inner_class .=' ml-auto';
	} 
} else {
	$sidebar_inner_class = 'cz-sidebar rounded-lg box-shadow-lg';

	if ( $shop_sidebar === 'right-sidebar') {
		$sidebar_inner_class .=' ml-lg-auto';
	} 
}

?>

<div id="secondary" class="<?php echo esc_attr( $sidebar_class ); ?>" role="complementary">
	<div class="<?php echo esc_attr( $sidebar_inner_class ); ?>" id="shop-sidebar">
		<?php if ( $shop_sidebar === 'left-sidebar' || $shop_sidebar === 'right-sidebar' ) { ?>
		    <div class="cz-sidebar-header box-shadow-sm">
				<button class="close ml-auto" type="button" data-dismiss="sidebar" aria-label="<?php
				/* translators: close shop sidebar (on mobile) aria-label */
				echo esc_attr_x( 'Close', 'front-end', 'cartzilla' ); ?>">
					<span class="d-inline-block font-size-xs font-weight-normal align-middle">
						<?php echo esc_html_x( 'Close sidebar', 'front-end', 'cartzilla' ); ?>
					</span>
					<span class="d-inline-block align-middle ml-2" aria-hidden="true">&times;</span>
				</button>
			</div>
		<?php } ?>
		<div class="cz-sidebar-body" data-simplebar data-simplebar-auto-hide="true">
		    <?php dynamic_sidebar( 'sidebar-shop' ); ?>
		</div>
	</div>
</div><!-- #secondary -->
