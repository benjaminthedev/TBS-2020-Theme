<?php

/**
 *  Dokan Dashboard Template
 *
 *  Dokan Dashboard Sales chart report widget
 *
 *  @since 2.4
 *
 *  @package dokan
 */
?>

<div class="dashboard-widget sells-graph card">
    <div class="card-body">
        <h3 class="font-size-sm pb-3 mb-0 border-bottom">
            <?php esc_html_e( 'Sales ', 'cartzilla' ); ?>
            <span class="font-weight-normal font-size-xs text-muted">
                <?php esc_html_e( 'Past 2 weeks', 'cartzilla' ); ?>
            </span>
        </h3>

        <?php
    	    require_once DOKAN_INC_DIR . '/reports.php';
    	    dokan_dashboard_sales_overview();
        ?>
    </div>
</div> <!-- .sells-graph -->
