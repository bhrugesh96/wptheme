<?php
/**
 * Content page template to display all post content
 *
 * @package Armcodirect
 */

get_template_part( 'template-parts/deafult-header-strip-block' );
?>
<section class="blog-list-wrap grid">
	<div class="container">
		<div class="row">
			<?php
			if ( have_posts() ) :
				$paged = ( get_query_var( 'paged' ) ) ? absint( get_query_var( 'paged' ) ) : 1;// phpcs:ignore
				while ( have_posts() ) :
					the_post();
					if ( is_sticky() && 1 === $paged ) {
						?>
						<article <?php post_class( 'col-12' ); ?>>
							<div class="post-wrapper d-flex">
								<div class="col-md-5 post-content-wrapper">
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
								<div class="col-md-7">
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
								</div>
							</div>
						</article>
						<?php
					} else {
						?>
						<article <?php post_class( 'col-lg-4 col-md-6 col-12' ); ?>>
							<div class="post-wrapper">
								<div class="post-thumb">
									<a href="<?php the_permalink(); ?>">
										<?php
										if ( has_post_thumbnail() ) {
											the_post_thumbnail();
										} else {
											?>
											<img src="<?php echo ARMCODIRECT_THEME_URI;// phpcs:ignore ?>/inc/assets/placeholder.jpg" alt="" />
											<?php
										}
										?>
									</a>
								</div>
								<div class="post-content-wrapper">
									<?php get_template_part( 'template-parts/post/entry-meta' ); ?>
									<a href="<?php the_permalink(); ?>">
										<h3 class="entry-title"><?php the_title(); ?></h3>
									</a>
									<?php
									if ( ! has_excerpt() ) {
										echo '<p class="post-content entry-content">' . esc_html( wp_trim_words( get_the_content(), 34, '...' ) ) . '</p>';// phpcs:ignore
									} else {
										echo '<p class="post-content excerpt-post">' . esc_html( get_the_excerpt() ) . '</p>';
									}
									?>
									<a class="btn btn-blue" href="<?php the_permalink(); ?>"><?php echo esc_html__( 'Read more', 'armcodirect' ); ?></a>
								</div>
							</div>
						</article>
						<?php
					}
				endwhile;
				armcodirect_get_the_posts_pagination(); // Pagination.
			else :
				get_template_part( 'template-parts/content', 'none' );
			endif;
			?>
		</div>
	</div>
</section>
