<?php
/**
 * Front Menu Walker Class.
 *
 * @package Armcodirect
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Armcodirect_Mega_Menu_Walker' ) ) {
	/**
	 * Define Mega menu walker.
	 */
	class Armcodirect_Mega_Menu_Walker extends Walker_Nav_Menu {
		/* Defaine plublic variable */
		public $get_first_level_menu_id = '';

		/**
		 * Starts the list before the elements are added.
		 */
		public function start_lvl( &$output, $depth = 0, $args = array() ) {
			if ( isset( $args->item_spacing ) && 'discard' === $args->item_spacing ) {
				$t = '';
				$n = '';
			} else {
				$t = "\t";
				$n = "\n";
			}
			$indent = str_repeat( $t, $depth );

			/**
			* Default class.
			*/
			$classes = array( 'sub-menu' );

			$armcodirect_get_first_level_status = get_post_meta( $this->get_first_level_menu_id, '_armcodirect_mega_menu_item_status', true );

			if ( 'enabled' === $armcodirect_get_first_level_status && 0 === $depth ) {
				$output .= '<div class="megamenu">';
			} elseif ( 'enabled' === $armcodirect_get_first_level_status && 1 === $depth ) {
				$classes[] = 'dropdown-menu';
			} else {
				$classes[] = 'dropdown-menu';
			}

			/**
			 * Filters the CSS class(es) applied to a menu list element.
			 */
			$class_names = join( ' ', apply_filters( 'nav_menu_submenu_css_class', $classes, $args, $depth ) );
			$class_names = $class_names ? ' class="' . esc_attr( $class_names ) . '"' : '';

			$output .= "{$n}{$indent}<ul $class_names>{$n}";
		}

		/**
		 * Ends the list of after the elements are added.
		 */
		public function end_lvl( &$output, $depth = 0, $args = array() ) {
			if ( isset( $args->item_spacing ) && 'discard' === $args->item_spacing ) {
				$t = '';
				$n = '';
			} else {
				$t = "\t";
				$n = "\n";
			}
			$indent = str_repeat( $t, $depth );
			$output .= "$indent</ul>{$n}";

			$armcodirect_get_first_level_status = get_post_meta( $this->get_first_level_menu_id, '_armcodirect_mega_menu_item_status', true );
			if ( 'enabled' === $armcodirect_get_first_level_status && 0 === $depth ) {
				$output .= '</div>';
			}

			if ( 0 === $depth ) {
				$this->get_first_level_menu_id = '';
			}
		}

		/**
		 * Starts the element output.
		 */
		public function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {

			if ( isset( $args->item_spacing ) && 'discard' === $args->item_spacing ) {
				$t = '';
				$n = '';
			} else {
				$t = "\t";
				$n = "\n";
			}
			$indent = ( $depth ) ? str_repeat( $t, $depth ) : '';

			$classes = empty( $item->classes ) ? array() : (array) $item->classes;
			$classes[] = 'menu-item-' . $item->ID;

			/**
			 * Add Simple Menu or Mega Menu Class
			 */
			$armcodirect_mega_menu_item_status  = get_post_meta( $item->ID, '_armcodirect_mega_menu_item_status', true );
			$armcodirect_mega_menu_item_sidebar = get_post_meta( $item->ID, '_armcodirect_mega_menu_item_sidebar', true );
			$armcodirect_get_first_level_status = get_post_meta( $this->get_first_level_menu_id, '_armcodirect_mega_menu_item_status', true );

			switch ( $depth ) {
				case '0':
					if ( $args->walker->has_children ) {
						$classes[] = 'dropdown';
					}
					if ( 'enabled' === $armcodirect_mega_menu_item_status ) {
						$classes[] = 'megamenu-fw';
					} else {
						$classes[] = 'simple-dropdown';
					}

					if ( 'enabled' === $armcodirect_mega_menu_item_status ) :
						$this->get_first_level_menu_id = $item->ID;
					endif;
					break;
				case '1':
					if ( $args->walker->has_children ) {
						$classes[] = 'dropdown';
					}

					break;
				default:
					if ( $args->walker->has_children ) {
						$classes[] = 'dropdown';
					}
					break;
			}
			if ( '0' !== $armcodirect_mega_menu_item_sidebar ) {
				$classes[] = 'armcodirect-menu-sidebar container';
			}

			/**
			 * Filters the arguments for a single nav menu item.
			 */
			$args = apply_filters( 'nav_menu_item_args', $args, $item, $depth );

			/**
			 * Filters the CSS class(es) applied to a menu item's list item element.
			 */
			$class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args, $depth ) );
			$class_names = $class_names ? ' class="' . esc_attr( $class_names ) . '"' : '';

			/**
			 * Filters the ID applied to a menu item's list item element.
			 */
			$id = apply_filters( 'nav_menu_item_id', 'menu-item-' . $item->ID, $item, $args, $depth );
			$id = $id ? ' id="' . esc_attr( $id ) . '"' : '';

			$output .= $indent . '<li' . $id . $class_names . '>';

			$atts = array();
			$atts['title']  = ! empty( $item->attr_title ) ? $item->attr_title : '';
			$atts['rel']    = ! empty( $item->xfn ) ? $item->xfn : '';
			$atts['target'] = ! empty( $item->target ) ? $item->target : '';
			$atts['href']   = ! empty( $item->url ) ? $item->url : 'javascript:void(0);';

			if ( 'enabled' === $armcodirect_get_first_level_status && ( 1 === $depth || 2 === $depth ) ) {
				$atts['class'] = 'dropdown-header';
			}

			if ( 'enabled' !== $armcodirect_mega_menu_item_status ) {
				$atts['class'] = 'inner-link';
			}

			/**
			 * Filters the HTML attributes applied to a menu item's anchor element.
			 */
			$atts = apply_filters( 'nav_menu_link_attributes', $atts, $item, $args, $depth );

			$attributes = '';
			foreach ( $atts as $attr => $value ) {
				if ( ! empty( $value ) ) {
					$value = ( 'href' === $attr ) ? esc_url( $value ) : esc_attr( $value );
					$attributes .= ' ' . $attr . '="' . $value . '"';
				}
			}

			/** This filter is documented in wp-includes/post-template.php */
			$title = apply_filters( 'the_title', $item->title, $item->ID );

			/**
			 * Filters a menu item's title.
			 */
			$title = apply_filters( 'nav_menu_item_title', $title, $item, $args, $depth );

			$item_output = $args->before;

			// Sidebar Menu.
			if ( '0' !== $armcodirect_mega_menu_item_sidebar && 'enabled' === $armcodirect_get_first_level_status && is_active_sidebar( $armcodirect_mega_menu_item_sidebar ) ) {
				ob_start();
				dynamic_sidebar( $armcodirect_mega_menu_item_sidebar );
				$mega_menu_item_sidebar_result = ob_get_contents();
				$item_output .= apply_filters( 'armcodirect_mega_menu_item_sidebar_result', $mega_menu_item_sidebar_result );
				ob_end_clean();
			} else {
				$item_output .= '<a' . $attributes . ' itemprop="url">';
				$item_output .= $args->link_before . $title . $args->link_after;
				if ( ( 1 === $depth || 2 === $depth ) && 'enabled' !== $armcodirect_get_first_level_status && $args->walker->has_children ) {
					$item_output .= '<i class="fas fa-angle-right"></i>';
				}

				$item_output .= '</a>';
			}

			$item_output .= $args->after;

			/**
			 * Filters a menu item's starting output.
			 */
			$output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );

			/* Add mobile icon for parent item */

			if ( $args->walker->has_children && 0 === $depth ) {
				$output .= '<span class="mobile-dropdown-toggle"></span>';
			}
		}

		/**
		 * Ends the element output, if needed.
		 */
		public function end_el( &$output, $item, $depth = 0, $args = array() ) {
			if ( 0 === $depth ) {
				$this->get_first_level_menu_id = '';
			}
			if ( isset( $args->item_spacing ) && 'discard' === $args->item_spacing ) {
				$t = '';
				$n = '';
			} else {
				$t = "\t";
				$n = "\n";
			}
			$output .= "</li>{$n}";
		}

	} // Walker_Nav_Menu
}
