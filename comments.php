<?php
/**
 * The template for displaying comments
 *
 * The area of the page that contains both current comments
 * and the comment form.
 *
 * @package Armcodirect
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/*
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
 */

if ( post_password_required() ) {
	return;
}
?>
<section id="comments" class="comments">
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-lg-8 col-12">
				<h6 class="comment-reply-title text-center h-2 mb-5">
				<?php
				if ( ! have_comments() ) {
					esc_html_e( 'Write a comment', 'armcodirect' );
				} else {
					$comments_number = comments_number();
					?>
					<span class="comment-title"><?php echo esc_html( $comments_number ); ?></span>
					<?php
				}
				?>
			</h6><!-- .comments-title -->
				<?php
				if ( have_comments() ) :
					?>
					<ul class="blog-comment">
						<?php
						wp_list_comments(
							array(
								'style'       => 'li',
								'short_ping'  => true,
								'avatar_size' => 400,
							)
						);
						?>
					</ul>
					<?php
					if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) :
						?>
						<nav>
							<ul class="pager">
								<?php
								if ( get_previous_comments_link() ) :
									?>
									<li class="previous">
										<?php
											previous_comments_link( __( '&larr; Older comments', 'armcodirect' ) );
										?>
									</li>
									<?php
								endif;
								if ( get_next_comments_link() ) :
									?>
									<li class="next">
										<?php
											next_comments_link( __( 'Newer comments &rarr;', 'armcodirect' ) );
										?>
									</li>
									<?php
								endif;
								?>
							</ul>
						</nav>
						<?php
					endif;
				endif; // have_comments function.

				if ( ! comments_open() && get_comments_number() !== '0' && post_type_supports( get_post_type(), 'comments' ) ) :
					?>
					<div class="alert alert-warning">
						<?php _e( 'Comments are closed.', 'armcodirect' );// phpcs:ignore ?>
					</div>
					<?php
				endif;
				$comments_args = array( 'class_submit' => 'btn btn-blue' );
				comment_form( $comments_args );
				?>
			</div>
		</div>
	</div>
</section>
