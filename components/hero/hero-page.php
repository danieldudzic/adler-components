<?php
/**
 * Template part for displaying the hero page.
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
				<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
			</header>
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

		<footer class="entry-footer">
			<?php
				edit_post_link(
					sprintf(
						adler_get_svg( array(
							'icon' => 'edit',
						) ) .
						/* translators: %s: Name of current post */
						esc_html__( 'Edit %s', 'adler' ),
						the_title( '<span class="screen-reader-text">"', '"</span>', false )
					),
					'<span class="edit-link">',
					'</span>'
				);
			?>
		</footer>
	</div><!-- .entry-wrapper -->
</article><!-- #post-## -->
