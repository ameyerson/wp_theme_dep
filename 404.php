<?php

get_header(); ?>

		<header class="page">
			<div class="container">
				<h1><?php _e( 'Oops! That page can&rsquo;t be found.', 'ameye-theme' ); ?></h1>
			</div>
		</header>
		<article class="error-404 page not-found">
			<div class="container">
				<p><?php _e( 'It looks like nothing was found at this location. Maybe try a search?', 'ameye-theme' ); ?></p>

				<?php get_search_form(); ?>
			</div>
		</article>


<?php get_footer(); ?>
