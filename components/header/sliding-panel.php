<?php if ( is_active_sidebar( 'sidebar-1' ) || has_nav_menu( 'menu-1' ) || has_nav_menu( 'social' ) ) : ?>

	<button class="menu-toggle animated" aria-expanded="false" >
		<span class="menu-toggle-label"><?php esc_html_e( 'Menu', 'adler' ); ?></span>

		<span class="menu-toggle-icon">
			<?php echo adler_get_svg( array(
				'icon' => 'menu-toggle',
			) ); ?>
		</span>

		<span class="menu-toggle-icon-close">
			<?php echo adler_get_svg( array(
				'icon' => 'menu-toggle-close',
			) ); ?>
		</span>
	</button>

	<div class="slide-panel animated closed">
		<?php adler_social_menu(); ?>

		<?php if ( has_nav_menu( 'menu-1' ) ) : ?>
			<nav id="site-navigation" class="main-navigation" role="navigation">
				<?php wp_nav_menu( array(
					'theme_location' => 'menu-1',
				) ); ?>
			</nav>
		<?php endif; ?>

		<?php get_sidebar(); ?>
	</div>

<?php endif; ?>
