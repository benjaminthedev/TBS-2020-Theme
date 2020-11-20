<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Cartzilla
 */

get_header();

/**
 * Fires at the most top of blog posts listing
 *
 * Note: at this moment we don't know whether we have posts or not.
 */
do_action( 'cartzilla_index_before' );

if ( have_posts() ) {
	get_template_part( 'templates/blog/loop', '' );
} else {
	get_template_part( 'templates/blog/none', '' );
}

/**
 * Fires at the most bottom of blog posts listing
 *
 * This action doesn't consider where we have posts or not.
 */
do_action( 'cartzilla_index_after' );

get_footer();
