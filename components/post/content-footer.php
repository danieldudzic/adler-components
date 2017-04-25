<?php if ( 'post' === get_post_type() ) : ?>

	<?php if ( ! is_single() ) { ?>

		<footer class="entry-footer">
			<div class="entry-meta">
				<?php adler_entry_meta(); ?>
				<?php adler_entry_footer(); ?>
			</div><!-- .entry-meta -->
		</footer><!-- .entry-footer -->

		<span class="leaf">
			<?php echo adler_get_svg( array(
				'icon' => 'leaf',
			) ); ?>
		</span><!-- .leaf -->

	<?php } else { ?>

		<?php if ( has_tag() || has_category() && ! has_category( 'uncategorized' ) ) : ?>

			<footer class="entry-footer">
				<div class="entry-meta">
					<?php adler_entry_footer(); ?>
				</div><!-- .entry-meta -->
			</footer><!-- .entry-footer -->

		<?php endif; ?>

		<?php adler_author_bio(); ?>

	<?php } ?>

<?php endif; ?>
