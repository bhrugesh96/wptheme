<?php
/**
 * Product terms widget.
 *
 * @package Armcodirect
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Core class used to implement a Product terms widget.
 *
 * @since 2.8.0
 *
 * @see WP_Widget
 */
class Armcodirect_Widget_Product_Terms extends WP_Widget {

	/**
	 * Sets up a new Categories widget instance.
	 *
	 * @since 2.8.0
	 */
	public function __construct() {
		$widget_ops = array(
			'classname'                   => 'widget_product_taxonomy',
			'description'                 => __( 'A list of product categories.' ),
			'customize_selective_refresh' => true,
			'show_instance_in_rest'       => true,
		);
		parent::__construct( 'product_taxonomy', __( 'Product Categories' ), $widget_ops );
	}

	/**
	 * Outputs the content for the product terms instance.
	 *
	 * @param array $args     Display arguments including 'before_title', 'after_title',
	 *                        'before_widget', and 'after_widget'.
	 * @param array $instance Settings for the current Custom HTML widget instance.
	 */
	public function widget( $args, $instance ) {

		echo $args['before_widget']; // phpcs:ignore

		$thumbnail   = ( isset( $instance['thumbnail'] ) ) ? $instance['thumbnail'] : '';
		$postperpage = ( isset( $instance['postperpage'] ) ) ? $instance['postperpage'] : 6;
		$orderby     = ( isset( $instance['orderby'] ) ) ? $instance['orderby'] : 'name';
		$sortby      = ( isset( $instance['sortby'] ) ) ? $instance['sortby'] : 'ASC';

		$terms = get_terms(
			array(
				'orderby'    => $orderby,
				'order'      => $sortby,
				'taxonomy'   => 'product-category',
				'number'     => $postperpage,
				'hide_empty' => false,
			)
		);

		if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) {
			foreach ( $terms as $term_val ) {
				$the_query = new WP_Query(
					array(
						'post_type' => 'products',
						'tax_query' => array(
							array(
								'taxonomy' => 'product-category',
								'field'    => 'id',
								'terms'    => $term_val->term_id,
							),
						),
					)
				);
				$count         = $the_query->found_posts;
				$product_label = ( 1 === $count ) ? esc_html__( 'Product', 'armcodirect' ) : esc_html__( 'Products', 'armcodirect' );
				$thumbnail_id  = get_field( 'category_image_tax', $term_val );
				if ( $count > 0 ) {
					?>
					<div class="col-lg-4 col-md-6">
						<a class="grid-term-link" href="<?php echo esc_url( get_term_link( $term_val ) ); ?>">
							<div class="category-grid">
								<div class="category-img-wrapper">
								<?php
								if ( 'on' === $thumbnail ) {
									if ( ! empty( $thumbnail_id ) ) {
										echo wp_get_attachment_image( $thumbnail_id, 'full' );
									} else {
										?>
										<img src="<?php echo ARMCODIRECT_THEME_URI; // phpcs:ignore ?>/inc/assets/small-placeholder.jpg" alt="" />
										<?php
									}
								}
								?>
								</div>
								<div class="category-title-wrapper">
									<h5 class="category-title"><?php echo esc_html( $term_val->name ); ?></h5>
									<span class="count">
										<?php
										echo sprintf( '%1$s&nbsp;%2$s', esc_html( $count ), esc_html( $product_label ) ) . '';
										?>
									</span>
								</div>
								<span class="term-link arrow"></span>
							</div>
						</a>
					</div>
					<?php
				}
			}
		}
		echo $args['after_widget'];// phpcs:ignore
	}

	/**
	 * Outputs the produc category settings form.
	 *
	 * @param array $instance Current instance.
	 */
	public function form( $instance ) {

		$instance    = wp_parse_args( (array) $instance, array() );
		$thumbnail   = ( isset( $instance['thumbnail'] ) && 'on' === $instance['thumbnail'] ) ? 'checked="checked"' : '';
		$postperpage = ( isset( $instance['postperpage'] ) ) ? $instance['postperpage'] : 6;
		$orderby     = ( isset( $instance['orderby'] ) ) ? $instance['orderby'] : 'name';
		$sortby      = ( isset( $instance['sortby'] ) ) ? $instance['sortby'] : 'ASC';
		?>
		<p>
			<input class="widefat" id="<?php echo $this->get_field_id( 'thumbnail' ); ?>" size="3" name="<?php echo $this->get_field_name( 'thumbnail' ); ?>" type="checkbox" <?php echo $thumbnail; ?> /><?php // phpcs:ignore ?>
			<label for="<?php echo $this->get_field_id( 'thumbnail' ); ?>"><?php // phpcs:ignore ?>
				<?php esc_html_e( 'Display Thumbnail?', 'armcodirect' ); ?>
			</label>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'postperpage' );// phpcs:ignore ?>"><?php esc_html_e( 'Number of categories to show:', 'armcodirect' ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'postperpage' ); ?>" size="3"  name="<?php echo $this->get_field_name( 'postperpage' ); ?>" type="text" value="<?php echo esc_attr( $postperpage ); ?>" /><?php // phpcs:ignore ?>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'orderby' );// phpcs:ignore  ?>">
				<?php esc_html_e( 'Order by:', 'armcodirect' ); ?>
			</label>
			<select name="<?php echo $this->get_field_name( 'orderby' );// phpcs:ignore  ?>" id="orderby" class="widefat">
				<option value="ID"<?php echo esc_attr( 'ID' === $orderby ) ? ' selected="selected"' : ''; ?>><?php echo esc_html__( 'ID', 'armcodirect' ); ?></option>
				<option value="name"<?php echo esc_attr( 'name' === $orderby ) ? ' selected="selected"' : ''; ?>><?php echo esc_html__( 'Name', 'armcodirect' ); ?></option>
				<option value="slug"<?php echo esc_attr( 'slug' === $orderby ) ? ' selected="selected"' : ''; ?>><?php echo esc_html__( 'Slug', 'armcodirect' ); ?></option>
				<option value="count"<?php echo esc_attr( 'count' === $orderby ) ? ' selected="selected"' : ''; ?>><?php echo esc_html__( 'Count', 'armcodirect' ); ?></option>
				<option value="term_group"<?php echo esc_attr( 'term_group' === $orderby ) ? ' selected="selected"' : ''; ?>><?php echo esc_html__( 'Term Group', 'armcodirect' ); ?></option>
			</select>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'sortby' );// phpcs:ignore  ?>">
				<?php esc_html_e( 'Sort order:', 'armcodirect' ); ?>
			</label>
			<select name="<?php echo $this->get_field_name( 'sortby' );// phpcs:ignore  ?>" id="sortby" class="widefat">
				<option value="DESC"<?php echo esc_attr( 'DESC' === $sortby ) ? ' selected="selected"' : ''; ?>><?php echo esc_html__( 'Descending', 'armcodirect' ); ?></option>
				<option value="ASC"<?php echo esc_attr( 'ASC' === $sortby ) ? ' selected="selected"' : ''; ?>><?php echo esc_html__( 'Ascending', 'armcodirect' ); ?></option>
			</select>
		</p>
		<?php
	}

	/**
	 * Handles updating settings for the current Custom HTML widget instance.
	 *
	 * @param array $new_instance New settings for this instance as input by the user via
	 *                            WP_Widget::form().
	 * @param array $old_instance Old settings for this instance.
	 * @return array Settings to save or bool false to cancel saving.
	 */
	public function update( $new_instance, $old_instance ) {

		$instance = array();
		$instance['thumbnail']   = ( ! empty( $new_instance['thumbnail'] ) ) ? wp_strip_all_tags( $new_instance['thumbnail'] ) : '';
		$instance['postperpage'] = ( ! empty( $new_instance['postperpage'] ) ) ? wp_strip_all_tags( $new_instance['postperpage'] ) : '';
		$instance['orderby']     = ( ! empty( $new_instance['orderby'] ) ) ? wp_strip_all_tags( $new_instance['orderby'] ) : '';
		$instance['sortby']      = ( ! empty( $new_instance['sortby'] ) ) ? wp_strip_all_tags( $new_instance['sortby'] ) : '';
		return $instance;
	}
}

if ( ! function_exists( 'armcodirect_product_categories' ) ) {
	/**
	 * Register and load the widget.
	 */
	function armcodirect_product_categories() {
		register_widget( 'Armcodirect_Widget_Product_Terms' );
	}
}
add_action( 'widgets_init', 'armcodirect_product_categories' );
