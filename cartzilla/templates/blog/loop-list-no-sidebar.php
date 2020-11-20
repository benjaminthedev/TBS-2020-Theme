<?php
/**
 * Template part for displaying the "List without sidebar" blog layout
 *
 * @author Createx Studio
 * @package Cartzilla
 */

/**
 * Fires before the posts section
 */
do_action( 'cartzilla_posts_before' );

?>
<div class="<?php echo ! ( function_exists( 'cartzilla_get_shop_page_style' ) && cartzilla_get_shop_page_style() === 'style-v3' ) ? 'container' : 'container-fluid';?> pb-5 mb-2 mb-md-4">

	<?php do_action( 'cartzilla_posts_content_before' ); ?>

	<div class="row justify-content-center pt-5">
		<section class="col-lg-9">

			<?php
			/**
			 * Fires right before the blog loop starts
			 */
			do_action( 'cartzilla_loop_before' );

			while ( have_posts() ) :
				the_post();
				get_template_part( 'templates/blog/content', 'list' );
			endwhile;

			/**
			 * Fires right after the blog loop
			 */
			do_action( 'cartzilla_loop_after' ); ?>

		</section>
	</div>

	<?php do_action( 'cartzilla_posts_content_after' ); ?>

</div>
<?php

/**
 * Fires after the posts section
 */
do_action( 'cartzilla_posts_after' );
