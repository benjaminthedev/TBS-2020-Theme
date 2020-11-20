;(function ( $, window, document ) {
	'use strict';

	$( document ).ready( function () {
		$( '#menu-to-edit .menu-item' ).bind( 'click', function ( e ) {
			// Init the Nav Menu object and pass the data from wp_localize_scripts()
			const cartzillaNavMenu = new CartzillaNavMenu( cartzillaNavMenuLocalized );

			// Handle current click
			let $menuItem = $( e.currentTarget );

			if ( !$menuItem.hasClass( 'mega-menu-already-modified' )
			     && $menuItem.hasClass( 'menu-item-edit-inactive' )
			     && cartzillaNavMenu.isTopLevelMenuItem( $menuItem )
			) {
				let menuItem = {};

				menuItem.Id = cartzillaNavMenu.getId( $menuItem );
				menuItem.element = $menuItem;
				menuItem.container = menuItem.element.find( '.menu-item-settings' );

				cartzillaNavMenu.renderFields( menuItem );

				// Mark element to prevent duplicate modifications
				$menuItem.addClass( 'mega-menu-already-modified' );
			}

			return true;
		} );
	} );

	function CartzillaNavMenu( data ) {
		this.data = data
	}

	CartzillaNavMenu.prototype.data = undefined;

	CartzillaNavMenu.prototype.isTopLevelMenuItem = function ( $menuItem ) {
		let parentId = parseInt( $menuItem.find( 'input.menu-item-data-parent-id' ).val(), 10 );

		return parentId === 0;
	};

	CartzillaNavMenu.prototype.renderFields = function( menuItem ) {
		const self = this;

		$.each( self.data.fields, function ( i, field ) {
			if ( field.type === 'select' ) {
				self.addSelectField( field, menuItem.container, menuItem.Id );
			} else {
				$( document ).trigger( 'render-mega-menu-field.cartzilla', [field, menuItem] );
			}
		} );
	};

	CartzillaNavMenu.prototype.addSelectField = function( field, $container, itemId ) {
		let $select = $( '<select />', {
			id: this.getFieldId( field.name, itemId ),
			name: field.name + '[' + itemId + ']',
			'class': 'widefat code'
		} );

		if ( field.hasOwnProperty( 'options' ) ) {
			$.each( field.options, function ( val, label ) {
				console.log( ['create options', val, label, field, itemId] );
				if ( field.hasOwnProperty( 'values' )
				     && field.values.hasOwnProperty( itemId )
				     && field.values[itemId] === val
				) {
					$select.append( new Option( label, val, true, true ) );
				} else {
					$select.append( new Option( label, val ) );
				}
			} );
		}

		this.addField( field, $container, itemId, $select );
	};

	CartzillaNavMenu.prototype.addField = function ( field, $container, itemID, $field ) {
		var self = this;

		// Wrap field into the <p> with <label> and add right above the .field-move
		var $p = $( '<p/>', {'class': 'description description-wide'} );

		// Create a label
		if ( field.hasOwnProperty( 'title' ) && field.title !== '' ) {
			var $label = $( '<label/>', {'for': self.getFieldId( field.name, itemID )} );
			$label.text( field.title );
			$label.append( document.createElement( 'br' ) );
			$p.append( $label );
		}

		$p.append( $field );

		// Add a description
		if ( field.hasOwnProperty( 'description' ) && field.description !== '' ) {
			var $descr = $( '<div/>', {'text': field.description} );
			$p.append( $descr );
		}

		var selector = $container.find( '.field-move' );
		$p.insertBefore( selector );
	};

	CartzillaNavMenu.prototype.getFieldId = function ( name, ID ) {
		return 'edit-' + name + '-' + ID;
	};

	CartzillaNavMenu.prototype.getId = function ( $el ) {
		return parseInt( $el.attr( 'id' ).replace( /[^\d]/g, '' ), 10 );
	};

})( jQuery, window, document );
