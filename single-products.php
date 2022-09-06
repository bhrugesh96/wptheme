<?php
/**
 * Single Product Template.
 *
 * @package Armcodirect
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

get_template_part( 'template-parts/deafult-header-strip-block' );

get_template_part( 'template-parts/product/content', 'product-info' );

get_template_part( 'template-parts/content', 'page' );

get_template_part( 'template-parts/product/content', 'related-product' );
