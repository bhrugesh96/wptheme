<?php
/**
 * Template part for display Footer.
 *
 * @package Armcodirect
 */

?>
<footer id="footer">
	<?php
	$subtitle_footer      = get_field( 'subtitle_footer', 'option' );
	$title_footer         = get_field( 'title_footer', 'option' );
	$description_footer   = get_field( 'description_footer', 'option' );
	$phone_footer         = get_field( 'phone_footer', 'option' );
	$email_address_footer = get_field( 'email_address_footer', 'option' );
	if ( ! empty( $subtitle_footer ) || ! empty( $title_footer ) || ! empty( $description_footer ) || ! empty( $phone_footer ) || ! empty( $email_address_footer ) ) {
		?>
		<div class="footer-top">
			<div class="container">
				<div class="row">
					<div class="col-lg-5">
						<?php
						if ( ! empty( $subtitle_footer ) ) {
							?>
							<div class="subtitle">
								<?php echo esc_html( $subtitle_footer ); ?>
							</div>
							<?php
						}
						if ( ! empty( $title_footer ) ) {
							?>
							<h2 class="title h-1">
								<?php echo esc_html( $title_footer ); ?>
							</h2>
							<?php
						}
						if ( ! empty( $description_footer ) ) {
							?>
							<div class="description">
								<?php echo sprintf( '%s', $description_footer );// phpcs:ignore ?>
							</div>
							<?php
						}
						if ( ! empty( $phone_footer ) || ! empty( $email_address_footer ) ) {
							?>
							<div class="contact-details">
								<?php
								if ( ! empty( $phone_footer ) ) {
									?>
									<a class="phone h-4" href="tel:<?php echo str_replace( " ", "", $phone_footer );// phpcs:ignore ?>">
										<?php echo esc_html( $phone_footer ); ?>
									</a>
									<?php
								}
								if ( ! empty( $email_address_footer ) ) {
									?>
									<a class="email h-4" href="mailto:<?php echo $email_address_footer;// phpcs:ignore ?>">
										<?php echo esc_html( $email_address_footer ); ?>
									</a>
									<?php
								}
								?>
							</div>
							<?php
						}
						?>
					</div>
				</div>
			</div>
		</div>
		<?php
	}
	$header_logo              = get_field( 'header_logo', 'option' );
	$contactform_shortcode_id = get_field( 'contactform_shortcode', 'option' );

	if ( $header_logo || $contactform_shortcode_id || is_active_sidebar( 'footer-column-1' ) || is_active_sidebar( 'footer-column-2' ) || is_active_sidebar( 'footer-column-3' ) ) {
		?>
		<div class="footer-bottom">
			<div class="container">
				<?php
				if ( $header_logo ) {
					?>
					<div class="row row-cols-1 footer-logo">
						<?php echo wp_get_attachment_image( $header_logo, 'full' ); ?>
					</div>
					<?php
				}
				?>
				<div class="row">
					<div class="col-xxl-6 col-lg-7 col-12 order-2 order-lg-1">
						<div class="row row-cols-1 row-cols-lg-2 row-cols-xl-3">
							<?php
							if ( is_active_sidebar( 'footer-column-1' ) ) {
								?>
								<div class="col mb-4 mb-md-0">
									<?php dynamic_sidebar( 'footer-column-1' ); ?>
								</div>
								<?php
							}
							if ( is_active_sidebar( 'footer-column-2' ) ) {
								?>
								<div class="col mb-4 mb-md-0">
									<?php dynamic_sidebar( 'footer-column-2' ); ?>
								</div>
								<?php
							}
							if ( is_active_sidebar( 'footer-column-3' ) ) {
								?>
								<div class="col mb-4 mb-md-0">
									<?php dynamic_sidebar( 'footer-column-3' ); ?>
								</div>
								<?php
							}
							?>
						</div>
					</div>
					<div class="col-lg-5 offset-xxl-1 order-1 order-lg-2 mb-4 mb-lg-0">
						<?php
						if ( ! empty( $contactform_shortcode_id ) ) {
							$contactform_shortcode = '[contact-form-7 id="' . $contactform_shortcode_id . '"]';
							?>
							<div class="contact-form-wrap">
								<?php echo do_shortcode( $contactform_shortcode ); ?>
							</div>
							<?php
						}
						?>
					</div>
				</div>
				<div class="row justify-content-start mt-0 mt-md-5">
					<div class="col-auto">
						<span class="credit-text"><?php echo esc_html__( 'Website designed by' ); ?> <a href="#" target="_blank"><b><?php echo esc_html__( 'Self' ); ?></b></a></span>
					</div>
				</div>
			</div>
		</div>
		<?php
	}
	?>
</footer>
