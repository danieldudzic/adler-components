<?php
/**
 * Template part for displaying posts.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Adler
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<div class="entry-wrapper">
		<header class="entry-header">
			<?php
				the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
			?>
		</header>
		
		<?php if ( '' != get_the_post_thumbnail() ) : ?>
			<div class="post-thumbnail">
				<a href="<?php the_permalink(); ?>">
					<?php the_post_thumbnail( 'adler-featured-image' ); ?>
				</a>
			</div>
		<?php endif; ?>

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