<footer class="entry-footer">
	<?php if ( ! is_single() && 'post' === get_post_type() ) {
		get_template_part( 'components/post/content', 'meta' );
	} ?>
	<?php adler_entry_footer(); ?>
</footer><!-- .entry-footer -->
<?php if ( is_single() && 'post' === get_post_type() ) {
	adler_author_bio();
} ?>

<?php if ( ! is_single() && 'post' === get_post_type() ) {
	echo '<span class="leaf">' .
			adler_get_svg( array(
				'icon' => 'leaf',
			) ) .
		 '</span>';
} ?>
