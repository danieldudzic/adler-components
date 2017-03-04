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
	
	// Add a class of no-sidebar when there is no sidebar present
	if ( ! is_active_sidebar( 'sidebar-1' ) ) {
		$classes[] = 'no-sidebar';
	}
	
	// Adds a class of has-post-thumbnail if the featured image is set ( or the first post in the loop has the featured image set )
	if ( has_post_thumbnail() && ! is_archive() ) {
		$classes[] = 'has-hero-thumbnail';
	}
	
	//If we have no active social links menu and the header text is hidden, narrow the top bar
	if ( ! has_nav_menu( 'jetpack-social-menu' ) && 'blank' == get_header_textcolor() ) {
		$classes[] = 'no-top-bar';
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