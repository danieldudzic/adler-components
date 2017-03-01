<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package Adler
 */

get_header();

//Starting The Loop earlier to take advantage of functions like has_post_thumbnail()
while ( have_posts() ) : the_post(); ?>
	
	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

		<?php
			if ( has_post_thumbnail() ) {
				get_template_part( 'components/hero/hero', 'single' );
			} else {
				get_template_part( 'components/post/content', get_post_format() );
			}

			the_post_navigation();

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
