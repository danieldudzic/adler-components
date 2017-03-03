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
		menuToggle = $( '.menu-toggle' );
		scrollIndicatorWrapper = $( '.scroll-indicator-wrapper' );
		scrollIndicatorAnchor = $( '#scroll-indicator-anchor' );
		

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
	* Sliding panel
	*
	* Swaps classes for sliding panel so it uses CSS transformations.
	*/
	function slideControl() {
		menuToggle.on( 'click', function( e ) {
			e.preventDefault();
			var $this = $( this );

			slideMenu.toggleClass( 'expanded' ).resize();
			body.toggleClass( 'sidebar-open' );

			$this.toggleClass( 'toggle-on' );
			$this.attr( 'aria-expanded', $( this ).attr( 'aria-expanded' ) == 'false' ? 'true' : 'false');

			if( slideMenu.hasClass( 'expanded' ) ) {
							actionText.text( 'hide' );
					} else {
						actionText.text( 'show' );
					}

			//Close slide menu with double click
			body.dblclick( function( e ) {
				e.preventDefault();
				slideMenu.removeClass( 'expanded' ).resize();
				$( this ).removeClass( 'sidebar-open' );
				menuToggle.removeClass( 'toggle-on' );
			} );
		} );
	}
	
	
		/**
	* Navigation sub menu show and hide
	*
	* Show sub menus with an arrow click to work across all devices
	* This switches classes and changes the genericon.
	*/
	$( '.main-navigation .menu-item-has-children > a' ).after( '<button class="showsub-toggle" aria-expanded="false"><span class="screen-reader-text">' + menuToggleText.open + '</span></button>' );
	
	$( '.main-navigation .page_item_has_children > li' ).append( '<button class="showsub-toggle" aria-expanded="false"><span class="screen-reader-text">' + menuToggleText.open + '</span></button>' );
	
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
	
	// Scroll down when the arrow is clicked.
	function scroll() {
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
		bigImageClass();
		slideControl();
		scroll();
	} );
	
	
	/**
	* Adler js
	*/

    /* Search */
    $(".nav__item--search").click(function(){
        $(".overlay--search").fadeIn("fast");

    });
    $(".overlay__close").click(function() {
        $(".overlay--search").fadeOut("fast");
    });

    $(".menu-toggle").click(function() {
        $(".toolbar, .logo").toggle().css("z-index","1");
        $(".main-menu-container").toggleClass("padding--fix");
    });



} )( jQuery );