<?php

class UAB_Assets {
	public function __construct() {
		add_action( 'admin_enqueue_scripts', array( $this, 'load_assets' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'load_frontend_assets' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'load_dynamic_css' ) );
	}

	// Load JavaScript & CSS
	public function load_assets( $hook ) {
		if ( $hook === 'toplevel_page_ultimate-author-box' || $hook === 'author-box_page_uab-elements-style' || $hook === 'profile.php' ) {
			wp_enqueue_media();
			wp_enqueue_style( 'wp-color-picker' );
			wp_enqueue_script( 'uab-admin-script', UAB_PLUGIN_URL . '/assets/js/admin-script.js', array( 'wp-color-picker' ), false, true );
		}
	}

	public function load_frontend_assets() {

		wp_enqueue_style( 'ultimate-author-box', UAB_PLUGIN_URL . 'assets/css/style.css' );
		wp_enqueue_style( 'font-awesome-css', UAB_PLUGIN_URL . 'assets/css/font-awesome.min.css' );
		// wp_enqueue_style('custom-cdn-style', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css', array(), null, 'all');
	}

	public function load_dynamic_css() {
		$options      = get_option( 'uab_style_settings', array() );
		$bg_color     = isset( $options['background_color'] ) ? 'background-color:' . esc_attr( $options['background_color'] ) . ';' : '#f9f9f9';
		$border_color = isset( $options['border_color'] ) ? 'border: 1px solid ' . esc_attr( $options['border_color'] ) . ';' : '#ccc';
		$image_width  = isset( $options['author_image_width'] ) ? 'max-width:' . esc_attr( $options['author_image_width'] ) . 'px;' : '100px';

		$dynamic_css = "
        .uab-author-box {
            {$bg_color}
            {$border_color}
        }
        .uab-avatar img {
            {$image_width}
        }
        ";

		wp_add_inline_style( 'ultimate-author-box', $dynamic_css );
	}
}
