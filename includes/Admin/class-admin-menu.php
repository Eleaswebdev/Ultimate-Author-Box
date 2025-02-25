<?php

class UAB_Admin_Menu {
	public function __construct() {
		add_action( 'admin_menu', array( $this, 'add_menu' ) );
	}

	public function add_menu() {
		add_menu_page(
			'Ultimate Author Box',
			'Author Box',
			'manage_options',
			'ultimate-author-box',
			array( $this, 'settings_page' ),
			'dashicons-admin-users',
			80
		);

		add_submenu_page(
			'ultimate-author-box',
			'Settings',
			'Settings',
			'manage_options',
			'ultimate-author-box',
			array( $this, 'settings_page' )
		);

		add_submenu_page(
			'ultimate-author-box',
			'Elements Style',
			'Elements Style',
			'manage_options',
			'uab-elements-style',
			array( $this, 'style_settings_page' )
		);
	}

	public function settings_page() {
		echo '<div class="wrap"><h1>Ultimate Author Box Settings</h1>';
		echo '<form method="post" action="options.php">';
		settings_fields( 'uab_settings_group' );
		do_settings_sections( 'ultimate-author-box' );
		submit_button();
		echo '</form></div>';
	}

	public function style_settings_page() {
		echo '<div class="wrap"><h1>Elements Style</h1>';
		echo '<form method="post" action="options.php">';
		settings_fields( 'uab_style_settings_group' );
		do_settings_sections( 'uab-elements-style' );
		submit_button();
		echo '</form></div>';
	}
}
