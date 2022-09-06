<?php
/**
 * Quote CTA Block
 *
 * @package Armcodirect
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

$bg_pattern = get_sub_field( 'background_pattern' );
$page_title = get_sub_field( 'title' );
$content    = get_sub_field( 'content' );
$button     = get_sub_field( 'button' );

if ( ! empty( $page_title ) || ! empty( $content ) || ! empty( $button ) ) {
	?>
	<section class="quote-cta-block <?php echo esc_attr( $bg_pattern ); ?>">
		<div class="container">
			<div class="row justify-content-between align-items-center">
				<div class="col-md-7">
				<?php
				if ( ! empty( $page_title ) ) {
					echo '<h2 class="title">';
						echo sprintf( '%s', $page_title ); // phpcs:ignore
					echo '</h2>';
				}
				if ( ! empty( $content ) ) {
					?>
					<div class="description">
						<?php
							echo sprintf( '%s', $content ); // phpcs:ignore
						?>
					</div>
					<?php
				}
				?>
				</div>
				<div class="col-lg-auto col-md-5 col-auto">
				<?php
				if ( ! empty( $button ) ) {
					$link_url    = ( isset( $button['url'] ) && ! empty( $button['url'] ) ) ? $button['url'] : '';
					$link_title  = ( isset( $button['title'] ) && ! empty( $button['title'] ) ) ? $button['title'] : '';
					$link_target = ( isset( $button['target'] ) && ! empty( $button['target'] ) ) ? $button['url'] : '_self';
					if ( $link_url ) {
						?>
						<a class="btn yellow-strip-btn btn-big" href="<?php echo esc_url( $link_url ); ?>" target="<?php echo esc_attr( $link_target ); ?>"><?php echo esc_html( $link_title ); ?></a>
						<?php
					}
				}
				?>
				</div>
			</div>
		</div>
	</section>
	<?php
}
