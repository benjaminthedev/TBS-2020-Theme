<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 * @package Cartzilla
 */

get_header();?>

	<div id="primary" class="content-area">

        <?php
        while ( have_posts() ) :
            
            the_post();

            do_action( 'cartzilla_page_before' );

            get_template_part( 'templates/contents/content', 'page' );
            // If comments are open or we have at least one comment, load up the comment template.
			if ( comments_open() || get_comments_number() ) :
				comments_template();
			endif;

            /**
             * Functions hooked in to cartzilla_page_after action
             *
             * @hooked cartzilla_display_comments - 10
             */
            do_action( 'cartzilla_page_after' );

        endwhile; // End of the loop.
        ?>
        
    </div><!-- #primary -->

<?php
get_footer();



	

