<?php
/**
 * The template for displaying product price filter widget.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-widget-price-filter.php
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.7.1
 */

defined( 'ABSPATH' ) || exit;

$currency_symbol = get_woocommerce_currency_symbol();

?>

<?php do_action( 'woocommerce_widget_price_filter_start', $args ); ?>

<div class="cz-range-slider"
     data-start-min="<?php echo esc_attr( $current_min_price ); ?>"
     data-start-max="<?php echo esc_attr( $current_max_price ); ?>"
     data-min="<?php echo esc_attr( $min_price ); ?>"
     data-max="<?php echo esc_attr( $max_price ); ?>"
     data-step="<?php echo esc_attr( $step ); ?>"
     data-currency-symbol="<?php echo esc_attr( $currency_symbol ); ?>"
>
	<div class="cz-range-slider-ui"></div>
	<form method="get" action="<?php echo esc_url( $form_action ); ?>">
		<div class="d-flex pb-1">
			<div class="w-50 pr-2 mr-2">
				<div class="input-group input-group-sm">
					<div class="input-group-prepend">
						<span class="input-group-text"><?php echo esc_html( $currency_symbol ); ?></span>
					</div>
					<input type="text" name="min_price" class="form-control cz-range-slider-value-min">
				</div>
			</div>
			<div class="w-50 pl-2">
				<div class="input-group input-group-sm">
					<div class="input-group-prepend">
						<span class="input-group-text"><?php echo esc_html( $currency_symbol ); ?></span>
					</div>
					<input type="text" name="max_price" class="form-control cz-range-slider-value-max">
				</div>
			</div>
		</div>
		<?php wc_query_string_form_fields( null, array( 'min_price', 'max_price', 'paged' ), '', true ); ?>
	</form>
</div>

<?php do_action( 'woocommerce_widget_price_filter_end', $args );
