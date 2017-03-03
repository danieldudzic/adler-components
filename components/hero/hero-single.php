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
	$attachment_image = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'full' );
	$image_url = $attachment_image[0];
	$hero_class .= 'hero-has-image';
	$hero_style .= 'style="background-image: url(\'' . $image_url . '\')"'; ?>
	
	<div class="hero-wrapper">
		<div class="hero-bg <?php echo $hero_class; ?>" <?php echo $hero_style; ?>></div>
		
		<div class="hero-content">
			<header class="entry-header">
				<?php
					the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
				?>
			</header>
			
			<?php  get_template_part( 'components/post/content', 'meta' ); ?>
		</div><!-- .hero-content -->
		
		<div class="scroll-indicator-wrapper">
			<a href="#" id="scroll-indicator" class="scroll-indicator"><span class="screen-reader-text">Scroll down to see more content</span></a>
		</div>
		
	</div><!-- .hero-wrapper -->
	<div id="scroll-indicator-anchor"></div>
	
	<div class="entry-wrapper">	
		<div class="entry-content">
			<?php
				the_content( sprintf(
					wp_kses( esc_html__( 'Read More', 'adler' ), array( 'span' => array( 'class' => array() ) ) ),
					the_title( '<span class="screen-reader-text">"', '"</span>', false )
				) );
	
				wp_link_pages( array(
					'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'adler' ),
					'after'  => '</div>',
				) );
			?>
		</div><!-- .entry-content -->

		<?php get_template_part( 'components/post/content', 'footer' ); ?>
	</div><!-- .entry-wrapper -->
		
</article><!-- #post-## -->