<?php
/**
 * Template part for displaying a related post tile in a special section Related Posts of single post page
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Cartzilla
 */

?>
<article <?php post_class(); ?>>
	<?php if ( has_post_thumbnail() && ! post_password_required() ) : ?>
		<a class="blog-entry-thumb mb-3" href="<?php the_permalink(); ?>">
			<?php the_post_thumbnail( 'large', [
				'class' => 'rounded',
				'alt'   => the_title_attribute( [ 'echo' => false ] ),
			] ); ?>
		</a>
	<?php endif; ?>
	<div class="d-flex align-items-center font-size-sm mb-2">
		<a class="blog-entry-meta-link"
		   href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>"
		><?php
			/* translators: posted by */
			echo esc_html_x( 'by', 'front-end', 'cartzilla' ), ' ', esc_html( get_the_author() ); ?></a>
		<span class="blog-entry-meta-divider"></span>
		<a class="blog-entry-meta-link" href="<?php the_permalink(); ?>"><?php cartzilla_posted_on(); ?></a>
	</div>
	<?php
	the_title(
		sprintf( '<h3 class="h6 blog-entry-title"><a href="%s">', esc_url( get_permalink() ) ),
		'</a></h3>'
	); ?>
</article>
