<?php
/**
 * Template part for displaying the single entry featured background post.
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
			<header class="entry-header">
				<?php the_title( '<h1 class="entry-title"><span class="entry-featured-background-title">', '</span></h1>' ); ?>
			</header>

			<div class="entry-meta">
				<?php echo adler_meta_categories(); ?>
				<?php echo adler_meta_posted_on(); ?>
			</div><!-- .entry-meta -->
		</div><!-- .entry-featured-background-content -->

		<?php get_template_part( 'components/entry-featured-background/entry-featured-background', 'scroll-indicator' ); ?>
	</div><!-- .entry-featured-background-wrapper -->

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
