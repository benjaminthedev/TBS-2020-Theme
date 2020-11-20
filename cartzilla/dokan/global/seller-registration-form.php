<?php
/**
 * Dokan Seller registration form
 *
 * @since 2.4
 *
 * @package dokan
 */
?>

<div class="show_if_seller" style="<?php echo esc_attr( $role_style ); ?>">

    <div class="split-row form-row-wide row">
        <div class="woocommerce-form-row form-group col-12 col-sm-6">
            <label for="first-name"><?php esc_html_e( 'First Name', 'cartzilla' ); ?> <span class="required">*</span></label>
            <input type="text" class="input-text form-control" name="fname" id="first-name" value="<?php if ( ! empty( $postdata['fname'] ) ) echo esc_attr($postdata['fname']); ?>" required="required" />
        </div>

        <div class="woocommerce-form-row form-group col-12 col-sm-6">
            <label for="last-name"><?php esc_html_e( 'Last Name', 'cartzilla' ); ?> <span class="required">*</span></label>
            <input type="text" class="input-text form-control" name="lname" id="last-name" value="<?php if ( ! empty( $postdata['lname'] ) ) echo esc_attr($postdata['lname']); ?>" required="required" />
        </div>
    </div>

    <div class="woocommerce-form-row form-group form-row-wide">
        <label for="company-name"><?php esc_html_e( 'Shop Name', 'cartzilla' ); ?> <span class="required">*</span></label>
        <input type="text" class="input-text form-control" name="shopname" id="company-name" value="<?php if ( ! empty( $postdata['shopname'] ) ) echo esc_attr($postdata['shopname']); ?>" required="required" />
    </div>

    <div class="woocommerce-form-row form-group form-row-wide">
        <label for="seller-url" class="pull-left"><?php esc_html_e( 'Shop URL', 'cartzilla' ); ?> <span class="required">*</span></label>
        <strong id="url-alart-mgs" class="pull-right"></strong>
        <input type="text" class="input-text form-control" name="shopurl" id="seller-url" value="<?php if ( ! empty( $postdata['shopurl'] ) ) echo esc_attr($postdata['shopurl']); ?>" required="required" />
        <small><?php echo esc_url( home_url() . '/' . dokan_get_option( 'custom_store_url', 'dokan_general', 'store' ) ); ?>/<strong id="url-alart"></strong></small>
    </div>

    <div class="woocommerce-form-row form-group form-row-wide">
        <label for="shop-phone"><?php esc_html_e( 'Phone Number', 'cartzilla' ); ?><span class="required">*</span></label>
        <input type="text" class="input-text form-control" name="phone" id="shop-phone" value="<?php if ( ! empty( $postdata['phone'] ) ) echo esc_attr($postdata['phone']); ?>" required="required" />
    </div>

    <?php
    $show_terms_condition = dokan_get_option( 'enable_tc_on_reg', 'dokan_general' );
    $terms_condition_url  = dokan_get_terms_condition_url();

    if ( 'on' === $show_terms_condition && $terms_condition_url ) { ?>
        <div class="woocommerce-form-row form-group form-row-wide">
            <input class="tc_check_box" type="checkbox" id="tc_agree" name="tc_agree" required="required">
            <label style="display: inline" for="tc_agree"><?php echo wp_kses_post( sprintf( __( 'I have read and agree to the <a target="_blank" href="%s">Terms &amp; Conditions</a>.', 'cartzilla' ), esc_url( $terms_condition_url ) ) ); ?></label>
        </div>
    <?php }

    do_action( 'dokan_seller_registration_field_after' );
    ?>
</div>

<?php do_action( 'dokan_reg_form_field' ); ?>

<div class="form-row form-group user-role">

    <label class="radio form-check-inline">
        <input type="radio" name="role" class="form-check-input" value="customer"<?php checked( $role, 'customer' ); ?>>
        <?php esc_html_e( 'I am a customer', 'cartzilla' ); ?>
    </label>

    <label class="radio form-check-inline">
        <input type="radio" name="role" class="form-check-input" value="seller"<?php checked( $role, 'seller' ); ?>>
        <?php esc_html_e( 'I am a vendor', 'cartzilla' ); ?>
    </label>

    <?php do_action( 'dokan_registration_form_role', $role ); ?>

</div>
