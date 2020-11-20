<?php
/**
 * Dokan Settings Payment Template
 *
 * @since 2.2.2 Insert action before payment settings form
 *
 * @package dokan
 */
$has_methods = false;

do_action( 'dokan_payment_settings_before_form', $current_user, $profile_info ); ?>

<form method="post" id="payment-form"  action="" class="dokan-form">

    <?php wp_nonce_field( 'dokan_payment_settings_nonce' ); ?>

    <?php foreach ( $methods as $method_key ) {
        $method = dokan_withdraw_get_method( $method_key );

        if ( ! empty( $method ) ) {
            $has_methods = true;
        }

        if ( isset( $method['callback'] ) && is_callable( $method['callback'] ) ) {
        ?>
        <div class="payment-field-<?php echo esc_attr( $method_key ); ?>">
            <div class="form-group">
                <label><?php echo esc_html( $method['title'] ) ?></label>
                <?php call_user_func( $method['callback'], $profile_info ); ?>
            </div>
        </div>
        <?php } ?>
    <?php } ?>
    <?php
    /**
     * @since 2.2.2 Insert action on botton of payment settings form
     */
    do_action( 'dokan_payment_settings_form_bottom', $current_user, $profile_info ); ?>

    <?php if ( $has_methods ): ?>
        <div class="form-group">
            <div class="ajax_prev">
                <input type="submit" name="dokan_update_payment_settings" class="btn dokan-btn dokan-btn-danger dokan-btn-theme" value="<?php esc_attr_e( 'Update Settings', 'cartzilla' ); ?>">
            </div>
        </div>
    <?php endif ?>

</form>

<?php
    if ( ! $has_methods ) {
        dokan_get_template_part( 'global/dokan-error', '', array( 'deleted' => false, 'message' => esc_html__( 'No withdraw method is available. Please contact site admin.', 'cartzilla' ) ) );
    }
?>


<?php
/**
 * @since 2.2.2 Insert action after social settings form
 */
do_action( 'dokan_payment_settings_after_form', $current_user, $profile_info ); ?>
