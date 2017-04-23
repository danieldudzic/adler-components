<?php if ( ! is_single() && 'post' === get_post_type() ) : ?>

	<footer class="entry-footer">
		<div class="entry-meta">
			<?php adler_entry_meta(); ?>
			<?php adler_entry_footer(); ?>
		</div><!-- .entry-meta -->
	</footer><!-- .entry-footer -->

<?php endif; ?>

<?php if ( is_single() && 'post' === get_post_type() ) {
	adler_author_bio();
} ?>

<?php if ( ! is_single() && 'post' === get_post_type() ) : ?>

	<span class="leaf">
		<?php echo adler_get_svg( array(
			'icon' => 'leaf',
		) ); ?>
	</span><!-- .leaf -->

<?php endif; ?>
