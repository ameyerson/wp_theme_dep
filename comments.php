<?php

/*
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
 */
if ( post_password_required() ) {
	return;
}
?>

<div class="container">
	<div id="comments" class="comments-area">

		<?php if ( have_comments() ) : ?>
			<h2 class="comments-title">
				<?php
					$comments_number = get_comments_number();
					if ( 1 === $comments_number ) {
						echo 'One thought on &ldquo;' . get_the_title() . '&rdquo;';
					} else {
						echo $comments_number . ' thoughts on &ldquo;' . get_the_title() . '&rdquo;';
					}
				?>
			</h2>

			<?php the_comments_navigation(); ?>

			<ol class="comment-list">
				<?php
					wp_list_comments( array(
						'style'       => 'ul',
					) );
				?>
			</ol><!-- .comment-list -->

			<?php the_comments_navigation(); ?>

		<?php endif; // Check for have_comments(). ?>

		<?php
			// If comments are closed and there are comments, let's leave a little note, shall we?
			if ( ! comments_open() && get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) :
		?>
			<p class="no-comments">Comments are closed.</p>
		<?php endif; ?>

		<?php
			comment_form( array(

				  'class_submit'      => 'btn btn-default',

				  'comment_field' =>  '<div class="form-group"><label for="comment">Comment</label><textarea id="comment" name="comment" class="form-control" cols="45" rows="8" aria-required="true"></textarea></div>',

				  'must_log_in' => '<p class="must-log-in">' .
				    sprintf(
				      __( 'You must be <a href="%s">logged in</a> to post a comment.' ),
				      wp_login_url( apply_filters( 'the_permalink', get_permalink() ) )
				    ) . '</p>',

				  'logged_in_as' => '<p class="help-block logged-in-as">' .
				    sprintf(
				    __( 'Logged in as <a href="%1$s">%2$s</a>. <a href="%3$s" title="Log out of this account">Log out?</a>' ),
				      admin_url( 'profile.php' ),
				      $user_identity,
				      wp_logout_url( apply_filters( 'the_permalink', get_permalink( ) ) )
				    ) . '</p>',

				  'comment_notes_before' => '<p class="help-block comment-notes">' .
				    __( 'Your email address will not be published.' ) . ( $req ? $required_text : '' ) .
				    '</p>',

				  'comment_notes_after' => '<p class="help-block form-allowed-tags">' .
				    sprintf(
				      __( 'You may use these <abbr title="HyperText Markup Language">HTML</abbr> tags and attributes: %s' ),
				      ' <code>' . allowed_tags() . '</code>'
				    ) . '</p>',
				)
			);
		?>

	</div><!-- .comments-area -->
</div>
