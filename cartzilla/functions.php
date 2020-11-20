<?php
/**
 * Cartzilla engine room
 *
 * @package cartzilla
 */

/**
 * Assign the Cartzilla version to a var
 */
$theme              = wp_get_theme( 'cartzilla' );
$cartzilla_version = $theme['Version'];

/**
 * Set the content width based on the theme's design and stylesheet.
 */
if ( ! isset( $content_width ) ) {
	$content_width = 980; /* pixels */
}

$cartzilla = (object) array(
	'version'    => $cartzilla_version,

	/**
	 * Initialize all the things.
	 */
	'main'       => require get_template_directory() . '/inc/class-cartzilla.php',
	'customizer' => require get_template_directory() . '/inc/customizer/class-cartzilla-customizer.php',
);

/**
 * TGM Plugin Activation class.
 */
require get_template_directory() . '/classes/class-tgm-plugin-activation.php';

/**
 * Customizer Functions.
 */
require get_template_directory() . '/inc/customizer/cartzilla-customizer-functions.php';

/**
 * Departments Menu Walker
 */
require get_template_directory() . '/classes/walkers/class-cartzilla-walker-departments-menu.php';

/**
 * Menu Walker
 */
require get_template_directory() . '/classes/walkers/class-wp-bootstrap-navwalker.php';

/**
 * Category Walker
 */
require get_template_directory() . '/classes/walkers/class-cartzilla-walker-category.php';

/**
 * Custom Comment Walker template.
 */
require get_template_directory() . '/classes/walkers/class-cartzilla-walker-comment.php';

/**
 * Functions used in Cartzilla
 */
require get_template_directory() . '/inc/cartzilla-functions.php';

/**
 * Hooks and Filters used in Cartzilla
 */
require get_template_directory() . '/inc/cartzilla-template-hooks.php';

/**
 * Tags and Functions used in Cartzilla
 */
require get_template_directory() . '/inc/cartzilla-template-functions.php';

if ( function_exists( 'cartzilla_is_jetpack_activated' ) && cartzilla_is_jetpack_activated() ) {
	require get_template_directory() . '/inc/jetpack/cartzilla-jetpack-functions.php';
}

if ( cartzilla_is_woocommerce_activated() ) {
	$cartzilla->woocommerce                  = require get_template_directory() . '/inc/woocommerce/class-cartzilla-woocommerce.php';
	$cartzilla->woocommerce_customizer       = require get_template_directory() . '/inc/woocommerce/class-cartzilla-woocommerce-customizer.php';
	
	require get_template_directory() . '/inc/woocommerce/cartzilla-woocommerce-template-hooks.php';
	require get_template_directory() . '/inc/woocommerce/cartzilla-woocommerce-template-functions.php';
	require get_template_directory() . '/inc/woocommerce/integrations.php';
}

if ( cartzilla_is_dokan_activated() ) {
	$cartzilla->dokan_customizer = require get_template_directory() . '/inc/dokan/class-cartzilla-dokan-customizer.php';
	require get_template_directory() . '/inc/dokan/cartzilla-dokan-functions.php';
	require get_template_directory() . '/inc/dokan/cartzilla-dokan-template-hooks.php';
	require get_template_directory() . '/inc/dokan/cartzilla-dokan-template-functions.php';
}

if ( cartzilla_is_wedocs_activated() ) {
	$cartzilla->wedocs               = require get_template_directory() . '/inc/wedocs/class-cartzilla-wedocs.php';
	$cartzilla->wedocs_customizer    = require get_template_directory() . '/inc/wedocs/class-cartzilla-wedocs-customizer.php';

	require get_template_directory() . '/inc/wedocs/cartzilla-wedocs-template-hooks.php';
	require get_template_directory() . '/inc/wedocs/cartzilla-wedocs-template-functions.php';
	require get_template_directory() . '/inc/wedocs/cartzilla-wedocs-functions.php';
}

if ( cartzilla_is_ocdi_activated() ) {
    require get_template_directory() . '/inc/ocdi/hooks.php';
    require get_template_directory() . '/inc/ocdi/functions.php';
}

/**
 * Functions used for Cartzilla Custom Theme Color
 */
require get_template_directory() . '/inc/cartzilla-custom-color-functions.php';

/**
 * Note: Do not add any custom code here. Please use a custom plugin so that your customizations aren't lost during updates.
 * https://github.com/woocommerce/theme-customisations
 */
