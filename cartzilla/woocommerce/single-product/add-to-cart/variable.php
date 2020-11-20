<?php
/**
 * Variable product add to cart
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/add-to-cart/variable.php.
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

global $product;

$attribute_keys  = array_keys( $attributes );
$variations_json = wp_json_encode( $available_variations );
$variations_attr = function_exists( 'wc_esc_json' ) ? wc_esc_json( $variations_json ) : _wp_specialchars( $variations_json, ENT_QUOTES, 'UTF-8', true );

do_action( 'woocommerce_before_add_to_cart_form' ); ?>

<form class="variations_form cart" action="<?php echo esc_url( apply_filters( 'woocommerce_add_to_cart_form_action', $product->get_permalink() ) ); ?>" method="post" enctype='multipart/form-data' data-product_id="<?php echo absint( $product->get_id() ); ?>" data-product_variations="<?php echo ! empty( $variations_attr ) ? $variations_attr : ''; // WPCS: XSS ok. ?>">
	<?php do_action( 'woocommerce_before_variations_form' ); ?>

	<?php if ( empty( $available_variations ) && false !== $available_variations ) : ?>
		<p class="stock out-of-stock text-muted font-size-sm"><?php echo apply_filters( 'woocommerce_out_of_stock_message', esc_html__( 'This product is currently out of stock and unavailable.', 'cartzilla' ) ); ?></p>
	<?php else : ?>
		<div class="variations">
			<?php foreach ( $attributes as $attribute_name => $options ) : ?>
				<?php $attr_id = sanitize_title( $attribute_name ) . '-' . uniqid(); ?>
				<div class="form-group">
					<div class="label"><label class="font-weight-medium" for="<?php echo esc_attr( $attr_id ); ?>"><?php echo wc_attribute_label( $attribute_name ); // WPCS: XSS ok. ?></label></div>
					<div class="value">
						<?php
						wc_dropdown_variation_attribute_options( array(
							'options'   => $options,
							'attribute' => $attribute_name,
							'product'   => $product,
							'class'     => 'custom-select',
							'id'        => $attr_id,
						) );
						echo end( $attribute_keys ) === $attribute_name ? wp_kses_post( apply_filters( 'woocommerce_reset_variations_link', '<a class="reset_variations" href="#">' . esc_html__( 'Clear', 'cartzilla' ) . '</a>' ) ) : '';
						?>
					</div>
				</div>
			<?php endforeach; ?>
		</div>

		<?php if( cartzilla_is_wc_single_product_variations_radio_style() ) {
			$variations = $product->get_available_variations();
			if( ! empty( $variations ) ) {
				$id_attr = 'product-' . $product->get_id() . '-all-variations';
				echo '<div class="variations-radio-style accordion" id="' . esc_attr( $id_attr ) . '">';
				foreach ( $variations as $key => $variation ) {

					$variation_attributes_name = array();
					$variation_attributes = array();
					$is_selected = false;

					foreach ( $variation['attributes'] as $key => $value ) {
						$taxonomy = str_replace( 'attribute_', '', $key );
						$term = get_term_by( 'slug', $value, $taxonomy );
						$variation_attributes_name[] = isset( $term->name ) ? $term->name : $value;
						$variation_attributes[] = array(
							'attribute_name' => $key,
							'attribute_value' => $value
						);

						// Get selected value.
						$selected = isset( $_REQUEST[ $key ] ) ? wc_clean( wp_unslash( $_REQUEST[ $key ] ) ) : $product->get_variation_default_attribute( $taxonomy );
						$is_selected = $selected == $value ? true : false;
					}

					$variation_name = implode( ', ', $variation_attributes_name );
					?>
					<div class="card border-left-0 border-right-0">
						<div class="card-header d-flex justify-content-between align-items-center py-3 border-0">
							<div class="custom-control custom-radio" data-attributes="<?php echo htmlspecialchars( json_encode( $variation_attributes ), ENT_QUOTES, 'UTF-8' ); ?>">
								<input class="custom-control-input" type="radio" name="<?php echo esc_attr( $id_attr ); ?>" id="<?php echo esc_attr( 'variation-' . $variation['variation_id'] ); ?>"<?php if( $is_selected ) { echo ' checked="checked"'; } ?>>
								<label class="custom-control-label font-weight-medium text-dark" for="<?php echo esc_attr( 'variation-' . $variation['variation_id'] ); ?>" data-toggle="collapse" data-target="#<?php echo esc_attr( 'variation-' . $variation['variation_id'] . '-collapse' ); ?>"><?php echo wp_kses_post($variation_name ); ?></label>
							</div>
							<h5 class="mb-0 text-accent font-weight-normal"><?php echo wp_kses_post( $variation['price_html'] ); ?></h5>
						</div>
						<div class="collapse <?php if( $is_selected ) { echo ' show'; } ?>" id="<?php echo esc_attr( 'variation-' . $variation['variation_id'] . '-collapse' ); ?>" data-parent="#<?php echo esc_attr( $id_attr ); ?>">
							<div class="card-body py-0 pb-2">
								<?php echo wp_kses_post( $variation['variation_description'] ); ?>
							</div>
						</div>
					</div>
					<?php
				}
				echo '</div>';
			}
		} ?>

		<div class="single_variation_wrap">
			<?php
				/**
				 * Hook: woocommerce_before_single_variation.
				 */
				do_action( 'woocommerce_before_single_variation' );

				/**
				 * Hook: woocommerce_single_variation. Used to output the cart button and placeholder for variation data.
				 *
				 * @since 2.4.0
				 * @hooked woocommerce_single_variation - 10 Empty div for variation data.
				 * @hooked woocommerce_single_variation_add_to_cart_button - 20 Qty and cart button.
				 */
				do_action( 'woocommerce_single_variation' );

				/**
				 * Hook: woocommerce_after_single_variation.
				 */
				do_action( 'woocommerce_after_single_variation' );
			?>
		</div>
	<?php endif; ?>

	<?php do_action( 'woocommerce_after_variations_form' ); ?>
</form>
<?php
do_action( 'woocommerce_after_add_to_cart_form' );
