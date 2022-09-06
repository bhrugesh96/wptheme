<?php
/**
 * Add functionality
 *
 * @package Armcodirect
 */

if ( ! function_exists( 'armcodirect_plugins_loaded' ) ) {
	/**
	 * Armcodirect theme only works with Advanced Custom Fields Pro.
	 */
	function armcodirect_plugins_loaded() {
		if ( is_admin() || ( 'wp-login.php' === $GLOBALS['pagenow'] ) ) {
			return;
		}

		if ( ! class_exists( 'acf' ) ) {
			$acfexternalurl = 'https://www.advancedcustomfields.com/pro';
			wp_die( sprintf(__( 'It needs <a href="%1s" target="_blank">Advanced Custom Fields Pro</a> to run. Please download and activate it.', 'armcodirect' ), $acfexternalurl ) );// phpcs:ignore
		}
	}
}
add_action( 'init', 'armcodirect_plugins_loaded' );

if ( ! function_exists( 'armcodirect_product_custom_post_type_init' ) ) {
	/**
	 * Products custom post type
	 */
	function armcodirect_product_custom_post_type_init() {
		$labels = array(
			'name'               => _x( 'Product', 'Product', 'armcodirect' ),
			'singular_name'      => _x( 'Product', 'Product', 'armcodirect' ),
			'add_new'            => _x( 'Add New', 'Product', 'armcodirect' ),
			'add_new_item'       => __( 'Add New Product', 'armcodirect' ),
			'edit_item'          => __( 'Edit Product', 'armcodirect' ),
			'new_item'           => __( 'New Product', 'armcodirect' ),
			'all_items'          => __( 'All Products', 'armcodirect' ),
			'view_item'          => __( 'View Product', 'armcodirect' ),
			'search_items'       => __( 'Search Product', 'armcodirect' ),
			'not_found'          => __( 'No Product found', 'armcodirect' ),
			'not_found_in_trash' => __( 'No Products found in the Trash', 'armcodirect' ),
			'parent_item_colon'  => '',
			'menu_name'          => __( 'Product', 'armcodirect' ),
		);

		$args = array(
			'labels'        => $labels,
			'description'   => __( 'Holds our products and product specific data', 'armcodirect' ),
			'public'        => true,
			'menu_icon'     => 'dashicons-products',
			'menu_position' => 21,
			'show_in_rest'  => true,
			'show_ui'       => true,
			'supports'      => array( 'title', 'thumbnail', 'editor', 'author', 'revisions', 'page-attributes' ),
			'has_archive'   => true,
			'hierarchical'  => true,
		);
		register_post_type( 'products', $args );

		/**
		 * Product Category
		 */
		$labels = array(
			'name'              => _x( 'Product Categories', 'taxonomy general name', 'armcodirect' ),
			'singular_name'     => _x( 'Product Category', 'taxonomy singular name', 'armcodirect' ),
			'search_items'      => __( 'Search categories', 'armcodirect' ),
			'all_items'         => __( 'All Categories', 'armcodirect' ),
			'parent_item'       => __( 'Parent Category', 'armcodirect' ),
			'parent_item_colon' => __( 'Parent Category:', 'armcodirect' ),
			'edit_item'         => __( 'Edit Category', 'armcodirect' ),
			'update_item'       => __( 'Update Category', 'armcodirect' ),
			'add_new_item'      => __( 'Add New Category', 'armcodirect' ),
			'new_item_name'     => __( 'New Category Name', 'armcodirect' ),
			'menu_name'         => __( 'Categories', 'armcodirect' ),
		);
		$args = array(
			'labels'            => $labels,
			'public'            => true,
			'show_ui'           => true,
			'hierarchical'      => true,
			'show_admin_column' => true,
			'show_in_nav_menus' => true,
			'show_in_rest'      => true,
		);
		register_taxonomy( 'product-category', 'products', $args );
	}
}
add_action( 'init', 'armcodirect_product_custom_post_type_init' );

if ( ! function_exists( 'armcodirect_review_custom_post_type_init' ) ) {
	/**
	 * Review custom post type
	 */
	function armcodirect_review_custom_post_type_init() {
		$labels = array(
			'name'               => _x( 'Reviews', 'Review', 'armcodirect' ),
			'singular_name'      => _x( 'Review', 'Review', 'armcodirect' ),
			'add_new'            => _x( 'Add New', 'Review', 'armcodirect' ),
			'add_new_item'       => __( 'Add New Review', 'armcodirect' ),
			'edit_item'          => __( 'Edit Review', 'armcodirect' ),
			'new_item'           => __( 'New Review', 'armcodirect' ),
			'all_items'          => __( 'All Reviews', 'armcodirect' ),
			'view_item'          => __( 'View Review', 'armcodirect' ),
			'search_items'       => __( 'Search Reviews', 'armcodirect' ),
			'not_found'          => __( 'No Review found', 'armcodirect' ),
			'not_found_in_trash' => __( 'No Reviews found in the Trash', 'armcodirect' ),
			'parent_item_colon'  => '',
			'menu_name'          => __( 'Reviews', 'armcodirect' ),
		);

		$args = array(
			'labels'        => $labels,
			'description'   => __( 'Holds our review and review specific data', 'armcodirect' ),
			'public'        => false,
			'menu_icon'     => 'dashicons-testimonial',
			'menu_position' => 21,
			'show_in_rest'  => true,
			'show_ui'       => true,
			'supports'      => array(
				'title',
				'editor',
				'author',
				'revisions',
				'page-attributes',
			),
			'has_archive'   => false,
			'hierarchical'  => false,
		);
		register_post_type( 'review', $args );
	}
}
add_action( 'init', 'armcodirect_review_custom_post_type_init' );

if ( ! function_exists( 'armcodirect_breadcrumb_display' ) ) {
	/**
	 * Page title option for individual pages
	 */
	function armcodirect_breadcrumb_display() {

		if ( class_exists( 'Armcodirect_Breadcrumb' ) ) {

			$breadcrumb_title_blog  = esc_html__( 'Home', 'armcodirect' );
			$breadcrumb_title_home  = esc_html__( 'Home', 'armcodirect' );
			$armcodirect_breadcrumb = new Armcodirect_Breadcrumb();

			$armcodirect_breadcrumb->opt['static_frontpage'] = false;
			$armcodirect_breadcrumb->opt['url_blog']         = '';
			$armcodirect_breadcrumb->opt['title_blog']       = esc_html__( 'Home', 'armcodirect' );
			$armcodirect_breadcrumb->opt['title_home']       = esc_html__( 'Home', 'armcodirect' );
			$armcodirect_breadcrumb->opt['separator']        = '';
			$armcodirect_breadcrumb->opt['tag_page_prefix']  = '';

			return $armcodirect_breadcrumb->armcodirect_display_breadcrumb();
		}
	}
}

if ( ! function_exists( 'armcodirect_admin_custom_scripts' ) ) {
	/**
	 * Register Custom scripts for admin
	 */
	function armcodirect_admin_custom_scripts() {
		wp_register_script( 'armcodirect-admin-custom-script', ARMCODIRECT_THEME_URI . '/lib/admin/armcodirect-admin-custom.js', array( 'jquery' ), '1.0', true );
		wp_enqueue_script( 'armcodirect-admin-custom-script' );
	}
}
add_action( 'admin_enqueue_scripts', 'armcodirect_admin_custom_scripts' );

if ( ! function_exists( 'armcodirect_get_the_posts_pagination' ) ) {
	/**
	 * Pagination.
	 */
	function armcodirect_get_the_posts_pagination() {

		$pagination = get_the_posts_pagination(
			array(
				'mid_size'  => 2,
				'prev_next' => false,
			)
		);
		echo $pagination; // phpcs:ignore
	}
}

if ( ! function_exists( 'armcodirect_cf7_footer_script' ) ) {
	/**
	 * CF7 script.
	 */
	function armcodirect_cf7_footer_script() {
		$redict_url = home_url( '/thank-you' );
		?>
		<script>
		document.addEventListener( 'wpcf7mailsent', function( event ) {
			location = '<?php echo esc_url( $redict_url ); ?>';
		}, false );
		</script>
		<?php
	}
}
add_action( 'wp_footer', 'armcodirect_cf7_footer_script' );
