<?php
/**
 * USP Content Block
 *
 * @package Armcodirect
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

$bg_pattern    = get_sub_field( 'background_pattern' );
$subtitle      = get_sub_field( 'subtitle' );
$page_title    = get_sub_field( 'title' );
$content_field = get_sub_field( 'content_field' );
$cta_button    = get_sub_field( 'cta_button' );

if ( ! empty( $subtitle ) || ! empty( $page_title ) || have_rows( 'usp_block_obj' ) ) {
	?>
	<section class="usp-content-block <?php echo esc_attr( $bg_pattern ); ?>">
		<div class="container">
			<div class="row justify-content-center">
				<div class="col-lg-8 col-12 text-center">
					<?php
					if ( ! empty( $subtitle ) ) {
						?>
						<span class="subtitle text-blue">
							<?php
								echo esc_html( $subtitle );
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
					if ( ! empty( $content_field ) ) {
						?>
						<div class="content">
							<?php
								echo sprintf( '%s', $content_field );// phpcs:ignore
							?>
						</div>
						<?php
					}
					?>
				</div>
			</div>
			<?php
			if ( have_rows( 'usp_block_obj' ) ) :
				echo '<div class="row row-cols-1 row-cols-xxl-5 row-cols-lg-3 row-cols-md-2 justify-content-center">';
				while ( have_rows( 'usp_block_obj' ) ) :
					the_row();
					$icon_id     = get_sub_field( 'icon' );
					$heading     = get_sub_field( 'heading' );
					$description = get_sub_field( 'description' );
					echo '<div class="col d-flex mb-3">';
					echo '<div class="usp-wrapper">';
					echo wp_get_attachment_image( $icon_id );
					if ( ! empty( $heading ) ) {
						?>
						<h4 class="heading">
							<?php
								echo esc_html( $heading );
							?>
						</h4>
						<?php
					}
					if ( ! empty( $description ) ) {
						?>
						<p>
							<?php
								echo esc_html( $description );
							?>
						</p>
						<?php
					}
					echo '</div>';
					echo '</div>';
				endwhile;
				echo '</div>';
			endif;
			if ( $cta_button ) {
				$link_url    = ( isset( $cta_button['url'] ) && ! empty( $cta_button['url'] ) ) ? $cta_button['url'] : '';
				$link_title  = ( isset( $cta_button['title'] ) && ! empty( $cta_button['title'] ) ) ? $cta_button['title'] : '';
				$link_target = ( isset( $cta_button['target'] ) && ! empty( $cta_button['target'] ) ) ? $cta_button['url'] : '_self';
				if ( $link_url ) {
					?>
					<div class="row justify-content-center">
						<div class="col-auto btn-wrapper">
							<a class="btn btn-big yellow-strip-btn" href="<?php echo esc_url( $link_url ); ?>" target="<?php echo esc_attr( $link_target ); ?>"><?php echo esc_html( $link_title ); ?></a>
						</div>
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
