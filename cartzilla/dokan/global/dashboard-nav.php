<?php
$home_url = home_url();
$active_class = ' class="active"'
?>
<aside class="col-lg-4">
    <div class="d-block d-lg-none p-4">
        <a class="btn btn-outline-accent d-block" href="#account-menu" data-toggle="collapse">
            <i class="czi-menu mr-2"></i>
            <?php echo apply_filters( 'cartzilla_dokan_dashboard_handheld_sidebar_title', esc_html__( 'Account menu', 'cartzilla' ) ); ?>
        </a>
    </div>
    <div class="cz-sidebar-static h-100 p-0">
        <div id="account-menu" class="secondary-nav collapse border-right">
            <?php
                global $allowedposttags;

                // These are required for the hamburger menu.
                if ( is_array( $allowedposttags ) ) {
                    $allowedposttags['input'] = [
                        'id'      => [],
                        'type'    => [],
                        'checked' => []
                    ];
                }

                echo wp_kses( cartzilla_dokan_dashboard_nav( $active_menu ), $allowedposttags );
            ?>
        </div>
    </div>
</aside>
