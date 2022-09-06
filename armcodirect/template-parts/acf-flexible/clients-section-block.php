<?php
/**
 * Display Client section block.
 *
 * @package Armcodirect
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
$clients_logo_obj = get_sub_field( 'clients_logo_obj' );

if ( ! empty( $clients_logo_obj ) ) :
	?>
	<section class="client-logos-block">
		<div class="container">
			<div class="row">
				<div class="swiper swiper-container" data-slider-options='{ "slidesPerView": 1, "watchOverflow": true, "keyboard": { "enabled": true, "onlyInViewport": true }, "autoplay": { "delay": 3500, "disableOnInteraction": false }, "breakpoints": { "1200": { "slidesPerView": 6 }, "992": { "slidesPerView": 3 }, "768": { "slidesPerView": 3 }, "576": { "slidesPerView": 2 } } }'>
					<div class="swiper-wrapper">
						<?php
						foreach ( $clients_logo_obj as $row ) :
							$logo_image = ( isset( $row['logo_image'] ) && ! empty( $row['logo_image'] ) ) ? $row['logo_image'] : '';
							$logo_url   = ( isset( $row['logo_image_url'] ) && ! empty( $row['logo_image_url'] ) ) ? $row['logo_image_url'] : '';

							if ( ! empty( $logo_image ) ) {
								echo '<div class="swiper-slide d-flex align-items-center justify-content-center">';
								if ( ! empty( $logo_url ) ) {
									echo '<a href="' . esc_url( $logo_url ) . '" target="_blank">';
								}
								echo wp_get_attachment_image( $logo_image, 'full', '', array( 'class' => 'skip-lazy' ) );
								if ( ! empty( $logo_url ) ) {
									echo '</a>';
								}
								echo '</div>';
							}
						endforeach;
						?>
					</div>
				</div>
			</div>
		</div>
	</section>
	<?php
endif;
