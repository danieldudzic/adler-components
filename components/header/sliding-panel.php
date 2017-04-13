<?php if ( is_active_sidebar( 'sidebar-1' ) || has_nav_menu( 'top' ) || has_nav_menu( 'social' ) ) : ?>
	<button class="menu-toggle animated" aria-expanded="false" >
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
		<span class="screen-reader-text"><?php esc_html_e( 'Toggle Menu', 'adler' ); ?></span>
	</button>
	<div class="slide-panel animated closed">
		<?php adler_social_menu(); ?>

		<?php if ( has_nav_menu( 'top' ) ) : ?>
			<nav id="site-navigation" class="main-navigation" role="navigation">
				<?php wp_nav_menu( array(
					'theme_location' => 'top',
				) ); ?>
			</nav>
		<?php endif; ?>

		<?php if ( is_active_sidebar( 'sidebar-1' ) ) {
			get_sidebar();
		} ?>
	</div>
<?php endif; ?>
