<?php
/**
 * The template for displaying the Helpcenter Page .
 *
 * This page template will display any functions hooked into the `cartzilla_helpcenter` action.
 *
 * Template name: Helpcenter
 *
 * @package Cartzilla
 */

get_header();

if ( cartzilla_is_wedocs_activated() ):

    do_action( 'cartzilla_helpcenter' );

else: 

    while ( have_posts() ) : the_post(); ?>
        <article <?php post_class(); ?>>
            <?php
            /**
             * Fires before the single post content
             *
             * NOTE: this hook executes inside the loop
             */
            do_action( 'cartzilla_page_before' );

            the_content();

            /**
             * Fires after the single post content
             *
             * NOTE: this hook executes inside the loop
             */
            do_action( 'cartzilla_page_after' );
            ?>
        </article>
    <?php endwhile;

endif;

get_footer();