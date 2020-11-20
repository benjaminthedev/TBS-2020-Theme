<?php
/**
 * The sidebar containing the main widget area
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Cartzilla
 */

if ( ! is_active_sidebar( 'blog-sidebar' ) ) {
	return;
}

if( is_single() ) {
	$sidebar = function_exists( 'cartzilla_post_layout' ) ? cartzilla_post_layout() : 'right-sidebar';
} else {
	$sidebar = function_exists( 'cartzilla_posts_sidebar' ) ? cartzilla_posts_sidebar() : 'right-sidebar';
}

?>
<div class="cz-sidebar <?php echo esc_attr( $sidebar == 'left-sidebar' ? 'border-right mr-lg-auto' : 'border-left ml-lg-auto' ); ?>" id="blog-sidebar">
	<div class="cz-sidebar-header box-shadow-sm">
		<button class="close ml-auto" type="button" data-dismiss="sidebar"
		        aria-label="<?php
		        /* translators: close blog sidebar button label */
		        echo esc_attr_x( 'Close', 'front-end', 'cartzilla' ); ?>">
			<span class="d-inline-block font-size-xs font-weight-normal align-middle">
				<?php echo esc_html_x( 'Close sidebar', 'front-end', 'cartzilla' ); ?>
			</span>
			<span class="d-inline-block align-middle ml-2" aria-hidden="true">&times;</span>
		</button>
	</div>
	<div class="cz-sidebar-body py-lg-1" data-simplebar data-simplebar-auto-hide="true">
		<?php dynamic_sidebar( 'blog-sidebar' ); ?>
	</div>
</div>
