<?php
/**
 * Content page template to display all product.
 *
 * @package Armcodirect
 */

$product_cta_text = get_field( 'product_cta_text', 'option' );
$product_cta_text = ( ! empty( $product_cta_text ) ) ? $product_cta_text : esc_html__( 'VIEW PRODUCT', 'armcodirect' );
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
					<img src="<?php echo ARMCODIRECT_THEME_URI;// phpcs:ignore ?>/inc/assets/placeholder.jpg" alt="" />
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
			<a class="btn" href="<?php the_permalink(); ?>"><?php echo esc_html( $product_cta_text ); ?></a>
		</div>
	</div>
</div>
