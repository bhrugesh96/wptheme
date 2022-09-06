<?php
/**
 * Content page template to display related products
 *
 * @package Armcodirect
 */

$related_title = get_field( 'related_title' );
$products_obj  = get_field( 'products_single_obj' );
$terms         = get_field( 'categories_single_obj' );
$related_title = ( ! empty( $related_title ) ) ? $related_title : esc_html__( 'Related Products', 'armcodirect' );
if ( ! empty( $products_obj ) || ! empty( $terms ) ) {
	?>
	<section class="related-products-wrapper">
		<div class="container">
			<?php
			if ( $products_obj ) :
				?>
				<div class="row">
					<div class="col-12">
						<h3 class="title h-1">
							<?php echo esc_html( $related_title ); ?>
						</h3>
					</div>
					<?php
					foreach ( $products_obj as $post ) :// phpcs:ignore
						// Setup this post for WP functions (variable must be named $post).
						setup_postdata( $post );
						?>
						<div class="col-lg-3 col-md-6 col-12 mb-4">
							<div class="product-box">
								<div class="post-thumb">
									<?php
									$taxonomy_arr = get_the_terms( get_the_ID(), 'product-category' );
									if ( ! empty( $taxonomy_arr ) && ! is_wp_error( $taxonomy_arr ) ) {
										foreach ( $taxonomy_arr as $tax_val ) {
											echo '<a class="category-badge" href="' . get_term_link( $tax_val ) . '"><span>' . esc_html( $tax_val->name ) . '</span></a>';
											break;
										}
									}
									?>
									<a class="post-thumb-box" href="<?php the_permalink(); ?>">
										<?php
										if ( has_post_thumbnail() ) {
											the_post_thumbnail();
										} else {
											?>
											<img src="<?php echo ARMCODIRECT_THEME_URI; // phpcs:ignore ?>/inc/assets/placeholder.jpg" alt="" />
											<?php
										}
										?>
									</a>
								</div>
								<div class="post-content-wrapper">
									<?php
									if ( get_the_title() ) {
										?>
										<a href="<?php the_permalink(); ?>">
											<h3 class="h-5 entry-title text-blue"><?php the_title(); ?></h3>
										</a>
										<?php
									}
									?>
									<a class="btn" href="<?php the_permalink(); ?>"><?php echo esc_html__( 'VIEW PRODUCT', 'armcodirect' ); ?></a>
								</div>
							</div>
						</div>
						<?php
					endforeach;
					?>
				</div>
				<?php
			endif;
			?>
			<?php
			if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) {
				?>
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
				<?php
			}
			?>
		</div>
	</section>
	<?php
}
