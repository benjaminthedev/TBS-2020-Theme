<div class="cz-sidebar border-right" id="help-sidebar">
    <div class="cz-sidebar-header box-shadow-sm">
        <button class="close ml-auto" type="button" data-dismiss="sidebar" aria-label="Close">
            <span class="d-inline-block font-size-xs font-weight-normal align-middle"><?php echo esc_html__( 'Close Sidebar', 'cartzilla' ); ?></span>
            <span class="d-inline-block align-middle ml-2" aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="wedocs-sidebar wedocs-hide-mobile cz-sidebar-body py-lg-1 pl-lg-0" data-simplebar data-simplebar-auto-hide="true"><?php
        do_action( 'cz_wedocs_sidebar' );
    ?></div>
</div>