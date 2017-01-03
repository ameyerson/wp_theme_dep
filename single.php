<?php get_header(); ?>
	<div class="container">
		<header class="page">

			<h2><?php the_title();?></h2>

		</header>
		<div class="row">
			<div class="col-sm-9">
				<article class="page">

					<?php
					if ( has_post_thumbnail() ) {
					    $image_id = get_post_thumbnail_id();
					    $image_array = wp_get_attachment_image_src($image_id, 'full');
					    $image_url = $image_array[0];
					    $alt_text = get_post_meta($image_id, '_wp_attachment_image_alt', true);
					} else {
					    // $image_url = get_stylesheet_directory_uri() . '/assets/img/header-default.jpg';
					    $alt_text = get_bloginfo();
					}
					if ($image_url) {
					?>

						<img src="<?php echo $image_url ?>" class="" alt="<?php echo $alt_text ?>">
					<?php  } ?>
					<?php
					// Start the loop.
					while ( have_posts() ) : the_post();

						the_content('Read more...'); 

						wp_link_pages( array(
							'before'      => '<nav class="page-links"><span class="page-links-title">Pages: </span><ul class="pagination"><li>',
							'after'       => '</li></ul></nav>',
							'link_before' => '<span>',
							'link_after'  => '</span>',
							'separator'   => '</li><li>',
							'pagelink'    => '%',

						) );
					// End the loop.
					endwhile;
					?>


				</article>
			</div>
			<div class="col-sm-3">
				<?php get_sidebar(); ?>
			</div>

		</div>
		<aside>
		<?php
			// If comments are open or we have at least one comment, load up the comment template.
			if ( comments_open() || get_comments_number() ) {
				comments_template();
			}
		?>
		</aside>
		<?php
		// Previous/next post navigation.
			ameye_post_navigation();
		?>
	</div>

<?php get_footer('sticky'); ?>