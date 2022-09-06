<?php
/**
 * The template for displaying the footer
 *
 * @package Armcodirect
 */

?>

</main><!-- main content : END -->
	<?php
	if ( ! is_page_template( 'templates/landing-templates.php' ) ) {
		get_template_part( 'template-parts/content', 'footer' );
	}
	?>
	<?php wp_footer(); ?>
	</body>
</html>
