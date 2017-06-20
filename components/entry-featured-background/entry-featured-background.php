<?php
/**
 * Template part for displaying entry featured background posts.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Adler
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<div class="entry-featured-background-wrapper">
		<div class="entry-featured-background-bg feature-header" style="background-image:url( <?php echo esc_url( adler_get_post_thumbnail_url( 'adler-entry-featured-background' ) ); ?> )"></div>

		<div class="entry-featured-background-content">
			<div class="entry-meta">
				<?php echo adler_meta_categories(); ?>
				<?php echo adler_meta_posted_on(); ?>
			</div><!-- .entry-meta -->

			<header class="entry-header">
				<?php
					the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
				?>
			</header>

			<div class="entry-content">
				<?php the_excerpt(); ?>
			</div><!-- .entry-content -->

		</div><!-- .entry-featured-background-content -->

		<?php get_template_part( 'components/entry-featured-background/entry-featured-background', 'scroll-indicator' ); ?>
	</div><!-- .entry-featured-background-wrapper -->
</article><!-- #post-## -->
<div id="scroll-indicator-anchor"></div>
