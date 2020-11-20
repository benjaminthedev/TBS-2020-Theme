<?php
/**
 * Template for displaying the "Marketplace" header.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 */
?>
<header id="masthead" role="banner" class="site-header site-header-marketplace bg-light box-shadow-sm <?php echo cartzilla_header_is_sticky() ? 'navbar-sticky' : ''; ?>">
	<div class="<?php cartzilla_navbar_class( 'navbar-light' ); ?>">
		<div class="<?php echo cartzilla_header_is_fw() ? 'container-fluid' : 'container'; ?>">
			<?php cartzilla_logo(); ?>
			<?php cartzilla_mobile_logo(); ?>
			<div class="navbar-toolbar d-flex align-items-center order-lg-3">
				<a href="#cz-handheld-sidebar" class="navbar-toggler" data-toggle="sidebar">
					<span class="navbar-toggler-icon"></span>
				</a>
				<?php if ( cartzilla_navbar_is_search() ) : ?>
					<a class="navbar-tool d-none d-lg-flex" href="#searchBox" data-toggle="collapse" role="button" aria-expanded="false" aria-controls="searchBox">
						<span class="navbar-tool-tooltip">
							<?php echo esc_html_x( 'Search', 'front-end', 'cartzilla' ); ?>
						</span>
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
					<?php if ( is_user_logged_in() ) : $_cz_user = wp_get_current_user(); $_cz_user_id = $_cz_user->ID; ?>
						<div class="navbar-tool dropdown ml-2">
							<a class="navbar-tool-icon-box border dropdown-toggle" href="<?php echo get_permalink( wc_get_page_id( 'myaccount' ) ); ?>">
								<?php $gravatar_url = get_avatar_url( $_cz_user_id ); ?>
								<img class="rounded-circle w-100" src="<?php echo esc_url( $gravatar_url ); ?>" alt="<?php echo esc_attr( $_cz_user->display_name ); ?>">
							</a>
							<a class="navbar-tool-text ml-n1" href="<?php echo get_permalink( wc_get_page_id( 'myaccount' ) ); ?>">
								<?php
								if( cartzilla_is_dokan_activated() && dokan_is_seller_enabled( $_cz_user_id ) ) :
									$store_info = dokan_get_store_info( $_cz_user_id );
									?><small>
										<?php echo ! empty( $store_info['store_name'] ) ? esc_html( $store_info['store_name'] ) : esc_html( $_cz_user->display_name ) ?>
									</small>
									<?php echo dokan_get_seller_balance( $_cz_user_id ); ?>
								<?php else : ?>
									<small>
										<?php
										/* translators: a small text before "log in" link in Navbar */
										echo esc_html_x( 'Hello,', 'front-end', 'cartzilla' ); ?>
									</small>
									<?php echo esc_html( $_cz_user->display_name ); ?>
								<?php endif; ?>
							</a>
							
							<?php if( cartzilla_is_dokan_activated() && dokan_is_seller_enabled( $_cz_user_id ) && apply_filters( 'cartzilla_enable_my_account_dokan_dropdown_menu_items', true ) ) : ?>
								<ul class="dropdown-menu dropdown-menu-right" style="min-width: 14rem;"><?php
								$nav_menu = apply_filters( 'cartzilla_my_account_dokan_dropdown_menu_items', dokan_get_dashboard_nav() );
									foreach ( $nav_menu as $key => $item ) {
										if( isset( $item['url'], $item['icon'], $item['title'] ) ) {
											?>
											<li><a class="dropdown-item d-flex align-items-center" href="<?php echo esc_url( $item['url'] ); ?>">
												<?php echo wp_kses_post( $item['icon'] ); ?>
												<?php echo wp_kses_post( $item['title'] ); ?>
											</a></li>
											<?php
										} elseif( isset( $item['title'], $item['divider'] ) ) {
											if( $key === 'seller-dashboard' ) {
												?><li class="dropdown-divider"></li><?php
											}
											?><li class="dropdown-header"><?php echo wp_kses_post( $item['title'] ); ?></li><?php
										}
									}
									?>

									<li class="dropdown-divider"></li>
								    <li><a class="dropdown-item d-flex align-items-center" href="<?php echo esc_url( wp_logout_url( home_url() ) ); ?>">
								        <i class="czi-sign-out opacity-60 mr-2"></i>
								        <?php esc_html_e( 'Sign out', 'cartzilla'); ?>
								    </a><li>
						    	</ul>
							<?php else : ?>
								<?php cartzilla_wc_my_account_endpoint_dropdown(); ?>
							<?php endif; ?>
							
						</div>
					<?php else: ?>
						<a class="navbar-tool ml-1 mr-n1" href="#cz-sign-in-modal" data-toggle="modal">
							<span class="navbar-tool-tooltip"><?php echo esc_html_x( 'Account', 'front-end', 'cartzilla' ); ?></span>
							<div class="navbar-tool-icon-box">
								<i class="navbar-tool-icon czi-user"></i>
							</div>
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
			<div class="navbar-collapse mr-auto order-lg-2 collapse" id="navbarCollapse">
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
</header>
