<?php
/**
 * Cartzilla WeDocs Customizer Class
 *
 * @package  cartzilla
 * @since    1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

if ( ! class_exists( 'Cartzilla_WeDocs_Customizer' ) ) :


    class Cartzilla_WeDocs_Customizer extends Cartzilla_Customizer {

        /**
         * Setup class.
         *
         * @since 1.0.0
         * @return void
         */
        public function __construct() {
            add_action( 'customize_register', array( $this, 'customize_register' ), 10 );
        }

        public function docs_tags() {
            $terms = get_terms( array(
                'taxonomy' => 'doc_tag',
                'hide_empty' => false,
            ) );

            $docs_tags = [];

            foreach($terms as $term ){
               $docs_tags[$term->term_id] = $term->name; 
            }
            return $docs_tags;
        }

        public function sanitize_docs_tags( $input ) {
            $valid = $this->docs_tags();

            foreach ($input as $value) {
                if ( !array_key_exists( $value, $valid ) ) {
                    return [];
                }
            }

            return $input;
        }

        /**
         * Add postMessage support for site title and description for the Theme Customizer along with several other settings.
         *
         * @param WP_Customize_Manager $wp_customize Theme Customizer object.
         * @since 2.4.0
         */
        public function customize_register( $wp_customize ) {
            /**
             * Helpcenter
             */
            $wp_customize->add_panel(
                'cartzilla_helpcenter',
                array(
                    'priority'       => 200,
                    'title'          => esc_html__( 'Helpcenter', 'cartzilla' ),
                )
            );

            $this->add_helpcenter_home_section( $wp_customize );
            $this->add_helpcenter_topic_section( $wp_customize );
            $this->add_helpcenter_article_section( $wp_customize );
            $this->add_helpcenter_action_section( $wp_customize );
        }

        /**
         * Helpcenter Section
         *
         * @param WP_Customize_Manager $wp_customize Theme Customizer object.
         */
        private function add_helpcenter_home_section( $wp_customize ) {
            $wp_customize->add_section(
                'cz_helpcenter_hero',
                array(
                    'title'    => esc_html__( 'Template Hero', 'cartzilla' ),
                    'priority' => 10,
                    'panel'    => 'cartzilla_helpcenter',
                )
            );

            $wp_customize->add_setting( 'cz_helpcenter_hero_disable', [
                'default'           => false,
                'sanitize_callback' => 'sanitize_key',
            ] );


            $wp_customize->add_control( 'cz_helpcenter_hero_disable', [
                'type'        => 'checkbox',
                'section'     => 'cz_helpcenter_hero',
                'label'       => esc_html__( 'Hide Hero', 'cartzilla' ),
                'description' => esc_html__( 'This setting allows you to hide hero block.', 'cartzilla' ),
            ] );


            $wp_customize->add_setting(
                'cz_helpcenter_hero_title',
                array(
                    'default'           => esc_html__( 'How can we help?', 'cartzilla' ),
                    'sanitize_callback' => 'wp_kses_post',
                    'transport'         => 'postMessage',
                )
            );

            $wp_customize->add_control(
                'cz_helpcenter_hero_title',
                array(
                    'label'       => esc_html__( 'Hero Title', 'cartzilla' ),
                    'section'     => 'cz_helpcenter_hero',
                    'settings'    => 'cz_helpcenter_hero_title',
                    'type'        => 'text',
                    'active_callback' => function() {
                        return (  get_theme_mod( 'cz_helpcenter_hero_disable' ) == false );
                    }
                )
            );

            $wp_customize->selective_refresh->add_partial( 'cz_helpcenter_hero_title', [
                'selector'        => '[data-cz-customizer="cz_helpcenter_hero_title"]',
                'render_callback' => function () {
                    return wp_kses_post( get_theme_mod( 'cz_helpcenter_hero_title' ) );
                },
            ] );

            $wp_customize->add_setting(
                'cz_helpcenter_hero_subtitle',
                array(
                    'default'           => esc_html__( 'Ask Questions. Browse Topics. Find Answers', 'cartzilla' ),
                    'sanitize_callback' => 'wp_kses_post',
                    'transport'         => 'postMessage',
                )
            );

            $wp_customize->add_control(
                'cz_helpcenter_hero_subtitle',
                array(
                    'label'       => esc_html__( 'Hero Subtitle', 'cartzilla' ),
                    'section'     => 'cz_helpcenter_hero',
                    'settings'    => 'cz_helpcenter_hero_subtitle',
                    'type'        => 'text',
                    'active_callback' => function() {
                        return (  get_theme_mod( 'cz_helpcenter_hero_disable' ) == false );
                    }
                )
            );

            $wp_customize->selective_refresh->add_partial( 'cz_helpcenter_hero_subtitle', [
                'selector'        => '[data-cz-customizer="cz_helpcenter_hero_subtitle"]',
                'render_callback' => function () {
                    return wp_kses_post( get_theme_mod( 'cz_helpcenter_hero_subtitle' ) );
                },
            ] );

            $wp_customize->add_setting(
                'cz_helpcenter_hero_tags',
                array(
                    'default'           => '',
                    'sanitize_callback' => array($this, 'sanitize_docs_tags'),
                    'transport'         => 'postMessage',
                )
            );


            $wp_customize->add_control( new Cartzilla_Customize_Control_Multiple_Select( $wp_customize, 'cz_helpcenter_hero_tags',
                
                array(
                    'label'       => esc_html__( 'Hero Tags', 'cartzilla' ),
                    'section'     => 'cz_helpcenter_hero',
                    'settings'    => 'cz_helpcenter_hero_tags',
                    'type'        => 'multiple-select',
                    'choices'     => $this->docs_tags(),
                    'active_callback' => function() {
                        return (  get_theme_mod( 'cz_helpcenter_hero_disable' ) == false );
                    }
                )
            ) );

            $wp_customize->add_setting(
                'cz_helpcenter_hero_bg',
                array(
                    'sanitize_callback' => 'absint',
                    'transport'         => 'postMessage',
                )
            );

            $wp_customize->add_control(
                new WP_Customize_Media_Control( $wp_customize, 'cz_helpcenter_hero_bg', [
                    'label'       => esc_html__( 'Hero Bg', 'cartzilla' ),
                    'description' => esc_html__( 'This setting allows you to upload an backgroundimage for hero', 'cartzilla' ),
                    'section'     => 'cz_helpcenter_hero',
                    'settings'    => 'cz_helpcenter_hero_bg',
                    'mime_type'   => 'image',
                    'active_callback' => function() {
                        return (  get_theme_mod( 'cz_helpcenter_hero_disable' ) == false );
                    }
            ] ) );
        }

        private function add_helpcenter_topic_section( $wp_customize ) {
            $wp_customize->add_section(
                'cz_helpcenter_topics',
                array(
                    'title'    => esc_html__( 'Template Topics', 'cartzilla' ),
                    'priority' => 10,
                    'panel'    => 'cartzilla_helpcenter',
                )
            );

            $wp_customize->add_setting( 'cz_helpcenter_topics_disable', [
                'default'           => false,
                'sanitize_callback' => 'sanitize_key',
            ] );


            $wp_customize->add_control( 'cz_helpcenter_topics_disable', [
                'type'        => 'checkbox',
                'section'     => 'cz_helpcenter_topics',
                'label'       => esc_html__( 'Hide Topics', 'cartzilla' ),
                'description' => esc_html__( 'This setting allows you to hide topics block.', 'cartzilla' ),
            ] );

            $wp_customize->add_setting(
                'cz_helpcenter_topic_title',
                array(
                    'default'           => esc_html__( 'Select a Topic', 'cartzilla' ),
                    'sanitize_callback' => 'wp_kses_post',
                    'transport'         => 'postMessage',
                )
            );

            $wp_customize->add_control(
                'cz_helpcenter_topic_title',
                array(
                    'label'       => esc_html__( 'Topics Title', 'cartzilla' ),
                    'section'     => 'cz_helpcenter_topics',
                    'settings'    => 'cz_helpcenter_topic_title',
                    'type'        => 'text',
                    'active_callback' => function() {
                        return (  get_theme_mod( 'cz_helpcenter_topics_disable' ) == false );
                    }
                )
            );

            $wp_customize->selective_refresh->add_partial( 'cz_helpcenter_topic_title', [
                'selector'        => '[data-cz-customizer="cz_helpcenter_topic_title"]',
                'render_callback' => function () {
                    return wp_kses_post( get_theme_mod( 'cz_helpcenter_topic_title' ) );
                },
            ] );

            $wp_customize->add_setting(
                'cz_helpcenter_topic_column',
                array(
                    'default'           => 3,
                    'sanitize_callback' => 'wp_kses_post',
                    'transport'         => 'postMessage',
                )
            );

            $wp_customize->add_control(
                'cz_helpcenter_topic_column',
                array(
                    'label'       => esc_html__( 'Topics Column', 'cartzilla' ),
                    'section'     => 'cz_helpcenter_topics',
                    'settings'    => 'cz_helpcenter_topic_column',
                    'type'        => 'number',
                    'input_attrs' => array(
                        'min'  => 2,
                        'max'  => 4,
                        'step' => 1,
                    ),
                    'active_callback' => function() {
                        return (  get_theme_mod( 'cz_helpcenter_topics_disable' ) == false );
                    }
                )
            );

            $wp_customize->add_setting(
                'cz_helpcenter_topic_count',
                array(
                    'default'           => 6,
                    'sanitize_callback' => 'absint',
                    'transport'         => 'postMessage',
                )
            );

            $wp_customize->add_control(
                'cz_helpcenter_topic_count',
                array(
                    'label'       => esc_html__( 'Rows', 'cartzilla' ),
                    'section'     => 'cz_helpcenter_topics',
                    'settings'    => 'cz_helpcenter_topic_count',
                    'type'        => 'number',
                    'input_attrs' => array(
                        'min'  => 1 ,
                        'max'  => 12,
                        'step' => 1,
                    ),
                    'active_callback' => function() {
                        return (  get_theme_mod( 'cz_helpcenter_topics_disable' ) == false );
                    }
                )
            );
        }

        private function add_helpcenter_article_section( $wp_customize ) {


            $wp_customize->add_section(
                'cz_helpcenter_articles',
                array(
                    'title'    => esc_html__( 'Template Articles', 'cartzilla' ),
                    'priority' => 10,
                    'panel'    => 'cartzilla_helpcenter',
                )
            );

            $wp_customize->add_setting( 'cz_helpcenter_articles_disable', [
                'default'           => false,
                'sanitize_callback' => 'sanitize_key',
            ] );


            $wp_customize->add_control( 'cz_helpcenter_articles_disable', [
                'type'        => 'checkbox',
                'section'     => 'cz_helpcenter_articles',
                'label'       => esc_html__( 'Hide articles', 'cartzilla' ),
                'description' => esc_html__( 'This setting allows you to hide articles block.', 'cartzilla' ),
            ] );

            $wp_customize->add_setting(
                'cz_helpcenter_article_title',
                array(
                    'default'           => esc_html__( 'Popular Articles', 'cartzilla' ),
                    'sanitize_callback' => 'wp_kses_post',
                    'transport'         => 'postMessage',
                )
            );

            $wp_customize->add_control(
                'cz_helpcenter_article_title',
                array(
                    'label'       => esc_html__( 'Articles Title', 'cartzilla' ),
                    'section'     => 'cz_helpcenter_articles',
                    'settings'    => 'cz_helpcenter_article_title',
                    'type'        => 'text',
                    'active_callback' => function() {
                        return (  get_theme_mod( 'cz_helpcenter_articles_disable' ) == false );
                    }
                )
            );

            $wp_customize->selective_refresh->add_partial( 'cz_helpcenter_article_title', [
                'selector'        => '[data-cz-customizer="cz_helpcenter_article_title"]',
                'render_callback' => function () {
                    return wp_kses_post( get_theme_mod( 'cz_helpcenter_article_title' ) );
                },
            ] );

            $wp_customize->add_setting(
                'cz_helpcenter_article_count',
                array(
                    'default'           => 10,
                    'sanitize_callback' => 'absint',
                    'transport'         => 'postMessage',
                )
            );

            $wp_customize->add_control(
                'cz_helpcenter_article_count',
                array(
                    'label'       => esc_html__( 'Article Count', 'cartzilla' ),
                    'section'     => 'cz_helpcenter_articles',
                    'settings'    => 'cz_helpcenter_article_count',
                    'type'        => 'number',
                    'input_attrs' => array(
                        'min'  => 1 ,
                        'max'  => 10,
                        'step' => 1,
                    ),
                    'active_callback' => function() {
                        return (  get_theme_mod( 'cz_helpcenter_articles_disable' ) == false );
                    }
                )
            );
        }

        private function add_helpcenter_action_section( $wp_customize ) {
            $wp_customize->add_section(
                'cz_helpcenter_action',
                array(
                    'title'    => esc_html__( 'Template Action', 'cartzilla' ),
                    'priority' => 20,
                    'panel'    => 'cartzilla_helpcenter',
                )
            );

            $wp_customize->add_setting( 'cz_helpcenter_action_disable', [
                'default'           => false,
                'sanitize_callback' => 'sanitize_key',
            ] );


            $wp_customize->add_control( 'cz_helpcenter_action_disable', [
                'type'        => 'checkbox',
                'section'     => 'cz_helpcenter_action',
                'label'       => esc_html__( 'Hide Action', 'cartzilla' ),
                'description' => esc_html__( 'This setting allows you to hide action block.', 'cartzilla' ),
            ] );

            $wp_customize->add_setting(
                'cz_helpcenter_action_title',
                array(
                    'transport'         => 'postMessage',
                    'sanitize_callback' => 'wp_kses_post',
                    'default'           => esc_html__( "Haven't found the answer? We can help.", 'cartzilla' ),
                )
            );

            $wp_customize->add_control(
                'cz_helpcenter_action_title',
                array(
                    'label'       => esc_html__( 'Action Title', 'cartzilla' ),
                    'section'     => 'cz_helpcenter_action',
                    'settings'    => 'cz_helpcenter_action_title',
                    'type'        => 'text',
                    'active_callback' => function() {
                        return (  get_theme_mod( 'cz_helpcenter_action_disable' ) == false );
                    }
                )
            );

            $wp_customize->selective_refresh->add_partial(
                'cz_helpcenter_action_title', [
                'selector'        => '[data-cz-customizer="action_title"]',
                'render_callback' => function () {
                    return wp_kses_post( get_theme_mod( 'cz_helpcenter_action_title' ) );
                },
            ] );

            $wp_customize->add_setting( 'cz_helpcenter_action_icon_class', [
                'default'           => esc_html__( "czi-help", 'cartzilla' ),
                'transport'         => 'postMessage',
                'sanitize_callback' => 'esc_attr',
            ] );
            $wp_customize->add_control( 'cz_helpcenter_action_icon_class', [
                'label'   => esc_html__( 'Icon Class', 'cartzilla' ),
                'section' => 'cz_helpcenter_action',
                'type'    => 'text',
                'active_callback' => function() {
                    return (  get_theme_mod( 'cz_helpcenter_action_disable' ) == false );
                }
            ] );

            $wp_customize->selective_refresh->add_partial(
                'cz_helpcenter_action_icon_class', [
                'selector'        => '[data-cz-customizer="action_iconclass"]',
                'container_inclusive' => true,
                'render_callback' => function () {
                    return esc_attr( get_theme_mod( 'cz_helpcenter_action_icon_class' ) );
                },
            ] );

            $wp_customize->add_setting(
                'cz_helpcenter_action_btntext',
                array(
                    'transport'         => 'postMessage',
                    'sanitize_callback' => 'wp_kses_post',
                    'default'           => esc_html__( "Submit a request", 'cartzilla' ),
                )
            );

            $wp_customize->add_control(
                'cz_helpcenter_action_btntext',
                array(
                    'label'       => esc_html__( 'Action link Text', 'cartzilla' ),
                    'section'     => 'cz_helpcenter_action',
                    'settings'    => 'cz_helpcenter_action_btntext',
                    'type'        => 'text',
                    'active_callback' => function() {
                        return (  get_theme_mod( 'cz_helpcenter_action_disable' ) == false );
                    }
                )
            );

            $wp_customize->selective_refresh->add_partial(
                'cz_helpcenter_action_btntext', [
                'selector'        => '[data-cz-customizer="action_btntext"]',
                'render_callback' => function () {
                    return esc_url( get_theme_mod( 'cz_helpcenter_action_btntext' ) );
                },

            ] );

            $wp_customize->add_setting(
                'cz_helpcenter_action_subtitle',
                array(
                    'transport'         => 'postMessage',
                    'sanitize_callback' => 'wp_kses_post',
                    'default'           => esc_html__( "Contact us and we'll get back to you as soon as possible.", 'cartzilla' ),
                )
            );

            $wp_customize->add_control(
                'cz_helpcenter_action_subtitle',
                array(
                    'label'       => esc_html__( 'Action Sub Title', 'cartzilla' ),
                    'section'     => 'cz_helpcenter_action',
                    'settings'    => 'cz_helpcenter_action_subtitle',
                    'type'        => 'text',
                    'active_callback' => function() {
                        return (  get_theme_mod( 'cz_helpcenter_action_disable' ) == false );
                    }
                )
            );

            $wp_customize->selective_refresh->add_partial(
                'cz_helpcenter_action_subtitle', [
                'selector'        => '[data-cz-customizer="action_subtitle"]',
                'render_callback' => function () {
                    return wp_kses_post( get_theme_mod( 'cz_helpcenter_action_subtitle' ) );
                },
            ] );

            $wp_customize->add_setting( 'cz_helpcenter_action_link', [
                'transport'         => 'postMessage',
                'sanitize_callback' => 'esc_url_raw',
            ] );

            $wp_customize->add_control( 'cz_helpcenter_action_link', [
                'label'   => esc_html__( 'Button text Url ', 'cartzilla' ),
                'section' => 'cz_helpcenter_action',
                'settings'    => 'cz_helpcenter_action_link',
                'type'    => 'url',
                'active_callback' => function() {
                    return (  get_theme_mod( 'cz_helpcenter_action_is_modal' ) == false );
                }
            ] );

            $wp_customize->selective_refresh->add_partial(
                'cz_helpcenter_action_link', [
                'selector'        => '[data-cz-customizer="action_btn"]',
                'container_inclusive' => true,
                'render_callback' => function () {
                    return esc_url( get_theme_mod( 'cz_helpcenter_action_link' ) );
                },
            ] );

            $wp_customize->add_setting( 'cz_helpcenter_action_is_modal', [
                'default'           => true,
                'sanitize_callback' => 'sanitize_key',
            ] );
            $wp_customize->add_control( 'cz_helpcenter_action_is_modal', [
                'type'        => 'checkbox',
                'section'     => 'cz_helpcenter_action',
                'label'       => esc_html__( 'Is modal enable?', 'cartzilla' ),
                'description' => esc_html__( 'This setting allows you to add custom url.', 'cartzilla' ),
                'active_callback' => function() {
                        return (  get_theme_mod( 'cz_helpcenter_action_disable' ) == false );
                    }
            ] );
        }
    }

endif;

return new Cartzilla_WeDocs_Customizer();