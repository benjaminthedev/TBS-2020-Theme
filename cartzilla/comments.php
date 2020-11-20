<?php
/**
 * The template for displaying comments
 *
 * This is the template that displays the area of the page that contains both the current comments
 * and the comment form.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Cartzilla
 */

/*
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
 */
if ( post_password_required() ) {
	return;
}

?>
<div class="pt-2 mt-5" id="comments">
	<h2 class="h4">
		<?php
		/* translators: comments title */
		echo esc_html_x( 'Comments', 'front-end', 'cartzilla' ); ?>
		<span class="badge badge-secondary font-size-sm text-body align-middle ml-2">
			<?php echo number_format_i18n( get_comments_number() ); ?>
		</span>
	</h2>

	<?php
	if ( have_comments() ) :

		wp_list_comments( [
			/* translators: comment reply text */
			'reply_text'  => esc_html_x( 'Reply', 'front-end', 'cartzilla' ),
			'style'       => 'div',
			'format'      => 'html5',
			'avatar_size' => 50,
			'walker'      => new Cartzilla_Comment_Walker(),
		] );

		cartzilla_comments_navigation();

		if ( ! comments_open() ) : ?>
			<div class="alert alert-danger alert-with-icon mt-4" role="alert">
				<div class="alert-icon-box">
					<i class="alert-icon czi-close-circle"></i>
				</div>
				<span class="no-comments"><?php echo esc_html_x( 'Comments are closed.', 'front-end', 'cartzilla' ); ?></span>
			</div>
		<?php endif;

	endif;

	comment_form( apply_filters( 'cartzilla_comment_form_args', [
		'logged_in_as'         => '',
		'title_reply_before'   => '<h3 id="reply-title" class="comment-reply-title h5">',
		'submit_field'         => '<div class="form-group form-submit">%1$s%2$s</div>',
		'submit_button'        => '<button type="submit" name="%1$s" id="%2$s" class="%3$s">%4$s</button>',
		'class_submit'         => 'btn btn-primary',
		'comment_notes_after'  => '',
		'comment_notes_before' => sprintf( '<p class="font-size-sm text-muted">%s %s <span class="text-danger">*</span></p>',
			esc_html_x( 'Your email address will not be published.', 'front-end', 'cartzilla' ),
			/* translators: related to comment form; phrase follows by red mark*/
			esc_html_x( 'Required fields are marked', 'front-end', 'cartzilla' )
		),
		'comment_field'        => sprintf(
			'<div class="form-group comment-form-comment">
				<label for="comment">%s</label>
				<textarea id="comment" name="comment" class="form-control" rows="8" maxlength="65525" required></textarea>
			</div>',
			/* translators: label for textarea in comment form */
			esc_html_x( 'Comment', 'front-end', 'cartzilla' )
		),
	] ) );
	?>
</div>
<?php
