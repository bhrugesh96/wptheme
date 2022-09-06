<?php
/**
 * 404 Page Template.
 *
 * @package Armcodirect
 */

?>
<section class="error-404">
	<div class="container">
		<div class="row">
			<div class="not-found text-center">
			<h2 class="h-1 title"><?php echo esc_html__( '404', 'armcodirect' ); ?></h2>
			<p><?php echo esc_html__( 'This page could not be found!', 'armcodirect' ); ?></p>
			<a class="btn btn-grey" href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php echo esc_html__( 'Return to the homepage', 'armcodirect' ); ?></a>
			</div>
		</div>
	</div>
</section>
