<?php
/**
 * Cartzilla Theme Customizer
 *
 * @package Cartzilla
 */

if ( ! function_exists( 'cartzilla_sass_hex_to_rgba' ) ) {
	function cartzilla_sass_hex_to_rgba( $hex, $alpa = '' ) {
		preg_match('/^#?([0-9a-f]{2})([0-9a-f]{2})([0-9a-f]{2})$/i', $hex, $matches);
		for($i = 1; $i <= 3; $i++) {
			$matches[$i] = hexdec($matches[$i]);
		}
		if( !empty( $alpa ) ) {
			$rgb = 'rgba(' . $matches[1] . ', ' . $matches[2] . ', ' . $matches[3] . ', ' . $alpa .')';
		} else {
			$rgb = 'rgba(' . $matches[1] . ', ' . $matches[2] . ', ' . $matches[3] . ')';
		}
		return $rgb;
	}
}

if ( ! function_exists( 'cartzilla_sass_yiq' ) ) {
	function cartzilla_sass_yiq( $hex ) {
		$length = strlen( $hex );
		if( $length < 5 ) {
			$hex = ltrim($hex,"#");
			$hex = '#' . $hex . $hex;
		}

		preg_match('/^#?([0-9a-f]{2})([0-9a-f]{2})([0-9a-f]{2})$/i', $hex, $matches);

		for($i = 1; $i <= 3; $i++) {
			$matches[$i] = hexdec($matches[$i]);
		}
		$yiq = (($matches[1]*299)+($matches[2]*587)+($matches[3]*114))/1000;
		return ($yiq >= 128) ? '#000' : '#fff';
	}
}

/**
 * Get all of the Cartzilla theme colors.
 *
 * @return array $cartzilla_theme_colors The Cartzilla Theme Colors.
 */
if( ! function_exists( 'cartzilla_get_theme_colors' ) ) {
	function cartzilla_get_theme_colors() {
		$cartzilla_theme_colors = array(
			'primary_color'     => get_theme_mod( 'cartzilla_primary_color', apply_filters( 'cartzilla_default_primary_color', '#fe696a' ) ),
			'accent_color'      => get_theme_mod( 'cartzilla_accent_color', apply_filters( 'cartzilla_default_accent_color', '#4e54c8' ) ),
			'secondary_color'   => get_theme_mod( 'cartzilla_secondary_color', apply_filters( 'cartzilla_default_secondary_color', '#f3f5f9' ) ),
			'dark_color'        => get_theme_mod( 'cartzilla_dark_color', apply_filters( 'cartzilla_default_dark_color', '#373f50' ) ),
		);

		return apply_filters( 'cartzilla_get_theme_colors', $cartzilla_theme_colors );
	}
}

/**
 * Get Customizer Color css.
 *
 * @see cartzilla_get_custom_color_css()
 * @return array $styles the css
 */
if( ! function_exists( 'cartzilla_get_custom_color_css' ) ) {
	function cartzilla_get_custom_color_css() {
		$cartzilla_theme_colors = cartzilla_get_theme_colors();

		$primary_color = $cartzilla_theme_colors['primary_color'];
		$primary_color_yiq = cartzilla_sass_yiq( $primary_color );
		$primary_color_darken_10p = cartzilla_adjust_color_brightness( $primary_color, -10 );
		$primary_color_darken_15p = cartzilla_adjust_color_brightness( $primary_color, -15 );

		$accent_color = $cartzilla_theme_colors['accent_color'];
		$accent_color_yiq = cartzilla_sass_yiq( $accent_color );
		$accent_color_darken_10p = cartzilla_adjust_color_brightness( $accent_color, -10 );
		$accent_color_darken_15p = cartzilla_adjust_color_brightness( $accent_color, -15 );

		$styles = 
'
/*
 * Primary Color
 */
a,
.btn-outline-primary,
.btn-link,
.dropdown-item:hover,
.lang-item > a:hover,
.dropdown-item:focus,
.lang-item > a:focus,
.dropdown-item.active,
.lang-item > a.active,
.dropdown-item:active,
.lang-item > a:active,
.nav-tabs .nav-link.active,
.nav-tabs .nav-item.show .nav-link,
.navbar-light .navbar-brand,
.navbar-light .navbar-brand:hover,
.navbar-light .navbar-brand:focus,
.navbar-light .navbar-nav .nav-link:hover,
.navbar-light .navbar-nav .nav-link:focus,
.navbar-light .navbar-nav .show > .nav-link,
.navbar-light .navbar-nav .active > .nav-link,
.navbar-light .navbar-nav .nav-link.show,
.navbar-light .navbar-nav .nav-link.active,
.navbar-light .navbar-text a,
.navbar-light .navbar-text a:hover,
.navbar-light .navbar-text a:focus,
.password-toggle-btn .custom-control-input:checked ~ .password-toggle-indicator,
.dropdown-menu .active > .dropdown-item,
.mega-nav .mega-dropdown .mega-menu-container .active > .dropdown-item,
.dropdown-menu .lang-item.active > a,
.mega-nav .mega-dropdown .mega-menu-container .lang-item.active > a,
.nav-tabs .nav-link:hover,
a.nav-link:hover .media-tab-media,
.nav-link-style:hover,
.active > .nav-link-style,
.is-active > .nav-link-style,
.nav-link-style.active,
.mega-nav .mega-dropdown .mega-menu-container .dropdown-menu .mega-dropdown-column .widget-list > li > a:hover,
.mega-nav .mega-dropdown .mega-menu-container .mega-menu-container .mega-dropdown-column .widget-list > li > a:hover,
.mega-nav .mega-dropdown:hover > a,
.navbar-light .nav-item:hover .nav-link:not(.disabled),
.navbar-light .nav-item:hover .nav-link:not(.disabled) > i,
.navbar-light .nav-item.active .nav-link:not(.disabled) > i,
.navbar-light .nav-item.show .nav-link:not(.disabled) > i,
.navbar-light .nav-item.dropdown .nav-link:focus:not(.disabled) > i,
.topbar-light .topbar-text > i,
.topbar-light .topbar-link > i,
.topbar-dark .topbar-text > i,
.topbar-dark .topbar-link > i,
.cz-handheld-menu ul > li a:hover,
.breadcrumb-item > a:hover,
.bg-secondary .breadcrumb .breadcrumb-item > a:hover,
.bg-secondary .breadcrumb.breadcrumb-light .breadcrumb-item > a:hover,
.entry-navigation-link:hover,
.logged-in-as > a:hover,
.widget ul > li > a:hover,
.widget ul > li.active > a,
.widget-list-link:hover,
.active > .widget-list-link,
.widget_cartzilla_wc_categories .accordion-heading > a,
.widget_cartzilla_wc_categories .accordion-heading > a:hover,
.widget_cartzilla_wc_categories .accordion-heading > a:hover .accordion-indicator,
.widget-product-title:hover > a,
.widget_recent_entries ul > li > a:hover,
.widget_recent_comments .recentcomments > a:hover,
.widget_calendar table a:hover,
.widget_layered_nav_filters .chosen > a::before,
.widget_rss .rsswidget:hover,
.product-title > a:hover,
.btn-wishlist:hover,
.tawcvs-swatches .swatch.swatch-color.selected,
.tawcvs-swatches .swatch.swatch-label.selected,
.blog-entry-title > a:hover,
.wp-block-categories-list > li > a:hover,
.wp-block-categories-list ul > li > a:hover,
.wp-block-archives-list > li > a:hover,
.wp-block-archives-list ul > li > a:hover,
.wp-block-categories-list > li > a.active > a,
.wp-block-categories-list ul > li > a.active > a,
.wp-block-archives-list > li > a.active > a,
.wp-block-archives-list ul > li > a.active > a,
.product-card a.add_to_wishlist:hover,
.product-card-alt a.add_to_wishlist:hover,
ul.products.list-view .product-details a.add_to_wishlist:hover,
.single-product.style-v1 .product-summary a.add_to_wishlist:hover,
.single-product.style-v1 .product-summary .yith-wcwl-wishlistaddedbrowse a:hover,
.single-product.style-v1 .product-summary .yith-wcwl-wishlistexistsbrowse a:hover,
.cd-quick-view a.add_to_wishlist:hover,
.cd-quick-view .yith-wcwl-wishlistaddedbrowse a:hover,
.cd-quick-view .yith-wcwl-wishlistexistsbrowse a:hover,
.cartzilla-tabs .nav-tabs .nav-item.active a,
.product-card .yith-wcwl-wishlistaddedbrowse a,
.product-card .yith-wcwl-wishlistaddedbrowse a:hover,
.product-card .yith-wcwl-wishlistexistsbrowse a,
.product-card .yith-wcwl-wishlistexistsbrowse a:hover,
.product-card-alt .yith-wcwl-wishlistaddedbrowse a,
.product-card-alt .yith-wcwl-wishlistaddedbrowse a:hover,
.product-card-alt .yith-wcwl-wishlistexistsbrowse a,
.product-card-alt .yith-wcwl-wishlistexistsbrowse a:hover,
ul.products.list-view .product-details .yith-wcwl-wishlistaddedbrowse a,
ul.products.list-view .product-details .yith-wcwl-wishlistaddedbrowse a:hover,
ul.products.list-view .product-details .yith-wcwl-wishlistexistsbrowse a,
ul.products.list-view .product-details .yith-wcwl-wishlistexistsbrowse a:hover,
ul.products.grid-view .product-details .yith-wcwl-wishlistaddedbrowse a,
ul.products.grid-view .product-details .yith-wcwl-wishlistexistsbrowse a,
ul.products.grid-view .product-details .yith-wcwl-wishlistexistsbrowse a:hover,
ul.products li.product .product-card-alt .added_to_cart,
form.variations_form .mas-wcvs-swatches .mas-wcvs-swatch.selected,
.site-header-marketplace .navbar .mega-nav .mega-dropdown .mega-menu-container .dropdown-menu li.mega-dropdown-column > a:hover,
.cz-offcanvas .dropdown > div:hover > a,
.cz-sidebar-fixed .dropdown > div:hover > a {
	color: ' . $primary_color . ';
}

.text-primary,
.single-product:not(.style-v3) .yith-wcwl-wishlistexistsbrowse a i,
.single-product:not(.style-v3) .yith-wcwl-wishlistaddedbrowse a i,
.single-product.style-v1 .yith-wcwl-add-button a:hover,
.product-card .add-to-compare-link:hover,
.cz-sidebar-fixed .cz-sidebar-body .cz-handheld-menu .btn:hover, 
.cz-sidebar-fixed .cz-sidebar-body .cz-handheld-menu .woocommerce-widget-layered-nav-dropdown__submit:hover,
.cz-sidebar-fixed .cz-sidebar-body .cz-handheld-menu .btn:focus, 
.cz-sidebar-fixed .cz-sidebar-body .cz-handheld-menu .woocommerce-widget-layered-nav-dropdown__submit:focus,
.wp-block-button.is-style-outline .wp-block-button__link:not(:hover),
.read-more-text.blog-entry-meta-link:hover,
.read-more-text.blog-entry-meta-link:focus,
.current-page-parent > a,
.current_page_parrent > a,
.current_page_item > a,
.current-menu-item > a,
.current-page-ancestor > a,
.current-menu-ancestor > a,
.dropdown-menu .current-page-parent > a,
.mega-nav .mega-dropdown .mega-menu-container .current-page-parent > a,
.dropdown-menu .current_page_parrent > a,
.mega-nav .mega-dropdown .mega-menu-container .current_page_parrent > a,
.dropdown-menu .current_page_item > a,
.mega-nav .mega-dropdown .mega-menu-container .current_page_item > a,
.dropdown-menu .current-menu-item > a,
.mega-nav .mega-dropdown .mega-menu-container .current-menu-item > a,
.dropdown-menu .current-page-ancestor > a,
.mega-nav .mega-dropdown .mega-menu-container .current-page-ancestor > a,
.dropdown-menu .current-menu-ancestor > a,
.mega-nav .mega-dropdown .mega-menu-container .current-menu-ancestor > a,
.select2-container--default .select2-results__option[aria-selected=true],
.select2-container--default .select2-results__option[data-selected=true],
.select2-container--default .select2-results__option--highlighted {
	color: ' . $primary_color . ' !important;
}

a:hover,
.btn-link:hover {
	color: ' . $primary_color_darken_10p . ';
}

a.text-primary:hover,
a.text-primary:focus {
	color: ' . $primary_color_darken_15p . ' !important;
}

.custom-range::-ms-thumb {
	background-color: ' . $primary_color . ';
}

.custom-range::-moz-range-thumb {
	background-color: ' . $primary_color . ';
}

.custom-range::-webkit-slider-thumb,
.list-group-item.active,
.nav-tabs .nav-link.active::before,
.cz-carousel [data-nav].tns-nav-active,
.cz-range-slider-ui .noUi-connect,
.wp-block-file > .wp-block-file__button,
.cz-carousel .slick-dots li.slick-active,
.widget_price_filter .ui-slider-horizontal .ui-slider-range,
.cartzilla-tabs .nav-tabs .nav-item.active:before,
#yith-quick-view-content .onsale,
.slick-dots li.slick-active button {
	background-color: ' . $primary_color . ';
}

.bg-primary {
	color: ' . cartzilla_sass_yiq( $primary_color ) . ';
	background-color: ' . $primary_color . ' !important;
}

a.bg-primary:hover,
a.bg-primary:focus,
button.bg-primary:hover,
button.bg-primary:focus {
	color: ' . cartzilla_sass_yiq( $primary_color_darken_10p ) . ';
	background-color: ' . $primary_color_darken_10p . ' !important;
}

.cz-sidebar-fixed .cz-sidebar-body .cz-handheld-menu .btn:hover, 
.cz-sidebar-fixed .cz-sidebar-body .cz-handheld-menu .woocommerce-widget-layered-nav-dropdown__submit:hover,
.cz-sidebar-fixed .cz-sidebar-body .cz-handheld-menu .btn:focus, 
.cz-sidebar-fixed .cz-sidebar-body .cz-handheld-menu .woocommerce-widget-layered-nav-dropdown__submit:focus {
	background-color: ' . cartzilla_sass_hex_to_rgba( $primary_color, '0.1' ) . ';
}

.btn-primary,
.btn-primary:hover,
.btn-primary:focus,
.product-card .added_to_cart,
.product-card .added_to_cart:hover,
.product-card .added_to_cart:focus,
.woocommerce-widget-layered-nav .woocommerce-widget-layered-nav-dropdown__submit,
.wpforms-container-full.subscribe-form .wpforms-form button[type="submit"],
.wpforms-container-full.subscribe-form .wpforms-form button[type="submit"]:hover,
.wpforms-container-full.subscribe-form .wpforms-form button[type="submit"]:focus,
.wpforms-container-full.subscribe-form .wpforms-form button[type="submit"]:active,
form.variations_form .mas-wcvs-swatches .mas-wcvs-swatch.selected,
.flex-control-thumbs > li > img.flex-active {
	border-color: ' . $primary_color . ';
}

.btn-outline-primary {
	border-color: ' . cartzilla_sass_hex_to_rgba( $primary_color, '0.35' ) . ';
}

.btn-primary.btn-shadow,
.btn-shadow.woocommerce-widget-layered-nav-dropdown__submit,
.yith-wcwl-form.wishlist-fragment .hidden-title-form input.btn-shadow[type="submit"],
.compare-table .btn-shadow.button,
.wp-block-button .btn-shadow.wp-block-button__link,
.page-item.active > .page-link,
.cv-form.wpforms-container .btn-primary.btn-shadow,
.contact-form.wpforms-container .btn-primary.btn-shadow,
div.wpforms-container-full.cv-form .btn-primary.btn-shadow,
div.wpforms-container-full.contact-form .btn-primary.btn-shadow {
	box-shadow: 0 0.5rem 1.125rem -0.5rem ' . cartzilla_sass_hex_to_rgba( $primary_color, '0.9' ) . ';
}

blockquote:not(.cz-testimonial):before {
	box-shadow: 0 0.5rem 0.575rem -0.25rem ' . cartzilla_sass_hex_to_rgba( $primary_color, '0.75' ) . ';
}

.select2-container--default .select2-search--dropdown .select2-search__field:focus {
	border-color: ' . cartzilla_sass_hex_to_rgba( $primary_color, '0.3' ) . ' !important;
}

.custom-select:focus,
select:focus,
.woocommerce-currency-switcher:focus,
.select2.select2-container .select2-selection--single:focus,
.select2.select2-container .select2-selection--multiple:focus,
.form-control:focus,
.widget_search .search-field:focus,
.widget_product_search .search-field:focus,
.yith-wcwl-form.wishlist-fragment .hidden-title-form input:focus[type="text"],
.dokan-dashboard .datepicker:focus,
.dokan-dashboard .dokan-product-regular-price:focus,
.dokan-dashboard .dokan-product-sales-price:focus {
	border-color: ' . cartzilla_sass_hex_to_rgba( $primary_color, '0.3' ) . ';
	box-shadow: 0 0 0 0 transparent, 0 0.375rem 0.625rem -0.3125rem ' . cartzilla_sass_hex_to_rgba( $primary_color, '0.15' ) . ';
}

.nav-pills .nav-link.active,
.nav-pills .show > .nav-link,
.page-item.active .page-link,
.badge-primary,
.progress-bar,
.list-group-item.active,
.navbar-tool .navbar-tool-label,
.steps-dark .step-item.active .step-count,
.steps-dark .step-item.active .step-progress,
.steps-light .step-item.active .step-count,
.steps-light .step-item.active .step-progress,
.cz-testimonial .cz-testimonial-mark,
.video-popup-btn:not(.video-cover):hover,
.widget_calendar table #today,
.widget-woocommerce-currency-converter .woocs_converter_shortcode_button,
blockquote:not(.cz-testimonial):before {
	background-color: ' . $primary_color . ';
	color: ' . $primary_color_yiq . ';
}

a.badge-primary:hover,
a.badge-primary:focus {
	background-color: ' . $primary_color_darken_10p . ';
	color: ' . cartzilla_sass_yiq( $primary_color_darken_10p ) . ';
}

.btn-primary,
.product-card .added_to_cart,
.woocommerce-widget-layered-nav-dropdown__submit,
.yith-wcwl-form.wishlist-fragment .hidden-title-form input[type="submit"],
.wpforms-container-full.subscribe-form .wpforms-form button[type="submit"],
.woocommerce-widget-layered-nav .woocommerce-widget-layered-nav-dropdown__submit,
.compare-table .button,
.wp-block-button .wp-block-button__link,
.btn-outline-primary:hover,
.btn-outline-primary:not(:disabled):not(.disabled):active,
.btn-outline-primary:not(:disabled):not(.disabled).active,
.show > .btn-outline-primary.dropdown-toggle,
.custom-control-input:checked ~ .custom-control-label::before,
.custom-checkbox .custom-control-input:indeterminate ~ .custom-control-label::before,
.list-group-item.active,
.cz-filter-item.chosen .custom-control-label::before,
.nav-link.active .media-tab-media,
.nav-link.active:hover .media-tab-media,
.tagcloud > a.active,
.tagcloud > .tag-cloud-link.active, 
.shop-sidebar .woocommerce-widget-layered-nav ul li.chosen a:before,
[data-type="czgb/hero-search-form"] .hero-search-form .input-group-append .custom-select,
[data-type="czgb/hero-search-form"] .hero-search-form .input-group-append select,
.hero-search-form .input-group-append .custom-select,
.hero-search-form .input-group-append select,
.hero-search-form .input-group-append .custom-select:hover,
.hero-search-form .input-group-append select:hover,
.hero-search-form .input-group-append .custom-select:focus,
.hero-search-form .input-group-append select:focus,
.btn-primary.disabled,
.disabled.woocommerce-widget-layered-nav-dropdown__submit,
.yith-wcwl-form.wishlist-fragment .hidden-title-form input.disabled[type="submit"],
.compare-table .disabled.button,
.wp-block-button .disabled.wp-block-button__link,
.btn-primary:disabled,
.woocommerce-widget-layered-nav-dropdown__submit:disabled,
.yith-wcwl-form.wishlist-fragment .hidden-title-form input:disabled[type="submit"],
.compare-table .button:disabled,
.wp-block-button .wp-block-button__link:disabled,
.cv-form.wpforms-container .btn-primary,
.contact-form.wpforms-container .btn-primary,
div.wpforms-container-full.cv-form .btn-primary,
div.wpforms-container-full.contact-form .btn-primary {
	background-color: ' . $primary_color . ';
	border-color: ' . $primary_color . ';
	color: ' . $primary_color_yiq . ';
}

.btn-primary:hover,
.btn-primary:focus,
.product-card .added_to_cart:hover,
.product-card .added_to_cart:focus,
.woocommerce-widget-layered-nav .woocommerce-widget-layered-nav-dropdown__submit:hover,
.woocommerce-widget-layered-nav .woocommerce-widget-layered-nav-dropdown__submit:focus,
.wpforms-container-full.subscribe-form .wpforms-form button[type="submit"]:hover,
.wpforms-container-full.subscribe-form .wpforms-form button[type="submit"]:focus,
.wpforms-container-full.subscribe-form .wpforms-form button[type="submit"]:active,
.wp-block-button.is-style-outline .wp-block-button__link:hover,
.cv-form.wpforms-container .btn-primary:hover,
.contact-form.wpforms-container .btn-primary:hover,
div.wpforms-container-full.cv-form .btn-primary:hover,
div.wpforms-container-full.contact-form .btn-primary:hover,
.cv-form.wpforms-container .btn-primary:focus,
.contact-form.wpforms-container .btn-primary:focus,
div.wpforms-container-full.cv-form .btn-primary:focus,
div.wpforms-container-full.contact-form .btn-primary:focus {
	background-color: ' . $primary_color_darken_10p . ' !important;
}

.czgb-team-member .nav-link-style a:hover {
	fill: ' . $primary_color . ' !important;
}

/*
 * Accent Color
 */

.list-style li::before,
.single-product .woocommerce-Price-amount,
.single-product .price,
table.wishlist_table .product-price,
.wishlist_table.wishlist_view.responsive.mobile table .value .woocommerce-Price-amount.amount,
.dokan-product-listing .dokan-product-listing-area.cartzilla-dokan-product-listing .row-actions span.view a:before,
.btn-outline-accent.disabled,
.btn-outline-accent:disabled {
	color: ' . $accent_color . ';
}

.text-accent {
	color: ' . $accent_color . ' !important;
}

a.text-accent:hover,
a.text-accent:focus {
	color: ' . $accent_color_darken_15p . ' !important;
}

.bg-accent {
	color: ' . cartzilla_sass_yiq( $accent_color ) . ';
	background-color: ' . $accent_color . ' !important;
}

a.bg-accent:hover,
a.bg-accent:focus,
button.bg-accent:hover,
button.bg-accent:focus {
	color: ' . cartzilla_sass_yiq( $accent_color_darken_10p ) . ';
	background-color: ' . $accent_color_darken_10p . ' !important;
}

.badge-accent {
	color: ' . $accent_color_yiq . ';
	background-color: ' . $accent_color . ';
}

a.badge-accent:hover,
a.badge-accent:focus {
	color: ' . $accent_color_yiq . ';
	background-color: ' . $accent_color_darken_10p . ';
}

.btn-outline-accent,
.style-v3 .product-summary .yith-wcwl-add-to-wishlist a {
	color: ' . $accent_color . ';
	border-color: ' . $accent_color . ';
}

.btn-outline-accent:hover,
.btn-outline-accent:not(:disabled):not(.disabled):active,
.btn-outline-accent:not(:disabled):not(.disabled).active,
.show > .btn-outline-accent.dropdown-toggle,
.style-v3 .product-summary .yith-wcwl-add-to-wishlist a:hover {
	background-color: ' . $accent_color . ';
	border-color: ' . $accent_color . ';
	color: ' . $accent_color_yiq . ';
}

.btn-outline-accent:focus,
.btn-outline-accent.focus,
.btn-outline-accent:not(:disabled):not(.disabled):active:focus,
.btn-outline-accent:not(:disabled):not(.disabled).active:focus,
.show > .btn-outline-accent.dropdown-toggle:focus,
a.badge-accent:focus,
a.badge-accent.focus {
	box-shadow: 0 0 0 0 ' . cartzilla_sass_hex_to_rgba( $accent_color, '0.5' ) . ';
}
';

		return apply_filters( 'cartzilla_get_custom_color_css', $styles );
	}
}

/**
 * Add CSS in <head> for styles handled by the theme customizer
 *
 * @since 1.0.0
 * @return void
 */
if( ! function_exists( 'cartzilla_enqueue_custom_color_css' ) ) {
	function cartzilla_enqueue_custom_color_css() {
		if( get_theme_mod( 'cartzilla_enable_custom_color', 'no' ) === 'yes' ) {
			$cartzilla_theme_colors = cartzilla_get_theme_colors();
			$color_root = ':root { --primary: ' . $cartzilla_theme_colors['primary_color'] . '; --accent: ' . $cartzilla_theme_colors['accent_color'] . '; }';
			$styles = $color_root . cartzilla_get_custom_color_css();
			wp_add_inline_style( 'cartzilla-color', $styles );
		}
	}
}
add_action( 'wp_enqueue_scripts', 'cartzilla_enqueue_custom_color_css', 130 );

if( ! function_exists( 'cartzilla_enqueue_block_editor_panel_custom_color_css' ) ) {
	function cartzilla_enqueue_block_editor_panel_custom_color_css() {
		if( get_theme_mod( 'cartzilla_enable_custom_color', 'no' ) === 'yes' ) {
			$cartzilla_theme_colors = cartzilla_get_theme_colors();
			$color_root = ':root { --primary: ' . $cartzilla_theme_colors['primary_color'] . '; --accent: ' . $cartzilla_theme_colors['accent_color'] . '; }';
			$editor_styles =
'
.components-panel__body > .components-panel__body-title svg.components-panel__icon {
	color: ' . $cartzilla_theme_colors['primary_color'] . ';
}

svg path[fill="#fe696a"] {
	fill: ' . $cartzilla_theme_colors['primary_color'] . ' !important;
}

.cartzillagb-radiobutton-bg .components-radio-control__option input[value="primary"],
.cartzillagb-radiobutton-bg .components-radio-control__option input[value="bg-primary"],
.cartzillagb-radiobutton-bg .components-radio-control__option input[value="text-primary"] {
	background-color: ' . $cartzilla_theme_colors['primary_color'] . ' !important;
}

.cartzillagb-radiobutton-bg .components-radio-control__option input[value=accent],
.cartzillagb-radiobutton-bg .components-radio-control__option input[value=bg-accent],
.cartzillagb-radiobutton-bg .components-radio-control__option input[value="text-accent"] {
	background-color: ' . $cartzilla_theme_colors['accent_color'] . ' !important;
}
';
			$styles = $color_root . $editor_styles;
			wp_add_inline_style( 'czgb-style-css', $styles );
		}
	}
}
add_action( 'enqueue_block_assets', 'cartzilla_enqueue_block_editor_panel_custom_color_css' );

if( ! function_exists( 'cartzilla_enqueue_block_editor_custom_color_css' ) ) {
	function cartzilla_enqueue_block_editor_custom_color_css( $response, $parsed_args, $url ) {
		if ( content_url( '/custom_theme_color_css' ) === $url ) {
			$response = array(
				'body'		=> cartzilla_get_custom_color_css(), // E.g. 'body { background-color: #fbca04; }'
				'headers' 	=> new Requests_Utility_CaseInsensitiveDictionary(),
				'response'	=> array(
					'code'		=> 200,
					'message'	=> 'OK',
				),
				'cookies'	=> array(),
				'filename'	=> null,
			);
		}

		return $response;
	}
}
add_filter( 'pre_http_request', 'cartzilla_enqueue_block_editor_custom_color_css', 10, 3 );
