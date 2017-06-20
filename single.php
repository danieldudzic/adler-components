<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package Adler
 */

get_header();

// Starting The Loop earlier to take advantage of functions like has_post_thumbnail()
while ( have_posts() ) : the_post(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

		<?php
			if ( adler_has_post_thumbnail() ) {
				get_template_part( 'components/entry-featured-background/entry-featured-background', 'single' );
			} else {
				get_template_part( 'components/post/content', 'single' );
			}

			the_post_navigation( array(
				'prev_text' => '<span class="title">' .
									esc_html_x( 'Previous', 'previous post', 'adler' ) .
								'</span>%title',
				'next_text' => '<span class="title">' .
									esc_html_x( 'Next', 'next post', 'adler' ) .
								'</span>%title',
			) );

			// If comments are open or we have at least one comment, load up the comment template.
			if ( comments_open() || get_comments_number() ) :
				comments_template();
			endif;
		?>

		</main>
	</div>
<?php
endwhile; // End of the loop.

get_footer();
