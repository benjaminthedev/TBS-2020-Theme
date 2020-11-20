<?php
/**
 * Template for displaying the "v2" footer.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 */

$layout = function_exists( 'cartzilla_footer_layout' ) ? cartzilla_footer_layout() : 'dark';
$additional_class = apply_filters('cartzilla_bottom_bar_class', '');
$has_footer_pm = ! empty( cartzilla_get_footer_pm() ) ? true : false;
?>
<footer class="site-footer footer-v2 pt-5 <?php echo esc_attr( $layout == 'light' ? 'footer-light bg-secondary' : 'footer-dark bg-dark' ) ?><?php echo cartzilla_header_layout() === 'grocery' ? ' sidebar-fixed-enabled': '';?>">

    <div class="px-lg-3 pt-2 pb-4">
        <div class="mx-auto px-3" style="max-width: 80rem;">
            <div class="row">
                <div class="col-xl-2 col-lg-3 col-sm-4 pb-2 mb-4">
                    <div class="mt-n1">
                        <?php cartzilla_footer_logo(); ?>
                        <?php if ( apply_filters( 'cartzilla_enable_footer_language_currency_dropdown',  get_theme_mod( 'enable_footer_language_currency', 'no' ) ) === 'yes' && has_filter( 'cartzilla_dropdown_tools_toggle' ) ) : ?>
                            <div class="btn-group dropdown disable-autohide mt-4">
                                <button class="btn btn-sm dropdown-toggle px-3 <?php echo esc_attr( $layout == 'light' ? 'btn-outline-secondary' : 'btn-outline-light border-light' ) ?>" type="button" data-toggle="dropdown">
                                    <?php cartzilla_dropdown_tools_toggle(); ?>
                                </button>
                                <ul class="dropdown-menu">
                                    <?php cartzilla_dropdown_tools(); ?>
                                </ul>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
                 <?php if ( apply_filters( 'cartzilla_enable_footer_widgets', true ) && cartzilla_is_active_sidebars( [ 'footer-column-1', 'footer-column-2', 'footer-column-3' ] ) ) : ?>
                    <?php if ( is_active_sidebar( 'footer-column-1' ) ) : ?>
                        <div class="col-xl-3 col-lg-4 col-sm-4">
                            <?php dynamic_sidebar( apply_filters('cartzilla_footer_widget_1', 'footer-column-1' ) ); ?>
                        </div>
                    <?php endif; ?>
                    <?php if ( is_active_sidebar( 'footer-column-2' ) ) : ?>
                        <div class="col-xl-3 col-lg-4 col-sm-4">
                            <?php dynamic_sidebar( apply_filters('cartzilla_footer_widget_2', 'footer-column-2' ) ); ?>
                        </div>
                    <?php endif; ?>
                    <?php if ( is_active_sidebar( 'footer-column-3' ) ) : ?>
                        <div class="col-xl-4 col-sm-8">
                            <?php dynamic_sidebar( apply_filters('cartzilla_footer_widget_3', 'footer-column-3' ) ); ?>
                        </div>
                    <?php endif; ?>
                 <?php endif; ?>
            </div>
        </div>
    </div>

    <?php if ( $has_footer_pm || cartzilla_is_copyright() ): ?>
        <div class="px-lg-3 py-3<?php if( $layout == 'dark' ) echo esc_attr( ' bg-darker' ) ?> <?php echo esc_attr( $additional_class );?>"<?php if( $layout == 'light' ) echo esc_attr( ' style=background-color:' . '#ecf2f7;' ) ?>>
            <div class="d-sm-flex justify-content-between align-items-center mx-auto px-3" style="max-width: 80rem;">
                <?php if ( cartzilla_is_copyright() ) : ?>
                    <div class="font-size-xs text-center text-sm-left py-3 copyright <?php echo esc_attr( $layout == 'light' ? 'text-muted' : 'text-light opacity-50' ) ?>">
                        <?php cartzilla_copyright(); ?>
                    </div>
                <?php endif; ?>

                <?php if ( $has_footer_pm ) : ?>
                    <div class="py-3">
                        <?php cartzilla_footer_pm(); ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    <?php endif;?>
</footer>
