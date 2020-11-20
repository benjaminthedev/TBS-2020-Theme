<?php
/**
 * Template for displaying the "v1" footer.
 * 
 * @link https://codex.wordpress.org/Template_Hierarchy
 */

$layout = function_exists( 'cartzilla_footer_layout' ) ? cartzilla_footer_layout() : 'dark';
$additional_class = apply_filters('cartzilla_bottom_bar_class', '');

$has_footer_social_icons = ( has_nav_menu( 'social_media' ) && apply_filters( 'cartzilla_enable_footer_social_icons', true ) ) ? true : false;
$has_footer_pm = ! empty( cartzilla_get_footer_pm() ) ? true : false;
?>
<footer class="site-footer footer-v1 <?php echo esc_attr( $layout == 'light' ? 'footer-light bg-secondary' : 'footer-dark bg-dark' ) ?><?php echo cartzilla_header_layout() === 'grocery' ? ' sidebar-fixed-enabled': '';?>">

    <?php if ( apply_filters( 'cartzilla_enable_footer_widgets', true ) && cartzilla_is_active_sidebars( [ 'footer-column-1', 'footer-column-2', 'footer-column-3' ] ) ) : ?>
        <div class="container pt-5">
            <div class="row pb-2">
                <?php if ( is_active_sidebar( 'footer-column-1' ) ) : ?>
                    <div class="col-md-4 col-sm-6">
                        <?php dynamic_sidebar( apply_filters('cartzilla_footer_widget_1', 'footer-column-1' ) ); ?>
                    </div>
                <?php endif; ?>
                <?php if ( is_active_sidebar( 'footer-column-2' ) ) : ?>
                    <div class="col-md-4 col-sm-6">
                        <?php dynamic_sidebar( apply_filters('cartzilla_footer_widget_2', 'footer-column-2' ) ); ?>
                    </div>
                <?php endif; ?>
                <?php if ( is_active_sidebar( 'footer-column-3' ) ) : ?>
                    <div class="col-md-4">
                        <?php dynamic_sidebar( apply_filters('cartzilla_footer_widget_3', 'footer-column-3' ) ); ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    <?php endif; ?>

    <div class="pt-5<?php if( $layout == 'dark' ) echo esc_attr( ' bg-darker' ) ?> <?php echo esc_attr( $additional_class );?>"<?php if( $layout == 'light' ) echo esc_attr( ' style=background-color:' . '#ecf2f7;' ) ?>>
        <div class="container">
            <?php if ( apply_filters( 'cartzilla_enable_footer_static_content' , true )) :
                cartzilla_footer_static_content(); 
            endif; ?>
            <div class="row pb-2">
                <div class="<?php echo esc_attr( ( $has_footer_social_icons || $has_footer_pm ) ? 'col-md-6' : 'col-12' ); ?> text-center text-md-left mb-4">
                    <div class="text-nowrap mb-4">
                        <?php cartzilla_footer_logo(); ?>
                        <?php if ( apply_filters( 'cartzilla_enable_footer_language_currency_dropdown',  get_theme_mod( 'enable_footer_language_currency', 'no' ) ) === 'yes' && has_filter( 'cartzilla_dropdown_tools_toggle' ) ) : ?>
                            <div class="btn-group dropdown disable-autohide">
                                <button class="btn btn-sm dropdown-toggle px-3 <?php echo esc_attr( $layout == 'light' ? 'btn-outline-secondary' : 'btn-outline-light border-light' ) ?>" type="button" data-toggle="dropdown">
                                    <?php cartzilla_dropdown_tools_toggle(); ?>
                                </button>
                                <ul class="dropdown-menu">
                                    <?php cartzilla_dropdown_tools(); ?>
                                </ul>
                            </div>
                        <?php endif; ?>
                    </div>
                    <?php if ( apply_filters( 'cartzilla_enable_footer_menu' , true )) : ?>
                        <div class="widget widget-links widget-light">
                            <?php cartzilla_footer_menu(); ?>
                        </div>
                    <?php endif; ?>
                </div>
                <?php if ( $has_footer_social_icons || $has_footer_pm ) : ?>
                    <div class="col-md-6 text-center text-md-right mb-4">
                        <?php if ( $has_footer_social_icons ) : ?>
                            <div class="mb-3">
                                <?php cartzilla_social_menu(); ?>
                            </div>
                        <?php endif; ?>
                        <?php if ( $has_footer_pm ) :
                            cartzilla_footer_pm(); 
                        endif; ?>
                    </div>
                <?php endif; ?>
            </div>

            <?php if ( cartzilla_is_copyright() ) : ?>
                <div class="pb-4 font-size-xs text-center text-md-<?php echo apply_filters( 'cartzilla_footer_copyright_alignment', get_theme_mod( 'copyright_alignment', 'left' ) );?> copyright <?php echo esc_attr( $layout == 'light' ? 'text-muted' : 'text-light opacity-50' ) ?>">
                    <?php cartzilla_copyright(); ?>
                </div>
            <?php endif; ?>

        </div>
    </div>
</footer>
