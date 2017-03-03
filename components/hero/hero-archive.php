<?php
/**
 * Template part for displaying hero posts.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Adler
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	
	<?php
	$hero_class = '';
	$hero_style = '';
	$attachment_image = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'adler-large' );
	$image_url = $attachment_image[0];
	?>
	
	<div class="hero-wrapper">
		<div class="hero-bg feature-header" style="background-image:url( <?php echo esc_url( $image_url ); ?> )"></div>
		
		<div class="hero-content">
			<?php  get_template_part( 'components/post/content', 'meta' ); ?>
					
			<header class="entry-header">
				<?php
					the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
				?>
			</header>
			
			<div class="entry-content">
				<?php the_excerpt(); ?>
				<a href="<?php the_permalink(); ?>" class="more-link"><?php echo esc_html__( 'Read More', 'adler' ); ?></a>
			</div><!-- .entry-content -->

		</div><!-- .hero-content -->

		<div class="scroll-indicator-wrapper">
			<a href="#" id="scroll-indicator" class="scroll-indicator"><span class="screen-reader-text">Scroll down to see more content</span></a>
		</div>
	
	</div><!-- .hero-wrapper -->
</article><!-- #post-## -->
<div id="scroll-indicator-anchor"></div>