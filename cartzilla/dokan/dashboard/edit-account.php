<?php
/**
 *  Dokan Dashboard Template
 *
 *  Dokan Main Dashboard template for Front-end
 *
 *  @since 2.5
 *
 *  @package dokan
 */

$user = get_user_by( 'id', get_current_user_id() );
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

        <section class="col-lg-8 pt-lg-4 pb-4 mb-3 dokan-dashboard-content">

            <?php
                /**
                 *  dokan_dashboard_content_before hook
                 *
                 *  @hooked show_seller_dashboard_notice
                 *
                 *  @since 2.4
                 */
                do_action( 'dokan_dashboard_content_inside_before' );
            ?>

                <div class="edit-account-wrap pt-2 px-4 pl-lg-0 pr-xl-5">

                    <?php
                        /**
                         * dokan_review_content_area_header hook
                         *
                         * @hooked dokan_settings_content_area_header
                         *
                         * @since 2.4
                         */
                        do_action( 'dokan_dashboard_edit_account_area_header' );
                    ?>

                    <?php wc_print_notices();?>

                    <form class="woocommerce-EditAccountForm edit-account" action="" method="post" <?php do_action( 'woocommerce_edit_account_form_tag' ); ?> >

                        <?php do_action( 'woocommerce_edit_account_form_start' ); ?>

                        <div class="row">
                            <div class="col-sm-6">
                                <div class="woocommerce-form-row woocommerce-form-row--first form-group">
                                    <label for="account_first_name"><?php esc_html_e( 'First name', 'cartzilla' ); ?><span class="text-danger">*</span></label>
                                    <input type="text" class="woocommerce-Input woocommerce-Input--text input-text form-control" name="account_first_name" id="account_first_name" autocomplete="given-name" value="<?php echo esc_attr( $user->first_name ); ?>" />
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="woocommerce-form-row woocommerce-form-row--last form-group">
                                    <label for="account_last_name"><?php esc_html_e( 'Last name', 'cartzilla' ); ?><span class="text-danger">*</span></label>
                                    <input type="text" class="woocommerce-Input woocommerce-Input--text input-text form-control" name="account_last_name" id="account_last_name" autocomplete="family-name" value="<?php echo esc_attr( $user->last_name ); ?>" />
                                </div>
                            </div>
                        </div>

                        <div class="woocommerce-form-row woocommerce-form-row--wide form-group">
                            <label for="account_display_name"><?php esc_html_e( 'Display name', 'cartzilla' ); ?><span class="text-danger">*</span></label>
                            <input type="text" class="woocommerce-Input woocommerce-Input--text input-text form-control" name="account_display_name" id="account_display_name" value="<?php echo esc_attr( $user->display_name ); ?>" />
                            <small class="form-text text-muted"><?php esc_html_e( 'This will be how your name will be displayed in the account section and in reviews', 'cartzilla' ); ?></small>
                        </div>

                        <div class="woocommerce-form-row woocommerce-form-row--wide form-group">
                            <label for="account_email"><?php esc_html_e( 'Email address', 'cartzilla' ); ?><span class="text-danger">*</span></label>
                            <input type="email" class="woocommerce-Input woocommerce-Input--email input-text form-control" name="account_email" id="account_email" autocomplete="email" value="<?php echo esc_attr( $user->user_email ); ?>" />
                        </div>

                        <div class="woocommerce-form-row woocommerce-form-row--wide form-group">
                            <label for="password_current"><?php echo esc_html__( 'Current password', 'cartzilla' ); ?></label>
                            <div class="password-toggle">
                                <input type="password" class="woocommerce-Input woocommerce-Input--password input-text form-control" name="password_current" id="password_current" autocomplete="off" />
                                <label class="password-toggle-btn">
                                    <input class="custom-control-input" type="checkbox">
                                    <i class="czi-eye password-toggle-indicator"></i>
                                    <span class="sr-only"><?php echo esc_html__( 'Show password', 'cartzilla' ); ?></span>
                                </label>
                            </div>
                            <small class="form-text text-muted"><?php echo esc_html__( 'Leave blank to leave unchanged', 'cartzilla' ); ?></small>
                        </div>
                        <div class="woocommerce-form-row woocommerce-form-row--wide form-group">
                            <label for="password_1"><?php echo esc_html__( 'New password', 'cartzilla' ); ?></label>
                            <div class="password-toggle">
                                <input type="password" class="woocommerce-Input woocommerce-Input--password input-text form-control" name="password_1" id="password_1" autocomplete="off" />
                                <label class="password-toggle-btn">
                                    <input class="custom-control-input" type="checkbox">
                                    <i class="czi-eye password-toggle-indicator"></i>
                                    <span class="sr-only"><?php echo esc_html__( 'Show password', 'cartzilla' ); ?></span>
                                </label>
                            </div>
                            <small class="form-text text-muted"><?php echo esc_html__( 'Leave blank to leave unchanged', 'cartzilla' ); ?></small>
                        </div>
                        <div class="woocommerce-form-row woocommerce-form-row--wide form-group">
                            <label for="password_2"><?php esc_html_e( 'Confirm new password', 'cartzilla' ); ?></label>
                            <div class="password-toggle">
                                <input type="password" class="woocommerce-Input woocommerce-Input--password input-text form-control" name="password_2" id="password_2" autocomplete="off" />
                                <label class="password-toggle-btn">
                                    <input class="custom-control-input" type="checkbox">
                                    <i class="czi-eye password-toggle-indicator"></i>
                                    <span class="sr-only"><?php echo esc_html__( 'Show password', 'cartzilla' ); ?></span>
                                </label>
                            </div>
                        </div>

                        <?php do_action( 'woocommerce_edit_account_form' ); ?>

                        <button type="submit" class="woocommerce-Button button btn btn-primary" name="save_account_details" value="<?php esc_attr_e( 'Save changes', 'cartzilla' ); ?>"><?php esc_html_e( 'Save changes', 'cartzilla' ); ?></button>
                        <input type="hidden" name="action" value="save_account_details" />
                        <?php wp_nonce_field( 'save_account_details', 'save-account-details-nonce' ); ?>

                        <?php do_action( 'woocommerce_edit_account_form_end' ); ?>

                    </form>

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

