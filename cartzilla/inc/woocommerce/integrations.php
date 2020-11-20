<?php
/**
 * WooCommerce Third Party Plugin Compatibility
 *
 * @package cartzilla
 */

/**
 * Integrate plugin "YITH WooCommerce Wishlist" into the theme. 
 */

if ( cartzilla_is_yith_wcwl_activated() ) {

	global $yith_wcwl;

	/**
	 * Add provider for wishlist functionality.
	 */
	if( ! function_exists( 'cartzilla_wishlist_provider_yith' ) ){
		function cartzilla_wishlist_provider_yith() {
			return 'yith';
		}
	}

	add_filter('cartzilla_wishlist_provider','cartzilla_wishlist_provider_yith' );

	// Dequeue YITH styles.
	add_action( 'wp_print_styles', 'cartzilla_yith_wcwl_dequeue_styles', 20 );

	if( ! function_exists( 'cartzilla_yith_wcwl_dequeue_styles' ) ){
		function cartzilla_yith_wcwl_dequeue_styles() {
			wp_dequeue_style( 'yith-wcwl-main' );
		}
	}

	/**
	 * Output the "Add to Wishlist" button.
	 */
	function cartzilla_add_to_wishlist_button() {
		echo do_shortcode( "[yith_wcwl_add_to_wishlist]" );
	}

	add_action('cartzilla_add_to_wishlist_yith', 'cartzilla_add_to_wishlist_button');

	if( property_exists( $yith_wcwl, 'wcwl_init' ) ) {
		remove_action( 'wp_enqueue_scripts', array( $yith_wcwl->wcwl_init, 'enqueue_styles_and_stuffs' ) );
	}

	if( ! function_exists( 'cartzilla_get_wishlist_page_id' ) ){
		/**
		 * Gets the page ID of wishlist page
		 *
		 * @return int
		 */
		function cartzilla_get_wishlist_page_id() {
			$wishlist_page_id = yith_wcwl_object_id( get_option( 'yith_wcwl_wishlist_page_id' ) );
			return $wishlist_page_id;
		}
	}

	if( ! function_exists( 'cartzilla_is_wishlist_page' ) ) {
		/**
		 * Conditional tag to determine if a page is a wishlist page or not
		 *
		 * @return boolean
		 */
		function cartzilla_is_wishlist_page() {
			$wishlist_page_id = cartzilla_get_wishlist_page_id();
			return is_page( $wishlist_page_id );
		}
	}

	if( ! function_exists( 'cartzilla_get_wishlist_url') ) {
		/**
		 * Returns URL of wishlist page
		 *
		 * @return string
		 */
		function cartzilla_get_wishlist_url(){
			$wishlist_page_id = cartzilla_get_wishlist_page_id();
			return get_permalink( $wishlist_page_id );
		}
	}

	if( ! function_exists( 'cartzilla_yith_wcwl_ajax_update_count' ) ){
		function cartzilla_yith_wcwl_ajax_update_count(){
			wp_send_json( array(
				'count' => yith_wcwl_count_all_products()
			) );
		}
		add_action( 'wp_ajax_yith_wcwl_update_wishlist_count', 'cartzilla_yith_wcwl_ajax_update_count' );
		add_action( 'wp_ajax_nopriv_yith_wcwl_update_wishlist_count', 'cartzilla_yith_wcwl_ajax_update_count' );
	}

	/**
	 * Add link to wishlist page inside the handheld toolbar
	 */
	add_action( 'cartzilla_handheld_toolbar', function() {
		$page = get_option( 'yith_wcwl_wishlist_page_id' );
		if ( empty( $page ) ) {
			return;
		}

		?>
		<a href="<?php echo esc_url( get_permalink( $page ) ); ?>" class="d-table-cell cz-handheld-toolbar-item">
			<span class="cz-handheld-toolbar-icon">
				<i class="czi-heart"></i>
				<?php if ( apply_filters( 'cartzilla_handheld_toolbar_show_wishlist_count', true ) ) : ?>
					<span class="badge badge-primary badge-pill yith_wcwl_count">
						<?php echo yith_wcwl_count_products(); ?>
					</span>
				<?php endif; ?>
			</span>
			<span class="cz-handheld-toolbar-label"><?php echo esc_html_x( 'Wishlist', 'front-end', 'cartzilla' ); ?></span>
		</a>
		<?php
	}, 40 );
}

/**
 * Integrate plugin "YITH WooCommerce Compare" into the theme. 
 */

if( cartzilla_is_yith_woocompare_activated() ) {

	global $yith_woocompare;

	/**
	 * Add provider for compare functionality.
	 */
	if( ! function_exists( 'cartzilla_compare_provider_yith' ) ){
		function cartzilla_compare_provider_yith() {
			return 'yith';
		}
	}

	add_filter('cartzilla_compare_provider','cartzilla_compare_provider_yith' );


	remove_action( 'woocommerce_single_product_summary', array( $yith_woocompare->obj , 'add_compare_link' ), 35 );
	remove_action( 'woocommerce_after_shop_loop_item', array( $yith_woocompare->obj, 'add_compare_link' ), 20 );


	function cartzilla_add_compare_url_to_localize_data( $data ) {
		$data[ 'compare_page_url' ] = cartzilla_get_compare_page_url();
		return $data;
	}

	add_filter( 'cartzilla_localize_script_data', 'cartzilla_add_compare_url_to_localize_data' );

	function cartzilla_add_to_compare_link() {
		
		global $product, $yith_woocompare;
		$product_id = $product->get_id();

        $button_text = get_option( 'yith_woocompare_button_text', esc_html__( 'Compare', 'cartzilla' ) );
        $button_text = function_exists( 'icl_translate' ) ? icl_translate( 'Plugins', 'plugin_yit_compare_button_text', $button_text ) : $button_text;

        if( ! is_admin() ) {
        	echo apply_filters( 'cartzilla_add_to_compare_link', sprintf( 
				'<a href="%s" class="%s" data-product_id="%d">%s</a>', 
				$yith_woocompare->obj->add_product_url( $product_id ),
				'btn btn-secondary add-to-compare-link',
				$product_id,
				$button_text
			) );
        }
	}
	
	function cartzilla_update_yith_compare_options( $options ) {
		
		foreach( $options['general'] as $key => $option ) {
			
			if( $option['id'] == 'yith_woocompare_auto_open' ) {
				$options['general'][$key]['std'] = 'no';
				$options['general'][$key]['default'] = 'no';
			}
		
		}
		
		return $options;
	}
	
	add_filter( 'yith_woocompare_general_settings', 'cartzilla_update_yith_compare_options' );

	if( ! function_exists( 'cartzilla_get_compare_page_id' ) ) {
		/**
		 * Gets page ID of product comparision page
		 *
		 * @return int
		 */
		function cartzilla_get_compare_page_id() {
			$compare_page_id = apply_filters( 'cartzilla_product_comparison_page_id', get_theme_mod('compare_page_id', 0) );
			
			if( 0 !== $compare_page_id && function_exists( 'icl_object_id' ) ) {
				$compare_page_id = icl_object_id( $compare_page_id, 'page' );
			}

			return $compare_page_id;
		}
	}

	if( ! function_exists( 'cartzilla_get_compare_page_url' ) ) {
		/**
		 * Returns URL of Product Comparision Page
		 *
		 * @return string
		 */
		function cartzilla_get_compare_page_url() {
			$compare_page_id = cartzilla_get_compare_page_id();
			$compare_page_url = '#';

			if( 0 !== $compare_page_id ) {
				$compare_page_url = get_permalink( $compare_page_id );
			}

			return $compare_page_url;
		}
	}
}



/**
 * Integrate plugin "MAS WooCommerce Variation Swatches" into the theme. 
 */

if( cartzilla_is_mas_wcvs_activated() ) {

    if( ! function_exists( 'cartzilla_mas_wcvs_loop_variation' ) ) {
        function cartzilla_mas_wcvs_loop_variation() {

            global $product;

             if ( apply_filters( 'mas_wcvs_loop_variation_enable', true ) && $product->is_type( 'variable' ) ) {
                remove_action( 'woocommerce_single_variation', 'woocommerce_single_variation_add_to_cart_button', 20 );
                woocommerce_variable_add_to_cart();
                add_action( 'woocommerce_single_variation', 'woocommerce_single_variation_add_to_cart_button', 20 );
            }
        }
    }

    remove_action( 'woocommerce_after_shop_loop_item', 'mas_wcvs_loop_variation', 6 );

    add_action( 'woocommerce_after_shop_loop_item_title', 'cartzilla_mas_wcvs_loop_variation', 40 );
    add_action( 'woocommerce_after_shop_loop_item', 'cartzilla_mas_wcvs_loop_variation', 130 );
    
   
    add_action( 'wp_enqueue_scripts', 'mas_wcvs_enqueue_style' );

    function mas_wcvs_enqueue_style() {
        wp_enqueue_style( 'mas-wcvs-style' );
    }
}