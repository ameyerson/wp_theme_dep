<?php get_header(); ?>
	<article class="page">
		<div class="container">
			<header class="page">
				<h1><?php the_title();?></h1>
			</header>
			<?php if ( have_posts() ) : ?>
				<?php while ( have_posts() ) : the_post(); ?>
					
						<?php the_content('Read More...'); ?>
						
				<?php endwhile; ?>
			<?php endif; ?>
		</div>
	</article>

<?php get_footer('sticky'); ?>