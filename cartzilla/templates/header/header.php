<?php
/**
 * Template for displaying the "1 Level Light" header
 *
 * This is a fallback for default header
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 */

$header = function_exists( 'cartzilla_header_layout' ) ? cartzilla_header_layout() : '1-level-light';
get_template_part( 'templates/header/header', $header );