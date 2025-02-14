<?php

class UAB_Assets {
    public function __construct() {
        add_action('admin_enqueue_scripts', array($this, 'load_assets'));
        add_action('wp_enqueue_scripts', array($this, 'load_frontend_assets'));
    }

    // Load JavaScript & CSS
    public function load_assets($hook) {
        if ($hook !== 'toplevel_page_ultimate-author-box') return;

        wp_enqueue_style('wp-color-picker');
        wp_enqueue_script('uab-admin-script', UAB_PLUGIN_URL . '/assets/js/admin-script.js', ['wp-color-picker'], false, true);

    }

    public function load_frontend_assets() {

        wp_enqueue_style('ultimate-author-box', UAB_PLUGIN_URL . '/assets/css/style.css');

    }
}
