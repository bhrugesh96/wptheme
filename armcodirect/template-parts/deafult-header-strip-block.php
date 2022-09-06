<?php
/**
 * Content page template to display Header Titles.
 *
 * @package Armcodirect
 */

if ( function_exists( 'armcodirect_breadcrumb_display' ) ) {

	if ( is_search() || is_category() || is_tag() || is_archive() ) { // if Post category, tag, archive page

		if ( is_tag() ) {
			$armcodirect_archive_title = sprintf( '%s', single_tag_title( '', false ) );
		} elseif ( is_author() ) {
			$armcodirect_archive_title = sprintf( '%s', get_the_author() );
		} elseif ( is_category() ) {
			$armcodirect_archive_title = sprintf( '%s', single_tag_title( '', false ) );
		} elseif ( is_year() ) {
			$armcodirect_archive_title = sprintf( '%s', get_the_date( _x( 'Y', 'yearly archives date format', 'armcodirect' ) ) );
		} elseif ( is_month() ) {
			$armcodirect_archive_title = sprintf( '%s', get_the_date( _x( 'F Y', 'monthly archives date format', 'armcodirect' ) ) );
		} elseif ( is_day() ) {
			$armcodirect_archive_title = sprintf( '%s', get_the_date( _x( '', 'daily archives date format', 'armcodirect' ) ) ); // phpcs:ignore
		} elseif ( is_search() ) {
			$armcodirect_archive_title = esc_html__( 'Search Results For ', 'armcodirect' ) . '"' . get_search_query() . '"'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped

		} elseif ( is_tax( 'product-category' ) ) {
			$armcodirect_archive_title = sprintf( '%s', single_tag_title( '', false ) );
		} elseif ( is_post_type_archive( 'products' ) ) {
			$armcodirect_archive_title = esc_html__( 'Our Products', 'armcodirect' );
		} elseif ( is_archive() ) {
			$armcodirect_archive_title = esc_html__( 'Archives', 'armcodirect' );
		} else {
			$armcodirect_archive_title = get_the_title();
		}

		$armcodirect_title = $armcodirect_archive_title; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped

	} elseif ( is_home() ) {

		$armcodirect_title = esc_html__( 'Latest news from Armco Direct', 'armcodirect' );

	} else {
		$armcodirect_title = get_the_title();
	}
	?>
	<section class="header-strip-block">
		<div class="container">
			<div class="row">
				<div class="col-12">
					<ul class="breadcrumb-wrap" itemscope itemtype="https://schema.org/BreadcrumbList">
						<?php echo armcodirect_breadcrumb_display(); // phpcs:ignore ?>
					</ul>
					<?php
					if ( ! empty( $armcodirect_title ) ) {
						?>
						<h2 class="title h-1"><?php echo esc_html( $armcodirect_title ); ?></h2>
						<?php
					}
					?>
				</div>
			</div>
		</div>
	</section>
	<?php
}
