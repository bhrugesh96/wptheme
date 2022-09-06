<?php
/**
 * Content page template to display all pages content
 *
 * @package Armcodirect
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if ( get_the_content() ) {
	// Default content dispplay.
	?>
	<section class="content-wrap">
		<div class="container">
			<div class="row justify-content-center">
				<div class="col-xl-8 col-lg-10 col-12">
					<div class="row">
						<div class="col-sm-auto col-12">
							<?php
							if ( is_single() ) {
								?>
								<div class="social-share">
									<?php get_template_part( 'template-parts/post/social-share' ); ?>
								</div>
								<?php
							}
							?>
						</div>
						<div class="entry-content">
							<?php the_content(); ?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
	<?php
}
if ( have_rows( 'page_builder' ) ) {
	while ( have_rows( 'page_builder' ) ) :
		the_row();
		$layout_section = get_row_layout();
		switch ( $layout_section ) {
			case 'header_banner':
			case 'header_strip_block':
			case 'content_with_image':
			case 'quote_cta_block':
			case 'faq_content_with_image':
			case 'content_block':
			case 'usp_content_block':
			case 'google_maps_block':
			case 'testimonials_block':
			case 'blog_listing_block':
			case 'product_usage_block':
			case 'clients_section_block':
			case 'product_suggestion_block':
			case 'product_usage_with_content_block':
				$template_name = str_replace( '_', '-', $layout_section );
				get_template_part( 'template-parts/acf-flexible/' . $template_name );
				break;
			default:
				break;
		}
	endwhile;
}
