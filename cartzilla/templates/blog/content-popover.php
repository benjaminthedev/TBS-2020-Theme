<?php
/**
 * Template part for displaying a post info within a popover in post prev/next navigation
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Cartzilla
 */

?>
<div class="media align-items-center">
	<?php
	if ( has_post_thumbnail() && ! post_password_required() && ! is_attachment() ) :
		/*
		 * Perform multiple replacements:
		 * 1. Remove the height attribute
		 * 2. Replace the width attribute with width="60"
		 */
		echo preg_replace(
			[ '/height="\d*"\s/', '/width="\d*"/' ],
			[ '', 'width="60"' ],
			wp_get_attachment_image( (int) get_post_thumbnail_id(), 'thumbnail', false, [
				'class' => 'mr-3',
				'alt'   => the_title_attribute( [ 'echo' => false ] ),
			] )
		);
	endif; ?>
	<div class="media-body">
		<?php the_title( '<h6  class="font-size-sm font-weight-semibold mb-0">', '</h6>' ); ?>
		<span class="d-block font-size-xs text-muted"><?php
			/* translators: posted by, %s: author name */
			echo sprintf( esc_html_x( 'by %s', 'front-end', 'cartzilla' ), esc_html( get_the_author() ) );
		?></span>
	</div>
</div>
