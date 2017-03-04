<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Adler
 */

?>
		<?php if ( is_active_sidebar( 'sidebar-2' ) ) : ?>
			<div class="full-width-widget-area widget-area">
				<?php dynamic_sidebar( 'sidebar-2' ); ?>
			</div>
		<?php endif; ?>
	</div><!-- #content -->
	<footer id="colophon" class="site-footer" role="contentinfo">
		<?php get_template_part( 'components/footer/site', 'info' ); ?>
		<?php get_template_part( 'components/footer/footer', 'navigation' ); ?>
	</footer>
</div>
<?php wp_footer(); ?>

</body>
</html>
