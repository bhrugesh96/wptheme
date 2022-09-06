<?php
/**
 * Template Name: Thank You Template
 *
 * @package Armcodirect
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

$heading    = get_field( 'heading' );
$content    = get_field( 'content' );
$cta_button = get_field( 'cta_button' );

if ( ! empty( $heading ) || ! empty( $content ) || ! empty( $cta_button ) ) {
	?>
	<section class="thank-you-block">
		<div class="container">
			<div class="row justify-content-center">
				<div class="col-xl-6 col-lg-8 col-md-10 col-sm-8 col-12">
					<div class="title-wrap text-center">
						<?php
						if ( ! empty( $heading ) ) {
							?>
							<h2 class="title h-1">
								<?php
									echo sprintf( '%s', $heading );// phpcs:ignore
								?>
							</h2>
							<?php
						}
						if ( ! empty( $content ) ) {
							?>
							<span class="content">
								<?php
									echo sprintf( '%s', $content );// phpcs:ignore
								?>
							</span>
							<?php
						}
						?>
					</div>
				</div>
				<?php
				if ( $cta_button ) {
					$link_url    = ( isset( $cta_button['url'] ) && ! empty( $cta_button['url'] ) ) ? $cta_button['url'] : '';
					$link_title  = ( isset( $cta_button['title'] ) && ! empty( $cta_button['title'] ) ) ? $cta_button['title'] : '';
					$link_target = ( isset( $cta_button['target'] ) && ! empty( $cta_button['target'] ) ) ? $cta_button['url'] : '_self';
					if ( $link_url ) {
						?>
						<div class="col-12 d-flex justify-content-center mt-4">
							<a class="btn btn-big yellow-strip-btn" href="<?php echo esc_url( $link_url ); ?>" target="<?php echo esc_attr( $link_target ); ?>"><?php echo esc_html( $link_title ); ?></a>
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
