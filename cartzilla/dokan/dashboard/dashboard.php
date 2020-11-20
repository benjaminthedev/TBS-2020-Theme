<?php
/**
 *  Dokan Dashboard Template
 *
 *  Dokan Main Dashboard template for Fron-end
 *
 *  @since 2.4
 *
 *  @package dokan
 */
?>
<?php do_action( 'dokan_dashboard_wrap_start' ); ?>

    <div class="dokan-dashboard-wrap">

        <?php

            /**
             *  dokan_dashboard_content_before hook
             *
             *  @hooked get_dashboard_side_navigation
             *
             *  @since 2.4
             */
            do_action( 'dokan_dashboard_content_before' );
        ?>

        <section class="col-lg-8 pt-lg-4 pb-4 mb-3">

            <?php

                /**
                 *  dokan_dashboard_content_inside_before hook
                 *
                 *  @hooked show_seller_dashboard_notice
                 *
                 *  @since 2.4
                 */
                do_action( 'dokan_dashboard_content_inside_before' );
            ?>

            <div class="dashboard-content-area pt-2 px-4 pl-lg-0 pr-xl-5">

                <?php

                    /**
                     *  dokan_dashboard_before_widgets hook
                     *
                     *  @hooked dokan_show_profile_progressbar
                     *
                     *  @since 2.4
                     */
                    do_action( 'dokan_dashboard_before_widgets' );
                ?>

                <div class="row mx-n2">

                    <div class="col-lg-8 px-2">

                        <?php

                            /**
                             *  dokan_dashboard_left_widgets hook
                             *
                             *  @hooked get_big_counter_widgets
                             *  @hooked get_orders_widgets
                             *  @hooked get_products_widgets
                             *
                             *  @since 2.4
                             */
                            do_action( 'dokan_dashboard_left_widgets' );
                        ?>

                    </div> <!-- .col-md-6 -->

                    <div class="col-lg-4 px-2">
                        <?php
                            /**
                             *  dokan_dashboard_right_widgets hook
                             *
                             *  @hooked get_sales_report_chart_widget
                             *
                             *  @since 2.4
                             */
                            do_action( 'dokan_dashboard_right_widgets' );
                        ?>

                    </div>
                </div>

                <?php

                    /**
                     *  dokan_dashboard_after_widgets hook
                     *
                     *  @hooked dokan_show_profile_progressbar
                     *
                     *  @since 2.4
                     */
                    do_action( 'dokan_dashboard_after_widgets' );
                ?>

            </div><!-- .dashboard-content-area -->

             <?php

                /**
                 *  dokan_dashboard_content_inside_after hook
                 *
                 *  @since 2.4
                 */
                do_action( 'dokan_dashboard_content_inside_after' );
            ?>


        </section><!-- .dokan-dashboard-content -->

        <?php

            /**
             *  dokan_dashboard_content_after hook
             *
             *  @since 2.4
             */
            do_action( 'dokan_dashboard_content_after' );
        ?>

    </div>

<?php do_action( 'dokan_dashboard_wrap_end' ); ?>
