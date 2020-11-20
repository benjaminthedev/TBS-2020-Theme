<?php
/**
 * Compare Template
 *
 * @author Transvelo
 * @package Cartzilla/templates/shop
 * @version 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

global $product, $yith_woocompare, $post; ?>
    
<?php if( ! empty( $products ) ) : ?>

<div class="table-responsive table-responsive-sm compare py-5 mb-lg-4">

    <table class="table table-bordered table-fixed font-size-sm compare-table">

        <thead>
            <?php $fields_displayed = array(); ?>

                <?php if( isset( $fields['image'] ) && isset( $fields['title'] ) && isset( $fields['add-to-cart'] ) ) : ?>
                <tr>
                    <td class="align-middle">
                    </td>
                    
                    <?php foreach( $products as $key => $product ) : ?>
                        <?php $product_id = $product->get_id(); ?>

                        <td class="text-center px-4 pb-4">
                            <?php 
                                $remove_product_url_args    = array(
                                    'id'     => $product->get_id(),
                                    'action' => $yith_woocompare->obj->action_remove
                                );
                                $remove_product_url = esc_url_raw( add_query_arg( $remove_product_url_args, cartzilla_get_compare_page_url() ) )
                            ?>
                            <a class="btn btn-sm btn-block text-danger mb-2" href="<?php echo esc_url( $remove_product_url ); ?>" data-product_id="<?php echo esc_attr( $product->get_id() ); ?>" class="remove-icon" title="<?php echo esc_attr( esc_html__( 'Remove', 'cartzilla' ) ); ?>"><i class="czi-trash mr-1"></i><?php echo esc_html__( 'Remove', 'cartzilla' ); ?></a>

                            <a href="<?php echo get_permalink( $product_id ); ?>" class="product d-inline-block mb-3">
                                <div class="product-image">
                                    <div class="image">
                                        <?php 
                                            if( has_post_thumbnail( $product_id ) ) {
                                                echo get_the_post_thumbnail( $product_id, 'shop_catalog' );
                                            } elseif( wc_placeholder_img_src() ) {
                                                echo wc_placeholder_img( 'shop_catalog' );
                                            }
                                        ?>
                                    </div>
                                </div>
                            </a>

                            <h3 class="product-title font-size-sm"><a href="<?php echo get_permalink( $product_id ); ?>" class="product"><?php echo esc_html( $product->fields['title'] ); ?></a></h3>
                            <?php wc_get_template( 'loop/add-to-cart.php', array( 'product' => $product ) ); ?>
                          

                           <?php 
                                $fields_displayed[] = 'image';
                                $fields_displayed[] = 'title';
                            ?>
                        </td>
                    <?php endforeach; ?>     
                   
                </tr>
                <?php endif; ?>
           
          </thead>
        
         <tbody id="summary" data-filter="target">

            <?php $fields_displayed = array(); ?>

            <?php if( isset( $fields['title'] ) ) : ?>
            <tr class="bg-secondary">
                <th class="text-uppercase text-dark"><?php echo esc_html__( 'Summary', 'cartzilla' ); ?></th>
                <?php foreach( $products as $key => $product ) : ?>
                    <?php $product_id = $product->get_id(); ?>
                <td>
                    <span class="text-dark font-weight-medium text-dark"><?php echo esc_html( $product->fields['title'] ); ?></span>
                </td>
                <?php 
                    $fields_displayed[] = 'title';
                ?>
                <?php endforeach; ?>
            </tr>
            <?php endif; ?>

            <?php if( isset( $fields['price'] ) ) : ?>
            <tr>
                <th><?php echo esc_html__( 'Price', 'cartzilla' ); ?></th>
                <?php foreach( $products as $key => $product ) : ?>
                <td>
                    <div class="product-price price"><?php echo wp_kses_post( $product->fields['price'] ); ?></div>
                </td>
                <?php $fields_displayed[] = 'price'; ?>
                <?php endforeach; ?>
            </tr>
            <?php endif; ?>

            <?php if( isset( $fields['rating'] ) ) : ?>
            <tr>
                <th><?php echo esc_html__( 'Rating', 'cartzilla' ); ?></th>
                <?php foreach( $products as $key => $product ) : ?>
                <td>
                    <?php wc_get_template( 'loop/rating.php', array( 'product', $product ) ); ?>
                        
                </td>
                <?php endforeach; ?>
            </tr>
            <?php endif; ?>

            <?php if( isset( $fields['stock'] ) ) : ?>
            <tr>
                <th><?php echo esc_html__( 'Availability', 'cartzilla' ); ?></th>
                <?php foreach( $products as $key => $product ) : ?>
                <td><?php echo wp_kses_post( $product->fields['stock'] ); ?>
                <?php $fields_displayed[] = 'stock'; ?>
                <?php endforeach; ?>
            </tr>
            <?php endif; ?>

            <?php if( isset( $fields['description'] ) ) : ?>
            <tr>
                <th><?php echo esc_html__( 'Description', 'cartzilla' ); ?></th>
                <?php foreach( $products as $key => $product ) : ?>
                <td><?php echo wp_kses_post( $product->fields['description'] ); ?>
                <?php $fields_displayed[] = 'description'; ?>
                <?php endforeach; ?>
            </tr>
            <?php endif; ?>

            <?php foreach( $fields as $field => $name ) : ?>
                <?php if( ! in_array( $field, $fields_displayed ) ) : ?>
                <tr>
                    <th><?php echo wp_kses_post( $name ); ?></th>
                    <?php foreach( $products as $key => $product ) : ?>
                    <td>
                        <?php 
                            if( $field === 'add-to-cart' ) {
                                wc_get_template( 'loop/add-to-cart.php', array( 'product' => $product ) );
                            } else {
                                echo empty( $product->fields[$field] ) ? '&nbsp;' : $product->fields[$field];
                            }
                        ?>
                    </td>
                    <?php endforeach; ?>
                </tr>
                <?php endif; ?>
            <?php endforeach; ?>

            <?php if ( $repeat_price == 'yes' && isset( $fields['price'] ) ) : ?>
                <tr>
                    <th><?php echo esc_html__( 'Price', 'cartzilla' ); ?></th>
                    <?php foreach( $products as $key => $product ) : ?>
                    <td>
                        <div class="product-price price"><?php echo wp_kses_post( $product->fields['price'] ); ?></div>
                    </td>
                    <?php $fields_displayed[] = 'price'; ?>
                    <?php endforeach; ?>
                </tr>
            <?php endif; ?>

            <?php if ( $repeat_add_to_cart == 'yes' && isset( $fields['add-to-cart'] ) ) : ?>
                <tr class="add-to-cart repeated">
                    <th><?php echo wp_kses_post( $fields['add-to-cart'] ); ?></th>
                    <?php foreach( $products as $key => $product ) : ?>
                    <td><?php wc_get_template( 'loop/add-to-cart.php', array( 'product' => $product ) ); ?></td>
                    <?php endforeach; ?>
                </tr>
            <?php endif; ?>

        </tbody>
    </table>

</div><!-- /.table-responsive -->


<?php else : ?>

    <div class="compare-empty text-center py-5 mb-lg-3">
        <h1 class="h3 mb-4 mt-5 text-center cart-empty">
            <?php esc_html_e( 'No products were added to the compare table', 'cartzilla' ) ?>
        </h1>
        
        <p class="return-to-shop">
            <a class="btn btn-secondary" href="<?php echo apply_filters( 'woocommerce_return_to_shop_redirect', get_permalink( wc_get_page_id( 'shop' ) ) ); ?>">
                <i class="icon czi-store"></i>
                <?php esc_html_e( 'Return to shop', 'cartzilla' ) ?>
            </a>
        </p>
    </div>

<?php endif; ?>