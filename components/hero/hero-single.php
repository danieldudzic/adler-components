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
				<?php the_title( '<h1 class="entry-title"><span class="hero-title">', '</span></h1>' ); ?>
			</header>

			<?php get_template_part( 'components/post/content', 'meta' ); ?>
		</div><!-- .hero-content -->

		<?php get_template_part( 'components/hero/hero', 'scroll-indicator' ); ?>
	</div><!-- .hero-wrapper -->

	<div id="scroll-indicator-anchor" class="entry-wrapper">
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
