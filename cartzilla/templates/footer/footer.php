<?php
/**
 * Template for displaying the "v1" footer
 *
 * This is a fallback for default footer
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 */

$footer = function_exists( 'cartzilla_footer_version' ) ? cartzilla_footer_version() : 'v1';
get_template_part( 'templates/footer/footer', $footer );


