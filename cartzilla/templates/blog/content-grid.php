<?php
/**
 * Template part for displaying a post tile in grid layout
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Cartzilla
 */
?>
<article <?php post_class( 'grid-item' ); ?>>
	<div class="card">
		<?php if ( has_post_thumbnail() && ! post_password_required() && ! is_attachment() ) : ?>
			<a class="blog-entry-thumb" href="<?php the_permalink(); ?>">
				<?php the_post_thumbnail( 'large', [
					'class' => 'card-img-top',
					'alt'   => the_title_attribute( [ 'echo' => false ] ),
				] ); ?>
			</a>
		<?php endif; ?>
		<div class="card-body">
			<?php
			the_title(
				sprintf( '<h2 class="h6 blog-entry-title"><a href="%s">', esc_url( get_permalink() ) ),
				is_sticky() ? '<span class="sticky-badge badge badge-dark font-size-xs align-middle ml-1">Featured</span></a></h2>' : '</a></h2>'
			); ?>
			<p class="font-size-sm"><?php the_excerpt(); ?></p>
			<div class="tagcloud">
				<?php foreach ( cartzilla_post_get_categories() as $_czi_category ) : ?>
					<a class="tag-cloud-link" href="<?php echo esc_url( get_category_link( $_czi_category ) ); ?>">
						<?php echo esc_html( $_czi_category->name ); ?>
					</a>
				<?php endforeach;
				unset( $_czi_category ); ?>
			</div>
		</div>
		<div class="card-footer d-flex align-items-center font-size-xs">
			<?php cartzilla_posted_by(); ?>
			<div class="ml-auto text-nowrap">
				<a class="blog-entry-meta-link text-nowrap" href="<?php the_permalink(); ?>">
					<?php cartzilla_posted_on(); ?>
				</a>
				<?php if ( ! post_password_required() && ( comments_open() || get_comments_number() ) ) : ?>
					<span class="blog-entry-meta-divider mx-2"></span>
					<a class="blog-entry-meta-link text-nowrap" href="<?php echo esc_url( get_comments_link() ); ?>">
						<i class="czi-message"></i>
						<span><?php echo esc_html( get_comments_number() ); ?></span>
					</a>
				<?php endif; ?>
			</div>
		</div>
	</div>
</article>
