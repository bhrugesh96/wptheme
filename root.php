<?php
/**
 * Setup Global files.
 *
 * @package Armcodirect
 */

/**
 * Get header();
 */

get_header( root_template_base() );

/**
 * Include page body content
 */

require root_template_path();

/**
 * Get footer();
 */

get_footer( root_template_base() );
