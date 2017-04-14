/**
 * Custom js for theme
 */

( function( $ ) {
	var $window   = $( window ),
		$document = $( document ),
		resizeTimer,
		toolbarHeight,
		slideMenu = $( '.slide-panel' ),
		body = $( 'body' ),
		htmlBody = $( 'html, body' ),
		actionText = $('.action-text'),
		menuToggle = $( '.menu-toggle' ),
		bodyWrapper  = $( '.body-wrapper' ),
		scrollIndicatorWrapper = $( '.scroll-indicator-wrapper' ),
		scrollIndicatorAnchor = $( '#scroll-indicator-anchor' ),
		siteMain = $( '.site-main' );

	/**
	* Full width feature images
	*
	* Makes full width images have a class.
	*/
	function bigImageClass() {
		$( '.entry-content img.size-full' ).each( function() {
			var img = $( this ),
			newImg = new Image();

			newImg.src = img.attr( 'src' );

			$( newImg ).load( function() {
				var imgWidth = newImg.width;

				if ( imgWidth >= 1080 ) {
					$( img ).addClass( 'size-big' );
				}
			} );
		} );
	}

	/**
	* Full screen size images: props to Resonar for solution
	*/
	function fullscreenFeaturedImage() {
		var entryHeaderHeight = $window.height();
		var windowWidth       = $window.width();
		var entryHeaderBackground = $( '.feature-header' );

		if ( ! entryHeaderBackground ) {
			return;
		}

		toolbarHeight = body.is( '.admin-bar' ) ? $( '#wpadminbar' ).height() : 0;

		entryHeaderBackground.css( {
			'height': entryHeaderHeight + 'px',
			'margin-top': '-' + toolbarHeight + 'px',
		} );
	}

	/**
	* Sliding panel
	*
	* Swaps classes for sliding panel so it uses CSS transformations.
	*/
	function slideControl() {
		menuToggle.on( 'click', function( e ) {
			e.preventDefault();
			var $this = $( this );

			var bodyWrapperHeight = function() {

				bodyWrapper.css( {
					'height': slideMenu.outerHeight() + 'px',
				} );
			};

			slideMenu.toggleClass( 'expanded' ).resize();
			body.toggleClass( 'slide-panel-open' );

			$this.toggleClass( 'toggle-on' );
			$this.attr( 'aria-expanded', $( this ).attr( 'aria-expanded' ) == 'false' ? 'true' : 'false');

			if ( slideMenu.hasClass( 'expanded' ) ) {
				actionText.text( 'hide' );
			} else {
				bodyWrapper.removeAttr('style');
				actionText.text( 'show' );
			}

			//Close slide menu with double click
			body.dblclick( function( e ) {
				e.preventDefault();
				slideMenu.removeClass( 'expanded' ).resize();
				$( this ).removeClass( 'slide-panel-open' );
				menuToggle.removeClass( 'toggle-on' );
			} );
		} );
	}

	/**
	* Count articles for the purpose of styling
	*/
	function countArticles() {

		// New posts have been added to the page.
		$( document.body ).on( 'post-load', function () {

			articleNumber = siteMain.children( '.hentry' ).size();

			if ( ! $( '#infinite-view-1' ).hasClass( 'odd' ) && ! $( '#infinite-view-1' ).hasClass( 'even' ) ) {
				// Count the initial articles.
				if ( articleNumber % 2 == 0 ) {
					$( '#infinite-view-1' ).addClass( 'odd' );

				} else {
					$( '#infinite-view-1' ).addClass( 'even' );
				}
			}

			$( '.infinite-wrap' ).each( function( i ) {

				if ( ! $( this ).hasClass( 'odd' ) && ! $( this ).hasClass( 'even' ) ) {

					if ( i % 2 == 0 ) {
						if ( articleNumber % 2 == 0 ) {
							$( this ).addClass( 'odd' );
						} else {
							$( this ).addClass( 'even' );
						}
					}
				}

				$( '.infinite-wrap' ).removeClass( 'last' );
				$( '.infinite-wrap' ).last().toggleClass( 'last' );
			});
		});
	}

	// Scroll down when the arrow is clicked.
	function heroScroll() {
		if ( ! $( '#scroll-indicator' ) ) {
			return;
		}

		$( '#scroll-indicator' ).on( 'click.adler', function() {
			scrollIndicatorWrapper.click( function() {
		        htmlBody.animate({
		            scrollTop: scrollIndicatorAnchor.offset().top
		        }, 500 );
		        return false;
			} );
		} );
	}

	/**
	* Navigation sub menu show and hide
	*
	* Show sub menus with an arrow click to work across all devices
	* This switches classes and changes the genericon.
	*/
	$( '.main-navigation .menu-item-has-children > a' ).after( '<button class="showsub-toggle" aria-expanded="false"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16"><rect x="0" fill="none" width="16" height="16"/><g><path d="M8 12.7L1.3 6l1.4-1.4L8 9.9l5.3-5.3L14.7 6"/></g></svg><span class="screen-reader-text">' + menuToggleText.open + '</span></button>' );

	$( '.main-navigation .page_item_has_children > li' ).append( '<button class="showsub-toggle" aria-expanded="false"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16"><rect x="0" fill="none" width="16" height="16"/><g><path d="M8 12.7L1.3 6l1.4-1.4L8 9.9l5.3-5.3L14.7 6"/></g></svg><span class="screen-reader-text">' + menuToggleText.open + '</span></button>' );

	$( '.main-navigation .current-menu-ancestor > a' ).addClass( 'sub-on' );
	$( '.main-navigation .current-menu-ancestor > button' ).addClass( 'sub-on' );
	$( '.main-navigation .current-menu-ancestor > .sub-menu' ).addClass( 'sub-on' );

	$( '.showsub-toggle' ).click( function( e ) {
			e.preventDefault();
			var $this = $( this );
			$this.toggleClass( 'sub-on' );
			$this.next( 'ul' ).toggleClass( 'sub-on' );
			$( 'span', $this ).text( $( 'span', $this ).text() == menuToggleText.open ? menuToggleText.close : menuToggleText.open );
			$this.parent().next( '.children, .sub-menu' ).toggleClass( 'sub-on' );
			$this.attr( 'aria-expanded', $this.attr( 'aria-expanded' ) == 'false' ? 'true' : 'false');
	} );

	// Add a class to change opacity of the arrow and to move the entry header.
	$( function() {
		if ( ! $( '#scroll-indicator' ) ) {
			return;
		}

		$window.on( 'scroll.adler', function() {
			if ( 0 < $window.scrollTop() ) {
				$( '#scroll-indicator' ).addClass ( 'scrolled' );
			} else {
				$( '#scroll-indicator' ).removeClass ( 'scrolled' );
			}
		} );
	} );

	/**
	* Close slide menu with escape key
	*
	* Adds in this functionality
	*/
	$document.keyup( function( e ) {
		if ( e.keyCode === 27 && slideMenu.hasClass( 'expanded' ) ) {
			body.removeClass( 'sidebar-open' );
			menuToggle.removeClass( 'toggle-on' );
			slideMenu.removeClass( 'expanded' ).resize();

			if( slideMenu.hasClass( 'expanded' ) ) {
				actionText.text( 'hide' );
			} else {
				actionText.text( 'show' );
			}
		}
	} );

	/**
	* Loader for all the theme functions
	*/
	$document.ready( function() {
		$window.on( 'resize.adler', function() {
			clearTimeout( resizeTimer );
			resizeTimer = setTimeout( function() {
				fullscreenFeaturedImage();
			}, 100 );
		} );

		countArticles();
		bigImageClass();
		slideControl();
		heroScroll();
	} );

} )( jQuery );
