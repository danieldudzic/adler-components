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
		'render'	=> 'adler_infinite_scroll_render',
	) );

	// Add theme support for Responsive Videos.
	add_theme_support( 'jetpack-responsive-videos' );

	// Add theme support for Social Menus.
	add_theme_support( 'jetpack-social-menu', 'svg' );

		// Add theme support for Content Options.
	add_theme_support( 'jetpack-content-options', array(
		'blog-display'		 => 'excerpt',
		'author-bio'		 => true,
		'author-bio-default' => false,
		'post-details'	 => array(
			'stylesheet' => 'adler-style',
			'date'		 => '.posted-on',
			'categories' => '.cats-links',
			'tags'		 => '.tags-links',
			'author'	 => '.byline',
		),
		'featured-images' => array(
			'archive'	  => true,
			'post'		  => true,
			'page'		  => true,
			'fallback'	  => true,
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
 * Switch Infinite Scroll mode to "Click" if the footer menu is present
 */
function adler_has_footer_menu() {
	if ( has_nav_menu( 'menu-2' ) ) {
		return true;
	} else {
		return false;
	}
}
add_filter( 'infinite_scroll_has_footer_widgets', 'adler_has_footer_menu' );

/*
 * Only display social menu if function exists.
 */
function adler_social_menu() {
	if ( ! function_exists( 'jetpack_social_menu' ) ) {
		return;
	} else {
		jetpack_social_menu();
	}
}

/**
 * Load the author template if Author Bio is not available.
 */
function adler_author_bio() {
	if ( ! function_exists( 'jetpack_author_bio' ) ) {
		get_template_part( 'components/post/content', 'author' );
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
 * Get the Blog Display Content Options value.
 */
function adler_get_blog_display() {
	if ( function_exists( 'jetpack_blog_display_custom_excerpt' ) ) {
		$options 	  = get_theme_support( 'jetpack-content-options' );
		$blog_display = ( ! empty( $options[0]['blog-display'] ) ) ? $options[0]['blog-display'] : null;
		$blog_display = preg_grep( '/^(content|excerpt)$/', (array) $blog_display );
		sort( $blog_display );
		$blog_display = implode( ', ', $blog_display );
		$blog_display = ( 'content, excerpt' === $blog_display ) ? 'mixed' : $blog_display;
		$display_option = get_option( 'jetpack_content_blog_display', $blog_display );
	} else {
		$display_option = 'excerpt';
	}

	return $display_option;
}

/**
 * Check if the display of Post Categories is enabled.
 */
function adler_displays_categories() {
	if ( function_exists( 'jetpack_post_details_should_run' ) ) {
		$categories = get_option( 'jetpack_content_post_details_categories' );

		if ( empty( $categories ) ) {
			return false;
		} else {
			return true;
		}
	} else {
		return true;
	}
}

/**
 * Show/Hide Featured Image on .single if option is ticked.
 */
function adler_jetpack_featured_image_display() {
	if ( ! function_exists( 'jetpack_featured_images_remove_post_thumbnail' ) ) {
		return true;
	} else {
		$options		 = get_theme_support( 'jetpack-content-options' );
		$featured_images = ( ! empty( $options[0]['featured-images'] ) ) ? $options[0]['featured-images'] : null;

		$settings = array(
			'post-default' => ( isset( $featured_images['post-default'] ) && false === $featured_images['post-default'] ) ? '' : 1,
			'page-default' => ( isset( $featured_images['page-default'] ) && false === $featured_images['page-default'] ) ? '' : 1,
		);

		$settings = array_merge( $settings, array(
			'post-option'  => get_option( 'jetpack_content_featured_images_post', $settings['post-default'] ),
			'page-option'  => get_option( 'jetpack_content_featured_images_page', $settings['page-default'] ),
		) );

		if ( ( ! $settings['post-option'] && is_single() )
		|| ( ! $settings['page-option'] && is_singular() && is_page() ) ) {
			return false;
		} else {
			return true;
		}
	}
}

/**
 * Display a Featured Image on archive pages if option is ticked.
 */
function adler_jetpack_featured_image_archive_display() {
	if ( ! function_exists( 'jetpack_featured_images_remove_post_thumbnail' ) ) {
		return false;
	} else {
		$options		 = get_theme_support( 'jetpack-content-options' );
		$featured_images = ( ! empty( $options[0]['featured-images'] ) ) ? $options[0]['featured-images'] : null;

		$settings = array(
			'archive-default' => ( isset( $featured_images['archive-default'] ) && false === $featured_images['archive-default'] ) ? '' : 1,
		);

		$settings = array_merge( $settings, array(
			'archive-option'  => get_option( 'jetpack_content_featured_images_archive', $settings['archive-default'] ),
		) );

		if ( $settings['archive-option'] ) {
			return true;
		} else {
			return false;
		}
	}
}

/**
 * Check for fallback Featured Images.
 */
function adler_has_post_thumbnail( $post = null ) {
	if ( ! function_exists( 'jetpack_has_featured_image' ) ) {
		return has_post_thumbnail( $post );
	} else {
		return jetpack_has_featured_image( $post );
	}
}

/**
 * Get the fallback Featured Image URL.
 */
function adler_get_post_thumbnail_url( $size ) {
	if ( ! function_exists( 'jetpack_featured_images_fallback_get_image' ) || has_post_thumbnail() ) {
		return the_post_thumbnail_url( $size );
	} else {
		// This is a workaround until Jetpack will support the jetpack_featured_images_fallback_get_image_url() function.
		$fallback_image_html = jetpack_featured_images_fallback_get_image( '', get_the_ID(), '', $size, '' );
		$fallback_image_url = wp_extract_urls( $fallback_image_html );
		return $fallback_image_url[0];
	}
}
