<?php
/**
 * Archive Product Template.
 *
 * @package Armcodirect
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

get_template_part( 'template-parts/deafult-header-strip-block' );
?>
<section class="products-list">
	<div class="container">
		<div class="row">
			<?php
			if ( have_posts() ) {
				while ( have_posts() ) {
					the_post();
					get_template_part( 'template-parts/content', 'products' );
				}
				armcodirect_get_the_posts_pagination(); // Pagination.
			} else {
				get_template_part( 'template-parts/content', 'none' );
			}
			?>
		</div>
	</div>
</section>
<?php
get_template_part( 'template-parts/content', 'category-grid' );
