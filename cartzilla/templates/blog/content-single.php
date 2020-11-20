<?php
/**
 * Template for displaying single post with sidebar
 *
 * This is a fallback template.
 *
 * @see single.php
 *
 * @package Cartzilla
 */

$blog_layout = function_exists( 'cartzilla_post_layout' ) ? cartzilla_post_layout() : 'right-sidebar';
$has_sidebar = in_array( $blog_layout, [ 'left-sidebar', 'right-sidebar' ] ) ? true : false;

$post_class	= $has_sidebar ? 'col-lg-8' : 'col-lg-9';
if( $blog_layout == 'left-sidebar' ) {
	$post_class	.= ' order-lg-1';
}

?>
<article id="post-<?php the_ID(); ?>" <?php post_class( $post_class ); ?>>

	<?php
	do_action( 'cartzilla_single_post_top', $blog_layout );

	/**
	 * Functions hooked into cartzilla_single_post add_action
	 *
	 * @hooked cartzilla_post_header          - 10
	 * @hooked cartzilla_post_meta            - 20
	 * @hooked cartzilla_post_content         - 30
	 */
	do_action( 'cartzilla_single_post', $blog_layout );

	/**
	 * Functions hooked in to cartzilla_single_post_bottom action
	 *
	 * @hooked cartzilla_post_nav         - 10
	 * @hooked cartzilla_display_comments - 20
	 */
	do_action( 'cartzilla_single_post_bottom', $blog_layout );
	?>

</article><!-- #post-## -->