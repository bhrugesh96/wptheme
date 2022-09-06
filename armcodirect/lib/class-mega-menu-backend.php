<?php
/**
 * Mega menu backend options
 *
 * @package  * @package

 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if ( ! function_exists( 'armcodirect_nav_option_update' ) ) :
	/**
	 * Update Options in database.
	 *
	 * @param string $menu_id         Get Menu ID.
	 * @param string $menu_item_db_id Get menu item ID.
	 * @param array  $args            Menu args.
	 */
	function armcodirect_nav_option_update( $menu_id, $menu_item_db_id, $args ) {

		if ( ! isset( $_REQUEST['menu-item-armcodirect-mega-menu-item-status'][ $menu_item_db_id ] ) ) {// phpcs:ignore
			$_REQUEST['menu-item-armcodirect-mega-menu-item-status'][ $menu_item_db_id ] = '';
		}
		$armcodirect_mega_menu_item_status = $_REQUEST['menu-item-armcodirect-mega-menu-item-status'][ $menu_item_db_id ];// phpcs:ignore
		update_post_meta( $menu_item_db_id, '_armcodirect_mega_menu_item_status', $armcodirect_mega_menu_item_status );

		if ( ! isset( $_REQUEST['menu-item-armcodirect-mega-menu-item-sidebar'][ $menu_item_db_id ] ) ) {// phpcs:ignore
			$_REQUEST['menu-item-armcodirect-mega-menu-item-sidebar'][ $menu_item_db_id ] = '';
		}
		$armcodirect_mega_menu_item_sidebar = $_REQUEST['menu-item-armcodirect-mega-menu-item-sidebar'][ $menu_item_db_id ];// phpcs:ignore
		update_post_meta( $menu_item_db_id, '_armcodirect_mega_menu_item_sidebar', $armcodirect_mega_menu_item_sidebar );
	}
endif;
add_action( 'wp_update_nav_menu_item', 'armcodirect_nav_option_update', 10, 3 );

if ( ! function_exists( 'armcodirect_get_nav_custom_post_meta' ) ) {
	/**
	 * Adds value of new field to $item object that will be passed to Walker_Nav_Menu_Edit_Custom.
	 *
	 * @param object $menu_item Menu Item ID.
	 */
	function armcodirect_get_nav_custom_post_meta( $menu_item ) {

		$menu_item->armcodirect_mega_menu_item_status  = get_post_meta( $menu_item->ID, '_armcodirect_mega_menu_item_status', true );
		$menu_item->armcodirect_mega_menu_item_sidebar = get_post_meta( $menu_item->ID, '_armcodirect_mega_menu_item_sidebar', true );
		return $menu_item;
	}
}
add_filter( 'wp_setup_nav_menu_item', 'armcodirect_get_nav_custom_post_meta' );

if ( ! function_exists( 'armcodirect_custom_nav_edit_walker' ) ) :
	/**
	 * Filter For Edit Walker_Nav_Menu_Edit_Custom Walker.
	 */
	function armcodirect_custom_nav_edit_walker() {
		return 'Armcodirect_Walker_Nav_Menu_Edit_Custom';
	}
endif;
add_filter( 'wp_edit_nav_menu_walker', 'armcodirect_custom_nav_edit_walker' );

/**
 * Navigation Menu API: Walker_Nav_Menu_Edit class.
 */
if ( ! class_exists( 'Armcodirect_Walker_Nav_Menu_Edit_Custom' ) ) {
	/**
	 * Define Mega Menu Edit Walker Class.
	 */
	class Armcodirect_Walker_Nav_Menu_Edit_Custom extends Walker_Nav_Menu {

		/**
		 * Starts the list before the elements are added.
		 */
		public function start_lvl( &$output, $depth = 0, $args = array() ) {}

		/**
		 * Ends the list of after the elements are added.
		 */
		public function end_lvl( &$output, $depth = 0, $args = array() ) {}

		/**
		 * Start the element output.
		 */
		public function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {

			global $_wp_nav_menu_max_depth;
			$_wp_nav_menu_max_depth = $depth > $_wp_nav_menu_max_depth ? $depth : $_wp_nav_menu_max_depth;// phpcs:ignore

			ob_start();
			$item_id = esc_attr( $item->ID );
			$removed_args = array(
				'action',
				'customlink-tab',
				'edit-menu-item',
				'menu-item',
				'page-tab',
				'_wpnonce',
			);

			$original_title = false;
			if ( 'taxonomy' === $item->type ) {
				$original_title = get_term_field( 'name', $item->object_id, $item->object, 'raw' );
				if ( is_wp_error( $original_title ) ) {
					$original_title = false;
				}
			} elseif ( 'post_type' === $item->type ) {
				$original_object = get_post( $item->object_id );
				$original_title  = get_the_title( $original_object->ID );
			} elseif ( 'post_type_archive' === $item->type ) {
				$original_object = get_post_type_object( $item->object );
				if ( $original_object ) {
					$original_title = $original_object->labels->archives;
				}
			}

			$classes = array(
				'menu-item menu-item-depth-' . $depth,
				'menu-item-' . esc_attr( $item->object ),
				'menu-item-edit-' . ( ( isset( $_GET['edit-menu-item'] ) && $item_id == $_GET['edit-menu-item'] ) ? 'active' : 'inactive' ),// phpcs:ignore
			);

			$title = $item->title;

			if ( ! empty( $item->_invalid ) ) {
				$classes[] = 'menu-item-invalid';
				/* translators: %s: title of menu item which is invalid */
				$title = esc_html( $item->title ) . esc_html__( ' (Invalid) ', 'armcodirect' );
			} elseif ( isset( $item->post_status ) && 'draft' === $item->post_status ) {
				$classes[] = 'pending';
				/* translators: %s: title of menu item in draft status */
				$title = esc_html( $item->title ) . esc_html__( ' (Pending) ', 'armcodirect' );
			}

			$title = ( ! isset( $item->label ) || '' === $item->label ) ? $title : $item->label;

			$submenu_text = '';
			if ( 0 === $depth ) {
				$submenu_text = 'style="display: none;"';
			}
			?>
			<style type="text/css">
				.field-armcodirect-mega-menu-item-status,
				.field-armcodirect-mega-menu-item-sidebar{ display: none; }
				.menu-item-depth-0 .field-armcodirect-mega-menu-item-status { display: block;}
				.menu-item-depth-0 .field-megamenu-status { display: block;}

				.menu-item-depth-1.armcodirect-megamenu-active .field-armcodirect-mega-menu-item-sidebar,
				.menu-item-depth-2.armcodirect-megamenu-active .field-armcodirect-mega-menu-item-sidebar { display: block; }
				.menu-item-depth-1 .field-armcodirect-mega-menu-item-status, .menu-item-depth-2 .field-armcodirect-mega-menu-item-status { display: none;}
			</style>
			<li id="menu-item-<?php echo esc_attr( $item_id ); ?>" class="<?php echo implode( ' ', $classes );// phpcs:ignore ?>">
				<div class="menu-item-bar">
					<div class="menu-item-handle">
						<label class="item-title" for="menu-item-checkbox-<?php echo $item_id;// phpcs:ignore ?>">
							<input id="menu-item-checkbox-<?php echo $item_id; ?>" type="checkbox" class="menu-item-checkbox" data-menu-item-id="<?php echo $item_id; // phpcs:ignore ?>" disabled="disabled" />
							<span class="menu-item-title"><?php echo esc_html( $title ); ?></span>
							<span class="is-submenu" <?php echo $submenu_text;// phpcs:ignore  ?>><?php echo esc_html__( 'sub item', 'armcodirect' ); ?></span>
						</label>
						<span class="item-controls">
							<span class="item-type"><?php echo esc_html( $item->type_label ); ?></span>
							<span class="item-order hide-if-js">
								<a href="<?php
									echo wp_nonce_url( // phpcs:ignore
										add_query_arg(
											array(
												'action'    => 'move-up-menu-item',
												'menu-item' => $item_id,
											),
											remove_query_arg( $removed_args, admin_url( 'nav-menus.php' ) )
										),
										'move-menu_item'
									); // phpcs:ignore
								?>" class="item-move-up" aria-label="<?php esc_attr_e( 'Move up', 'armcodirect' ); ?>">&#8593;</a><?php // phpcs:ignore ?>
								|
								<a href="<?php
									echo wp_nonce_url( // phpcs:ignore
										add_query_arg(
											array(
												'action' => 'move-down-menu-item',
												'menu-item' => $item_id,
											),
											remove_query_arg( $removed_args, admin_url( 'nav-menus.php' ) )
										),
										'move-menu_item'
									);// phpcs:ignore
								?>" class="item-move-down" aria-label="<?php esc_attr_e( 'Move down', 'armcodirect' ); ?>">&#8595;</a><?php // phpcs:ignore ?>
							</span>
							<a class="item-edit" id="edit-<?php echo esc_attr( $item_id ); ?>" href="<?php
								echo ( isset( $_GET['edit-menu-item'] ) && $item_id === $_GET['edit-menu-item'] ) ? admin_url( 'nav-menus.php' ) : add_query_arg( 'edit-menu-item', $item_id, remove_query_arg( $removed_args, admin_url( 'nav-menus.php#menu-item-settings-' . $item_id ) ) );// phpcs:ignore
							?>" aria-label="<?php esc_attr_e( 'Edit menu item', 'armcodirect' ); ?>"><span class="screen-reader-text"><?php echo esc_html__( 'Edit', 'armcodirect' ); ?></span></a>
						</span>
					</div>
				</div>
				<div class="menu-item-settings wp-clearfix" id="menu-item-settings-<?php echo esc_attr( $item_id ); ?>">
					<?php if ( 'custom' === $item->type ) : ?>
						<p class="field-url description description-wide">
							<label for="edit-menu-item-url-<?php echo esc_attr( $item_id ); ?>">
								<?php echo esc_html__( 'URL', 'armcodirect' ); ?><br />
								<input type="text" id="edit-menu-item-url-<?php echo esc_attr( $item_id ); ?>" class="widefat code edit-menu-item-url" name="menu-item-url[<?php echo esc_attr( $item_id ); ?>]" value="<?php echo esc_attr( $item->url ); ?>" />
							</label>
						</p>
					<?php endif; ?>
					<p class="description description-wide">
						<label for="edit-menu-item-title-<?php echo esc_attr( $item_id ); ?>">
							<?php echo esc_html__( 'Navigation Label', 'armcodirect' ); ?><br />
							<input type="text" id="edit-menu-item-title-<?php echo esc_attr( $item_id ); ?>" class="widefat edit-menu-item-title" name="menu-item-title[<?php echo esc_attr( $item_id ); ?>]" value="<?php echo esc_attr( $item->title ); ?>" />
						</label>
					</p>
					<p class="field-title-attribute field-attr-title description description-wide">
						<label for="edit-menu-item-attr-title-<?php echo esc_attr( $item_id ); ?>">
							<?php echo esc_html__( 'Title Attribute', 'armcodirect' ); ?><br />
							<input type="text" id="edit-menu-item-attr-title-<?php echo esc_attr( $item_id ); ?>" class="widefat edit-menu-item-attr-title" name="menu-item-attr-title[<?php echo esc_attr( $item_id ); ?>]" value="<?php echo esc_attr( $item->post_excerpt ); ?>" />
						</label>
					</p>
					<p class="field-link-target description">
						<label for="edit-menu-item-target-<?php echo esc_attr( $item_id ); ?>">
							<input type="checkbox" id="edit-menu-item-target-<?php echo esc_attr( $item_id ); ?>" value="_blank" name="menu-item-target[<?php echo esc_attr( $item_id ); ?>]"<?php checked( $item->target, '_blank' ); ?> />
							<?php echo esc_html__( 'Open link in a new tab', 'armcodirect' ); ?>
						</label>
					</p>
					<p class="field-css-classes description description-thin">
						<label for="edit-menu-item-classes-<?php echo esc_attr( $item_id ); ?>">
							<?php echo esc_html__( 'CSS Classes (optional)', 'armcodirect' ); ?><br />
							<input type="text" id="edit-menu-item-classes-<?php echo esc_attr( $item_id ); ?>" class="widefat code edit-menu-item-classes" name="menu-item-classes[<?php echo esc_attr( $item_id ); ?>]" value="<?php echo esc_attr( implode( ' ', $item->classes ) ); ?>" />
						</label>
					</p>
					<p class="field-xfn description description-thin">
						<label for="edit-menu-item-xfn-<?php echo esc_attr( $item_id ); ?>">
							<?php echo esc_html__( 'Link Relationship (XFN)', 'armcodirect' ); ?><br />
							<input type="text" id="edit-menu-item-xfn-<?php echo esc_attr( $item_id ); ?>" class="widefat code edit-menu-item-xfn" name="menu-item-xfn[<?php echo esc_attr( $item_id ); ?>]" value="<?php echo esc_attr( $item->xfn ); ?>" />
						</label>
					</p>
					<p class="field-description description description-wide">
						<label for="edit-menu-item-description-<?php echo esc_attr( $item_id ); ?>">
							<?php echo esc_html__( 'Description', 'armcodirect' ); ?><br />
							<textarea id="edit-menu-item-description-<?php echo esc_attr( $item_id ); ?>" class="widefat edit-menu-item-description" rows="3" cols="20" name="menu-item-description[<?php echo esc_attr( $item_id ); ?>]"><?php echo esc_html( $item->description ); ?></textarea>
							<span class="description"><?php echo esc_html__( 'The description will be displayed in the menu if the current theme supports it.', 'armcodirect' ); ?></span>
						</label>
					</p>
					<div class="armcodirect-admin-mega-menu-init" id="armcodirect-admin-mega-menu-init">
						<p class="field-armcodirect-mega-menu-item-status description-wide">
							<label for="edit-menu-item-armcodirect-mega-menu-item-status-<?php echo esc_attr( $item_id ); ?>">
								<?php $status_checked = ( 'enabled' === $item->armcodirect_mega_menu_item_status ) ? 'checked="checked"' : ''; ?>
								<input type="checkbox" id="edit-menu-item-armcodirect-mega-menu-item-status-<?php echo esc_attr( $item_id ); ?>" class="widefat code edit-menu-item-armcodirect-mega-menu-item-status" name="menu-item-armcodirect-mega-menu-item-status[<?php echo esc_attr( $item_id ); ?>]" value="enabled" <?php echo esc_attr( $status_checked ); ?> />
								<?php echo esc_html__( 'Enable Mega Menu For This Item (only for main parent)', 'armcodirect' ); ?>
							</label>
						</p>
						<p class="field-armcodirect-mega-menu-item-sidebar description description-wide">
							<label for="edit-armcodirect-mega-menu-item-sidebar-<?php echo esc_attr( $item_id ); ?>">
								<?php echo esc_html__( 'Select Mega Menu Item Sidebar( If sidebar selected then menu title will remove only shows sidebar on menu).', 'armcodirect' ); ?>
								<?php
								echo '<select id="edit-menu-item-armcodirect-mega-menu-item-sidebar-' . $item_id . '" class="widefat code edit-menu-item-armcodirect-mega-menu-item-sidebar" name="menu-item-armcodirect-mega-menu-item-sidebar[' . $item_id . ']">'; // phpcs:ignore
								global $wp_registered_sidebars;
								if ( ! empty( $wp_registered_sidebars ) && is_array( $wp_registered_sidebars ) ) {
									echo '<option value="0">' . esc_html__( 'Select Widget Area', 'armcodirect' ) . '</option>';
									foreach ( $wp_registered_sidebars as $sidebar ) {
										$sidebar_value = $item->armcodirect_mega_menu_item_sidebar;
										$selected = ( ( $sidebar_value === $sidebar['id'] ) ) ? ' selected="selected"' : '';
										echo '<option ' . esc_attr( $selected ) . ' sidebar-id="' . esc_attr( $sidebar['id'] ) . '" value="' . esc_attr( $sidebar['id'] ) . '">' . htmlspecialchars( $sidebar['name'] ) . '</option>';  // phpcs:ignore
									}
								}
								echo '</select>';
								?>
							</label>
						</p>
					</div>

					<fieldset class="field-move hide-if-no-js description description-wide">
						<span class="field-move-visual-label" aria-hidden="true"><?php echo esc_html__( 'Move', 'armcodirect' ); ?></span>
						<button type="button" class="button-link menus-move menus-move-up" data-dir="up"><?php echo esc_html__( 'Up one', 'armcodirect' ); ?></button>
						<button type="button" class="button-link menus-move menus-move-down" data-dir="down"><?php echo esc_html__( 'Down one', 'armcodirect' ); ?></button>
						<button type="button" class="button-link menus-move menus-move-left" data-dir="left"></button>
						<button type="button" class="button-link menus-move menus-move-right" data-dir="right"></button>
						<button type="button" class="button-link menus-move menus-move-top" data-dir="top"><?php echo esc_html__( 'To the top', 'armcodirect' ); ?></button>
					</fieldset>

					<div class="menu-item-actions description-wide submitbox">
						<?php if ( 'custom' !== $item->type && false !== $original_title ) : ?>
							<p class="link-to-original">
								<?php printf( esc_html__( 'Original: %s', 'armcodirect' ), '<a href="' . esc_attr( $item->url ) . '">' . esc_html( $original_title ) . '</a>' ); ?>
							</p>
						<?php endif; ?>
						<a class="item-delete submitdelete deletion" id="delete-<?php echo esc_attr( $item_id ); ?>" href="<?php
						echo wp_nonce_url( // phpcs:ignore
							add_query_arg(
								array(
									'action'    => 'delete-menu-item',
									'menu-item' => $item_id,
								),
								admin_url( 'nav-menus.php' )
							),
							'delete-menu_item_' . $item_id
						); // phpcs:ignore
						?>"><?php echo esc_html__( 'Remove', 'armcodirect' ); ?></a> <span class="meta-sep hide-if-no-js"> | </span> <a class="item-cancel submitcancel hide-if-no-js" id="cancel-<?php echo esc_attr( $item_id ); ?>" href="<?php // phpcs:ignore
							echo esc_url( add_query_arg(
								array(
									'edit-menu-item' => $item_id,
									'cancel' => time(),
								),
								admin_url( 'nav-menus.php' ),
								),// phpcs:ignore
							);
							?>#menu-item-settings-<?php echo esc_attr( $item_id ); ?>"><?php echo esc_html__( 'Cancel', 'armcodirect' ); // phpcs:ignore ?></a>
					</div>
					<input class="menu-item-data-db-id" type="hidden" name="menu-item-db-id[<?php echo esc_attr( $item_id ); ?>]" value="<?php echo esc_attr( $item_id ); ?>" />
					<input class="menu-item-data-object-id" type="hidden" name="menu-item-object-id[<?php echo esc_attr( $item_id ); ?>]" value="<?php echo esc_attr( $item->object_id ); ?>" />
					<input class="menu-item-data-object" type="hidden" name="menu-item-object[<?php echo esc_attr( $item_id ); ?>]" value="<?php echo esc_attr( $item->object ); ?>" />
					<input class="menu-item-data-parent-id" type="hidden" name="menu-item-parent-id[<?php echo esc_attr( $item_id ); ?>]" value="<?php echo esc_attr( $item->menu_item_parent ); ?>" />
					<input class="menu-item-data-position" type="hidden" name="menu-item-position[<?php echo esc_attr( $item_id ); ?>]" value="<?php echo esc_attr( $item->menu_order ); ?>" />
					<input class="menu-item-data-type" type="hidden" name="menu-item-type[<?php echo esc_attr( $item_id ); ?>]" value="<?php echo esc_attr( $item->type ); ?>" />
				</div><!-- .menu-item-settings-->
				<ul class="menu-item-transport"></ul>
			<?php
			$output .= ob_get_clean();
		}
	}
}
