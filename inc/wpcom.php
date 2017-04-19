<?php
/**
 * WordPress.com-specific functions and definitions
 *
 * This file is centrally included from `wp-content/mu-plugins/wpcom-theme-compat.php`.
 *
 * @package Adler
 */

/**
 * Adds support for wp.com-specific theme functions.
 *
 * @global array $themecolors
 */
function adler_wpcom_setup() {
	global $themecolors;

	// Set theme colors for third party services.
	if ( ! isset( $themecolors ) ) {
		$themecolors = array(
			'bg'	 => 'ffffff',
			'border' => '68f3c8',
			'text'	 => '45525a',
			'link'	 => '0e364f',
			'url'	 => '0e364f',
		);
	}

	/* Add WP.com print styles */
	add_theme_support( 'print-style' );
}
add_action( 'after_setup_theme', 'adler_wpcom_setup' );
