<?php get_header(); ?>

		<?php if ( have_posts() ) : ?>

			<header class="page">
				<div class="container">
					<h1><?php printf( __( 'Search Results for: %s', 'ameye-theme' ), get_search_query() ); ?></h1>
				</div>
			</header><!-- .page-header -->

			<?php
			// Start the loop.
			while ( have_posts() ) : the_post();

				get_template_part('content', 'entry');

			endwhile;

			// Previous/next page navigation.
			// ameye_pagination( );
			the_posts_pagination();

		else :
			get_template_part( 'content', 'none' );

		endif;
		?>


<?php get_footer(); ?>