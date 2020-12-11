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

// Change Checkout Fields

add_filter( 'woocommerce_checkout_fields', 'billing_email_first' );
 
function billing_email_first( $checkout_fields ) {
	$checkout_fields['billing']['billing_email']['priority'] = 4;
	$checkout_fields['billing']['billing_company']['priority'] = 50;
	$checkout_fields['billing']['billing_phone']['priority'] = 30;
	$checkout_fields['shipping']['shipping_company']['priority'] = 50;
	return $checkout_fields;
}

// Hook in
add_filter( 'woocommerce_checkout_fields' , 'custom_override_checkout_fields' );

// Our hooked in function - $fields is passed via the filter!
function custom_override_checkout_fields( $fields ) {
	 $fields['billing']['billing_email']['placeholder'] = 'Email Address*';
	 $fields['billing']['billing_first_name']['placeholder'] = 'First Name*';
	 $fields['billing']['billing_last_name']['placeholder'] = 'Last Name*';
	 $fields['billing']['billing_phone']['placeholder'] = 'Contact Number*';
	 $fields['billing']['billing_company']['placeholder'] = 'Company Name';
	 $fields['billing']['billing_address_1']['placeholder'] = 'Address Line 1*';
	 $fields['billing']['billing_address_2']['placeholder'] = 'Address Line 2';
	 $fields['billing']['billing_city']['placeholder'] = 'Town/City*';
	 $fields['billing']['billing_postcode']['placeholder'] = 'Postcode*';
	 $fields['shipping']['shipping_first_name']['placeholder'] = 'First Name*';
	 $fields['shipping']['shipping_last_name']['placeholder'] = 'Last Name*';
	 $fields['shipping']['shipping_company']['placeholder'] = 'Company Name';
	 $fields['shipping']['shipping_address_1']['placeholder'] = 'Address Line 1*';
	 $fields['shipping']['shipping_address_2']['placeholder'] = 'Address Line 2';
	 $fields['shipping']['shipping_city']['placeholder'] = 'Town/City*';
	 $fields['shipping']['shipping_postcode']['placeholder'] = 'Postcode*';
     return $fields;
}
// WooCommerce Checkout Fields Hook
add_filter('woocommerce_checkout_fields','custom_wc_checkout_fields_no_label');

// Our hooked in function - $fields is passed via the filter!
// Action: remove label from $fields
function custom_wc_checkout_fields_no_label($fields) {
    // loop by category
    foreach ($fields as $category => $value) {
        // loop by fields
        foreach ($fields[$category] as $field => $property) {
            // remove label property
            unset($fields[$category][$field]['label']);
        }
    }
     return $fields;
}
// hide coupon field on checkout page
function hide_coupon_field_on_checkout( $enabled ) {
	if ( is_checkout() ) {
		$enabled = false;
	}
	return $enabled;
}
add_filter( 'woocommerce_coupons_enabled', 'hide_coupon_field_on_checkout' );

// Defer Transactional Emails

add_filter( 'woocommerce_defer_transactional_emails', '__return_true' );
add_action('woocommerce_order_status_changed', 'send_custom_email_notifications', 10, 4 );
function send_custom_email_notifications( $order_id, $old_status, $new_status, $order ){
    if ( $new_status == 'cancelled' || $new_status == 'failed' ){
        $wc_emails = WC()->mailer()->get_emails(); // Get all WC_emails objects instances
        $customer_email = $order->get_billing_email(); // The customer email
    }

    if ( $new_status == 'cancelled' ) {
        // change the recipient of this instance
        $wc_emails['WC_Email_Cancelled_Order']->recipient = $customer_email;
        // Sending the email from this instance
        $wc_emails['WC_Email_Cancelled_Order']->trigger( $order_id );
    } 
    elseif ( $new_status == 'failed' ) {
        // change the recipient of this instance
        $wc_emails['WC_Email_Failed_Order']->recipient = $customer_email;
        // Sending the email from this instance
        $wc_emails['WC_Email_Failed_Order']->trigger( $order_id );
    } 
}

//hide the Payment Request button on the single Product page

add_filter( 'wc_stripe_hide_payment_request_on_product_page', '__return_true' );

// show the Payment Request button on the Checkout page

add_filter( 'wc_stripe_show_payment_request_on_checkout', '__return_true' );

//remove cart notices from checkout page

function sv_remove_cart_notice_on_checkout() {
	if ( function_exists( 'wc_cart_notices' ) ) {
		remove_action( 'woocommerce_before_checkout_form', array( wc_cart_notices(), 'add_cart_notice' ) );
	}
}
add_action( 'init', 'sv_remove_cart_notice_on_checkout' );

// Add Google Tag Manager code in <head>
add_action( 'wp_head', 'google_tag_manager_head' );
function google_tag_manager_head() { ?>
	
    <!-- Google Tag Manager -->
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','GTM-5DRH468');</script>
<!-- End Google Tag Manager -->

<?php }


// Add Google Tag Manager code immediately below opening <body> tag
add_action( 'google_tag_manager_before', 'google_tag_manager_body' );
function google_tag_manager_body() { ?>
	
<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-5DRH468"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->

<?php }

// Add Google Customer Reviews Badge
add_action( 'google_customer_reviews_before', 'customer_review_badge' );
function customer_review_badge(){?>
<script src="https://apis.google.com/js/platform.js" async defer></script>
<?php }

// Data Layer for Tag Manager
function push_to_datalayer($order_id){
    $order = wc_get_order( $order_id );
?>
<script type='text/javascript'>
    window.dataLayer = window.dataLayer || [];
             dataLayer.push({
                 'event' : 'transaction',
                 'ecommerce' : {
                     'purchase' : {
                         'actionField' : {
                             'id': '<?php echo $order->get_order_number(); ?>',
                             'affiliation': '<?php echo get_option("blogname"); ?>',
							 'date': '<?php echo $order->get_date_created(); ?>',
							 'currency': '<?php echo $order->get_currency(); ?>',
                             'revenue' : '<?php echo number_format($order->get_subtotal(), 2, ".", ""); ?>', 
                             'tax': '<?php echo number_format($order->get_total_tax(), 2 ,".", ""); ?>',
                             'shipping': '<?php echo number_format($order->calculate_shipping(), 2 , ".", ""); ?>',
                             <?php if($order->get_used_coupons()) : ?>
                              'coupon' : '<?php echo implode("-", $order->get_used_coupons()); ?>'
                             <?php endif; ?>
                         }
                         }
 
                     }
                 });
    </script>
 
<?php
}
add_action('woocommerce_thankyou' , 'push_to_datalayer');

// Add Product Subtitle

add_action( 'woocommerce_single_product_summary', 'product_subtitle', 6 );
function product_subtitle() {
            $subtitle = get_field('product_subtitle');

            if( $subtitle ) : echo '<p>' . $subtitle . '</p>'; endif; 
}

// Add Sales Count

remove_action( 'woocommerce_single_product_summary', 'cartzilla_product_sold_count' );
add_action( 'woocommerce_single_product_summary', 'product_sold_count', 30 );
function product_sold_count() {
    global $product;
       $units_sold = $product->get_total_sales();
       if ( $units_sold > 0 ) {
        ?>
            <div class="bg-secondary rounded p-3 mb-2">
                <?php echo apply_filters( 'cartzilla_sold_count_icon_icon', '<i class="fab fa-gripfire h5 text-muted align-middle mb-0 mt-n1 mr-2"></i>' ); ?>
                <span class="d-inline-block h6 mb-0 mr-1"><?php echo esc_attr( $units_sold ); ?></span><span class="font-size-sm"><?php echo esc_html( sprintf( _nx( 'Sold', 'Sold', $units_sold, 'front-end', 'cartzilla' ), $units_sold ) ); ?></span>
           </div><?php
        }
    }

// Add Cost Price to Google Product Feed 
function lw_woocommerce_gpf_custom_field_list( $list ) {
    // Register the _my_custom_field meta field as a pre-population option.
    $list['meta:_alg_wc_cog_cost'] = 'Cost of Goods Sold';
    return $list;
}
add_filter( 'woocommerce_gpf_custom_field_list', 'lw_woocommerce_gpf_custom_field_list' );

// Removes product category(ies) in the product loop

if ( ! function_exists( 'cartzilla_wc_loop_product_category' ) ) {
    function cartzilla_wc_loop_product_category() {
}
}

// Remove handheld sidebar option in Product page 

if( ! function_exists( 'cartzilla_handheld_toolbar_toggle_blog_sidebar' ) ) {
    function cartzilla_handheld_toolbar_toggle_blog_sidebar() {
        if ( ( is_home() || is_singular( 'post' ) || ( 'post' == get_post_type() && ( is_category() || is_tag() || is_author() || is_date() || is_year() || is_month() || is_time() ) ) )
             && cartzilla_posts_sidebar() !== 'no-sidebar'
        ) : ?>
            <a href="#blog-sidebar" data-toggle="sidebar" class="d-table-cell cz-handheld-toolbar-item">
                <div class="cz-handheld-toolbar-icon">
                    <i class="czi-sign-in"></i>
                </div>
                <span class="cz-handheld-toolbar-label"><?php echo esc_html_x( 'Sidebar', 'front-end', 'cartzilla' ); ?></span>
            </a>
        <?php
        endif;
    }
}