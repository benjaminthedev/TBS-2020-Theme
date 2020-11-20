<?php
/**
 * Cartzilla Class
 *
 * @since    1.0.0
 * @package  cartzilla
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Cartzilla' ) ) :

	/**
	 * The main Cartzilla class
	 */
	class Cartzilla {

		/**
		 * Setup class.
		 *
		 * @since 1.0
		 */
		public function __construct() {
			add_action( 'after_setup_theme', array( $this, 'content_width' ), 0 );
			add_action( 'after_setup_theme', array( $this, 'setup' ) );
			add_action( 'widgets_init', array( $this, 'widgets_init' ) );
			add_action( 'wp_enqueue_scripts', array( $this, 'scripts' ), 10 );
			add_action( 'wp_enqueue_scripts', array( $this, 'child_scripts' ), 30 ); // After WooCommerce.
			add_action( 'admin_enqueue_scripts', array( $this, 'admin_assets' ), 20 );
			add_filter( 'body_class', array( $this, 'body_classes' ) );
			add_filter( 'wp_page_menu_args', array( $this, 'page_menu_args' ) );
			// TODO: Analyse and remove
			add_action( 'enqueue_block_editor_assets', array( $this, 'block_editor_assets' ) );
			add_action( 'admin_menu', array( $this, 'admin_pages' ) );
			add_filter( 'mce_buttons_2', array( $this, 'classic_editor_buttons' ) );
			add_filter( 'tiny_mce_before_init', array( $this, 'classic_editor_formats' ) );
			add_action( 'woocommerce_widget_price_filter_start', array( $this, 'cartzilla_wc_widget_price_filter_scripts' ));
			add_action( 'tgmpa_register', array( $this, 'register_required_plugins' ) );
		}

		/**
		 * Set the content width in pixels, based on the theme's design and stylesheet.
		 *
		 * Priority 0 to make it available to lower priority callbacks.
		 *
		 * @global int $content_width
		 */
		public function content_width() {
			// This variable is intended to be overruled from themes.
			// Open WPCS issue: {@link https://github.com/WordPress-Coding-Standards/WordPress-Coding-Standards/issues/1043}.
			// phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
			$GLOBALS['content_width'] = apply_filters( 'cartzilla_content_width', 1260 );
		}

		/**
		 * Sets up theme defaults and registers support for various WordPress features.
		 *
		 * Note that this function is hooked into the after_setup_theme hook, which
		 * runs before the init hook. The init hook is too late for some features, such
		 * as indicating support for post thumbnails.
		 */
		public function setup() {
			/*
			 * Load Localisation files.
			 *
			 * Note: the first-loaded translation file overrides any following ones if the same translation is present.
			 */

			// Loads wp-content/languages/themes/cartzilla-it_IT.mo.
			load_theme_textdomain( 'cartzilla', trailingslashit( WP_LANG_DIR ) . 'themes' );

			// Loads wp-content/themes/child-theme-name/languages/it_IT.mo.
			load_theme_textdomain( 'cartzilla', get_stylesheet_directory() . '/languages' );

			// Loads wp-content/themes/cartzilla/languages/it_IT.mo.
			load_theme_textdomain( 'cartzilla', get_template_directory() . '/languages' );

			/**
			 * Add default posts and comments RSS feed links to head.
			 */
			add_theme_support( 'automatic-feed-links' );

			/*
			 * Enable support for Post Thumbnails on posts and pages.
			 *
			 * @link https://developer.wordpress.org/reference/functions/add_theme_support/#Post_Thumbnails
			 */
			add_theme_support( 'post-thumbnails' );

			/**
			 * Enable support for site logo.
			 */
			add_theme_support(
				'custom-logo', apply_filters(
					'cartzilla_custom_logo_args', array(
						'width'       => 284,
						'height'      => 68,
						'flex-width'  => true,
						'flex-height' => true,
					)
				)
			);

			/**
			 * Register menu locations.
			 */
			register_nav_menus(
				apply_filters(
					'cartzilla_register_nav_menus', array(
						'primary'     => esc_html_x( 'Primary', 'menu location', 'cartzilla' ),
						'handheld'    => esc_html_x( 'Handheld', 'menu location', 'cartzilla' ),
						'footer'      => esc_html_x( 'Footer', 'menu location', 'cartzilla' ),
						'departments' => esc_html_x( 'Departments', 'menu location', 'cartzilla' ),
						'social_media' => esc_html_x( 'Social Media', 'menu location', 'cartzilla' ),
					)
				)
			);

			/*
			 * Switch default core markup for search form, comment form, comments, galleries, captions and widgets
			 * to output valid HTML5.
			 */
			add_theme_support(
				'html5', apply_filters(
					'cartzilla_html5_args', array(
						'search-form',
						'comment-form',
						'comment-list',
						'gallery',
						'caption',
						'widgets',
					)
				)
			);

			// Declare WooCommerce support.
			add_theme_support( 'woocommerce', apply_filters( 'cartzilla_woocommerce_args', array(
				'thumbnail_image_width' => 350,
				'product_grid'          => array(
					'default_columns' => 3,
					'default_rows'    => 4,
					'min_columns'     => 1,
					'max_columns'     => 6,
					'min_rows'        => 1
				)
			) ) );

			add_theme_support( 'wc-product-gallery-zoom' );
			add_theme_support( 'wc-product-gallery-lightbox' );
			add_theme_support( 'wc-product-gallery-slider' );


			/**
			 *  Add support for the Site Logo plugin and the site logo functionality in JetPack
			 *  https://github.com/automattic/site-logo
			 *  http://jetpack.me/
			 */
			add_theme_support(
				'site-logo', apply_filters(
					'cartzilla_site_logo_args', array(
						'size' => 'full',
					)
				)
			);

			/**
			 * Declare support for title theme feature.
			 */
			add_theme_support( 'title-tag' );

			/**
			 * Declare support for selective refreshing of widgets.
			 */
			add_theme_support( 'customize-selective-refresh-widgets' );

			/**
			 * Add support for Block Styles.
			 */
			add_theme_support( 'wp-block-styles' );

			/**
			 * Add support for full and wide align images.
			 */
			add_theme_support( 'align-wide' );

			/**
			 * Add support for editor styles.
			 */
			add_theme_support( 'editor-styles' );

			/**
			 * Add support for editor font sizes.
			 */
			add_theme_support( 'editor-font-sizes', [
				[
					'name' => esc_html__( 'Normal', 'cartzilla' ),
					'slug' => 'base',
					'size' => 16
				],
				[
					'name' => esc_html__( 'Lead', 'cartzilla' ),
					'slug' => 'lead',
					'size' => 20
				],
				[
					'name' => esc_html__( 'Extra large', 'cartzilla' ),
					'slug' => 'xl',
					'size' => 26
				],
				[
					'name' => esc_html__( 'Large', 'cartzilla' ),
					'slug' => 'lg',
					'size' => 18
				],
				[
					'name' => esc_html__( 'Medium', 'cartzilla' ),
					'slug' => 'md',
					'size' => 15
				],
				[
					'name' => esc_html__( 'Small', 'cartzilla' ),
					'slug' => 'sm',
					'size' => 14
				],
				[
					'name' => esc_html__( 'Medium small', 'cartzilla' ),
					'slug' => 'ms',
					'size' => 13
				],
				[
					'name' => esc_html__( 'Extra small', 'cartzilla' ),
					'slug' => 'xs',
					'size' => 12
				],
			] );
			add_theme_support( 'editor-color-palette', [
				[
					'name'  => esc_html__( 'Primary', 'cartzilla' ),
					'slug'  => 'primary',
					'color' => 'var( --primary )'
				],
				[
					'name'  => esc_html__( 'Accent', 'cartzilla' ),
					'slug'  => 'accent',
					'color' => 'var( --accent )'
				],
				[
					'name'  => esc_html__( 'Info', 'cartzilla' ),
					'slug'  => 'info',
					'color' => '#69b3fe'
				],
				[
					'name'  => esc_html__( 'Success', 'cartzilla' ),
					'slug'  => 'success',
					'color' => '#42d697'
				],
				[
					'name'  => esc_html__( 'Warning', 'cartzilla' ),
					'slug'  => 'warning',
					'color' => '#fea569'
				],
				[
					'name'  => esc_html__( 'Danger', 'cartzilla' ),
					'slug'  => 'danger',
					'color' => '#f34770'
				],
				[
					'name'  => esc_html__( 'White', 'cartzilla' ),
					'slug'  => 'white',
					'color' => '#ffffff'
				],
				[
					'name'  => esc_html__( 'Lighter gray', 'cartzilla' ),
					'slug'  => 'lighter-gray',
					'color' => '#f6f9fc'
				],
				[
					'name'  => esc_html__( 'Light gray', 'cartzilla' ),
					'slug'  => 'light-gray',
					'color' => '#f3f5f9'
				],
				[
					'name'  => esc_html__( 'Medium gray', 'cartzilla' ),
					'slug'  => 'medium-gray',
					'color' => '#7d879c'
				],
				[
					'name'  => esc_html__( 'Default gray', 'cartzilla' ),
					'slug'  => 'default-gray',
					'color' => '#4b566b'
				],
				[
					'name'  => esc_html__( 'Dark gray', 'cartzilla' ),
					'slug'  => 'dark-gray',
					'color' => '#373f50'
				],
				[
					'name'  => esc_html__( 'Darker gray', 'cartzilla' ),
					'slug'  => 'darker-gray',
					'color' => '#2b3445'
				],
				[
					'name'  => esc_html__( 'Black', 'cartzilla' ),
					'slug'  => 'black',
					'color' => '#000000'
				],
			] );

			/**
			 * Enqueue editor styles.
			 */

			$editor_styles = [
				is_rtl() ? 'assets/css/gutenberg-editor-rtl.css' : 'assets/css/gutenberg-editor.css',
				$this->google_fonts(),
			];

			if( get_theme_mod( 'cartzilla_enable_custom_color', 'no' ) === 'yes' ) {
				$editor_styles[] = content_url( '/custom_theme_color_css' );
			}

			add_editor_style( $editor_styles );

			/**
			 * Add support for responsive embedded content.
			 */
			add_theme_support( 'responsive-embeds' );
		}

		/**
		 * Register widget area.
		 *
		 * @link https://codex.wordpress.org/Function_Reference/register_sidebar
		 */
		public function widgets_init() {
			register_sidebar( [
				'id'            => 'blog-sidebar',
				'name'          => esc_html__( 'Blog Sidebar', 'cartzilla' ),
				'before_widget' => '<div id="%1$s" class="widget %2$s">',
				'after_widget'  => '</div>',
				'before_title'  => '<h3 class="widget-title">',
				'after_title'   => '</h3>',
			] );

			register_sidebar( [
				'id'            => 'footer-column-1',
				'name'          => esc_html__( 'Footer Column 1', 'cartzilla' ),
				'before_widget' => '<div id="%1$s" class="widget %2$s pb-2 mb-4">',
				'after_widget'  => '</div>',
				'before_title'  => '<h3 class="widget-title">',
				'after_title'   => '</h3>',
			] );

			register_sidebar( [
				'id'            => 'footer-column-2',
				'name'          => esc_html__( 'Footer Column 2', 'cartzilla' ),
				'before_widget' => '<div id="%1$s" class="widget %2$s pb-2 mb-4">',
				'after_widget'  => '</div>',
				'before_title'  => '<h3 class="widget-title">',
				'after_title'   => '</h3>',
			] );

			register_sidebar( [
				'id'            => 'footer-column-3',
				'name'          => esc_html__( 'Footer Column 3', 'cartzilla' ),
				'before_widget' => '<div id="%1$s" class="widget %2$s pb-2 mb-4">',
				'after_widget'  => '</div>',
				'before_title'  => '<h3 class="widget-title">',
				'after_title'   => '</h3>',
			] );

		}

		/**
		 * Get all Cartzilla scripts.
		 */
		private static function get_theme_scripts() {
			$cartzilla_get_theme_script = apply_filters( 'cartzilla_theme_script', [
				'popper' => [
					'src' => '/assets/js/popper.min.js',
					'dep' => [ 'jquery' ],
				],
				'bootstrap' => [
					'src' => '/assets/js/bootstrap.min.js',
					'dep' => [ 'jquery', 'popper' ],
					'ver' => '4.3.1',
				],
				'simplebar' => [
					'src' => '/assets/js/simplebar.min.js',
					'dep' => [],
					'ver' => '4.3.0',
				],
				'smooth-scroll' => [
					'src' => '/assets/js/smooth-scroll.min.js',
					'dep' => [],
					'ver' => '16.1.1',
				],
				'lightgallery' => [
					'src' => '/assets/js/vendor/lightgallery.min.js',
					'dep' => [],
					'ver' => '1.1.3',
				],
				'tiny-slider' => [
					'src' => '/assets/js/tiny-slider.min.js',
					'dep' => [],
					'ver' => '2.9.2',
				],
				'nouislider' => [
					'src' => '/assets/js/nouislider.min.js',
					'dep' => [],
					'ver' => '14.0.2',
				],
				'slick-carousel' => [
					'src' => '/assets/js/slick.min.js',
					'dep' => [ 'jquery' ],
					'ver' => '1.8.1',
				],
				'cartzilla-scripts' => [
					'src' => '/assets/js/theme.js',
					'dep' => [ 'jquery', 'bootstrap', 'tiny-slider', 'slick-carousel', 'simplebar', 'smooth-scroll', 'lightgallery' ],
				],
			] );

			return $cartzilla_get_theme_script;
		}

		/**
		 * Register all Reen scripts.
		 */
		private static function register_scripts() {
			global $cartzilla_version;

			$register_scripts = self::get_theme_scripts();
			foreach ( $register_scripts as $handle => $props ) {
				wp_register_script(
					$handle,
					get_template_directory_uri() . $props['src'],
					$props['dep'],
					isset( $props['ver'] ) ? $props['ver'] : $cartzilla_version
				);
			}
		}

		private static function localize_script_data() {
			$admin_ajax_url = admin_url( 'admin-ajax.php' );
			$current_lang   = apply_filters( 'wpml_current_language', NULL );

			if ( $current_lang ) {
				$admin_ajax_url = add_query_arg( 'lang', $current_lang, $admin_ajax_url );
			}

			$cartzilla_options = apply_filters( 'cartzilla_localize_script_data', array(
				'rtl'                       => is_rtl() ? '1' : '0',
				'ajax_url'                  => $admin_ajax_url,
				'ajax_loader_url'           => get_template_directory_uri() . '/assets/img/ajax-loader.gif',
				'scroll_sticky_nav_offset'	=> 400,
				'scroll_to_top_offset'		=> 600,
			) );

			return $cartzilla_options;
		}

		/**
		 * Enqueue scripts and styles.
		 *
		 * @since  1.0.0
		 */
		public function scripts() {
			global $cartzilla_version;

			/**
			 * Styles
			 */
			$vendors = apply_filters( 'cartzilla_vendor_styles', array(
				'fontawesome' => 'font-awesome/css/fontawesome-all.min.css',
			) );

			foreach( $vendors as $key => $vendor ) {
				wp_enqueue_style( $key, get_template_directory_uri() . '/assets/vendor/' . $vendor, '', $cartzilla_version );
			}

			wp_enqueue_style( 'cartzilla-vendor', get_template_directory_uri() . '/assets/css/vendor.min.css', '', $cartzilla_version, 'screen' );

			// Slider for all purposes
			// https://github.com/ganlanyuan/tiny-slider
			wp_register_style( 'tiny-slider', get_template_directory_uri() . '/assets/css/tiny-slider.min.css', array(), '2.9.2', 'screen' );

			wp_enqueue_style( 'slick-carousel', get_template_directory_uri() . '/assets/css/slick.css', array(), '1.8.1', 'screen' );

			// nouislider
			// https://github.com/leongersen/noUiSlider
			wp_register_style( 'nouislider', get_template_directory_uri() . '/assets/css/nouislider.min.css', array(), '14.0.2', 'screen' );

			wp_enqueue_style( 'cartzilla-icons', get_template_directory_uri() . '/assets/css/cartzilla-icons.css', '', $cartzilla_version, 'screen' );

			wp_enqueue_style( 'cartzilla-style', get_template_directory_uri() . '/style.css', '', $cartzilla_version );
			wp_style_add_data( 'cartzilla-style', 'rtl', 'replace' );

			if( apply_filters( 'cartzilla_use_predefined_colors', true ) ) {
				$color_css_file = apply_filters( 'cartzilla_primary_color', 'pink' );
				wp_enqueue_style( 'cartzilla-color', get_template_directory_uri() . '/assets/css/colors/' . $color_css_file . '.css', '', $cartzilla_version );
			}

			/**
			 * Fonts
			 */
			wp_enqueue_style( 'cartzilla-fonts', $this->google_fonts(), array(), null );

			/**
			 * Scripts
			 */
			self::register_scripts();

			if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
				wp_enqueue_script( 'comment-reply' );
			}

			if ( is_home() || is_archive() ) {
				wp_enqueue_script( 'masonry' );
			}

			if( cartzilla_is_woocommerce_activated() && cartzilla_is_mas_wcvs_activated() ) {
				wp_enqueue_script( 'mas-wcvs-scripts' );
			}

			if( cartzilla_is_woocommerce_activated() && is_product() && cartzilla_is_wc_single_product_variations_radio_style() ) {
				wp_enqueue_script( 'cartzilla-variation-radio-scripts', get_template_directory_uri() . '/assets/js/variation-radio-scripts.js', [ 'jquery' ], $cartzilla_version, true );
			}

			wp_enqueue_script( 'cartzilla-scripts', get_template_directory_uri() . '/assets/js/theme.js', [
				'jquery',
				'bootstrap',
				'tiny-slider',
				'slick-carousel',
				'simplebar',
				'smooth-scroll'
			], $cartzilla_version, true );

			$cartzilla_options = self::localize_script_data();
			wp_localize_script( 'cartzilla-scripts', 'cartzilla_options', $cartzilla_options );
		}

		/**
		 * Register Google fonts.
		 *
		 * @since 2.4.0
		 * @return string Google fonts URL for the theme.
		 */
		public function google_fonts() {
			$google_fonts = apply_filters(
				'cartzilla_google_font_families', array(
					'rubik' => 'Rubik:300,400,500,700'
				)
			);

			$query_args = array(
				'family'  => implode( '|', $google_fonts ),
				'display' => 'swap'
			);

			$fonts_url = add_query_arg( $query_args, 'https://fonts.googleapis.com/css' );

			return $fonts_url;
		}

		/**
		 * Enqueue assets on admin side
		 *
		 * @since 1.0.0
		 */
		public function admin_assets() {
			global $cartzilla_version;
			wp_enqueue_style( 'cartzilla', get_template_directory_uri() . '/assets/css/admin.css', array(), $cartzilla_version, 'screen' );
		}

		/**
		 * Add custom pages in "Appearance"
		 *
		 * @since 1.0.0
		 */
		public function admin_pages() {
			add_theme_page(
				esc_html__( 'Cartzilla Icons', 'cartzilla' ),
				esc_html__( 'Cartzilla Icons', 'cartzilla' ),
				'edit_theme_options',
				'cartzilla-icons',
				function() {
					require get_theme_file_path( 'templates/admin/icons.php' );
				}
			);

			add_theme_page(
				esc_html__( 'Utility CSS Classes', 'cartzilla' ),
				esc_html__( 'Utility CSS Classes', 'cartzilla' ),
				'edit_theme_options',
				'cartzilla-utility-css-classes',
				function() {
					require get_theme_file_path( 'templates/admin/utility-css-classes.php' );
				}
			);
		}

		/**
		 * Enqueue supplemental block editor assets.
		 *
		 * @since 2.4.0
		 */
		public function block_editor_assets() {
			global $cartzilla_version;

			// Styles.
			$vendors = apply_filters( 'cartzilla_editor_vendor_styles', array(
				'fontawesome' => 'font-awesome/css/fontawesome-all.min.css',
			) );

			foreach( $vendors as $key => $vendor ) {
				wp_enqueue_style( $key, get_template_directory_uri() . '/assets/vendor/' . $vendor, '', $cartzilla_version );
			}

			wp_enqueue_style( 'cartzilla-vendor', get_template_directory_uri() . '/assets/css/vendor.min.css', array(), $cartzilla_version, 'screen' );

			wp_enqueue_style( 'tiny-slider', get_template_directory_uri() . '/assets/css/tiny-slider.min.css', array(), '2.9.2', 'screen' );

			wp_enqueue_style( 'slick-carousel', get_template_directory_uri() . '/assets/css/slick.css', array(), '1.8.1', 'screen' );

			wp_enqueue_style( 'nouislider', get_template_directory_uri() . '/assets/css/nouislider.min.css', array(), '14.0.2', 'screen' );

			wp_enqueue_style( 'cartzilla-icons', get_template_directory_uri() . '/assets/css/cartzilla-icons.css', '', $cartzilla_version, 'screen' );

			// Scripts
			$theme_scripts = self::get_theme_scripts();
			foreach ( $theme_scripts as $handle => $props ) {
				wp_enqueue_script(
					$handle,
					get_template_directory_uri() . $props['src'],
					$props['dep'],
					isset( $props['ver'] ) ? $props['ver'] : $cartzilla_version
				);
			}

			$cartzilla_options = self::localize_script_data();
			wp_localize_script( 'cartzilla-scripts', 'cartzilla_options', $cartzilla_options );
		}

		/**
		 * Enqueue child theme stylesheet.
		 * A separate function is required as the child theme css needs to be enqueued _after_ the parent theme
		 * primary css and the separate WooCommerce css.
		 *
		 * @since  1.5.3
		 */
		public function child_scripts() {
			if ( is_child_theme() ) {
				$child_theme = wp_get_theme( get_stylesheet() );
				wp_enqueue_style( 'cartzilla-child-style', get_stylesheet_uri(), array(), $child_theme->get( 'Version' ) );
			}
		}

		/**
		 * Get our wp_nav_menu() fallback, wp_page_menu(), to show a home link.
		 *
		 * @param array $args Configuration arguments.
		 * @return array
		 */
		public function page_menu_args( $args ) {
			$args['show_home'] = true;
			return $args;
		}

		/**
		 * Adds custom classes to the array of body classes.
		 *
		 * @param array $classes Classes for the body element.
		 * @return array
		 */
		public function body_classes( $classes ) {
			global $post;
			// Adds a class to blogs with more than 1 published author.
			if ( is_multi_author() ) {
				$classes[] = 'group-blog';
			}

			if ( is_page() && isset( $post->ID ) ) {
				$body_class_meta_values = get_post_meta( $post->ID, '_bodyClasses', true );

				if ( isset( $body_class_meta_values ) && $body_class_meta_values ) {
					$classes[] = $body_class_meta_values;
				}
			}

			/**
			 * Adds a class when WooCommerce is not active.
			 *
			 * @todo Refactor child themes to remove dependency on this class.
			 */
			$classes[] = 'no-wc-breadcrumb';

			// If our main sidebar doesn't contain widgets, adjust the layout to be full-width.
			if ( ! is_active_sidebar( 'sidebar-1' ) ) {
				$classes[] = 'cartzilla-full-width-content';
			}

			// Add class when using homepage template + featured image.
			if ( is_page_template( 'template-homepage.php' ) && has_post_thumbnail() ) {
				$classes[] = 'has-post-thumbnail';
			}

			// Add class when Secondary Navigation is in use.
			if ( has_nav_menu( 'secondary' ) ) {
				$classes[] = 'cartzilla-secondary-navigation';
			}

			// Add class if align-wide is supported.
			if ( current_theme_supports( 'align-wide' ) ) {
				$classes[] = 'cartzilla-align-wide';
			}

			// Add class if single post has sidebar.
			if ( is_single() && 'post' == get_post_type() && cartzilla_post_layout() !== 'no-sidebar' ) {
				$classes[] = 'has-sidebar';
			}

			if( cartzilla_is_woocommerce_activated() && is_product() ) {
				$classes[] = cartzilla_get_single_product_style();
				if( cartzilla_is_wc_single_product_variations_radio_style() ) {
					$classes[] = 'cartzilla-variations-radio-style-enabled';
				}
			}

			if ( cartzilla_is_woocommerce_activated() && ( is_shop() || is_product_category() || is_tax( 'product_label' ) || is_tax( get_object_taxonomies( 'product' ) ) ) ) {
				$classes[] = cartzilla_get_shop_page_style();
			}

			if ( cartzilla_is_woocommerce_activated() && cartzilla_get_shop_page_style() === 'style-v3') {
				$classes[] = 'bg-secondary grocery-homepage';
			}


			return $classes;
		}

		/**
		 * Add extra buttons to TinyMCE editor
		 *
		 * @param array $buttons TinyMCE Buttons
		 *
		 * @return array
		 */
		public function classic_editor_buttons( $buttons ) {
			array_unshift( $buttons, 'styleselect' );

			return $buttons;
		}

		/**
		 * Modify TinyMCE. Add "style_formats"
		 *
		 * @link https://codex.wordpress.org/TinyMCE_Custom_Styles#Using_style_formats
		 *
		 * @param array $init_array
		 *
		 * @return array
		 */
		public function classic_editor_formats( $init_array ) {
			$style_formats = [
				[
					'title' => esc_html__( 'Headings', 'cartzilla' ),
					'items' => [
						[
							'title'   => esc_html__( 'Heading 1', 'cartzilla' ),
							'format'  => 'h1',
						],
						[
							'title'  => esc_html__( 'Heading 2', 'cartzilla' ),
							'format' => 'h2',
						],
						[
							'title'  => esc_html__( 'Heading 3', 'cartzilla' ),
							'format' => 'h3',
						],
						[
							'title'  => esc_html__( 'Heading 4', 'cartzilla' ),
							'format' => 'h4',
						],
						[
							'title'  => esc_html__( 'Heading 5', 'cartzilla' ),
							'format' => 'h5',
						],
						[
							'title'  => esc_html__( 'Heading 6', 'cartzilla' ),
							'format' => 'h6',
						],
					],
				],
				[
					'title' => esc_html__( 'Display', 'cartzilla' ),
					'items' => [
						[
							'title'   => esc_html__( 'Display 1', 'cartzilla' ),
							'block'   => 'div',
							'classes' => 'display-1',
						],
						[
							'title'   => esc_html__( 'Display 2', 'cartzilla' ),
							'block'   => 'div',
							'classes' => 'display-2',
						],
						[
							'title'   => esc_html__( 'Display 3', 'cartzilla' ),
							'block'   => 'div',
							'classes' => 'display-3',
						],
						[
							'title'   => esc_html__( 'Display 4', 'cartzilla' ),
							'block'   => 'div',
							'classes' => 'display-4',
						],
					],
				],
				[
					'title' => esc_html__( 'Inline', 'cartzilla' ),
					'items' => [
						[
							'title'  => esc_html__( 'Bold', 'cartzilla' ),
							'icon'   => 'bold',
							'format' => 'bold',
						],
						[
							'title'  => esc_html__( 'Italic', 'cartzilla' ),
							'icon'   => 'italic',
							'format' => 'italic',
						],
						[
							'title'  => esc_html__( 'Underline', 'cartzilla' ),
							'icon'   => 'underline',
							'format' => 'underline',
						],
						[
							'title'  => esc_html__( 'Strikethrough', 'cartzilla' ),
							'icon'   => 'strikethrough',
							'format' => 'strikethrough',
						],
						[
							'title'  => esc_html__( 'Superscript', 'cartzilla' ),
							'icon'   => 'superscript',
							'format' => 'superscript',
						],
						[
							'title'  => esc_html__( 'Subscript', 'cartzilla' ),
							'icon'   => 'subscript',
							'format' => 'subscript',
						],
						[
							'title'  => esc_html__( 'Code', 'cartzilla' ),
							'icon'   => 'code',
							'format' => 'code',
						],
					],
				],
				[
					'title' => esc_html__( 'Blocks', 'cartzilla' ),
					'items' => [
						[
							'title'  => esc_html__( 'Paragraph', 'cartzilla' ),
							'format' => 'p',
						],
						[
							'title'  => esc_html__( 'Blockquote', 'cartzilla' ),
							'format' => 'blockquote',
						],
						[
							'title'  => esc_html__( 'Div', 'cartzilla' ),
							'format' => 'div',
						],
						[
							'title'  => esc_html__( 'Pre', 'cartzilla' ),
							'format' => 'pre',
						],
					],
				],
				[
					'title' => esc_html__( 'Alignment', 'cartzilla' ),
					'items' => [
						[
							'title'  => esc_html__( 'Left', 'cartzilla' ),
							'icon'   => 'alignleft',
							'format' => 'alignleft',
						],
						[
							'title'  => esc_html__( 'Center', 'cartzilla' ),
							'icon'   => 'aligncenter',
							'format' => 'aligncenter',
						],
						[
							'title'  => esc_html__( 'Right', 'cartzilla' ),
							'icon'   => 'alignright',
							'format' => 'alignright',
						],
						[
							'title'  => esc_html__( 'Justify', 'cartzilla' ),
							'icon'   => 'alignjustify',
							'format' => 'alignjustify',
						],
					],
				],
				[
					'title' => esc_html__( 'Font size', 'cartzilla' ),
					'items' => [
						[
							'title'   => esc_html__( 'Lead', 'cartzilla' ),
							'block'   => 'p',
							'classes' => 'lead',
						],
						[
							'title'   => esc_html__( 'Large', 'cartzilla' ),
							'block'   => 'p',
							'classes' => 'font-size-lg',
						],
						[
							'title'   => esc_html__( 'Normal', 'cartzilla' ),
							'block'   => 'p',
							'classes' => 'font-size-base',
						],
						[
							'title'   => esc_html__( 'Medium', 'cartzilla' ),
							'block'   => 'p',
							'classes' => 'font-size-md',
						],
						[
							'title'   => esc_html__( 'Small', 'cartzilla' ),
							'block'   => 'p',
							'classes' => 'font-size-sm',
						],
						[
							'title'   => esc_html__( 'Medium small', 'cartzilla' ),
							'block'   => 'p',
							'classes' => 'font-size-ms',
						],
						[
							'title'   => esc_html__( 'Extra small', 'cartzilla' ),
							'block'   => 'p',
							'classes' => 'font-size-xs',
						],
					],
				],
				[
					'title' => esc_html__( 'Font weight', 'cartzilla' ),
					'items' => [
						[
							'title'   => esc_html__( 'Light', 'cartzilla' ),
							'block'   => 'p',
							'classes' => 'font-weight-light',
						],
						[
							'title'   => esc_html__( 'Normal', 'cartzilla' ),
							'block'   => 'p',
							'classes' => 'font-weight-normal',
						],
						[
							'title'   => esc_html__( 'Medium', 'cartzilla' ),
							'block'   => 'p',
							'classes' => 'font-weight-medium',
						],
						[
							'title'   => esc_html__( 'Bold', 'cartzilla' ),
							'block'   => 'p',
							'classes' => 'font-weight-bold',
						],
					],
				],
				[
					'title' => esc_html__( 'Opacity', 'cartzilla' ),
					'items' => [
						[
							'title'   => esc_html__( 'Opacity 100', 'cartzilla' ),
							'inline'  => 'span',
							'classes' => 'opacity-100',
						],
						[
							'title'   => esc_html__( 'Opacity 90', 'cartzilla' ),
							'inline'  => 'span',
							'classes' => 'opacity-90',
						],
						[
							'title'   => esc_html__( 'Opacity 80', 'cartzilla' ),
							'inline'  => 'span',
							'classes' => 'opacity-80',
						],
						[
							'title'   => esc_html__( 'Opacity 75', 'cartzilla' ),
							'inline'  => 'span',
							'classes' => 'opacity-75',
						],
						[
							'title'   => esc_html__( 'Opacity 70', 'cartzilla' ),
							'inline'  => 'span',
							'classes' => 'opacity-70',
						],
						[
							'title'   => esc_html__( 'Opacity 60', 'cartzilla' ),
							'inline'  => 'span',
							'classes' => 'opacity-60',
						],
						[
							'title'   => esc_html__( 'Opacity 50', 'cartzilla' ),
							'inline'  => 'span',
							'classes' => 'opacity-50',
						],
						[
							'title'   => esc_html__( 'Opacity 25', 'cartzilla' ),
							'inline'  => 'span',
							'classes' => 'opacity-25',
						],
					],
				]
			];

			$init_array['style_formats'] = json_encode( $style_formats );

			return $init_array;
		}

		/**
		 * Replace scripts for "Filter Products by Price" widget.
		 *
		 * @param array $args
		 *
		 * @since 1.0.0
		 */
		public function cartzilla_wc_widget_price_filter_scripts( $args ) {
			global $cartzilla_version;
			wp_dequeue_script( 'wc-price-slider' );
			wp_enqueue_script( 'cz-price-range', get_template_directory_uri() . '/assets/js/price-range.js', [ 'nouislider' ], null, true );
		}

		/**
		 * Register the required plugins for this theme.
		 *
		 * This function is hooked into `tgmpa_register`, which is fired on the WP `init` action on priority 10.
		 */
		public function register_required_plugins() {
			/*
			 * Array of plugin arrays. Required keys are name and slug.
			 * If the source is NOT from the .org repo, then source is also required.
			 */
			global $cartzilla_version;

			$dokan = array(
				'name'                  => esc_html__( 'Dokan', 'cartzilla' ),
				'slug'                  => 'dokan-lite',
				'required'              => true,
				'version'               => '3.0.10',
				'force_activation'      => false,
				'force_deactivation'    => false,
			);

			$mas_woocommerce_brands = array(
				'name'                  => esc_html__( 'MAS Brands for WooCommerce', 'cartzilla' ),
				'slug'                  => 'mas-woocommerce-brands',
				'version'               => '1.0.3',
				'force_activation'      => false,
				'force_deactivation'    => false,
				'required'              => false,
			);

			$mas_variation_swatches = array(
				'name'                  => esc_html__( 'MAS Variation Swatches for WooCommerce', 'cartzilla' ),
				'slug'                  => 'mas-woocommerce-variation-swatches',
				'version'               => '1.0.1',
				'force_activation'      => false,
				'force_deactivation'    => false,
				'required'              => false,
			);

			$wedocs = array(
				'name'                  => esc_html__( 'weDocs', 'cartzilla' ),
				'slug'                  => 'wedocs',
				'required'              => false,
				'version'               => '1.6.2',
				'force_activation'      => false,
				'force_deactivation'    => false,
			);

			$woocommerce = array(
				'name'					=> esc_html__( 'WooCommerce', 'cartzilla' ),
				'slug'					=> 'woocommerce',
				'required'				=> true,
				'version'				=> '4.6.0',
				'force_activation'		=> false,
				'force_deactivation'	=> false,
				'external_url'			=> '',
			);

			$wpforms_lite = array(
				'name'                  => esc_html__( 'WPForms Lite', 'cartzilla' ),
				'slug'                  => 'wpforms-lite',
				'required'              => false,
				'version'               => '1.6.3.1',
				'force_activation'      => false,
				'force_deactivation'    => false,
				'external_url'          => '',
			);

			$yith_woocompare = array(
				'name'                  => esc_html__( 'YITH WooCommerce Compare', 'cartzilla' ),
				'slug'                  => 'yith-woocommerce-compare',
				'required'              => false,
				'version'               => '2.4.1',
				'force_activation'      => false,
				'force_deactivation'    => false,
				'is_callable'           => array( 'YITH_Woocompare', 'is_frontend' ),
				'external_url'          => '',
			);

			$yith_woocommerce_wishlist = array(
				'name'                  => esc_html__( 'YITH WooCommerce Wishlist', 'cartzilla' ),
				'slug'                  => 'yith-woocommerce-wishlist',
				'required'              => false,
				'version'               => '3.0.15',
				'force_activation'      => false,
				'force_deactivation'    => false,
				'is_callable'           => array( 'YITH_WCWL', 'get_instance' ),
				'external_url'          => '',
			);

			$plugins = array(

				array(
					'name'					=> esc_html__( 'Cartzilla Extensions', 'cartzilla' ),
					'slug'					=> 'cartzilla-extensions',
					'source'				=> 'https://transvelo.github.io/included-plugins/cartzilla-extensions.zip',
					'required'				=> true,
					'version'				=> $cartzilla_version,
					'force_activation'		=> false,
					'force_deactivation'	=> false,
					'external_url'			=> '',
				),

				array(
					'name'                  => esc_html__( 'Cartzilla Gutenberg Blocks', 'cartzilla' ),
					'slug'                  => 'cartzillagb',
					'source'                => 'https://transvelo.github.io/included-plugins/cartzillagb.zip',
					'version'               => $cartzilla_version,
					'force_activation'      => false,
					'force_deactivation'    => false,
					'required'              => true
				),

				array(
					'name'                  => esc_html__( 'Envato Market', 'cartzilla' ),
					'slug'                  => 'envato-market',
					'source'                => 'https://envato.github.io/wp-envato-market/dist/envato-market.zip',
					'required'              => false,
					'version'               => '2.0.5',
					'force_activation'      => false,
					'force_deactivation'    => false,
					'external_url'          => '',
				),

				array(
					'name'                  => esc_html__( 'MAS Static Content', 'cartzilla' ),
					'slug'                  => 'mas-static-content',
					'version'               => '1.0.3',
					'force_activation'      => false,
					'force_deactivation'    => false,
					'required'              => true,
				),

				array(
					'name'                  => esc_html__( 'One Click Demo Import', 'cartzilla' ),
					'slug'                  => 'one-click-demo-import',
					'version'               => '2.6.1',
					'force_activation'      => false,
					'force_deactivation'    => false,
					'required'              => false,
				),
			);

			$selected_demo = get_option( 'cartzilla_tgmpa_selected_demo', '' );

			switch ( $selected_demo ) {
				case 'main':
					$plugins[] = $mas_variation_swatches;
					$plugins[] = $mas_woocommerce_brands;
					$plugins[] = $woocommerce;
					$plugins[] = $wpforms_lite;
					$plugins[] = $yith_woocompare;
					$plugins[] = $yith_woocommerce_wishlist;
				break;
				case 'electronics':
					$plugins[] = $mas_variation_swatches;
					$plugins[] = $mas_woocommerce_brands;
					$plugins[] = $woocommerce;
					$plugins[] = $wpforms_lite;
					$plugins[] = $yith_woocompare;
					$plugins[] = $yith_woocommerce_wishlist;
				break;
				case 'marketplace':
					$plugins[] = $dokan;
					$plugins[] = $woocommerce;
					$plugins[] = $wpforms_lite;
					$plugins[] = $yith_woocommerce_wishlist;
				break;
				case 'grocery':
					$plugins[] = $woocommerce;
					$plugins[] = $wpforms_lite;
					$plugins[] = $yith_woocommerce_wishlist;
				break;
				case 'helpcenter':
					$plugins[] = $wedocs;
				break;
				default:
				break;
			}

			$config = array(
				'id'           => 'cartzilla',                 // Unique ID for hashing notices for multiple instances of TGMPA.
				'default_path' => '',                      // Default absolute path to bundled plugins.
				'menu'         => 'tgmpa-install-plugins', // Menu slug.
				'has_notices'  => true,                    // Show admin notices or not.
				'dismissable'  => true,                    // If false, a user cannot dismiss the nag message.
				'dismiss_msg'  => '',                      // If 'dismissable' is false, this message will be output at top of nag.
				'is_automatic' => false,                   // Automatically activate plugins after installation or not.
				'message'      => '',                      // Message to output right before the plugins table.
			);

			tgmpa( $plugins, $config );
		}

	}
endif;

return new Cartzilla();
