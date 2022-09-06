<?php
/**
 * Template part for display landing page Header.
 *
 * @package Armcodirect
 */

$header_logo        = get_field( 'header_logo', 'option' );
$header_sticky_logo = get_field( 'header_sticky_logo', 'option' );
$phone_footer       = get_field( 'phone_footer', 'option' );
$cta_button_header  = get_field( 'cta_button_header', 'option' );
?>
<nav class="navbar navbar-expand-lg justify-content-between landing-header">
	<div class="col-auto">
		<a class="navbar-brand px-0 m-0" href="<?php echo esc_url( home_url( '/' ) ); ?>">
			<?php
			if ( ! empty( $header_logo ) || ! empty( $header_sticky_logo ) ) {
				echo wp_get_attachment_image( $header_logo, 'full', '', array( 'class' => 'default-logo' ) );
				echo wp_get_attachment_image( $header_sticky_logo, 'full', '', array( 'class' => 'alt-logo' ) );
			} else {
				?>
				<h1><?php echo esc_html( get_bloginfo( 'name' ) ); ?></h1>
				<?php
			}
			?>
		</a>
	</div>
	<div class="col-auto ms-auto d-flex">
	<?php
	if ( ! empty( $phone_footer ) ) {
		$phone_footer = esc_url( $phone_footer );
		?>
		<a class="phone h-4 mb-0" href="tel:<?php echo str_replace( " ", "", $phone_footer ); // phpcs:ignore ?>">
			<?php echo esc_html( $phone_footer ); ?>
		</a>
		<?php
	}
	?>
	</div>
	<div class="col-auto d-flex h-100">
		<?php
		if ( $cta_button_header ) {
			$link_url    = ( isset( $cta_button_header['url'] ) && ! empty( $cta_button_header['url'] ) ) ? $cta_button_header['url'] : '';
			$link_title  = ( isset( $cta_button_header['title'] ) && ! empty( $cta_button_header['title'] ) ) ? $cta_button_header['title'] : '';
			$link_target = ( isset( $cta_button_header['target'] ) && ! empty( $cta_button_header['target'] ) ) ? $cta_button_header['url'] : '_self';
			if ( $link_url ) {
				?>
				<a class="btn calculate-btn yellow-strip-btn" href="<?php echo esc_url( $link_url ); ?>" target="<?php echo esc_attr( $link_target ); ?>"><?php echo esc_html( $link_title ); ?></a>
				<?php
			}
		}
		?>
	</div>
</nav>
