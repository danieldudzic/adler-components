<?php
/**
 * Custom functions that act independently of the theme templates
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package Adler
 */

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function adler_body_classes( $classes ) {
	// Adds a class of group-blog to blogs with more than 1 published author.
	if ( is_multi_author() ) {
		$classes[] = 'group-blog';
	}

	// Adds a class of hfeed to non-singular pages.
	if ( ! is_singular() ) {
		$classes[] = 'hfeed';
	}

	// Add a class of no-sidebar when there is no sidebar present.
	if ( ! is_active_sidebar( 'sidebar-1' ) ) {
		$classes[] = 'no-sidebar';
	}

	// Add a class of has-post-thumbnail if the post or page ( or the blog page - first post ) has a featured image set.
	if ( adler_has_post_thumbnail() && ! is_archive() ) {
		if ( true === adler_jetpack_featured_image_display() && is_singular() ) {
			$classes[] = 'has-hero-thumbnail';
		}
		if ( true === adler_jetpack_featured_image_archive_display() && ! is_singular() ) {
			$classes[] = 'has-hero-thumbnail';
		}
	}

	// Add class if the site title and tagline is hidden.
	$theme_mods = get_theme_mods();

	if ( 'blank' === $theme_mods['header_textcolor'] ) {
		$classes[] = 'title-tagline-hidden';
	}

	return $classes;
}
add_filter( 'body_class', 'adler_body_classes' );

/**
 * Add a pingback url auto-discovery header for singularly identifiable articles.
 */
function adler_pingback_header() {
	if ( is_singular() && pings_open() ) {
		echo '<link rel="pingback" href="', esc_url( get_bloginfo( 'pingback_url' ) ), '">';
	}
}
add_action( 'wp_head', 'adler_pingback_header' );
