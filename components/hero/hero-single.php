<?php
/**
 * Template part for displaying the single hero post.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Adler
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<div class="hero-wrapper">
		<div class="hero-bg feature-header" style="background-image:url( <?php echo esc_url( adler_get_post_thumbnail_url( 'adler-hero' ) ); ?> )"></div>

		<div class="hero-content">
			<header class="entry-header">
				<?php
					the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
				?>
			</header>

			<?php  get_template_part( 'components/post/content', 'meta' ); ?>
		</div><!-- .hero-content -->

		<div class="scroll-indicator-wrapper">
			<a href="#" id="scroll-indicator" class="scroll-indicator"><span class="screen-reader-text"><?php esc_html_e( 'Scroll down to see more content', 'adler' ); ?></span></a>
		</div>

	</div><!-- .hero-wrapper -->
	<div id="scroll-indicator-anchor"></div>

	<div class="entry-wrapper">
		<div class="entry-content">
			<?php
				the_content();

				wp_link_pages( array(
					'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'adler' ),
					'after'  => '</div>',
				) );
			?>
		</div><!-- .entry-content -->

		<?php get_template_part( 'components/post/content', 'footer' ); ?>
	</div><!-- .entry-wrapper -->
</article><!-- #post-## -->
