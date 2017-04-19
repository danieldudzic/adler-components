<footer class="entry-footer">
	<?php if ( ! is_single() && 'post' === get_post_type() ) : ?>

		<div class="entry-meta">
			<?php adler_posted_on(); ?>
		</div><!-- .entry-meta -->

	<?php endif; ?>

	<?php adler_entry_footer(); ?>
</footer><!-- .entry-footer -->

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
