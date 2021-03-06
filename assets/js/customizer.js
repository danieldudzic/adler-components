/**
 * File customizer.js.
 *
 * Theme Customizer enhancements for a better user experience.
 *
 * Contains handlers to make Theme Customizer preview reload changes asynchronously.
 */

( function( $ ) {

	// Site title and description.
	wp.customize( 'blogname', function( value ) {
		value.bind( function( to ) {
			$( '.site-title a' ).text( to );
		} );
	} );
	wp.customize( 'blogdescription', function( value ) {
		value.bind( function( to ) {
			$( '.site-description' ).text( to );
		} );
	} );

	// Site title and tagline display.
	wp.customize( 'header_textcolor', function( value ) {
		value.bind( function( to ) {
			if ( 'blank' === to ) {
				$( '.site-title, .site-description' ).css( {
					'clip': 'rect(1px, 1px, 1px, 1px)',
					'position': 'absolute'
				} );
				$( 'body' ).addClass( 'title-tagline-hidden' );
			} else {
				$( '.site-title, .site-description' ).css( {
					'clip': 'auto',
					'position': 'relative'
				} );
				$( 'body' ).removeClass( 'title-tagline-hidden' );
			}
		} );
	} );

	// Background color.
	wp.customize( 'background_color', function( value ) {
		value.bind( function( to ) {
			$( '.entry-wrapper .entry-main' ).css( {
					'background-color': to,
			} );
		} );
	} );

	// Entry Featured Background sticky label dash.
	wp.customize( 'jetpack_content_post_details_categories', function( value ) {
		value.bind( function( to ) {
			if ( false === to ) {
				$( '.entry-featured-background-wrapper .sticky-label' ).addClass( 'no-dash' );
			} else {
				$( '.entry-featured-background-wrapper .sticky-label' ).removeClass( 'no-dash' );
			}
		} );
	} );

} )( jQuery );
