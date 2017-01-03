<?php get_template_part( 'header', 'top' ); ?> 
	<header id="global-header">
		<nav class="navbar navbar-default">
			<div class="container">

			    <!-- Brand and toggle get grouped for better mobile display -->
			    <div class="navbar-header">
					<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
						<span class="sr-only">Toggle navigation</span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
					<a class="navbar-brand" href="<?php echo get_home_url(); ?>">
						<img alt="Brand" width="20" height="20" src="<?php echo get_theme_mod('theme_customizer_logo') ?>">
					</a>
			    </div>
			    <?php
	                wp_nav_menu( array(
	                    'theme_location'    => 'primary',
	                    'depth'             => 0,
	                    'container'         => 'div',
	                    'container_class'   => 'collapse navbar-collapse',
	                    'container_id'   	=> 'bs-example-navbar-collapse-1',
	                    'menu_class'        => 'nav navbar-nav',
	                    'fallback_cb'       => 'wp_bootstrap_navwalker::fallback',
	                    'walker'            => new wp_bootstrap_navwalker())
	                );
			    ?>
			</div><!-- /.container -->
		</nav>
		<div class="container">
			<?php 
			if (function_exists('ameye_breadcrumbs')) {
				ameye_breadcrumbs(); 
			}
			?>
		</div>

	</header>
	<main class="global">
