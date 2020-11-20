<?php
/**
 *  Dashboard Widget Template
 *
 *  Get dokan dashboard widget template
 *
 *  @since 2.4
 *
 *  @package dokan
 *
 */
?>

<div class="dashboard-widget orders card">
    <div class="card-body">
        <h3 class="font-size-sm pb-3 mb-0 border-bottom"><?php esc_attr_e( 'Orders', 'cartzilla' ); ?></h3>
        <div class="d-flex justify-content-between align-items-center font-size-sm py-2 border-bottom">
            <a href="<?php echo esc_url( $orders_url ); ?>">
                <span class="title"><?php esc_attr_e( 'Total', 'cartzilla' ); ?></span> <span class="count"><?php echo esc_html( $orders_count->total ); ?></span>
            </a>
        </div>
        <div class="d-flex justify-content-between align-items-center font-size-sm py-2 border-bottom">
            <a href="<?php echo esc_url( add_query_arg( array( 'order_status' => 'wc-completed' ), $orders_url ) ); ?>" style="color: <?php echo esc_attr( $order_data[0]['color'] ); ?>">
                <span class="title"><?php esc_attr_e( 'Completed', 'cartzilla' ); ?></span> <span class="count"><?php echo esc_html( number_format_i18n( $orders_count->{'wc-completed'}, 0 ) ); ?></span>
            </a>
        </div>
        <div class="d-flex justify-content-between align-items-center font-size-sm py-2 border-bottom">
            <a href="<?php echo esc_url( add_query_arg( array( 'order_status' => 'wc-pending' ), $orders_url ) ); ?>" style="color: <?php echo esc_attr( $order_data[1]['color'] ); ?>">
                <span class="title"><?php esc_attr_e( 'Pending', 'cartzilla' ); ?></span> <span class="count"><?php echo esc_html( number_format_i18n( $orders_count->{'wc-pending'}, 0 ) ); ?></span>
            </a>
        </div>
        <div class="d-flex justify-content-between align-items-center font-size-sm py-2 border-bottom">
            <a href="<?php echo esc_url( add_query_arg( array( 'order_status' => 'wc-processing' ), $orders_url ) ); ?>" style="color: <?php echo esc_attr( $order_data[2]['color'] ); ?>">
                <span class="title"><?php esc_attr_e( 'Processing', 'cartzilla' ); ?></span> <span class="count"><?php echo esc_html( number_format_i18n( $orders_count->{'wc-processing'}, 0 ) ); ?></span>
            </a>
        </div>
        <div class="d-flex justify-content-between align-items-center font-size-sm py-2 border-bottom">
            <a href="<?php echo esc_url( add_query_arg( array( 'order_status' => 'wc-cancelled' ), $orders_url ) ); ?>" style="color: <?php echo esc_attr( $order_data[3]['color'] ); ?>">
                <span class="title"><?php esc_html_e( 'Cancelled', 'cartzilla' ); ?></span> <span class="count"><?php echo esc_html( number_format_i18n( $orders_count->{'wc-cancelled'}, 0 ) ); ?></span>
            </a>
        </div>
        <div class="d-flex justify-content-between align-items-center font-size-sm py-2 border-bottom">
            <a href="<?php echo esc_url( add_query_arg( array( 'order_status' => 'wc-refunded' ), $orders_url ) ); ?>" style="color: <?php echo esc_attr( $order_data[4]['color'] ); ?>">
                <span class="title"><?php esc_html_e( 'Refunded', 'cartzilla' ); ?></span> <span class="count"><?php echo esc_html( number_format_i18n( $orders_count->{'wc-refunded'}, 0 ) ); ?></span>
            </a>
        </div>
        <div class="d-flex justify-content-between align-items-center font-size-sm py-2">
            <a href="<?php echo esc_url( add_query_arg( array( 'order_status' => 'wc-on-hold' ), $orders_url ) ); ?>" style="color: <?php echo esc_attr( $order_data[5]['color'] ); ?>">
                <span class="title"><?php esc_html_e( 'On hold', 'cartzilla' ); ?></span> <span class="count"><?php echo esc_html( number_format_i18n( $orders_count->{'wc-on-hold'}, 0  ) ); ?></span>
            </a>
        </div>
    </div>
</div> <!-- .orders -->
