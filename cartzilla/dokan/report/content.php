<?php
/**
 * Dokan Review Content Template
 *
 * @since 2.4
 *
 * @package dokan
 */
?>
<div class="dokan-report-wrap">
    <ul class="nav nav-tabs nav-justified align-items-end">
    <?php
    foreach ( $charts['charts'] as $key => $value ) {
        if ( isset( $value['permission'] ) && ! current_user_can( $value['permission'] ) ) {
            continue;
        }

        $class = ( $current == $key ) ? 'nav-link px-2 active' : 'nav-link px-2';
        printf( '<li class="text-center flex-grow-1"><a href="%s" class="%s">%s</a></li>', add_query_arg( array( 'chart' => $key ), $link ), $class, $value['title'] );
    }
    ?>
    </ul>

    <?php if ( isset( $charts['charts'][$current] ) ) { ?>
        <?php if ( isset( $charts['charts'][$current]['permission'] ) && ! current_user_can( $charts['charts'][$current]['permission'] ) ): ?>
            <?php
                dokan_get_template_part('global/dokan-error', '', array( 'deleted' => false, 'message' => esc_html__( 'You have no permission to view this report', 'cartzilla' ) ) );
            ?>
        <?php else: ?>
            <div id="dokan_tabs_container">
                <div class="tab-pane active" id="home">
                    <?php
                    $func = $charts['charts'][$current]['function'];
                    if ( $func && ( is_callable( $func ) ) ) {
                        call_user_func( $func );
                    }
                    ?>
                </div>
            </div>
        <?php endif ?>

    <?php } ?>
</div>
