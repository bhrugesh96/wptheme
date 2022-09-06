<?php
/**
 * Armcodirect Includes.
 * The $armcodirect_includes array determines the code library included into the site.
 *
 * @package Armcodirect
 */

define( 'ARMCODIRECT_THEME_DIR', get_template_directory() );
define( 'ARMCODIRECT_THEME_URI', get_template_directory_uri() );
define( 'ARMCODIRECT_THEME_LIB', ARMCODIRECT_THEME_DIR . '/lib' );

$armcodirect_includes = array(
	'lib/root-wrapper.php',
	'lib/class-armcodirect-breadcrumb.php',
	'lib/class-product-categories-widget.php',
	'lib/mega-menu.php',
	'lib/extras.php',
	'lib/optimisation.php',
);

foreach ( $armcodirect_includes as $file ) {
	if ( ! $filepath = locate_template( $file ) ) { // phpcs:ignore
		trigger_error( sprintf( __( 'Error locating %s for inclusion', 'armcodirect' ), $file ), E_USER_ERROR ); // phpcs:ignore
	}

	require_once $filepath;
}
unset( $file, $filepath );

if ( ! function_exists( 'armco_theme_setup' ) ) {
	/**
	 * Sets up theme defaults and registers support for various wp features.
	 *
	 * @return void
	 */
	function armco_theme_setup() {

		/**
		 * Text Domain.
		 */
		load_theme_textdomain( 'armcodirect', ARMCODIRECT_THEME_DIR . '/languages' );

		/**
		 * Register Featured Image Support.
		 */
		add_theme_support( 'post-thumbnails' );

		/**
		 * Register Navigations.
		 */
		register_nav_menus(
			array(
				'menu-1' => __( 'Primary', 'armcodirect' ),
				// Add next menu here.
			)
		);

	}
}
add_action( 'after_setup_theme', 'armco_theme_setup' );

/**
 * Register and include Scripts.
 */
function register_load_scripts() {

	wp_enqueue_script( 'masonry' );
	wp_register_script( 'armcodirect-vendors', ARMCODIRECT_THEME_URI . '/dist/vendors.min.js', array( 'jquery' ), '1.0', true );
	wp_register_script( 'armcodirect-scripts', ARMCODIRECT_THEME_URI . '/dist/main.min.js', array( 'jquery', 'armcodirect-vendors' ), '1.0', true );
	wp_enqueue_script( 'armcodirect-scripts' );

	if ( is_page_template( 'templates/calculator-template.php' ) ) {
		wp_register_script( 'jquery.sticky-kit', ARMCODIRECT_THEME_URI . '/lib/js/jquery.sticky-kit.min.js', array( 'jquery' ), '1.0', true );
		wp_register_script( 'armcodirect-calculator', ARMCODIRECT_THEME_URI . '/lib/js/calculator.js', array( 'jquery' ), '1.0', true );
		wp_enqueue_script( 'jquery.sticky-kit' );
		wp_enqueue_script( 'armcodirect-calculator' );
	}
}
add_action( 'wp_enqueue_scripts', 'register_load_scripts' );

/**
 * Register Styles.
 */
function register_load_stylesheets() {
	wp_register_style( 'styles', get_template_directory_uri() . '/dist/main.min.css', array(), '1.0', 'screen' );
	wp_enqueue_style( 'styles' );
}
add_action( 'wp_enqueue_scripts', 'register_load_stylesheets' );

/**
 * Register Sidebars.
 */
function widgets_init() {

	register_sidebar(
		array(
			'name'          => __( 'Primary Sidebar', 'armcodirect' ),
			'id'            => 'sidebar-primary',
			'before_widget' => '<div class="widget %1$s %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h4>',
			'after_title'   => '</h4>',
		)
	);

	register_sidebar(
		array(
			'name'          => __( 'Product Mega Menu', 'armcodirect' ),
			'id'            => 'product-mega-menu',
			'before_widget' => '<div class="row widget %1$s %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '',
			'after_title'   => '',
		)
	);

	register_sidebar(
		array(
			'name'          => __( 'Footer Column 1', 'armcodirect' ),
			'id'            => 'footer-column-1',
			'before_widget' => '<div class="widget %1$s %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h3 class="title h-4">',
			'after_title'   => '</h3>',
		)
	);

	register_sidebar(
		array(
			'name'          => __( 'Footer Column 2', 'armcodirect' ),
			'id'            => 'footer-column-2',
			'before_widget' => '<div class="widget %1$s %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h3 class="title h-4">',
			'after_title'   => '</h3>',
		)
	);

	register_sidebar(
		array(
			'name'          => __( 'Footer Column 3', 'armcodirect' ),
			'id'            => 'footer-column-3',
			'before_widget' => '<div class="widget %1$s %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h3 class="title h-4">',
			'after_title'   => '</h3>',
		)
	);
}
add_action( 'widgets_init', __NAMESPACE__ . '\\widgets_init' );

if ( ! function_exists( 'armcodirect_support_mime_types' ) ) {
	/**
	 * SVG File upload.
	 *
	 * @param array $mimes Return Array with svg support.
	 */
	function armcodirect_support_mime_types( $mimes ) {
		$mimes['svg'] = 'image/svg+xml';
		return $mimes;
	}
}
add_filter( 'upload_mimes', 'armcodirect_support_mime_types', 1, 1 );

// Theme Settings.
if ( function_exists( 'acf_add_options_page' ) ) {
	acf_add_options_page(
		array(
			'page_title' => __( 'Theme Settings', 'armcodirect' ),
			'menu_title' => __( 'Theme Settings', 'armcodirect' ),
			'menu_slug'  => 'theme-general-settings',
			'capability' => 'edit_posts',
			'redirect'   => false,
		)
	);
}
