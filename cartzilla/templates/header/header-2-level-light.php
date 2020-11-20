<?php
/**
 * Template for displaying the "2 Level Light" header.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 */
?>
<header id="masthead" role="banner" class="site-header bg-light box-shadow-sm site-header-v2-light">
	<?php if ( apply_filters('cartzilla_enable_topbar' , true ) ) : ?>
		<div class="<?php cartzilla_topbar_class( 'light' === cartzilla_topbar_skin() ? 'topbar-light bg-secondary' : 'topbar-dark bg-dark' ); ?>">
			<div class="<?php echo cartzilla_header_is_fw() ? 'container-fluid' : 'container' ; ?> justify-content-between">
				<div class="topbar-text text-nowrap d-none d-md-inline-block" data-cz-customizer="topbar_contacts">
					<?php echo wp_kses_post( apply_filters( 'cartzilla_enable_topbar_contact', get_theme_mod( 'topbar_contacts' ) ) ); ?>
				</div>
				<?php cartzilla_topbar_promo(); ?>
				<div class="ml-3 text-nowrap">
					<?php if ( apply_filters('cartzilla_enable_ordertracking', true )): 
						cartzilla_order_tracking(); 
					endif; ?>
					<?php if ( apply_filters( 'cartzilla_enable_topbar_language_currency_dropdown',  get_theme_mod( 'enable_topbar_language_currency', 'no' ) ) === 'yes' && has_filter( 'cartzilla_dropdown_tools_toggle' ) ) : ?>
						<div class="topbar-text dropdown disable-autohide ml-4">
							<a href="#" class="topbar-link dropdown-toggle" data-toggle="dropdown">
								<?php cartzilla_dropdown_tools_toggle(); ?>
							</a>
							<?php if( has_action( 'cartzilla_dropdown_tools' ) ) : ?>
								<ul class="dropdown-menu dropdown-menu-right">
									<?php cartzilla_dropdown_tools(); ?>
								</ul>
							<?php endif; ?>
						</div>
					<?php endif; ?>
				</div>
			</div>
		</div>
	<?php endif;?>
	<div class="<?php echo cartzilla_header_is_sticky() ? 'navbar-sticky' : ''; ?>">
		<div class="<?php cartzilla_navbar_class( 'navbar-light bg-light' ); ?>">
			<div class="<?php echo cartzilla_header_is_fw() ? 'container-fluid' : 'container'; ?>">
				<?php cartzilla_logo(); ?>
				<?php cartzilla_mobile_logo(); ?>
				<div class="navbar-toolbar d-flex align-items-center order-lg-3">
					<a href="#cz-handheld-sidebar" class="navbar-toggler" data-toggle="sidebar">
						<span class="navbar-toggler-icon"></span>
					</a>
					<?php if ( cartzilla_navbar_is_search() ) : ?>
						<a class="navbar-tool d-none d-lg-flex" href="#searchBox" data-toggle="collapse" role="button" aria-expanded="false" aria-controls="searchBox">
							<span class="navbar-tool-tooltip"><?php echo esc_html_x( 'Search', 'front-end', 'cartzilla' ); ?></span>
							<div class="navbar-tool-icon-box"><i class="navbar-tool-icon czi-search"></i></div>
						</a>
					<?php endif; ?>

					<?php if ( apply_filters( 'cartzilla_enable_wishlist', true ) && function_exists( 'YITH_WCWL' ) ) : ?>
						<a href="<?php echo esc_url( get_permalink( get_option( 'yith_wcwl_wishlist_page_id' ) ) ); ?>" class="navbar-tool d-none d-lg-flex">
							<?php if ( apply_filters( 'cartzilla_show_wishlist_count', true ) ) : ?>
								<span class="navbar-tool-label yith_wcwl_count">
									<?php echo yith_wcwl_count_products(); ?>
								</span>
							<?php endif; ?>
							<span class="navbar-tool-tooltip"><?php echo esc_html_x( 'Wishlist', 'front-end', 'cartzilla' ); ?></span>
							<div class="navbar-tool-icon-box"><i class="navbar-tool-icon czi-heart"></i></div>
						</a>
					<?php endif; ?>

					<?php if ( cartzilla_navbar_is_account() ) : ?>
						<?php if ( is_user_logged_in() ) : ?>
							<div class="navbar-tool dropdown ml-2">
								<a class="navbar-tool-icon-box border dropdown-toggle" href="<?php echo get_permalink( wc_get_page_id( 'myaccount' ) ); ?>">
									<?php echo get_avatar( wp_get_current_user(), 36, '', '', [ 'class' => 'rounded-circle' ] ); ?>
								</a>
								<?php cartzilla_wc_my_account_endpoint_dropdown(); ?>
							</div>
						<?php else: ?>
							<a class="navbar-tool ml-1 mr-n1" href="#cz-sign-in-modal" data-toggle="modal">
								<span class="navbar-tool-tooltip"><?php echo esc_html_x( 'Account', 'front-end', 'cartzilla' ); ?></span>
								<div class="navbar-tool-icon-box"><i class="navbar-tool-icon czi-user"></i></div>
							</a>
						<?php endif; ?>
					<?php endif; ?>
					<?php if ( cartzilla_navbar_is_cart() ) : ?>
						<div class="navbar-tool dropdown ml-3">
							<?php cartzilla_navbar_cart_toggle(); ?>
							<?php cartzilla_navbar_cart(); ?>
						</div>
					<?php endif; ?>
					<?php if ( apply_filters( 'cartzilla_is_custom_header', false ) ) : 
						cartzilla_display_button_component(); 
					endif; ?>
				</div>
				<div class="d-none d-lg-block mr-auto order-lg-2">
					<?php cartzilla_primary_menu(); ?>
				</div>
			</div>
		</div>
		<?php if ( cartzilla_navbar_is_search() ) : ?>
			<div class="search-box collapse" id="searchBox">
				<div class="card pt-2 pb-4 border-0 rounded-0">
					<div class="container">
						<?php if ( cartzilla_is_woocommerce_activated() ) : ?>
							<?php the_widget( 'WC_Widget_Product_Search', 'title=' ); ?>
						<?php else : ?>
							<form role="search" method="get" class="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
								<div class="input-group-overlay">
									<div class="input-group-prepend-overlay">
										<span class="input-group-text"><i class="czi-search"></i></span>
									</div>
									<input type="search" name="s" class="form-control prepended-form-control" value="<?php echo get_search_query(); ?>" placeholder="<?php echo esc_html_x( 'Search site...', 'front-end', 'cartzilla' ); ?>">
								</div>
							</form>
						<?php endif; ?>
					</div>
				</div>
			</div>
		<?php endif; ?>
	</div>
</header>
