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
	<div class="hero-wrapper">
		<div class="hero-bg feature-header" style="background-image:url( <?php echo esc_url( adler_get_post_thumbnail_url( 'adler-hero' ) ); ?> )"></div>

		<div class="hero-content">
			<div class="entry-meta">
				<?php adler_entry_meta(); ?>
			</div><!-- .entry-meta -->

			<header class="entry-header">
				<?php
					the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
				?>
			</header>

			<div class="entry-content">
				<?php the_excerpt(); ?>
			</div><!-- .entry-content -->

		</div><!-- .hero-content -->

		<?php get_template_part( 'components/hero/hero', 'scroll-indicator' ); ?>
	</div><!-- .hero-wrapper -->
</article><!-- #post-## -->
<div id="scroll-indicator-anchor"></div>
