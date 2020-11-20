<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package Cartzilla
 */
get_header();
$style_404 = apply_filters( 'cartzilla_404_style', get_theme_mod( '404_style', 'style-v1' ) );

if ( (int) get_theme_mod( '404_image') > 0 ) : ?>
	<div class="container pb-5 mb-md-4 text-center">
		<?php echo wp_get_attachment_image( get_theme_mod( '404_image' ), 'large', false, [
			'class' => 'error-image d-block mx-auto mb-4',
			'alt'   => esc_html_x( 'Error 404', 'front-end', 'cartzilla' ),
		] ); ?>
		<a class="btn btn-<?php echo esc_attr( get_theme_mod( '404_button_color', 'primary' ) ); ?>" href="<?php echo esc_url( home_url( '/' ) ); ?>">
			<i class="czi-home mr-1"></i>
			<?php echo esc_html_x( 'Back to Home', 'front-end', 'cartzilla' ); ?>
		</a>
	</div>
<?php else : ?>
	<div class="container py-5 mb-3 text-center">
		<div class="row justify-content-center py-lg-5">
			<div class="col-lg-5">
				<?php 
				if ( $style_404 == 'style-v2' ) {
					echo wp_get_attachment_image( get_theme_mod( '404_image_option' ), '340px', false, [
						'class' => 'd-block mx-auto mb-5 error-image',
						'alt'   => esc_html_x( 'Error 404', 'front-end', 'cartzilla' ),
					] );
				}
				?>
				<h1 class="<?php echo esc_attr( $style_404 == 'style-v1' ? 'display-404' : 'h3' ); ?>"><?php echo esc_html( get_theme_mod( '404_title', _x( '404', 'front-end', 'cartzilla' ) ) ); ?></h1>
				<?php if ( get_theme_mod( '404_subtitle' ) ) : ?>
					<h2 class="<?php echo esc_attr( $style_404 == 'style-v1' ? 'h3 mb-4' : 'h5 font-weight-normal mb-4' ); ?>" data-cz-customizer="404_subtitle"><?php echo esc_html( get_theme_mod( '404_subtitle', _x( 'We can\'t seem to find the page you are looking for.', 'front-end', 'cartzilla' ) ) ); ?></h2>
					<p class="font-size-md mb-4" data-cz-customizer="404_link_title">
						<u><?php echo esc_html( get_theme_mod( '404_link_title', _x( 'Here are some helpful links instead:', 'front-end', 'cartzilla' ) ) ); ?></u>
					</p>
				<?php endif; ?>
				<a class="btn btn-<?php echo esc_attr( get_theme_mod( '404_button_color', 'primary' ) ); ?> mb-3" href="<?php echo esc_url( home_url( '/' ) ); ?>">
					<i class="czi-home mr-1"></i>
					<?php echo esc_html_x( 'Back to Home', 'front-end', 'cartzilla' ); ?>
				</a>
			</div>
		</div>
		<?php if ( get_theme_mod( '404_enable_feature_lists', 'no' ) === 'yes' ) : ?>
			<div class="row justify-content-center">
				<div class="col-xl-8 col-lg-10">
					<div class="row">
						<div class="col-sm-4 mb-3">
							<a class="card h-100 border-0 box-shadow-sm" data-cz-customizer="homepage_btn" href="<?php echo esc_url( get_theme_mod( 'cz_404_homepage_link', '#' ) ); ?>">
								<div class="card-body text-left">
									<div class="media align-items-center"><i class="czi-home text-primary h4 mb-0"></i>
										<div class="media-body pl-3">
											<h5 class="font-size-sm mb-0"><?php esc_html_e( 'Homepage', 'cartzilla' ); ?></h5>
											<span class="text-muted font-size-ms"><?php esc_html_e( 'Return to homepage', 'cartzilla' ); ?></span>
										</div>
									</div>
								</div>
							</a>
						</div>
						<div class="col-sm-4 mb-3">
							<a class="card h-100 border-0 box-shadow-sm" data-cz-customizer="search_btn" href="<?php echo esc_url( get_theme_mod( 'cz_404_search_link', '#' ) ); ?>">
								<div class="card-body text-left">
									<div class="media align-items-center"><i class="czi-search text-success h4 mb-0"></i>
										<div class="media-body pl-3">
										  <h5 class="font-size-sm mb-0"><?php esc_html_e( 'Search', 'cartzilla' ); ?></h5>
										  <span class="text-muted font-size-ms"><?php esc_html_e( 'Find with advanced search', 'cartzilla' ); ?></span>
										</div>
									</div>
								</div>
							</a>
						</div>
						<div class="col-sm-4 mb-3">
							<a class="card h-100 border-0 box-shadow-sm" data-cz-customizer="support_btn" href="<?php echo esc_url( get_theme_mod( 'cz_404_support_link', '#' ) ); ?>">
								<div class="card-body text-left">
									<div class="media align-items-center"><i class="czi-help text-info h4 mb-0"></i>
										<div class="media-body pl-3">
										  <h5 class="font-size-sm mb-0"><?php esc_html_e( 'Help &amp; Support', 'cartzilla' ); ?></h5>
										  <span class="text-muted font-size-ms"><?php esc_html_e( 'Visit our help center', 'cartzilla' ); ?></span>
										</div>
									</div>
								</div>
							</a>
						</div>
					</div>
				</div>
			</div>
		<?php endif; ?>
	</div>
<?php
endif;

get_footer();
