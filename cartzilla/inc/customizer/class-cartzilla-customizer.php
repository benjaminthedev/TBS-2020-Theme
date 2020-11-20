<?php
/**
 * Cartzilla Customizer Class
 *
 * @package  cartzilla
 * @since    1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

if ( ! class_exists( 'Cartzilla_Customizer' ) ) :
    /**
     * The Cartzilla Customizer class
     */
    class Cartzilla_Customizer {

        /**
         * Setup class.
         *
         * @since 1.0
         */
        public function __construct() {
            $this->includes();
            $this->init_hooks();
        }

        /**
         * Includes Cartzilla_Customizer when Wordpress Initializes
         */
        public function includes() {
            /**
             * Core classes.
             */
            require_once get_template_directory() . '/inc/customizer/cartzilla-customizer-multi-select.php';
        }

        /**
         * Init Cartzilla_Customizer when Wordpress Initializes
         */
        public function init_hooks() {
            add_action( 'customize_register', array( $this, 'customize_logos' ), 10 );
            add_action( 'customize_register', array( $this, 'customize_header' ), 10 );
            add_action( 'customize_register', array( $this, 'customize_footer' ), 10 );
            add_action( 'customize_register', array( $this, 'customize_blog' ), 10 );
            add_action( 'customize_register', array( $this, 'customize_404' ), 10 );
            add_action( 'customize_register', array( $this, 'customize_customcolor' ), 10 );
        }

        /**
         * Customize all available site logos
         *
         * All logos located in title_tagline (Site Identity) section.
         *
         * @param WP_Customize_Manager $wp_customize Theme Customizer object.
         */
        public function customize_logos( $wp_customize ) {
            $this->add_customize_logos( $wp_customize );
        }

        private function add_customize_logos( $wp_customize ) {
            $wp_customize->get_control( 'custom_logo' )->description = esc_html__(
                'Logo is optimized for retina displays, so the original image size should be twice
                as big as the final logo that appears on the website. For example, if you want logo to
                be 142x34 px you should upload image 284x68 px.',
                'cartzilla'
            );

            // Update the "custom_logo" partial with a new render callback
            // TODO: wrap into anonymous function with return context
            $wp_customize->selective_refresh->get_partial( 'custom_logo' )->render_callback = 'cartzilla_get_logo';
            //</editor-fold>

            //<editor-fold desc="mobile_logo">
            $wp_customize->add_setting( 'mobile_logo', [
                'transport'      => 'postMessage',
                'theme_supports' => 'custom-logo',
                'sanitize_callback' => 'absint',
            ] );
            $wp_customize->add_control( new WP_Customize_Cropped_Image_Control( $wp_customize, 'mobile_logo', [
                'section'       => 'title_tagline',
                'label'         => esc_html__( 'Mobile Logo', 'cartzilla' ),
                'description'   => esc_html__( 'Mobile logo inherits the same behavior for retina displays as desktop logo.', 'cartzilla' ),
                'priority'      => 9,
                'width'         => 68,
                'height'        => 68,
                'flex_width'    => true,
                'flex_height'   => true,
                'button_labels' => [
                    'select'       => esc_html__( 'Select logo', 'cartzilla' ),
                    'change'       => esc_html__( 'Change logo', 'cartzilla' ),
                    'remove'       => esc_html__( 'Remove', 'cartzilla' ),
                    'default'      => esc_html__( 'Default', 'cartzilla' ),
                    'placeholder'  => esc_html__( 'No logo selected', 'cartzilla' ),
                    'frame_title'  => esc_html__( 'Select logo', 'cartzilla' ),
                    'frame_button' => esc_html__( 'Choose logo', 'cartzilla' ),
                ],
            ] ) );
            $wp_customize->selective_refresh->add_partial( 'mobile_logo', [
                'selector'            => '.mobile-logo-link',
                'container_inclusive' => true,
                'render_callback'     => 'cartzilla_get_mobile_logo',
            ] );
            //</editor-fold>

            //<editor-fold desc="footer_logo">
            $wp_customize->add_setting( 'footer_logo', [
                'transport'      => 'postMessage',
                'theme_supports' => 'custom-logo',
                'sanitize_callback' => 'absint',
            ] );
            $wp_customize->add_control( new WP_Customize_Cropped_Image_Control( $wp_customize, 'footer_logo', [
                'section'       => 'title_tagline',
                /* translators: label field for setting in Customizer */
                'label'         => esc_html__( 'Footer Logo', 'cartzilla' ),
                /* translators: description field for setting in Customizer */
                'description'   => esc_html__( 'Footer logo inherits the same behavior for retina displays as desktop logo.', 'cartzilla' ),
                'priority'      => 9,
                'width'         => 234,
                'height'        => 56,
                'flex_width'    => true,
                'flex_height'   => true,
                'button_labels' => [
                    'select'       => esc_html__( 'Select logo', 'cartzilla' ),
                    'change'       => esc_html__( 'Change logo', 'cartzilla' ),
                    'remove'       => esc_html__( 'Remove', 'cartzilla' ),
                    'default'      => esc_html__( 'Default', 'cartzilla' ),
                    'placeholder'  => esc_html__( 'No logo selected', 'cartzilla' ),
                    'frame_title'  => esc_html__( 'Select logo', 'cartzilla' ),
                    'frame_button' => esc_html__( 'Choose logo', 'cartzilla' ),
                ],
            ] ) );
            $wp_customize->selective_refresh->add_partial( 'footer_logo', [
                'selector'            => '.footer-logo-link',
                'container_inclusive' => true,
                'render_callback'     => 'cartzilla_get_footer_logo',
            ] );
        }

        /**
         * Customize site header
         *
         * @param WP_Customize_Manager $wp_customize Theme Customizer object.
         */
        public function customize_header( $wp_customize ) {
            $wp_customize->add_panel( 'cartzilla_header', [
                'title'       => esc_html__( 'Header', 'cartzilla' ),
                'description' => esc_html__( 'Customize the theme header.', 'cartzilla' ),
                'priority'    => 30,
            ] );

            $this->add_header_general_section( $wp_customize );
            $this->add_header_topbar_section( $wp_customize );
            $this->add_header_navbar_section( $wp_customize );
            $this->add_header_navigation_section( $wp_customize );
        }

        private function add_header_general_section( $wp_customize ) {
            $wp_customize->add_section( 'cartzilla_header_general', [
                'title'       => esc_html__( 'General', 'cartzilla' ),
                'description' => esc_html__( 'Contains general settings for header customization.', 'cartzilla' ),
                'panel'       => 'cartzilla_header',
            ] );

            $wp_customize->add_setting( 'header_type', [
                'default'           => '1-level-light',
                'sanitize_callback' => 'sanitize_key',
            ] );
            $wp_customize->add_control( 'header_type', [
                'type'        => 'select',
                'section'     => 'cartzilla_header_general',
                'label'       => esc_html__( 'Type', 'cartzilla' ),
                'description' => esc_html__( 'This setting allows you to choose the desired type of header from minimal to more complicated.', 'cartzilla' ),
                'choices'     => [
                    '1-level-light' => esc_html__( '1 Level Light', 'cartzilla' ),
                    '1-level-dark'  => esc_html__( '1 Level Dark', 'cartzilla' ),
                    '2-level-light' => esc_html__( '2 Level Light', 'cartzilla' ),
                    '2-level-dark'  => esc_html__( '2 Level Dark', 'cartzilla' ),
                    '3-level-light' => esc_html__( '3 Level Light', 'cartzilla' ),
                    '3-level-dark'  => esc_html__( '3 Level Dark', 'cartzilla' ),
                    'electronics-store'  => esc_html__( 'Electronics Store', 'cartzilla' ),
                    'marketplace'   => esc_html__( 'Marketplace', 'cartzilla' ),
                    'grocery'   => esc_html__( 'Grocery', 'cartzilla' ),
                    'with-button'   => esc_html__( 'Button Header', 'cartzilla' ),
                ],
            ] );

            $wp_customize->add_setting( 'header_is_full_width', [
                'default'           => 'no',
                'sanitize_callback' => 'sanitize_key',
            ] );

            $wp_customize->add_control( 'header_is_full_width', [
                'type'        => 'radio',
                'section'     => 'cartzilla_header_general',
                'label'       => esc_html__( 'Make header full-width?', 'cartzilla' ),
                'description' => esc_html__( 'This setting allows you to control header width. Default is boxed.', 'cartzilla' ),
                'choices'     => [
                    'yes' => esc_html__( 'Yes', 'cartzilla' ),
                    'no'  => esc_html__( 'No', 'cartzilla' ),
                ],
            ] );

            $wp_customize->add_setting( 'header_is_sticky', [
                'default'           => 'yes',
                'sanitize_callback' => 'sanitize_key',
            ] );

            $wp_customize->add_control( 'header_is_sticky', [
                'type'        => 'radio',
                'section'     => 'cartzilla_header_general',
                'label'       => esc_html__( 'Make header sticky?', 'cartzilla' ),
                'description' => esc_html__(
                    'Sticky means that navbar is locked into place so that it does not disappear when the user scrolls down the page.',
                    'cartzilla'
                ),
                'choices'     => [
                    'yes' => esc_html__( 'Yes', 'cartzilla' ),
                    'no'  => esc_html__( 'No', 'cartzilla' ),
                ],
            ] );

            $wp_customize->add_setting( 'navbar_is_account', [
                'default'           => 'yes',
                'sanitize_callback' => 'sanitize_key',
            ] );

            $wp_customize->add_control( 'navbar_is_account', [
                'type'        => 'radio',
                'section'     => 'cartzilla_header_general',
                'label'       => esc_html__( 'Show account?', 'cartzilla' ),
                'description' => esc_html__( 'Enable / disable "My account" with a dropdown menu in Navbar section.', 'cartzilla' ),
                'choices'     => [
                    'yes' => esc_html__( 'Yes', 'cartzilla' ),
                    'no'  => esc_html__( 'No', 'cartzilla' ),
                ],
                'active_callback' => function () {
                    return in_array( get_theme_mod( 'header_type' ), [
                        '1-level-light',
                        '1-level-dark',
                        '2-level-light',
                        '2-level-dark',
                        '3-level-light',
                        '3-level-dark',
                        'electronics-store',
                        'marketplace',
                        'grocery',
                    ] ) && cartzilla_is_woocommerce_activated();
                }
            ] );

            $wp_customize->selective_refresh->add_partial( 'navbar_is_account', [
                'fallback_refresh'    => true
            ] );

            $wp_customize->add_setting( 'navbar_is_cart', [
                'default'           => 'yes',
                'sanitize_callback' => 'sanitize_key',
            ] );

            $wp_customize->add_control( 'navbar_is_cart', [
                'type'        => 'radio',
                'section'     => 'cartzilla_header_general',
                'label'       => esc_html__( 'Show cart?', 'cartzilla' ),
                'description' => esc_html__( 'Enable / disable mini cart in Navbar section.', 'cartzilla' ),
                'choices'     => [
                    'yes' => esc_html__( 'Yes', 'cartzilla' ),
                    'no'  => esc_html__( 'No', 'cartzilla' ),
                ],
                'active_callback' => function () {
                    return in_array( get_theme_mod( 'header_type' ), [
                        '1-level-light',
                        '1-level-dark',
                        '2-level-light',
                        '2-level-dark',
                        '3-level-light',
                        '3-level-dark',
                        'electronics-store',
                        'marketplace',
                        'grocery',
                    ] ) && cartzilla_is_woocommerce_activated();
                }
            ] );

            $wp_customize->selective_refresh->add_partial( 'navbar_is_cart', [
                'fallback_refresh'    => true
            ] );

            $wp_customize->add_setting( 'cartzilla_order_tracking_page', [
                'default'              => 0,
                'type'                 => 'option',
                'sanitize_callback'    => 'absint',
                'sanitize_js_callback' => 'absint',
            ] );

            $wp_customize->add_control( 'cartzilla_order_tracking_page', [
                'type'     => 'dropdown-pages',
                'priority' => 20,
                'label'    => esc_html__( 'Select an "Order tracking" page', 'cartzilla' ),
                'section'  => 'cartzilla_header_general',
                'settings' => 'cartzilla_order_tracking_page',
                'active_callback' => function () {
                    return in_array( get_theme_mod( 'header_type' ), [
                        '2-level-light',
                        '2-level-dark',
                        '3-level-light',
                        '3-level-dark',
                        'electronics-store',
                    ] ) && cartzilla_is_woocommerce_activated();
                }
            ] );

            $wp_customize->selective_refresh->add_partial( 'cartzilla_order_tracking_page', [
                'fallback_refresh'    => true
            ] );

            $wp_customize->add_setting( 'cartzilla_order_tracking_page_text', [
                'default'           => esc_html__( 'Order tracking', 'cartzilla' ),
                'transport'         => 'postMessage',
                'sanitize_callback' => 'sanitize_text_field',
            ] );

            $wp_customize->add_control( 'cartzilla_order_tracking_page_text', [
                'type'            => 'text',
                'priority'        => 20,
                'section'         => 'cartzilla_header_general',
                'label'           => esc_html__( 'Order Tracking Text', 'cartzilla' ),
                'description'     => esc_html__( 'This setting allows you to change "Support" word to something else.', 'cartzilla' ),
                'active_callback' => function () {
                    return in_array( get_theme_mod( 'header_type' ), [
                        '2-level-light',
                        '2-level-dark',
                        '3-level-light',
                        '3-level-dark',
                        'electronics-store',
                    ] ) && cartzilla_is_woocommerce_activated();
                }
            ] );

            $wp_customize->selective_refresh->add_partial( 'cartzilla_order_tracking_page_text', [
                'fallback_refresh'    => true
            ] );

            $wp_customize->add_setting( 'cartzilla_order_tracking_page_icon', [
                'default'           => 'czi-location',
                'transport'         => 'postMessage',
                'sanitize_callback' => 'sanitize_text_field',
            ] );

            $wp_customize->add_control( 'cartzilla_order_tracking_page_icon', [
                'type'            => 'text',
                'priority'        => 20,
                'section'         => 'cartzilla_header_general',
                'label'           => esc_html__( 'Order Tracking Icon', 'cartzilla' ),
                'description'     => esc_html__( 'This setting allows you to change the order tracking icon to something else.', 'cartzilla' ),
                'active_callback' => function () {
                    return in_array( get_theme_mod( 'header_type' ), [
                        '2-level-light',
                        '2-level-dark',
                        '3-level-light',
                        '3-level-dark',
                        'electronics-store',
                    ] ) && cartzilla_is_woocommerce_activated();
                }
            ] );

            $wp_customize->selective_refresh->add_partial( 'cartzilla_order_tracking_page_icon', [
                'fallback_refresh'    => true
            ] );

            $wp_customize->add_setting( 'support_info', [
                'default'           => 'yes',
                'sanitize_callback' => 'sanitize_key',
            ] );

            $wp_customize->add_control( 'support_info', [
                'type'        => 'radio',
                'section'     => 'cartzilla_header_general',
                'label'       => esc_html__( 'Enable Support Info', 'cartzilla' ),
                'description' => esc_html__( 'This setting allows you to show or hide support info.', 'cartzilla' ),
                'choices'     => [
                    'yes' => esc_html__( 'Yes', 'cartzilla' ),
                    'no'  => esc_html__( 'No', 'cartzilla' ),
                ],
                'active_callback' => function () {
                    return  in_array( get_theme_mod( 'header_type' ), [
                        '2-level-light',
                        '2-level-dark',
                        '3-level-light',
                        '3-level-dark',
                        'electronics-store',
                        'grocery',
                    ] ) ;
                } 
            ] );

            $wp_customize->selective_refresh->add_partial( 'support_info', [
                'fallback_refresh'    => true
            ] );

            $wp_customize->add_setting( 'support_info_title', [
                'default'           => esc_html__( 'Support', 'cartzilla' ),
                'transport'         => 'postMessage',
                'sanitize_callback' => 'sanitize_text_field',
            ] );

            $wp_customize->add_control( 'support_info_title', [
                'type'            => 'text',
                'section'         => 'cartzilla_header_general',
                'label'           => esc_html__( 'Support Info Title', 'cartzilla' ),
                'description'     => esc_html__( 'This setting allows you to change "Support" word to something else.', 'cartzilla' ),
                'active_callback' => function () {
                    return in_array( get_theme_mod( 'header_type' ), [
                        '2-level-light',
                        '2-level-dark',
                        '3-level-light',
                        '3-level-dark',
                        'electronics-store',
                        'grocery',
                    ] ) && 'yes' === get_theme_mod( 'support_info', 'yes' );
                }
            ] );

            $wp_customize->selective_refresh->add_partial( 'support_info_title', [
                'fallback_refresh'    => true
            ] );

            $wp_customize->add_setting( 'support_info_icon', [
                /* translators: default value for "departments_title" setting in Customizer */
                'default'           => 'czi-support',
                'transport'         => 'postMessage',
                'sanitize_callback' => 'sanitize_text_field',
            ] );

            $wp_customize->add_control( 'support_info_icon', [
                'type'            => 'text',
                'section'         => 'cartzilla_header_general',
                'label'           => esc_html__( 'Support Info Icon', 'cartzilla' ),
                'description'     => esc_html__( 'This setting allows you to change the support icon to something else.', 'cartzilla' ),
                'active_callback' => function () {
                    return in_array( get_theme_mod( 'header_type' ), [
                        '2-level-light',
                        '2-level-dark',
                        '3-level-light',
                        '3-level-dark',
                        'electronics-store',
                        'grocery',
                    ] ) && 'yes' === get_theme_mod( 'support_info', 'yes' );
                }
            ] );

            $wp_customize->selective_refresh->add_partial( 'support_info_icon', [
                'fallback_refresh'    => true
            ] );

            $wp_customize->add_setting( 'support_info_text', [
                /* translators: default value for "departments_title" setting in Customizer */
                'default'           => esc_html__( '+1 (00) 33 169 7720', 'cartzilla' ),
                'transport'         => 'postMessage',
                'sanitize_callback' => 'wp_kses_post',
            ] );

            $wp_customize->add_control( 'support_info_text', [
                'type'            => 'textarea',
                'section'         => 'cartzilla_header_general',
                'label'           => esc_html__( 'Support Text', 'cartzilla' ),
                'description'     => esc_html__( 'This setting allows you to change the support number to something else.', 'cartzilla' ),
                'active_callback' => function () {
                    return in_array( get_theme_mod( 'header_type' ), [
                        '2-level-light',
                        '2-level-dark',
                        '3-level-light',
                        '3-level-dark',
                        'electronics-store',
                        'grocery',
                    ] ) && 'yes' === get_theme_mod( 'support_info', 'yes' );
                }
            ] );

            $wp_customize->selective_refresh->add_partial( 'support_info_text', [
                'fallback_refresh'    => true
            ] );

            $wp_customize->add_setting( 'support_info_link', [
                /* translators: default value for "departments_title" setting in Customizer */
                'default'           => esc_html__( 'tel:+100331697720', 'cartzilla' ),
                'transport'         => 'postMessage',
                'sanitize_callback' => 'sanitize_text_field',
            ] );

            $wp_customize->add_control( 'support_info_link', [
                'type'            => 'text',
                'section'         => 'cartzilla_header_general',
                'label'           => esc_html__( 'Support Link', 'cartzilla' ),
                'description'     => esc_html__( 'This setting allows you to change support link to something else.', 'cartzilla' ),
                'active_callback' => function () {
                    return in_array( get_theme_mod( 'header_type' ), [
                        '2-level-light',
                        '2-level-dark',
                        '3-level-light',
                        '3-level-dark',
                        'electronics-store',
                        'grocery',
                    ] ) && 'yes' === get_theme_mod( 'support_info', 'yes' );
                }
            ] );

            $wp_customize->selective_refresh->add_partial( 'support_info_link', [
                'fallback_refresh'    => true
            ] );


            $wp_customize->add_setting( 'contact_info', [
                'default'           => 'yes',
                'sanitize_callback' => 'sanitize_key',
            ] );

            $wp_customize->add_control( 'contact_info', [
                'type'        => 'radio',
                'section'     => 'cartzilla_header_general',
                'label'       => esc_html__( 'Enable Contact Info', 'cartzilla' ),
                'description' => esc_html__( 'This setting allows you to show or hide contact info.', 'cartzilla' ),
                'choices'     => [
                    'yes' => esc_html__( 'Yes', 'cartzilla' ),
                    'no'  => esc_html__( 'No', 'cartzilla' ),
                ],
                'active_callback' => function () {
                    return in_array( get_theme_mod( 'header_type' ), [ 'grocery' ] );
                } 
            ] );

            $wp_customize->selective_refresh->add_partial( 'contact_info', [
                'fallback_refresh'    => true
            ] );

            $wp_customize->add_setting( 'contact_info_title', [
                'default'           => esc_html__( 'Email', 'cartzilla' ),
                'transport'         => 'postMessage',
                'sanitize_callback' => 'sanitize_text_field',
            ] );

            $wp_customize->add_control( 'contact_info_title', [
                'type'            => 'text',
                'section'         => 'cartzilla_header_general',
                'label'           => esc_html__( 'Contact Info Title', 'cartzilla' ),
                'description'     => esc_html__( 'This setting allows you to change "Email" word to something else.', 'cartzilla' ),
                'active_callback' => function () {
                    return in_array(
                        get_theme_mod( 'header_type' ), [ 'grocery' ] 
                    ) && 'yes' === get_theme_mod( 'contact_info', 'yes' );
                }
            ] );

            $wp_customize->selective_refresh->add_partial( 'contact_info_title', [
                'fallback_refresh'    => true
            ] );

            $wp_customize->add_setting( 'contact_info_icon', [
                /* translators: default value for "departments_title" setting in Customizer */
                'default'           => 'czi-mail',
                'transport'         => 'postMessage',
                'sanitize_callback' => 'sanitize_text_field',
            ] );

            $wp_customize->add_control( 'contact_info_icon', [
                'type'            => 'text',
                'section'         => 'cartzilla_header_general',
                'label'           => esc_html__( 'Contact Info Icon', 'cartzilla' ),
                'description'     => esc_html__( 'This setting allows you to change the contact icon to something else.', 'cartzilla' ),
                'active_callback' => function () {
                    return in_array(
                        get_theme_mod( 'header_type' ), [ 'grocery' ] 
                    ) && 'yes' === get_theme_mod( 'contact_info', 'yes' );
                }
            ] );

            $wp_customize->selective_refresh->add_partial( 'contact_info_icon', [
                'fallback_refresh'    => true
            ] );

            $wp_customize->add_setting( 'contact_info_text', [
                /* translators: default value for "departments_title" setting in Customizer */
                'default'           => esc_html__( 'customer@example.com', 'cartzilla' ),
                'transport'         => 'postMessage',
                'sanitize_callback' => 'wp_kses_post',
            ] );

            $wp_customize->add_control( 'contact_info_text', [
                'type'            => 'textarea',
                'section'         => 'cartzilla_header_general',
                'label'           => esc_html__( 'Contact Text', 'cartzilla' ),
                'description'     => esc_html__( 'This setting allows you to change the contact text to something else.', 'cartzilla' ),
                'active_callback' => function () {
                    return in_array(
                        get_theme_mod( 'header_type' ), [ 'grocery' ] 
                    ) && 'yes' === get_theme_mod( 'contact_info', 'yes' );
                }
            ] );

            $wp_customize->selective_refresh->add_partial( 'contact_info_text', [
                'fallback_refresh'    => true
            ] );

            $wp_customize->add_setting( 'contact_info_link', [
                /* translators: default value for "departments_title" setting in Customizer */
                'default'           => esc_html__( 'mailto:customer@example.com', 'cartzilla' ),
                'transport'         => 'postMessage',
                'sanitize_callback' => 'sanitize_text_field',
            ] );

            $wp_customize->add_control( 'contact_info_link', [
                'type'            => 'text',
                'section'         => 'cartzilla_header_general',
                'label'           => esc_html__( 'Contact Link', 'cartzilla' ),
                'description'     => esc_html__( 'This setting allows you to change contact link to something else.', 'cartzilla' ),
                'active_callback' => function () {
                    return in_array(
                        get_theme_mod( 'header_type' ), [ 'grocery' ] 
                    ) && 'yes' === get_theme_mod( 'contact_info', 'yes' );
                }
            ] );


            $wp_customize->selective_refresh->add_partial( 'contact_info_link', [
                'fallback_refresh'    => true
            ] );

            $wp_customize->add_setting( 'header_social_menu', [
                'default'           => 'yes',
                'sanitize_callback' => 'sanitize_key',
            ] );

            $wp_customize->add_control( 'header_social_menu', [
                'type'        => 'radio',
                'section'     => 'cartzilla_header_general',
                'label'       => esc_html__( 'Enable Header Social Menu', 'cartzilla' ),
                'description' => esc_html__( 'This setting allows you to show or hide social menu in Header.', 'cartzilla' ),
                'choices'     => [
                    'yes' => esc_html__( 'Yes', 'cartzilla' ),
                    'no'  => esc_html__( 'No', 'cartzilla' ),
                ],
                'active_callback' => function () {
                    return in_array(
                        get_theme_mod( 'header_type' ), [ 'grocery' ] 
                    ); 
                }
            ] );

            $wp_customize->selective_refresh->add_partial( 'header_social_menu', [
                'fallback_refresh'    => true
            ] );

            $wp_customize->add_setting( 'header_social_menu_title', [
                'default'           => esc_html__( 'Follow us', 'cartzilla' ),
                'transport'         => 'postMessage',
                'sanitize_callback' => 'sanitize_text_field',
            ] );

            $wp_customize->add_control( 'header_social_menu_title', [
                'type'            => 'text',
                'section'         => 'cartzilla_header_general',
                'label'           => esc_html__( 'Social Menu Title', 'cartzilla' ),
                'description'     => esc_html__( 'This setting allows you to change "Follow us" word to something else.', 'cartzilla' ),
                'active_callback' => function () {
                    return in_array(
                        get_theme_mod( 'header_type' ), [ 'grocery' ] 
                    ); 
                }
            ] );

            $wp_customize->selective_refresh->add_partial( 'header_social_menu_title', [
                'fallback_refresh'    => true
            ] );

            $wp_customize->add_setting( 'button_url', [
                'default'           => '#',
                'sanitize_callback' => 'esc_url_raw',
            ] );

            $wp_customize->add_control( 'button_url', [
                'type'            => 'url',
                'section'         => 'cartzilla_header_general',
                'label'           => esc_html__( 'Button Link', 'cartzilla' ),
                'description'     => esc_html__( 'This setting allows you to change the button link', 'cartzilla' ),
                'active_callback' => function () {
                    return in_array(
                        get_theme_mod( 'header_type' ), [ 'with-button' ] 
                    ); 
                }
            ] );

            $wp_customize->selective_refresh->add_partial( 'button_url', [
                'fallback_refresh'    => true
            ] );

            $wp_customize->add_setting( 'button_text', [
                'default'           => esc_html__( 'Buy Now', 'cartzilla' ),
                'sanitize_callback' => 'sanitize_key',
            ] );

            $wp_customize->add_control( 'button_text', [
                'type'            => 'text',
                'section'         => 'cartzilla_header_general',
                'label'           => esc_html__( 'Button Text', 'cartzilla' ),
                'description'     => esc_html__( 'This setting allows you to change the button text', 'cartzilla' ),
                'active_callback' => function () {
                    return in_array(
                        get_theme_mod( 'header_type' ), [ 'with-button' ] 
                    ); 
                }
            ] );

            $wp_customize->selective_refresh->add_partial( 'button_text', [
                'fallback_refresh'    => true
            ] );

            $wp_customize->add_setting( 'enable_button_icon', [
                'default'           => 'yes',
                'sanitize_callback' => 'sanitize_key',
            ] );

            $wp_customize->add_control( 'enable_button_icon', [
                'type'        => 'radio',
                'section'     => 'cartzilla_header_general',
                'label'       => esc_html__( 'Enable Button Icon', 'cartzilla' ),
                'description' => esc_html__( 'This setting allows you to show or hide button icon in Header.', 'cartzilla' ),
                'choices'     => [
                    'yes' => esc_html__( 'Yes', 'cartzilla' ),
                    'no'  => esc_html__( 'No', 'cartzilla' ),
                ],
                'active_callback' => function () {
                    return in_array(
                        get_theme_mod( 'header_type' ), [ 'with-button' ] 
                    ); 
                }
            ] );

            $wp_customize->selective_refresh->add_partial( 'enable_button_icon', [
                'fallback_refresh'    => true
            ] );

            $wp_customize->add_setting( 'button_icon', [
                'default'           => esc_html__( 'czi-cart', 'cartzilla' ),
                'transport'         => 'postMessage',
                'sanitize_callback' => 'sanitize_text_field',
            ] );

            $wp_customize->add_control( 'button_icon', [
                'type'        => 'text',
                'section'     => 'cartzilla_header_general',
                'label'       => esc_html__( 'Enter Button Icon', 'cartzilla' ),
                'description' => esc_html__( 'This setting allows you to enter the button icon.', 'cartzilla' ),
                'active_callback' => function () {
                    return in_array(
                        get_theme_mod( 'header_type' ), [ 'with-button' ] 
                    ) && 'yes' === get_theme_mod( 'enable_button_icon', 'yes' ); 
                }
            ] );

            $wp_customize->selective_refresh->add_partial( 'button_icon', [
                'fallback_refresh'    => true
            ] );
        }

        private function add_header_topbar_section( $wp_customize ) {
            $wp_customize->add_section( 'cartzilla_header_topbar', [
                'title'           => esc_html__( 'Topbar', 'cartzilla' ),
                'description'     => esc_html__( 'Contains topbar settings for customization.', 'cartzilla' ),
                'panel'           => 'cartzilla_header',
                'active_callback' => function ( WP_Customize_Section $section ) {
                    return in_array( get_theme_mod( 'header_type' ), [
                        '2-level-light',
                        '2-level-dark',
                        '3-level-light',
                        '3-level-dark',
                        'electronics-store',
                    ] );
                }
            ] );

            $wp_customize->add_setting( 'topbar_skin', [
                'default'           => 'dark',
                'sanitize_callback' => 'sanitize_key',
            ] );

            $wp_customize->add_control( 'topbar_skin', [
                'type'        => 'select',
                'section'     => 'cartzilla_header_topbar',
                'label'       => esc_html__( 'Skin', 'cartzilla' ),
                'description' => esc_html__( 'This setting allows you to choose your topbar skin.', 'cartzilla' ),
                'choices'     => [
                    'light' => esc_html__( 'Light', 'cartzilla' ),
                    'dark'  => esc_html__( 'Dark', 'cartzilla' ),
                ],
            ] );

            // Contact information
            $wp_customize->add_setting( 'topbar_contacts', [
                'transport'         => 'postMessage',
                'sanitize_callback' => 'wp_kses_post',
            ] );

            $wp_customize->add_control( 'topbar_contacts', [
                'type'        => 'textarea',
                'section'     => 'cartzilla_header_topbar',
                'label'       => esc_html__( 'Contact Information', 'cartzilla' ),
                'description' => esc_html__( 'This text will appear on the left side of the topbar line. HTML is allowed.', 'cartzilla' ),
            ] );

            $wp_customize->selective_refresh->add_partial( 'topbar_contacts', [
                'selector'        => '[data-cz-customizer="topbar_contacts"]',
                'render_callback' => function () {
                    return wp_kses_post( get_theme_mod( 'topbar_contacts' ) );
                },
            ] );

            $wp_customize->add_setting( 'topbar_promo', [
                'transport'         => 'postMessage',
                'sanitize_callback' => 'sanitize_textarea_field',
            ] );

            $wp_customize->add_control( 'topbar_promo', [
                'type'        => 'textarea',
                'section'     => 'cartzilla_header_topbar',
                'label'       => esc_html__( 'Promo', 'cartzilla' ),
                'description' => esc_html__(
                    'This setting allows you to add a promo line (or several). If you separate messages with a newline
                    symbol (just press enter) this section will be converted into a slider. This setting accepts HTML, too.
                    It will appear in the middle of topbar on desktop and will be hidden on mobile.',
                    'cartzilla'
                ),
                'input_attrs' => [
                    /* translators: just a placeholder for Topbar Promo setting */
                    'placeholder' => esc_html__( 'Free shipping for order over $200', 'cartzilla' ),
                ],
                'active_callback' => function () {
                    return in_array( get_theme_mod( 'header_type' ), [
                        '2-level-light',
                        '2-level-dark',
                        '3-level-light',
                        '3-level-dark',
                    ] );
                }
            ] );

            $wp_customize->selective_refresh->add_partial( 'topbar_promo', [
                'selector'            => '.topbar-promo',
                'container_inclusive' => true,
                'render_callback'     => function() {
                    cartzilla_topbar_promo();
                }
            ] );

            $wp_customize->add_setting( 'enable_topbar_language_currency', [
                'default'           => 'no',
                'sanitize_callback' => 'sanitize_key',
            ] );

            $wp_customize->add_control( 'enable_topbar_language_currency', [
                'type'        => 'radio',
                'section'     => 'cartzilla_header_topbar',
                'label'       => esc_html__( 'Enable Language Currency', 'cartzilla' ),
                'description' => esc_html__( 'This setting allows you to show or hide language currency in Header.', 'cartzilla' ),
                'choices'     => [
                    'yes' => esc_html__( 'Yes', 'cartzilla' ),
                    'no'  => esc_html__( 'No', 'cartzilla' ),
                ],
            ] );
            $wp_customize->selective_refresh->add_partial( 'enable_topbar_language_currency', [
                'fallback_refresh'    => true
            ] );

            // Handheld Dropdown
            $wp_customize->add_setting( 'topbar_handheld_dropdown_title', [
                'default'           => esc_html__( 'Useful links', 'cartzilla' ),
                'transport'         => 'postMessage',
                'sanitize_callback' => 'sanitize_textarea_field',
            ] );

            $wp_customize->add_control( 'topbar_handheld_dropdown_title', [
                'type'        => 'text',
                'section'     => 'cartzilla_header_topbar',
                'label'       => esc_html__( 'Topbar Handheld Dropdown Title', 'cartzilla' ),
                'description' => esc_html__( 'This setting allows you to add a dropdown title.
                    It will appear in the left of topbar on mobile and will be hidden on desktop.', 'cartzilla' ),
            ] );

            $wp_customize->selective_refresh->add_partial( 'topbar_handheld_dropdown_title', [
                'selector'        => '[data-cz-customizer="topbar_handheld_dropdown"]',
                'render_callback' => function () {
                    topbar_handheld_dropdown();
                },
            ] );
        }

        private function add_header_navbar_section( $wp_customize ) {
            $wp_customize->add_section( 'cartzilla_header_navbar', [
                'title'       => esc_html__( 'Navbar', 'cartzilla' ),
                'description' => esc_html__( 'Contains navbar settings for customization.', 'cartzilla' ),
                'panel'       => 'cartzilla_header',
            ] );

            $wp_customize->add_setting( 'navbar_is_search', [
                'default'           => 'yes',
                'sanitize_callback' => 'sanitize_key',
            ] );

            $wp_customize->add_control( 'navbar_is_search', [
                'type'        => 'radio',
                'section'     => 'cartzilla_header_navbar',
                'priority'    => 15,
                'label'       => esc_html__( 'Show search?', 'cartzilla' ),
                'description' => esc_html__( 'This setting allows you to show or hide a search in navbar.', 'cartzilla' ),
                'choices'     => [
                    'yes' => esc_html__( 'Yes', 'cartzilla' ),
                    'no'  => esc_html__( 'No', 'cartzilla' ),
                ],
                'active_callback' => function () {
                    return in_array( get_theme_mod( 'header_type' ), [
                        '1-level-light',
                        '1-level-dark',
                        '2-level-light',
                        '2-level-dark',
                        '3-level-light',
                        '3-level-dark',
                        'electronics-store',
                        'marketplace',
                        'grocery',
                    ] );
                }
            ] );

            $wp_customize->add_setting( 'navbar_search_is_category_dropdown', [
                'default'           => 'yes',
                'sanitize_callback' => 'sanitize_key',
            ] );

            $wp_customize->add_control( 'navbar_search_is_category_dropdown', [
                'type'        => 'radio',
                'section'     => 'cartzilla_header_navbar',
                'priority'    => 15,
                'label'       => esc_html__( 'Show Category Dropdown?', 'cartzilla' ),
                'description' => esc_html__( 'This setting allows you to show or hide a category dropdown in navbar search.', 'cartzilla' ),
                'choices'     => [
                    'yes' => esc_html__( 'Yes', 'cartzilla' ),
                    'no'  => esc_html__( 'No', 'cartzilla' ),
                ],
                'active_callback' => function () {
                    return in_array(
                        get_theme_mod( 'header_type' ), ['electronics-store'] 
                    ) && 'yes' === get_theme_mod( 'navbar_is_search', 'yes' );
                }
            ] );
        }

        private function add_header_navigation_section( $wp_customize ) {
            $wp_customize->add_section( 'cartzilla_header_navigation', [
                'title'       => esc_html__( 'Navigation', 'cartzilla' ),
                'description' => esc_html__( 'Contains all navigational links used across the theme.', 'cartzilla' ),
                'panel'       => 'cartzilla_header',
            ] );

            $wp_customize->add_setting( 'is_departments_menu', [
                'default'           => 'yes',
                'sanitize_callback' => 'sanitize_key',
            ] );

            $wp_customize->add_control( 'is_departments_menu', [
                'type'            => 'radio',
                'section'         => 'cartzilla_header_navigation',
                'priority'        => 10,
                'label'           => esc_html__( 'Show "Departments" (categories) menu?', 'cartzilla' ),
                'description'     => esc_html__(
                    'This setting allows you to control the visibility of a special menu location called "Departments". Uncheck the box to hide the menu completely.',
                    'cartzilla'
                ),
                'choices'         => [
                    'yes' => esc_html__( 'Yes', 'cartzilla' ),
                    'no'  => esc_html__( 'No', 'cartzilla' ),
                ],
                'active_callback' => function () {
                    return in_array( get_theme_mod( 'header_type' ), [
                        '3-level-light',
                        '3-level-dark',
                        'electronics-store',
                        'marketplace',
                    ] );
                }
            ] );

            $wp_customize->add_setting( 'departments_menu_title', [
                /* translators: default value for "departments_title" setting in Customizer */
                'default'           => esc_html__( 'Departments', 'cartzilla' ),
                'transport'         => 'postMessage',
                'sanitize_callback' => 'sanitize_text_field',
            ] );

            $wp_customize->add_control( 'departments_menu_title', [
                'type'            => 'text',
                'section'         => 'cartzilla_header_navigation',
                'priority'        => 15,
                'label'           => esc_html__( '"Departments" title', 'cartzilla' ),
                'description'     => esc_html__( 'This setting allows you to change "Departments" word to something else.', 'cartzilla' ),
                'active_callback' => function () {
                    $is_suitable_header = in_array( get_theme_mod( 'header_type' ), [ '3-level-light', '3-level-dark', 'electronics-store', 'marketplace', 'grocery'  ] );
                    $is_menu_visible    = 'yes' === get_theme_mod( 'is_departments_menu' );

                    return $is_suitable_header && $is_menu_visible;
                }
            ] );

            $wp_customize->selective_refresh->add_partial( 'departments_menu_title', array(
                'selector'        => '[data-cz-customizer="departments_title"]',
                'render_callback' => function () {
                    return esc_html( get_theme_mod( 'departments_menu_title' ) );
                },
            ) );

            $wp_customize->add_setting( 'departments_menu_icon_class', [
                /* translators: default value for "departments_title" setting in Customizer */
                'default'           => esc_html__( 'Departments', 'cartzilla' ),
                'transport'         => 'postMessage',
                'sanitize_callback' => 'sanitize_text_field',
            ] );

            $wp_customize->add_control( 'departments_menu_icon_class', [
                'type'            => 'text',
                'section'         => 'cartzilla_header_navigation',
                'priority'        => 15,
                'label'           => esc_html__( '"Departments" Icon Class', 'cartzilla' ),
                'description'     => esc_html__( 'This setting allows you to change Departments menu icon word to something else.', 'cartzilla' ),
                'active_callback' => function () {
                    $is_suitable_header = in_array( get_theme_mod( 'header_type' ), [ '3-level-light', '3-level-dark', 'electronics-store', 'marketplace' ] );
                    $is_menu_visible    = 'yes' === get_theme_mod( 'is_departments_menu' );

                    return $is_suitable_header && $is_menu_visible;
                }
            ] );
        }

        /**
         * Customize site footer
         *
         * @param WP_Customize_Manager $wp_customize Theme Customizer object.
         */
        public function customize_footer( $wp_customize ) {
            $wp_customize->add_panel( 'cartzilla_footer', [
                'title'              => esc_html__( 'Footer', 'cartzilla' ),
                'description'        => esc_html__(
                    'Footer is divided into two section: top section and bottom one. The top section contains the widgets
                    areas and divided into three columns. The bottom section can be customized here. Also you may find one
                    menu location in bottom section.',
                    'cartzilla'
                ),
                'priority'           => 30,
                'description_hidden' => false,
            ] );

            $this->add_footer_general_section( $wp_customize );
        }

        private function add_footer_general_section( $wp_customize ) {
            $wp_customize->add_section( 'cartzilla_footer_general', [
                /* translators: title of section in Customizer */
                'title'       => esc_html__( 'General', 'cartzilla' ),
                'description' => esc_html__( 'Contains general settings for footer customization.', 'cartzilla' ),
                'panel'       => 'cartzilla_footer',
            ] );

            $wp_customize->add_setting( 'footer_version', [
                'default'           => 'v1',
                'sanitize_callback' => 'sanitize_key',
            ] );

            $wp_customize->add_control( 'footer_version', [
                'type'        => 'select',
                'section'     => 'cartzilla_footer_general',
                'label'       => esc_html__( 'Version', 'cartzilla' ),
                'description' => esc_html__( 'This setting allows you to choose the desired version of footer.', 'cartzilla' ),
                'choices'     => [
                    'v1'  => esc_html__( 'Footer v1', 'cartzilla' ),
                    'v2'  => esc_html__( 'Footer v2', 'cartzilla' ),
                    'v3'  => esc_html__( 'Footer v3', 'cartzilla' ),
                    'v4'  => esc_html__( 'Footer v4', 'cartzilla' ),
                ],
            ] );

            $wp_customize->add_setting( 'footer_type', [
                'default'           => 'dark',
                'sanitize_callback' => 'sanitize_key',
            ] );

            $wp_customize->add_control( 'footer_type', [
                'type'        => 'select',
                'section'     => 'cartzilla_footer_general',
                'label'       => esc_html__( 'Footer Type', 'cartzilla' ),
                'description' => esc_html__( 'This setting allows you to choose the desired type of footer.', 'cartzilla' ),
                'choices'     => [
                    /* translators: type of footer (related to setting in Customizer) */
                    'light' => esc_html__( 'Light', 'cartzilla' ),
                    /* translators: type of footer (related to setting in Customizer) */
                    'dark'  => esc_html__( 'Dark', 'cartzilla' ),
                ],
                'active_callback' => function () {
                    return in_array(
                        get_theme_mod( 'footer_version' ), [ 'v1', 'v2', 'v3' ] 
                    );
                }
            ] );

            $wp_customize->add_setting(
                'cartzilla_footer_jumbotron', array(
                    'capability' => 'edit_theme_options',
                    'sanitize_callback' => 'absint',
                )
            );

            $wp_customize->add_control(
                'cartzilla_footer_jumbotron', array(
                    'section'     => 'cartzilla_footer_general',
                    'label'       => esc_html__( 'Footer Jumbotron', 'cartzilla' ),
                    'description' => esc_html__( 'Choose a static block that will be the jumbotron element for footer', 'cartzilla' ),
                    'type'        => 'select',
                    'choices'     => static_content_options(),
                    'active_callback' => function () {
                        return in_array(
                            get_theme_mod( 'footer_version' ), [ 'v1', 'v3' ] 
                        );
                    }
                )
            );

            $wp_customize->add_setting( 'enable_footer_language_currency', [
                'default'           => 'no',
                'sanitize_callback' => 'sanitize_key',
            ] );

            $wp_customize->add_control( 'enable_footer_language_currency', [
                'type'        => 'radio',
                'section'     => 'cartzilla_footer_general',
                'label'       => esc_html__( 'Enable Language Currency', 'cartzilla' ),
                'description' => esc_html__( 'This setting allows you to show or hide language currency in Footer.', 'cartzilla' ),
                'choices'     => [
                    'yes' => esc_html__( 'Yes', 'cartzilla' ),
                    'no'  => esc_html__( 'No', 'cartzilla' ),
                ],
                'active_callback' => function () {
                    return in_array(
                        get_theme_mod( 'footer_version' ), [ 'v1', 'v2' ] 
                    );
                }
            ] );

            $wp_customize->selective_refresh->add_partial( 'enable_footer_language_currency', [
                'fallback_refresh'    => true
            ] );

            $wp_customize->add_setting( 'footer_payment_methods', [
                'transport'         => 'postMessage',
                'sanitize_callback' => 'absint',
            ] );

            $wp_customize->add_control( new WP_Customize_Media_Control( $wp_customize, 'footer_payment_methods', [
                'section'     => 'cartzilla_footer_general',
                /* translators: label field for setting in Customizer */
                'label'       => esc_html__( 'Payment Methods', 'cartzilla' ),
                /* translators: description field for "Payment Methods" setting in Customizer */
                'description' => esc_html__(
                    'This setting allows you to upload an image with available payment methods or anything you want.
                    This image as well as site logos is optimized for retina displays, so the original image size should
                    be twice as big as the final image that appears on the website.',
                    'cartzilla'
                ),
                'mime_type'   => 'image',
                'active_callback' => function () {
                    return in_array( get_theme_mod( 'footer_version' ), [ 'v1', 'v2' ] );
                }
            ] ) );

            $wp_customize->selective_refresh->add_partial( 'footer_payment_methods', [
                'selector'            => '.payment-methods',
                'container_inclusive' => true,
                'render_callback'     => 'cartzilla_get_footer_pm',
            ] );

            $wp_customize->add_setting( 'footer_site_title', [
                /* translators: default value for "departments_title" setting in Customizer */
                'default'           => esc_html__( 'Marketplace', 'cartzilla' ),
                'transport'         => 'postMessage',
                'sanitize_callback' => 'sanitize_text_field',
            ] );

            $wp_customize->add_control( 'footer_site_title', [
                'type'            => 'text',
                'section'         => 'cartzilla_footer_general',
                'label'           => esc_html__( 'Footer Site Title', 'cartzilla' ),
                'description'     => esc_html__( 'This setting allows you to change footer site title to something else.', 'cartzilla' ),
                'active_callback' => function () {
                    return in_array( get_theme_mod( 'footer_version' ), [ 'v3' ] );
                }
            ] );

            $wp_customize->selective_refresh->add_partial( 'footer_site_title', [
                'fallback_refresh'    => true
            ] );

            $wp_customize->add_setting( 'footer_site_desc', [
                /* translators: default value for "departments_title" setting in Customizer */
                'default'           => esc_html__( 'High quality items created by our global community.', 'cartzilla' ),
                'transport'         => 'postMessage',
                'sanitize_callback' => 'sanitize_text_field',
            ] );

            $wp_customize->add_control( 'footer_site_desc', [
                'type'            => 'text',
                'section'         => 'cartzilla_footer_general',
                'label'           => esc_html__( 'Footer Site Description', 'cartzilla' ),
                'description'     => esc_html__( 'This setting allows you to change footer site desc to something else.', 'cartzilla' ),
                'active_callback' => function () {
                    return in_array( get_theme_mod( 'footer_version' ), [ 'v3' ] );
                }
            ] );

            $wp_customize->selective_refresh->add_partial( 'footer_site_desc', [
                'fallback_refresh'    => true
            ] );

            $wp_customize->add_setting( 'footer_statistics_enable', [
                'default'           => 'yes',
                'sanitize_callback' => 'sanitize_key',
            ] );

            $wp_customize->add_control( 'footer_statistics_enable', [
                'type'            => 'radio',
                'section'         => 'cartzilla_footer_general',
                'label'           => esc_html__( 'Show Footer Statistics?', 'cartzilla' ),
                'description'     => esc_html__(
                    'This setting allows you to control the visibility of a statistics on footer v3. Uncheck the box to hide the statistics completely.',
                    'cartzilla'
                ),
                'choices'         => [
                    'yes' => esc_html__( 'Yes', 'cartzilla' ),
                    'no'  => esc_html__( 'No', 'cartzilla' ),
                ],
                'active_callback' => function () {
                    return in_array( get_theme_mod( 'footer_version' ), [ 'v3' ] );
                }
            ] );

            $wp_customize->selective_refresh->add_partial( 'footer_statistics_enable', [
                'fallback_refresh'    => true
            ] );

            if ( cartzilla_is_copyright() ) {
                $wp_customize->add_setting( 'copyright', [
                    'transport'         => 'postMessage',
                    'sanitize_callback' => 'wp_kses_post',
                ] );
                $wp_customize->add_control( 'copyright', [
                    'type'        => 'textarea',
                    'section'     => 'cartzilla_footer_general',
                    /* translators: label field for setting in Customizer */
                    'label'       => esc_html__( 'Copyright', 'cartzilla' ),
                    /* translators: description field for "Copyright" setting in Customizer */
                    'description' => esc_html__( 'HTML is allowed in this field.', 'cartzilla' ),
                ] );
                $wp_customize->selective_refresh->add_partial( 'copyright', [
                    'selector'        => '.copyright',
                    'render_callback' => 'cartzilla_get_copyright',
                ] );

                $wp_customize->add_setting( 'copyright_alignment', [
                    'default'           => 'left',
                    'transport'         => 'postMessage',
                    'sanitize_callback' => 'sanitize_key',
                ] );
                $wp_customize->add_control( 'copyright_alignment', [
                    'type'        => 'select',
                    'section'     => 'cartzilla_footer_general',
                    /* translators: label field for setting in Customizer */
                    'label'       => esc_html__( 'Copyright Alignment', 'cartzilla' ),
                    'description' => esc_html__( 'This setting allows you to choose the copyright alignment', 'cartzilla' ),
                    'choices'     => [
                        /* translators: type of footer (related to setting in Customizer) */
                        'left' => esc_html__( 'Left', 'cartzilla' ),
                        /* translators: type of footer (related to setting in Customizer) */
                        'center'  => esc_html__( 'Center', 'cartzilla' ),
                    ],
                    'active_callback' => function () {
                        return in_array( get_theme_mod( 'footer_version' ), [ 'v1' ] );
                    }
                ] );

                $wp_customize->selective_refresh->add_partial( 'copyright_alignment', [
                    'fallback_refresh'    => true
                ] );
            }

            $wp_customize->add_setting( 'footer_widget_section_note', [
                'sanitize_callback' => 'sanitize_textarea_field',
            ] );
            $wp_customize->add_control( 'footer_widget_section_note', [
                'type'            => 'hidden',
                'section'         => 'cartzilla_footer_general',
                'active_callback' => function ( WP_Customize_Control $control ) {
                    return in_array( get_theme_mod( 'footer_type' ), [ 'light', 'dark' ] );
                },
                /* translators: label field for setting in Customizer */
                'label'           => esc_html__( 'Note', 'cartzilla' ),
                'description'     => wp_kses(
                    sprintf(
                    /* translators: %s: link to Widgets panel in Customizer  */
                        __( 'Top section is built with widgets. On Widgets screen you can find three sidebars
                            with names like "Footer Column 1" each represents one column and may contains one or more widgets.
                            Top section will appear as soon as you add your first widget (in any column).
                            <strong>Make sure you published your changes.</strong>
                            <p>Ready? <a href="%s">Add widgets to the footer columns</a>.</p>
                            <hr>',
                            'cartzilla'
                        ),
                        admin_url( '/widgets.php' )
                    ),
                    [
                        'strong' => true,
                        'br'     => true,
                        'hr'     => true,
                        'p'      => true,
                        'a'      => [ 'href' => true ],
                    ]
                ),
            ] );
        }

        /**
         * Customize site blog
         *
         * @param WP_Customize_Manager $wp_customize Theme Customizer object.
         */
        public function customize_blog( $wp_customize ) {
            $wp_customize->add_section( 'cartzilla_blog', [
                /* translators: title of section in Customizer */
                'title'       => esc_html__( 'Blog', 'cartzilla' ),
                'description' => esc_html__( 'This section contains settings related to posts listing archives and single post.', 'cartzilla' ),
                'priority'    => 30,
            ] );

            $this->add_blog_section( $wp_customize );
        }

        private function add_blog_section( $wp_customize ) {
            $wp_customize->add_setting( 'blog_title', [
                'sanitize_callback' => 'sanitize_text_field',
                'transport'         => 'postMessage',
            ] );
            $wp_customize->add_control( 'blog_title', [
                'section'     => 'cartzilla_blog',
                'type'        => 'text',
                /* translators: label field of setting responsible for keeping the page title of blog in posts listing (no Static Front Page). */
                'label'       => esc_html__( 'Blog Title', 'cartzilla' ),
                'description' => esc_html__(
                    'This title applicable for your home page (posts listing) when no Static Front Page used.
                    When you enable Static Front Page you must create a separate page for posts and the title
                    of that page will be in use if exists',
                    'cartzilla'
                ),
            ] );
            $wp_customize->selective_refresh->add_partial( 'blog_title', [
                'selector'        => '.page-title h1',
                'render_callback' => function () {
                    return esc_html( get_theme_mod( 'blog_title' ) );
                },
            ] );
            $wp_customize->add_setting( 'blog_title_background', [
                'default'           => 'light',
                'sanitize_callback' => 'sanitize_key',
            ] );
            $wp_customize->add_control( 'blog_title_background', [
                'type'        => 'select',
                'section'     => 'cartzilla_blog',
                'label'       => esc_html__( 'Blog Title Background', 'cartzilla' ),
                'description' => esc_html__( 'This setting allows you to choose the desired type of blog page title background.', 'cartzilla' ),
                'choices'     => [
                    /* translators: type of footer (related to setting in Customizer) */
                    'light' => esc_html__( 'Light', 'cartzilla' ),
                    /* translators: type of footer (related to setting in Customizer) */
                    'dark'  => esc_html__( 'Dark', 'cartzilla' ),
                ],
            ] );
            $wp_customize->add_setting( 'blog_layout', [
                'default'           => 'list',
                'sanitize_callback' => 'sanitize_key',
            ] );
            $wp_customize->add_control( 'blog_layout', [
                'type'        => 'select',
                'section'     => 'cartzilla_blog',
                /* translators: label field of control in Customizer */
                'label'       => esc_html__( 'Blog Layout', 'cartzilla' ),
                'description' => esc_html__( 'This setting affects both the posts listing (your blog page) and archives.', 'cartzilla' ),
                'choices'     => [
                    /* translators: single item in a list of Blog Layout choices (in Customizer) */
                    'grid'            => esc_html__( 'Grid', 'cartzilla' ),
                    /* translators: single item in a list of Blog Layout choices (in Customizer) */
                    'list'            => esc_html__( 'List', 'cartzilla' ),
                ],
            ] );
            $wp_customize->add_setting( 'blog_sidebar', [
                'default'           => 'right-sidebar',
                'sanitize_callback' => 'sanitize_key',
            ] );
            $wp_customize->add_control( 'blog_sidebar', [
                'type'        => 'select',
                'section'     => 'cartzilla_blog',
                /* translators: label field of control in Customizer */
                'label'       => esc_html__( 'Blog Sidebar', 'cartzilla' ),
                'description' => esc_html__( 'This setting affects both the posts listing (your blog page) and archives. This works when blog sidebar has widgets', 'cartzilla' ),
                'choices'     => [
                    'left-sidebar'  => esc_html__( 'Left Sidebar', 'cartzilla' ),
                    'right-sidebar' => esc_html__( 'Right Sidebar', 'cartzilla' ),
                    'no-sidebar'    => esc_html__( 'No Sidebar', 'cartzilla' ),
                ],
            ] );

            $wp_customize->add_setting( 'enable_popular_posts', [
                'default'           => 'no',
                'sanitize_callback' => 'sanitize_key',
            ] );
            $wp_customize->add_control( 'enable_popular_posts', [
                'type'            => 'radio',
                'section'         => 'cartzilla_blog',
                'label'           => esc_html__( 'Show Popular Post Carousel?', 'cartzilla' ),
                'description'     => esc_html__(
                    'This setting allows you to control the visibility of a popular post carousel on blog page. Uncheck the box to hide the popular post carousel completely.',
                    'cartzilla'
                ),
                'choices'         => [
                    'yes' => esc_html__( 'Yes', 'cartzilla' ),
                    'no'  => esc_html__( 'No', 'cartzilla' ),
                ],
            ] );
            $wp_customize->selective_refresh->add_partial( 'enable_popular_posts', [
                'fallback_refresh'    => true
            ] );

            $wp_customize->add_setting( 'blog_single_layout', [
                'default'           => 'right-sidebar',
                'sanitize_callback' => 'sanitize_key',
            ] );
            $wp_customize->add_control( 'blog_single_layout', [
                'type'        => 'select',
                'section'     => 'cartzilla_blog',
                /* translators: label field of control in Customizer */
                'label'       => esc_html__( 'Blog Single Sidebar', 'cartzilla' ),
                'description' => esc_html__( 'This setting affects single post page. This works when blog sidebar has widgets', 'cartzilla' ),
                'choices'     => [
                    'left-sidebar'  => esc_html__( 'Left Sidebar', 'cartzilla' ),
                    'right-sidebar' => esc_html__( 'Right Sidebar', 'cartzilla' ),
                    'no-sidebar'    => esc_html__( 'No Sidebar', 'cartzilla' ),
                ],
            ] );
        }

        /**
         * Customize site 404
         *
         * @param WP_Customize_Manager $wp_customize Theme Customizer object.
         */
        public function customize_404( $wp_customize ) {
            $wp_customize->add_section( 'cartzilla_404', [
                'title'    => '404',
                'priority' => 31,
            ] );

            $this->add_404_section( $wp_customize );
        }

        private function add_404_section( $wp_customize ) {
            $wp_customize->add_setting( '404_image', [
                'default'           => 0,
                'sanitize_callback' => 'absint',
            ] );
            $wp_customize->add_control( new WP_Customize_Media_Control( $wp_customize, '404_image', [
                'label'       => esc_html__( 'Upload an image', 'cartzilla' ),
                'description' => esc_html__( 'If you have a cool picture that you want to display on the 404 page you can upload it here.', 'cartzilla' ),
                'section'     => 'cartzilla_404',
                'mime_type'   => 'image',
            ] ) );
            $wp_customize->add_setting( '404_title', [
                'default'           => esc_html_x( '404', 'front-end', 'cartzilla' ),
                'sanitize_callback' => 'sanitize_text_field',
                'transport'         => 'postMessage',
            ] );
            $wp_customize->add_control( '404_title', [
                'type'            => 'text',
                'section'         => 'cartzilla_404',
                'label'           => esc_html__( '404 Title', 'cartzilla' ),
                'active_callback' => function () {
                    return (int) get_theme_mod( '404_image' ) <= 0;
                },
            ] );
            $wp_customize->selective_refresh->add_partial( '404_title', [
                'selector'        => '[data-cz-customizer="404_title"]',
                'render_callback' => function () {
                    return esc_html( get_theme_mod( '404_title' ) );
                },
            ] );
            $wp_customize->add_setting( '404_image_option', [
                'transport'         => 'postMessage',
                'sanitize_callback' => 'absint',
            ] );
            $wp_customize->add_control( new WP_Customize_Media_Control( $wp_customize, '404_image_option', [
                'section'     => 'cartzilla_404',
                'label'       => esc_html__( '404 Image Upload', 'cartzilla' ),
                'description' => esc_html__(
                    'This setting allows you to upload an image for 404 page.',
                    'cartzilla'
                ),
                'mime_type'   => 'image',
                'active_callback' => function() {
                    return (  get_theme_mod( '404_style' ) == 'style-v2' );
                }
            ] ) );
            $wp_customize->add_setting( '404_subtitle', [
                'default'           => esc_html_x( 'We can\'t seem to find the page you are looking for.', 'front-end', 'cartzilla' ),
                'sanitize_callback' => 'sanitize_text_field',
                'transport'         => 'postMessage',
            ] );
            $wp_customize->add_control( '404_subtitle', [
                'type'            => 'text',
                'section'         => 'cartzilla_404',
                'label'           => esc_html__( 'Subtitle', 'cartzilla' ),
                'active_callback' => function () {
                    return (int) get_theme_mod( '404_image' ) <= 0;
                },
            ] );
            $wp_customize->selective_refresh->add_partial( '404_subtitle', [
                'selector'        => '[data-cz-customizer="404_subtitle"]',
                'render_callback' => function () {
                    return esc_html( get_theme_mod( '404_subtitle' ) );
                },
            ] );
            $wp_customize->add_setting( '404_link_title', [
                'default'           => esc_html_x( 'Here are some helpful links instead:', 'front-end', 'cartzilla' ),
                'sanitize_callback' => 'sanitize_text_field',
                'transport'         => 'postMessage',
            ] );
            $wp_customize->add_control( '404_link_title', [
                'type'            => 'text',
                'section'         => 'cartzilla_404',
                'label'           => esc_html__( 'Link Title', 'cartzilla' ),
                'active_callback' => function () {
                    return (int) get_theme_mod( '404_image' ) <= 0;
                },
            ] );
            $wp_customize->selective_refresh->add_partial( '404_link_title', [
                'selector'        => '[data-cz-customizer="404_link_title"]',
                'render_callback' => function () {
                    return esc_html( get_theme_mod( '404_link_title' ) );
                },
            ] );
            $wp_customize->add_setting( '404_style', array(
                    'default'           => 'style-v1',
                    'sanitize_callback' => 'sanitize_key',
                    'transport'         => 'postMessage',
                )
            );

            $wp_customize->add_control( '404_style', array(
                    'type'        => 'select',
                    'section'     => 'cartzilla_404',
                    'label'       => esc_html__( '404 Style', 'cartzilla' ),
                    'description' => esc_html__( 'Select the style for 404 page', 'cartzilla' ),
                    'choices'     => [
                        'style-v1'            => esc_html__( '404 - Simple', 'cartzilla' ),
                        'style-v2'            => esc_html__( '404 - Illustration', 'cartzilla' ),
                    ],
                    'active_callback' => function () {
                        return (int) get_theme_mod( '404_image' ) <= 0;
                    },
                )
            );

            $wp_customize->selective_refresh->add_partial( '404_style', [
                'selector'        => '[data-cz-customizer="404_style"]',
                'render_callback' => function () {
                    return esc_attr( get_theme_mod( '404_style' ) );
                },
            ] );

            $wp_customize->add_setting( '404_button_color', [
                'default'           => 'primary',
                'sanitize_callback' => 'sanitize_key',
            ] );

            $wp_customize->add_control( '404_button_color', [
                'type'    => 'select',
                'section' => 'cartzilla_404',
                'label'   => esc_html__( '"Back to Home" button color', 'cartzilla' ),
                'choices' => [
                    'primary'   => esc_html_x( 'Primary', 'button', 'cartzilla' ),
                    'accent'    => esc_html_x( 'Accent', 'button', 'cartzilla' ),
                    'secondary' => esc_html_x( 'Secondary', 'button', 'cartzilla' ),
                    'success'   => esc_html_x( 'Success', 'button', 'cartzilla' ),
                    'danger'    => esc_html_x( 'Danger', 'button', 'cartzilla' ),
                    'warning'   => esc_html_x( 'Warning', 'button', 'cartzilla' ),
                    'info'      => esc_html_x( 'Info', 'button', 'cartzilla' ),
                    'dark'      => esc_html_x( 'Dark', 'button', 'cartzilla' ),
                ],
            ] );

            $wp_customize->add_setting( '404_enable_feature_lists', [
                'default'           => 'no',
                'sanitize_callback' => 'sanitize_key',
            ] );

            $wp_customize->add_control( '404_enable_feature_lists', [
                'type'            => 'radio',
                'section'         => 'cartzilla_404',
                'label'           => esc_html__( 'Show Feature Icon Lists?', 'cartzilla' ),
                'description'     => esc_html__(
                    'This setting allows you to control the visibility of a feature icons on 404 page.',
                    'cartzilla'
                ),
                'choices'         => [
                    'yes' => esc_html__( 'Yes', 'cartzilla' ),
                    'no'  => esc_html__( 'No', 'cartzilla' ),
                ],
            ] );

            $wp_customize->selective_refresh->add_partial( '404_enable_feature_lists', [
                'fallback_refresh'    => true
            ] );

            $wp_customize->add_setting( 'cz_404_homepage_link', [
                'transport'         => 'postMessage',
                'sanitize_callback' => 'esc_url_raw',
            ] );

            $wp_customize->add_control( 'cz_404_homepage_link', [
                'label'   => esc_html__( 'Homepage Link', 'cartzilla' ),
                'section' => 'cartzilla_404',
                'type'    => 'url',
                'active_callback' => function () {
                    return (int) get_theme_mod( '404_image' ) <= 0;
                },
            ] );

            $wp_customize->selective_refresh->add_partial(
                'cz_404_homepage_link', [
                'selector'        => '[data-cz-customizer="homepage_btn"]',
                'container_inclusive' => true,
                'render_callback' => function () {
                    return esc_url( get_theme_mod( 'cz_404_homepage_link' ) );
                },
            ] );

            $wp_customize->add_setting( 'cz_404_search_link', [
                'transport'         => 'postMessage',
                'sanitize_callback' => 'esc_url_raw',
            ] );

            $wp_customize->add_control( 'cz_404_search_link', [
                'label'   => esc_html__( 'Search Link', 'cartzilla' ),
                'section' => 'cartzilla_404',
                'type'    => 'url',
                'active_callback' => function () {
                    return (int) get_theme_mod( '404_image' ) <= 0;
                },
            ] );

            $wp_customize->selective_refresh->add_partial(
                'cz_404_search_link', [
                'selector'        => '[data-cz-customizer="search_btn"]',
                'container_inclusive' => true,
                'render_callback' => function () {
                    return esc_url( get_theme_mod( 'cz_404_search_link' ) );
                },
            ] );

            $wp_customize->add_setting( 'cz_404_support_link', [
                'transport'         => 'postMessage',
                'sanitize_callback' => 'esc_url_raw',
            ] );

            $wp_customize->add_control( 'cz_404_support_link', [
                'label'   => esc_html__( 'Healp & Support Link', 'cartzilla' ),
                'section' => 'cartzilla_404',
                'type'    => 'url',
                'active_callback' => function () {
                    return (int) get_theme_mod( '404_image' ) <= 0;
                },
            ] );

            $wp_customize->selective_refresh->add_partial(
                'cz_404_support_link', [
                'selector'        => '[data-cz-customizer="support_btn"]',
                'container_inclusive' => true,
                'render_callback' => function () {
                    return esc_url( get_theme_mod( 'cz_404_support_link' ) );
                },
            ] );
        }

        /**
         * Customize site Custom Theme Color
         *
         * @param WP_Customize_Manager $wp_customize Theme Customizer object.
         */
        public function customize_customcolor( $wp_customize ) {
            $wp_customize->add_section( 'cartzilla_customcolor', [
                'title'    => __( 'Custom Theme Color', 'cartzilla' ),
                'priority' => 200,
            ] );

            $this->add_customcolor_section( $wp_customize );
        }

        private function add_customcolor_section( $wp_customize ) {
            /**
             * Custom Color Enable / Disble Toggle
             */
            $wp_customize->add_setting( 'cartzilla_enable_custom_color', [
                'default'           => 'no',
                'sanitize_callback' => 'sanitize_key',
            ] );

            $wp_customize->add_control( 'cartzilla_enable_custom_color', [
                'type'        => 'radio',
                'section'     => 'cartzilla_customcolor',
                'label'       => esc_html__( 'Enable Custom Color?', 'cartzilla' ),
                'description' => esc_html__(
                    'This settings allow you to apply your custom color option.',
                    'cartzilla'
                ),
                'choices'     => [
                    'yes' => esc_html__( 'Yes', 'cartzilla' ),
                    'no'  => esc_html__( 'No', 'cartzilla' ),
                ],
            ] );

            /**
             * Primary Color
             */
            $wp_customize->add_setting(
                'cartzilla_primary_color', array(
                    'default'           => apply_filters( 'cartzilla_default_primary_color', '#fe696a' ),
                    'sanitize_callback' => 'sanitize_hex_color',
                )
            );
            $wp_customize->add_control(
                new WP_Customize_Color_Control(
                    $wp_customize, 'cartzilla_primary_color', array(
                        'label'    => __( 'Primary color', 'cartzilla' ),
                        'section'  => 'cartzilla_customcolor',
                        'settings' => 'cartzilla_primary_color',
                        'active_callback' => function () {
                            return get_theme_mod( 'cartzilla_enable_custom_color', 'no' ) === 'yes';
                        }
                    )
                )
            );

            /**
             * Accent Color
             */
            $wp_customize->add_setting(
                'cartzilla_accent_color', array(
                    'default'           => apply_filters( 'cartzilla_default_accent_color', '#4e54c8' ),
                    'sanitize_callback' => 'sanitize_hex_color',
                )
            );
            $wp_customize->add_control(
                new WP_Customize_Color_Control(
                    $wp_customize, 'cartzilla_accent_color', array(
                        'label'    => __( 'Accent color', 'cartzilla' ),
                        'section'  => 'cartzilla_customcolor',
                        'settings' => 'cartzilla_accent_color',
                        'active_callback' => function () {
                            return get_theme_mod( 'cartzilla_enable_custom_color', 'no' ) === 'yes';
                        }
                    )
                )
            );

            /**
             * Secondary Color
             */
            // $wp_customize->add_setting(
            //     'cartzilla_secondary_color', array(
            //         'default'           => apply_filters( 'cartzilla_default_secondary_color', '#f3f5f9' ),
            //         'sanitize_callback' => 'sanitize_hex_color',
            //     )
            // );
            // $wp_customize->add_control(
            //     new WP_Customize_Color_Control(
            //         $wp_customize, 'cartzilla_secondary_color', array(
            //             'label'    => __( 'Secondary color', 'cartzilla' ),
            //             'section'  => 'cartzilla_customcolor',
            //             'settings' => 'cartzilla_secondary_color',
            //             'active_callback' => function () {
            //                 return get_theme_mod( 'cartzilla_enable_custom_color', 'no' ) === 'yes';
            //             }
            //         )
            //     )
            // );

            /**
             * Dark Color
             */
            // $wp_customize->add_setting(
            //     'cartzilla_dark_color', array(
            //         'default'           => apply_filters( 'cartzilla_default_dark_color', '#373f50' ),
            //         'sanitize_callback' => 'sanitize_hex_color',
            //     )
            // );
            // $wp_customize->add_control(
            //     new WP_Customize_Color_Control(
            //         $wp_customize, 'cartzilla_dark_color', array(
            //             'label'    => __( 'Dark color', 'cartzilla' ),
            //             'section'  => 'cartzilla_customcolor',
            //             'settings' => 'cartzilla_dark_color',
            //             'active_callback' => function () {
            //                 return get_theme_mod( 'cartzilla_enable_custom_color', 'no' ) === 'yes';
            //             }
            //         )
            //     )
            // );
        }
    }
endif;

return new Cartzilla_Customizer();