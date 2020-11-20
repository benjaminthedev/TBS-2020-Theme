<?php
/**
 * Cartzilla functions.
 *
 * @package cartzilla
 */

if ( ! function_exists( 'cartzilla_is_woocommerce_activated' ) ) {
	/**
	 * Query WooCommerce activation
	 */
	function cartzilla_is_woocommerce_activated() {
		return class_exists( 'WooCommerce' ) ? true : false;
	}
}

if ( ! function_exists( 'cartzilla_is_mas_static_content_activated' ) ) {
	/**
	 * Query MAS Static Content activation
	 */
	function cartzilla_is_mas_static_content_activated() {
		return class_exists( 'Mas_Static_Content' ) ? true : false;
	}
}

if ( ! function_exists( 'cartzilla_is_jetpack_activated' ) ) {
	/**
	 * Query JetPack activation
	 */
	function cartzilla_is_jetpack_activated() {
		return class_exists( 'Jetpack' ) ? true : false;
	}
}

if ( ! function_exists( 'cartzilla_is_wedocs_activated' ) ) {
	/**
	 * Query weDocs Activation
	 */
	function cartzilla_is_wedocs_activated() {
		return class_exists( 'WeDocs' ) ? true: false;
	}
}

if( ! function_exists( 'cartzilla_is_ocdi_activated' ) ) {
	/**
	 * Check if One Click Demo Import is activated
	 */
	function cartzilla_is_ocdi_activated() {
		return class_exists( 'OCDI_Plugin' ) ? true : false;
	}
}

/**
 * Query WooCommerce Extension Activation.
 * @var  $extension main extension class name
 * @return boolean
 */
function cartzilla_is_woocommerce_extension_activated( $extension ) {

	if( cartzilla_is_woocommerce_activated() ) {
		$is_activated = class_exists( $extension ) ? true : false;
	} else {
		$is_activated = false;
	}

	return $is_activated;
}

if( ! function_exists( 'cartzilla_is_yith_wcwl_activated' ) ) {
	/**
	 * Checks if YITH Wishlist is activated
	 *
	 * @return boolean
	 */
	function cartzilla_is_yith_wcwl_activated() {
		return cartzilla_is_woocommerce_extension_activated( 'YITH_WCWL' );
	}
}

if( ! function_exists( 'cartzilla_is_yith_woocompare_activated' ) ) {
	/**
	 * Checks if YITH WooCompare is activated
	 *
	 * @return boolean
	 */
	function cartzilla_is_yith_woocompare_activated() {
		return cartzilla_is_woocommerce_extension_activated( 'YITH_Woocompare' );
	}
}

if( ! function_exists( 'cartzilla_is_dokan_activated' ) ) {
	/**
	 * Checks if Dokan is activated
	 *
	 * @return boolean
	 */
	function cartzilla_is_dokan_activated() {
		return cartzilla_is_woocommerce_extension_activated( 'WeDevs_Dokan' );
	}
}

if( ! function_exists( 'cartzilla_is_dokan_pro_activated' ) ) {
	/**
	 * Checks if Dokan Pro is activated
	 *
	 * @return boolean
	 */
	function cartzilla_is_dokan_pro_activated() {
		return cartzilla_is_woocommerce_extension_activated( 'Dokan_Pro' );
	}
}

if( ! function_exists( 'cartzilla_is_mas_wcvs_activated' ) ) {
	/**
	 * Checks if MAS WooCommerce Variation Swatches activated
	 *
	 * @return boolean
	 */
	function cartzilla_is_mas_wcvs_activated() {
		return cartzilla_is_woocommerce_extension_activated( 'MAS_WCVS' );
	}
}

if ( ! function_exists( 'cartzilla_is_mas_static_content_activated' ) ) {
	/**
	 * Checks if Mas Static Content is activated
	 *
	 * @return boolean
	 */
	function cartzilla_is_mas_static_content_activated() {
		return class_exists( 'Mas_Static_Content' ) ? true : false;
	}
}

if ( ! function_exists( 'cartzilla_get_classes' ) ) {
	/**
	 * Prepare and sanitize the class set.
	 *
	 * Caution! This function sanitize each class,
	 * but don't escape the returned result.
	 *
	 * E.g. [ 'my', 'cool', 'class' ] or 'my cool class'
	 * will be sanitized and converted to "my cool class".
	 *
	 * @param array|string $classes
	 *
	 * @return string
	 */
	function cartzilla_get_classes( $classes ) {
		if ( empty( $classes ) ) {
			return '';
		}

		if ( is_string( $classes ) ) {
			$classes = (array) $classes;
		}

		// remove empty elements before loop, if exists
		// and explode array into the flat list
		$classes   = array_filter( $classes );
		$class_set = array();
		foreach ( $classes as $class ) {
			$class = trim( $class );
			if ( false === strpos( $class, ' ' ) ) {
				$class_set[] = $class;

				continue;
			}

			// replace possible multiple whitespaces with single one
			$class = preg_replace( '/\\s\\s+/', ' ', $class );
			foreach ( explode( ' ', $class ) as $subclass ) {
				$class_set[] = trim( $subclass );
			}
			unset( $subclass );
		}
		unset( $class );

		// do not duplicate
		$class_set = array_unique( $class_set );
		$class_set = array_map( 'sanitize_html_class', $class_set );
		$class_set = array_filter( $class_set );

		$set = implode( ' ', $class_set );

		return $set;
	}
}

if ( ! function_exists( 'cartzilla_is_active_sidebars' ) ) {
	/**
	 * This function acts like {@see is_active_sidebar()},
	 * but supports multiple sidebars.
	 *
	 * NOTE: if at least one sidebar active this function returns true
	 *
	 * Another words you can pass some sidebar IDs and if
	 * one of them is active this function returns true.
	 *
	 * @param array $sidebars A list of sidebars to check
	 *
	 * @return bool
	 */
	function cartzilla_is_active_sidebars( $sidebars = array() ) {
		if ( empty( $sidebars ) ) {
			return false;
		}

		$sidebars_widgets = wp_get_sidebars_widgets();
		$current_sidebars = array_intersect_key( $sidebars_widgets, array_flip( $sidebars ) );
		$active_sidebars  = array_filter( $current_sidebars );

		return count( $active_sidebars ) > 0;
	}
}

if ( ! function_exists( 'cartzilla_clean' ) ) {
	/**
	 * Clean variables using sanitize_text_field. Arrays are cleaned recursively.
	 * Non-scalar values are ignored.
	 *
	 * @param string|array $var Data to sanitize.
	 * @return string|array
	 */
	function cartzilla_clean( $var ) {
		if ( is_array( $var ) ) {
			return array_map( 'cartzilla_clean', $var );
		} else {
			return is_scalar( $var ) ? sanitize_text_field( $var ) : $var;
		}
	}
}

if ( ! function_exists( 'cartzilla_strlen' ) ) {
	function cartzilla_strlen( $var ) {
		if ( is_array( $var ) ) {
			return array_map( 'cartzilla_strlen', $var );
		} else {
			return strlen( $var );
		}
	}
}

function cartzilla_number_format_i18n( $n ) {
	// first strip any formatting;
	$n = ( 0 + str_replace( ",", "", $n ) );

	// is this a number?
	if( ! is_numeric( $n ) ) {
		return $n;
	}

	// now filter it;
	if( $n >= 1000000000000 ) {
		return round( ( $n/1000000000000 ), 1 ) . 'T';
	} elseif( $n >= 1000000000 ) {
		return round( ( $n/1000000000 ), 1 ) . 'B';
	} elseif( $n >= 1000000 ) {
		return round( ( $n/1000000 ), 1 ) . 'M';
	} elseif( $n >= 10000 ) {
		return round( ( $n/10000 ), 10 ) . 'K';
	}

	return number_format_i18n( $n );
}

if ( ! function_exists( 'cartzilla_sort_priority_callback' ) ) {
	function cartzilla_sort_priority_callback( $a, $b ) {
		if ( ! isset( $a['priority'], $b['priority'] ) || $a['priority'] === $b['priority'] ) {
			return 0;
		}
		return ( $a['priority'] < $b['priority'] ) ? -1 : 1;
	}
}

if ( ! function_exists( 'cartzilla_pr' ) ) {
	function cartzilla_pr( $var ) {
		echo '<pre>' . print_r( $var, 1 ) . '</pre>';
	}
}

/**
 * Enables template debug mode
 *
 */
function cartzilla_template_debug_mode() {
	if ( ! defined( 'FRONT_TEMPLATE_DEBUG_MODE' ) ) {
		$status_options = get_option( 'woocommerce_status_options', array() );
		if ( ! empty( $status_options['template_debug_mode'] ) && current_user_can( 'manage_options' ) ) {
			define( 'FRONT_TEMPLATE_DEBUG_MODE', true );
		} else {
			define( 'FRONT_TEMPLATE_DEBUG_MODE', false );
		}
	}
}
add_action( 'after_setup_theme', 'cartzilla_template_debug_mode', 10 );

/**
 * Get other templates (e.g. product attributes) passing attributes and including the file.
 *
 * @access public
 * @param string $template_name
 * @param array $args (default: array())
 * @param string $template_path (default: '')
 * @param string $default_path (default: '')
 * @return void
 */
function cartzilla_get_template( $template_name, $args = array(), $template_path = '', $default_path = '' ) {
	if ( $args && is_array( $args ) ) {
		extract( $args );
	}

	$located = cartzilla_locate_template( $template_name, $template_path, $default_path );

	if ( ! file_exists( $located ) ) {
		_doing_it_wrong( __FUNCTION__, sprintf( '<code>%s</code> does not exist.', $located ), '2.1' );
		return;
	}

	// Allow 3rd party plugin filter template file from their plugin
	$located = apply_filters( 'cartzilla_get_template', $located, $template_name, $args, $template_path, $default_path );

	do_action( 'cartzilla_before_template_part', $template_name, $template_path, $located, $args );

	include( $located );
}

/**
 * Locate a template and return the path for inclusion.
 *
 * This is the load order:
 *
 *      yourtheme       /   $template_path  /   $template_name
 *      yourtheme       /   $template_name
 *      $default_path   /   $template_name
 *
 * @access public
 * @param string $template_name
 * @param string $template_path (default: '')
 * @param string $default_path (default: '')
 * @return string
 */
function cartzilla_locate_template( $template_name, $template_path = '', $default_path = '' ) {
	if ( ! $template_path ) {
		$template_path = 'templates/';
	}

	if ( ! $default_path ) {
		$default_path = 'templates/';
	}

	// Look within passed path within the theme - this is priority
	$template = locate_template(
		array(
			trailingslashit( $template_path ) . $template_name,
			$template_name
		)
	);

	// Get default template
	if ( ! $template || FRONT_TEMPLATE_DEBUG_MODE ) {
		$template = $default_path . $template_name;
	}

	// Return what we found
	return apply_filters( 'cartzilla_locate_template', $template, $template_name, $template_path );
}

/**
 * Call a shortcode function by tag name.
 *
 * @since  1.4.6
 *
 * @param string $tag     The shortcode whose function to call.
 * @param array  $atts    The attributes to pass to the shortcode function. Optional.
 * @param array  $content The shortcode's content. Default is null (none).
 *
 * @return string|bool False on failure, the result of the shortcode on success.
 */
function cartzilla_do_shortcode( $tag, array $atts = array(), $content = null ) {
	global $shortcode_tags;

	if ( ! isset( $shortcode_tags[ $tag ] ) ) {
		return false;
	}

	return call_user_func( $shortcode_tags[ $tag ], $atts, $content, $tag );
}

/**
 * Adjust a hex color brightness
 * Allows us to create hover styles for custom link colors
 *
 * @param  strong  $hex   hex color e.g. #111111.
 * @param  integer $steps factor by which to brighten/darken ranging from -255 (darken) to 255 (brighten).
 * @return string        brightened/darkened hex color
 * @since  1.0.0
 */
function cartzilla_adjust_color_brightness( $hex, $steps ) {
	// Steps should be between -255 and 255. Negative = darker, positive = lighter.
	$steps = max( -255, min( 255, $steps ) );

	// Format the hex color string.
	$hex = str_replace( '#', '', $hex );

	if ( 3 === strlen( $hex ) ) {
		$hex = str_repeat( substr( $hex, 0, 1 ), 2 ) . str_repeat( substr( $hex, 1, 1 ), 2 ) . str_repeat( substr( $hex, 2, 1 ), 2 );
	}

	// Get decimal values.
	$r = hexdec( substr( $hex, 0, 2 ) );
	$g = hexdec( substr( $hex, 2, 2 ) );
	$b = hexdec( substr( $hex, 4, 2 ) );

	// Adjust number of steps and keep it inside 0 to 255.
	$r = max( 0, min( 255, $r + $steps ) );
	$g = max( 0, min( 255, $g + $steps ) );
	$b = max( 0, min( 255, $b + $steps ) );

	$r_hex = str_pad( dechex( $r ), 2, '0', STR_PAD_LEFT );
	$g_hex = str_pad( dechex( $g ), 2, '0', STR_PAD_LEFT );
	$b_hex = str_pad( dechex( $b ), 2, '0', STR_PAD_LEFT );

	return '#' . $r_hex . $g_hex . $b_hex;
}

/**
 * Sanitizes choices (selects / radios)
 * Checks that the input matches one of the available choices
 *
 * @param array $input the available choices.
 * @param array $setting the setting object.
 * @since  1.3.0
 */
function cartzilla_sanitize_choices( $input, $setting ) {
	// Ensure input is a slug.
	$input = sanitize_key( $input );

	// Get list of choices from the control associated with the setting.
	$choices = $setting->manager->get_control( $setting->id )->choices;

	// If the input is a valid key, return it; otherwise, return the default.
	return ( array_key_exists( $input, $choices ) ? $input : $setting->default );
}

/**
 * Checkbox sanitization callback.
 *
 * Sanitization callback for 'checkbox' type controls. This callback sanitizes `$checked`
 * as a boolean value, either TRUE or FALSE.
 *
 * @param bool $checked Whether the checkbox is checked.
 * @return bool Whether the checkbox is checked.
 * @since  1.5.0
 */
function cartzilla_sanitize_checkbox( $checked ) {
	return ( ( isset( $checked ) && true === $checked ) ? true : false );
}

/**
 * Cartzilla Sanitize Hex Color
 *
 * @param string $color The color as a hex.
 * @todo remove in 2.1.
 */
function cartzilla_sanitize_hex_color( $color ) {
	_deprecated_function( 'cartzilla_sanitize_hex_color', '2.0', 'sanitize_hex_color' );

	if ( '' === $color ) {
		return '';
	}

	// 3 or 6 hex digits, or the empty string.
	if ( preg_match( '|^#([A-Fa-f0-9]{3}){1,2}$|', $color ) ) {
		return $color;
	}

	return null;
}

/*
 * Remove action of anonymous class object
 */
if ( ! function_exists( 'cartzilla_remove_class_action' ) ) {
	function cartzilla_remove_class_action( $hook_name = '', $class_name = '', $method_name = '', $priority = 10 ) {
		global $wp_filter;
		// Take only filters on right hook name and priority
		if ( ! isset( $wp_filter[ $hook_name ][ $priority ] ) || ! is_array( $wp_filter[ $hook_name ][ $priority ] ) ) {
			return false;
		}
		// Loop on filters registered
		foreach ( (array) $wp_filter[ $hook_name ][ $priority ] as $unique_id => $filter_array ) {
			// Test if filter is an array ! (always for class/method)
			if ( isset( $filter_array['function'] ) && is_array( $filter_array['function'] ) ) {
				// Test if object is a class, class and method is equal to param !
				if ( is_object( $filter_array['function'][0] ) && get_class( $filter_array['function'][0] ) && get_class( $filter_array['function'][0] ) == $class_name && $filter_array['function'][1] == $method_name ) {
					// Test for WordPress >= 4.7 WP_Hook class (https://make.wordpress.org/core/2016/09/08/wp_hook-next-generation-actions-and-filters/)
					if ( is_a( $wp_filter[ $hook_name ], 'WP_Hook' ) ) {
						unset( $wp_filter[ $hook_name ]->callbacks[ $priority ][ $unique_id ] );
					} else {
						unset( $wp_filter[ $hook_name ][ $priority ][ $unique_id ] );
					}
				}
			}
		}
		return false;
	}
}

function cz_has_children() {
	global $post;
	return count( get_posts( array( 'post_parent' => $post->ID, 'post_type' => $post->post_type ) ) );
}

/**
 * Get current page depth
 *
 * @return integer
 */
function cz_get_current_page_depth(){
	global $wp_query;
	 
	$object = $wp_query->get_queried_object();
	$parent_id  = $object->post_parent;
	$depth = 0;
	while($parent_id > 0){
		$page = get_page($parent_id);
		$parent_id = $page->post_parent;
		$depth++;
	}

	return $depth;
}

if ( ! function_exists( 'cartzilla_display_button_component' ) ) {
	function cartzilla_display_button_component( $args = array() ) {
		$defaults = array(
			'className' => '',
			'size' => apply_filters( 'cartzilla_custom_button_size', 'default' ),
			'animation' => apply_filters( 'cartzilla_custom_button_animation', 'none' ),
			'delay' => apply_filters( 'cartzilla_custom_button_delay', 'none' ),
			'shape' => apply_filters( 'cartzilla_custom_button_shape', 'default' ),
			'backgroundColor' => apply_filters( 'cartzilla_custom_button_bg','primary' ),
			'text' => apply_filters( 'cartzilla_custom_button_text',  esc_html__( 'Buy Now', 'cartzilla' ) ),
			'design' => apply_filters( 'cartzilla_custom_button_design', 'solid' ),
			'shadow' => apply_filters( 'cartzilla_custom_button_shadow', false ),
			'iconAfterText' => apply_filters( 'cartzilla_custom_button_icon_after_text', false ),
			'buttonIcon' => apply_filters( 'cartzilla_custom_is_button_icon',false ),
			'url' => apply_filters( 'cartzilla_custom_button_url', '#' ),
			'icon' => apply_filters( 'cartzilla_custom_button_icon','czi-cart' ),
			'isSelected' => null,
		);

		$args = wp_parse_args( $args, $defaults );
		extract( $args );

		$mainClasses = array( 'czgb-button', 'btn' );
		if( $design != 'solid' ) {
			$mainClasses[] = 'btn-' . $design . '-' . $backgroundColor; 
		} else {
			$mainClasses[] = 'btn-' . $backgroundColor;
		}

		if( $size ) {
			$mainClasses[] = 'btn-' . $size ;
		}
		
		if( $buttonIcon ) {
			$mainClasses[] = 'button-icon czgb-button--has-icon';
		}

		if( $shape == 'default' ) {
			$mainClasses[] = '';
		} else {
			$mainClasses[] = 'btn-' . $shape;
		}

		if( $animation ) {
			$mainClasses[] = $animation;
		}

		if( $delay ) {
			$mainClasses[] = $delay;
		}

		if( $shadow ) {
			$mainClasses[] = 'btn-shadow';
		}

		if( $icon && substr( $icon, 0, 3 ) === "czgb" ) {
			$mainClasses[] = 'button-icon';
		}

		$iconPrefix = substr( $icon, 0, 3 );

		if ( $iconPrefix =='czi' ) {
			$iconClassNames = $icon; 
		} else {
			$iconClassNames =  str_replace( $iconPrefix, $iconPrefix . ' fa', $icon );
		}

		?>
		<a href="<?php echo esc_url( $url ); ?>" class="<?php echo esc_attr( implode( ' ', $mainClasses ) ); ?>">

			<?php if( $icon && ! $iconAfterText ) { ?>
				<i class="<?php echo esc_attr($iconClassNames); ?> mr-1"></i>
			<?php } ?>
			<?php if ( ! $buttonIcon ) { ?>
				 <span class="czgb-button--inner"><?php echo esc_html($text);?></span>
			<?php } ?>

			<?php if ( $icon && $iconAfterText ) { ?>
				<i class="<?php echo esc_attr($iconClassNames); ?> ml-2 mr-n1"></i>
			<?php } ?>
		</a>
		<?php
	}
}
