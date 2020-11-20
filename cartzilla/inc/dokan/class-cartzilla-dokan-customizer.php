<?php
/**
 * Cartzilla Dokan Customizer Class
 *
 * @package  cartzilla
 * @since    1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

if ( ! class_exists( 'Cartzilla_Dokan_Customizer' ) ) {
    class Cartzilla_Dokan_Customizer extends Cartzilla_Customizer {

        /**
         * Setup class.
         *
         * @since 1.0.0
         * @return void
         */
        public function __construct() {
            add_action( 'customize_register', array( $this, 'customize_register' ), 10 );
        }

        /**
         * Add postMessage support for site title and description for the Theme Customizer along with several other settings.
         *
         * @param WP_Customize_Manager $wp_customize Theme Customizer object.
         * @since 2.4.0
         */
        public function customize_register( $wp_customize ) {
            /**
             * Woocommerce Page Title
             */
            $wp_customize->add_section( 'cartzilla_dokan_settings', array(
                'title'       => esc_html__( 'Dokan', 'cartzilla' ),
                'description' => esc_html__( 'This setting applicable for your Dokan pages', 'cartzilla' ),
                'priority'    => 999,
                'panel'       => 'woocommerce',
            ) );

            $wp_customize->add_setting( 'is_dokan_vendor_style_enabled', array(
                'default'           => 'yes',
                'sanitize_callback' => 'sanitize_key',
                'transport'         => 'postMessage',
            ) );

            $wp_customize->add_control( 'is_dokan_vendor_style_enabled', [
                'type'        => 'radio',
                'section'     => 'cartzilla_dokan_settings',
                'label'       => esc_html__( 'Enable Cartzilla Vendor Style ?', 'cartzilla' ),
                'description' => esc_html__( 'This setting allows you to control style of vendor page. Default is yes.', 'cartzilla' ),
                'choices'     => [
                    'yes' => esc_html__( 'Yes', 'cartzilla' ),
                    'no'  => esc_html__( 'No', 'cartzilla' ),
                ],
            ] );

            $wp_customize->selective_refresh->add_partial( 'is_dokan_vendor_style_enabled', [
                'fallback_refresh'    => true
            ] );
        }
    }
}

return new Cartzilla_Dokan_Customizer();