<?php
/**
 * Template part for displaying the "No content" without a sidebar blog layout
 *
 * @package Cartzilla
 */

?>
<div class="page-title bg-secondary py-4">
	<div class="<?php echo ! ( function_exists( 'cartzilla_get_shop_page_style' ) && cartzilla_get_shop_page_style() === 'style-v3' ) ? 'container' : 'container-fluid';?> d-lg-flex justify-content-between py-2 py-lg-3">
		<div class="order-lg-2 mb-3 mb-lg-0 pt-lg-2">
			<?php cartzilla_breadcrumbs(); ?>
		</div>
		<div class="order-lg-1 pr-lg-4 text-center text-lg-left">
			<h1 class="h3 mb-0"><?php echo esc_html_x( 'Nothing found', 'front-end', 'cartzilla' ); ?></h1>
		</div>
	</div>
</div>
<div class="<?php echo ! ( function_exists( 'cartzilla_get_shop_page_style' ) && cartzilla_get_shop_page_style() === 'style-v3' ) ? 'container' : 'container-fluid';?> pb-5 mb-2 mb-md-4">
	<div class="pt-5">
		<?php if ( is_home() && current_user_can( 'publish_posts' ) ) : ?>
			<p>
				<?php echo esc_html_x( 'Ready to publish your first post?', 'front-end', 'cartzilla' ); ?>
				<a href="<?php echo esc_url( admin_url( 'post-new.php' ) ); ?>"><?php
					/* translators: ready to publish your first post? */
					echo esc_html_x( 'Get started here', 'front-end', 'cartzilla' ); ?></a>
			</p>
		<?php else :?>
			<p><?php echo esc_html_x( 'It seems we can&rsquo;t find what you&rsquo;re looking for.', 'front-end', 'cartzilla' ); ?></p>
		<?php endif; ?>
	</div>
</div>
