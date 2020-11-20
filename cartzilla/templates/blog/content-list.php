<?php
/**
 * Template part for displaying a post tile in list layout
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Cartzilla
 */

$_czi_categories = cartzilla_post_get_categories();

?>
<article <?php post_class( 'blog-list border-bottom pb-4 mb-5' ); ?>>
	<div class="left-column">
		<div class="d-flex align-items-center font-size-sm pb-2 mb-1">
			<?php cartzilla_posted_by(); ?>
			<span class="blog-entry-meta-divider"></span>
			<a class="blog-entry-meta-link" href="<?php the_permalink(); ?>"><?php cartzilla_posted_on(); ?></a>
		</div>
		<?php
		the_title(
			sprintf( '<h2 class="h5 blog-entry-title"><a href="%s">', esc_url( get_permalink() ) ),
			is_sticky() ? '<span class="sticky-badge badge badge-dark font-size-xs align-middle ml-1">Featured</span></a></h2>' : '</a></h2>'
		); ?>
	</div>
	<div class="right-column">
		<?php if ( has_post_thumbnail() && ! post_password_required() && ! is_attachment() ) : ?>
			<a class="blog-entry-thumb mb-3" href="<?php the_permalink(); ?>">
				<?php the_post_thumbnail( 'large', [ 'alt' => the_title_attribute( [ 'echo' => false ] ) ] ); ?>
			</a>
		<?php endif; ?>
		<div class="d-flex justify-content-between mb-1">
			<?php if ( ! empty( $_czi_categories ) ) : ?>
				<div class="font-size-sm text-muted pr-2 mb-2">
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
			<?php endif; unset( $_czi_categories ); ?>
			<?php if ( ! post_password_required() && ( comments_open() || get_comments_number() ) ) : ?>
				<div class="font-size-sm mb-2">
					<a class="blog-entry-meta-link text-nowrap" href="<?php echo esc_url( get_comments_link() ); ?>">
						<i class="czi-message"></i>
						<span><?php echo esc_html( get_comments_number() ); ?></span>
					</a>
				</div>
			<?php endif; ?>
		</div>
		<p class="font-size-sm">
			<?php the_excerpt(); ?>
			<a href="<?php the_permalink(); ?>" class="read-more-text blog-entry-meta-link font-weight-medium">
				<?php
				/* translators: continue reading post link text */
				echo esc_html_x( '[Read more]', 'front-end', 'cartzilla' ); ?>
			</a>
		</p>
	</div>
</article>
