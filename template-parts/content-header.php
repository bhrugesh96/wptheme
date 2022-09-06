<?php
/**
 * Template part for display Header.
 *
 * @package Armcodirect
 */

$header_logo        = get_field( 'header_logo', 'option' );
$header_sticky_logo = get_field( 'header_sticky_logo', 'option' );
$cta_button_header  = get_field( 'cta_button_header', 'option' );
?>
<nav class="navbar navbar-expand-lg justify-content-between">
	<div class="col-auto">
		<a class="navbar-brand px-0 m-0" href="<?php echo esc_url( home_url( '/' ) ); ?>">
			<h1 class="mb-0">
				<?php
				if ( ! empty( $header_logo ) || ! empty( $header_sticky_logo ) ) {
					echo wp_get_attachment_image( $header_logo, 'full', '', array( 'class' => 'default-logo' ) );
					echo wp_get_attachment_image( $header_sticky_logo, 'full', '', array( 'class' => 'alt-logo' ) );
				} else {
					?>
					<?php echo esc_html( get_bloginfo( 'name' ) ); ?>
					<?php
				}
				?>
			</h1>
		</a>
	</div>
	<div class="col-auto ms-auto d-flex">
		<button class="navbar-toggler collapsed my-auto" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-label="<?php echo esc_html__( 'Toggle navigation', 'armcodirect' ); ?>" aria-expanded="false">
			<span class="navbar-toggler-line"></span>
		</button>
		<div class="collapse navbar-collapse" id="navbarSupportedContent">
			<?php
			if ( has_nav_menu( 'menu-1' ) ) {
				wp_nav_menu(
					array(
						'theme_location' => 'menu-1',
						'menu'           => 'primary',
						'menu_class'     => 'navbar-nav navigation-links',
						'container'      => 'menu-container',
						'container_id'   => 'navbarNav',
						'fallback_cb'    => false,
						'walker'         => new Armcodirect_Mega_Menu_Walker(),
					),
				);
			} else {
				wp_nav_menu(
					array(
						'menu_class'   => 'navbar-nav',
						'menu'         => '',
						'container'    => 'menu-container',
						'container_id' => 'navbarNav',
					)
				);
			}
			?>
			<?php
			if ( $cta_button_header ) {
				$link_url    = ( isset( $cta_button_header['url'] ) && ! empty( $cta_button_header['url'] ) ) ? $cta_button_header['url'] : '';
				$link_title  = ( isset( $cta_button_header['title'] ) && ! empty( $cta_button_header['title'] ) ) ? $cta_button_header['title'] : '';
				$link_target = ( isset( $cta_button_header['target'] ) && ! empty( $cta_button_header['target'] ) ) ? $cta_button_header['url'] : '_self';
				if ( $link_url ) {
					?>
					<a class="btn calculate-btn blue-strip-btn" href="<?php echo esc_url( $link_url ); ?>" target="<?php echo esc_attr( $link_target ); ?>"><?php echo esc_html( $link_title ); ?></a>
					<?php
				}
			}
			?>
		</div>
		<?php
		if ( $cta_button_header ) {
			$link_url    = ( isset( $cta_button_header['url'] ) && ! empty( $cta_button_header['url'] ) ) ? $cta_button_header['url'] : '';
			$link_title  = ( isset( $cta_button_header['title'] ) && ! empty( $cta_button_header['title'] ) ) ? $cta_button_header['title'] : '';
			$link_target = ( isset( $cta_button_header['target'] ) && ! empty( $cta_button_header['target'] ) ) ? $cta_button_header['url'] : '_self';
			if ( $link_url ) {
				?>
				<a class="btn calculate-btn blue-strip-btn" href="<?php echo esc_url( $link_url ); ?>" target="<?php echo esc_attr( $link_target ); ?>"><?php echo esc_html( $link_title ); ?></a>
				<?php
			}
		}
		?>
	</div>
</nav>
