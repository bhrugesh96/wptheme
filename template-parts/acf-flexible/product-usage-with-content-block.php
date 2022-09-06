<?php
/**
 * Product usage with content block
 *
 * @package Armcodirect
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

$subtitle    = get_sub_field( 'subtitle' );
$page_title  = get_sub_field( 'title' );
$heading     = get_sub_field( 'heading' );
$description = get_sub_field( 'description' );
$cta_button  = get_sub_field( 'cta_button' );

if ( ! empty( $subtitle ) || ! empty( $page_title ) || ! empty( $heading ) || ! empty( $description ) || ! empty( $cta_button ) || have_rows( 'feature_box_obj' ) ) {
	?>
	<section class="product-usage-with-content-block">
		<div class="container">
			<div class="row align-items-end">
				<div class="col-xxl-8 col-xl-7 col-12 left-content">
					<?php
					if ( ! empty( $subtitle ) || ! empty( $page_title ) ) {
						?>
						<div class="title-wrap">
							<?php
							if ( ! empty( $subtitle ) ) {
								?>
								<span class="subtitle text-blue">
									<?php
										echo sprintf( '%s', $subtitle ); // phpcs:ignore
									?>
								</span>
								<?php
							}
							if ( ! empty( $page_title ) ) {
								?>
								<h2 class="title h-1">
									<?php
										echo sprintf( '%s', $page_title ); // phpcs:ignore
									?>
								</h2>
								<?php
							}
							?>
						</div>
						<?php
					}

					if ( have_rows( 'feature_box_obj' ) ) :
						echo '<div class="row feature-box-wrapper">';
						while ( have_rows( 'feature_box_obj' ) ) :
							the_row();
							$icon_id  = get_sub_field( 'icons' );
							$add_text = get_sub_field( 'add_text' );
							?>
							<div class="col-sm-3 col-6 mb-3">
								<div class="feature-box">
									<?php
									if ( ! empty( $icon_id ) ) {
										echo wp_get_attachment_image( $icon_id, 'full' );
									}

									if ( ! empty( $add_text ) ) {
										?>
										<strong class="text"><?php echo esc_html( $add_text ); ?></strong>
										<?php
									}
									?>
								</div>
							</div>
							<?php
						endwhile;
						echo '</div>';
					endif;
					?>
				</div>
				<div class="col-xxl-4 col-xl-5 col-12 right-content mb-3">
					<?php
					if ( ! empty( $heading ) || ! empty( $description ) || ! empty( $cta_button ) ) {
						?>
						<div class="content-box">
							<?php
							if ( ! empty( $heading ) ) {
								?>
								<h3 class="heading">
									<?php
										echo esc_html( $heading );
									?>
								</h3>
								<?php
							}
							echo $description; // phpcs:ignore
							if ( ! empty( $cta_button ) ) {
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
