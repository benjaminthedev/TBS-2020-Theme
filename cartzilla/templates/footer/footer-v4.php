<?php
/**
 * Template for displaying the "v4" footer.
 * 
 * @link https://codex.wordpress.org/Template_Hierarchy
 */
?>
<footer class="footer-v4">
	<div class="container text-center">          
		<?php if ( cartzilla_is_copyright() ) : ?>
			<div class="font-size-ms text-muted py-5 text-center border-top">
				<?php cartzilla_copyright(); ?>
					
			</div>
		<?php endif; ?>
	</div>
</footer>