<?php
/**
 * Dokan Settings Main Template
 *
 * @since 2.4
 *
 * @package dokan
 */
?>

<?php do_action( 'dokan_dashboard_wrap_start' ); ?>

    <div class="dokan-dashboard-wrap">

        <?php

            /**
             *  dokan_dashboard_content_before hook
             *  dokan_dashboard_settings_store_content_before hook
             *
             *  @hooked get_dashboard_side_navigation
             *
             *  @since 2.4
             */
            do_action( 'dokan_dashboard_content_before' );
            do_action( 'dokan_dashboard_settings_content_before' );
        ?>

        <section class="col-lg-8 pt-lg-4 pb-4 mb-3 dokan-settings-content">
            <?php

                /**
                 *  dokan_settings_content_inside_before hook
                 *
                 *  @since 2.4
                 */
                do_action( 'dokan_settings_content_inside_before' );
            ?>
            <div class="dokan-settings-area pt-2 px-4 pl-lg-0 pr-xl-5">

                <?php
                    /**
                     * dokan_review_content_area_header hook
                     *
                     * @hooked dokan_settings_content_area_header
                     *
                     * @since 2.4
                     */
                    do_action( 'dokan_settings_content_area_header' );


                    /**
                     * dokan_settings_content hook
                     *
                     * @hooked render_settings_content_hook
                     */
                    do_action( 'dokan_settings_content' );
                ?>

                <!--settings updated content ends-->
            </div>
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
