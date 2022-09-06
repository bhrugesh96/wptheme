<?php
/**
 * Header Strip Block for breadcrumb
 *
 * @package Armcodirect
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
$bg_pattern          = get_sub_field( 'background_pattern' );
$breadcrumb_switcher = get_sub_field( 'breadcrumb_switcher' );
$breadcrumb_text     = get_sub_field( 'breadcrumb_text' );
?>
<section class="header-strip-block <?php echo esc_attr( $bg_pattern ); ?>">
	<div class="container">
		<div class="row">
			<div class="col-12">
				<?php
				if ( $breadcrumb_switcher && function_exists( 'armcodirect_breadcrumb_display' ) ) {
					?>
					<ul class="breadcrumb-wrap" itemscope itemtype="https://schema.org/BreadcrumbList">
						<?php echo armcodirect_breadcrumb_display(); // phpcs:ignore ?>
					</ul>
					<?php
				}
				if ( get_the_title() ) {
					?>
					<h2 class="title h-1"><?php the_title(); ?></h2>
					<?php
				}
				?>
			</div>
		</div>
	</div>
</section>
