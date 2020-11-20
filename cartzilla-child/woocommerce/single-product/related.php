<?php
/**
 * Related Products
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/related.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see         https://docs.woocommerce.com/document/template-structure/
 * @package     WooCommerce/Templates
 * @version     3.9.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( $related_products && 'yes' === get_theme_mod( 'enable_related_products', 'yes' ) ) : 
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
		$container_additional_class=" py-5 my-md-3";
		$title_additional_class = " text-center pb-4";
	}

?>

	<section class="related products<?php echo cartzilla_get_single_product_style() === 'style-v4' ? ' pb-5 mb-2 mb-xl-4' : '';?>">
		<div class="<?php echo cartzilla_get_single_product_style() !== 'style-v4' ? 'container' : 'container-fluid';?><?php echo esc_attr( $container_additional_class );?>">

			<?php
			$heading = apply_filters( 'woocommerce_product_related_products_heading', esc_html__( 'Related products', 'cartzilla' ) );


			if ( $heading ) : 
				if ( cartzilla_get_single_product_style() === 'style-v3' ) { ?>
					<div class="d-flex flex-wrap justify-content-between align-items-center border-bottom pb-4 mb-4">
				<?php } ?>

				<h2 class="h3<?php echo esc_attr( $title_additional_class );?>"><?php echo esc_html( $heading ); ?></h2>
				
				<?php if ( cartzilla_get_single_product_style() === 'style-v3' ) { ?>
					</div>
				<?php } ?>

			<?php endif; 

			if ( cartzilla_get_single_product_style() === 'style-v4' ) {
			 	$dots = true;
			 	$slidesToShow = 5;
			} else {
				$dots= false;
				$slidesToShow = 4;
			}

			$defaults = apply_filters( 'cartzilla_related_products_carousel_args', array(
	            
	            'carousel_args'     => array(
	                'slidesToShow'   => apply_filters( 'cartzilla_related_products_slide_count', $slidesToShow ),
	                'slidesToScroll' => 1,
	                'infinite'       => false,
	                'autoplay'       => false,
	                'arrows'         => true,
	                'dots'           => apply_filters( 'cartzilla_related_products_dots', $dots ),
	                'responsive'        => array(
	                    array(
	                        'breakpoint'    => 0,
	                        'settings'      => array(
	                            'slidesToShow'      => 1,
	                            'slidesToScroll'    => 1
	                        )
	                    ),
	                    array(
	                        'breakpoint'    => 576,
	                        'settings'      => array(
	                            'slidesToShow'      => 1,
	                            'slidesToScroll'    => 1
	                        )
	                    ),
	                    array(
	                        'breakpoint'    => 768,
	                        'settings'      => array(
	                            'slidesToShow'      => 2,
	                            'slidesToScroll'    => 2
	                        )
	                    ),
	                    array(
	                        'breakpoint'    => 992,
	                        'settings'      => array(
	                            'slidesToShow'      => 3,
	                            'slidesToScroll'    => 3
	                        )
	                    ),
	                    array(
	                        'breakpoint'    => 1200,
	                        'settings'      => array(
	                            'slidesToShow'      => 4,
	                            'slidesToScroll'    => 4
	                        )
	                    )
	                ),
	            )
	        ) );

	        $args = wp_parse_args( $args, $defaults );

	        if( is_rtl() ) {
	            $args['carousel_args']['rtl'] = true;
	            if( isset( $args['carousel_args']['prevArrow'] ) && isset( $args['carousel_args']['nextArrow'] ) ) {
	                $carousel_args_temp_arrow = $args['carousel_args']['prevArrow'];
	                $args['carousel_args']['prevArrow'] = $args['carousel_args']['nextArrow'];
	                $args['carousel_args']['nextArrow'] = $carousel_args_temp_arrow;
	            }
	        }

            ?>
            <div class="products-carousel-wrap related-product-carousel" data-ride="ct-slick-carousel" data-wrap=".products" data-slick="<?php echo esc_attr( json_encode( $args['carousel_args'] ), ENT_QUOTES, 'UTF-8' ); ?>">
				<?php woocommerce_product_loop_start(); ?>
				
					<?php foreach ( $related_products as $related_product ) : ?>

							<?php
							$post_object = get_post( $related_product->get_id() );

							setup_postdata( $GLOBALS['post'] =& $post_object ); // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited, Squiz.PHP.DisallowMultipleAssignments.Found

							wc_get_template_part( 'content', 'product' );
							?>

					<?php endforeach; ?>
				
				<?php woocommerce_product_loop_end(); ?>
			</div>
		</div>
	</section>
	<?php
endif;

wp_reset_postdata();
