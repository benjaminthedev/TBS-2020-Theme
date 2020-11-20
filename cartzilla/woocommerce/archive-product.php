<?php
/**
 * The Template for displaying product archives, including the main shop page which is a post type archive
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/archive-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.4.0
 */

defined( 'ABSPATH' ) || exit;

get_header( 'shop' );

/**
 * Hook: woocommerce_before_main_content.
 *
 * @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content)
 * @hooked woocommerce_breadcrumb - 20
 * @hooked WC_Structured_Data::generate_website_data() - 30
 */
do_action( 'woocommerce_before_main_content' );
$shop_sidebar = cartzilla_wc_products_sidebar();

$page_title_wrap_class='';
$container_additional_class='';

$_cz_is_filters_active = cartzilla_is_active_sidebars( [
	'shop-filters-column-1',
	'shop-filters-column-2',
	'shop-filters-column-3',
] );

if ( $_cz_is_filters_active && cartzilla_enable_cz_filters() ) {
	$page_title_wrap_class = ' pt-4 pb-5';
	$container_additional_class = 'pt-2 pb-3 pt-lg-3 pb-lg-4';
} else {
	$page_title_wrap_class = ' page-title-overlap pt-4';
	$container_additional_class = 'd-lg-flex justify-content-between py-2 py-lg-3';
}

if ( cartzilla_get_shop_page_style() == 'style-v2' ) { ?>
	<div class="<?php echo cartzilla_wc_catalog_type() ===  'dark'  ? 'bg-accent' : 'bg-secondary'; ?> pt-4 pb-5">
	    <div class="container pt-2 pb-3 pt-lg-3 pb-lg-4">
	        <div class="d-lg-flex justify-content-between pb-3">
		        <div class="order-lg-2 mb-3 mb-lg-0 pt-lg-2">
		            <?php if ( apply_filters( 'woocommerce_show_breadcrumb', true ) ): 
					 	cartzilla_breadcrumbs(); 
					 endif; ?>
		        </div>

	          <div class="order-lg-1 pr-lg-4 text-center text-lg-left">
	          	<?php if ( apply_filters( 'woocommerce_show_page_title', true ) ) : ?>
					<h1 class="h3 <?php echo cartzilla_wc_catalog_type() ===  'dark'  ? 'text-light' : 'text-dark'; ?> mb-0"><?php woocommerce_page_title(); ?></h1>
				<?php endif; ?>
	          </div>
	        </div>
	    </div>
    </div>
<?php } elseif ( cartzilla_get_shop_page_style() == 'style-v1' ) { ?>
	<div class="<?php echo cartzilla_wc_catalog_type() ===  'dark'  ? 'bg-dark' : 'bg-secondary'; ?><?php echo esc_attr( $page_title_wrap_class ); ?>">
		<div class="container <?php echo esc_attr( $container_additional_class ); ?>">
			<?php if ( $_cz_is_filters_active && cartzilla_enable_cz_filters() ) { ?>
				<div class="d-lg-flex justify-content-between pb-3">
			<?php } ?>
					
				<div class="order-lg-2 mb-3 mb-lg-0 pt-lg-2">
					<?php if ( apply_filters( 'woocommerce_show_breadcrumb', true ) ): 
					 	cartzilla_breadcrumbs(); 
					 endif; ?>
				</div>
				<div class="order-lg-1 pr-lg-4 text-center text-lg-left">
					<?php if ( apply_filters( 'woocommerce_show_page_title', true ) ) : ?>
						<h1 class="h3 mb-0 <?php echo cartzilla_wc_catalog_type() ===  'dark'  ? 'text-light' : 'text-dark'; ?>"><?php woocommerce_page_title(); ?></h1>
					<?php endif; ?>
				</div>
			<?php if ( $_cz_is_filters_active && cartzilla_enable_cz_filters() ) { ?>
				</div>
			<?php } ?>
		</div>
	</div><?php
} ?>


<div class="<?php echo cartzilla_get_shop_page_style() !== 'style-v3' ? 'container pb-5 mb-2 mb-md-4' : 'container-fluid p-0';?>">

	<?php if ( cartzilla_get_shop_page_style() == 'style-v1' && $_cz_is_filters_active && cartzilla_enable_cz_filters() ) : ?>
    	<div class="bg-light box-shadow-lg rounded-lg p-4 mt-n5 mb-4">
        	<div class="d-flex justify-content-between align-items-center">
				<div class="dropdown mr-2">
					<?php if ( $_cz_is_filters_active ) : ?>
						<a class="btn btn-outline-secondary dropdown-toggle" href="#cz-shop-filters" data-toggle="collapse">
							<i class="czi-filter mr-2"></i>
							<?php echo esc_html__( 'Filters', 'cartzilla' ); ?>
						</a>
					<?php endif; ?>
				</div>
				<div class="d-flex">
					<?php cartzilla_wc_products_navigation_dark();?>
				</div>
				<div class="d-none d-sm-flex">
					<?php cartzilla_wc_products_views_dark(); ?>
				</div>
			</div>
		
			<div class="collapse" id="cz-shop-filters">
				<div class="row pt-4">
					<?php if ( is_active_sidebar( 'shop-filters-column-1' ) ) : ?>
						<div class="col-lg-4 col-sm-6">
							<?php dynamic_sidebar( 'shop-filters-column-1' ); ?>
						</div>
					<?php endif; ?>
					<?php if ( is_active_sidebar( 'shop-filters-column-2' ) ) : ?>
						<div class="col-lg-4 col-sm-6">
							<?php dynamic_sidebar( 'shop-filters-column-2' ); ?>
						</div>
					<?php endif; ?>
					<?php if ( is_active_sidebar( 'shop-filters-column-3' ) ) : ?>
						<div class="col-lg-4 col-sm-6">
							<?php dynamic_sidebar( 'shop-filters-column-3' ); ?>
						</div>
					<?php endif; ?>
				</div>
			</div>
			
		</div>
	<?php endif; ?>
		
	<?php if ( cartzilla_shop_has_sidebar() ) : ?>

		<div class="row">
			<?php
			$content_area_classes = 'content-area col-lg-8';
			$shop_layout   = cartzilla_wc_products_sidebar();
			if ( $shop_layout === 'left-sidebar' ) {
			    $content_area_classes .= ' order-lg-2';
			}
			?>
			<div class="<?php echo esc_attr( $content_area_classes ); ?>">
	<?php else : ?>

	    	<div class="content-area">
	<?php endif; ?>
				
			<?php
				if ( woocommerce_product_loop() ) {

					/**
					 * Hook: woocommerce_before_shop_loop.
					 *
					 * @hooked woocommerce_output_all_notices - 10
					 * @hooked woocommerce_result_count - 20
					 * @hooked woocommerce_catalog_ordering - 30
					 */
					do_action( 'woocommerce_before_shop_loop' );

					woocommerce_product_loop_start();

					if ( wc_get_loop_prop( 'total' ) ) {
						$products_count = 0;
						while ( have_posts() ) {
							the_post();

							/**
							 * Hook: woocommerce_shop_loop.
							 *
							 * @hooked WC_Structured_Data::generate_product_data() - 10
							 */
							do_action( 'woocommerce_shop_loop' );
							if ( is_shop() && cartzilla_get_shop_page_style() == 'style-v1' ) {
								 
								$current      = (int) wc_get_loop_prop( 'current_page' );
								$columns      = apply_filters('cartzilla_catalog_columns', get_option( 'woocommerce_catalog_columns',wc_get_loop_prop( 'columns' ) ) );
								$rows         = absint( get_option( 'woocommerce_catalog_rows',  4 ) );
								$middle       = ( $rows * $columns ) / 2 - ( ( $rows * $columns ) / 2 ) % $columns ;

								if ( $current == 1 && intval($middle) == $products_count ) {
                                	cartzilla_archive_middle_jumbotron();
								}
                            	
                            }
							wc_get_template_part( 'content', 'product' );

							$products_count++;
							
						}
					}

					woocommerce_product_loop_end();

					/**
					 * Hook: woocommerce_after_shop_loop.
					 *
					 * @hooked woocommerce_pagination - 10
					 */
					do_action( 'woocommerce_after_shop_loop' );
				} else {
					/**
					 * Hook: woocommerce_no_products_found.
					 *
					 * @hooked wc_no_products_found - 10
					 */
					do_action( 'woocommerce_no_products_found' );
				}

				/**
				 * Hook: woocommerce_after_main_content.
				 *
				 * @hooked woocommerce_output_content_wrapper_end - 10 (outputs closing divs for the content)
				 */
				do_action( 'woocommerce_after_main_content' ); ?>
				<?php if ( cartzilla_shop_has_sidebar() ) : ?>
	    
	        </div>
			<?php
			/**
			 * Hook: woocommerce_sidebar.
			 *
			 * @hooked woocommerce_get_sidebar - 10
			 */
			do_action( 'woocommerce_sidebar' );  ?>

		</div>
	<?php else : ?>
    
    </div>
    
    <?php endif; ?>
</div>

<?php do_action( 'cartzilla_archive_main_content_after' ); ?>
<?php
get_footer( 'shop' );