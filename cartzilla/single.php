<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package Cartzilla
 */

get_header();

while ( have_posts() ) :
	the_post();

	/**
	 * Fires before the single post content
	 */
	do_action( 'cartzilla_single_post_before' );

	get_template_part( 'templates/blog/content', 'single' );

	/**
	 * Fires after the single post content
	 */
	do_action( 'cartzilla_single_post_after' );

endwhile;

get_footer();
