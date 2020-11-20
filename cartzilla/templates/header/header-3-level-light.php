<?php
/**
 * Template for displaying the "3 Level Light" header
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 */
?>
<header id="masthead" role="banner" class="site-header box-shadow-sm site-header-v3-light">
	<?php if ( apply_filters('cartzilla_enable_topbar' , true )): ?>
		<div class="<?php cartzilla_topbar_class( 'light' === cartzilla_topbar_skin() ? 'topbar-light bg-secondary' : 'topbar-dark bg-dark' ); ?>">
			<div class="<?php echo cartzilla_header_is_fw() ? 'container-fluid' : 'container' ; ?> justify-content-between">
				<?php topbar_handheld_dropdown(); ?>
				<div class="topbar-text text-nowrap d-none d-md-inline-block" data-cz-customizer="topbar_contacts">
					<?php echo wp_kses_post( apply_filters( 'cartzilla_enable_topbar_contact', get_theme_mod( 'topbar_contacts' ) ) ); ?>
				</div>
				<?php cartzilla_topbar_promo(); ?>
				<div class="ml-3 text-nowrap">
					<?php if ( apply_filters('cartzilla_enable_ordertracking' , true )): 
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
	<div class="bg-light <?php echo cartzilla_header_is_sticky() ? 'navbar-sticky' : ''; ?>">
		<div class="<?php cartzilla_navbar_class( 'navbar-light' ); ?>">
			<div class="<?php echo cartzilla_header_is_fw() ? 'container-fluid' : 'container'; ?>">
				<?php cartzilla_logo(); ?>
				<?php cartzilla_mobile_logo(); ?>
				<?php if ( cartzilla_navbar_is_search() ) : ?>
					<div class="input-group-overlay d-none d-lg-flex mx-4">
						<?php if ( cartzilla_is_woocommerce_activated() ) : ?>
							<?php the_widget( 'WC_Widget_Product_Search', 'title=' ); ?>
						<?php else : ?>
							<form role="search" method="get" class="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
								<input type="search" name="s" class="form-control appended-form-control" value="<?php echo get_search_query(); ?>" placeholder="<?php echo esc_html_x( 'Search site...', 'front-end', 'cartzilla' ); ?>">
								<div class="input-group-append-overlay">
									<span class="input-group-text"><i class="czi-search"></i></span>
								</div>
							</form>
						<?php endif; ?>
					</div>
				<?php endif; ?>
				<div class="navbar-toolbar d-flex align-items-center">
					<a href="#cz-handheld-sidebar" class="navbar-toggler" data-toggle="sidebar">
						<span class="navbar-toggler-icon"></span>
					</a>
					<a class="navbar-tool navbar-stuck-toggler" href="#">
						<span class="navbar-tool-tooltip"><?php echo esc_html_x( 'Expand menu', 'front-end', 'cartzilla' ); ?></span>
						<div class="navbar-tool-icon-box">
							<i class="navbar-tool-icon czi-menu"></i>
						</div>
					</a>

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
								<a class="navbar-tool-text ml-n1" href="<?php echo get_permalink( wc_get_page_id( 'myaccount' ) ); ?>">
									<small>
										<?php
										/* translators: a small text before "log in" link in Navbar */
										echo esc_html_x( 'Hello,', 'front-end', 'cartzilla' ); ?>
									</small>
									<?php
									$_cz_user = wp_get_current_user();
									echo esc_html( $_cz_user->display_name ); ?>
								</a>
								<?php cartzilla_wc_my_account_endpoint_dropdown(); ?>
							</div>
						<?php else: ?>
							<a class="navbar-tool ml-1 ml-lg-0 mr-n1 mr-lg-2" href="#cz-sign-in-modal" data-toggle="modal">
								<div class="navbar-tool-icon-box">
									<i class="navbar-tool-icon czi-user"></i>
								</div>
								<div class="navbar-tool-text ml-n2">
									<small>
										<?php
										/* translators: a small text before "log in" link in Navbar */
										echo esc_html_x( 'Hello, Sign in', 'front-end', 'cartzilla' ); ?>
									</small>
									<?php
									/* translators: heading for "log in" link in Navbar */
									echo esc_html_x( 'My Account', 'front-end', 'cartzilla' ); ?>
								</div>
							</a>
						<?php endif; ?>
					<?php endif; ?>
					<?php if ( cartzilla_navbar_is_cart() ) : ?>
						<div class="navbar-tool dropdown ml-3">
							<?php cartzilla_navbar_cart_toggle_v3(); ?>
							<?php cartzilla_navbar_cart(); ?>
						</div>
					<?php endif; ?>
					<?php if ( apply_filters( 'cartzilla_is_custom_header', false ) ) : 
						cartzilla_display_button_component(); 
					endif; ?>
				</div>
			</div>
		</div>
		<div class="<?php cartzilla_navbar_class( 'navbar-light mt-n2 pt-0 pb-2' . ( cartzilla_header_is_sticky() ? ' navbar-stuck-menu' : '' ) ); ?>">
			<div class="<?php echo cartzilla_header_is_fw() ? 'container-fluid' : 'container'; ?>">
				<div class="navbar-collapse d-none d-lg-block">
					<?php if ( cartzilla_departments_is_visible() ) : ?>
						<ul class="navbar-nav mega-nav pr-lg-2 mr-lg-2">
							<li class="nav-item dropdown">
								<a class="nav-link dropdown-toggle pl-0" href="#">
									<?php if ( has_nav_menu( 'departments' ) ) : ?>
										<i class="<?php echo esc_attr( apply_filters( 'cartzilla_department_menu_icon_class', 'czi-menu' ) ); ?> align-middle mt-n1 mr-2"></i>
									<?php else: ?>
										<i class="czi-view-grid mr-1"></i>
									<?php endif; ?>
									<span data-cz-customizer="departments_title"><?php cartzilla_departments_title(); ?></span>
								</a>
								<?php cartzilla_departments_menu(); ?>
							</li>
						</ul>
					<?php endif; ?>
					<?php cartzilla_primary_menu(); ?>
				</div>
			</div>
		</div>
	</div>
</header>
