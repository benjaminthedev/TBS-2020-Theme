<?php
/**
 * Template part for displaying a featured post tile in a special section Featured Posts of blog
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Cartzilla
 */

$_czi_categories = cartzilla_post_get_categories();

?>
<article <?php post_class(); ?>>
	<a class="blog-entry-thumb mb-3" href="<?php the_permalink(); ?>">
		<span class="blog-entry-meta-label font-size-sm">
			<i class="czi-time"></i>
			<?php cartzilla_posted_on(); ?>
		</span>
		<?php the_post_thumbnail( 'large', [ 'alt' => the_title_attribute( [ 'echo' => false ] ) ] ); ?>
	</a>
	<div class="d-flex justify-content-between mb-2 pt-1">
		<?php
		the_title(
			sprintf( '<h2 class="h5 blog-entry-title mb-0"><a href="%s">', esc_url( get_permalink() ) ),
			'</a></h2>'
		); ?>
		<?php if ( ! post_password_required() && ( comments_open() || get_comments_number() ) ) : ?>
			<a class="blog-entry-meta-link font-size-sm text-nowrap ml-3 pt-1" href="<?php echo esc_url( get_comments_link() ); ?>">
				<i class="czi-message"></i>
				<span><?php echo esc_html( get_comments_number() ); ?></span>
			</a>
		<?php endif; ?>
	</div>
	<div class="d-flex align-items-center font-size-sm">
		<?php cartzilla_posted_by(); ?>
		<span class="blog-entry-meta-divider"></span>
		<div class="font-size-sm text-muted">
			<?php
			/* translators: in categories; before post categories list */
			echo esc_html_x( 'in', 'front-end', 'cartzilla' );
			echo ' '; // note the whitespace
			echo implode( ', ', array_map( function ( $category ) {
				return sprintf( '<a href="%s" class="blog-entry-meta-link">%s</a>',
					esc_url( get_category_link( $category ) ),
					esc_html( $category->name )
				);
			}, $_czi_categories ) ); ?>
		</div>
	</div>
</article>
