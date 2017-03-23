<?php
/**
 * Adler Theme Customizer
 *
 * @package Adler
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function adler_customize_register( $wp_customize ) {
	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';
}
add_action( 'customize_register', 'adler_customize_register' );

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function adler_customize_preview_js() {
	wp_enqueue_script( 'adler_customizer', get_template_directory_uri() . '/assets/js/customizer.js', array( 'customize-preview' ), '20151215', true );
}
add_action( 'customize_preview_init', 'adler_customize_preview_js' );

/**
 * Prevent Hero post from displaying full content in the Customizer.
*/
function adler_the_excerpt_customizer( $excerpt ) {
	global $wp_query;

	if ( is_home() || is_archive() ) {
		ob_start();
		the_content();
		$content = ob_get_clean();
	}

	if ( 0 === $wp_query->current_post && has_post_thumbnail() ) {
		$content = $excerpt;

		$read_more = sprintf(
			/* translators: %s: Name of current post. */
			wp_kses( __( 'Continue reading %s', 'adler' ), array( 'span' => array( 'class' => array() ) ) ),
			the_title( '<span class="screen-reader-text">"', '"</span>', false )
		);
	}

	if ( empty( $content ) ) {
		return $excerpt;
	} else {
		return sprintf( '<div class="jetpack-blog-display jetpack-the-content">%s</div><div class="jetpack-blog-display jetpack-the-excerpt">%s</div>', $content, $excerpt );
	}
}

/**
 * Load the adler_the_excerpt_customizer in the Customizer.
*/
function adler_custom_content_display() {
	if ( function_exists( 'jetpack_blog_display_custom_excerpt' ) ) {
		$display_option = adler_get_blog_display();

		if ( 'excerpt' === $display_option ) {
			remove_filter( 'the_excerpt', 'jetpack_the_excerpt_customizer' );
			add_filter( 'the_excerpt', 'adler_the_excerpt_customizer' );
		}
	}
}

add_action( 'customize_preview_init', 'adler_custom_content_display' );