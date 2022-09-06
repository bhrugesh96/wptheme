<?php
/**
 * The header.
 *
 * @package Armcodirect
 */

?>

<!DOCTYPE html>
<html <?php language_attributes(); ?>>
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
		<!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
		<title><?php wp_title(); ?> <?php bloginfo( 'name' ); ?></title>

		<script>
		// https://browser-update.org/
		var $buoop = {vs:{i:10,f:-4,o:-4,s:8,c:-4},api:4};
		function $buo_f(){
			var e = document.createElement("script");
			e.src = "//browser-update.org/update.min.js";
			document.body.appendChild(e);
		};
		try {document.addEventListener("DOMContentLoaded", $buo_f,false)}
		catch(e){window.attachEvent("onload", $buo_f)}
		</script>
		<link rel="stylesheet" href="https://use.typekit.net/dvo2rdl.css">
		<?php wp_head(); ?>
	</head>

	<body <?php body_class(); ?>>
	<?php
	wp_body_open();
	$page_section_id = get_field( 'page_section_id' );
	$page_section_id = ( $page_section_id ) ? ' id="' . esc_attr( $page_section_id ) . '"' : '';
	?>
		<header>
			<?php
			if ( is_page_template( 'templates/landing-templates.php' ) ) {
				get_template_part( 'template-parts/content-landing', 'header' );
			} else {
				get_template_part( 'template-parts/content', 'header' );
			}
			?>
		</header>
			<main class="main-content-wrap"<?php echo $page_section_id;//phpcs:ignore ?>><!-- main content: BEGIN -->
