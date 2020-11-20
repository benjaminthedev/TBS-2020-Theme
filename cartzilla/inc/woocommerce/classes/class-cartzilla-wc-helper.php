<?php
/**
 * Cartzilla Helper Class for WooCommerce
 */

class Cartzilla_WC_Helper {

    public static function init() {
        add_action( 'wp_ajax_woocommerce_json_search_simple_products',  array( 'Cartzilla_WC_Helper', 'json_search_simple_products' ) );

        // Accessories Ajax Add to Cart for Variable Products
        add_action( 'wp_ajax_nopriv_cartzilla_variable_add_to_cart',      array( 'Cartzilla_WC_Helper', 'add_to_cart' ) );
        add_action( 'wp_ajax_cartzilla_variable_add_to_cart',             array( 'Cartzilla_WC_Helper', 'add_to_cart' ) );

        // Accessories Ajax Total Price Update
        add_action( 'wp_ajax_nopriv_cartzilla_accessories_total_price',   array( 'Cartzilla_WC_Helper', 'accessory_checked_total_price' ) );
        add_action( 'wp_ajax_cartzilla_accessories_total_price',          array( 'Cartzilla_WC_Helper', 'accessory_checked_total_price' ) );

        // Add Accessories Tab
        add_action( 'woocommerce_product_write_panel_tabs', array( 'Cartzilla_WC_Helper', 'add_product_accessories_panel_tab' ) );
        add_action( 'woocommerce_product_data_panels',      array( 'Cartzilla_WC_Helper', 'add_product_accessories_panel_data' ) );

        // Add Specification Tab
        add_action( 'woocommerce_product_write_panel_tabs', array( 'Cartzilla_WC_Helper', 'add_product_specification_panel_tab' ) );
        add_action( 'woocommerce_product_data_panels',      array( 'Cartzilla_WC_Helper', 'add_product_specification_panel_data' ) );
        
        foreach ( wc_get_product_types() as $value => $label ) {
            // Save Accessories Tab
            add_action( 'woocommerce_process_product_meta_' . $value, array( 'Cartzilla_WC_Helper', 'save_product_accessories_panel_data' ) );

            // Save Specification Tab
            add_action( 'woocommerce_process_product_meta_' . $value, array( 'Cartzilla_WC_Helper', 'save_product_specification_panel_data' ) );
        }

        // Add Custom Meta on General Tab
        add_action( 'woocommerce_product_options_general_product_data', [ __class__, 'add_general_product_data_custom_button_meta' ] );
        add_action( 'woocommerce_process_product_meta', [ __class__, 'save_general_product_data_custom_button_meta' ] );
    }

    /**
     * Search for products and echo json.
     *
     * @param string $term (default: '')
     * @param string $post_types (default: array('product'))
     */
    public static function json_search_simple_products( $term = '', $post_types = array( 'product' ) ) {
        global $wpdb;

        ob_start();

        check_ajax_referer( 'search-products', 'security' );

        if ( empty( $term ) ) {
            $term = wc_clean( stripslashes( $_GET['term'] ) );
        } else {
            $term = wc_clean( $term );
        }

        if ( empty( $term ) ) {
            die();
        }

        $like_term = '%' . $wpdb->esc_like( $term ) . '%';

        if ( is_numeric( $term ) ) {
            $query = $wpdb->prepare( "
                SELECT ID FROM {$wpdb->posts} posts LEFT JOIN {$wpdb->postmeta} postmeta ON posts.ID = postmeta.post_id
                WHERE posts.post_status = 'publish'
                AND (
                    posts.post_parent = %s
                    OR posts.ID = %s
                    OR posts.post_title LIKE %s
                    OR (
                        postmeta.meta_key = '_sku' AND postmeta.meta_value LIKE %s
                    )
                )
            ", $term, $term, $term, $like_term );
        } else {
            $query = $wpdb->prepare( "
                SELECT ID FROM {$wpdb->posts} posts LEFT JOIN {$wpdb->postmeta} postmeta ON posts.ID = postmeta.post_id
                WHERE posts.post_status = 'publish'
                AND (
                    posts.post_title LIKE %s
                    or posts.post_content LIKE %s
                    OR (
                        postmeta.meta_key = '_sku' AND postmeta.meta_value LIKE %s
                    )
                )
            ", $like_term, $like_term, $like_term );
        }

        $query .= " AND posts.post_type IN ('" . implode( "','", array_map( 'esc_sql', $post_types ) ) . "')";

        if ( ! empty( $_GET['exclude'] ) ) {
            $query .= " AND posts.ID NOT IN (" . implode( ',', array_map( 'intval', explode( ',', $_GET['exclude'] ) ) ) . ")";
        }

        if ( ! empty( $_GET['include'] ) ) {
            $query .= " AND posts.ID IN (" . implode( ',', array_map( 'intval', explode( ',', $_GET['include'] ) ) ) . ")";
        }

        if ( ! empty( $_GET['limit'] ) ) {
            $query .= " LIMIT " . intval( $_GET['limit'] );
        }

        $posts          = array_unique( $wpdb->get_col( $query ) );
        $found_products = array();

        if ( ! empty( $posts ) ) {
            foreach ( $posts as $post ) {
                $product = wc_get_product( $post );

                if ( ! current_user_can( 'read_product', $post ) ) {
                    continue;
                }

                if ( ! $product || ( $product->is_type( 'variation' ) && empty( $product->parent ) ) ) {
                    continue;
                }

                if ( ! $product->is_type( 'simple' ) ) {
                    continue;
                }

                $found_products[ $post ] = rawurldecode( $product->get_formatted_name() );
            }
        }

        $found_products = apply_filters( 'woocommerce_json_search_found_products', $found_products );

        wp_send_json( $found_products );
    }

    public static function add_product_accessories_panel_tab() {
        ?>
        <li class="accessories_options accessories_tab show_if_simple show_if_variable">
            <a href="#accessories_product_data"><span><?php echo esc_html__( 'Accessories', 'cartzilla' ); ?></span></a>
        </li>
        <?php
    }

    public static function add_product_accessories_panel_data() {
        global $post;
        ?>

        <div id="accessories_product_data" class="panel woocommerce_options_panel">
            <div class="options_group">

               <?php woocommerce_wp_text_input(  array( 
                    'id' => '_accessories_attributes_title',
                    'label' => esc_html__( 'Accessories Title', 'cartzilla' ),
                    'desc_tip' => 'true',
                    'description' => esc_html__( 'Accessories Title', 'cartzilla' ),
                    'type' => 'text'
                ) ); ?>

                <p class="form-field">
                    <label for="accessory_ids"><?php esc_html_e( 'Accessories', 'cartzilla' ); ?></label>
                        <select class="wc-product-search" multiple="multiple" style="width: 50%;" id="accessory_ids" name="accessory_ids[]" data-placeholder="<?php esc_attr_e( 'Search for a product&hellip;', 'cartzilla' ); ?>" data-action="woocommerce_json_search_simple_products" data-exclude="<?php echo intval( $post->ID ); ?>">
                            <?php
                                $product_ids = array_filter( array_map( 'absint', (array) get_post_meta( $post->ID, '_accessory_ids', true ) ) );

                                foreach ( $product_ids as $product_id ) {
                                    $product = wc_get_product( $product_id );
                                    if ( is_object( $product ) ) {
                                        echo '<option value="' . esc_attr( $product_id ) . '"' . selected( true, true, false ) . '>' . wp_kses_post( $product->get_formatted_name() ) . '</option>';
                                    }
                                }
                            ?>
                        </select>

                    <?php echo wc_help_tip( esc_html__( 'Accessories are products which you recommend to be bought along with this product. Only simple products can be added as accessories.', 'cartzilla' ) ); ?>
                </p>
            </div>
        </div>
        <?php
    }

    public static function save_product_accessories_panel_data( $post_id ) {
    
        $accessories = isset( $_POST['accessory_ids'] ) ? array_map( 'intval', (array) $_POST['accessory_ids'] ) : array();
        update_post_meta( $post_id, '_accessory_ids', $accessories );

        $attributes_title = isset( $_POST['_accessories_attributes_title'] ) ? $_POST['_accessories_attributes_title'] : '';
        update_post_meta( $post_id, '_accessories_attributes_title', $attributes_title );

    }

    public static function get_accessories( $product ) {
        $product_id = $product->get_id();
        $accessory_ids = get_post_meta( $product_id, '_accessory_ids', true );
        $accessories = empty( $accessory_ids )? array() : (array) maybe_unserialize( $accessory_ids );
        return apply_filters( 'woocommerce_product_accessory_ids', $accessories , $product );
    }

    public static function add_product_specification_panel_tab() {
        ?>
        <li class="specification_options specification_tab">
            <a href="#specification_product_data"><span><?php echo esc_html__( 'Specifications', 'cartzilla' ); ?></span></a>
        </li>
        <?php
    }

    public static function add_product_specification_panel_data() {
        global $post;
        ?>
        <div id="specification_product_data" class="panel woocommerce_options_panel">
            <div class="options_group">
                <?php
                    $specifications = get_post_meta( $post->ID, '_specifications', true );
                    wp_editor( wp_specialchars_decode( $specifications ), '_specifications', array() );
                ?>
            </div>
        </div>
        <?php
    }

    public static function save_product_specification_panel_data( $post_id ) {
        $specifications = isset( $_POST['_specifications'] ) ? $_POST['_specifications'] : '';
        update_post_meta( $post_id, '_specifications', $specifications );
    }

    /**
     * AJAX add to cart.
     */
    public static function add_to_cart() {
        $product_id        = apply_filters( 'cartzilla_add_to_cart_product_id', absint( $_POST['product_id'] ) );
        $quantity          = empty( $_POST['quantity'] ) ? 1 : wc_stock_amount( $_POST['quantity'] );
        $variation_id      = empty( $_POST['variation_id'] ) ? 0 : $_POST['variation_id'];
        $variation         = empty( $_POST['variation'] ) ? array() : $_POST['variation'];
        $passed_validation = apply_filters( 'cartzilla_add_to_cart_validation', true, $product_id, $quantity );
        $product_status    = get_post_status( $product_id );
        
        if ( $passed_validation && WC()->cart->add_to_cart( $product_id, $quantity, $variation_id, $variation ) && 'publish' === $product_status ) {

            do_action( 'woocommerce_ajax_added_to_cart', $product_id );

            if ( get_option( 'woocommerce_cart_redirect_after_add' ) == 'yes' ) {
                wc_add_to_cart_message( $product_id );
            }

            // Return fragments
            WC_AJAX::get_refreshed_fragments();

        } else {

            // If there was an error adding to the cart, redirect to the product page to show any errors
            $data = array(
                'error'       => true,
                'product_url' => apply_filters( 'woocommerce_cart_redirect_after_error', get_permalink( $product_id ), $product_id )
            );

            wp_send_json( $data );

        }

        die();
    }

    /**
     * AJAX total price display.
     */
    public static function accessory_checked_total_price() {
        global $woocommerce;
        $price = empty( $_POST['price'] ) ? 0 : $_POST['price'];
        $price_suffix = empty( $_POST['price_suffix'] ) ? 0 : $_POST['price_suffix'];

        if( $price ) {
            $price_html = wc_price( $price );
            if( $price_suffix ) {
                $suffix = get_option( 'woocommerce_price_display_suffix' );
                if ( strpos( $suffix, '{price_excluding_tax}' ) !== false ) {
                    $price_html .= str_replace( '{price_excluding_tax}', wc_price( $price_suffix ), ' <small class="woocommerce-price-suffix">' . wp_kses_post( $suffix ) . '</small>' );
                } elseif ( strpos( $suffix, '{price_including_tax}' ) !== false ) {
                    $price_html .= str_replace( '{price_including_tax}', wc_price( $price_suffix ), ' <small class="woocommerce-price-suffix">' . wp_kses_post( $suffix ) . '</small>' );
                }
            }
            echo wp_kses_post( $price_html );
        }

        die();
    }
    
    public static function add_general_product_data_custom_button_meta() {
        $product_id = get_the_ID();
        $product    = wc_get_product( $product_id );

        if ( ! $product instanceof WC_Product ) {
            return;
        }

        $custom_fields = cartzilla_general_product_data_custom_button_meta_args();
        uasort( $custom_fields, 'cartzilla_sort_priority_callback' );

        if( ! empty ( $custom_fields ) ) {
            foreach ( $custom_fields as $key => $custom_field ) {
                $data = $product->get_meta( '_' . $key );
                $button_text = ! empty( $data['button_text'] ) ? $data['button_text'] : '';
                $button_url = ! empty( $data['button_url'] ) ? $data['button_url'] : '';
                $new_tab = ! empty( $data['new_tab'] ) ? $data['new_tab'] : 'no';

                echo '<div class="options_group">';

                    woocommerce_wp_text_input( [
                        'id'        => $key . '_button_text',
                        'value'     => $button_text,
                        'label'     => sprintf( __( '%s Button Text', 'cartzilla' ), $custom_field['label_base'] ),
                    ] );

                    woocommerce_wp_text_input( [
                        'id'        => $key . '_button_url',
                        'value'     => $button_url,
                        'data_type' => 'url',
                        'label'     => sprintf( __( '%s Button Url', 'cartzilla' ), $custom_field['label_base'] ),
                    ] );

                    woocommerce_wp_checkbox( [
                        'id'          => $key . '_new_tab',
                        'value'       => $new_tab,
                        'label'       => __( 'Open in New Tab', 'cartzilla' ),
                        'description' => sprintf( __( 'open %s button url in new tab', 'cartzilla' ), $custom_field['label_base'] ),
                    ] );

                echo '</div>';
            }
        }
    }

    public static function save_general_product_data_custom_button_meta( $product_id ) {
        $product = wc_get_product( $product_id );

        if ( ! $product instanceof WC_Product ) {
            return;
        }

        $custom_fields = cartzilla_general_product_data_custom_button_meta_args();

        if( ! empty ( $custom_fields ) ) {
            foreach ( $custom_fields as $key => $custom_field ) {
                $data = [];
                $data['button_text'] = ! empty( $_POST["{$key}_button_text"] ) ? wc_clean( $_POST["{$key}_button_text"] ) : '';
                $data['button_url'] = ! empty( $_POST["{$key}_button_url"] ) ? wc_clean( $_POST["{$key}_button_url"] ) : '';
                $data['new_tab'] = ! empty( $_POST["{$key}_new_tab"] ) ? wc_clean( $_POST["{$key}_new_tab"] ) : 'no';

                $product->update_meta_data( '_' . $key , $data );
            }
        }
        $product->save();
    }
}

Cartzilla_WC_Helper::init();