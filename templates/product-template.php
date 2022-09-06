<?php
/**
 * Template Name: Product Template
 *
 * @package Armcodirect
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

get_template_part( 'template-parts/deafult-header-strip-block' );

get_template_part( 'template-parts/content', 'page' );

$product_query = new WP_Query(
	array(
		'post_type'      => 'products',
		'post_status'    => 'publish',
		'posts_per_page' => 2,
		'paged'          => get_query_var( 'paged' ) ? get_query_var( 'paged' ) : 1,
	)
);
$archive_product_title = get_field( 'archive_product_title', 'option' );
?>
<section class="products-list">
	<div class="container">
		<?php
		if ( ! empty( $archive_product_title ) ) {
			?>
			<div class="row">
				<div class="col-12">
					<h2 class="section-title"><?php echo esc_html( $archive_product_title ); ?></h2>
				</div>
			</div>
			<?php
		}
		?>
		<div class="row">
			<?php
			if ( $product_query->have_posts() ) {
				while ( $product_query->have_posts() ) {
					$product_query->the_post();
					get_template_part( 'template-parts/content', 'products' );
				}
				?>
				<nav class="navigation pagination">
					<h2 class="screen-reader-text"><?php echo esc_html__( 'Posts navigation' ); ?></h2>
					<div class="nav-links">
						<?php
						$big = 999999999;
						// phpcs:ignore
						echo paginate_links(
							array(
								'base'      => str_replace( $big, '%#%', get_pagenum_link( $big ) ),
								'format'    => '?paged=%#%',
								'current'   => max( 1, get_query_var( 'paged' ) ),
								'total'     => $product_query->max_num_pages,
								'prev_next' => false,
							)
						);
						?>
					</div>
				</nav>
				<?php
			} else {
				get_template_part( 'template-parts/content', 'none' );
			}
			wp_reset_postdata();
			?>
		</div>
	</div>
</section>
<?php
get_template_part( 'template-parts/content', 'category-grid' );
