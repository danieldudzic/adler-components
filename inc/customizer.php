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
	$wp_customize->get_setting( 'blogname' )->transport			= 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport	= 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';

	// Adler doesn't support a header image. No need to customize the header text color either.
	$wp_customize->remove_control( 'header_image' );
	$wp_customize->remove_control( 'header_textcolor' );
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
 * Filter the excerpt in the Customizer.
 */
function adler_the_excerpt_customizer( $excerpt ) {
	global $post;

	if ( is_home() || is_archive() ) {
		ob_start();
		the_content();
		$content = ob_get_clean();
	}

	if ( adler_is_entry_featured_background() ) {
		$content = $excerpt;
	}

	if ( ! adler_is_entry_featured_background() && has_excerpt() && strpos( $post->post_content, '<!--more-->' ) ) {
		$read_more = sprintf(
			/* translators: %s: Name of current post. */
			wp_kses( __( 'Continue reading %s', 'adler' ), array(
				'span' => array(
					'class' => array(),
				),
			) ),
			the_title( '<span class="screen-reader-text">"', '"</span>', false )
		);

		$content .= '<div class="read-more"><a class="more-link" href="' . esc_url( get_permalink() ) . '">' . $read_more . '</a></div>';
	}

	if ( empty( $content ) ) {
		return $excerpt;
	} else {
		return sprintf( '<div class="jetpack-blog-display jetpack-the-content">%1$s</div><div class="jetpack-blog-display jetpack-the-excerpt">%2$s</div>', $content, $excerpt );
	}
}

/**
 * Filter the content in the Customizer.
 */
function adler_the_content_customizer( $content ) {
	global $post;

	$class = jetpack_the_content_customizer_class();

	if ( is_home() || is_archive() ) {
		if ( post_password_required() ) {
			$excerpt = sprintf( '<p>%s</p>', esc_html__( 'There is no excerpt because this is a protected post.', 'adler' ) );
		} else {
			$excerpt = jetpack_blog_display_custom_excerpt( $content );
		}
	}

	if ( has_excerpt() && strpos( $post->post_content, '<!--more-->' ) ) {
		$read_more = sprintf(
			/* translators: %s: Name of current post. */
			wp_kses( __( 'Continue reading %s', 'adler' ), array(
				'span' => array(
					'class' => array(),
				),
			) ),
			the_title( '<span class="screen-reader-text">"', '"</span>', false )
		);

		$content .= '<div class="read-more"><a class="more-link" href="' . esc_url( get_permalink() ) . '">' . $read_more . '</a></div>';
	}

	if ( empty( $excerpt ) ) {
		return $content;
	} else {
		return sprintf( '<div class="jetpack-blog-display %1$s jetpack-the-content">%2$s</div><div class="jetpack-blog-display %3$s jetpack-the-excerpt">%4$s</div>', $class, $content, $class, $excerpt );
	}
}

/**
 * Load the adler_the_excerpt_customizer in the Customizer.
 */
function adler_custom_content_display() {
	if ( function_exists( 'jetpack_blog_display_custom_excerpt' ) ) {
		$display_option = adler_get_blog_display();

		if ( 'excerpt' === $display_option ) {
			add_filter( 'the_excerpt', 'adler_the_excerpt_customizer' );
			remove_filter( 'the_excerpt', 'jetpack_the_excerpt_customizer' );
		}

		if ( 'content' === $display_option ) {
			add_filter( 'the_content', 'adler_the_content_customizer' );
			remove_filter( 'the_content', 'jetpack_the_content_customizer' );
		}
	}
}

add_action( 'customize_preview_init', 'adler_custom_content_display' );
