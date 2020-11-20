<?php
/**
 * Cartzilla WooCommerce Class
 *
 * @package  cartzilla
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

define( 'CARTZILLA_WC_VIEW_COOKIE', 'cartzilla_wc_view' );

if ( ! class_exists( 'Cartzilla_WooCommerce' ) ) :

    /**
     * Cartzilla WooCommerce Integration class
     */
    class Cartzilla_WooCommerce {

        /**
         * Setup class.
         *
         * @since 1.0.0
         */
        public function __construct() {
            $this->includes();
            $this->init_hooks();
        }

        /**
         * Includes classes and other files required
         */
        public function includes() {
            require_once get_template_directory() . '/inc/woocommerce/classes/class-cartzilla-wc-helper.php';
        }

        /**
         * Setup class.
         *
         * @since 1.0
         */
        private function init_hooks() {
            add_filter( 'woocommerce_enqueue_styles', '__return_empty_array' );
            add_action( 'widgets_init', array( $this, 'widgets_init' ) );
            add_action( 'admin_init', array( $this, 'allow_customer_uploads' ) );
            add_action( 'init', array( $this, 'allow_customer_uploads' ) );
            add_filter( 'ajax_query_attachments_args',  array( $this, 'filter_get_the_user_attachments' ), 10 );
        }

        public static function widgets_init() {
            register_sidebar( [
                'id'            => 'sidebar-shop',
                'name'          => esc_html__( 'Shop Sidebar', 'cartzilla' ),
                'before_widget' => '<div id="%1$s" class="widget %2$s">',
                'after_widget'  => '</div>',
                'before_title'  => '<h3 class="widget-title">',
                'after_title'   => '</h3>',
            ] );

            // Register 3 additional sidebars "Shop Filter Column 1-3" for layouts with filters on top.
            register_sidebar( [
                'id'            => 'shop-filters-column-1',
                'name'          => esc_html__( 'Full Width Shop Filters Column 1', 'cartzilla' ),
                'description'   => esc_html__( 'For use inside layout with filters on top. Left column.', 'cartzilla' ),
                'before_widget' => '<div class="card mb-grid-gutter"><div class="card-body px-4"><div class="widget %2$s">',
                'after_widget'  => '</div></div></div>',
                'before_title'  => '<h3 class="widget-title">',
                'after_title'   => '</h3>',
            ] );

            register_sidebar( [
                'id'            => 'shop-filters-column-2',
                'name'          => esc_html__( 'Full Width Shop Filters Column 2', 'cartzilla' ),
                'description'   => esc_html__( 'For use inside layout with filters on top. Column on center.', 'cartzilla' ),
                'before_widget' => '<div class="card mb-grid-gutter"><div class="card-body px-4"><div class="widget %2$s">',
                'after_widget'  => '</div></div></div>',
                'before_title'  => '<h3 class="widget-title">',
                'after_title'   => '</h3>',
            ] );

            register_sidebar( [
                'id'            => 'shop-filters-column-3',
                'name'          => esc_html__( 'Full Width Shop Filters Column 3', 'cartzilla' ),
                'description'   => esc_html__( 'For use inside layout with filters on top. Right column.', 'cartzilla' ),
                'before_widget' => '<div class="card mb-grid-gutter"><div class="card-body px-4"><div class="widget %2$s">',
                'after_widget'  => '</div></div></div>',
                'before_title'  => '<h3 class="widget-title">',
                'after_title'   => '</h3>',
            ] );
        }

        public static function allow_customer_uploads() {
            if ( ! current_user_can('upload_files') && is_wc_endpoint_url( 'edit-account' ) ) {
                $customer = get_role('customer');
                $customer->add_cap('upload_files');
            }
        }

        public static function filter_get_the_user_attachments( $query ) {
            $current_user = wp_get_current_user();

            if ( ! $current_user ) {
                return $query;
            }

            if( current_user_can('administrator') ) {
                return $query;
            }

            if( current_user_can('customer') ) {
                $current_user_id = $current_user->ID;
                $query['author__in'] = array(
                    $current_user_id
                );
                return $query;
            }
            return $query;
        }
    }

endif;

return new Cartzilla_WooCommerce();