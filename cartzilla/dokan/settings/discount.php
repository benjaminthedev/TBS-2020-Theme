<?php
/**
 * Settings discount template
 *
 * @since 2.6
 */
if ( isset( $is_enable_op_discount['order-discount'] ) && $is_enable_op_discount['order-discount'] == 'order-discount' ) {
    ?>
    <div class="col-sm-12">
        <div class="row">
            <div class="col-sm-12">
                <div class="form-group">
                    <label><?php esc_html_e( 'Discount', 'cartzilla' ); ?></label>
                    <div class="custom-control custom-checkbox d-block">
                        <input type="hidden" name="setting_show_minimum_order_discount_option" value="no">
                        <input id="lbl_setting_minimum_quantity" class="custom-control-input" type="checkbox" name="setting_show_minimum_order_discount_option" value="yes"<?php checked( $is_enable_order_discount, 'yes' ); ?>>
                        <label class="custom-control-label" for="lbl_setting_minimum_quantity"><?php esc_html_e( 'Enable storewide discount', 'cartzilla' ); ?></label>
                    </div>
                </div>
            </div>
            <div class="col-sm-12 show_if_needs_sw_discount <?php echo esc_attr( ($is_enable_order_discount=='yes') ? '' : 'hide_if_order_discount' );?>">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <input id="setting_minimum_order_amount" value="<?php echo esc_attr( $setting_minimum_order_amount ); ?>" name="setting_minimum_order_amount" placeholder="<?php esc_html_e( 'Minimum Order Amount', 'cartzilla' ); ?>" class="form-control" type="number">
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <input id="setting_order_percentage" value="<?php echo esc_attr( $setting_order_percentage ); ?>" name="setting_order_percentage" placeholder="<?php esc_html_e( 'Percentage', 'cartzilla' ); ?>" class="form-control" type="number" min="1" max="100">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php
}
?>