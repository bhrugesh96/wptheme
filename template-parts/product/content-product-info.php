<?php
/**
 * Content page template to display all products
 *
 * @package Armcodirect
 */

if ( have_posts() ) :
	while ( have_posts() ) :
		the_post();
		$page_title        = get_field( 'title' );
		$content           = get_field( 'content' );
		$download_cta_text = get_field( 'download_cta_text' );
		$download_pdf_file = get_field( 'download_pdf_file' );
		$cta_button        = get_field( 'cta_button' );
		if ( ! empty( $page_title ) || ! empty( $content ) || ! empty( $download_cta_text ) || ! empty( $download_pdf_file ) || ! empty( $cta_button ) ) {
			?>
			<section class="single-product-main-wrapper">
				<div class="container">
					<div class="row">
						<div class="col-md-6 product-image">
							<?php
							if ( has_post_thumbnail() ) :
								?>
								<div class="post-thumb">
									<?php the_post_thumbnail(); ?>
								</div>
								<?php
							endif;
							?>
						</div>
						<div class="col-md-6 product-info">
							<?php
							if ( ! empty( $page_title ) ) {
								?>
								<h2 class="title">
									<?php echo esc_html( $page_title ); ?>
								</h2>
								<?php
							}

							if ( ! empty( $content ) ) {
								?>
								<div class="content">
									<?php echo sprintf( '%s', $content );// phpcs:ignore ?>
								</div>
								<?php
							}
							echo '<div class="cta-button-wrap">';
							if ( ! empty( $download_pdf_file ) ) {
								$download_cta_text = ( ! empty( $download_cta_text ) ) ? $download_cta_text : esc_html__( 'DOWNLOAD SPEC SHEET', 'armcodirect' );
								?>
								<a class="btn btn-grey" href="<?php echo esc_url( $download_pdf_file ); ?>" target="_blank"><?php echo esc_html( $download_cta_text ); ?></a>
								<?php
							}

							if ( ! empty( $cta_button ) ) {
								$link_url    = ( isset( $cta_button['url'] ) && ! empty( $cta_button['url'] ) ) ? $cta_button['url'] : '';
								$link_title  = ( isset( $cta_button['title'] ) && ! empty( $cta_button['title'] ) ) ? $cta_button['title'] : '';
								$link_target = ( isset( $cta_button['target'] ) && ! empty( $cta_button['target'] ) ) ? $cta_button['url'] : '_self';
								if ( $link_url ) {
									?>
									<a class="btn yellow-strip-btn" href="<?php echo esc_url( $link_url ); ?>" target="<?php echo esc_attr( $link_target ); ?>"><?php echo esc_html( $link_title ); ?></a>
									<?php
								}
							}
							echo '</div>';
							?>
						</div>
					</div>
				</div>
			</section>
			<?php
		}
	endwhile;
endif;
