<?php

class UAB_Database_Handler {
	public static function get_settings() {
		return get_option( 'uab_settings', array() );
	}

	public static function update_settings( $settings ) {
		update_option( 'uab_settings', $settings );
	}
}
