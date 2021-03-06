/**
 * Custom js for theme
 */

( function( $ ) {
	var $window   = $( window ),
		$document = $( document ),
		resizeTimer,
		offsetTimer,
		slidingPanel = $( '.slide-panel' ),
		body = $( 'body' ),
		htmlBody = $( 'html, body' ),
		actionText = $( '.action-text' ),
		menuToggle = $( '.menu-toggle' ),
		bodyWrapper  = $( '.body-wrapper' ),
		scrollIndicatorWrapper = $( '.scroll-indicator-wrapper' ),
		scrollIndicatorAnchor = $( '#scroll-indicator-anchor' ),
		siteMain = $( '.site-main' );

	/**
	* Full width images
	*
	* Add a class to big images and captions >= 1088px.
	*/
	function bigImageClass() {
		$( '.entry-content img.size-full' ).each( function() {
			var img = $( this ),
			    caption = $( this ).closest( 'figure' ),
			    newImg = new Image();

			newImg.src = img.attr( 'src' );

			$( newImg ).load( function() {
				var imgWidth = newImg.width;

				if ( 1088 <= imgWidth ) {
					$( img ).addClass( 'size-big' );
				}

				if ( caption.hasClass( 'wp-caption' ) && 1088 <= imgWidth ) {
					caption.addClass( 'caption-big' );
					caption.removeAttr( 'style' );
				}
			} );
		} );
	}

	/**
	* Full screen size images: props to Resonar for solution
	*/
	function fullscreenFeaturedImage() {
		var entryHeaderHeight = $window.height();
		var entryHeaderBackground = $( '.entry-featured-background-wrapper' );

		if ( ! entryHeaderBackground ) {
			return;
		}

		entryHeaderBackground.css( {
			'height': entryHeaderHeight + 'px',
		} );
	}

	/**
	* Sliding panel control
	*
	* Swap classes for sliding panel so it uses CSS transformations.
	*/
	function slidingPanelControl() {
		menuToggle.on( 'click', function( e ) {
			e.preventDefault();
			var $this = $( this );

			slidingPanel.toggleClass( 'expanded' ).resize();
			body.toggleClass( 'slide-panel-open' );

			$this.toggleClass( 'toggle-on' );
			$this.attr( 'aria-expanded', $( this ).attr( 'aria-expanded' ) == 'false' ? 'true' : 'false' );

			if ( slidingPanel.hasClass( 'expanded' ) ) {
				actionText.text( 'hide' );
			} else {
				actionText.text( 'show' );
			}

			//Close slide menu with double click
			body.dblclick( function( e ) {
				e.preventDefault();
				slidingPanel.removeClass( 'expanded' ).resize();
				$( this ).removeClass( 'slide-panel-open' );
				menuToggle.removeClass( 'toggle-on' );
			} );

			slidingPanelHeight();
			resizeInfiniteScrollFooter();
		} );
	}

	/**
	* Sliding panel height
	*
	* Ensure the Sliding Panel always is as tall as the browser window.
	*/
	function slidingPanelHeight() {
		slidingPanel.each( function() {
			var bodyWrapperHeight		= bodyWrapper.height();
			var browserWindowHeight = $window.innerHeight();
			var browserWindowWidth	= $window.width();
			var slidingPanelHeight = 0;

			slidingPanel.children().each( function(){
				slidingPanelHeight = slidingPanelHeight + $( this ).outerHeight( true );
			});

			if ( 924 > browserWindowWidth ) {
				if ( $( this ).hasClass( 'expanded' ) ) {
					bodyWrapper.css( 'height', slidingPanelHeight );
				} else {
					bodyWrapper.css( 'height', 'auto' );
				}
			}

			if ( bodyWrapperHeight <= browserWindowHeight ) {
				bodyWrapper.css( 'height', browserWindowHeight );
				slidingPanel.css( 'height', browserWindowHeight );
			}
		} );
	}

	/**
	* Scroll down when the Entry Featured Background arrow is clicked
	*/
	function entryFeaturedBackgroundScroll() {
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
	* Make sure the Infinite Scroll footer matches the size of the page
	*/
	function resizeInfiniteScrollFooter() {
		var footerContainer = $( '#infinite-footer .container' );

		if ( ! footerContainer ) {
			return;
		}

		clearTimeout( offsetTimer );
		offsetTimer = setTimeout( function() {

			var site = $( '.site' );
			var pageWidth = $( '#page' ).width();
			var slidingPanelOffset = '0px';
			var slidingPanelOffsetDirection = '';

			footerContainer.css( 'margin-left', '0' );
			footerContainer.css( 'margin-right', '0' );
			footerContainer.css( 'width', pageWidth );

			if ( '0px' < site.css('left') ) {
				slidingPanelOffset = site.css('left');
				slidingPanelOffsetDirection = 'left';
			}

			if ( '0px' < site.css('right') ) {
				slidingPanelOffset = site.css('right');
				slidingPanelOffsetDirection = 'right';
			}

			if ( 'left' === slidingPanelOffsetDirection ) {
				footerContainer.css( 'margin-right', '-' + slidingPanelOffset );
			}

			if ( 'right' === slidingPanelOffsetDirection ) {
				footerContainer.css( 'margin-left','-' + slidingPanelOffset );
			}
		}, 500 );
	}

	/**
	* Navigation sub menu show and hide
	*
	* Show sub menus with an arrow click to work across all devices
	* This switches classes and changes the genericon.
	*/
	$( '.main-navigation .menu-item-has-children > a' ).after( '<button class="showsub-toggle" aria-expanded="false">' + menuToggleText.showsubToggle + '<span class="screen-reader-text">' + menuToggleText.open + '</span></button>' );
	$( '.main-navigation .page_item_has_children > li' ).append( '<button class="showsub-toggle" aria-expanded="false">' + menuToggleText.showsubToggle + '<span class="screen-reader-text">' + menuToggleText.open + '</span></button>' );

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
				$( '#scroll-indicator' ).addClass( 'scrolled' );
			} else {
				$( '#scroll-indicator' ).removeClass( 'scrolled' );
			}
		} );
	} );

	/**
	* Close slide menu with escape key
	*/
	$document.keyup( function( e ) {
		if ( e.keyCode === 27 && slidingPanel.hasClass( 'expanded' ) ) {
			body.removeClass( 'sidebar-open' );
			menuToggle.removeClass( 'toggle-on' );
			slidingPanel.removeClass( 'expanded' ).resize();

			if( slidingPanel.hasClass( 'expanded' ) ) {
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
				slidingPanelHeight();
				resizeInfiniteScrollFooter();
			}, 300 );
		} );

		bigImageClass();
		slidingPanelControl();
		slidingPanelHeight();
		entryFeaturedBackgroundScroll();
		resizeInfiniteScrollFooter();
		fullscreenFeaturedImage();
	} );

} )( jQuery );
