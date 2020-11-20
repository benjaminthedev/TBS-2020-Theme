<?php
/**
 * Cartzilla WooCommerce Customizer Class
 *
 * @package  cartzilla
 * @since    1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Cartzilla_WooCommerce_Customizer' ) ) :

	/**
	 * The Cartzilla Customizer class
	 */
	class Cartzilla_WooCommerce_Customizer extends Cartzilla_Customizer {

		/**
		 * Setup class.
		 *
		 * @since 1.0.0
		 * @return void
		 */
		public function __construct() {
			add_action( 'customize_register', array( $this, 'customize_woocommerce_page_title_background' ), 10 );
			add_action( 'customize_register', array( $this, 'customize_shop_register' ), 10 );
			add_action( 'customize_register', array( $this, 'customize_product_page_register' ), 10 );
			add_action( 'customize_register', array( $this, 'customize_wc_endpoint_icon_settings' ), 10 );
		}

		/**
		 * Add postMessage support for site title and description for the Theme Customizer along with several other settings.
		 *
		 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
		 * @since 1.0.0
		 */
		public function customize_woocommerce_page_title_background( $wp_customize ) {

			/**
			 * Woocommerce Page Title
			 */
			$wp_customize->add_section(
				'cartzilla_wc_title_bg', array(
					'title'       => esc_html__( 'WooCommerce Page Title Background', 'cartzilla' ),
					'description' => esc_html__( 'This setting applicable for your WooCommerce pages', 'cartzilla' ),
					'priority'    => 30,
					'panel'       => 'woocommerce',
				)
			);

			$wp_customize->add_setting(
				'cartzilla_catalog_type', array(
					'default'           => 'dark',
					'sanitize_callback' => 'sanitize_key',
					'transport'         => 'postMessage',
				)
			);


			$wp_customize->add_control(
				'cartzilla_catalog_type', array(
					'type'        => 'select',
					'section'     => 'cartzilla_wc_title_bg',
					/* translators: label field of control in Customizer */
					'label'       => esc_html__( 'Page Title Background Color', 'cartzilla' ),
					'description' => esc_html__( 'This setting allows you to choose your woocommerce page title background', 'cartzilla' ),
					'choices'     => [
						'light' => esc_html__( 'Light', 'cartzilla' ),
						'dark'  => esc_html__( 'Dark', 'cartzilla' ),
					],
					'priority'    => 10,
				)
			);

			$wp_customize->selective_refresh->add_partial( 'cartzilla_catalog_type', [
				'fallback_refresh'    => true
			] );
		}


		/**
		 * Add postMessage support for site title and description for the Theme Customizer along with several other settings.
		 *
		 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
		 * @since 1.0.0
		 */
		public function customize_shop_register( $wp_customize ) {

			/**
			 * Shop page
			 */

			$wp_customize->add_section(
				'cartzilla_shop', array(
					'title'       => esc_html__( 'Shop Page', 'cartzilla' ),
	                'description' => esc_html__( 'This section contains settings related to products listing and archives.', 'cartzilla' ),
	                'priority'    => 30,
	                'panel'       => 'woocommerce',
				)
			);

			$wp_customize->add_setting(
				'shop_page_style', array(
					'default'           => 'style-v1',
					'sanitize_callback' => 'sanitize_key',
					'transport'         => 'postMessage',
				)
			);

			$wp_customize->add_control(
				'shop_page_style', array(
					'type'        => 'select',
					'section'     => 'cartzilla_shop',
					'label'       => esc_html__( 'Shop Page Style', 'cartzilla' ),
					'description' => esc_html__( 'Select the style for shop page', 'cartzilla' ),
					'choices'     => [
						'style-v1'            => esc_html__( 'Woocommerce - Shop', 'cartzilla' ),
						'style-v2'            => esc_html__( 'MarketPlace - Shop', 'cartzilla' ),
						'style-v3'            => esc_html__( 'Grocery - Shop',     'cartzilla' ),
					],
					'priority'    => 10,
				)
			);

			$wp_customize->add_setting(
				'cartzilla_wc_jumbotron', array(
					'capability' => 'edit_theme_options',
  					'sanitize_callback' => 'absint',
				)
			);
			
			$wp_customize->add_control(
				'cartzilla_wc_jumbotron', array(
					'section'     => 'cartzilla_shop',
					'label'       => esc_html__( 'Shop Top Jumbotron', 'cartzilla' ),
					'description' => esc_html__( 'Choose a static block that will be the jumbotron element for shop page', 'cartzilla' ),
					'type'		  => 'select',
					'choices'     => static_content_options(),
					'active_callback' => function () {
	                    return in_array( get_theme_mod( 'shop_page_style' ), [ 'style-v1' ] 
                    	) && cartzilla_is_mas_static_content_activated();
	                }
				)
			);

			$wp_customize->add_setting(
				'cartzilla_wc_middle_jumbotron', array(
					'capability' => 'edit_theme_options',
  					'sanitize_callback' => 'absint',
				)
			);	

			$wp_customize->add_control(
				'cartzilla_wc_middle_jumbotron', array(
					'section'     => 'cartzilla_shop',
					'label'       => esc_html__( 'Shop Middle Jumbotron', 'cartzilla' ),
					'description' => esc_html__( 'Choose a static block that will be the middle jumbotron element for shop page', 'cartzilla' ),
					'type'		  => 'select',
					'choices'     => static_content_options(),
					'active_callback' => function () {
	                    return in_array(
                        	get_theme_mod( 'shop_page_style' ), [ 'style-v1' ] 
                    	) && cartzilla_is_mas_static_content_activated();
	                }
				)
			);
				

			$wp_customize->add_setting(
				'shop_sidebar', array(
					'default'           => 'left-sidebar',
					'sanitize_callback' => 'sanitize_key',
					'transport'         => 'postMessage',
				)
			);

			$wp_customize->add_control(
				'shop_sidebar', array(
					'type'        => 'select',
					'section'     => 'cartzilla_shop',
					/* translators: label field of control in Customizer */
					'label'       => esc_html__( 'Shop Sidebar', 'cartzilla' ),
					'description' => esc_html__( 'Select from the three sidebar layouts for shop', 'cartzilla' ),
					'choices'     => [
						'left-sidebar'	=> esc_html__( 'Left Sidebar', 'cartzilla' ),
						'right-sidebar'	=> esc_html__( 'Right Sidebar', 'cartzilla' ),
						'no-sidebar'	=> esc_html__( 'No Sidebar', 'cartzilla' ),
					],
					'priority'    => 10,
				)
			);

			$wp_customize->add_setting(
				'cartzilla_catalog_layout', array(
					'default'           => 'grid',
					'sanitize_callback' => 'sanitize_key',
					'transport'         => 'postMessage',
				)
			);

			$wp_customize->add_control(
				'cartzilla_catalog_layout', array(
					'type'        => 'select',
					'section'     => 'cartzilla_shop',
					'label'       => esc_html__( 'Shop Layout', 'cartzilla' ),
					'description' => esc_html__( 'Applicable for both shop page and category views.', 'cartzilla' ),
					'choices'     => [
						'grid'            => esc_html__( 'Grid', 'cartzilla' ),
						'list'            => esc_html__( 'List', 'cartzilla' ),
					],
					'priority'    => 20,
					'active_callback' => function () {
	                	return in_array( get_theme_mod( 'shop_page_style' ), [ 'style-v1' ] );
					} 
				)
			);

			$wp_customize->add_setting(
				'compare_page_id', array(
					'capability' => 'edit_theme_options',
  					'sanitize_callback' => 'sanitize_key',
				)
			);

			$wp_customize->add_control(
				'compare_page_id', array(
					'section'     => 'cartzilla_shop',
					'label'       => esc_html__( 'Shop Comparison Page', 'cartzilla' ),
					'description' => esc_html__( 'Choose a page that will be the product compare page for shop.', 'cartzilla' ),
					'type'		  => 'dropdown-pages',
					'active_callback' => function () {
	                	return in_array( get_theme_mod( 'shop_page_style' ), [ 'style-v1' ] );
					} 
				)
			);

			$wp_customize->selective_refresh->add_partial( 'shop_page_style', [
				'fallback_refresh'    => true
			] );

			$wp_customize->selective_refresh->add_partial( 'shop_sidebar', [
				'fallback_refresh'    => true
			] );

			$wp_customize->selective_refresh->add_partial( 'cartzilla_catalog_layout', [
				'fallback_refresh'    => true
			] );

		}

		/**
		 * Add postMessage support for site title and description for the Theme Customizer along with several other settings.
		 *
		 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
		 * @since 1.0.0
		 */
		public function customize_product_page_register( $wp_customize ) {

			/**
			 * Product Page
			 */
			$wp_customize->add_section(
				'cartzilla_product_page', array(
					'title'       => esc_html__( 'Product Page', 'cartzilla' ),
					'description' => esc_html__( 'This section contains settings related to single product page', 'cartzilla' ),
					'priority'    => 30,
					'panel'       => 'woocommerce',
				)
			);

			$wp_customize->add_setting(
				'product_style', array(
					'default'           => 'style-v1',
					'sanitize_callback' => 'sanitize_key',
					'transport'         => 'postMessage',
				)
			);

			$wp_customize->add_control(
				'product_style', array(
					'type'        => 'select',
					'section'     => 'cartzilla_product_page',
					'label'       => esc_html__( 'Single Product Style', 'cartzilla' ),
					'description' => esc_html__( 'Select the style for single product page', 'cartzilla' ),
					'choices'     => [
						'style-v1'            => esc_html__( 'Product Page v.1', 'cartzilla' ),
						'style-v2'            => esc_html__( 'Product Page v.2', 'cartzilla' ),
						'style-v3'            => esc_html__( 'Market Place Single Page', 'cartzilla' ),
						'style-v4'            => esc_html__( 'Grocery Single Page', 'cartzilla' ),
					],
					'priority'    => 10,
				)
			);

			$wp_customize->selective_refresh->add_partial( 'product_style', [
				'fallback_refresh'    => true
			] );

			$wp_customize->add_setting(
				'enable_related_products', array(
					'default'           => 'no',
					'sanitize_callback' => 'sanitize_key',
					'transport'         => 'postMessage',
				)
			);

			$wp_customize->add_control(
				'enable_related_products', array(
					'type'        => 'radio',
					'section'     => 'cartzilla_product_page',
					'label'       => esc_html__( 'Related Products', 'cartzilla' ),
					'description' => esc_html__( 'Enable / Disable Related Products in Product Page', 'cartzilla' ),
					'choices'     => [
						'yes' => esc_html__( 'Yes', 'cartzilla' ),
						'no'  => esc_html__( 'No', 'cartzilla' ),
					],
					'priority'    => 20,
				)
			);

			$wp_customize->selective_refresh->add_partial( 'enable_related_products', [
				'fallback_refresh'    => true
			] );
		}

		/**
		 * Add postMessage support for wc end point icons for the Theme Customizer along with several other settings.
		 *
		 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
		 * @since 1.0.0
		 */
		public function customize_wc_endpoint_icon_settings( $wp_customize ) {
			/**
			 * Endpoint Icon Settings
			 */
			$wp_customize->add_section(
				'cartzilla_wc_endpoint_icons', array(
					'title'       => esc_html__( 'WC Endpoint Icons Settings', 'cartzilla' ),
					'description' => esc_html__( 'This setting applicable for your WC Endpoint', 'cartzilla' ),
					'priority'    => 30,
					'panel'       => 'woocommerce',
				)
			);

			$default_icons = [
				'dashboard' => 'czi-home',
				'orders' => 'czi-bag',
				'downloads' => 'czi-cloud-download',
				'edit-address' => 'czi-location',
				'edit-account' => 'czi-user',
				'payment-methods' => 'czi-card',
				'customer-logout' => 'czi-sign-out',
			];

			$endpoints = wc_get_account_menu_items();

			if( class_exists( 'WC_Subscriptions' ) ) {
				ob_start();
				$wcs_query = new WCS_Query();
				ob_end_clean();
				$endpoints = $wcs_query->add_menu_items( $endpoints );
			}

			if( function_exists( 'affiliate_wp' ) ) {
				$affiliate_area_page = affwp_get_affiliate_area_page_id();

				if ( $affiliate_area_page ) {
					$title = apply_filters( 'affwp_woocommerce_affiliate_area_title', get_the_title( $affiliate_area_page ), $affiliate_area_page );
					$affiliate_area = array( 'affiliate-area' => $title );

					$last_link = array();

					if ( array_key_exists( 'customer-logout', $endpoints ) ) {
						$last_link = array_slice( $endpoints, count( $endpoints ) - 1, 1, true );
						array_pop( $endpoints );
					}
					$endpoints = array_merge( $endpoints, $affiliate_area, $last_link );
				}
			}

			foreach ( $endpoints as $endpoint => $label ) :
				$wp_customize->add_setting(
					"cartzilla_wc_endpoint_{$endpoint}_icon", array(
						'default'           => isset( $default_icons[$endpoint] ) ? $default_icons[$endpoint] : '',
						'sanitize_callback' => 'sanitize_key',
						'transport'         => 'postMessage',
					)
				);
				$wp_customize->add_control(
					"cartzilla_wc_endpoint_{$endpoint}_icon", array(
						'type'        => 'text',
						'section'     => 'cartzilla_wc_endpoint_icons',
						/* translators: label field of control in Customizer */
						'label'       => sprintf( esc_html__( '%s Icon Class', 'cartzilla' ), $label ),
						'description' => esc_html__( 'This setting allows you to choose your icon for woocommerce endpoints', 'cartzilla' ),
						'priority'    => 10,
					)
				);
				$wp_customize->selective_refresh->add_partial( "cartzilla_wc_endpoint_{$endpoint}_icon", [
					'fallback_refresh'    => true
				] );
			endforeach;
		}

	}

endif;

return new Cartzilla_WooCommerce_Customizer();