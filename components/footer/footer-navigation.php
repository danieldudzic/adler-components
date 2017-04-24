<?php if ( has_nav_menu( 'menu-2' ) ) : ?>
	<nav id="footer-navigation" class="footer-navigation" role="navigation">
		<?php
		wp_nav_menu( array(
			'theme_location' => 'menu-2',
			'menu_id' => 'footer-menu',
		) );
		?>
	</nav>
<?php endif; ?>
