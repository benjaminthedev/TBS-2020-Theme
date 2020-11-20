;(function ( $, window, document ) {
	'use strict';

	/**
	 * Check if cookies are enabled
	 *
	 * @return bool
	 */
	function is_cookie_enabled() {
		if (navigator.cookieEnabled) return true;

		// set and read cookie
		document.cookie = "cookietest=1";
		var ret = document.cookie.indexOf("cookietest=") != -1;

		// delete cookie
		document.cookie = "cookietest=1; expires=Thu, 01-Jan-1970 00:00:01 GMT";

		return ret;
	}

	$( document ).on( 'click', '[data-cz-wishlist="add"]', function ( e ) {
		e.preventDefault();
		$( document.body ).trigger( 'adding_to_wishlist' );

		let el = $( this );

		if ( !is_cookie_enabled() ) {
			alert( yith_wcwl_l10n.labels.cookie_disabled );
			return;
		}

		$.ajax({
			type: 'POST',
			url: yith_wcwl_l10n.ajax_url,
			dataType: 'json',
			data: {
				add_to_wishlist: el.data( 'product-id' ),
				product_type: el.data( 'product-type' ),
				action: yith_wcwl_l10n.actions.add_to_wishlist_action
			},
			beforeSend: function(){
				el.addClass( 'spinner-grow' );
				el.tooltip( 'dispose' );
			},
			complete: function(){
				el.removeClass( 'spinner-grow' );
			},
			success: function( response ) {
				if ( response.result == "true") {
					el.removeClass( 'visible' ).addClass( 'hidden' );
					let removeBtn = el.siblings( '[data-cz-wishlist="remove"]' );
					removeBtn.removeClass( 'hidden' ).addClass( 'visible' );
					removeBtn.tooltip();
				}

				$( document.body ).trigger( 'added_to_wishlist', [el] );
			}
		});
	} );

	$( document ).on( 'click', '[data-cz-wishlist="remove"]', function ( e ) {
		e.preventDefault();
		let el = $( this );

		$.ajax( {
			type: 'POST',
			url: yith_wcwl_l10n.ajax_url,
			dataType: 'json',
			data: {
				action: yith_wcwl_l10n.actions.remove_from_wishlist_action,
				remove_from_wishlist: el.data( 'product-id' ),
				wishlist_id: el.data( 'wishlist-id' ),
				wishlist_token: el.data( 'wishlist-token' )
			},
			beforeSend: function(){
				el.addClass( 'spinner-grow' );
				el.tooltip( 'dispose' );
			},
			complete: function( xhr, status ){
				el.removeClass( 'spinner-grow' );
				el.removeClass( 'visible' ).addClass( 'hidden' );

				let addBtn = el.siblings( '[data-cz-wishlist="add"]' );
				addBtn.removeClass( 'hidden' ).addClass( 'visible' );
				addBtn.tooltip();

				$( document.body ).trigger( 'removed_from_wishlist', [el] );
			}
		} );
	} );

})( jQuery, window, document );
