<?php
/**
 * Cartzilla Child
 *
 * @package cartzilla-child
 */

/**
 * Include all your custom code here
 */
/**
 * Add Additional tabs to WooCommerce products
 *
 */
 
	add_filter( 'woocommerce_product_tabs', 'woo_new_product_tab' );
	
	function woo_new_product_tab( $tabs ) {
	
		global $post;
		$product_how_to_use = get_post_meta( $post->ID, 'how_to_use', true );
		$product_ingredients    = get_post_meta( $post->ID, 'ingredients', true );
		$product_about_the_brand    = get_post_meta( $post->ID, 'about_the_brand', true );
	 
		if ( ! empty( $product_how_to_use ) ) {
		
			$tabs['how_to_use_tab'] = array(
				'title'    => __( 'How to Use', 'woocommerce' ),
				'priority' => 15,
				'callback' => 'woo_how_to_use_tab_content'
			);
			
		}
		
		if ( ! empty( $product_ingredients ) ) {
		
			$tabs['ingredients_tab'] = array(
				'title'    => __( 'Ingredients', 'woocommerce' ),
				'priority' => 16,
				'callback' => 'woo_ingredients_tab_content'
			);
			
			}
		
		if ( ! empty( $product_about_the_brand ) ) {
		
			$tabs['about_the_brand_tab'] = array(
				'title'    => __( 'About the Brand', 'woocommerce' ),
				'priority' => 16,
				'callback' => 'woo_about_the_brand_tab_content'
			);
			
		}
		
		return $tabs;
	 
	}
	
	function woo_how_to_use_tab_content() {
	
		echo get_field('how_to_use', $post_id);
			
		}
	 
	
	function woo_ingredients_tab_content() {
	
		echo get_field('ingredients', $post_id);
			
		}
	 

     function woo_about_the_brand_tab_content() {
	
		echo get_field('about_the_brand', $post_id);
			
	 }

// Switch off Refund and Restock by Default

add_action('admin_footer', 'uncheck_restock_refund_checkbox');
function uncheck_restock_refund_checkbox() {
	echo '<script>jQuery("#restock_refunded_items").prop("checked", false);</script>';
}

//assign user in guest order
add_action( 'woocommerce_new_order', 'action_woocommerce_new_order', 10, 1 );
function action_woocommerce_new_order( $order_id ) {
	$order = new WC_Order($order_id);
	$user = $order->get_user();
	
	if( !$user ){
		//guest order
		$userdata = get_user_by( 'email', $order->get_billing_email() );
		if(isset( $userdata->ID )){
			//registered
			update_post_meta($order_id, '_customer_user', $userdata->ID );
		}else{
			//Guest
		}
	}
}

// Move MSRP Price

add_action( 'init', function () {
	global $woocommerce_msrp_frontend;
	remove_action(
		'woocommerce_single_product_summary',
		[ $woocommerce_msrp_frontend, 'show_msrp' ],
		7
	);
	add_action(
		'woocommerce_single_product_summary',
		[ $woocommerce_msrp_frontend, 'show_msrp' ],
		13
	);
} );

// Remove Product Title

    function cartzilla_wc_product_title() {
        $style = cartzilla_get_single_product_style();

        if ( ! (bool) apply_filters( 'cartzilla_is_wc_product_title', true ) ) {
            return;
        }

        ?>
        <div class="page-title-overlap pt-4 <?php echo cartzilla_wc_catalog_type() ===  'dark'  ? ( cartzilla_get_single_product_style() === 'style-v3' ? 'bg-accent' : 'bg-dark' ) : 'bg-secondary'; ?>">
            <div class="container d-lg-flex justify-content-between py-2 py-lg-3">
                <div class="order-lg-2 mb-3 mb-lg-0 pt-lg-2">
                    <?php cartzilla_breadcrumbs(); ?>
                </div>
            </div>
        </div>
        <?php
    }
		
// Remove Product Description

    function cartzilla_wc_product_description() {
       // do nothing
    }

// Remove Reviews Tab

add_filter( 'woocommerce_product_tabs', 'remove_reviews_tab' );
 
function remove_reviews_tab( $tabs ) {
 
	unset( $tabs['reviews'] );
	return $tabs;
 
}

// Add Product Tabs

add_action( 'init', 'add_product_tabs');

function add_product_tabs() {
     add_action( 'woocommerce_after_single_product_summary',              'woocommerce_output_product_data_tabs', 10 );
};

// Change Product Title H1 Tag to H3

remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_title', 5 );
add_action( 'woocommerce_single_product_summary', 'sgl_template_single_title', 5 );
function sgl_template_single_title() {
    the_title( '<h3 class="product_title entry-title">', '</h3>' );
}
// Elasticpress Custom Field Weighting

function my_ep_weighting_configuration_for_search( $weight_config, $args ) {
	$post_type = (array) $args['post_type'];
	if ( in_array( 'post', $post_type, true ) ) {
		$weight_config['post']['meta:total_sales'] = array(
			'weight'  => 20,
			'enabled' => 1,
		);
	}
	return $weight_config;
}
add_filter( 'ep_weighting_configuration_for_search', 'my_ep_weighting_configuration_for_search', 10, 2 );

if ( ! function_exists( 'cartzilla_wc_product_images' ) ) {
    function cartzilla_wc_product_images() { 
    }
}