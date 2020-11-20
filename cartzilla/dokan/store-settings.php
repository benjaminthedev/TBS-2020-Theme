<div id="dokan-seller-vacation-settings" class="col-12">
    <div class="row">
        <div class="col-12 goto_vacation_settings">
            <div class="form-group">
                <label><?php esc_html_e( 'Go to Vacation', 'cartzilla' ); ?></label>
                <div class="custom-control custom-checkbox d-block">
                    <input type="hidden" name="setting_go_vacation" value="no">
                    <input type="checkbox" name="setting_go_vacation" id="dokan-seller-vacation-activate" class="custom-control-input" value="yes"<?php checked( $setting_go_vacation, 'yes' ); ?>>
                    <label class="custom-control-label" for="dokan-seller-vacation-activate"><?php esc_html_e( 'Want to go vacation by closing our store publically', 'cartzilla' ); ?></label>
                </div>
            </div>
        </div>
        <div id="dokan-seller-vacation-closing-style" class="col-12 <?php echo dokan_validate_boolean( $setting_go_vacation ) ? '' : 'dokan-hide'; ?>">
            <div class="form-group">
                <label for="settings_closing_style"><?php esc_html_e( 'Closing Style', 'cartzilla' ); ?></label>
                <select id="settings_closing_style" name="settings_closing_style" class="custom-select">
                    <?php foreach ( $closing_style_options as $key => $closing_style_option ): ?>
                        <option value="<?php echo esc_attr( $key ); ?>" <?php selected( $key, $settings_closing_style ); ?>><?php echo esc_html( $closing_style_option ); ?></option>
                   <?php endforeach ?>
                </select>
            </div>
        </div>
        <div id="dokan-seller-vacation-vacation-dates" class="col-12 <?php echo esc_attr( $show_schedules ? '' : 'dokan-hide' ); ?>">
            <div class="row">
                <div class="col-12">
                    <label><?php esc_html_e( 'Date Range', 'cartzilla' ); ?></label>
                    <div class="row">
                        <div class="col-md-6 dokan-seller-vacation-datepickers">
                            <div class="form-group">
                                <label for="dokan-seller-vacation-date-from"><?php esc_html_e( 'From', 'cartzilla' ) ?></label>
                                <input type="text" class="form-control" id="dokan-seller-vacation-date-from" name="dokan_seller_vacation_datewise_from">
                            </div>
                        </div>
                        <div class="col-md-6 dokan-seller-vacation-datepickers">
                            <div class="form-group">
                                <label for="dokan-seller-vacation-date-to"><?php esc_html_e( 'To', 'cartzilla' ) ?></label>
                                <input type="text" class="form-control" id="dokan-seller-vacation-date-to" name="dokan_seller_vacation_datewise_to">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-12">
                    <div class="form-group">
                        <label for="dokan-seller-vacation-message"><?php esc_html_e( 'Set Vacation Message', 'cartzilla' ); ?></label>
                        <textarea class="form-control" id="dokan-seller-vacation-message" rows="5" name="dokan_seller_vacation_datewise_message"></textarea>
                        <button
                            type="button"
                            class="btn btn-sm btn-secondary"
                            id="dokan-seller-vacation-save-edit"
                            disabled
                        ><i class="fa fa-check"></i> <span><?php esc_html_e( 'Save', 'cartzilla' ); ?></span></button>
                        <button
                            type="button"
                            class="btn btn-sm btn-secondary"
                            id="dokan-seller-vacation-cancel-edit"
                            disabled
                        ><i class="fa fa-times"></i> <?php esc_html_e( 'Cancel', 'cartzilla' ); ?></button>
                    </div>
                </div>

                <div class="col-12">
                    <div class="form-group">
                        <label><?php esc_html_e( 'Vacation List', 'cartzilla' ); ?></label>
                        <div class="table-responsive">
                            <table class="table dokan-table dokan-table-striped" id="dokan-seller-vacation-list-table">
                                <thead>
                                    <tr>
                                        <th class="dokan-seller-vacation-list-from"><?php esc_html_e( 'From', 'cartzilla' ); ?></th>
                                        <th class="dokan-seller-vacation-list-to"><?php esc_html_e( 'To', 'cartzilla' ); ?></th>
                                        <th class="dokan-seller-vacation-list-message"><?php esc_html_e( 'Message', 'cartzilla' ); ?></th>
                                        <th class="dokan-seller-vacation-list-action"></th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <input type="hidden" id="dokan-seller-vacation-schedules" value="<?php echo esc_attr( json_encode( $seller_vacation_schedules ) ); ?>">
            </div>
        </div>

        <div id="dokan-seller-vacation-vacation-instant-vacation-message" class="col-12 <?php echo esc_attr( $show_schedules ? 'dokan-hide' : '' ); ?>">
            <div class="form-group">
                <label for="dokan-seller-vacation-message-1"><?php esc_html_e( 'Set Vacation Message', 'cartzilla' ); ?></label>
                <textarea class="form-control" id="dokan-seller-vacation-message-1" rows="5" name="setting_vacation_message"><?php echo esc_html( $setting_vacation_message ); ?></textarea>
            </div>
        </div>
    </div>
</div>
