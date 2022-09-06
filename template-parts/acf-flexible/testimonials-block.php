<?php
/**
 * Testimonials block to show reviews
 *
 * @package Armcodirect
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

$bg_pattern       = get_sub_field( 'background_pattern' );
$subtitle         = get_sub_field( 'subtitle' );
$page_title       = get_sub_field( 'title' );
$testimonials_obj = get_sub_field( 'testimonials_obj' );

if ( ! empty( $subtitle ) || ! empty( $page_title ) || ! empty( $testimonials_obj ) ) {
	?>
	<section class="testimonials-block <?php echo esc_attr( $bg_pattern ); ?>">
		<div class="container">
			<div class="row">
				<div class="col-12 text-center text-lg-start">
					<?php
					if ( ! empty( $subtitle ) ) {
						?>
						<span class="subtitle">
							<?php
								echo sprintf( '%s', $subtitle );// phpcs:ignore
							?>
						</span>
						<?php
					}
					if ( ! empty( $page_title ) ) {
						?>
						<h2 class="title h-1">
							<?php
								echo sprintf( '%s', $page_title );// phpcs:ignore
							?>
						</h2>
						<?php
					}
					?>
				</div>
			</div>
		</div>
		<div class="container-fluid">
			<?php
			if ( ! empty( $testimonials_obj ) ) :
				?>
				<div class="swiper swiper-container" data-slider-options='{ "slidesPerView": 1, "spaceBetween": 20, "centeredSlides": true, "loop": true, "allowTouchMove": true, "autoHeight": true, "keyboard": { "enabled": true, "onlyInViewport": true }, "navigation": { "nextEl": ".swiper-button-next", "prevEl": ".swiper-button-prev" }, "breakpoints": { "768": { "slidesPerView": "2", "autoHeight": false }, "1200": { "slidesPerView": "3", "autoHeight": false } } }'>
					<div class="swiper-wrapper">
						<?php
						foreach ( $testimonials_obj as $post ) :// phpcs:ignore
							// Setup this post for WP functions (variable must be named $post).
							setup_postdata( $post );
							$icon_id     = get_field( 'icon' );
							$designation = get_field( 'designation' );
							?>
							<div class="swiper-slide h-auto">
								<div class="testimonial-wrapper">
									<?php
									echo wp_get_attachment_image( $icon_id, 'full' );
									if ( ! empty( get_the_content() ) ) {
										?>
										<h5 class="content">
											<?php
												echo sprintf( '%s', get_the_content() );// phpcs:ignore
											?>
										</h5>
										<?php
									}
									?>
									<strong class="name">
										<?php
										echo esc_html( get_the_title() );// phpcs:ignore
										if ( ! empty( $designation ) ) {
											echo '<span>' . esc_html( $designation ) . '</span>';
										}
										?>
									</strong>
								</div>
							</div>
							<?php
						endforeach;
						?>
					</div>
					<div class="swiper-button-next"></div>
					<div class="swiper-button-prev"></div>
				</div>
				<?php
				// Reset the global post object so that the rest of the page works correctly.
				wp_reset_postdata();
			endif;
			?>
		</div>
	</section>
	<?php
}
