;( function ( $, window, document ) {
	'use strict';

/**
 * Lightbox component for presenting various types of media
 * https://github.com/sachinchoolur/lightgallery.js
 */
let gallery = document.querySelectorAll( '.cz-gallery' );
	if ( gallery.length ) {
		for ( let i = 0; i < gallery.length; i++ ) {
			lightGallery( gallery[i], {
				selector: '.gallery-item',
				subHtmlSelectorRelative: true,
				download: false,
				videojs: true,
				youtubePlayerParams: {
					modestbranding: 1,
					showinfo: 0,
					rel: 0,
					controls: 0
				},
				vimeoPlayerParams: {
					byline: 0,
					portrait: 0,
					color: 'fe696a'
				}
			} );
		}
	}

	/**
	 * Cascading (Masonry) grid layout
	 * https://github.com/desandro/imagesloaded
	 * https://github.com/desandro/masonry
	 */
	function masonryGrid() {

		let grid = document.querySelectorAll('.cz-masonry-grid'),
				masonry;
	
		if (grid == null) return;
		
		console.log(grid);
	
		imagesLoaded(document.querySelector('body'), function() {
			for (let i = 0; i < grid.length; i++) {
				masonry = new Masonry(grid[i], {
					itemSelector: '.grid-item',
				});
			}
		});
	}

} )( jQuery, window, document );
