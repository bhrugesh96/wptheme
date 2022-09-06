<?php
/**
 * Template part for no content template.
 *
 * @package Armcodirect
 */

?>
<div class="not-found text-center">
	<h2 class="title"><?php echo esc_html__( 'Nothing Found', 'armcodirect' ); ?></h2>
	<p><?php echo esc_html__( 'Sorry, but you are looking for something that isn\'t here.', 'armcodirect' ); ?></p>
	<a class="btn btn-grey" href="<?php echo esc_url( home_url( '/' ) ); ?>">
	<?php echo esc_html__( 'Return to the homepage', 'armcodirect' ); ?>
	</a>
</div>
