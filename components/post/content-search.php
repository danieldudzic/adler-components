<?php
/**
 * Template part for displaying results in search pages.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Adler
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<div class="entry-wrapper">
		<header class="entry-header">
			<?php the_title( sprintf( '<h2 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' ); ?>
		</header>

		<?php if ( '' != get_the_post_thumbnail() ) : ?>
			<div class="post-thumbnail">
				<a href="<?php the_permalink(); ?>">
					<?php the_post_thumbnail( 'adler-featured-image' ); ?>
				</a>
			</div>
		<?php endif; ?>

		<div class="entry-main">
			<div class="entry-summary">
				<?php the_excerpt(); ?>
			</div>
			<?php get_template_part( 'components/post/content', 'footer' ); ?>
		</div><!-- .entry-main -->
	</div><!-- .entry-wrapper -->
</article>
