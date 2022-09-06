<?php
/**
 * Blog listing block
 *
 * @package Armcodirect
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

$subtitle         = get_sub_field( 'subtitle' );
$page_title       = get_sub_field( 'title' );
$viw_all_button   = get_sub_field( 'viw_all_button' );
$read_more_button = get_sub_field( 'read_more_button' );
$read_more_button = ( ! empty( $read_more_button ) ) ? $read_more_button : __( 'Read more', 'armcodirect' );

$args = array(
	'posts_per_page'      => 5,
	'post_status'         => 'publish',
	'ignore_sticky_posts' => 1,
);

$the_query = new WP_Query( $args );
$totalpost = $the_query->post_count;

if ( ! empty( $subtitle ) || ! empty( $page_title ) || ! empty( $viw_all_button ) || $the_query->have_posts() ) {
	?>
	<section class="blog-listing-block">
		<div class="container">
			<?php
			if ( ! empty( $subtitle ) || ! empty( $page_title ) || ! empty( $viw_all_button ) ) {
				?>
				<div class="row justify-content-between align-items-center mb-lg-5 mb-3">
					<div class="col-auto">
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
					<div class="col-auto">
						<?php
						if ( $viw_all_button ) {
							$link_url    = ( isset( $viw_all_button['url'] ) && ! empty( $viw_all_button['url'] ) ) ? $viw_all_button['url'] : '';
							$link_title  = ( isset( $viw_all_button['title'] ) && ! empty( $viw_all_button['title'] ) ) ? $viw_all_button['title'] : '';
							$link_target = ( isset( $viw_all_button['target'] ) && ! empty( $viw_all_button['target'] ) ) ? $viw_all_button['url'] : '_self';
							if ( $link_url ) {
								?>
								<a class="btn btn-transparent-blue" href="<?php echo esc_url( $link_url ); ?>" target="<?php echo esc_attr( $link_target ); ?>"><?php echo esc_html( $link_title ); ?></a>
								<?php
							}
						}
						?>
					</div>
				</div>
				<?php
			}
			if ( $the_query->have_posts() ) {
				?>
				<div class="row">
				<?php
				$counter = 1;
				while ( $the_query->have_posts() ) {
					$the_query->the_post();
					if ( 1 === $counter ) {
						?>
						<div class="col-md-6 mb-3">
							<div class="big-post">
								<?php
								if ( has_post_thumbnail() ) :
									?>
									<div class="post-thumb">
										<a href="<?php the_permalink(); ?>">
											<?php the_post_thumbnail(); ?>
										</a>
									</div>
									<?php
								endif;
								?>
								<div class="post-content-wrapper">
									<?php
									get_template_part( 'template-parts/post/entry-meta' );

									if ( get_the_title() ) {
										?>
										<a href="<?php the_permalink(); ?>">
											<h3 class="entry-title"><?php the_title(); ?></h3>
										</a>
										<?php
									}
									if ( ! has_excerpt() ) {
										echo '<p class="post-content entry-content">' . esc_html( wp_trim_words( get_the_content(), 34, '' ) ) . '</p>';// phpcs:ignore
									} else {
										echo '<p class="post-content excerpt-post">' . esc_html( get_the_excerpt() ) . '</p>';
									}
									?>
									<a class="btn btn-blue" href="<?php the_permalink(); ?>"><?php echo esc_html( $read_more_button ); ?></a>
								</div>
							</div>
						</div>
						<div class="col-md-6"><div class="row">
						<?php
					} else {
						?>
						<div class="col-md-6 mb-3">
							<div class="small-post">
								<div class="post-thumb">
									<?php
									if ( has_post_thumbnail() ) {
										?>
										<a href="<?php the_permalink(); ?>">
											<?php the_post_thumbnail(); ?>
										</a>
										<?php
									}
									?>
								</div>
								<div class="post-content-wrapper">
									<?php
									if ( get_the_title() ) {
										?>
										<a href="<?php the_permalink(); ?>">
											<h2 class="entry-title"><?php the_title(); ?></h2>
										</a>
										<?php
									}
									if ( ! has_excerpt() ) {
										echo '<p class="post-content entry-content">' . esc_html( wp_trim_words( get_the_content(), 17, '...' ) ) . '</p>';// phpcs:ignore
									} else {
										echo '<p class="post-content excerpt-post">' . esc_html( get_the_excerpt() ) . '</p>';
									}
									?>
								</div>
							</div>
						</div>
						<?php
					}
					if ( $totalpost === $counter ) {
						?>
						</div></div>
						<?php
					}
					$counter++;
				}
				?>
				</div>
				<?php
			}
			wp_reset_postdata();
			?>
		</div>
	</section>
	<?php
}
