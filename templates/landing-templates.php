<?php
/**
 * Template Name: Landing Template
 *
 * @package Armcodirect
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

$main_title  = get_field( 'main_title' );
$add_title   = get_field( 'title' );
$add_content = get_field( 'add_content' );
$cta_button  = get_field( 'cta' );

if ( ! empty( $main_title ) || have_rows( 'usp_block' ) || ! empty( $add_title ) || ! empty( $add_content ) || ! empty( $cta_button ) ) {
	?>
	<section class="product-usage-with-content-block landing-block">
		<div class="container">
			<div class="row align-items-center justify-content-between">
				<div class="col-xxl-6 col-lg-7 col-12 left-content">
					<?php
					if ( ! empty( $main_title ) ) {
						?>
						<div class="title-wrap">
							<h2 class="title h-1">
								<?php
									echo sprintf( '%s', $main_title );// phpcs:ignore
								?>
							</h2>
						</div>
						<?php
					}

					if ( have_rows( 'usp_block' ) ) :
						?>
						<div class="row feature-box-wrapper">
							<?php
							while ( have_rows( 'usp_block' ) ) :
								the_row();
								$icon_id           = get_sub_field( 'icon_field' );
								$title_field       = get_sub_field( 'title_field' );
								$description_field = get_sub_field( 'description_field' );

								if ( ! empty( $icon_id ) || ! empty( $title_field ) || ! empty( $description_field ) ) {
									?>
									<div class="col-sm-6 col-12 mb-3">
										<div class="feature-box">
											<?php echo wp_get_attachment_image( $icon_id, 'full' ); ?>
											<?php
											if ( ! empty( $title_field ) || ! empty( $description_field ) ) {
												?>
												<div class="content">
													<?php
													if ( ! empty( $title_field ) ) {
														?>
														<strong class="title">
															<?php
																echo esc_html( $title_field );
															?>
														</strong>
														<?php
													}
													if ( ! empty( $description_field ) ) {
														?>
														<p>
															<?php
																echo sprintf( '%s', $description_field );// phpcs:ignore
															?>
														</p>
														<?php
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
							?>
						</div>
						<?php
					endif;
					?>
				</div>
				<div class="col-xxl-4 col-lg-5 col-12 right-content mb-3">
					<?php
					if ( ! empty( $add_title ) || ! empty( $add_content ) || ! empty( $cta_button ) ) {
						?>
						<div class="content-box">
							<img class="arrow-icon" src="<?php echo ARMCODIRECT_THEME_URI;// phpcs:ignore ?>/inc/assets/arrow-1.png" alt="" />
							<?php
							if ( ! empty( $add_title ) ) {
								?>
								<h3 class="heading">
									<?php
										echo sprintf( '%s', $add_title ); // phpcs:ignore
									?>
								</h3>
								<?php
							}
							if ( ! empty( $add_content ) ) {
								?>
								<div class="content-right">
									<?php
										echo sprintf( '%s', $add_content ); // phpcs:ignore
									?>
								</div>
								<?php
							}
							if ( $cta_button ) {
								$link_url    = ( isset( $cta_button['url'] ) && ! empty( $cta_button['url'] ) ) ? $cta_button['url'] : '';
								$link_title  = ( isset( $cta_button['title'] ) && ! empty( $cta_button['title'] ) ) ? $cta_button['title'] : '';
								$link_target = ( isset( $cta_button['target'] ) && ! empty( $cta_button['target'] ) ) ? $cta_button['url'] : '_self';
								if ( $link_url ) {
									?>
									<a class="btn yellow-strip-btn" href="<?php echo esc_url( $link_url ); ?>" target="<?php echo esc_attr( $link_target ); ?>"><?php echo esc_html( $link_title ); ?></a>
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
		</div>
	</section>
	<?php
}

get_template_part( 'template-parts/content', 'page' );
