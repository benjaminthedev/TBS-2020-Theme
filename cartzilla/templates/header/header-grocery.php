<?php
/**
 * Template for displaying the "Grocery header
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 */
?>
<header id="masthead" role="banner" class="bg-light box-shadow-sm fixed-top side-header-fixed-top <?php echo cartzilla_header_is_sticky() ? 'navbar-sticky' : ''; ?>">
	<div class="<?php cartzilla_navbar_class( 'navbar-light' ); ?>">
		<div class="container-fluid">
			<?php cartzilla_logo(); ?>
			<?php cartzilla_mobile_logo(); ?>
			<?php if ( cartzilla_navbar_is_search() ) : ?>
				<div class="input-group-overlay d-none d-lg-block mx-4">
					<?php if ( cartzilla_is_woocommerce_activated() ) : ?>
						<?php if( cartzilla_navbar_search_is_category_dropdown() ) { ?>
							<form class="input-group-overlay d-none d-lg-block" method="get" action="<?php echo esc_url( home_url( '/'  ) ); ?>" autocomplete="off">
							    <div class="input-group-prepend-overlay">
							    	<button type="submit" class="input-group-text"><i class="czi-search"></i></button>
							    </div>
							    <input class="form-control prepended-form-control appended-form-control" type="text" placeholder="<?php echo esc_html_x( 'Search for products', 'front-end', 'cartzilla' ); ?>" name="s" value="<?php echo esc_attr( get_search_query() ); ?>" />
							    <div class="input-group-append-overlay">
									<?php $selected_cat = isset( $_GET['product_cat'] ) ? $_GET['product_cat'] : "0";
									$navbar_search_dropdown_text = apply_filters( 'cartzilla_navbar_search_category_dropdown_default_text', esc_html__( 'All Categories', 'cartzilla' ) );
									wp_dropdown_categories( apply_filters( 'cartzilla_search_dropdown_categories_filter_args', array(
										'show_option_all' 	=> $navbar_search_dropdown_text,
										'taxonomy' 			=> 'product_cat',
										'hide_if_empty'		=> 1,
										'name'				=> 'product_cat',
										'selected'			=> $selected_cat,
										'value_field'		=> 'slug',
										'class'				=> 'custom-select'
									) ) );
									?>
							  	</div>
							  	<input type="hidden" id="search-param" name="post_type" value="product" />
							  </form>
						<?php } else {
							the_widget( 'WC_Widget_Product_Search', 'title=' );
						} ?>
					<?php else : ?>
						<form class="input-group-overlay d-none d-lg-block" method="get" action="<?php echo esc_url( home_url( '/'  ) ); ?>" autocomplete="off">
						    <div class="input-group-prepend-overlay">
						    	<button type="submit" class="input-group-text"><i class="czi-search"></i></button>
						    </div>
						    <input class="form-control prepended-form-control appended-form-control" type="text" placeholder="<?php echo esc_html_x( 'Search post', 'front-end', 'cartzilla' ); ?>" name="s" value="<?php echo esc_attr( get_search_query() ); ?>" />
						    <div class="input-group-append-overlay">
								<?php $selected_cat = isset( $_GET['category'] ) ? $_GET['category'] : "0";
								$navbar_search_dropdown_text = apply_filters( 'cartzilla_navbar_search_category_dropdown_default_text', esc_html__( 'All Categories', 'cartzilla' ) );
								wp_dropdown_categories( apply_filters( 'cartzilla_search_dropdown_categories_filter_args', array(
									'show_option_all' 	=> $navbar_search_dropdown_text,
									'taxonomy' 			=> 'category',
									'hide_if_empty'		=> 1,
									'name'				=> 'category',
									'selected'			=> $selected_cat,
									'value_field'		=> 'slug',
									'class'				=> 'custom-select'
								) ) );
								?>
						  	</div>
						  	<input type="hidden" id="search-param" name="post_type" value="product" />
						  </form>
					<?php endif; ?>
				</div>
			<?php endif; ?>
			<div class="navbar-toolbar d-flex flex-shrink-0 align-items-center ml-xl-2">
				<a class="navbar-toggler" href="#sideNav" data-toggle="sidebar">
					<span class="navbar-toggler-icon"></span>
				</a>

				<?php if ( cartzilla_navbar_is_search() ) : ?>
					<a class="navbar-tool d-flex d-lg-none" href="#searchBox" data-toggle="collapse" role="button" aria-expanded="false" aria-controls="searchBox">
						<span class="navbar-tool-tooltip">
							<?php echo esc_html_x( 'Search', 'front-end', 'cartzilla' ); ?>
						</span>
						<div class="navbar-tool-icon-box"><i class="navbar-tool-icon czi-search"></i></div>
					</a>
				<?php endif; ?>

	          	<?php if ( apply_filters( 'cartzilla_enable_wishlist', true ) && function_exists( 'YITH_WCWL' ) ) : ?>
					<a href="<?php echo esc_url( get_permalink( get_option( 'yith_wcwl_wishlist_page_id' ) ) ); ?>" class="navbar-tool d-none d-lg-flex">
						<?php if ( apply_filters( 'cartzilla_show_wishlist_count', true ) ) : ?>
							<span class="navbar-tool-label  yith_wcwl_count">
								<?php echo yith_wcwl_count_products(); ?>
							</span>
						<?php endif; ?>
						<span class="navbar-tool-tooltip"><?php echo esc_html__( 'Wishlist', 'cartzilla' ); ?></span>
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

	<?php if ( cartzilla_navbar_is_search() ) : ?>
		<div class="collapse" id="searchBox">
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

 <!-- Sidebar menu-->
<aside class="cz-sidebar cz-sidebar-fixed" id="sideNav" style="padding-top: 5rem;">
     <button class="close" type="button" data-dismiss="sidebar" aria-label="<?php echo esc_attr_x( 'Close', 'front-end', 'cartzilla' ); ?>">
      	<span class="d-inline-block font-size-xs font-weight-normal align-middle"><?php echo esc_html_x( 'Close sidebar', 'front-end', 'cartzilla' ); ?></span>
      	<span class="d-inline-block align-middle ml-2" aria-hidden="true">&times;</span>
     </button>

   
    <div class="cz-sidebar-inner">
  		<?php $is_primary_menu         = has_nav_menu( 'primary' );
          	  $is_departments_menu     = has_nav_menu( 'departments' );

  		if ( $is_primary_menu && ( $is_departments_menu && apply_filters('cartzilla_grocery_department_menu' , true ) ) ) : ?>
            <ul class="nav nav-tabs nav-justified mt-2 mt-lg-4 mb-0" role="tablist">
            	<li class="nav-item">
                    <a href="#cz-sidebar-departments-tab" class="nav-link font-weight-medium active" data-toggle="tab" role="tab">
                        <?php cartzilla_departments_title(); ?>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#cz-sidebar-menu-tab" class="nav-link font-weight-medium" data-toggle="tab" role="tab">
                        <?php echo esc_html_x( 'Menu', 'front-end', 'cartzilla' ); ?>
                    </a>
                </li>
                
            </ul>

            <div class="cz-sidebar-body pt-3 pb-0" data-simplebar>
	            <div class="tab-content">
	            	<?php if (apply_filters('cartzilla_grocery_department_menu' , true ) ): ?>
	            	<div class="sidebar-nav tab-pane fade show active" id="cz-sidebar-departments-tab" role="tabpanel">
	                    <nav class="cz-handheld-menu">
	                        <?php cartzilla_handheld_departments_menu(); ?>
	                    </nav>
	                </div>
	            <?php endif; ?>
	                <div class="sidebar-nav tab-pane fade" id="cz-sidebar-menu-tab" role="tabpanel">
	                    <nav class="cz-handheld-menu">
	                        <?php cartzilla_offcanvas_primary_menu(); ?>
	                    </nav>
	                </div>
	                
	            </div>
	        </div>

        <?php elseif ( $is_primary_menu ) : ?>
        	<div class="cz-sidebar-body pt-3 pb-0" data-simplebar>
        		<div class="sidebar-nav">
		            <nav class="cz-handheld-menu">
		                <?php cartzilla_offcanvas_primary_menu(); ?>
		            </nav>
		        </div>
	        </div>
	        
        <?php elseif ( $is_departments_menu && apply_filters('cartzilla_grocery_department_menu' , true ) ) : ?>
        	<div class="cz-sidebar-body pt-3 pb-0" data-simplebar>
        		<div class="sidebar-nav">
		            <nav class="cz-handheld-menu">
		                <?php cartzilla_handheld_departments_menu(); ?>
		            </nav>
		        </div>
	        </div>
        <?php endif; ?>

        <div class="px-grid-gutter pt-5 pb-4 mb-2">
          	<?php if ( apply_filters( 'cartzilla_enable_site_info_support' , true ) ) :
          		cartzilla_site_info_support(); 
          	endif;

          	if ( apply_filters( 'cartzilla_enable_site_info_contact' , true ) ) :
          		cartzilla_site_info_contact();  
          	endif;

          	if ( apply_filters( 'cartzilla_enable_header_social_menu' , true ) ) :
          		cartzilla_header_social_menu();
          	endif; ?>

        </div>
    </div>
</aside>