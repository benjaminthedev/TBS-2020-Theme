<?php
/**
 * Template part for displaying the "List" blog layout (with sidebar)
 *
 * @author Createx Studio
 * @package Cartzilla
 */

$sidebar = function_exists( 'cartzilla_posts_sidebar' ) ? cartzilla_posts_sidebar() : 'right-sidebar';
$has_sidebar = in_array( $sidebar, [ 'left-sidebar', 'right-sidebar' ] ) ? true : false;

/**
 * Fires before the posts section
 */
do_action( 'cartzilla_posts_before' );

?>
<div class="<?php echo ! ( function_exists( 'cartzilla_get_shop_page_style' ) && cartzilla_get_shop_page_style() === 'style-v3' ) ? 'container' : 'container-fluid';?> pb-5 mb-2 mb-md-4">

	<?php do_action( 'cartzilla_posts_content_before' ); ?>

	<div class="row pt-5<?php if( ! $has_sidebar ) echo esc_attr( ' justify-content-center' ); ?>">
		<section class="<?php echo esc_attr( $has_sidebar ? 'col-lg-8' : 'col-lg-9' ); if( $sidebar == 'left-sidebar' ) echo esc_attr( ' order-lg-1' ); ?>">

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
		<?php if( $has_sidebar ) : ?>
			<aside class="col-lg-4">
				<?php get_sidebar(); ?>
			</aside>
		<?php endif; ?>
	</div>

	<?php do_action( 'cartzilla_posts_content_after' ); ?>

</div>
<?php

/**
 * Fires after the posts section
 */
do_action( 'cartzilla_posts_after' );
