				<article id="post-<?php the_ID(); ?>" <?php post_class('entry'); ?>>
					<div class="container">
						<header class="entry">
							<h2><a href="<?php the_permalink() ?>" rel="bookmark"><?php the_title() ?></a></h2>
						</header>

						<div class="entry-summary">
							<?php the_excerpt(); ?>
						</div>

						<?php if ( 'post' == get_post_type() ) { ?>

							<footer class="entry-footer">
								<?php ameye_post_meta(); ?>
							</footer><!-- .entry-footer -->

						<?php } ?>
					</div>
				</article><!-- #post-## -->