<?php
/**
 * Show options for ordering
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/loop/orderby.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	    https://docs.woocommerce.com/document/template-structure/
 * @package 	WooCommerce/Templates
 * @version     3.6.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

?>
<form class="woocommerce-ordering form-inline flex-nowrap" method="get">
	<?php if ( cartzilla_get_shop_page_style() === 'style-v3' ) { ?>
		<label class="d-none d-sm-block py-2 font-size-sm text-muted text-nowrap mr-2"><?php echo apply_filters( 'cartzilla_woocommerce-ordering_label', esc_html__( 'Sort by:', 'cartzilla' ) ); ?></label>
			<ul class="nav nav-tabs font-size-sm mb-0">
				<?php foreach ( $catalog_orderby_options as $id => $name ) :
				    echo '<li><a class="nav-link' . esc_attr( $orderby == $id  ? ' active': '' ). '" href="' . get_permalink( wc_get_page_id ( 'shop' ) ) . '?orderby=' . $id . '" >' . esc_attr( $name ) . '</a></li>';
				endforeach; ?>
		    </ul>

	<?php } elseif ( cartzilla_get_shop_page_style() === 'style-v2' ) { 
		$icons = array(
			'date'       => 'czi-flag' ,
			'popularity' => 'czi-rocket',
			'rating'     => 'czi-thumb-up',
			'price'      => 'czi-arrow-down',
			'price-desc' => 'czi-arrow-up',
			'relevance'	 => 'czi-idea',
		); ?>

		<div class="dropdown py-4 border-left">
			<a class="nav-link-style font-size-md font-weight-medium dropdown-toggle p-4" href="#" data-toggle="dropdown" aria-expanded="true">
				<span class="d-inline-block py-1"><i class="<?php echo esc_html($icons[$orderby]);?> align-middle opacity-60 mt-n1 mr-2"></i><?php echo esc_html($catalog_orderby_options[$orderby]); ?></span>
			</a>

			<ul class="dropdown-menu dropdown-menu-right">
				<?php unset($catalog_orderby_options[$orderby]); ?>
				<?php foreach ( $catalog_orderby_options as $id => $name ) :
				    echo '<li><a class="dropdown-item" href="' . get_permalink( wc_get_page_id ( 'shop' ) ) . '?orderby=' . $id . '" ><i class="' . esc_html($icons[$id]) . ' mr-2 opacity-60"></i>' . esc_attr( $name ) . '</a></li>';
				endforeach; ?>
		    </ul>
		</div>

	<?php } else { ?>
		<label class="<?php echo cartzilla_wc_catalog_type() ===  'dark'  ? 'text-light' : 'text-dark'; ?> opacity-75 text-nowrap mr-2 d-none d-sm-block" for="orderby"><?php echo apply_filters( 'cartzilla_woocommerce-ordering_label', esc_html__( 'Sort by:', 'cartzilla' ) ); ?></label>

		<select name="orderby" class="orderby form-control custom-select" aria-label="<?php esc_attr_e( 'Shop order', 'cartzilla' ); ?>" id="orderby">
			<?php foreach ( $catalog_orderby_options as $id => $name ) : ?>
				<option value="<?php echo esc_attr( $id ); ?>" <?php selected( $orderby, $id ); ?>><?php echo esc_html( $name ); ?></option>
			<?php endforeach; ?>
		</select>

		<input type="hidden" name="paged" value="1" />
		<?php wc_query_string_form_fields( null, array( 'orderby', 'submit', 'paged', 'product-page' ) ); ?>
		
		<span class="font-size-sm text-light opacity-75 text-nowrap ml-2 d-none d-md-block"><?php
			$total = wc_get_loop_prop( 'total' );
			/* translators: 1: total results; number of products */
			echo esc_html( sprintf( _nx( 'of %d product', 'of %d products', $total, 'front-end', 'cartzilla' ), $total ) ); ?>
		</span>
	<?php } ?>
	
</form>
