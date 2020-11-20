<?php
    $img_kses = apply_filters( 'dokan_product_image_attributes', array(
        'img' => array(
            'alt'    => array(),
            'class'  => array(),
            'height' => array(),
            'src'    => array(),
            'width'  => array(),
        ),
    ) );

    $row_actions_kses = apply_filters( 'dokan_row_actions_kses', array(
        'span' => array(
            'class' => array(),
        ),
        'a' => array(
            'href'    => array(),
            'onclick' => array(),
        ),
    ) );

    $price_kses = apply_filters( 'dokan_price_kses', array(
        'span' => array(
            'class' => array()
        ),
    ) );
?>
<tr class="<?php echo esc_attr( $tr_class ); ?>">

    <td class="dokan-product-select remove">
        <label for="cb-select-<?php echo esc_attr( $post->ID ); ?>"></label>
        <input class="cb-select-items dokan-checkbox" type="checkbox" name="bulk_products[]" value="<?php echo esc_attr( $post->ID ); ?>">
    </td>
    
    <td>
        <div class="media d-block d-sm-flex align-items-center py-4">
            <?php if ( current_user_can( 'dokan_edit_product' ) ): ?>
                <a class="d-block mb-3 mb-sm-0 mr-sm-4 mx-auto" href="<?php echo esc_url( dokan_edit_product_url( $post->ID ) ); ?>" style="width: 12.5rem"><?php echo wp_kses( $product->get_image( 'product-thumbnail' ), $img_kses ); ?></a>
            <?php else: ?>
                <?php echo wp_kses( $product->get_image( 'product-thumbnail' ), $img_kses ); ?>
            <?php endif ?>
            <div class="media-body text-center text-sm-left">
                <?php if ( current_user_can( 'dokan_edit_product' ) ): ?>
                    <h3 class="h6 product-title mb-2"><a href="<?php echo esc_url( dokan_edit_product_url( $post->ID ) ); ?>"><?php echo esc_html( $product->get_title() ); ?></a></h3>
                <?php else: ?>
                    <h3 class="h6 product-title mb-2"><a href=""><?php echo esc_html( $product->get_title() ); ?></a></h3>
                <?php endif ?>

                <?php if ( $price_html = $product->get_price_html() ) : ?>
                    <div class="d-inline-block text-accent">
                        <?php
                         echo wp_kses( $price_html, $price_kses );
                        ?>
                    </div>
                <?php endif;?>

                <div class="d-inline-block text-muted font-size-ms border-left ml-2 pl-2">
                    <?php
                    if ( $product->get_type() == 'simple' ) {
                        $price = wc_price( dokan()->commission->get_earning_by_product( $product ) );?>
                        <span><?php echo esc_html__( 'Earnings: ', 'cartzilla' ); ?></span>
                        <span class="font-weight-medium">
                            <?php echo wp_kses( $price, $price_kses );?>
                        </span><?php
                    } else {
                        $price = dokan_get_variable_product_earning( $product->get_id() ); ?>
                        <span><?php echo esc_html__( 'Earnings: ', 'cartzilla' ); ?></span>
                        <span class="font-weight-medium">
                        <?php echo wp_kses( $price, $price_kses );?>
                        </span><?php
                    }
                    ?>
                </div>

                <?php if ( !empty( $row_actions ) ): ?>
                    <div class="row-actions d-flex justify-content-center justify-content-sm-start pt-3">
                        <?php echo wp_kses( $row_actions, $row_actions_kses ); ?>
                    </div>
                <?php endif ?>
            </div>
        </div>
    </td>
    
    <td class="diviader"></td>

</tr>
