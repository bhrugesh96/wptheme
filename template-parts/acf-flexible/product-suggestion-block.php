<?php
/**
 * Product suggestion block
 *
 * @package Armcodirect
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

$subtitle      = get_sub_field( 'subtitle' );
$page_title    = get_sub_field( 'title' );
$cta_button    = get_sub_field( 'cta_button' );
$cta_alignment = get_sub_field( 'cta_alignment' );
$button_color  = get_sub_field( 'button_color' );
$terms         = get_sub_field( 'category_obj' );
$button_color  = ( ! empty( $button_color ) ) ? ' ' . $button_color . '-strip-btn' : ' blue-strip-btn';

$cta_alignment_class = '';
switch ( $cta_alignment ) {
	case 'text-start':
		$cta_alignment_class .= ' justify-content-start text-start';
		break;
	case 'text-end':
		$cta_alignment_class .= ' justify-content-end text-end';
		break;
	case 'text-center':
		$cta_alignment_class .= ' justify-content-center text-center';
		break;
}


if ( ! empty( $subtitle ) || ! empty( $page_title ) || ! empty( $terms ) || ! empty( $cta_button ) ) {
	?>
	<section class="product-category-grid-block product-suggestion-block">
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
								<span class="subtitle text-blue">
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

			if ( ! empty( $terms ) ) :
				?>
				<div class="row product-grid-wrapper gx-0">
					<?php
					foreach ( $terms as $term_val ) :
						$the_query = new WP_Query(
							array(
								'post_type' => 'products',
								'tax_query' => array(
									array(
										'taxonomy' => 'product-category',
										'field'    => 'id',
										'terms'    => $term_val->term_id,
									),
								),
							),
						);
						$count         = $the_query->found_posts;
						$product_label = ( 1 === $count ) ? esc_html__( 'Product', 'armcodirect' ) : esc_html__( 'Products', 'armcodirect' );
						$thumbnail_id  = get_field( 'category_image_tax', $term_val );
						if ( $count > 0 ) {
							?>
							<div class="col-md-4 col-sm-6 col-12 category-item">
								<a href="<?php echo esc_url( get_term_link( $term_val ) ); ?>"><h3 class="title h-2"><?php echo esc_html( $term_val->name ); ?></h3></a>
								<span class="count">
									<?php
									echo sprintf( '%1$s&nbsp;%2$s', esc_html( $count ), esc_html( $product_label ) ) . '';
									?>
								</span>
								<div class="product-img text-center d-flex align-items-center justify-content-center">
									<a href="<?php echo esc_url( get_term_link( $term_val ) ); ?>">
										<?php
										if ( ! empty( $thumbnail_id ) ) {
											echo wp_get_attachment_image( $thumbnail_id, 'full' );
										} else {
											?>
											<img src="<?php echo ARMCODIRECT_THEME_URI;// phpcs:ignore ?>/inc/assets/small-placeholder.jpg" alt="" />
											<?php
										}
										?>
									</a>
								</div>
							</div>
							<?php
						}
					endforeach;
					?>
				</div>
				<?php
			endif;
			if ( ! empty( $cta_button ) ) {
				echo '<div class="row' . esc_attr( $cta_alignment_class ) . '">';
				echo '<div class="col-auto mt-5">';
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
	</section>
	<?php
}
