<?php
/**
 * Product Quick view
 *
 * @author 		Transvelo
 * @package 	Cartzilla/Templates
 * @version     1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

?>
<?php
	$args = array(
		'post_type' => 'product',
		'post__in' 	=> array( $id ),
	);

	$products = new WP_Query( $args );
?>
<?php if ( $products->have_posts() ) : ?>
<?php while ( $products->have_posts() ) : $products->the_post(); ?>
<div class="modal-header">
	<h4 class="modal-title product-title"><a data-toggle="tooltip" data-placement="right" data-original-title="<?php esc_html_e( "Go to product page", 'cartzilla' ); ?>" href="<?php echo esc_url( apply_filters( 'woocommerce_loop_product_link', get_the_permalink(), $product ) ); ?>"><?php the_title(); ?><?php echo apply_filters( 'cartzilla_shop_quick_view_title_icon', '<i class="czi-arrow-right font-size-lg ml-2"></i>' ); ?></a></h4>
	<button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
</div>

<div class="modal-body">
	<div class="row">
		<div class="col-lg-7 pr-lg-0">
			<?php woocommerce_show_product_images(); ?>
		</div>
 
		<div class="col-lg-5 pt-4 pt-lg-0 cz-image-zoom-pane"> <?php
			cartzilla_quick_view_product_rating_wishlist();
			cartzilla_wc_product_price_labels();
			woocommerce_template_single_add_to_cart();
			cartzilla_wc_product_excerpt(); ?>
			
		</div>
	</div>
</div>
<?php endwhile; ?>
<?php endif; ?>
<?php wp_reset_postdata(); ?>