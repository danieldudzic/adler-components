<?php
/**
 * Adler functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Adler
 */

if ( ! function_exists( 'adler_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function adler_setup() {
	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on components, use a find and replace
	 * to change 'adler' to the name of your theme in all the template files.
	 */
	load_theme_textdomain( 'adler', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support( 'title-tag' );

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
	 */
	add_theme_support( 'post-thumbnails' );

	add_image_size( 'adler-featured-image', 1200, 9999 );
	add_image_size( 'adler-entry-featured-background', 2000, 1500, true );

	// This theme uses wp_nav_menu() in two locations.
	register_nav_menus( array(
		'menu-1'	=> esc_html__( 'Header Menu', 'adler' ),
		'menu-2'	=> esc_html__( 'Footer Menu', 'adler' ),
	) );

	/**
	 * Add support for core custom logo.
	 */
	add_theme_support( 'custom-logo', array(
		'height'      => 100,
		'width'       => 600,
		'flex-width'  => true,
		'flex-height' => true,
		'header-text' => array( 'site-title', 'site-description' ),
	) );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form',
		'comment-form',
		'comment-list',
		'gallery',
		'caption',
	) );

	// Set up the WordPress core custom background feature.
	add_theme_support( 'custom-background', apply_filters( 'adler_custom_background_args', array(
		'default-color' => 'ffffff',
		'default-image' => '',
		'wp-head-callback' => 'adler_custom_background_cb',
	) ) );

	/*
	 * Enable WordPress core custom header support solely for "Display Site Title and Tagline" option.
	 * See inc/customizer.php for removal of the "Header Image" Customizer panel.
	 */
	add_theme_support( 'custom-header', array(
		'wp-head-callback' => 'adler_style_site_title_and_tagline',
	) );
}
endif;
add_action( 'after_setup_theme', 'adler_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function adler_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'adler_content_width', 600 );
}
add_action( 'after_setup_theme', 'adler_content_width', 0 );

/**
 * Add a wp-head callback to the custom background
 */
function adler_custom_background_cb() {
	$background_image = get_background_image();
	$color = get_background_color();

	if ( ! $background_image && ! $color ) {
		return;
	}
?>
	<style type="text/css" id="adler-custom-background-css">
	<?php if ( ! empty( $background_image ) ) { ?>

		body.custom-background {
			background-image: url(<?php echo esc_url( $background_image ); ?>);
		}

	<?php } elseif ( 'ffffff' != $color ) { ?>

		body.custom-background,
		.entry-wrapper .entry-main,
		.hfeed .hentry:nth-of-type(2n+1) .entry-main {
			background-color: #<?php echo esc_attr( $color ); ?>;
		}

		.hfeed .hentry:nth-of-type(2n) .entry-wrapper blockquote {
			background-image: -webkit-linear-gradient(#<?php echo esc_attr( $color ); ?> 70%, transparent 70%, transparent);
			background-image: linear-gradient(#<?php echo esc_attr( $color ); ?> 70%, transparent 70%, transparent);
		}

	<?php } ?>
	</style>
<?php
}

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function adler_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sliding Panel Widgets', 'adler' ),
		'id'            => 'sidebar-1',
		'description'   => '',
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
}
add_action( 'widgets_init', 'adler_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function adler_scripts() {
	wp_enqueue_style( 'adler-style', get_stylesheet_uri() );

	wp_enqueue_style( 'adler-fonts', adler_fonts_url(), array(), null );

	wp_enqueue_script( 'adler-main', get_template_directory_uri() . '/assets/js/main.js', array( 'jquery' ), '20120206', true );
	wp_localize_script( 'adler-main', 'menuToggleText', array(
		'open'   => esc_html__( 'Open Sub-menu', 'adler' ),
		'close'  => esc_html__( 'Close Sub-menu', 'adler' ),
		'showsubToggle' => adler_get_svg( array(
			'icon' => 'showsub-toggle',
		 ) ),
	) );

	wp_enqueue_script( 'adler-navigation', get_template_directory_uri() . '/assets/js/navigation.js', array(), '20151215', true );

	wp_enqueue_script( 'adler-skip-link-focus-fix', get_template_directory_uri() . '/assets/js/skip-link-focus-fix.js', array(), '20151215', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'adler_scripts' );

/**
 * Returns the Google font stylesheet URL, if available.
 */
function adler_fonts_url() {
	$fonts_url = '';

	/*
	 translators: If there are characters in your language that are not supported
	 * by Droid Serif, translate this to 'off'. Do not translate into your own language.
	 */
	$droid_serif = esc_html_x( 'on', 'Droid Serif font: on or off',	'adler' );

	/*
	 translators: If there are characters in your language that are not supported
	 * by Permanent Marker, translate this to 'off'. Do not translate into your own language.
	 */
	$permanent_marker = esc_html_x( 'on', 'Permanent Marker font: on or off', 'adler' );

	/*
	 translators: If there are characters in your language that are not supported
	 * by Droid Sans Mono, translate this to 'off'. Do not translate into your own language.
	 */
	$droid_sans_mono = esc_html_x( 'on', 'Droid Sans Mono font: on or off', 'adler' );

	if ( 'off' !== $droid_serif || 'off' !== $permanent_marker || 'off' !== $droid_sans_mono ) {
		$font_families = array();

		if ( 'off' !== $droid_serif ) {
			$font_families[] = 'Droid Serif:400,700,400italic,700italic';
		}
		if ( 'off' !== $permanent_marker ) {
			$font_families[] = 'Permanent Marker:400';
		}

		if ( 'off' !== $droid_sans_mono ) {
			$font_families[] = 'Droid Sans Mono:400';
		}

		$query_args = array(
			'family' => urlencode( implode( '|', $font_families ) ),
			'subset' => urlencode( 'latin,latin-ext' ),
		);
		$fonts_url = add_query_arg( $query_args, 'https://fonts.googleapis.com/css' );
	}

	return esc_url_raw( $fonts_url );
}

/**
 * Template for comments and pingbacks.
 *
 * Used as a callback by wp_list_comments() for displaying the comments.
 */
function adler_comment( $comment, $args, $depth ) {
	global $post;

	$tag = ( 'div' === $args['style'] ) ? 'div' : 'li';
?>
	<<?php echo $tag; ?> id="comment-<?php comment_ID(); ?>" <?php comment_class( $args['has_children'] ? 'parent' : '', $comment ); ?>>
		<article id="div-comment-<?php comment_ID(); ?>" class="comment-body">
			<footer class="comment-meta">
				<div class="comment-author vcard">
					<?php if ( 0 != $args['avatar_size'] ) {

						if ( $comment->user_id === $post->post_author ) {
							$author_string = '<span class="post-author">%1$s</span>';

							printf( $author_string,
								adler_get_svg( array(
									'icon' => 'author',
								) )
							);
						}

						echo get_avatar( $comment, $args['avatar_size'] );

					} ?>
					<?php
						/* translators: %s: comment author link */
						printf( __( '%s <span class="says">says:</span>', 'adler' ),
							sprintf( '<b class="fn">%s</b>', get_comment_author_link( $comment ) )
						);
					?>
				</div><!-- .comment-author -->

				<div class="comment-metadata">
					<a href="<?php echo esc_url( get_comment_link( $comment, $args ) ); ?>">
						<time datetime="<?php comment_time( 'c' ); ?>">
							<?php
								/* translators: 1: comment date, 2: comment time */
								printf( esc_html__( '%1$s at %2$s', 'adler' ), get_comment_date( '', $comment ), get_comment_time() );
							?>
						</time>
					</a>
					<?php edit_comment_link( esc_html__( 'Edit', 'adler' ), '<span class="edit-link">', '</span>' ); ?>
				</div><!-- .comment-metadata -->

				<?php if ( '0' == $comment->comment_approved ) : ?>
				<p class="comment-awaiting-moderation"><?php esc_html__e( 'Your comment is awaiting moderation.', 'adler' ); ?></p>
				<?php endif; ?>
			</footer><!-- .comment-meta -->

			<div class="comment-content">
				<?php comment_text(); ?>
			</div><!-- .comment-content -->

			<?php
			comment_reply_link( array_merge( $args, array(
				'add_below' => 'div-comment',
				'depth'     => $depth,
				'max_depth' => $args['max_depth'],
				'before'    => '<div class="reply">',
				'after'     => '</div>'
			) ) );
			?>
	</article><!-- .comment-body -->
	<?php
}

/**
 * Check if the current item is an Entry Featured Background item.
 */
function adler_is_entry_featured_background() {
	global $wp_query;
	if ( 0 === $wp_query->current_post && ! is_paged() && ! is_archive() && ! is_search() && adler_has_post_thumbnail() ) {
		return true;
	} else {
		return false;
	}
}

/**
 * Filter the excerpt more link in order to display a Continue Reading button.
 */
function adler_excerpt_more() {
	$read_more = sprintf(
		/* translators: %s: Name of current post. */
		wp_kses( __( 'Continue reading %s', 'adler' ), array(
			'span' => array(
				'class' => array(),
			),
		) ),
		the_title( '<span class="screen-reader-text">"', '"</span>', false )
	);

	return '...<div class="read-more"><a class="more-link" href="' . esc_url( get_permalink() ) . '">' . $read_more . '</a></div>';
}
add_filter( 'excerpt_more', 'adler_excerpt_more', 11 );

/**
 * Filter the content more link in order to display a Continue Reading button.
 */
function adler_content_more() {
	global $post;

	if ( has_excerpt() && strpos( $post->post_content, '<!--more-->' ) ) {
		return;
	} else {
		$read_more = sprintf(
			/* translators: %s: Name of current post. */
			wp_kses( __( 'Continue reading %s', 'adler' ), array(
				'span' => array(
					'class' => array(),
				),
			) ),
			the_title( '<span class="screen-reader-text">"', '"</span>', false )
		);

		return '<div class="read-more"><a class="more-link" href="' . esc_url( get_permalink() ) . '">' . $read_more . '</a></div>';
	}
}
add_filter( 'the_content_more_link', 'adler_content_more', 11 );

/**
 * Filter the excerpt in order to ensure correct display of the content and the display of the Continue Reading button.
 */
function adler_get_the_excerpt( $excerpt ) {
	global $post;

	if ( strpos( $post->post_content, '<!--more-->' ) ) {
		$excerpt = get_the_content();
	}

	if ( has_excerpt() ) {
		$read_more = sprintf(
			/* translators: %s: Name of current post. */
			wp_kses( __( 'Continue reading %s', 'adler' ), array(
				'span' => array(
					'class' => array(),
				),
			) ),
			the_title( '<span class="screen-reader-text">"', '"</span>', false )
		);

		$excerpt .= '<div class="read-more"><a class="more-link" href="' . esc_url( get_permalink() ) . '">' . $read_more . '</a></div>';
	}

	return $excerpt;
}
add_filter( 'get_the_excerpt', 'adler_get_the_excerpt', 11 );

/**
 * Display Excerpt instead of Content for the Entry Featured Background post.
 */
function adler_entry_featured_background_content_to_the_excerpt( $content ) {
	global $post;

	$display_option = adler_get_blog_display();

	if ( ! is_singular() && 'content' === $display_option ) {
		if ( adler_is_entry_featured_background() ) {
			if ( post_password_required() ) {
				$content = sprintf( '<p>%s</p>', esc_html__( 'There is no excerpt because this is a protected post.', 'adler' ) );
			} else {
				$content = jetpack_blog_display_custom_excerpt( $content );

				if ( has_excerpt() ) {
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
			}
		} else {
			if ( has_excerpt() && strpos( $post->post_content, '<!--more-->' ) ) {
				if ( ! is_customize_preview() ) {
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
			}
		}// End if().
	}// End if().

	return $content;
}

/**
 * Load the content flters and ensure correct display of the Entry Featured Background excerpt and Continue Reading button.
 */
function adler_filter_the_contents() {
	add_filter( 'the_excerpt', 'adler_entry_featured_background_content_to_the_excerpt', 11 );

	if ( adler_is_entry_featured_background() ) {
		add_filter( 'the_content', 'adler_entry_featured_background_content_to_the_excerpt', 11 );
	}
}

add_action( 'init', 'adler_filter_the_contents' );

/**
 * Style the Site Title and Tagline.
 */
function adler_style_site_title_and_tagline() {

	if ( display_header_text() ) {
		return;
	}

	?>
	<style type="text/css">
		.site-title,
		.site-description {
			position: absolute;
			clip: rect(1px, 1px, 1px, 1px);
		}
	</style>
	<?php
}

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
require get_template_directory() . '/inc/jetpack.php';

/**
 * SVG icons functions and filters.
 */
require get_template_directory() . '/inc/icon-functions.php';
