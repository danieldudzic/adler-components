<?php
/**
 * Jetpack Compatibility File
 *
 * @link https://jetpack.me/
 *
 * @package Adler
 */

/**
 * Jetpack setup function.
 *
 * See: https://jetpack.me/support/infinite-scroll/
 * See: https://jetpack.me/support/responsive-videos/
 */
function adler_jetpack_setup() {
	// Add theme support for Infinite Scroll.
	add_theme_support( 'infinite-scroll', array(
		'container' => 'main',
		'render'    => 'adler_infinite_scroll_render',
		'footer'    => 'page',
	) );

	// Add theme support for Responsive Videos.
	add_theme_support( 'jetpack-responsive-videos' );

	// Add theme support for Social Menus
	add_theme_support( 'jetpack-social-menu', 'svg' );

		//Add theme support for Content Options.
	add_theme_support( 'jetpack-content-options', array(
		'blog-display'       => 'excerpt',
		'author-bio'         => true,
		'author-bio-default' => false,
		'post-details'       => array(
			'stylesheet' => 'adler-style',
			'date'       => '.posted-on',
			'categories' => '.cat-links',
			'tags'       => '.tags-links',
			'author'     => '.byline',
		),
		'featured-images'    => array(
			'archive'    => true,
			'post'       => true,
			'page'       => true,
		),
	) );
}
add_action( 'after_setup_theme', 'adler_jetpack_setup' );

/**
 * Custom render function for Infinite Scroll.
 */
function adler_infinite_scroll_render() {
	while ( have_posts() ) {
		the_post();
		if ( is_search() ) :
			get_template_part( 'components/post/content', 'search' );
		else :
			get_template_part( 'components/post/content', get_post_format() );
		endif;
	}
}

/*
 * Only display social menu if function exists
 */
function adler_social_menu() {
	if ( ! function_exists( 'jetpack_social_menu' ) ) {
		return;
	} else {
		jetpack_social_menu();
	}
}

/**
 * Return early if Author Bio is not available.
 */
function adler_author_bio() {
	if ( ! function_exists( 'jetpack_author_bio' ) ) {
		return;
	} else {
		jetpack_author_bio();
	}
}

/**
 * Author Bio Avatar Size.
 */
function adler_author_bio_avatar_size() {
	return 80;
}
add_filter( 'jetpack_author_bio_avatar_size', 'adler_author_bio_avatar_size' );

/**
 * Display Excerpt instead of Content for the Hero post.
*/
function adler_hero_content_to_the_excerpt( $content ) {

	$options      = get_theme_support( 'jetpack-content-options' );
	$blog_display = ( ! empty( $options[0]['blog-display'] ) ) ? $options[0]['blog-display'] : null;
	$blog_display = preg_grep( '/^(content|excerpt)$/', (array) $blog_display );
	sort( $blog_display );
	$blog_display = implode( ', ', $blog_display );
	$blog_display = ( 'content, excerpt' === $blog_display ) ? 'mixed' : $blog_display;

	$display_option = get_option( 'jetpack_content_blog_display', $blog_display );

	if ( $display_option === 'content' ) {
		global $wp_query;

		if ( 0 === $wp_query->current_post && has_post_thumbnail() ) {
			if ( post_password_required() ) {
				$content = sprintf( '<p>%s</p>', esc_html__( 'There is no excerpt because this is a protected post.', 'adler' ) );
			} else {
				$content = jetpack_blog_display_custom_excerpt( $content );
			}
		}
	}

	return $content;
}
add_filter( 'the_content', 'adler_hero_content_to_the_excerpt', 11 );
add_filter( 'the_excerpt', 'adler_hero_content_to_the_excerpt', 11 );
remove_filter( 'the_content', 'jetpack_the_content_customizer', 11 );
