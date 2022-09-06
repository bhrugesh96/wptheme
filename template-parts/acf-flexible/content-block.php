<?php
/**
 * Dispaly Content Block.
 *
 * @package Armcodirect
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

$column_layout      = get_sub_field( 'column_layout' );
$alignment          = get_sub_field( 'alignment' );
$bg_pattern         = get_sub_field( 'background_pattern' );
$page_title         = get_sub_field( 'title' );
$title_text_color   = get_sub_field( 'title_text_color' );
$content_first      = get_sub_field( 'content_first' );
$content_second     = get_sub_field( 'content_second' );
$content_text_color = get_sub_field( 'content_text_color' );
$cta_button         = get_sub_field( 'cta_button' );
$button_color       = get_sub_field( 'button_color' );
$title_text_style   = ( ! empty( $title_text_color ) ) ? ' style="color:' . esc_attr( $title_text_color ) . '"' : '';
$content_text_style = ( ! empty( $content_text_color ) ) ? ' style="color:' . esc_attr( $content_text_color ) . '"' : '';
$button_color       = ( $button_color ) ? ' ' . $button_color . '-strip-btn' : ' blue-strip-btn';
$container_column   = ( '1' === $column_layout ) ? 'col-lg-6 col-12' : 'col-12';

$alignment_class = '';
if ( '1' === $column_layout ) {
	switch ( $alignment ) {
		case 'center':
			$alignment_class = ' justify-content-center';
			break;
		case 'right':
			$alignment_class = ' justify-content-end';
			break;
		default:
			$alignment_class = ' justify-content-start text-start';
			break;
	}
} else {
	$alignment_class = ' justify-content-center';
}

if ( ! empty( $page_title ) || ! empty( $content_first ) || ! empty( $content_second ) || ! empty( $cta_button ) ) {
	?>
	<section class="content-block <?php echo esc_attr( $bg_pattern ); ?>">
		<div class="container">
			<div class="row <?php echo esc_attr( $alignment_class ); ?>">
				<div class="<?php echo esc_attr( $container_column ); ?>">
				<?php
				if ( ! empty( $page_title ) ) {
						echo '<div class="row">';
						echo '<div class="col-12">';
					?>
						<h2 class="title"<?php echo $title_text_style;// phpcs:ignore ?>>
							<?php
								echo sprintf( '%s', $page_title );// phpcs:ignore
							?>
						</h2>
						<?php
						echo '</div>';
						echo '</div>';
				}
				?>
				<div class="row content-row mb-md-5 mb-3<?php echo esc_attr( $alignment_class ); ?>">
					<div class="col mb-lg-0 mb-3"<?php echo $content_text_style;// phpcs:ignore ?>>
						<?php
						if ( ! empty( $content_first ) ) {
							?>
							<div class="content-left">
								<?php
									echo sprintf( '%s', $content_first );// phpcs:ignore
								?>
							</div>
							<?php
						}
						?>
					</div>
					<?php
					if ( '2' === $column_layout ) {
						?>
						<div class="col"<?php echo $content_text_style;// phpcs:ignore ?>>
							<?php
							if ( ! empty( $content_second ) ) {
								?>
								<div class="content-right">
									<?php
										echo sprintf( '%s', $content_second );// phpcs:ignore
									?>
								</div>
								<?php
							}
							?>
						</div>
						<?php
					}
					?>
				</div>
				<?php
				if ( ! empty( $cta_button ) ) {
					echo '<div class="row ' . esc_attr( $alignment_class ) . '">';
					echo '<div class="col-auto">';
					$link_url    = ( isset( $cta_button['url'] ) && ! empty( $cta_button['url'] ) ) ? $cta_button['url'] : '';
					$link_title  = ( isset( $cta_button['title'] ) && ! empty( $cta_button['title'] ) ) ? $cta_button['title'] : '';
					$link_target = ( isset( $cta_button['target'] ) && ! empty( $cta_button['target'] ) ) ? $cta_button['url'] : '_self';
					if ( $link_url ) {
						?>
						<a class="btn btn-big<?php echo esc_attr( $button_color ); ?>" href="<?php echo esc_url( $link_url ); ?>" target="<?php echo esc_attr( $link_target ); ?>"><?php echo esc_html( $link_title ); ?></a>
						<?php
					}
					echo '</div>';
					echo '</div>';
				}
				?>
				</div>
			</div>
		</div>
	</section>
	<?php
}
