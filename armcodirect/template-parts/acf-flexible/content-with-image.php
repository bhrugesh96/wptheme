<?php
/**
 * Content with Image Block
 *
 * @package Armcodirect
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

$image_position     = get_sub_field( 'image_position' );
$background_color   = get_sub_field( 'background_color' );
$image              = get_sub_field( 'image' );
$description        = get_sub_field( 'description' );
$subtitle           = get_sub_field( 'subtitle' );
$page_title         = get_sub_field( 'title' );
$heading_font_color = get_sub_field( 'heading_font_color' );
$content            = get_sub_field( 'content' );
$phone_number       = get_sub_field( 'phone_number' );
$email_address      = get_sub_field( 'email_address' );
$cta_button         = get_sub_field( 'cta_button' );

$banner_url             = wp_get_attachment_image_url( $image, 'full' );
$banner_url             = ( ! empty( $banner_url ) ) ? ' style="background-image:url(' . esc_url( $banner_url ) . ')"' : '';
$background_color_class = ( ! empty( $background_color ) ) ? ' bg-' . $background_color : ' bg-white';
$text_color_class       = ( ! empty( $heading_font_color ) ) ? ' heading-text-' . $heading_font_color : ' heading-text-white';
$image_position         = ( 'left' === $image_position ) ? ' flex-md-row-reverse' : '';

if ( ! empty( $subtitle ) || ! empty( $page_title ) || ! empty( $content ) || have_rows( 'usp_block' ) ) {
	?>
	<section class="content-with-image-block<?php echo esc_attr( $background_color_class ); ?>">
		<div class="container-fluid">
			<div class="row justify-content-end<?php echo esc_attr( $image_position ); ?>">
				<div class="col-md-6 content-col">
					<div class="content-wrapper">
						<?php
						if ( ! empty( $subtitle ) ) {
							?>
							<span class="subtitle">
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
						if ( ! empty( $content ) ) {
							?>
							<div class="description<?php echo esc_attr( $text_color_class ); ?>">
								<?php
									echo sprintf( '%s', $content );// phpcs:ignore
								?>
							</div>
							<?php
						}
						if ( ! empty( $phone_number ) || ! empty( $email_address ) ) {
							?>
							<div class="contact-details">
								<?php
								if ( ! empty( $phone_number ) ) {
									?>
									<a class="phone h-4" href="tel:<?php echo str_replace( " ", "", $phone_number );// phpcs:ignore ?>">
										<?php echo esc_html( $phone_number ); ?>
									</a>
									<?php
								}
								if ( ! empty( $email_address ) ) {
									?>
									<a class="email h-4" href="mailto:<?php echo $email_address;// phpcs:ignore ?>">
										<?php echo esc_html( $email_address ); ?>
									</a>
									<?php
								}
								?>
							</div>
							<?php
						}
						if ( have_rows( 'usp_block' ) ) :
							echo '<ul class="usp-list">';
							while ( have_rows( 'usp_block' ) ) :
								the_row();
								$text_field = get_sub_field( 'text_field' );
								echo '<li>' . esc_html( $text_field ) . '</li>';
							endwhile;
							echo '</ul>';
						endif;
						if ( $cta_button ) {
							$link_url    = ( isset( $cta_button['url'] ) && ! empty( $cta_button['url'] ) ) ? $cta_button['url'] : '';
							$link_title  = ( isset( $cta_button['title'] ) && ! empty( $cta_button['title'] ) ) ? $cta_button['title'] : '';
							$link_target = ( isset( $cta_button['target'] ) && ! empty( $cta_button['target'] ) ) ? $cta_button['url'] : '_self';
							if ( $link_url ) {
								?>
								<a class="btn btn-blue btn-medium" href="<?php echo esc_url( $link_url ); ?>" target="<?php echo esc_attr( $link_target ); ?>"><?php echo esc_html( $link_title ); ?></a>
								<?php
							}
						}
						?>
					</div>
				</div>
				<div class="col-md-6 bg-col"<?php echo $banner_url;// phpcs:ignore ?>></div>
			</div>
		</div>
	</section>
	<?php
}
