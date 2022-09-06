<?php
/**
 * Content page template to display single post content
 *
 * @package Armcodirect
 */

get_template_part( 'template-parts/deafult-header-strip-block' );

if ( has_post_thumbnail() ) : ?>
	<section class="feature-image-wrap">
		<div class="container">
			<div class="row justify-content-center">
				<div class="col-xl-8 col-lg-10 col-12">
					<?php the_post_thumbnail(); ?>
				</div>
			</div>
		</div>
	</section>
	<?php
endif;
get_template_part( 'template-parts/content', 'page' );

$label_field   = get_field( 'label_field' );
$related_posts = get_field( 'related_posts' );
$label_field   = ( $label_field ) ? $label_field : '';
if ( $related_posts ) :
	?>
	<section class="more-posts">
		<div class="container">
			<div class="row">
				<div class="col-12">
					<h2 class="title"><?php echo esc_html( $label_field ); ?></h2>
				</div>
				<?php
				if ( $related_posts ) :
					foreach ( $related_posts as $post ) : // phpcs:ignore
						// Setup this post for WP functions (variable must be named $post).
						setup_postdata( $post );
						?>
						<article <?php post_class( 'col-lg-4 col-md-6' ); ?>>
							<div class="post-wrapper">
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
											<h2 class="entry-title"><?php the_title(); ?></h2>
										</a>
										<?php
									}
									if ( ! has_excerpt() ) {
										echo '<p class="post-content entry-content">' . esc_html( wp_trim_words( get_the_content(), 27, '' ) ) . '</p>';// phpcs:ignore
									} else {
										echo '<p class="post-content excerpt-post">' . esc_html( get_the_excerpt() ) . '</p>';
									}
									?>
									<a class="btn btn-blue" href="<?php the_permalink(); ?>"><?php echo esc_html__( 'Read more', 'armcodirect' ); ?></a>
								</div>
							</div>
						</article>
						<?php
					endforeach;
				endif;
				wp_reset_postdata();
				?>
			</div>
		</div>
	</section>
	<?php
endif;

