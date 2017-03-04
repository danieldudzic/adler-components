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
function adler_posted_on() { ?>
	
	<div class="post-meta-categories">
		<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16"><rect x="0" fill="none" width="16" height="16"/><g><path id="categories-icon" d="M13 5H8l-.7-1.4c-.2-.4-.5-.6-.9-.6H3c-.5 0-1 .5-1 1v8c0 .6.5 1 1 1h10c.6 0 1-.4 1-1V6c0-.6-.4-1-1-1z"/></g></svg>
		<?php
		$categories = get_the_category();
		$separator  = ' ';
		$output     = '';
		if ( $categories ) {
			foreach ( $categories as $category ) {
				$output .= '<a href="' . get_category_link( $category->term_id ) . '" title="' . esc_attr( sprintf( esc_html__( "View all posts in %s", 'adler' ), $category->name ) ) . '">' . $category->cat_name . '</a>' . $separator;
			}
			echo trim( $output, $separator );
		} ?>
	</div>
	

	<?php echo '<span class="separator"> - </span>'; ?>
		
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

	echo '<span class="posted-on">' . $posted_on . '</span><span class="byline"> ' . $byline . '</span>'; // WPCS: XSS OK.

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
		$categories_list = get_the_category_list( esc_html__( ', ', 'adler' ) );
		if ( $categories_list && adler_categorized_blog() ) {
			printf( '<span class="cat-links"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16"><rect x="0" fill="none" width="16" height="16"/><g><path id="categories-icon" d="M13 5H8l-.7-1.4c-.2-.4-.5-.6-.9-.6H3c-.5 0-1 .5-1 1v8c0 .6.5 1 1 1h10c.6 0 1-.4 1-1V6c0-.6-.4-1-1-1z"/></g></svg>' . esc_html__( 'Posted in %1$s', 'adler' ) . '</span>', $categories_list ); // WPCS: XSS OK.
		}

		/* translators: used between list items, there is a space after the comma */
		$tags_list = get_the_tag_list( '', esc_html__( ', ', 'adler' ) );
		if ( $tags_list ) {
			printf( '<span class="tags-links"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16"><rect x="0" fill="none" width="16" height="16"/><g><path id="tags-icon" d="M11.3 4.3c-.2-.2-.4-.3-.7-.3H3c-.5 0-1 .5-1 1v6c0 .6.5 1 1 1h7.6c.3 0 .5-.1.7-.3L15 8l-3.7-3.7zM10 9c-.5 0-1-.5-1-1s.5-1 1-1 1 .5 1 1-.5 1-1 1z"/></g></svg>' . esc_html__( 'Tagged %1$s', 'adler' ) . '</span>', $tags_list ); // WPCS: XSS OK.
		}
	}

	if ( ! is_single() && ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
		echo '<span class="comments-link">';
		echo '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16"><rect x="0" fill="none" width="16" height="16"/><g><path id="comments-icon" d="M7 3H3c-1.1 0-2 .9-2 2v7l2.4-2.4c.4-.4.9-.6 1.4-.6H6V8c0-1.7 1.3-3 3-3 0-1.1-.9-2-2-2zm6 3H9c-1.1 0-2 .9-2 2v2c0 1.1.9 2 2 2h2.2c.5 0 1 .2 1.4.6L15 15V8c0-1.1-.9-2-2-2z"/></g></svg>';
		comments_popup_link( esc_html__( 'Leave a comment', 'adler' ), esc_html__( '1 Comment', 'adler' ), esc_html__( '% Comments', 'adler' ) );
		echo '</span>';
	}

	edit_post_link(
		sprintf(
			/* translators: %s: Name of current post */
			'<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16"><rect x="0" fill="none" width="16" height="16"/><g><path id="edit-icon" d="M12.6 6.9l.5-.5c.8-.8.8-2 0-2.8l-.7-.7c-.8-.8-2-.8-2.8 0l-.5.5 3.5 3.5zM8.4 4.1L2 10.5V14h3.5l6.4-6.4"/></g></svg>' . esc_html__( 'Edit %s', 'adler' ),
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
			'fields'     => 'ids',
			'hide_empty' => 1,
			// We only need to know if there is more than one category.
			'number'     => 2,
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
add_action( 'save_post',     'adler_category_transient_flusher' );
