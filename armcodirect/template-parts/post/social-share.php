<?php
/**
 * Content page template to display Social Share.
 *
 * @package Armcodirect
 */

$permalink  = get_permalink( get_the_ID() );
$post_title = rawurlencode( get_the_title( get_the_ID() ) );
?>
<ul class="social-share-list">
	<li>
		<a class="social-sharing-icon facebook-f" href="//www.facebook.com/sharer.php?u=<?php echo esc_url( $permalink ); ?>" onclick="window.open(this.href,this.title,'width=500,height=500,top=300px,left=300px');  return false;"  rel="nofollow" target="_blank" title="<?php echo esc_attr( $post_title ); ?>"><span class="screen-reader-text"><?php echo esc_html_e( 'facebook', 'armcodirect' ); ?></span></a>
	</li>
	<li>
		<a class="social-sharing-icon twitter" href="//twitter.com/share?url=<?php echo esc_url( $permalink ); ?>" onclick="window.open(this.href,this.title,'width=500,height=500,top=300px,left=300px');  return false;"  rel="nofollow" target="_blank" title="<?php echo esc_attr( $post_title ); ?>"><span class="screen-reader-text"><?php echo esc_html_e( 'twitter', 'armcodirect' ); ?></span></a>
		</a>
	</li>
	<li>
		<a class="social-sharing-icon linkedin-in" href="//linkedin.com/shareArticle?mini=true&amp;url=<?php echo esc_url( $permalink ); ?>&amp;title=<?php echo esc_attr( $post_title ); ?>" target="_blank" onclick="window.open(this.href,this.title,'width=500,height=500,top=300px,left=300px');  return false;"  rel="nofollow" title="<?php echo esc_attr( $post_title ); ?>"><span class="screen-reader-text"><?php echo esc_html_e( 'linkedin', 'armcodirect' ); ?></span></a>
		</a>
	</li>
</ul>
