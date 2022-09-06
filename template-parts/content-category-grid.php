<?php
/**
 * Template part for displaying category grid results
 *
 * @package Armcodirect
 */

$terms = get_terms(
	array(
		'taxonomy'   => 'product-category',
		'hide_empty' => false,
	)
);
if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) {
	?>
	<section class="product-category-grid">
		<div class="container">
			<div class="row">
			<?php
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
					),
				);
				$count         = $the_query->found_posts;
				$product_label = ( 1 === $count ) ? esc_html__( 'Product', 'armcodirect' ) : esc_html__( 'Products', 'armcodirect' );
				$thumbnail_id  = get_field( 'category_image_tax', $term_val );
				if ( $count > 0 ) {
					?>
					<div class="col-lg-4 col-md-6 col-12">
						<a class="grid-term-link" href="<?php echo esc_url( get_term_link( $term_val ) ); ?>">
							<div class="category-grid">
								<div class="category-img-wrapper">
									<?php
									if ( ! empty( $thumbnail_id ) ) {
										echo wp_get_attachment_image( $thumbnail_id, 'full' );
									} else {
										?>
										<img src="<?php echo ARMCODIRECT_THEME_URI;// phpcs:ignore ?>/inc/assets/small-placeholder.jpg" alt="" />
										<?php
									}
									?>
								</div>
								<div class="category-title-wrapper">
									<h4 class="category-title h-5"><?php echo esc_html( $term_val->name ); ?></h4>
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
			?>
			</div>
		</div>
	</section>
	<?php
}
