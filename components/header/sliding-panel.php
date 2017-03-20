		<?php if ( is_active_sidebar( 'sidebar-1' ) || has_nav_menu( 'top' ) || has_nav_menu( 'social' ) ) : ?>
			<button class="menu-toggle animated" aria-expanded="false" ><span class="menu-toggle-icon"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16"><rect x="0" fill="none" width="16" height="16"/><g><path d="M0 14h16v-2H0v2zM0 2v2h16V2H0zm0 7h16V7H0v2z"/></g></svg></span><span class="menu-toggle-icon-close"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16"><rect x="0" fill="none" width="16" height="16"/><g><path d="M14.7 2.7l-1.4-1.4L8 6.6 2.7 1.3 1.3 2.7 6.6 8l-5.3 5.3 1.4 1.4L8 9.4l5.3 5.3 1.4-1.4L9.4 8"/></g></svg></span><span class="screen-reader-text"><?php esc_html_e( 'Show', 'adler' ); ?></span></button>
			<div class="slide-panel animated closed">
				<?php adler_social_menu(); ?>

				<?php if ( has_nav_menu( 'top' ) ) : ?>
					<nav id="site-navigation" class="main-navigation" role="navigation">
						<?php wp_nav_menu( array( 'theme_location' => 'top' ) ); ?>
					</nav>
				<?php endif; ?>

				<?php if ( is_active_sidebar( 'sidebar-1' ) ) {
					get_sidebar();
				} ?>
			</div>
		<?php endif; ?>