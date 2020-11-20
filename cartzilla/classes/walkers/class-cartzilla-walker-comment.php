<?php

/**
 * Customizing the comment HTML
 *
 * @package Cartzilla
 */
class Cartzilla_Comment_Walker extends Walker_Comment {
	/**
	 * Outputs a comment in the HTML5 format.
	 *
	 * @since 3.6.0
	 *
	 * @see wp_list_comments()
	 *
	 * @param WP_Comment $comment Comment to display.
	 * @param int        $depth   Depth of the current comment.
	 * @param array      $args    An array of arguments.
	 */
	protected function html5_comment( $comment, $depth, $args ) {
		?>
		<div id="comment-<?php comment_ID(); ?>" <?php comment_class( 'media border-top pt-4 mt-4', $comment ); ?>>
			<?php
			if ( 0 != $args['avatar_size'] ) :
				echo get_avatar( $comment, $args['avatar_size'], '', get_comment_author( $comment ), [
					'class' => 'rounded-circle',
				] );
			endif; ?>
			<div class="media-body<?php echo esc_attr( ! empty( get_avatar( $comment ) ) ? ' pl-3' : '' ); ?>">
				<div class="d-flex justify-content-between align-items-center mb-2">
					<h6 class="font-size-md mb-0"><?php echo esc_html( get_comment_author( $comment ) ); ?></h6>
					<?php comment_reply_link( array_merge( $args, [
						'add_below' => 'comment-reply-target',
						'depth'     => $depth,
						'max_depth' => $args['max_depth'],
					] ), $comment ); ?>
				</div>
				<div class="comment-text font-size-md mb-1">
					<?php
					if ( '0' == $comment->comment_approved ) :
						$commenter = wp_get_current_commenter();
						if ( $commenter['comment_author_email'] ) {
							echo esc_html_x( 'Your comment is awaiting moderation.', 'front-end', 'cartzilla' );
						} else {
							echo esc_html_x(
								'Your comment is awaiting moderation. This is a preview, your comment will be visible after it has been approved.',
								'front-end',
								'cartzilla'
							);
						}
					else:
						comment_text();
					endif; ?>
				</div>
				<a href="<?php echo esc_url( get_comment_link( $comment, $args ) ); ?>" class="font-size-ms text-muted">
					<i class="czi-time align-middle mr-1 mt-n1"></i>
					<?php echo esc_html( get_comment_date( '', $comment ) ); ?>
				</a>
				<?php if ( current_user_can( 'edit_comment', $comment->comment_ID ) ) : ?>
					<a class="comment-edit-link font-size-ms ml-2" href="<?php echo esc_url( get_edit_comment_link( $comment ) ); ?>">
						<?php esc_html_e( 'Edit', 'cartzilla' ); ?>
					</a>
				<?php endif; ?>
				<div id="comment-reply-target-<?php comment_ID(); ?>"></div>
		<?php
	}

	/**
	 * Ends the element output, if needed.
	 *
	 * @since 2.7.0
	 *
	 * @see Walker::end_el()
	 * @see wp_list_comments()
	 *
	 * @param string     $output  Used to append additional content. Passed by reference.
	 * @param WP_Comment $comment The current comment object. Default current comment.
	 * @param int        $depth   Optional. Depth of the current comment. Default 0.
	 * @param array      $args    Optional. An array of arguments. Default empty array.
	 */
	public function end_el( &$output, $comment, $depth = 0, $args = array() ) {
		if ( ! empty( $args['end-callback'] ) ) {
			ob_start();
			call_user_func( $args['end-callback'], $comment, $args, $depth );
			$output .= ob_get_clean();
			return;
		}

		$output .= '</div></div>'; // close  div.media > div.media-body
	}
}
