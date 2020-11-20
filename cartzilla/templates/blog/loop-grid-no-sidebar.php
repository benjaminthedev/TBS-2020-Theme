<?php
/**
 * Template part for displaying the "Grid without sidebar" blog layout
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

	<div class="pt-5">

		<?php
		/**
		 * Fires right before the blog loop starts
		 */
		do_action( 'cartzilla_loop_before' ); ?>

		<div class="cz-masonry-grid" data-columns="3">
			<?php
			while ( have_posts() ) :
				the_post();
				get_template_part( 'templates/blog/content', 'grid' );
			endwhile; ?>
		</div>
		<hr class="pb-4">

		<?php
		/**
		 * Fires right after the blog loop
		 */
		do_action( 'cartzilla_loop_after' ); ?>

	</div>

	<?php do_action( 'cartzilla_posts_content_after' ); ?>

</div>
<?php

/**
 * Fires after the posts section
 */
do_action( 'cartzilla_posts_after' );
