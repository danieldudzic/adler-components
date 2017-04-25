<?php
/**
 * Custom template tags for this theme
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package Adler
 */

if ( ! function_exists( 'adler_entry_meta' ) ) :
/**
 * Print HTML with meta information for the current post-date/time and author.
 */
function adler_entry_meta() {
	$meta_links_string = '<div class="meta-links">%1$s%2$s%3$s%4$s</div>';

	printf( $meta_links_string,
		adler_meta_posted_on(),
		adler_meta_author(),
		adler_meta_comments_link(),
		adler_meta_edit_link()
	);
}
endif;

if ( ! function_exists( 'adler_entry_footer' ) ) :
/**
 * Print HTML with meta information for the categories, tags and comments.
 */
function adler_entry_footer() {
	// Hide category and tag text for pages.
	if ( 'post' === get_post_type() ) {
		$taxonomies_string = '<div class="taxonomies-links">%1$s%2$s</div>';

		printf( $taxonomies_string,
			adler_meta_categories(),
			adler_meta_tags()
		);
	}
}
endif;

if ( ! function_exists( 'adler_meta_posted_on' ) ) :
/**
 * Return the HTML for post-date/time.
 */
function adler_meta_posted_on() {

	if ( is_sticky() && ! is_single() ) {
		return adler_meta_sticky();
	} else {
		$time_date_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';

		if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
			$time_date_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
		}

		$time_date = sprintf( $time_date_string,
			esc_attr( get_the_date( 'c' ) ),
			esc_html( get_the_date() ),
			esc_attr( get_the_modified_date( 'c' ) ),
			esc_html( get_the_modified_date() )
		);

		$posted_on_string = '<span class="posted-on">%1$s<a href="%2$s" rel="bookmark">%3$s</a></span>';

		$posted_on = sprintf( $posted_on_string,
			adler_get_svg( array(
				'icon' => 'posted',
			) ),
			esc_url( get_permalink() ),
			$time_date
		);

		return $posted_on;
	}
}
endif;

if ( ! function_exists( 'adler_meta_author' ) ) :
/**
 * Return the HTML for author.
 */
function adler_meta_author() {
	$byline_string = '<span class="author vcard"><a class="url fn n" href="%1$s">%2$s</a></span>';

	$byline = sprintf( $byline_string,
		esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
		esc_html( get_the_author() )
	); // WPCS: XSS OK.

	$byline = sprintf( esc_html_x( 'by %s', 'post author', 'adler' ),
		$byline
	);

	$author_string = '<span class="byline">%1$s%2$s</span>';

	$author = sprintf( $author_string,
		adler_get_svg( array(
			'icon' => 'author',
		) ),
		$byline
	); // WPCS: XSS OK.

	return $author;
}
endif;

if ( ! function_exists( 'adler_meta_categories' ) ) :
/**
 * Return the HTML for categories.
 */
function adler_meta_categories() {
	$categories = '';

	/* translators: used between list items, there is a space after the comma */
	$categories_list = get_the_category_list( esc_html__( ', ', 'adler' ) );

	if ( $categories_list && adler_categorized_blog() ) {
		$cats_list_string = '<span class="cats-links">%1$s%2$s %3$s</span>';

		$categories = sprintf( $cats_list_string,
			adler_get_svg( array(
				'icon' => 'categories',
			) ),
			esc_html__( 'Posted in', 'adler' ),
			$categories_list
		); // WPCS: XSS OK.
	}

	return $categories;
}
endif;

if ( ! function_exists( 'adler_meta_tags' ) ) :
/**
 * Return the HTML for tags.
 */
function adler_meta_tags() {
	$tags = '';

	/* translators: used between list items, there is a space after the comma */
	$tags_list = get_the_tag_list( '', esc_html__( ', ', 'adler' ) );

	if ( $tags_list ) {
		$tags_list = sprintf( esc_html__( 'Tagged %1$s', 'adler' ), $tags_list ); // WPCS: XSS OK.
		$tags_list_string = '<span class="tags-links">%1$s%2$s</span>';

		$tags = sprintf( $tags_list_string,
			adler_get_svg( array(
				'icon' => 'tags',
			) ),
			$tags_list
		);
	}

	return $tags;
}
endif;

if ( ! function_exists( 'adler_meta_comments_link' ) ) :
/**
 * Return the HTML for comment link.
 */
function adler_meta_comments_link() {
	if ( ! is_single() && ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
		ob_start();
		comments_popup_link( esc_html__( 'Leave a comment', 'adler' ), esc_html__( '1 Comment', 'adler' ), esc_html__( '% Comments', 'adler' ) );
		$comments_popup_link = ob_get_contents();
		ob_end_clean();

		$comments_link_string = '<span class="comments-link">%1$s%2$s</span>';

		$comments_link = sprintf( $comments_link_string,
			adler_get_svg( array(
				'icon' => 'comments',
			) ),
			$comments_popup_link
		); // WPCS: XSS OK.

		return $comments_link;
	}
}
endif;

if ( ! function_exists( 'adler_meta_edit_link' ) ) :
/**
 * Return the Edit Post link.
 */
function adler_meta_edit_link() {
	$edit_link = sprintf(
		/* translators: %s: Name of current post */
		esc_html__( 'Edit %s', 'adler' ),
		the_title( '<span class="screen-reader-text">"', '"</span>', false )
	);

	ob_start();
	edit_post_link(
		adler_get_svg( array(
			'icon' => 'edit',
		) ) . $edit_link,
		'<span class="edit-link">',
		'</span>'
	);
	$edit_link = ob_get_contents();
	ob_end_clean();

	return $edit_link;
}
endif;

/**
 * Return the Sticky post label
 */
function adler_meta_sticky() {
	$sticky_string = '<span class="sticky-label">%1$s%2$s</span>';

	$sticky = sprintf( $sticky_string,
		adler_get_svg( array(
			'icon' => 'sticky',
		) ),
		esc_html__( 'Sticky', 'adler' )
	);

	return $sticky;
}

/**
 * Return true if a blog has more than 1 category.
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
