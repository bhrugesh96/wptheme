<?php
/**
 * FAQ Content with Image Block
 *
 * @package Armcodirect
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

$content_layout = get_sub_field( 'content_layout' );
$image_position = get_sub_field( 'image_position' );
$image          = get_sub_field( 'image' );
$subtitle       = get_sub_field( 'subtitle' );
$page_title     = get_sub_field( 'title' );
$cta_button     = get_sub_field( 'cta_button' );
$banner_url     = wp_get_attachment_image_url( $image, 'full' );
$banner_url     = ( ! empty( $banner_url ) ) ? ' style="background-image:url(' . esc_url( $banner_url ) . ')"' : '';
$image_position = ( 'left' === $image_position ) ? ' flex-md-row-reverse' : '';

$layout_class = '';
$column_class = ' col-md-7';
if ( 'full' === $content_layout ) {
	$layout_class = ' content-full';
	$column_class = ' col-12';
}

if ( ! empty( $image ) || ! empty( $subtitle ) || ! empty( $page_title ) || ! empty( $cta_button ) || have_rows( 'accordian_obj' ) ) {
	?>
	<section class="faq-content-with-image-block<?php echo esc_attr( $layout_class ); ?>">
		<div class="container-fluid">
			<div class="row<?php echo esc_attr( $image_position ); ?>">
				<div class="content-col<?php echo esc_attr( $column_class ); ?>">
					<div class="content-wrapper">
						<?php
						if ( ! empty( $subtitle ) ) {
							?>
							<span class="subtitle text-blue text-uppercase">
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
						if ( have_rows( 'accordian_obj' ) ) :
							global $accordion_unique_id;
							$accordion_unique_id = ! empty( $accordion_unique_id ) ? $accordion_unique_id : 1;
							$accordion_unique_id++;
							$counter = 1;
							echo '<div id="accordion-parent-' . $accordion_unique_id . '" class="accordian">'; // phpcs:ignore
							while ( have_rows( 'accordian_obj' ) ) :
								the_row();
								$accordion_heading_id = 'heading-' . $counter . '-' . $accordion_unique_id;
								$accordion_body_id    = 'collapse-' . $counter . '-' . $accordion_unique_id;
								$index                = get_sub_field( 'index' );
								$accordian_header     = get_sub_field( 'accordian_header' );
								$accordian_body       = get_sub_field( 'accordian_body' );
								?>
								<div class="accordion-item">
									<h3 class="accordion-header" id="<?php echo esc_attr( $accordion_heading_id ); ?>">
										<button class="accordion-button h-4<?php echo ( 1 === $counter ) ? '' : ' collapsed'; ?>" type="button" data-bs-toggle="collapse" data-bs-target="#<?php echo esc_attr( $accordion_body_id ); ?>" aria-expanded="<?php echo ( 1 === $counter ) ? 'true' : 'false'; ?>" aria-controls="<?php echo esc_attr( $accordion_body_id ); ?>">
											<?php
											if ( $index ) {
												echo '<span class="index">' . esc_html( $index ) . '</span>';
											}
											echo esc_html( $accordian_header );
											?>
										</button>
									</h3>
									<div id="<?php echo esc_attr( $accordion_body_id ); ?>" class="accordion-collapse collapse<?php echo ( 1 === $counter ) ? ' show' : ''; ?>" aria-labelledby="<?php echo esc_attr( $accordion_heading_id ); ?>" data-bs-parent="#accordion-parent-<?php echo esc_attr( $accordion_unique_id ); ?>">
										<div class="accordion-body">
											<?php echo sprintf( '%s', $accordian_body ); // phpcs:ignore ?>
										</div>
									</div>
								</div>
								<?php
								$counter++;
							endwhile;
							echo '</div>';
						endif;
						if ( ! empty( $cta_button ) ) {
							$link_url    = ( isset( $cta_button['url'] ) && ! empty( $cta_button['url'] ) ) ? $cta_button['url'] : '';
							$link_title  = ( isset( $cta_button['title'] ) && ! empty( $cta_button['title'] ) ) ? $cta_button['title'] : '';
							$link_target = ( isset( $cta_button['target'] ) && ! empty( $cta_button['target'] ) ) ? $cta_button['url'] : '_self';

							if ( $link_url ) {
								if ( 'full' === $content_layout ) {
									echo '<div class="text-center">';
								}
								?>
									<a class="btn btn-blue mt-3" href="<?php echo esc_url( $link_url ); ?>" target="<?php echo esc_attr( $link_target ); ?>"><?php echo esc_html( $link_title ); ?></a>
								<?php
								if ( 'full' === $content_layout ) {
									echo '</div>';
								}
							}
						}
						?>
					</div>
				</div>
				<?php
				if ( 'default' === $content_layout ) {
					?>
					<div class="bg-col col-md-5"<?php echo $banner_url; // phpcs:ignore ?>></div>
					<?php
				}
				?>
			</div>
		</div>
	</section>
	<?php
}
