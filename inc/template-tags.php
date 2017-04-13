<?php
/**
 * Custom template tags for this theme
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package Adler
 */

if ( ! function_exists( 'adler_posted_on' ) ) :
	/**
	 * Prints HTML with meta information for the current post-date/time and author.
	 */
	function adler_posted_on() {
	?>
			<div class="cat-links">
				<?php
				/* translators: used between list items, there is a space after the comma */
				$categories_list = get_the_category_list( esc_html__( ', ', 'adler' ) );

				if ( $categories_list && adler_categorized_blog() ) {
					printf( '<span class="cat-links">' . adler_get_svg( array(
						'icon' => 'categories',
					) ) . esc_html__( 'Posted in %1$s', 'adler' ) . '</span>', $categories_list ); // WPCS: XSS OK.
				} ?>
			</div>

			<?php
			$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
			if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
				$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
			}

			$time_string = sprintf( $time_string,
				esc_attr( get_the_date( 'c' ) ),
				esc_html( get_the_date() ),
				esc_attr( get_the_modified_date( 'c' ) ),
				esc_html( get_the_modified_date() )
			);

			$posted_on = sprintf(
				esc_html_x( '%s', 'post date', 'adler' ),
				'<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . $time_string . '</a>'
			);

			$byline = sprintf(
				esc_html_x( 'by %s', 'post author', 'adler' ),
				'<span class="author vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . esc_html( get_the_author() ) . '</a></span>'
			);

			echo '<span class="posted-on">' . adler_get_svg( array(
				'icon' => 'posted',
			) ) . $posted_on . '</span><span class="byline">' . adler_get_svg( array(
				'icon' => 'author',
			) ) . $byline . '</span>'; // WPCS: XSS OK.
	}
endif;

if ( ! function_exists( 'adler_entry_footer' ) ) :
	/**
	 * Prints HTML with meta information for the categories, tags and comments.
	 */
	function adler_entry_footer() {
		// Hide category and tag text for pages.
		if ( 'post' === get_post_type() ) {

			/* translators: used between list items, there is a space after the comma */
			$tags_list = get_the_tag_list( '', esc_html__( ', ', 'adler' ) );
			if ( $tags_list ) {
				printf( '<span class="tags-links">' . adler_get_svg( array(
					'icon' => 'tags',
				) ) . esc_html__( 'Tagged %1$s', 'adler' ) . '</span>', $tags_list ); // WPCS: XSS OK.
			}
		}

		if ( ! is_single() && ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
			echo '<span class="comments-link">' . adler_get_svg( array(
				'icon' => 'comments',
			) );
			comments_popup_link( esc_html__( 'Leave a comment', 'adler' ), esc_html__( '1 Comment', 'adler' ), esc_html__( '% Comments', 'adler' ) );
			echo '</span>';
		}

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
	}
endif;

/**
 * Returns true if a blog has more than 1 category.
 *
 * @return bool
 */
function adler_categorized_blog() {
	if ( false === ( $all_the_cool_cats = get_transient( 'adler_categories' ) ) ) {
		// Create an array of all the categories that are attached to posts.
		$all_the_cool_cats = get_categories( array(
			'fields'	 => 'ids',
			'hide_empty' => 1,
			// We only need to know if there is more than one category.
			'number'	 => 2,
		) );

		// Count the number of categories that are attached to the posts.
		$all_the_cool_cats = count( $all_the_cool_cats );

		set_transient( 'adler_categories', $all_the_cool_cats );
	}

	if ( $all_the_cool_cats > 1 ) {
		// This blog has more than 1 category so adler_categorized_blog should return true.
		return true;
	} else {
		// This blog has only 1 category so adler_categorized_blog should return false.
		return false;
	}
}

/**
 * Flush out the transients used in adler_categorized_blog.
 */
function adler_category_transient_flusher() {
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	// Like, beat it. Dig?
	delete_transient( 'adler_categories' );
}
add_action( 'edit_category', 'adler_category_transient_flusher' );
add_action( 'save_post',	 'adler_category_transient_flusher' );
