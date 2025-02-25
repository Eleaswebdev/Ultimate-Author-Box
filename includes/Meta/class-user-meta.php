<?php

class UAB_User_Meta {
	public function __construct() {
		add_action( 'show_user_profile', array( $this, 'uab_add_custom_user_profile_fields' ) );
		add_action( 'edit_user_profile', array( $this, 'uab_add_custom_user_profile_fields' ) );
	}

	function uab_add_custom_user_profile_fields( $user ) {
		$image = get_the_author_meta( 'uab_author_image', $user->ID );
		?>
		<h3>Profile Image(Ultimate Author Box)</h3>
		<table class="form-table">
			<tr>
				<th><label for="uab_author_image">Upload Profile Image</label></th>
				<td>
					<input type="hidden" id="uab_author_image" name="uab_author_image" value="<?php echo esc_url( $image ); ?>" />
					<div id="uab-image-preview">
						<?php if ( $image ) : ?>
							<img src="<?php echo esc_url( $image ); ?>" style="max-width: 150px; display: block;" />
						<?php endif; ?>
					</div>
					<input type="button" class="button button-secondary" id="uab-upload-button" value="Upload Image" />
					<input type="button" class="button button-secondary" id="uab-remove-button" value="Remove Image" style="<?php echo $image ? 'display:inline-block;' : 'display:none;'; ?>" />
				</td>
			</tr>
		</table>
		<?php
	}
}