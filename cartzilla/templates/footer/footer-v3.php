<?php
/**
 * Template for displaying the "v3" footer.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 */

$layout = function_exists( 'cartzilla_footer_layout' ) ? cartzilla_footer_layout() : 'dark';
$footer_site_title = apply_filters( 'cartzilla_footer_site_title', get_theme_mod('footer_site_title', 'Marketplace') );
$footer_site_description = apply_filters( 'cartzilla_footer_site_description', get_theme_mod('footer_site_desc', 'High quality items created by our global community.') );
$additional_class = apply_filters('cartzilla_bottom_bar_class', '');
?>
<footer class="site-footer footer-v3 pt-5 <?php echo esc_attr( $layout == 'light' ? 'footer-light bg-secondary' : 'footer-dark bg-dark' ) ?><?php echo cartzilla_header_layout() === 'grocery' ? ' sidebar-fixed-enabled': '';?>">

    <div class="container pt-2 pb-3">
        <div class="row">
            <div class="col-md-6 text-center text-md-left mb-4">
                <div class="text-nowrap mb-3">
                    <?php cartzilla_footer_logo(); ?>
                    <span class="d-inline-block align-middle h5 font-weight-light text-white mb-0"><?php echo esc_html( $footer_site_title ); ?></span>
                </div>
                <p class="font-size-sm text-white opacity-70 pb-1"><?php echo wp_kses_post( $footer_site_description ); ?></p>
                <?php if ( apply_filters( 'cartzilla_enable_footer_statistics' , get_theme_mod( 'footer_statistics_enable', 'yes' ) ) === 'yes' ) :
                    cartzilla_footer_statistics();
                endif; ?>
                <?php if ( apply_filters( 'cartzilla_enable_footer_social_menu' , true )) : ?>
                    <div class="mt-4"><?php cartzilla_social_menu(); ?> </div>
                <?php endif; ?>
                
            </div>

           <?php if ( apply_filters( 'cartzilla_enable_footer_widgets', true ) && cartzilla_is_active_sidebars( [ 'footer-column-1', 'footer-column-2' ] ) ) : ?>
                <?php if ( is_active_sidebar( 'footer-column-1' ) ) : ?>
                    <div class="col-md-3 d-none d-md-block text-center text-md-left mb-4">
                        <?php dynamic_sidebar( apply_filters('cartzilla_footer_widget_1', 'footer-column-1' ) ); ?>
                    </div>
                <?php endif; ?>

                <?php if ( is_active_sidebar( 'footer-column-2' ) ) : ?>
                    <div class="col-md-3 d-none d-md-block text-center text-md-left mb-4">
                        <?php dynamic_sidebar( apply_filters('cartzilla_footer_widget_2', 'footer-column-2' ) ); ?>
                    </div>
                <?php endif; ?>
            <?php endif; ?>
        </div>
    </div>

    <div class="footer-bottom-bar<?php if( $layout == 'dark' ) echo esc_attr( ' bg-darker' ) ?> <?php echo esc_attr( $additional_class );?>"<?php if( $layout == 'light' ) echo esc_attr( ' style=background-color:' . '#ecf2f7;' ) ?>>
        <div class="container">
            <?php if ( apply_filters( 'cartzilla_enable_footer_static_content' , true )) :
                cartzilla_footer_static_content(); 
            endif; ?>


            <div class="d-md-flex justify-content-between">
                 <?php if ( cartzilla_is_copyright() ) : ?>
                    <div class="pb-4 font-size-xs text-center text-md-left copyright <?php echo esc_attr( $layout == 'light' ? 'text-muted' : 'text-light opacity-50' ) ?>">
                        <?php cartzilla_copyright(); ?>
                    </div>
                <?php endif; ?>

                <?php if ( apply_filters( 'cartzilla_enable_footer_menu' , true )) : ?>
                    <div class="widget widget-links widget-light pb-4">
                        <?php cartzilla_footer_menu(); ?>
                    </div>
                 <?php endif; ?>
            </div>
        </div>
    </div>

</footer>
