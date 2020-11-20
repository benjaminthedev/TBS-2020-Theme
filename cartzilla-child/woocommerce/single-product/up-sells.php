<?php
/**
 * Single Product Up-Sells
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/up-sells.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	    https://docs.woocommerce.com/document/template-structure/
 * @package 	WooCommerce/Templates
 * @version     3.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( $upsells ) : 
	$container_additional_class="";
	if ( cartzilla_get_single_product_style() === 'style-v4' ) {
		$container_additional_class="";
		$title_additional_class = " h3 pb-2 mb-grid-gutter text-center";
	} elseif ( cartzilla_get_single_product_style() === 'style-v3' ) {
		$container_additional_class=" mb-4 pb-lg-3";
		$title_additional_class = " mb-0 pt-2";
	} elseif ( cartzilla_get_single_product_style() === 'style-v2' ) {
		$container_additional_class=" pt-lg-2 pb-5 mb-md-3";
		$title_additional_class = " text-center pb-4 pt-5";
	} else {
		$container_additional_class=" pt-5";
		$title_additional_class = " text-center pb-4";
	}
	?>

	<section class="up-sells upsells products">
		<div class="<?php echo cartzilla_get_single_product_style() !== 'style-v4' ? 'container' : 'container-fluid';?><?php echo esc_attr( $container_additional_class );?>">

			<?php if ( cartzilla_get_single_product_style() === 'style-v3' ) { ?>
				<div class="d-flex flex-wrap justify-content-between align-items-center border-bottom pb-4 mb-4">
			<?php } ?>
			<h2 class="h3<?php echo esc_attr( $title_additional_class );?>"><?php esc_html_e( 'You may also like&hellip;', 'cartzilla' ); ?></h2>

			<?php if ( cartzilla_get_single_product_style() === 'style-v3' ) { ?>
				</div>
			<?php } ?>

			<?php woocommerce_product_loop_start(); ?>

				<?php foreach ( $upsells as $upsell ) : ?>

					<?php
						$post_object = get_post( $upsell->get_id() );

						setup_postdata( $GLOBALS['post'] =& $post_object );

						wc_get_template_part( 'content', 'product' ); ?>

				<?php endforeach; ?>

			<?php woocommerce_product_loop_end(); ?>
		</div>
	</section>

<?php endif;

wp_reset_postdata();
