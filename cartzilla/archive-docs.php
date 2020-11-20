<?php
/**
 * The template for displaying archive pages of docs
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Cartzilla
 */

get_header();

/**
 * Fires at the most top of the archive page content
 *
 * Note: at this moment we don't know whether we have posts or not.
 */
do_action( 'cartzilla_archive_before' );

if ( have_posts() ) {
    get_template_part( 'templates/docs/loop', '' );
} else {
    get_template_part( 'templates/blog/none', '' );
}

/**
 * Fires at the most bottom of the archive page content
 *
 * This action doesn't consider where we have posts or not.
 */
do_action( 'cartzilla_archive_after' );

get_footer();
