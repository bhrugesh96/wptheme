<?php
/**
 * Product usage block
 *
 * @package Armcodirect
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
$subtitle   = get_sub_field( 'subtitle' );
$page_title = get_sub_field( 'title' );

if ( ! empty( $subtitle ) || ! empty( $page_title ) || have_rows( 'content_cards_obj' ) ) {
	?>
	<section class="product-usage-block">
		<div class="container">
			<?php
			if ( ! empty( $subtitle ) || ! empty( $page_title ) ) {
				?>
				<div class="row">
					<div class="col-12">
						<div class="title-wrap">
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
				<?php
			}
			if ( have_rows( 'content_cards_obj' ) ) :
				echo '<div class="row product-grid">';
				while ( have_rows( 'content_cards_obj' ) ) :
					the_row();
					$layout_style = get_sub_field( 'layout_style' );
					$icon_id      = get_sub_field( 'icon' );
					$add_title    = get_sub_field( 'add_title' );
					$content      = get_sub_field( 'content' );
					$cta_button   = get_sub_field( 'cta_button' );

					if ( ! empty( $icon_id ) || ! empty( $add_title ) || ! empty( $content ) || ! empty( $cta_button ) ) {
						?>
						<div class="col mb-3">
							<div class="card-box style-<?php echo esc_attr( $layout_style ); ?>">
								<?php
								if ( ! empty( $icon_id ) || ! empty( $add_title ) ) {
									?>
									<div class="card-top">
										<?php
										if ( ! empty( $icon_id ) ) {
											echo wp_get_attachment_image( $icon_id, 'thumbnail', '', array( 'class' => 'card-icon' ) );
										}
										if ( ! empty( $add_title ) ) {
											?>
											<h4 class="card-title">
												<?php
													echo sprintf( '%s', $add_title );// phpcs:ignore
												?>
											</h4>
											<?php
										}
										?>
									</div>
									<?php
								}

								if ( ! empty( $content ) || ! empty( $cta_button ) ) {
									?>
									<div class="card-bottom">
										<?php
										if ( ! empty( $content ) ) {
											?>
											<p class="card-content">
												<?php
													echo esc_html( $content );
												?>
											</p>
											<?php
										}
										if ( $cta_button ) {
											$link_url    = ( isset( $cta_button['url'] ) && ! empty( $cta_button['url'] ) ) ? $cta_button['url'] : '';
											$link_title  = ( isset( $cta_button['title'] ) && ! empty( $cta_button['title'] ) ) ? $cta_button['title'] : '';
											$link_target = ( isset( $cta_button['target'] ) && ! empty( $cta_button['target'] ) ) ? $cta_button['url'] : '_self';
											if ( $link_url ) {
												?>
												<a class="btn btn-blue" href="<?php echo esc_url( $link_url ); ?>" target="<?php echo esc_attr( $link_target ); ?>"><?php echo esc_html( $link_title ); ?></a>
												<?php
											}
										}
										?>
									</div>
									<?php
								}
								?>
							</div>
						</div>
						<?php
					}
				endwhile;
				echo '</div>';
			endif;
			?>
		</div>
	</section>
	<?php
}
