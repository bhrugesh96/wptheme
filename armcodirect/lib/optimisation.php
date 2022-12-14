<?php
/**
 * Remove Query Strings.
 *
 * @package Armcodirect
 */

/**
 * Remove Query strings.
 *
 * @param string $src Remove query string.
 */
function _remove_script_version( $src ) {
	$parts = explode( '?', $src );
	return $parts[0];
}
add_filter( 'script_loader_src', '_remove_script_version', 15, 1 );
add_filter( 'style_loader_src', '_remove_script_version', 15, 1 );
