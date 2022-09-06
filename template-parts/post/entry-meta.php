<?php
/**
 * Content page template to display Meta Entries like date, author etc.
 *
 * @package Armcodirect
 */

?>
<div class="entry-meta-wrap">
	<span class="post-date published">
		<?php
			echo esc_html( get_the_date() );
		?>
	</span>
	<time class="updated d-none" datetime="<?php echo esc_attr( get_the_modified_date( 'c' ) ); ?>">
		<?php echo esc_html( get_the_modified_date() ); ?>
	</time>
	<span class="byline author vcard">
	<a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>" rel="author" class="fn">
		<?php
			echo esc_html( get_the_author() );
		?>
		</a>
	</span>
</div>
