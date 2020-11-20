<?php
/**
 * Template for displaying the "Button Header" header.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 */

$button_url = get_theme_mod( 'button_url', '#' );
$button_text = get_theme_mod( 'button_text', 'Buy Now' );
$button_icon = get_theme_mod( 'button_icon', 'czi-cart' );

?>
<header id="masthead" role="banner" class="site-header site-header-helpcenter bg-light box-shadow-sm <?php echo cartzilla_header_is_sticky() ? 'navbar-sticky' : ''; ?>">
	<div class="<?php cartzilla_navbar_class( 'navbar-light' ); ?>">
		<div class="<?php echo cartzilla_header_is_fw() ? 'container-fluid' : 'container'; ?>">
			<?php cartzilla_logo(); ?>
			<?php cartzilla_mobile_logo(); ?>
			<div class="navbar-toolbar d-flex align-items-center order-lg-3">
				<a href="#cz-handheld-sidebar" class="navbar-toggler" data-toggle="sidebar">
					<span class="navbar-toggler-icon"></span>
				</a>

				<a class="btn btn-primary btn-shadow" href="<?php echo esc_url( $button_url ); ?>" target="_blank" rel="noopener">
					<?php if ( 'yes' === get_theme_mod( 'enable_button_icon', 'yes' ) ) : ?>
						<i class="<?php echo esc_attr( $button_icon ); ?> mr-1 d-none d-sm-inline-block"></i>
					<?php endif; ?>
					<?php echo esc_html($button_text);?>
				</a>
				
			</div>
			<div class="d-none d-lg-block mr-auto order-lg-2">
				<?php cartzilla_primary_menu(); ?>
			</div>
		</div>
	</div>
</header>


