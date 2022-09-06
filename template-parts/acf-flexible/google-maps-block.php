<?php
/**
 * Google Map Block
 *
 * @package Armcodirect
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

$map_iframe = get_sub_field( 'map_iframe' );
if ( ! empty( $map_iframe ) ) {
	?>
	<section class="google-map-block">
		<div class="container-fluid">
			<div class="row">
				<div class="col-12 map-iframe px-0">
					<?php
						echo $map_iframe; // phpcs:ignore
					?>
				</div>
			</div>
		</div>
	</section>
	<?php
}
