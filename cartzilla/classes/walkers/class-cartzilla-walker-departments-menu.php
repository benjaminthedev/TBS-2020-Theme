<?php

/**
 * Walker class for "Departments" menu
 *
 * @package Cartzilla
 */
class Cartzilla_Departments_Menu_Walker extends Walker_Nav_Menu {
	/**
	 * Starts the list before the elements are added.
	 *
	 * @since 3.0.0
	 *
	 * @see Walker::start_lvl()
	 *
	 * @param string   $output Used to append additional content (passed by reference).
	 * @param int      $depth  Depth of menu item. Used for padding.
	 * @param stdClass $args   An object of wp_nav_menu() arguments.
	 */
	public function start_lvl( &$output, $depth = 0, $args = null ) {
		if ( isset( $args->item_spacing ) && 'discard' === $args->item_spacing ) {
			$t = '';
			$n = '';
		} else {
			$t = "\t";
			$n = "\n";
		}
		$indent = str_repeat( $t, $depth );

		// Default class.
		$classes = [ 'sub-menu' ];

		// (Cartzilla) extra classes for top-level menu items
		if ( $depth === 0 ) {
			$classes[] = 'dropdown-menu';
		}

		if ( $depth === 1 ) {
			$classes[] = 'widget-list';
		}

		/**
		 * Filters the CSS class(es) applied to a menu list element.
		 *
		 * @since 4.8.0
		 *
		 * @param string[] $classes Array of the CSS classes that are applied to the menu `<ul>` element.
		 * @param stdClass $args    An object of `wp_nav_menu()` arguments.
		 * @param int      $depth   Depth of menu item. Used for padding.
		 */
		$class_names = join( ' ', apply_filters( 'nav_menu_submenu_css_class', $classes, $args, $depth ) );
		$class_names = $class_names ? ' class="' . esc_attr( $class_names ) . '"' : '';

		$output .= "{$n}{$indent}<ul$class_names>{$n}";
	}

	/**
	 * Ends the list of after the elements are added.
	 *
	 * @since 3.0.0
	 *
	 * @see Walker::end_lvl()
	 *
	 * @param string   $output Used to append additional content (passed by reference).
	 * @param int      $depth  Depth of menu item. Used for padding.
	 * @param stdClass $args   An object of wp_nav_menu() arguments.
	 */
	public function end_lvl( &$output, $depth = 0, $args = null ) {
		if ( isset( $args->item_spacing ) && 'discard' === $args->item_spacing ) {
			$t = '';
			$n = '';
		} else {
			$t = "\t";
			$n = "\n";
		}
		$indent  = str_repeat( $t, $depth );
		$output .= "$indent</ul>{$n}";
	}

	/**
	 * Starts the element output.
	 *
	 * @since 3.0.0
	 * @since 4.4.0 The {@see 'nav_menu_item_args'} filter was added.
	 *
	 * @see Walker::start_el()
	 *
	 * @param string   $output Used to append additional content (passed by reference).
	 * @param WP_Post  $item   Menu item data object.
	 * @param int      $depth  Depth of menu item. Used for padding.
	 * @param stdClass $args   An object of wp_nav_menu() arguments.
	 * @param int      $id     Current item ID.
	 */
	public function start_el( &$output, $item, $depth = 0, $args = null, $id = 0 ) {
		if ( isset( $args->item_spacing ) && 'discard' === $args->item_spacing ) {
			$t = '';
			$n = '';
		} else {
			$t = "\t";
			$n = "\n";
		}
		$indent = ( $depth ) ? str_repeat( $t, $depth ) : '';

		$classes = empty( $item->classes ) ? array() : (array) $item->classes;

        /*
         * Initialize some holder variables to store specially handled item
         * wrappers and icons.
         */
        $linkmod_classes = array();
        $icon_classes    = array();

        /*
         * Get an updated $classes array without linkmod or icon classes.
         *
         * NOTE: linkmod and icon class arrays are passed by reference and
         * are maybe modified before being used later in this function.
         */
        $classes = self::separate_linkmods_and_icons_from_classes( $classes, $linkmod_classes, $icon_classes, $depth );

        // Join any icon classes plucked from $classes into a string.
        $icon_class_string = join( ' ', $icon_classes );

		$classes[] = 'menu-item-' . $item->ID;

		/*
		 * (Cartzilla)
		 * Add extra classes for top-level menu items
		 */
		if ( $depth === 0 ) {
			$classes[] = 'dropdown';
			$classes[] = 'mega-dropdown';
		}

		/*
		 * (Cartzilla)
		 * Add extra classes for direct descendants of top-level menu items
		 */
		if ( $depth === 1 ) {
			$classes[] = 'mega-dropdown-column';
			$classes[] = 'py-4';
			$classes[] = 'px-3';
		}

		/**
		 * Filters the arguments for a single nav menu item.
		 *
		 * @since 4.4.0
		 *
		 * @param stdClass $args  An object of wp_nav_menu() arguments.
		 * @param WP_Post  $item  Menu item data object.
		 * @param int      $depth Depth of menu item. Used for padding.
		 */
		$args = apply_filters( 'nav_menu_item_args', $args, $item, $depth );

		/**
		 * Filters the CSS classes applied to a menu item's list item element.
		 *
		 * @since 3.0.0
		 * @since 4.1.0 The `$depth` parameter was added.
		 *
		 * @param string[] $classes Array of the CSS classes that are applied to the menu item's `<li>` element.
		 * @param WP_Post  $item    The current menu item.
		 * @param stdClass $args    An object of wp_nav_menu() arguments.
		 * @param int      $depth   Depth of menu item. Used for padding.
		 */
		$class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args, $depth ) );
		$class_names = $class_names ? ' class="' . esc_attr( $class_names ) . '"' : '';

		/**
		 * Filters the ID applied to a menu item's list item element.
		 *
		 * @since 3.0.1
		 * @since 4.1.0 The `$depth` parameter was added.
		 *
		 * @param string   $menu_id The ID that is applied to the menu item's `<li>` element.
		 * @param WP_Post  $item    The current menu item.
		 * @param stdClass $args    An object of wp_nav_menu() arguments.
		 * @param int      $depth   Depth of menu item. Used for padding.
		 */
		$id = apply_filters( 'nav_menu_item_id', 'menu-item-' . $item->ID, $item, $args, $depth );
		$id = $id ? ' id="' . esc_attr( $id ) . '"' : '';

		$output .= $indent . '<li' . $id . $class_names . '>';

		if( $depth > 0 && 'mas_static_content' == $item->object ) {
			$classes = empty( $item->classes ) ? array() : (array) $item->classes;
			$classes = apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args, $depth );
			$class_names = join( ' ', $classes );
			$class_names = $class_names ? esc_attr( $class_names ) : '';
			$item_output = do_shortcode( '[mas_static_content id=' . $item->object_id . ' class="' . $class_names . '"]' );
		} else {
			$atts           = array();
			$atts['title']  = ! empty( $item->attr_title ) ? $item->attr_title : '';
			$atts['target'] = ! empty( $item->target ) ? $item->target : '';
			if ( '_blank' === $item->target && empty( $item->xfn ) ) {
				$atts['rel'] = 'noopener noreferrer';
			} else {
				$atts['rel'] = $item->xfn;
			}
			$atts['href']         = ! empty( $item->url ) ? $item->url : '';
			$atts['aria-current'] = $item->current ? 'page' : '';

			/**
			 * Filters the HTML attributes applied to a menu item's anchor element.
			 *
			 * @since 3.6.0
			 * @since 4.1.0 The `$depth` parameter was added.
			 *
			 * @param array $atts {
			 *     The HTML attributes applied to the menu item's `<a>` element, empty strings are ignored.
			 *
			 *     @type string $title        Title attribute.
			 *     @type string $target       Target attribute.
			 *     @type string $rel          The rel attribute.
			 *     @type string $href         The href attribute.
			 *     @type string $aria_current The aria-current attribute.
			 * }
			 * @param WP_Post  $item  The current menu item.
			 * @param stdClass $args  An object of wp_nav_menu() arguments.
			 * @param int      $depth Depth of menu item. Used for padding.
			 */
			$atts = apply_filters( 'nav_menu_link_attributes', $atts, $item, $args, $depth );

			$attributes = '';
			foreach ( $atts as $attr => $value ) {
				if ( is_scalar( $value ) && '' !== $value && false !== $value ) {
					$value       = ( 'href' === $attr ) ? esc_url( $value ) : esc_attr( $value );
					$attributes .= ' ' . $attr . '="' . $value . '"';
				}
			}

			/*
             * Initiate empty icon var, then if we have a string containing any
             * icon classes form the icon markup with an <i> element. This is
             * output inside of the item before the $title (the link text).
             */
            $icon_html = '';
            if ( ! empty( $icon_class_string ) ) {
                if ( isset( $args->icon_class ) ) {
                    $icon_class_string .= ' ' . $args->icon_class;
                }
                // Append an <i> with the icon classes to what is output before links.
                $icon_html = '<i class="' . esc_attr( $icon_class_string ) . '" aria-hidden="true"></i> ';
            }

			/** This filter is documented in wp-includes/post-template.php */
			$title = apply_filters( 'the_title', $item->title, $item->ID );

			/**
			 * Filters a menu item's title.
			 *
			 * @since 4.4.0
			 *
			 * @param string   $title The menu item's title.
			 * @param WP_Post  $item  The current menu item.
			 * @param stdClass $args  An object of wp_nav_menu() arguments.
			 * @param int      $depth Depth of menu item. Used for padding.
			 */
			$title = apply_filters( 'nav_menu_item_title', $title, $item, $args, $depth );

			$item_output  = $args->before;
			$item_output .= '<a' . $attributes . '>';

			/*
			 * (Cartzilla)
			 * Add icon only for top-level menu items and if user specify something in Description field
			 */
			if ( $depth === 0 && ! empty( $item->icon ) ) {
				$item_output .= '<i class="' . esc_attr( cartzilla_get_classes( $item->icon ) ) . '"></i>';
			}

			$item_output .= $args->link_before . $icon_html . $title . $args->link_after;
			$item_output .= '</a>';
			$item_output .= $args->after;

			/*
			 * (Cartzilla)
			 * Wrap top-level menu items with children into container
			 */
			if ( $depth === 0 && $this->has_children ) {
				$item_output .= '<div class="mega-menu-container">';
			}

			/*
			 * (Cartzilla)
			 * Display image for product categories
			 */
			if ( $depth === 0
				 // Make sure that subcategories exists
				 && $this->has_children
				 // Make sure current menu item is a part of the "product_cat" taxonomy
				 && ( ! empty( $item->object ) && $item->object === 'product_cat' && ! empty( $item->object_id ) )
				 // Allow users to hide image
				 && false !== (bool) apply_filters( 'cartzilla_departments_menu_show_category_thumbnail', true )
			) {
				$category = get_term( (int) $item->object_id, 'product_cat' );
				if ( $category instanceof WP_Term ) {
					$thumbnail_id = get_term_meta( $category->term_id, 'thumbnail_id', true );
					// Make sure thumbnail_id is set for current category
					if ( $thumbnail_id ) {
						$small_thumbnail_size = 'woocommerce_thumbnail';
						$dimensions           = wc_get_image_size( $small_thumbnail_size );
						$image                = wp_get_attachment_image_src( $thumbnail_id, $small_thumbnail_size );
						$image                = $image[0];
						$image_srcset         = function_exists( 'wp_get_attachment_image_srcset' ) ? wp_get_attachment_image_srcset( $thumbnail_id, $small_thumbnail_size ) : false;
						$image_sizes          = function_exists( 'wp_get_attachment_image_sizes' ) ? wp_get_attachment_image_sizes( $thumbnail_id, $small_thumbnail_size ) : false;

						if ( $image ) {
							// Prevent esc_url from breaking spaces in urls for image embeds.
							// Ref: https://core.trac.wordpress.org/ticket/23605.
							$image = str_replace( ' ', '%20', $image );

							ob_start();
							?>
							<div class="menu-item-image text-center">
								<a href="<?php echo esc_url( get_term_link( $category ) ); ?>" class="d-block mb-2">
									<?php if ( $image_srcset && $image_sizes ) : ?>
										<?php echo '<img class="d-block w-100 rounded" src="' . esc_url( $image ) . '" alt="' . esc_attr( $category->name ) . '" width="' . esc_attr( $dimensions['width'] ) . '" height="' . esc_attr( $dimensions['height'] ) . '" srcset="' . esc_attr( $image_srcset ) . '" sizes="' . esc_attr( $image_sizes ) . '" />'; ?>
									<?php else : ?>
										<?php echo '<img src="' . esc_url( $image ) . '" alt="' . esc_attr( $category->name ) . '" width="' . esc_attr( $dimensions['width'] ) . '" height="' . esc_attr( $dimensions['height'] ) . '" />'; ?>
									<?php endif; ?>
								</a>
								<?php if ( ! empty( $category->description ) ) : ?>
									<div class="font-size-ms mb-3"><?php echo wp_kses_post( $category->description ); ?></div>
								<?php endif; ?>
								<a href="<?php echo esc_url( get_term_link( $category ) ); ?>" class="btn btn-primary btn-shadow btn-sm">
									<?php echo esc_html_x( 'Browse products', 'front-end', 'cartzilla' ); ?><i class="czi-arrow-right font-size-xs ml-1 mr-n1"></i>
								</a>
							</div>
							<?php
							$item_output .= ob_get_clean();
						}
					}
				}
			}

		}

		/**
		 * Filters a menu item's starting output.
		 *
		 * The menu item's starting output only includes `$args->before`, the opening `<a>`,
		 * the menu item's title, the closing `</a>`, and `$args->after`. Currently, there is
		 * no filter for modifying the opening and closing `<li>` for a menu item.
		 *
		 * @since 3.0.0
		 *
		 * @param string   $item_output The menu item's starting HTML output.
		 * @param WP_Post  $item        Menu item data object.
		 * @param int      $depth       Depth of menu item. Used for padding.
		 * @param stdClass $args        An object of wp_nav_menu() arguments.
		 */
		$output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
	}

	/**
	 * Find any custom linkmod or icon classes and store in their holder
	 * arrays then remove them from the main classes array.
	 *
	 * Supported linkmods: .disabled, .dropdown-header, .dropdown-divider, .sr-only
	 * Supported iconsets: Font Awesome 4/5, Glypicons
	 *
	 * NOTE: This accepts the linkmod and icon arrays by reference.
	 *
	 * @since 4.0.0
	 *
	 * @param array   $classes         an array of classes currently assigned to the item.
	 * @param array   $linkmod_classes an array to hold linkmod classes.
	 * @param array   $icon_classes    an array to hold icon classes.
	 * @param integer $depth           an integer holding current depth level.
	 *
	 * @return array  $classes         a maybe modified array of classnames.
	 */
	private function separate_linkmods_and_icons_from_classes( $classes, &$linkmod_classes, &$icon_classes, $depth ) {
		// Loop through $classes array to find linkmod or icon classes.
		foreach ( $classes as $key => $class ) {
			/*
			 * If any special classes are found, store the class in it's
			 * holder array and and unset the item from $classes.
			 */
			if ( preg_match( '/^disabled|^sr-only/i', $class ) ) {
				// Test for .disabled or .sr-only classes.
				$linkmod_classes[] = $class;
				unset( $classes[ $key ] );
			} elseif ( preg_match( '/^dropdown-header|^dropdown-divider|^dropdown-item-text/i', $class ) && $depth > 0 ) {
				/*
				 * Test for .dropdown-header or .dropdown-divider and a
				 * depth greater than 0 - IE inside a dropdown.
				 */
				$linkmod_classes[] = $class;
				unset( $classes[ $key ] );
			} elseif ( preg_match( '/^fa-(\S*)?|^fa(s|r|l|b)?(\s?)?$/i', $class ) ) {
				// Font Awesome.
				$icon_classes[] = $class;
				unset( $classes[ $key ] );
			} elseif ( preg_match( '/^glyphicon-(\S*)?|^glyphicon(\s?)$/i', $class ) ) {
				// Glyphicons.
				$icon_classes[] = $class;
				unset( $classes[ $key ] );
			} elseif ( preg_match( '/^czi-(\S*)?|^czi(\s?)$/i', $class ) ) {
				// Cartzilla.
				$icon_classes[] = $class;
				unset( $classes[ $key ] );
			}
		}

		return $classes;
	}

	/**
	 * Ends the element output, if needed.
	 *
	 * @since 3.0.0
	 *
	 * @see Walker::end_el()
	 *
	 * @param string   $output Used to append additional content (passed by reference).
	 * @param WP_Post  $item   Page data object. Not used.
	 * @param int      $depth  Depth of page. Not Used.
	 * @param stdClass $args   An object of wp_nav_menu() arguments.
	 */
	public function end_el( &$output, $item, $depth = 0, $args = null ) {
		if ( isset( $args->item_spacing ) && 'discard' === $args->item_spacing ) {
			$t = '';
			$n = '';
		} else {
			$t = "\t";
			$n = "\n";
		}

		/*
		 * (Cartzilla)
		 * Close div.mega-menu-container
		 */
		if ( $depth === 0 && ( 'mas_static_content' != $item->object ) && ( ! empty( $item->classes ) && is_array( $item->classes ) && in_array( 'menu-item-has-children', $item->classes ) ) ) {
			$output .= '</div>';
		}

		$output .= "</li>{$n}";
	}
}