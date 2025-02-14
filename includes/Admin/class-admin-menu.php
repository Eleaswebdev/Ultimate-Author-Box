<?php

class UAB_Admin_Menu {
    public function __construct() {
        add_action('admin_menu', [$this, 'add_menu']);
    }

    public function add_menu() {
        add_menu_page(
            'Ultimate Author Box',
            'Author Box',
            'manage_options',
            'ultimate-author-box',
            [$this, 'settings_page'],
            'dashicons-admin-users',
            80
        );
    }

    public function settings_page() {
        echo '<div class="wrap"><h1>Ultimate Author Box Settings</h1>';
        echo '<form method="post" action="options.php">';
        settings_fields('uab_settings_group');
        do_settings_sections('ultimate-author-box');
        submit_button();
        echo '</form></div>';
    }
}
