<?php
/**
 * Template part for displaying the tile with a "post" type on a search results page.
 *
 * @package Cartzilla
 */
?>
<article <?php post_class( 'search-results-item pb-3 mb-3 border-bottom' ); ?>>
	<div class="badge badge-warning mb-2">
		<?php
		/* translators: post type badge on a search results page */
		echo esc_html_x( 'Post', 'front-end', 'cartzilla' ); ?>
	</div>
	<?php
	the_title(
		sprintf( '<h2 class="h6 blog-entry-title"><a href="%s">', esc_url( get_permalink() ) ),
		'</a></h2>'
	); ?>

	<p class="font-size-sm mb-0">
		<?php the_content(); ?>
	</p>
</article>
