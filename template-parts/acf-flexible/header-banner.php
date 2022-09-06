<?php
/**
 * Header Banner
 *
 * @package Armcodirect
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

$breadcrumb          = get_sub_field( 'breadcrumb' );
$breadcrumb_text     = get_sub_field( 'breadcrumb_text' );
$header_banner_image = get_sub_field( 'image' );
$page_title          = get_sub_field( 'title' );
$description         = get_sub_field( 'description' );
$primary_button      = get_sub_field( 'primary_button' );
$secondary_button    = get_sub_field( 'secondary_button' );
$header_banner_url   = wp_get_attachment_image_url( $header_banner_image, 'full' );
$header_banner_url   = ( ! empty( $header_banner_url ) ) ? ' style="background-image:url(' . esc_url( $header_banner_url ) . ')"' : '';

if ( ! empty( $header_banner_url ) || ! empty( $page_title ) || ! empty( $description ) || ! empty( $primary_button ) || ! empty( $secondary_button ) || have_rows( 'usp_block' ) || $breadcrumb ) {
	?>
	<section class="header-banner-block">
		<div class="container-fluid">
			<div class="row">
				<div class="col-md-7 content-col">
					<div class="content-wrapper">
						<?php
						if ( $breadcrumb && function_exists( 'armcodirect_breadcrumb_display' ) ) {
							?>
							<ul class="breadcrumb-wrap" itemscope itemtype="https://schema.org/BreadcrumbList">
								<?php echo armcodirect_breadcrumb_display();// phpcs:ignore ?>
							</ul>
							<?php
						}
						if ( ! empty( $page_title ) ) {
							?>
							<h2 class="title">
								<?php echo sprintf( '%s', $page_title );// phpcs:ignore ?>
							</h2>
							<?php
						}
						if ( ! empty( $description ) ) {
							?>
								<?php echo sprintf( '%s', $description );// phpcs:ignore ?>
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
						if ( ! empty( $primary_button ) || ! empty( $secondary_button ) ) {
							?>
							<div class="btn-wrapper d-flex flex-wrap">
								<?php
								if ( ! empty( $primary_button ) ) {
									$primary_link_url    = ( isset( $primary_button['url'] ) && ! empty( $primary_button['url'] ) ) ? $primary_button['url'] : '';
									$primary_link_title  = ( isset( $primary_button['title'] ) && ! empty( $primary_button['title'] ) ) ? $primary_button['title'] : '';
									$primary_link_target = ( isset( $primary_button['target'] ) && ! empty( $primary_button['target'] ) ) ? $primary_button['url'] : '_self';
									if ( $primary_link_url ) {
										?>
										<a class="btn yellow-strip-btn btn-big mb-2" href="<?php echo esc_url( $primary_link_url ); ?>" target="<?php echo esc_attr( $primary_link_target ); ?>"><?php echo esc_html( $primary_link_title ); ?></a>
										<?php
									}
								}
								if ( ! empty( $secondary_button ) ) {
									$secondary_link_url    = ( isset( $secondary_button['url'] ) && ! empty( $secondary_button['url'] ) ) ? $secondary_button['url'] : '';
									$secondary_link_title  = ( isset( $secondary_button['title'] ) && ! empty( $secondary_button['title'] ) ) ? $secondary_button['title'] : '';
									$secondary_link_target = ( isset( $secondary_button['target'] ) && ! empty( $secondary_button['target'] ) ) ? $secondary_button['url'] : '_self';
									if ( $secondary_link_url ) {
										?>
										<a class="btn secondary-button white-transparent-btn d-flex align-items-center justify-content-center mb-2" href="<?php echo esc_url( $secondary_link_url ); ?>" target="<?php echo esc_attr( $secondary_link_target ); ?>"><?php echo esc_html( $secondary_link_title ); ?></a>
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
				<div class="col-md-5 bg-col"<?php echo $header_banner_url; // phpcs:ignore ?>></div>
			</div>
		</div>
	</section>
	<?php
}
