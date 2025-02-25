<?php

class UAB_Activator {
	public static function activate() {
		// Set default settings
		if ( ! get_option( 'uab_settings' ) ) {
			$default_settings = array(
				'enable_author_box' => 1,
				'show_social_links' => 1,
				'background_color'  => '#f9f9f9',
			);
			update_option( 'uab_settings', $default_settings );
		}
	}
}
