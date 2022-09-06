<?php
/**
 * Defind Mega Menu Class.
 *
 */
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Armcodirect_Mega_Menu' ) ) {

	class Armcodirect_Mega_Menu {

		public function __construct() {

			add_action( 'init', array( $this, 'armcodirect_mega_menu_init' ) );
		}

		public function armcodirect_mega_menu_init() {

			if ( file_exists( ARMCODIRECT_THEME_LIB . '/class-mega-menu-backend.php' ) ) :
				require_once ARMCODIRECT_THEME_LIB . '/class-mega-menu-backend.php';
			endif;

			if ( file_exists( ARMCODIRECT_THEME_LIB . '/class-mega-menu-frontend.php' ) ) :
				require_once ARMCODIRECT_THEME_LIB . '/class-mega-menu-frontend.php';
			endif;
		}
	} // end of class

	$armcodirect_mega_menu = new Armcodirect_Mega_Menu();

} // end of class_exists
