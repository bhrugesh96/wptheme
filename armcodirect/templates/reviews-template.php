<?php
/**
 * Template Name: Reviews Template
 *
 * @package Armcodirect
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

get_template_part( 'template-parts/deafult-header-strip-block' );

$the_query = new WP_Query(
	array(
		'post_type'      => 'review',
		'post_status'    => 'publish',
		'posts_per_page' => -1,
	)
);
?>
<section class="reviews-listing-block">
	<div class="container">
		<?php
		if ( $the_query->have_posts() ) {
			?>
			<ul>
				<?php
				while ( $the_query->have_posts() ) {
					$the_query->the_post();
					$icon_id     = get_field( 'icon' );
					$designation = get_field( 'designation' );
					?>
					<li class="mb-4">
						<div class="testimonial-wrapper bg-gray">
							<?php
							echo wp_get_attachment_image( $icon_id, 'full' );
							if ( ! empty( get_the_content() ) ) {
								?>
								<h5 class="content">
									<?php
										echo sprintf( '%s', get_the_content() );// phpcs:ignore
									?>
								</h5>
								<?php
							}
							?>
							<strong class="name">
								<?php
								echo esc_html( get_the_title() );// phpcs:ignore
								if ( ! empty( $designation ) ) {
									echo '<span>' . esc_html( $designation ) . '</span>';
								}
								?>
							</strong>
						</div>
					</li>
					<?php
				}
				?>
			</ul>
			<?php
		} else {
			?>
			<div class="row">
				<?php
				get_template_part( 'template-parts/content', 'none' );
				?>
			</div>
			<?php
		}
		wp_reset_postdata();
		?>
	</div>
</section>
