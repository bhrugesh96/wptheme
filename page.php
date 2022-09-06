<?php
/**
 * Default Page Template.
 *
 * @package Armcodirect
 */

if ( have_posts() ) :
	while ( have_posts() ) :
		the_post();
		get_template_part( 'template-parts/content', 'page' );
	endwhile;
endif;
