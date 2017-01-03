<?php

add_action( 'admin_init', 'social_options_init' );
add_action( 'admin_menu', 'social_options_add_page' );

/**
 * Init plugin options to white list our options
 */
function social_options_init(){
	register_setting( 'social_options', 'social_options_field', 'social_options_validate' );
}

/**
 * Load up the menu page
 */
function social_options_add_page() {
	add_menu_page( 'Social', 'Social', 'edit_theme_options', 'social_options', 'social_options_do_page','dashicons-share', '29.1');
}

/**
 * Create the options page
 */
function social_options_do_page() {

	if ( ! isset( $_REQUEST['settings-updated'] ) )
		$_REQUEST['settings-updated'] = false;

?>
	<div class="wrap">
		<h2>Social</h2>

		<?php if ( false !== $_REQUEST['settings-updated'] ) : ?>
		<div class="updated fade"><p><strong><?php echo 'Content saved'; ?></strong></p></div>
		<?php endif; ?>

		<form method="post" action="options.php">
			<?php settings_fields( 'social_options' ); ?>
			<?php $options = get_option( 'social_options_field' ); ?>

			<table class="form-table">
				<tr>
					<td>
						<label for="social_options_field[facebook_link]">Facebook</label>
					</td>
					<td>
						<input id="social_options_field[facebook_link]" class="regular-text" type="text" name="social_options_field[facebook_link]" value="<?php esc_attr_e( $options['facebook_link'] ); ?>" />
					</td>
				</tr>				
				<tr>
					<td>
						<label for="social_options_field[twitter_link]">Twitter</label>
					</td>
					<td>
						<input id="social_options_field[twitter_link]" class="regular-text" type="text" name="social_options_field[twitter_link]" value="<?php esc_attr_e( $options['twitter_link'] ); ?>" />
					</td>
				</tr>
				<tr>
					<td>
						<label for="social_options_field[instagram_link]">Instagram</label>
					</td>
					<td>
						<input id="social_options_field[instagram_link]" class="regular-text" type="text" name="social_options_field[instagram_link]" value="<?php esc_attr_e( $options['instagram_link'] ); ?>" />
					</td>
				</tr>
				<tr>
					<td>
						<label for="social_options_field[linkedin_link]">LinkedIn</label>
					</td>
					<td>
						<input id="social_options_field[linkedin_link]" class="regular-text" type="text" name="social_options_field[linkedin_link]" value="<?php esc_attr_e( $options['linkedin_link'] ); ?>" />
					</td>
				</tr>
			</table>

			<p class="submit">
				<input type="submit" class="button-primary" value="Save" />
			</p>
		</form>
	</div>
	<?php
}

/**
 * Sanitize and validate input. Accepts an array, return a sanitized array.
 */
function social_options_validate( $input ) {

	$input['facebook_link'] = wp_filter_nohtml_kses( $input['facebook_link'] );
	$input['twitter_link'] = wp_filter_nohtml_kses( $input['twitter_link'] );
	$input['instagram_link'] = wp_filter_nohtml_kses( $input['instagram_link'] );
	$input['linkedin_link'] = wp_filter_nohtml_kses( $input['linkedin_link'] );



	return $input;
}
/*****
call:
<?php
    $options = get_option('social_options_field');
    echo $options['facebook_link'];
?>
*****/

// adapted from http://planetozh.com/blog/2009/05/handling-plugins-options-in-wordpress-28-with-register_setting/